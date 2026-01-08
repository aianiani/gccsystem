<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class CounselorDashboardController extends Controller
{
    // Show all appointments assigned to the authenticated counselor
    public function index(Request $request)
    {
        // Base query
        $query = Appointment::where('counselor_id', auth()->id())
            ->with('student');

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Get paginated results
        $appointments = $query->orderBy('scheduled_at', 'desc')->paginate(10);

        // Calculate Stats (based on all data, not just filtered)
        $totalAppointments = Appointment::where('counselor_id', auth()->id())->count();
        $pendingAppointments = Appointment::where('counselor_id', auth()->id())->where('status', 'pending')->count();
        $completedAppointments = Appointment::where('counselor_id', auth()->id())->where('status', 'completed')->count();

        // Month stats (current month)
        $currentMonthCount = Appointment::where('counselor_id', auth()->id())
            ->whereMonth('scheduled_at', now()->month)
            ->whereYear('scheduled_at', now()->year)
            ->count();

        return view('counselor.appointments.index', compact(
            'appointments',
            'totalAppointments',
            'pendingAppointments',
            'completedAppointments',
            'currentMonthCount'
        ));
    }

    // Show details for a specific appointment
    public function show($id)
    {
        // Allow admins to view any appointment, counselors can only view their own
        if (auth()->user()->isAdmin()) {
            $appointment = Appointment::with('student', 'counselor')->findOrFail($id);
        } else {
            $appointment = Appointment::where('counselor_id', auth()->id())->with('student')->findOrFail($id);
        }
        // Load the student's latest assessment (if any)
        $latestAssessment = \App\Models\Assessment::where('user_id', $appointment->student_id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('counselor.appointments.show', compact('appointment', 'latestAssessment'));
    }

    // Toggle counselor availability (AJAX)
    public function toggleAvailability(Request $request)
    {
        $user = auth()->user();
        $user->is_available = $request->input('available') == '1';
        $user->save();
        return response()->json(['success' => true, 'is_available' => $user->is_available]);
    }
}
