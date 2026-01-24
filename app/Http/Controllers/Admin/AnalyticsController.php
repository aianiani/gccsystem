<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 1. Demographics
        // 1. Demographics (Active Students Only)
        $demographics = [
            'sex' => \App\Models\User::where('role', 'student')
                ->where('is_active', true)
                ->selectRaw("COALESCE(NULLIF(sex, ''), 'Unknown') as label, count(*) as count")
                ->groupBy('label')
                ->pluck('count', 'label'),

            'year_level' => \App\Models\User::where('role', 'student')
                ->where('is_active', true)
                ->selectRaw("COALESCE(NULLIF(year_level, ''), 'Unknown') as label, count(*) as count")
                ->groupBy('label')
                ->orderBy('label')
                ->pluck('count', 'label'),

            'college' => \App\Models\User::where('role', 'student')
                ->where('is_active', true)
                ->selectRaw("COALESCE(NULLIF(college, ''), 'Unspecified') as label, count(*) as count")
                ->groupBy('label')
                ->pluck('count', 'label'),

            'courses' => \App\Models\User::where('role', 'student')
                ->where('is_active', true)
                ->selectRaw("COALESCE(NULLIF(course, ''), 'Unspecified') as label, count(*) as count")
                ->groupBy('label')
                ->orderByDesc('count')
                ->take(5)
                ->pluck('count', 'label'),
        ];

        // 2. Counseling
        // Status Distribution (Active Students Only)
        $counselingStatus = \App\Models\Appointment::whereHas('student', function ($q) {
            $q->where('is_active', true);
        })
            ->selectRaw("status, count(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        // Nature of Appointment (Logic borrowed from Reports)
        // We will classify them on the fly for the chart
        $appointments = \App\Models\Appointment::whereHas('student', function ($q) {
            $q->where('is_active', true);
        })
            ->with('sessionNotes')
            ->get();
        $counselingNature = [
            'Walk-in' => 0,
            'Referral' => 0,
            'Follow-up' => 0,
            'Other' => 0
        ];

        foreach ($appointments as $appt) {
            $isFollowUp = $appt->sessionNotes->contains(fn($n) => $n->session_number > 1);
            if ($isFollowUp) {
                $counselingNature['Follow-up']++;
            } elseif ($appt->guardian1_name || $appt->guardian2_name) {
                // Using guardian info as proxy for referral as per previous logic
                $counselingNature['Referral']++;
            } else {
                // Defaulting remaining to Walk-in for now, or Other if needed
                $counselingNature['Walk-in']++;
            }
        }

        // Counselor Workload (Active Counselors Only)
        $counselorWorkload = \App\Models\User::where('role', 'counselor')
            ->where('is_active', true)
            ->withCount('sessionNotes')
            ->pluck('session_notes_count', 'name');

        // 3. Assessments (Who Tested / Participation)
        // Total by Type (Active Users Only)
        $assessmentTypeStats = \App\Models\Assessment::whereHas('user', function ($q) {
            $q->where('is_active', true);
        })
            ->selectRaw("type, count(*) as count")
            ->groupBy('type')
            ->pluck('count', 'type');

        // Assessments Trend (Last 6 Months - Active Users Only)
        $assessmentTrend = \App\Models\Assessment::whereHas('user', function ($q) {
            $q->where('is_active', true);
        })
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        // Participation by College (Who has taken at least one assessment - Active Students Only)
        // This is a heatmap-like metric: Count of Unique Students who took assessments per college
        $assessmentParticipation = \App\Models\Assessment::join('users', 'assessments.user_id', '=', 'users.id')
            ->where('users.is_active', true)
            ->selectRaw("COALESCE(NULLIF(users.college, ''), 'Unspecified') as college, count(DISTINCT users.id) as student_count")
            ->groupBy('college')
            ->pluck('student_count', 'college');


        // 4. Guidance (Seminars)
        // Attendance by Topic (Active Users Only)
        $seminarStats = \App\Models\SeminarAttendance::join('seminar_schedules', 'seminar_attendances.seminar_schedule_id', '=', 'seminar_schedules.id') // Join schedule to get seminar_id? No, attendance has logic.
            // Wait, relationships: Attendance -> Schedule -> Seminar
            // Let's use the Seminar model to count attendances
            ->join('seminars', 'seminar_schedules.seminar_id', '=', 'seminars.id')
            ->join('users', 'seminar_attendances.user_id', '=', 'users.id')
            ->where('users.is_active', true)
            ->selectRaw("seminars.name as topic, count(*) as count")
            ->groupBy('topic')
            ->pluck('count', 'topic');

        return view('admin.analytics.index', compact(
            'demographics',
            'counselingStatus',
            'counselingNature',
            'counselorWorkload',
            'assessmentTypeStats',
            'assessmentTrend',
            'assessmentParticipation',
            'seminarStats'
        ));
    }
}
