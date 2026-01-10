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

        // Date Range Filter
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('scheduled_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('scheduled_at', '<=', $request->date_to);
        }

        // Nature of Problem Filter
        if ($request->has('nature_of_problem') && $request->nature_of_problem != '') {
            $query->where('nature_of_problem', $request->nature_of_problem);
        }

        // Sort Options
        $sortBy = $request->get('sort_by', 'date_desc');
        switch ($sortBy) {
            case 'date_asc':
                $query->orderBy('scheduled_at', 'asc');
                break;
            case 'name_asc':
                $query->join('users', 'appointments.student_id', '=', 'users.id')
                    ->orderBy('users.name', 'asc')
                    ->select('appointments.*');
                break;
            case 'name_desc':
                $query->join('users', 'appointments.student_id', '=', 'users.id')
                    ->orderBy('users.name', 'desc')
                    ->select('appointments.*');
                break;
            case 'date_desc':
            default:
                $query->orderBy('scheduled_at', 'desc');
                break;
        }

        // Get paginated results
        $appointments = $query->paginate(10)->appends($request->except('page'));

        // Add session numbers to each appointment
        foreach ($appointments as $appointment) {
            // Count previous completed or accepted appointments with the same student
            $sessionNumber = Appointment::where('counselor_id', auth()->id())
                ->where('student_id', $appointment->student_id)
                ->where(function ($q) use ($appointment) {
                    $q->where('scheduled_at', '<', $appointment->scheduled_at)
                        ->orWhere(function ($q2) use ($appointment) {
                            $q2->where('scheduled_at', '=', $appointment->scheduled_at)
                                ->where('id', '<=', $appointment->id);
                        });
                })
                ->whereIn('status', ['completed', 'accepted', 'pending', 'rescheduled_pending'])
                ->count();
            $appointment->session_number = $sessionNumber;
        }

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

        // Calculate session number for this appointment
        $sessionNumber = Appointment::where('counselor_id', $appointment->counselor_id)
            ->where('student_id', $appointment->student_id)
            ->where(function ($q) use ($appointment) {
                $q->where('scheduled_at', '<', $appointment->scheduled_at)
                    ->orWhere(function ($q2) use ($appointment) {
                        $q2->where('scheduled_at', '=', $appointment->scheduled_at)
                            ->where('id', '<=', $appointment->id);
                    });
            })
            ->whereIn('status', ['completed', 'accepted', 'pending', 'rescheduled_pending'])
            ->count();
        $appointment->session_number = $sessionNumber;

        // If this is not the first session and some fields are missing, inherit from first session
        if ($sessionNumber > 1) {
            $firstAppointment = Appointment::where('counselor_id', $appointment->counselor_id)
                ->where('student_id', $appointment->student_id)
                ->whereIn('status', ['completed', 'accepted', 'pending', 'rescheduled_pending'])
                ->orderBy('scheduled_at', 'asc')
                ->orderBy('id', 'asc')
                ->first();

            if ($firstAppointment) {
                // Inherit guardian information if missing
                if (empty($appointment->guardian1_name) && !empty($firstAppointment->guardian1_name)) {
                    $appointment->guardian1_name = $firstAppointment->guardian1_name;
                    $appointment->guardian1_relationship = $firstAppointment->guardian1_relationship;
                    $appointment->guardian1_contact = $firstAppointment->guardian1_contact;
                }
                if (empty($appointment->guardian2_name) && !empty($firstAppointment->guardian2_name)) {
                    $appointment->guardian2_name = $firstAppointment->guardian2_name;
                    $appointment->guardian2_relationship = $firstAppointment->guardian2_relationship;
                    $appointment->guardian2_contact = $firstAppointment->guardian2_contact;
                }
                // Inherit nature of problem if missing
                if (empty($appointment->nature_of_problem) && !empty($firstAppointment->nature_of_problem)) {
                    $appointment->nature_of_problem = $firstAppointment->nature_of_problem;
                    $appointment->nature_of_problem_other = $firstAppointment->nature_of_problem_other;
                }
            }
        }

        // Ensure appointment has a reference number
        if (empty($appointment->reference_number)) {
            // Generate a reference number if missing
            $tempSessionNumber = $appointment->session_number; // Store temporarily
            unset($appointment->session_number); // Remove before saving to prevent SQL error

            $appointment->reference_number = 'APT-' . strtoupper(substr(md5(uniqid()), 0, 8));
            $appointment->save();

            $appointment->session_number = $tempSessionNumber; // Restore for display
        }

        // Load the student's latest assessment (if any)
        $latestAssessment = \App\Models\Assessment::where('user_id', $appointment->student_id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Load appointment history for this student with this counselor
        $appointmentHistory = Appointment::where('counselor_id', $appointment->counselor_id)
            ->where('student_id', $appointment->student_id)
            ->where('id', '!=', $appointment->id)
            ->whereIn('status', ['completed', 'accepted', 'pending', 'rescheduled_pending', 'declined', 'cancelled'])
            ->orderBy('scheduled_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('counselor.appointments.show', compact('appointment', 'latestAssessment', 'appointmentHistory'));
    }

    // Toggle counselor availability (AJAX)
    public function toggleAvailability(Request $request)
    {
        $user = auth()->user();
        $user->is_available = $request->input('available') == '1';
        $user->save();
        return response()->json(['success' => true, 'is_available' => $user->is_available]);
    }

    // Delete all completed appointments for the authenticated counselor
    public function deleteAllCompleted()
    {
        try {
            $deletedCount = Appointment::where('counselor_id', auth()->id())
                ->where('status', 'completed')
                ->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} completed appointment(s).",
                'deleted_count' => $deletedCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete completed appointments. Please try again.'
            ], 500);
        }
    }
}
