<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Seminar;
use App\Models\SeminarSchedule;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminReportsController extends Controller
{
    private $collegesList = [
        'College of Arts and Sciences' => 'CAS',
        'College of Veterinary Medicine' => 'CVM',
        'College of Forestry and Environmental Sciences' => 'CFES',
        'College of Business and Management' => 'CBM',
        'College of Nursing' => 'CON',
        'College of Human Ecology' => 'CHE',
        'College of Agriculture' => 'COA',
        'College of Information Science and Computing' => 'CISC',
        'College of Education' => 'COED',
        'College of Engineering' => 'COE'
    ];

    /**
     * Display the admin reports page
     */
    public function index(Request $request)
    {
        $frequency = $request->input('frequency', 'monthly');
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $week = $request->input('week', now()->weekOfYear);

        // Determine Date Range
        if ($frequency === 'annual') {
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
            $endDate = Carbon::create($year, 12, 31)->endOfDay();
            $bannerText = "Annual Report - {$year}";
        } elseif ($frequency === 'weekly') {
            // ISO Week
            $startDate = Carbon::now()->setISODate($year, $week)->startOfWeek();
            $endDate = Carbon::now()->setISODate($year, $week)->endOfWeek();
            $bannerText = "Weekly Report - Week {$week}, {$year} (" . $startDate->format('M d') . " - " . $endDate->format('M d') . ")";
        } else { // monthly or default
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            $bannerText = $startDate->format('F Y');
        }

        // Get report data
        $testingData = $this->getTestingData($startDate, $endDate);
        $guidanceData = $this->getGuidanceData($startDate, $endDate);
        $counselingData = $this->getCounselingData($startDate, $endDate);

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
            'frequency',
            'year',
            'month',
            'week',
            'bannerText'
        ));
    }

    /**
     * Get testing/assessment data aggregated by type
     * Optimized to use SQL aggregation
     */
    private function getTestingData($startDate, $endDate)
    {
        // Map assessment types to test categories
        $testCategories = [
            'First Year - GRIT' => ['type' => ['GRIT Scale', 'academic'], 'year_level' => ['1', '1st Year']],
            'Second Year - DASS' => ['type' => ['DASS-42', 'dass42'], 'year_level' => ['2', '2nd Year']],
            'Third Year - NEO' => ['type' => ['NEO-PI-R', 'wellness'], 'year_level' => ['3', '3rd Year']],
            'Graduating - WVI' => ['type' => ['Work Values Inventory', 'academic'], 'year_level' => ['4', '4th Year', '5', '5th Year']],
        ];

        $results = [];
        $processedIds = [];

        foreach ($testCategories as $category => $criteria) {
            $query = Assessment::query()
                ->whereBetween('assessments.created_at', [$startDate, $endDate])
                ->join('users', 'assessments.user_id', '=', 'users.id');

            if ($category === 'Others') {
                if (!empty($processedIds)) {
                    $query->whereNotIn('assessments.id', $processedIds);
                }
            } else {
                if ($criteria['type']) {
                    if (is_array($criteria['type'])) {
                        $query->whereIn('assessments.type', $criteria['type']);
                    } else {
                        $query->where('assessments.type', $criteria['type']);
                    }
                }
                if ($criteria['year_level']) {
                    if (is_array($criteria['year_level'])) {
                        $query->whereIn('users.year_level', $criteria['year_level']);
                    } else {
                        $query->where('users.year_level', $criteria['year_level']);
                    }
                }
            }

            // Capture IDs for the exclusion logic
            if ($category !== 'Others') {
                $currentIds = (clone $query)->pluck('assessments.id')->toArray();
                $processedIds = array_merge($processedIds, $currentIds);
            }

            // Group by college to get breakdown
            $aggregates = (clone $query)
                ->selectRaw("
                    users.college,
                    count(*) as admin_total,
                    sum(case when users.sex = 'male' then 1 else 0 end) as admin_male,
                    sum(case when users.sex = 'female' then 1 else 0 end) as admin_female,
                    
                    sum(case when assessments.status != 'pending' then 1 else 0 end) as checking_total,
                    sum(case when assessments.status != 'pending' and users.sex = 'male' then 1 else 0 end) as checking_male,
                    sum(case when assessments.status != 'pending' and users.sex = 'female' then 1 else 0 end) as checking_female,

                    sum(case when assessments.notes is not null then 1 else 0 end) as interp_total,
                    sum(case when assessments.notes is not null and users.sex = 'male' then 1 else 0 end) as interp_male,
                    sum(case when assessments.notes is not null and users.sex = 'female' then 1 else 0 end) as interp_female,

                    sum(case when assessments.status = 'completed' then 1 else 0 end) as report_total,
                    sum(case when assessments.status = 'completed' and users.sex = 'male' then 1 else 0 end) as report_male,
                    sum(case when assessments.status = 'completed' and users.sex = 'female' then 1 else 0 end) as report_female
                ")
                ->groupBy('users.college')
                ->get()
                ->keyBy('college');

            $categoryRows = [];

            // Iterate through ALL fixed colleges to ensure they are listed
            foreach ($this->collegesList as $collegeName => $acronym) {
                // Get data for this college if exists, else defaults
                $data = $aggregates->get($collegeName);

                // Calculate Total Enrolled (Target Population) for this SPECIFIC college and year level logic
                $totalEnrolledCount = 0;
                if ($criteria['year_level']) {
                    $totalEnrolledCount = User::where('role', 'student')
                        ->where('is_active', true)
                        ->where('registration_status', 'approved')
                        ->where('college', $collegeName) // Filter by College (Full Name)
                        ->when(is_array($criteria['year_level']), function ($q) use ($criteria) {
                            return $q->whereIn('year_level', $criteria['year_level']);
                        }, function ($q) use ($criteria) {
                            return $q->where('year_level', $criteria['year_level']);
                        })
                        ->count();
                }

                $categoryRows[] = [
                    'college' => $acronym, // Use Acronym for display
                    'administration' => [
                        'male' => $data->admin_male ?? 0,
                        'female' => $data->admin_female ?? 0,
                        'total' => $data->admin_total ?? 0,
                        'total_enrolled' => $totalEnrolledCount,
                    ],
                    'checking_scoring' => [
                        'male' => $data->checking_male ?? 0,
                        'female' => $data->checking_female ?? 0,
                        'total' => $data->checking_total ?? 0,
                    ],
                    'interpretation' => [
                        'male' => $data->interp_male ?? 0,
                        'female' => $data->interp_female ?? 0,
                        'total' => $data->interp_total ?? 0,
                    ],
                    'report_result' => [
                        'male' => $data->report_male ?? 0,
                        'female' => $data->report_female ?? 0,
                        'total' => $data->report_total ?? 0,
                    ],
                ];
            }

            $results[] = [
                'category' => $category,
                'rows' => $categoryRows
            ];
        }

        return $results;
    }

    /**
     * Get guidance/seminar data aggregated by topic
     */
    /**
     * Get guidance/seminar data aggregated by topic with fixed structure
     */
    private function getGuidanceData($startDate, $endDate)
    {
        // Fixed list of Seminar Topics (Case insensitive matching likely needed, but assuming exact for now based on request)
        // If names in DB differ slightly, we might need 'LIKE' queries.
        $fixedTopics = [
            'IDREAMS',
            '10C RESILIENCY',
            'LEADS',
            'IMAGE'
        ];

        $results = [];

        foreach ($fixedTopics as $topic) {
            // Find Seminars matching this topic (case-insensitive)
            // We use 'like' to match "IDREAMS" with "idreams" or " Idreams "
            $seminarIds = Seminar::where('name', 'like', trim($topic))
                ->pluck('id');

            // Initialize rows for this topic
            $topicRows = [];

            // Group 1: Get all schedules for these seminars within date range
            $query = SeminarSchedule::whereIn('seminar_id', $seminarIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->with(['attendances.user']);

            // We need to aggregate attendees by College for this Topic across ALL schedules
            // Because a topic might have multiple schedules (e.g. different dates), we should sum them up?
            // OR the report implies "DATE" column. If we fix the topics, do we still show Date?
            // The image shows "DATE" (Month?) column. "SEPTEMBER - IDREAMS".
            // If the report is "Monthly", usually there's only one run?
            // If "Annual", multiple runs.
            // Let's aggregating everything for the period under the Topic Name.
            // Data point for "Date": If multiple dates, maybe range or latest? Or just Month name if monthly.

            $relevantSchedules = $query->get();

            // Collect all attendances for this topic in this period
            $allAttendances = collect();
            foreach ($relevantSchedules as $sch) {
                $allAttendances = $allAttendances->merge($sch->attendances);
            }

            // Group attendances by User's College
            // We need to map user's college to our fixed list keys if possible, or just string match
            $attendancesByCollege = $allAttendances->groupBy(function ($attendance) {
                return $attendance->user->college ?? 'Unknown';
            });

            // Date for display - use the first schedule's date or 'Various Dates'
            $displayDate = $relevantSchedules->isEmpty()
                ? '-'
                : $relevantSchedules->sortBy('created_at')->first()->created_at->format('F'); // Just Month as per image hint "SEPTEMBER"

            // Iterate through ALL fixed colleges
            foreach ($this->collegesList as $collegeName => $acronym) {
                // Filter attendances for this college
                // Matching full college name from user record
                $collegeAttendances = $attendancesByCollege->get($collegeName, collect());

                $males = $collegeAttendances->where('user.sex', 'male')->count();
                $females = $collegeAttendances->where('user.sex', 'female')->count();
                $totalAttended = $collegeAttendances->count();

                // Calculate Total Enrolled (Target Population) for this SPECIFIC college
                // For Seminars, target population is often specific year levels.
                // We should try to find reference seminar config for target year level.
                // Taking the First matching seminar's target year level as "The Rule" for this topic.
                $refSeminar = Seminar::whereIn('id', $seminarIds)->first();
                $targetYearLevel = $refSeminar ? $refSeminar->target_year_level : null;

                $totalEnrolledCount = User::where('role', 'student')
                    ->where('is_active', true)
                    ->where('registration_status', 'approved')
                    ->where('college', $collegeName);

                if ($targetYearLevel) {
                    $totalEnrolledCount->where('year_level', $targetYearLevel);
                }

                $totalEnrolled = $totalEnrolledCount->count();

                $topicRows[] = [
                    'college' => $acronym,
                    'male' => $males,
                    'female' => $females,
                    'total_attended' => $totalAttended,
                    'total_enrolled' => $totalEnrolled,
                    'evaluation' => '', // Placeholder as requested
                ];
            }

            $results[] = [
                'topic' => $topic,
                'date' => $displayDate,
                'rows' => $topicRows
            ];
        }

        return $results;
    }

    /**
     * Get counseling/appointment data aggregated by nature
     */
    /**
     * Get counseling/appointment data aggregated by nature (Fixed Categories)
     */
    private function getCounselingData($startDate, $endDate)
    {
        // 1. Fetch appointments with needed relations
        $appointments = Appointment::whereBetween('created_at', [$startDate, $endDate])
            ->with(['student', 'sessionNotes'])
            ->get();

        // 2. Classify appointments into Fixed Natures
        $counselingTypes = [
            'WALK-IN' => collect(),
            'REFERRAL' => collect(),
            'CALL-IN' => collect(),
            'FOLLOW-UP' => collect(),
        ];

        foreach ($appointments as $appointment) {
            $type = 'WALK-IN'; // Default

            // Logic to classify
            // Check for Follow-up (Session > 1)
            // Note: This logic assumes 'session_number' > 1 means follow up. 
            // Ideally we check if it's the 2nd+ appointment for the same case, but this is a reasonable proxy given the schema.
            $hasFollowUpNote = $appointment->sessionNotes->contains(function ($note) {
                return $note->session_number > 1;
            });

            if ($hasFollowUpNote) {
                $type = 'FOLLOW-UP';
            } elseif ($appointment->guardian1_name || $appointment->guardian2_name) {
                // Assuming referral if guardian info is used/present implies it came from outside? 
                // Or we can add a 'referral' field logic if exists. Sticking to previous logic.
                $type = 'REFERRAL';
            }
            // Call-in logic? Currently no strict field. Leaving as default Walk-in unless specified.
            // If there's an 'appointment_type' or similar, strict check would be here.

            $counselingTypes[$type]->push($appointment);
        }

        $results = [];

        // 3. Loop through Fixed Categories and then Fixed Colleges
        foreach ($counselingTypes as $nature => $appts) {
            $natureRows = [];

            // Group these specific appointments by college
            $apptsByCollege = $appts->groupBy(function ($appt) {
                return $appt->student->college ?? 'Unknown';
            });

            foreach ($this->collegesList as $collegeName => $acronym) {
                $collegeAppts = $apptsByCollege->get($collegeName, collect());

                $males = $collegeAppts->where('student.sex', 'male')->count();
                $females = $collegeAppts->where('student.sex', 'female')->count();
                $total = $collegeAppts->count();

                // Aggregate Year Levels (Unique list)
                $yearLevels = $collegeAppts->pluck('student.year_level')
                    ->unique()
                    ->sort()
                    ->implode(', ');

                // Aggregate Presenting Problems (Unique list)
                $problems = $collegeAppts->pluck('nature_of_problem')
                    ->unique()
                    ->filter()
                    ->implode(', ');

                $natureRows[] = [
                    'college' => $acronym,
                    'year_level' => $yearLevels ?: '-',
                    'presenting_problem' => $problems ?: '-',
                    'male' => $males,
                    'female' => $females,
                    'total' => $total,
                ];
            }

            $results[] = [
                'nature' => $nature,
                'rows' => $natureRows
            ];
        }

        return $results;
    }

    /**
     * Export reports as PDF
     */
    public function export(Request $request, $format)
    {
        // Reuse index logic for dates
        $frequency = $request->input('frequency', 'monthly');
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $week = $request->input('week', now()->weekOfYear);

        if ($frequency === 'annual') {
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
            $endDate = Carbon::create($year, 12, 31)->endOfDay();
            $filename = "annual_report_{$year}";
        } elseif ($frequency === 'weekly') {
            $startDate = Carbon::now()->setISODate($year, $week)->startOfWeek();
            $endDate = Carbon::now()->setISODate($year, $week)->endOfWeek();
            $filename = "weekly_report_{$year}_week{$week}";
        } else {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            $filename = "monthly_report_{$year}_{$month}";
        }

        $testingData = $this->getTestingData($startDate, $endDate);
        $guidanceData = $this->getGuidanceData($startDate, $endDate);
        $counselingData = $this->getCounselingData($startDate, $endDate);

        $data = compact('testingData', 'guidanceData', 'counselingData', 'year', 'month', 'week', 'frequency');

        if ($format === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.export_pdf', $data);
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download("{$filename}.pdf");
        }

        return back()->with('error', 'Export format not yet implemented');
    }
}
