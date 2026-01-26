<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    private $collegeMap = [
        'College of Arts and Sciences' => 'CAS',
        'College of Veterinary Medicine' => 'CVM',
        'College of Forestry and Environmental Sciences' => 'CFES',
        'College of Business and Management' => 'CBM',
        'College of Nursing' => 'CON',
        'College of Human Ecology' => 'CHE',
        'College of Agriculture' => 'COA',
        'College of Information Sciences and Computing' => 'CISC',
        'College of Education' => 'COED',
        'College of Engineering' => 'COE'
    ];

    private function getAcronym($name)
    {
        return $this->collegeMap[$name] ?? ($name ?: 'Unspecified');
    }

    public function index(Request $request)
    {
        $data = $this->getAnalyticsData($request);
        return view('admin.analytics.index', $data);
    }

    public function export(Request $request)
    {
        $data = $this->getAnalyticsData($request);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.analytics.export_pdf', $data);
        $pdf->setPaper('a4', 'landscape');

        $filename = 'analytics_report_' . $data['startDate']->format('Ymd') . '_' . $data['endDate']->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    private function getAnalyticsData(Request $request)
    {
        // 1. Filtering Logic
        $startDate = $request->get('start_date') ? \Carbon\Carbon::parse($request->get('start_date')) : now()->subMonths(6)->startOfMonth();
        $endDate = $request->get('end_date') ? \Carbon\Carbon::parse($request->get('end_date')) : now()->endOfYear();

        if ($request->get('month') && $request->get('year')) {
            $startDate = \Carbon\Carbon::createFromDate($request->get('year'), $request->get('month'), 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        } elseif ($request->get('year')) {
            $startDate = \Carbon\Carbon::createFromDate($request->get('year'), 1, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfYear();
        }

        // Student Filters
        $studentFilters = function ($query) use ($request) {
            if ($request->filled('student_id')) {
                $query->where('id_number', 'like', '%' . $request->student_id . '%');
            }
            if ($request->filled('college')) {
                $query->where('college', $request->college);
            }
            if ($request->filled('program')) {
                $query->where('course', $request->program);
            }
            if ($request->filled('year_level')) {
                $query->where('year_level', $request->year_level);
            }
            if ($request->filled('gender')) {
                $query->where('sex', $request->gender);
            }
            if ($request->filled('status')) {
                if ($request->status == 'active')
                    $query->where('is_active', true);
                if ($request->status == 'inactive')
                    $query->where('is_active', false);
            }
        };

        // Helper to apply date and student filters to relation-based queries
        $commonFilter = function ($query, $dateColumn, $userRelation = 'user') use ($startDate, $endDate, $studentFilters) {
            $query->whereBetween($dateColumn, [$startDate, $endDate]);
            if ($userRelation) {
                $query->whereHas($userRelation, $studentFilters);
            }
        };

        // 2. PILLAR 1: Operational Excellence
        // Case Load by Nature of Problem
        $problemDistribution = \App\Models\Appointment::tap(fn($q) => $commonFilter($q, 'appointments.created_at', 'student'))
            ->selectRaw("nature_of_problem, count(*) as count")
            ->groupBy('nature_of_problem')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'nature_of_problem');

        // Referral Sources
        $referralDistribution = \App\Models\Appointment::tap(fn($q) => $commonFilter($q, 'appointments.created_at', 'student'))
            ->selectRaw("appointment_type, count(*) as count")
            ->groupBy('appointment_type')
            ->get()
            ->pluck('count', 'appointment_type');

        // Wait Time Logic
        $completedAppointments = \App\Models\Appointment::where('status', 'completed')
            ->tap(fn($q) => $commonFilter($q, 'appointments.created_at', 'student'))
            ->get();
        $avgWaitTime = $completedAppointments->count() > 0
            ? $completedAppointments->avg(fn($a) => $a->created_at->diffInDays($a->scheduled_at))
            : 0;

        // 3. PILLAR 2: Mental Health & Wellness
        // Risk Level Distribution
        $riskDistribution = \App\Models\Assessment::tap(fn($q) => $commonFilter($q, 'assessments.created_at', 'user'))
            ->selectRaw("risk_level, count(*) as count")
            ->groupBy('risk_level')
            ->get()
            ->pluck('count', 'risk_level');

        // Campus Mood Trend
        $moodTrend = \App\Models\Assessment::where('type', 'DASS-42')
            ->tap(fn($q) => $commonFilter($q, 'assessments.created_at', 'user'))
            ->get()
            ->groupBy(function ($a) {
                return $a->created_at->format('Y-m');
            })
            ->map(function ($group) {
                return $group->avg(function ($a) {
                    $s = is_array($a->score) ? $a->score : json_decode($a->score, true);
                    return (($s['depression'] ?? 0) + ($s['anxiety'] ?? 0) + ($s['stress'] ?? 0)) / 3;
                });
            })
            ->sortKeys();

        // Continuity of Care (Retention Rate)
        $sessionCounts = \App\Models\Appointment::tap(fn($q) => $commonFilter($q, 'appointments.created_at', 'student'))
            ->whereIn('status', ['completed', 'accepted'])
            ->selectRaw('student_id, COUNT(*) as count')
            ->groupBy('student_id')
            ->get();
        $retentionRate = $sessionCounts->count() > 0
            ? ($sessionCounts->where('count', '>', 1)->count() / $sessionCounts->count()) * 100
            : 0;

        // 4. PILLAR 3: Demographic Vulnerability & NEW REPORTS

        // High Risk by College
        $collegeRiskMap = \App\Models\Assessment::join('users', 'assessments.user_id', '=', 'users.id')
            ->tap(fn($q) => $commonFilter($q, 'assessments.created_at', null))
            ->whereHas('user', $studentFilters)
            ->whereIn('risk_level', ['high', 'very-high', 'severe', 'extremely severe'])
            ->selectRaw("users.college, count(*) as count")
            ->groupBy('users.college')
            ->get()
            ->pluck('count', 'college');

        // NEW: High-risk groups by program
        $programRiskMap = \App\Models\Assessment::join('users', 'assessments.user_id', '=', 'users.id')
            ->whereBetween('assessments.created_at', [$startDate, $endDate])
            ->whereHas('user', $studentFilters)
            ->whereIn('risk_level', ['high', 'very-high', 'severe', 'extremely severe'])
            ->selectRaw("users.course as program, count(*) as count")
            ->groupBy('users.course')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->pluck('count', 'program');

        // Year Level Risk Profile
        $yearLevelRisk = \App\Models\Assessment::join('users', 'assessments.user_id', '=', 'users.id')
            ->whereBetween('assessments.created_at', [$startDate, $endDate])
            ->whereHas('user', $studentFilters)
            ->selectRaw("users.year_level, assessments.risk_level, count(*) as count")
            ->groupBy('users.year_level', 'assessments.risk_level')
            ->get();

        // NEW: Counseling usage by year level / college
        $counselingUsage = \App\Models\Appointment::join('users', 'appointments.student_id', '=', 'users.id')
            ->whereBetween('appointments.created_at', [$startDate, $endDate])
            ->whereHas('student', $studentFilters)
            ->selectRaw("users.college, users.year_level, count(*) as count")
            ->groupBy('users.college', 'users.year_level')
            ->get()
            ->groupBy('college')
            ->map(function ($group) {
                return $group->pluck('count', 'year_level');
            });

        // NEW: Trend of counseling demand
        $counselingTrend = \App\Models\Appointment::whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('student', $studentFilters)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as date, count(*) as count")
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');


        // 5. PILLAR 4: Outreach & Impact
        // Seminar Attendance
        $seminarAttendance = \App\Models\SeminarAttendance::whereBetween('seminar_attendances.created_at', [$startDate, $endDate])
            ->whereHas('user', $studentFilters)
            ->join('seminar_schedules', 'seminar_attendances.seminar_schedule_id', '=', 'seminar_schedules.id')
            ->join('seminars', 'seminar_schedules.seminar_id', '=', 'seminars.id')
            ->selectRaw("seminars.name, count(*) as count")
            ->groupBy('seminars.name')
            ->get()
            ->pluck('count', 'seminars.name');

        // Sentiment
        $sentimentScore = \App\Models\SessionFeedback::join('appointments', 'session_feedback.appointment_id', '=', 'appointments.id')
            ->tap(fn($q) => $commonFilter($q, 'session_feedback.created_at', 'appointment.student'))
            ->avg('rating') ?: 0;

        // 6. SCALAR KPIs
        $totalAppointments = \App\Models\Appointment::tap(fn($q) => $commonFilter($q, 'appointments.created_at', 'student'))->count();

        $criticalRiskCount = \App\Models\Assessment::tap(fn($q) => $commonFilter($q, 'assessments.created_at', 'user'))
            ->whereIn('risk_level', ['high', 'very-high', 'severe', 'extremely severe'])
            ->count();

        $totalSeminarReach = \App\Models\SeminarAttendance::whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('user', $studentFilters)
            ->count();

        $pendingAppointments = \App\Models\Appointment::where('status', 'pending')
            ->tap(fn($q) => $commonFilter($q, 'appointments.created_at', 'student'))
            ->count();

        $totalSeminars = \App\Models\Seminar::count();

        $appointmentStatus = \App\Models\Appointment::tap(fn($q) => $commonFilter($q, 'appointments.created_at', 'student'))
            ->selectRaw("status, count(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $cancellationRate = $totalAppointments > 0
            ? (($appointmentStatus['cancelled'] ?? 0) / $totalAppointments) * 100
            : 0;

        // Peak Demand Heatmap
        $peakDemand = \App\Models\Appointment::tap(fn($q) => $commonFilter($q, 'appointments.scheduled_at', 'student'))
            ->whereNotNull('scheduled_at')
            ->selectRaw("DAYOFWEEK(scheduled_at) as day, HOUR(scheduled_at) as hour, count(*) as count")
            ->groupBy('day', 'hour')
            ->get();

        // 7. Demographics
        $msg_demographics = function ($col) use ($startDate, $endDate, $studentFilters) {
            return \App\Models\User::where('role', 'student')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->tap(function ($q) use ($studentFilters) {
                    $studentFilters($q);
                })
                ->selectRaw("$col as label, count(*) as count")
                ->groupBy('label')
                ->pluck('count', 'label');
        };

        $demographics = [
            'sex' => $msg_demographics('sex'),
            'year_level' => $msg_demographics('year_level'),
            'college' => $msg_demographics('college'),
        ];

        // 8. Qualitative Feedback
        $feedbackDistribution = \App\Models\SessionFeedback::join('appointments', 'session_feedback.appointment_id', '=', 'appointments.id')
            ->tap(fn($q) => $commonFilter($q, 'session_feedback.created_at', 'appointment.student'))
            ->selectRaw("rating, count(*) as count")
            ->groupBy('rating')
            ->orderByDesc('rating')
            ->get()
            ->pluck('count', 'rating');

        $recentFeedback = \App\Models\SessionFeedback::join('appointments', 'session_feedback.appointment_id', '=', 'appointments.id')
            ->tap(fn($q) => $commonFilter($q, 'session_feedback.created_at', 'appointment.student'))
            ->with(['appointment.student'])
            ->whereNotNull('comments')
            ->latest('session_feedback.created_at')
            ->limit(5)
            ->get();


        // Transform College Labels to Acronyms
        $collegeRiskMap = $collegeRiskMap->mapWithKeys(fn($v, $k) => [$this->getAcronym($k) => $v]);
        $counselingUsage = $counselingUsage->mapWithKeys(fn($v, $k) => [$this->getAcronym($k) => $v]);
        $demographics['college'] = $demographics['college']->mapWithKeys(fn($v, $k) => [$this->getAcronym($k) => $v]);

        // Lists for Filter Dropdowns
        $colleges = \App\Models\User::whereNotNull('college')->distinct()->pluck('college')->sort()->values();
        $programs = \App\Models\User::whereNotNull('course')->distinct()->pluck('course')->sort()->values();

        return compact(
            'startDate',
            'endDate',
            'problemDistribution',
            'referralDistribution',
            'avgWaitTime',
            'riskDistribution',
            'moodTrend',
            'retentionRate',
            'collegeRiskMap',
            'programRiskMap',
            'yearLevelRisk',
            'counselingUsage',
            'counselingTrend',
            'seminarAttendance',
            'sentimentScore',
            'demographics',
            'colleges',
            'programs',
            'totalAppointments',
            'criticalRiskCount',
            'totalSeminarReach',
            'appointmentStatus',
            'totalSeminars',
            'pendingAppointments',
            'cancellationRate',
            'peakDemand',
            'feedbackDistribution',
            'recentFeedback'
        );
    }
}
