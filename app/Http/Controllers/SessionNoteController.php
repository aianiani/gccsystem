<?php

namespace App\Http\Controllers;

use App\Models\SessionNote;
use App\Models\Appointment;
use Illuminate\Http\Request;

class SessionNoteController extends Controller
{
    // Show form to create a session note for an appointment
    public function create($appointmentId)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($appointmentId);

        // If a session note exists for this appointment
        $existingNote = $appointment->sessionNotes()->first();
        if ($existingNote) {
            // If the note is empty, redirect to edit
            if (trim($existingNote->note) === '') {
                return redirect()->route('counselor.session_notes.edit', $existingNote->id)
                    ->with('info', 'Please complete the existing session note for this appointment.');
            }
            // Otherwise, redirect to show
            return redirect()->route('counselor.session_notes.show', $existingNote->id)
                ->with('info', 'A session note for this appointment already exists.');
        }

        // Count existing session notes for this appointment
        $existingSessionCount = $appointment->sessionNotes()->count();

        // Determine the next session number (1-based, so add 1 to existing count)
        $nextSessionNumber = $existingSessionCount + 1;

        // Determine which session options to show
        $availableSessions = [];
        for ($i = $nextSessionNumber; $i <= 4; $i++) {
            $availableSessions[] = $i;
        }

