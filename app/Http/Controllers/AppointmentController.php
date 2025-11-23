<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\AppointmentAcceptedNotification;

class AppointmentController extends Controller
{
    // Show all appointments for the authenticated student
    public function index()
    {
        if (auth()->user()->role === 'counselor') {
            // Get the latest appointment per student for this counselor
            $appointments = \App\Models\Appointment::where('counselor_id', auth()->id())
                ->select('appointments.*')
                ->join(
                    \DB::raw('(
                        SELECT MAX(id) as id
                        FROM appointments
                        WHERE counselor_id = ' . auth()->id() . '
                        GROUP BY student_id
                    ) as latest'),
                    'appointments.id', '=', 'latest.id'
                )
                ->with('student')
                ->orderBy('scheduled_at', 'desc')
                ->get();
            $allAppointments = $appointments;
            return view('counselor.appointments.index', compact('appointments', 'allAppointments'));
        }
        // Default: student view
        $appointments = Appointment::where('student_id', auth()->id())
            ->with(['counselor', 'sessionNotes'])
            ->orderBy('scheduled_at', 'desc')
            ->get();
        return view('appointments.index', compact('appointments'));
    }

    // Show form to create a new appointment
    public function create()
    {
        // Check if user has completed DASS-42 assessment
        $hasDass42 = \App\Models\Assessment::where('user_id', auth()->id())
            ->where('type', 'DASS-42')
            ->exists();

        if (!$hasDass42) {
            return redirect()->route('assessments.index')
                ->with('error', 'Please complete the DASS-42 assessment first before booking an appointment.');
        }

        // Check if user has agreed to consent
        if (!auth()->user()->consent_agreed) {
            return redirect()->route('consent.show')
                ->with('error', 'Please agree to the consent information before booking an appointment.');
        }

        $counselors = User::where('role', 'counselor')->get();
        $student = auth()->user();
        
        // Get latest DASS-42 assessment
        $dass42Assessment = \App\Models\Assessment::where('user_id', auth()->id())
            ->where('type', 'DASS-42')
            ->latest()
            ->first();
        
        return view('appointments.create', compact('counselors', 'student', 'dass42Assessment'));
    }

    // Show appointment confirmation page
    public function confirmation($id)
    {
        $appointment = Appointment::with(['student', 'counselor'])->findOrFail($id);
        
        // Ensure the appointment belongs to the authenticated student
        if ($appointment->student_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if DASS-42 assessment exists (but don't pass scores to student)
        $hasDass42 = \App\Models\Assessment::where('user_id', $appointment->student_id)
            ->where('type', 'DASS-42')
            ->exists();
        
        return view('appointments.confirmation', compact('appointment', 'hasDass42'));
    }

    // Generate PDF for appointment confirmation
    public function downloadPdf($id)
    {
        $appointment = Appointment::with(['student', 'counselor'])->findOrFail($id);
        
        // Ensure the appointment belongs to the authenticated student
        if ($appointment->student_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if DASS-42 assessment exists (but don't pass scores to student)
        $hasDass42 = \App\Models\Assessment::where('user_id', $appointment->student_id)
            ->where('type', 'DASS-42')
            ->exists();
        
        // Get assessment date only (no scores)
        $dass42Assessment = null;
        if ($hasDass42) {
            $dass42Assessment = \App\Models\Assessment::where('user_id', $appointment->student_id)
                ->where('type', 'DASS-42')
                ->latest()
                ->first(['id', 'created_at', 'type']); // Only get date, not scores
        }
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('appointments.confirmation-pdf', compact('appointment', 'dass42Assessment'));
        return $pdf->download('appointment-confirmation-' . $appointment->reference_number . '.pdf');
    }

    // Store a new appointment
    public function store(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'scheduled_at' => 'nullable|date|after:now',
            'appointment_date' => 'nullable|date|after:today',
            'appointment_time' => 'nullable|string',
            'notes' => 'nullable|string',
            'guardian1_name' => 'required|string|max:255',
            'guardian1_relationship' => 'required|string|max:255',
            'guardian1_contact' => 'required|string|max:20',
            'guardian1_relationship_other' => 'nullable|string|max:255',
            'guardian2_name' => 'nullable|string|max:255',
            'guardian2_relationship' => 'nullable|string|max:255',
            'guardian2_contact' => 'nullable|string|max:20',
            'guardian2_relationship_other' => 'nullable|string|max:255',
            'nature_of_problem' => 'required|in:Academic,Family,Personal / Emotional,Social,Psychological,Other',
            'nature_of_problem_other' => 'nullable|string|max:500',
        ]);

        // Normalize scheduled_at to Asia/Manila and format for DB
        // Handle both scheduled_at (from time select) or appointment_date + appointment_time
        if ($request->scheduled_at) {
            $scheduledAt = \Carbon\Carbon::parse($request->scheduled_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s');
        } elseif ($request->appointment_date && $request->appointment_time) {
            // Combine date and time
            $scheduledAt = \Carbon\Carbon::parse($request->appointment_date . ' ' . $request->appointment_time)->timezone('Asia/Manila')->format('Y-m-d H:i:s');
        } else {
            return redirect()->back()->with('error', 'Please select a date and time for your appointment.')->withInput();
        }
        // Check if the counselor is available at the requested time
        $availability = \DB::table('availabilities')
            ->where('user_id', $request->counselor_id)
            ->where('start', $scheduledAt)
            ->first();
        if (!$availability) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'The counselor is not available at the selected time.'], 422);
            }
            return redirect()->back()->with('error', 'The counselor is not available at the selected time.')->withInput();
        }

