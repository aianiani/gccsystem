<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\SeminarAttendance;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $recentActivities = $user->activities()->latest()->take(5)->get();
        $recentAnnouncements = Announcement::orderBy('created_at', 'desc')->take(3)->get();

        $stats = [
            'total_users' => User::where('role', 'student')->where('is_active', true)->count(),
            'active_users' => User::where('is_active', true)->count(),
            'admin_users' => User::where('role', 'admin')->where('is_active', true)->count(),
            'total_activities' => UserActivity::count(),
        ];

        switch ($user->role) {
            case 'admin':
                $analytics = $this->calculateAdminAnalytics();
                return view('dashboard_admin', compact('user', 'recentActivities', 'stats', 'recentAnnouncements', 'analytics'));
            case 'counselor':
                $counselorId = $user->id;

                // Calendar events
                $allAppointments = \App\Models\Appointment::with([
                    'student.assessments' => function ($q) {
                        $q->latest();
                    }
                ])
                    ->where('counselor_id', $counselorId)
                    ->orderBy('scheduled_at', 'asc')
                    ->get();

                // Stats for top cards
                $todayAppointments = \App\Models\Appointment::where('counselor_id', $counselorId)
                    ->whereDate('scheduled_at', today())
                    ->count();

                $pendingAppointments = \App\Models\Appointment::where('counselor_id', $counselorId)
                    ->where('status', 'pending')
                    ->count();

                $completedThisMonth = \App\Models\Appointment::where('counselor_id', $counselorId)
                    ->where('status', 'completed')
                    ->whereMonth('scheduled_at', now()->month)
                    ->whereYear('scheduled_at', now()->year)
                    ->count();

                $activeStudentsCount = \App\Models\Appointment::where('counselor_id', $counselorId)
                    ->where('scheduled_at', '>=', now()->subDays(30))
                    ->distinct('student_id')
                    ->count('student_id');

                // List of today's appointments for the sidebar agenda
                $todayAppointmentsList = \App\Models\Appointment::with('student')
                    ->where('counselor_id', $counselorId)
                    ->whereDate('scheduled_at', today())
                    ->orderBy('scheduled_at', 'asc')
                    ->get();

                // High-Risk/Priority Students
                $priorityStudents = \App\Models\User::where('role', 'student')
                    ->whereHas('assessments', function ($q) {
                        $q->whereIn('risk_level', ['high', 'very-high', 'moderate']);
                    })
                    ->whereHas('appointments', function ($q) use ($counselorId) {
                        $q->where('counselor_id', $counselorId);
                    })
                    ->with([
                        'assessments' => function ($q) {
                            $q->latest();
                        }
                    ])
                    ->take(5)
                    ->get();

                $highRiskCasesCount = $priorityStudents->count();

                // Recent Feedback
                $recentFeedback = \App\Models\SessionFeedback::whereHas('appointment', function ($q) use ($counselorId) {
                    $q->where('counselor_id', $counselorId);
                })
                    ->with(['appointment.student'])
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();

                return view('dashboard_counselor', compact(
                    'user',
                    'recentActivities',
                    'stats',
                    'recentAnnouncements',
                    'allAppointments',
                    'todayAppointments',
                    'pendingAppointments',
                    'completedThisMonth',
                    'activeStudentsCount',
                    'priorityStudents',
                    'highRiskCasesCount',
                    'todayAppointmentsList',
                    'recentFeedback'
                ));
            case 'student':
                $studentStats = $this->calculateStudentStats($user);
                $upcomingAppointments = \App\Models\Appointment::where('student_id', $user->id)
                    ->where('scheduled_at', '>=', now())
                    ->whereIn('status', ['pending', 'accepted'])
                    ->orderBy('scheduled_at')
                    ->with('counselor')
                    ->take(3)
                    ->get();
                $recentMessages = $this->getRecentMessages($user);

                // Fetch Seminar Attendance
                $attendances = SeminarAttendance::where('user_id', $user->id)->get();
                $attendanceMatrix = [];
                foreach ($attendances as $attendance) {
                    $attendanceMatrix[$attendance->year_level][$attendance->seminar_name] = [
                        'attended' => true,
                        'schedule_id' => $attendance->seminar_schedule_id,
                        'status' => $attendance->status,
                    ];
                }

                return view('dashboard_student', compact('user', 'recentActivities', 'studentStats', 'recentAnnouncements', 'upcomingAppointments', 'recentMessages', 'attendanceMatrix'));
            default:
                return view('dashboard', compact('user', 'recentActivities', 'stats', 'recentAnnouncements'));
        }
    }

    /**
     * Calculate analytics for admin dashboard
     */
    private function calculateAdminAnalytics()
    {
        // 1. User Registrations (Last 7 days)
        $registrationData = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        $labels = [];
        $regCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M d');
            $regCounts[] = $registrationData->get($date, 0);
        }

        // 2. Appointment Status Distribution (Active or not, appointments are historical records, but maybe we want only active users? 
        // usually appointments stats are operational, so we keep all, OR we filter by active students. 
        // Let's filter by active students to be consistent with "current state".
        $appointmentStats = \App\Models\Appointment::whereHas('student', function ($q) {
            $q->where('is_active', true);
        })
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // 3. Risk Level Distribution (Global - Active Users Only)
        $riskStats = \App\Models\Assessment::whereHas('user', function ($q) {
            $q->where('is_active', true);
        })
            ->selectRaw('risk_level, COUNT(*) as count')
            ->groupBy('risk_level')
            ->get()
            ->pluck('count', 'risk_level');

        // 4. College-Wise Risk Mapping (High Risk Only: Severe, Extremely Severe)
        $collegeRiskData = \App\Models\Assessment::join('users', 'assessments.user_id', '=', 'users.id')
            ->where('users.is_active', true)
            ->whereIn('assessments.risk_level', ['high', 'very-high', 'severe', 'extremely severe'])
            ->selectRaw('users.college, assessments.risk_level, COUNT(*) as count')
            ->groupBy('users.college', 'assessments.risk_level')
            ->get();

        $collegeRiskMap = [];
        foreach ($collegeRiskData as $item) {
            $college = $item->college ?: 'Unknown';
            $collegeRiskMap[$college][$item->risk_level] = $item->count;
        }

        // 5. Counselor Workload (Appointments per counselor - Only active counselors)
        $counselorWorkload = User::where('role', 'counselor')
            ->where('is_active', true)
            ->withCount(['sessionNotes']) // Assuming counselor workload is based on notes/sessions
            ->get()
            ->pluck('session_notes_count', 'name');

        // 6. Critical Alerts (Latest high-risk assessments - Active users only)
        $criticalAlerts = \App\Models\Assessment::with('user')
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            })
            ->whereIn('risk_level', ['high', 'very-high', 'severe', 'extremely severe'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 7. Demographic Breakdown
        // Helper to safe keys
        $safeKey = fn($k) => $k ?: 'Unknown';

        $sexDistribution = User::where('role', 'student')
            ->where('is_active', true)
            ->selectRaw('sex, COUNT(*) as count')
            ->groupBy('sex')
            ->get()
            ->pluck('count', 'sex');

        $collegeDistribution = User::where('role', 'student')
            ->where('is_active', true)
            ->selectRaw('college, COUNT(*) as count')
            ->groupBy('college')
            ->get()
            ->pluck('count', 'college');

        $yearLevelDistribution = User::where('role', 'student')
            ->where('is_active', true)
            ->selectRaw('year_level, COUNT(*) as count')
            ->groupBy('year_level')
            ->orderBy('year_level')
            ->get()
            ->pluck('count', 'year_level');

        $topCourses = User::where('role', 'student')
            ->where('is_active', true)
            ->selectRaw('course, COUNT(*) as count')
            ->groupBy('course')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get()
            ->pluck('count', 'course');

        // 8. Expanded Analytics: Nature of Problem
        $problemDistribution = \App\Models\Appointment::selectRaw('nature_of_problem, COUNT(*) as count')
            ->groupBy('nature_of_problem')
            ->get()
            ->pluck('count', 'nature_of_problem');

        // 9. Expanded Analytics: Referral Sources (Appointment Type)
        $referralDistribution = \App\Models\Appointment::selectRaw('appointment_type, COUNT(*) as count')
            ->groupBy('appointment_type')
            ->get()
            ->pluck('count', 'appointment_type');

        // 10. Action Items Summary
        $actionItems = [
            'pending_approvals' => User::where('registration_status', 'pending')->where('is_active', true)->count(),
            'pending_appointments' => \App\Models\Appointment::where('status', 'pending')
                ->whereHas('student', function ($q) {
                    $q->where('is_active', true);
                })->count(),
            'total_students' => User::where('role', 'student')->where('is_active', true)->count(),
        ];

        return [
            'registration' => [
                'labels' => $labels,
                'data' => $regCounts,
            ],
            'appointments' => [
                'labels' => $appointmentStats->keys()->map(fn($k) => ucfirst($k ?: 'Unknown')),
                'data' => $appointmentStats->values(),
            ],
            'risk' => [
                'labels' => $riskStats->keys()->map(fn($k) => ucfirst($k ?: 'Unknown')),
                'data' => $riskStats->values(),
            ],
            'college_risk' => $collegeRiskMap,
            'counselor_workload' => [
                'labels' => $counselorWorkload->keys(),
                'data' => $counselorWorkload->values(),
            ],
            'demographics' => [
                'sex' => [
                    'labels' => $sexDistribution->keys()->map(fn($k) => ucfirst(str_replace('_', ' ', $k ?: 'Unknown'))),
                    'data' => $sexDistribution->values(),
                ],
                'college' => [
                    'labels' => $collegeDistribution->keys()->map($safeKey),
                    'data' => $collegeDistribution->values(),
                ],
                'year_level' => [
                    'labels' => $yearLevelDistribution->keys()->map(function ($k) {
                        if (!$k)
                            return 'Unknown';
                        $suffix = match ((int) $k) {
                            1 => 'st',
                            2 => 'nd',
                            3 => 'rd',
                            default => 'th',
                        };
                        return $k . $suffix . ' Year';
                    }),
                    'data' => $yearLevelDistribution->values(),
                ],
                'top_courses' => [
                    'labels' => $topCourses->keys()->map(function ($course) {
                        if (!$course)
                            return 'Unknown';

                        // Standardize common degree prefixes
                        $name = preg_replace('/^Bachelor of Science in /i', 'BS ', $course);
                        $name = preg_replace('/^BS in /i', 'BS ', $name);
                        $name = preg_replace('/^Bachelor of Arts in /i', 'AB ', $name);
                        $name = preg_replace('/^AB in /i', 'AB ', $name);
                        $name = preg_replace('/^Bachelor of /i', 'B ', $name);

                        // Extract capital letters to form acronym
                        preg_match_all('/[A-Z]/', $name, $matches);
                        $acronym = implode('', $matches[0]);

                        // Fail-safe: if acronym is too short (e.g. "B" for Biology), return truncated original
                        return strlen($acronym) > 1 ? $acronym : Str::limit($course, 10);
                    }),
                    'data' => $topCourses->values(),
                ],
                // NEW: Detailed Gender Analytics
                'gender_by_college' => \App\Models\User::where('role', 'student')
                    ->where('is_active', true)
                    ->selectRaw('college, sex, count(*) as count')
                    ->groupBy('college', 'sex')
                    ->get()
                    ->groupBy('college')
                    ->map(function ($group) {
                        return [
                            'male' => $group->where('sex', 'male')->sum('count'),
                            'female' => $group->where('sex', 'female')->sum('count')
                        ];
                    }),
                'gender_by_year' => \App\Models\User::where('role', 'student')
                    ->where('is_active', true)
                    ->selectRaw('year_level, sex, count(*) as count')
                    ->groupBy('year_level', 'sex')
                    ->get()
                    ->groupBy('year_level')
                    ->map(function ($group) {
                        return [
                            'male' => $group->where('sex', 'male')->sum('count'),
                            'female' => $group->where('sex', 'female')->sum('count')
                        ];
                    }),
                'matrix' => \App\Models\User::where('role', 'student')
                    ->where('is_active', true)
                    ->selectRaw('college, year_level, count(*) as count')
                    ->groupBy('college', 'year_level')
                    ->get()
                    ->groupBy('college')
                    ->map(function ($group) {
                        return $group->pluck('count', 'year_level');
                    }),
            ],
            'critical_alerts' => $criticalAlerts,

            'action_items' => $actionItems,
            'problem_distribution' => [
                'labels' => $problemDistribution->keys()->map($safeKey),
                'data' => $problemDistribution->values(),
            ],
            'referral_distribution' => [
                'labels' => $referralDistribution->keys()->map(fn($k) => ucfirst($k ?: 'Self-Referral')),
                'data' => $referralDistribution->values(),
            ],
            // 11. Reports Generated
            'reports' => [
                'counseling_usage' => \App\Models\Appointment::join('users', 'appointments.student_id', '=', 'users.id')
                    ->whereHas('student', function ($q) {
                        $q->where('is_active', true);
                    })
                    ->selectRaw("users.college, users.year_level, count(*) as count")
                    ->groupBy('users.college', 'users.year_level')
                    ->get()
                    ->groupBy('college')
                    ->map(function ($group) {
                        return $group->pluck('count', 'year_level');
                    }),
                'high_risk_programs' => \App\Models\Assessment::join('users', 'assessments.user_id', '=', 'users.id')
                    ->where('users.is_active', true)
                    ->whereIn('risk_level', ['severe', 'extremely severe'])
                    ->selectRaw("users.course as program, count(*) as count")
                    ->groupBy('users.course')
                    ->orderByDesc('count')
                    ->limit(5)
                    ->get()
                    ->pluck('count', 'program'),
                'counseling_trend' => \App\Models\Appointment::join('users', 'appointments.student_id', '=', 'users.id')
                    ->where('users.is_active', true)
                    ->selectRaw("DATE_FORMAT(appointments.created_at, '%Y-%m') as date, count(*) as count")
                    ->where('appointments.created_at', '>=', now()->subMonths(6)->startOfMonth())
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->pluck('count', 'date'),
            ],
        ];
    }

    /**
     * Calculate dynamic statistics for student dashboard
     */
    private function calculateStudentStats($user)
    {
        // Session Progress
        $totalSessions = $user->appointments()->where('status', 'completed')->count();
        $totalScheduled = $user->appointments()->whereIn('status', ['accepted', 'pending', 'completed'])->count();
        $sessionProgress = $totalScheduled > 0 ? round(($totalSessions / $totalScheduled) * 100) : 0;

        // Assessment Progress
        $completedAssessments = $user->assessments()->count();
        $totalAssessments = 3; // DASS-42, Academic, Wellness
        $assessmentProgress = round(($completedAssessments / $totalAssessments) * 100);

        // Attendance Rate
        $attendedSessions = $user->appointments()->where('status', 'completed')->count();
        $totalBookedSessions = $user->appointments()->whereIn('status', ['completed', 'declined'])->count();
        $attendanceRate = $totalBookedSessions > 0 ? round(($attendedSessions / $totalBookedSessions) * 100) : 100;

        // Wellness Status
        $latestAssessment = $user->assessments()->latest()->first();
        $currentRiskLevel = $latestAssessment ? $latestAssessment->risk_level : 'normal';

        // Communication Status
        $recentMessages = \App\Models\Message::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('recipient_id', $user->id);
        })->where('created_at', '>=', now()->subDays(7))->count();

        $communicationStatus = $recentMessages > 0 ? 'Active' : 'Quiet';

        // Consecutive Sessions (weekly streak)
        $consecutiveSessions = $user->appointments()
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->get()
            ->groupBy(function ($appointment) {
                return $appointment->scheduled_at->format('W'); // Group by week
            })
            ->count();

        // Sessions with Notes
        $sessionsWithNotes = $user->appointments()
            ->where('status', 'completed')
            ->whereHas('sessionNotes')
            ->count();

        return [
            'sessionProgress' => $sessionProgress,
            'totalSessions' => $totalSessions,
            'totalScheduled' => $totalScheduled,
            'assessmentProgress' => $assessmentProgress,
            'completedAssessments' => $completedAssessments,
            'totalAssessments' => $totalAssessments,
            'attendanceRate' => $attendanceRate,
            'currentRiskLevel' => $currentRiskLevel,
            'communicationStatus' => $communicationStatus,
            'recentMessages' => $recentMessages,
            'consecutiveSessions' => $consecutiveSessions,
            'sessionsWithNotes' => $sessionsWithNotes
        ];
    }

    /**
     * Get recent messages for student dashboard
     */
    private function getRecentMessages($user)
    {
        return \App\Models\Message::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('recipient_id', $user->id);
        })
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($message) use ($user) {
                // Determine if this user is the sender or recipient
                $isSender = $message->sender_id === $user->id;
                $otherUser = $isSender ? $message->recipient : $message->sender;

                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'sender_name' => $otherUser ? $otherUser->name : 'Unknown',
                    'is_self' => $isSender,
                    'created_at' => $message->created_at,
                    'time_ago' => $message->created_at->diffForHumans()
                ];
            });
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = auth()->user();
        $activities = $user->activities()->latest()->paginate(10);

        return view('profile', compact('user', 'activities'));
    }

    /**
     * Show activity logs (admin only)
     */
    public function activities()
    {
        $activities = UserActivity::with('user')->latest()->paginate(15);

        return view('activities', compact('activities'));
    }
}