        return view('counselor.session_notes.create', compact('appointment', 'nextSessionNumber', 'availableSessions'));
    }

    // Store a session note
    public function store(Request $request, $appointmentId)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($appointmentId);

        // Prevent multiple session notes for the same appointment
        if ($appointment->sessionNotes()->exists()) {
            return redirect()->back()->with('info', 'A session note for this appointment already exists.');
        }

        // Session number = the order of this appointment for the student
        $studentId = $appointment->student_id;
        $appointments = Appointment::where('student_id', $studentId)
            ->orderBy('scheduled_at')
            ->pluck('id')
            ->toArray();
        $sessionNumber = array_search($appointment->id, $appointments) !== false ? array_search($appointment->id, $appointments) + 1 : 1;

        $request->validate([
            'note' => 'required|string',
            'next_session' => 'nullable|date|after:now',
        ]);

        $status = trim($request->note) !== '' ? SessionNote::STATUS_COMPLETED : SessionNote::STATUS_SCHEDULED;
        $sessionNote = SessionNote::create([
            'appointment_id' => $appointment->id,
            'counselor_id' => auth()->id(),
            'note' => $request->note,
            'session_number' => $sessionNumber,
            'next_session' => $request->next_session,
            'session_status' => $status,
        ]);

        return redirect()->route('counselor.session_notes.index')->with('success', 'Session note added successfully!');
    }

    // List all session notes for the counselor
    public function index(Request $request)
    {
        // Start query building
        $query = \App\Models\SessionNote::where('session_notes.counselor_id', auth()->id())
            ->with(['appointment.student']);

        // Filter by student name
        if ($request->filled('student')) {
            $query->whereHas('appointment.student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student . '%');
            });
        }

        // Filter by session status
        if ($request->filled('status')) {
            $query->where('session_status', $request->status);
        }

        // Filter by attendance
        if ($request->filled('attendance')) {
            $query->where('attendance', $request->attendance);
        }

        // Filter by time period (upcoming/past)
        if ($request->filled('filter')) {
            $query->whereHas('appointment', function ($q) use ($request) {
                if ($request->filter === 'upcoming') {
                    $q->where('scheduled_at', '>=', now());
                } elseif ($request->filter === 'past') {
                    $q->where('scheduled_at', '<', now());
                }
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereHas('appointment', function ($q) use ($request) {
                $q->where('scheduled_at', '>=', $request->date_from);
            });
        }
        if ($request->filled('date_to')) {
            $query->whereHas('appointment', function ($q) use ($request) {
                $q->where('scheduled_at', '<=', $request->date_to . ' 23:59:59');
            });
        }

        // Apply sorting
        $sort = $request->get('sort', 'date_desc');
        switch ($sort) {
            case 'date_asc':
                $query->join('appointments', 'session_notes.appointment_id', '=', 'appointments.id')
                    ->orderBy('appointments.scheduled_at', 'asc')
                    ->select('session_notes.*');
                break;
            case 'student_asc':
                $query->join('appointments', 'session_notes.appointment_id', '=', 'appointments.id')
                    ->join('users', 'appointments.student_id', '=', 'users.id')
                    ->orderBy('users.name', 'asc')
                    ->select('session_notes.*');
                break;
            case 'student_desc':
                $query->join('appointments', 'session_notes.appointment_id', '=', 'appointments.id')
                    ->join('users', 'appointments.student_id', '=', 'users.id')
                    ->orderBy('users.name', 'desc')
                    ->select('session_notes.*');
                break;
            case 'date_desc':
            default:
                $query->join('appointments', 'session_notes.appointment_id', '=', 'appointments.id')
                    ->orderBy('appointments.scheduled_at', 'desc')
                    ->select('session_notes.*');
                break;
        }

        $sessionNotes = $query->get();

        return view('counselor.session_notes.index', compact('sessionNotes'));
    }

    // Show a single session note
    public function show($id)
    {
        $note = \App\Models\SessionNote::with(['appointment.student'])->where('counselor_id', auth()->id())->findOrFail($id);
        return view('counselor.session_notes.show', compact('note'));
    }

    // Mark a session note as completed
    public function complete($id)
    {
        $note = SessionNote::where('counselor_id', auth()->id())->findOrFail($id);
        $note->update(['session_status' => SessionNote::STATUS_COMPLETED]);
        return redirect()->back()->with('success', 'Session marked as completed.');
    }

    // Show edit form for a session note (reschedule)
    public function edit($id)
    {
        $note = SessionNote::where('counselor_id', auth()->id())->findOrFail($id);
        return view('counselor.session_notes.edit', compact('note'));
    }

    // Update a session note (reschedule)
    public function update(Request $request, $id)
    {
        $note = SessionNote::where('counselor_id', auth()->id())->findOrFail($id);
        $data = [];

        if ($request->has('note')) {
            $data['note'] = $request->note;
            // If note is filled, mark as completed
            $data['session_status'] = trim($request->note) !== '' ? SessionNote::STATUS_COMPLETED : SessionNote::STATUS_SCHEDULED;
        }

        if ($request->has('next_session')) {
            $request->validate([
                'next_session' => 'nullable|date|after:now',
            ]);
            $data['next_session'] = $request->next_session;
            // If note is empty, keep as scheduled
            if (empty($data['session_status'])) {
                $data['session_status'] = SessionNote::STATUS_SCHEDULED;
            }
        }

        if ($request->has('attendance')) {
            $data['attendance'] = $request->attendance;
            if ($request->attendance === 'missed' && $request->has('absence_reason')) {
                $data['absence_reason'] = $request->absence_reason;
            } elseif ($request->attendance !== 'missed') {
                $data['absence_reason'] = null;
            }
        }

        $note->update($data);
        return redirect()->route('counselor.session_notes.index')->with('success', 'Session note updated successfully!');
    }

    // Send reminder notification to student
    public function remind($id)
    {
        $note = SessionNote::where('counselor_id', auth()->id())->with('appointment.student')->findOrFail($id);
        if ($note->appointment && $note->appointment->student) {
            $note->appointment->student->notify(new \App\Notifications\SessionReminderNotification($note, 'upcoming'));
        }
        return redirect()->back()->with('success', 'Reminder sent to student.');
    }

    // Show session history timeline for a student
    public function timeline($studentId)
    {
        $sessionNotes = \App\Models\SessionNote::whereHas('appointment', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })
            ->with(['appointment.student'])
            ->orderBy('session_number')
            ->get();
        $student = $sessionNotes->first() ? $sessionNotes->first()->appointment->student : null;
        return view('counselor.session_notes.timeline', compact('sessionNotes', 'student'));
    }

    // Manually create next appointment for a session note
    public function createNextAppointment($id)
    {
        $note = \App\Models\SessionNote::with(['appointment'])->where('counselor_id', auth()->id())->findOrFail($id);
        if (!$note->next_session) {
            return redirect()->back()->with('error', 'No next session date set.');
        }
        // Check if appointment already exists
        $existing = \App\Models\Appointment::where('counselor_id', $note->counselor_id)
            ->where('student_id', $note->appointment->student_id)
            ->where('scheduled_at', $note->next_session)
            ->first();
        if ($existing) {
            return redirect()->back()->with('info', 'Next appointment already exists.');
        }
        // Create new appointment for the next session
        $newAppointment = \App\Models\Appointment::create([
            'student_id' => $note->appointment->student_id,
            'counselor_id' => $note->counselor_id,
            'scheduled_at' => $note->next_session,
            'status' => 'pending',
            'notes' => "Auto-created from session note #{$note->id}",
        ]);
        // Session number = the order of this appointment for the student
        $studentId = $note->appointment->student_id;
        $appointments = Appointment::where('student_id', $studentId)
            ->orderBy('scheduled_at')
            ->pluck('id')
            ->toArray();
        $sessionNumber = array_search($newAppointment->id, $appointments) !== false ? array_search($newAppointment->id, $appointments) + 1 : 1;
        // Prevent duplicate session notes for the same appointment
        if ($newAppointment->sessionNotes()->exists()) {
            return redirect()->back()->with('info', 'A session note for this appointment already exists.');
        }
        \App\Models\SessionNote::create([
            'appointment_id' => $newAppointment->id,
            'counselor_id' => $note->counselor_id,
            'note' => '', // Counselor will fill this after session
            'session_number' => $sessionNumber,
            'next_session' => null,
            'session_status' => \App\Models\SessionNote::STATUS_SCHEDULED,
        ]);
        return redirect()->back()->with('success', 'Next appointment and session created successfully!');
    }
}
