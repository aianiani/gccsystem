<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use App\Models\SeminarSchedule;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    public function index()
    {
        $seminars = Seminar::with('schedules')->get();
        return view('counselor.seminars.index', compact('seminars'));
    }

    public function create()
    {
        return view('counselor.seminars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_year_level' => 'required|integer|min:1|max:4',
        ]);

        Seminar::create($request->all());

        return redirect()->route('counselor.seminars.index')->with('success', 'Seminar created successfully.');
    }

    public function edit(Seminar $seminar)
    {
        return view('counselor.seminars.edit', compact('seminar'));
    }

    public function update(Request $request, Seminar $seminar)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_year_level' => 'required|integer|min:1|max:4',
        ]);

        $seminar->update($request->all());

        return redirect()->route('counselor.seminars.index')->with('success', 'Seminar updated successfully.');
    }

    public function destroy(Seminar $seminar)
    {
        $seminar->delete();
        return redirect()->route('counselor.seminars.index')->with('success', 'Seminar deleted successfully.');
    }

    public function storeSchedule(Request $request, Seminar $seminar)
    {
        $request->validate([
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'session_type' => 'required|in:Morning,Afternoon',
            'colleges' => 'required|array',
        ]);

        $seminar->schedules()->create($request->all());

        return back()->with('success', 'Schedule added successfully.');
    }

    public function destroySchedule(SeminarSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Schedule deleted successfully.');
    }
}
