<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Seminar;
use App\Models\SeminarSchedule;
use App\Models\SeminarAttendance;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminReportsController extends Controller
{
    /**
     * Display the admin reports page
     */
    public function index(Request $request)
    {
        // Default to current month if not specified
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Get report data
        $testingData = $this->getTestingData($month, $year);
        $guidanceData = $this->getGuidanceData($month, $year);
        $counselingData = $this->getCounselingData($month, $year);

        // Calculate Totals for Summary Cards
        $totalTested = collect($testingData)->sum(fn($item) => $item['administration']['total'] ?? 0);
        $totalGuided = collect($guidanceData)->sum('total_attended');
        $totalCounseled = collect($counselingData)->sum('total');

        return view('admin.reports.index', compact(
            'testingData',
            'guidanceData',
            'counselingData',
            'totalTested',
            'totalGuided',
            'totalCounseled',
            'month',
            'year'
        ));
    }

    /**
     * Get testing/assessment data aggregated by type
     */
    private function getTestingData($month, $year)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Map assessment types to test categories
        // KEY: Label in Report
        // VALUE: Criteria to match in Database
        // Note: We include legacy types (e.g. 'dass42') and year levels (e.g. '1', '1st Year') to ensure all data appears correctly.
        $testCategories = [
            'First Year - GRIT' => ['type' => ['GRIT Scale', 'academic'], 'year_level' => ['1', '1st Year']],
            'Second Year - DASS' => ['type' => ['DASS-42', 'dass42'], 'year_level' => ['2', '2nd Year']],
            'Third Year - NEO' => ['type' => ['NEO-PI-R', 'wellness'], 'year_level' => ['3', '3rd Year']],
            'Graduating - WVI' => ['type' => ['Work Values Inventory', 'academic'], 'year_level' => ['4', '4th Year', '5', '5th Year']],
            'Others' => ['type' => null, 'year_level' => null],
        ];

        $results = [];
        $processedIds = []; // Track IDs to exclude them from "Others"

        foreach ($testCategories as $category => $criteria) {
            $query = Assessment::whereBetween('created_at', [$startDate, $endDate])
                ->with('user');

            if ($category === 'Others') {
                // For "Others", exclude everything we've already counted
                $query->whereNotIn('id', $processedIds);
            } else {
                // Filter by type if specified
                if ($criteria['type']) {
                    if (is_array($criteria['type'])) {
                        $query->whereIn('type', $criteria['type']);
                    } else {
                        $query->where('type', $criteria['type']);
                    }
                }

                // Filter by year level through relationship
                if ($criteria['year_level']) {
                    $query->whereHas('user', function ($q) use ($criteria) {
                        if (is_array($criteria['year_level'])) {
                            $q->whereIn('year_level', $criteria['year_level']);
                        } else {
                            $q->where('year_level', $criteria['year_level']);
                        }
                    });
                }
            }

            $assessments = $query->get();

            // Add these IDs to the processed list so they don't appear in "Others"
            // (Only if we are NOT in "Others" - though for "Others" it doesn't matter)
            if ($category !== 'Others') {
                $processedIds = array_merge($processedIds, $assessments->pluck('id')->toArray());
            }

            // Helper to get unique colleges
            $getColleges = fn($collection) => $collection->pluck('user.college')->unique()->filter()->values();

            // Administration (All)
            $administrationEvents = $assessments;
            $administrationCount = $administrationEvents->count();
            $collegesAdmin = $getColleges($administrationEvents);

            // Checking / Scoring (Not pending)
            $checkingEvents = $assessments->where('status', '!=', 'pending');
            $checkingCount = $checkingEvents->count();
            $collegesChecking = $getColleges($checkingEvents);

            // Interpretation (With notes)
            $interpretationEvents = $assessments->whereNotNull('notes');
            $interpretationCount = $interpretationEvents->count();
            $collegesInterpretation = $getColleges($interpretationEvents);

            // Report / Result (Completed)
            $reportEvents = $assessments->where('status', 'completed');
            $reportResultCount = $reportEvents->count();
            $collegesResult = $getColleges($reportEvents);

            // Calculate total enrolled (target population) based on year level
            $totalEnrolledCount = 0;
            if ($criteria['year_level']) {
                $totalEnrolledCount = User::where('role', 'student')
                    ->where('is_active', true)
                    ->where('registration_status', 'approved')
                    ->when(is_array($criteria['year_level']), function ($q) use ($criteria) {
                        return $q->whereIn('year_level', $criteria['year_level']);
                    }, function ($q) use ($criteria) {
                        return $q->where('year_level', $criteria['year_level']);
                    })
                    ->count();
            }

            $results[] = [
                'category' => $category,
                'administration' => [
                    'colleges' => $collegesAdmin,
                    'male' => $administrationEvents->where('user.gender', 'male')->count(),
                    'female' => $administrationEvents->where('user.gender', 'female')->count(),
                    'total' => $administrationCount,
                    'total_enrolled' => $totalEnrolledCount,
                ],
                'checking_scoring' => [
                    'colleges' => $collegesChecking,
                    'male' => $checkingEvents->where('user.gender', 'male')->count(),
                    'female' => $checkingEvents->where('user.gender', 'female')->count(),
                    'total' => $checkingCount,
                ],
                'interpretation' => [
                    'colleges' => $collegesInterpretation,
                    'male' => $interpretationEvents->where('user.gender', 'male')->count(),
                    'female' => $interpretationEvents->where('user.gender', 'female')->count(),
                    'total' => $interpretationCount,
                ],
                'report_result' => [
                    'colleges' => $collegesResult,
                    'male' => $reportEvents->where('user.gender', 'male')->count(),
                    'female' => $reportEvents->where('user.gender', 'female')->count(),
                    'total' => $reportResultCount,
                ],
            ];
        }

        return $results;
    }

    /**
     * Get guidance/seminar data aggregated by topic
     */
    private function getGuidanceData($month, $year)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Get all seminars with schedules in the specified month
        $seminars = Seminar::whereHas('schedules', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->with([
                    'schedules' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('created_at', [$startDate, $endDate])
                            ->with('attendances.user');
                    }
                ])->get();

        $results = [];

        foreach ($seminars as $seminar) {
            foreach ($seminar->schedules as $schedule) {
                $attendances = $schedule->attendances;

                // Get attended count
                $attended = $attendances->count();

                // Get colleges from schedule or seminar target
                $collegesSource = $schedule->colleges ?? [];
                if (is_string($collegesSource)) {
                    $collegesSource = explode(',', $collegesSource);
                }

                $colleges = collect($collegesSource)
                    ->map(fn($c) => trim($c))
                    ->filter()
                    ->values();

                // Gender breakdown of attendees
                $males = $attendances->where('user.gender', 'male')->count();
                $females = $attendances->where('user.gender', 'female')->count();

                // Calculate total enrolled based on target criteria
                $totalEnrolled = User::where('role', 'student')
                    ->where('is_active', true)
                    ->where('registration_status', 'approved');

                if ($seminar->target_year_level) {
                    $totalEnrolled->where('year_level', $seminar->target_year_level);
                }

                if ($schedule->colleges) {
                    $totalEnrolled->whereIn('college', $colleges);
                }

                $totalEnrolled = $totalEnrolled->count();

                $results[] = [
                    'date' => $schedule->created_at->format('F'),
                    'topic' => $seminar->name,
                    'colleges' => $colleges,
                    'male' => $males,
                    'female' => $females,
                    'total_attended' => $attended,
                    'total_enrolled' => $totalEnrolled,
                ];
            }
        }

        return $results;
    }

    /**
     * Get counseling/appointment data aggregated by nature
     */
    private function getCounselingData($month, $year)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $appointments = Appointment::whereBetween('created_at', [$startDate, $endDate])
            ->with(['student', 'sessionNotes'])
            ->get();

        // Classify appointments by nature
        $counselingTypes = [
            'Walk-in' => [],
            'Referral' => [],
            'Call-in' => [],
            'Follow-up' => [],
        ];

        foreach ($appointments as $appointment) {
            // Determine type based on available data
            $type = 'Walk-in'; // Default

            // Follow-up: has session notes indicating multiple sessions
            if ($appointment->sessionNotes()->where('session_number', '>', 1)->exists()) {
                $type = 'Follow-up';
            }
            // Referral: appointed by counselor or has guardian info (indicating external referral)
            elseif ($appointment->guardian1_name || $appointment->guardian2_name) {
                $type = 'Referral';
            }

            $counselingTypes[$type][] = $appointment;
        }

        $results = [];

        foreach ($counselingTypes as $nature => $appts) {
            $appts = collect($appts);

            // Get colleges
            $colleges = $appts->pluck('student.college')->unique()->filter()->values();

            // Year levels
            $yearLevels = $appts->pluck('student.year_level')->unique()->filter()->sort()->values();

            // Presenting problems
            $problems = $appts->pluck('nature_of_problem')->unique()->filter()->values();

            // Gender breakdown
            $males = $appts->where('student.gender', 'male')->count();
            $females = $appts->where('student.gender', 'female')->count();

            $results[] = [
                'nature' => $nature,
                'colleges' => $colleges,
                'year_levels' => $yearLevels,
                'presenting_problems' => $problems,
                'male' => $males,
                'female' => $females,
                'total' => $appts->count(),
            ];
        }

        return $results;
    }

    /**
     * Export reports as PDF or Excel
     */
    public function export(Request $request, $format)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $testingData = $this->getTestingData($month, $year);
        $guidanceData = $this->getGuidanceData($month, $year);
        $counselingData = $this->getCounselingData($month, $year);

        $data = compact('testingData', 'guidanceData', 'counselingData', 'month', 'year');

        if ($format === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.export_pdf', $data);
            return $pdf->download("monthly_report_{$year}_{$month}.pdf");
        }

        // For Excel/CSV, we can add later
        return back()->with('error', 'Export format not yet implemented');
    }
}
