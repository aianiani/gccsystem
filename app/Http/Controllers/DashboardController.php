<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\Announcement;

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
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'total_activities' => UserActivity::count(),
        ];

        switch ($user->role) {
            case 'admin':
                return view('dashboard_admin', compact('user', 'recentActivities', 'stats', 'recentAnnouncements'));
            case 'counselor':
                $allAppointments = \App\Models\Appointment::where('counselor_id', $user->id)
                    ->with('student')
                    ->orderBy('scheduled_at', 'desc')
                    ->get();
                return view('dashboard_counselor', compact('user', 'recentActivities', 'stats', 'recentAnnouncements', 'allAppointments'));
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
                return view('dashboard_student', compact('user', 'recentActivities', 'studentStats', 'recentAnnouncements', 'upcomingAppointments', 'recentMessages'));
            default:
                return view('dashboard', compact('user', 'recentActivities', 'stats', 'recentAnnouncements'));
        }
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
        $totalAssessments = 3; // DASS-21, Academic, Wellness
        $assessmentProgress = round(($completedAssessments / $totalAssessments) * 100);
        
        // Attendance Rate
        $attendedSessions = $user->appointments()->where('status', 'completed')->count();
        $totalBookedSessions = $user->appointments()->whereIn('status', ['completed', 'declined'])->count();
        $attendanceRate = $totalBookedSessions > 0 ? round(($attendedSessions / $totalBookedSessions) * 100) : 100;
        
        // Wellness Status
        $latestAssessment = $user->assessments()->latest()->first();
        $currentRiskLevel = $latestAssessment ? $latestAssessment->risk_level : 'normal';
        
        // Communication Status
        $recentMessages = \App\Models\Message::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('recipient_id', $user->id);
        })->where('created_at', '>=', now()->subDays(7))->count();
        
        $communicationStatus = $recentMessages > 0 ? 'Active' : 'Quiet';
        
        // Consecutive Sessions (weekly streak)
        $consecutiveSessions = $user->appointments()
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->get()
            ->groupBy(function($appointment) {
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
        return \App\Models\Message::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('recipient_id', $user->id);
        })
        ->with(['sender', 'recipient'])
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get()
        ->map(function($message) use ($user) {
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
