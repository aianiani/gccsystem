<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Show all appointments for the authenticated student
    public function index()
    {
        $appointments = Appointment::where('student_id', auth()->id())->with('counselor')->orderBy('scheduled_at', 'desc')->get();
        return view('appointments.index', compact('appointments'));
    }

    // Show form to create a new appointment
    public function create()
    {
        $counselors = User::where('role', 'counselor')->get();
        return view('appointments.create', compact('counselors'));
    }

    // Store a new appointment
    public function store(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);
        Appointment::create([
            'student_id' => auth()->id(),
            'counselor_id' => $request->counselor_id,
            'scheduled_at' => $request->scheduled_at,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);
        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }
}
