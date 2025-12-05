<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class CounselorDashboardController extends Controller
{
    // Show all appointments assigned to the authenticated counselor
    public function index()
    {
        // Allow admins to view all appointments, counselors can only view their own
        if (auth()->user()->isAdmin()) {
            $appointments = Appointment::with('student', 'counselor')
                ->orderBy('scheduled_at', 'desc')
                ->paginate(10);
            $allAppointments = Appointment::with('student', 'counselor')
                ->orderBy('scheduled_at', 'desc')
                ->get();
        } else {
            $appointments = Appointment::where('counselor_id', auth()->id())
                ->with('student')
                ->orderBy('scheduled_at', 'desc')
                ->paginate(10);
            $allAppointments = Appointment::where('counselor_id', auth()->id())
                ->with('student')
                ->orderBy('scheduled_at', 'desc')
                ->get();
        }
        return view('counselor.appointments.index', compact('appointments', 'allAppointments'));
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
