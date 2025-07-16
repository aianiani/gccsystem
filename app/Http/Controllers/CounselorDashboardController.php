<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class CounselorDashboardController extends Controller
{
    // Show all appointments assigned to the authenticated counselor
    public function index()
    {
        $appointments = Appointment::where('counselor_id', auth()->id())->with('student')->orderBy('scheduled_at', 'desc')->get();
        return view('counselor.appointments.index', compact('appointments'));
    }

    // Show details for a specific appointment
    public function show($id)
    {
        $appointment = Appointment::where('counselor_id', auth()->id())->with('student')->findOrFail($id);
        return view('counselor.appointments.show', compact('appointment'));
    }
}