        // Check if the slot is already booked
        $alreadyBooked = \App\Models\Appointment::where('counselor_id', $request->counselor_id)
            ->where('scheduled_at', $scheduledAt)
            ->exists();
        if ($alreadyBooked) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'This slot is already booked.'], 422);
            }
            return redirect()->back()->with('error', 'This slot is already booked.')->withInput();
        }

        // Generate unique reference number
        $referenceNumber = 'APT-' . strtoupper(uniqid());

        // Handle guardian relationship "Other" fields
        $guardian1Relationship = $request->guardian1_relationship === 'Other' 
            ? $request->guardian1_relationship_other 
            : $request->guardian1_relationship;
        
        $guardian2Relationship = null;
        if ($request->guardian2_relationship) {
            $guardian2Relationship = $request->guardian2_relationship === 'Other' 
                ? $request->guardian2_relationship_other 
                : $request->guardian2_relationship;
        }

        // When creating the appointment, use $scheduledAt
        $appointment = \App\Models\Appointment::create([
            'student_id' => auth()->id(),
            'counselor_id' => $request->counselor_id,
            'scheduled_at' => $scheduledAt,
            'notes' => $request->notes,
            'status' => 'pending',
            'guardian1_name' => $request->guardian1_name,
            'guardian1_relationship' => $guardian1Relationship,
            'guardian1_contact' => $request->guardian1_contact,
            'guardian2_name' => $request->guardian2_name,
            'guardian2_relationship' => $guardian2Relationship,
            'guardian2_contact' => $request->guardian2_contact,
            'nature_of_problem' => $request->nature_of_problem,
            'nature_of_problem_other' => $request->nature_of_problem_other,
            'reference_number' => $referenceNumber,
        ]);
        
        // Notify the counselor
        $counselor = \App\Models\User::find($request->counselor_id);
        if ($counselor) {
            $counselor->notify(new \App\Notifications\AppointmentBookedNotification($appointment));
        }
        
        // Return JSON for AJAX, redirect for normal POST
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Appointment booked successfully!', 'appointment_id' => $appointment->id]);
        }
        return redirect()->route('appointments.confirmation', $appointment->id);
    }

    // Return available slots for a given counselor as JSON
    public function availableSlots(Request $request, $counselor_id)
    {
        // Get all availabilities for the counselor
        $availabilities = \DB::table('availabilities')
            ->where('user_id', $counselor_id)
            ->get();

        // Get all booked appointment times for the counselor
        $booked = \App\Models\Appointment::where('counselor_id', $counselor_id)
            ->pluck('scheduled_at')->toArray();

        $slots = [];
        foreach ($availabilities as $availability) {
            // Parse dates as stored (already in Asia/Manila timezone)
            $start = \Carbon\Carbon::parse($availability->start);
            $end = \Carbon\Carbon::parse($availability->end);

            $slot = [
                'start' => $start->format('Y-m-d\TH:i:s'),
                'end' => $end->format('Y-m-d\TH:i:s'),
                'title' => $availability->title ?? 'Available',
                'booked' => false,
            ];

            // Check if this slot is already booked
            foreach ($booked as $bookedTime) {
                $bookedCarbon = \Carbon\Carbon::parse($bookedTime);
                if ($bookedCarbon->format('Y-m-d\TH:i:s') === $slot['start']) {
                    $slot['booked'] = true;
                    break;
                }
            }

            $slots[] = $slot;
        }

        return response()->json($slots);
    }

    // Mark an appointment as completed
    public function complete($id)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($id);
        $appointment->status = 'completed';
        $appointment->save();
        // Notify the student
        $student = $appointment->student;
        if ($student) {
            $student->notify(new \App\Notifications\AppointmentCompletedNotification($appointment));
        }
        // Redirect back after completion (no longer go to Add Session Note)
        return redirect()->back()->with('success', 'Appointment marked as completed.');
    }

    // Cancel an appointment
    public function cancel($id)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();
        // Notify the student
        $student = $appointment->student;
        if ($student) {
            $student->notify(new \App\Notifications\AppointmentDeclinedByCounselorNotification($appointment));
        }
        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }

    // Accept an appointment
    public function accept($id)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($id);
        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending appointments can be accepted.');
        }
        $appointment->status = 'accepted';
        $appointment->save();
        // Notify the student
        $student = $appointment->student;
        if ($student) {
            $student->notify(new AppointmentAcceptedNotification($appointment));
        }
        return redirect()->back()->with('success', 'Appointment accepted.');
    }

    // Decline an appointment
    public function decline($id)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($id);
        if ($appointment->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending appointments can be declined.');
        }
        $appointment->status = 'declined';
        $appointment->save();
        // Notify the student
        $student = $appointment->student;
        if ($student) {
            $student->notify(new \App\Notifications\AppointmentDeclinedByCounselorNotification($appointment));
        }
        return redirect()->back()->with('success', 'Appointment declined.');
    }

    // Accept a rescheduled appointment (student action)
    public function acceptReschedule($id)
    {
        $appointment = Appointment::where('student_id', auth()->id())->findOrFail($id);
        if ($appointment->status !== 'rescheduled_pending') {
            return redirect()->back()->with('error', 'Only rescheduled appointments can be accepted.');
        }
        // Use previous_scheduled_at for the old date/time
        $oldDateTime = $appointment->previous_scheduled_at;
        $oldDateTimeFormatted = $oldDateTime ? \Carbon\Carbon::parse($oldDateTime)->format('F j, Y \\a\\t g:i A') : 'N/A';
        $appointment->status = 'accepted';
        $appointment->save();
        // Notify the counselor with the old and new date/time
        $counselor = $appointment->counselor;
        if ($counselor) {
            $counselor->notify(new \App\Notifications\AppointmentRescheduleAcceptedNotification($appointment, $oldDateTimeFormatted));
        }
        return redirect()->back()->with('success', 'You have accepted the new appointment slot.');
    }

    // Decline a rescheduled appointment (student action)
    public function declineReschedule($id)
    {
        $appointment = Appointment::where('student_id', auth()->id())->findOrFail($id);
        if ($appointment->status !== 'rescheduled_pending') {
            return redirect()->back()->with('error', 'Only rescheduled appointments can be declined.');
        }
        $appointment->status = 'declined';
        $appointment->save();
        // Notify the counselor (optional: implement a notification)
        $counselor = $appointment->counselor;
        if ($counselor) {
            $counselor->notify(new \App\Notifications\AppointmentDeclinedNotification($appointment));
        }
        return redirect()->back()->with('success', 'You have declined the new appointment slot.');
    }

    // Show form to edit an appointment (for counselor)
    public function edit($id)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->with('student')->findOrFail($id);
        return view('counselor.appointments.edit', compact('appointment'));
    }

    // Update an appointment (for counselor)
    public function update(Request $request, $id)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($id);
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);
        // Store the old scheduled_at before updating
        $appointment->previous_scheduled_at = $appointment->scheduled_at;
        $appointment->scheduled_at = \Carbon\Carbon::parse($request->scheduled_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s');
        $appointment->notes = $request->notes;
        $appointment->status = 'rescheduled_pending';
        $appointment->save();
        // Notify the student (implement a notification class for reschedule)
        $student = $appointment->student;
        if ($student) {
            $student->notify(new \App\Notifications\AppointmentRescheduledNotification($appointment));
        }
        return redirect()->route('counselor.appointments.index')->with('success', 'Appointment rescheduled and student notified. Awaiting student confirmation.');
    }

    // Permanently delete a completed appointment
    public function destroy($id)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($id);
        if (!in_array($appointment->status, ['completed', 'declined'])) {
            return redirect()->back()->with('error', 'Only completed or declined appointments can be deleted.');
        }
        $appointment->delete();
        return redirect()->back()->with('success', 'Appointment deleted successfully.');
    }

    // Show completed appointments with session notes for students
    public function completedWithNotes()
    {
        if (auth()->user()->role !== 'student') {
            return redirect()->back()->with('error', 'Access denied.');
        }

        $completedAppointments = Appointment::where('student_id', auth()->id())
            ->where('status', 'completed')
            ->whereHas('sessionNotes')
            ->with(['counselor', 'sessionNotes'])
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('appointments.completed-with-notes', compact('completedAppointments'));
    }
}
