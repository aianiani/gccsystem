<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SeminarAttendance;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('student');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->has('year_level') && $request->year_level) {
            $query->where('year_level', $request->year_level);
        }

        if ($request->has('college') && $request->college) {
            $query->where('college', 'like', '%' . $request->college . '%');
        }

        $students = $query->paginate(10)->withQueryString();

        return view('counselor.guidance.index', compact('students'));
    }

    public function show(User $student)
    {
        if (!$student->hasRole('student')) {
            abort(404);
        }

        $attendances = SeminarAttendance::where('user_id', $student->id)->get();

        $attendanceMatrix = [];
        foreach ($attendances as $attendance) {
            $attendanceMatrix[$attendance->year_level][$attendance->seminar_name] = [
                'attended' => true,
                'schedule_id' => $attendance->seminar_schedule_id,
            ];
        }

        $seminars = \App\Models\Seminar::with('schedules')->get();

        return view('counselor.guidance.show', compact('student', 'attendanceMatrix', 'seminars'));
    }

    public function update(Request $request, User $student)
    {
        $request->validate([
            'seminar_name' => 'required|string',
            'year_level' => 'required|integer|min:1|max:4',
            'attended' => 'required|boolean',
            'seminar_schedule_id' => 'nullable|exists:seminar_schedules,id',
        ]);

        if ($request->attended) {
            SeminarAttendance::updateOrCreate(
                [
                    'user_id' => $student->id,
                    'seminar_name' => $request->seminar_name,
                    'year_level' => $request->year_level,
                ],
                [
                    'attended_at' => now(),
                    'seminar_schedule_id' => $request->seminar_schedule_id,
                ]
            );
        } else {
            SeminarAttendance::where('user_id', $student->id)
                ->where('seminar_name', $request->seminar_name)
                ->where('year_level', $request->year_level)
                ->delete();
        }

        return response()->json(['success' => true]);
    }

    public function updateProfile(Request $request, User $student)
    {
        $request->validate([
            'student_id' => 'nullable|string|max:255',
            'year_level' => 'required|integer|min:1|max:4',
            'college' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,other',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $student->update([
            'student_id' => $request->student_id,
            'year_level' => $request->year_level,
            'college' => $request->college,
            'course' => $request->course,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->back()->with('success', 'Student profile updated successfully.');
    }
}
