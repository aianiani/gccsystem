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

        // Check if the counselor is available at the requested time
        $availability = \DB::table('availabilities')
            ->where('user_id', $request->counselor_id)
            ->where('start', '<=', $request->scheduled_at)
            ->where('end', '>', $request->scheduled_at)
            ->first();
        if (!$availability) {
            return redirect()->back()->withErrors(['scheduled_at' => 'The counselor is not available at the selected time.']);
        }

        // Check if the slot is already booked
        $alreadyBooked = \App\Models\Appointment::where('counselor_id', $request->counselor_id)
            ->where('scheduled_at', $request->scheduled_at)
            ->exists();
        if ($alreadyBooked) {
            return redirect()->back()->withErrors(['scheduled_at' => 'This slot is already booked.']);
        }

        \App\Models\Appointment::create([
            'student_id' => auth()->id(),
            'counselor_id' => $request->counselor_id,
            'scheduled_at' => $request->scheduled_at,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);
        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
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
            $start = strtotime($availability->start);
            $end = strtotime($availability->end);
            // 30-minute slots
            for ($time = $start; $time < $end; $time += 1800) {
                $slot = date('Y-m-d\TH:i', $time);
                if (!in_array($slot, $booked)) {
                    $slots[] = $slot;
                }
            }
        }
        return response()->json($slots);
    }
}
