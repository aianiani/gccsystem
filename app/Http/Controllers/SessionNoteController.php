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
        return view('counselor.session_notes.create', compact('appointment'));
    }

    // Store a session note
    public function store(Request $request, $appointmentId)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->findOrFail($appointmentId);
        $request->validate([
            'note' => 'required|string',
        ]);
        SessionNote::create([
            'appointment_id' => $appointment->id,
            'counselor_id' => auth()->id(),
            'note' => $request->note,
        ]);
        return redirect()->route('counselor.appointments.show', $appointment->id)->with('success', 'Session note added successfully!');
    }
}
