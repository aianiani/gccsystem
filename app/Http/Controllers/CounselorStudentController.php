<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SeminarAttendance;
use Illuminate\Http\Request;

class CounselorStudentController extends Controller
{
    /**
     * Display a listing of students with filtering options
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student');

        // Filter by college
        if ($request->filled('college')) {
            $query->where('college', 'like', '%' . $request->college . '%');
        }

        // Filter by course
        if ($request->filled('course')) {
            $query->where('course', 'like', '%' . $request->course . '%');
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by year level
        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('student_id', 'like', '%' . $search . '%');
            });
        }

        $students = $query->with([
            'assessments' => function ($q) {
                $q->latest()->take(1);
            }
        ])->orderBy('name')->paginate(15);

        // Get unique values for filter dropdowns
        $colleges = User::where('role', 'student')
            ->whereNotNull('college')
            ->distinct()
            ->pluck('college')
            ->filter()
            ->sort()
            ->values();



        $yearLevels = User::where('role', 'student')
            ->whereNotNull('year_level')
            ->distinct()
            ->pluck('year_level')
            ->filter()
            ->sort()
            ->values();

        // Summary Statistics
        $totalStudents = User::where('role', 'student')->count();

        // Year Level Counts
        $rawYearStats = User::where('role', 'student')
            ->selectRaw('year_level, count(*) as count')
            ->groupBy('year_level')
            ->pluck('count', 'year_level')
            ->toArray();

        // Normalize keys (e.g., "1st Year" -> 1)
        $yearStats = [];
        foreach ($rawYearStats as $key => $value) {
            // Extract the first digit
            if (preg_match('/(\d+)/', $key, $matches)) {
                $yearStats[$matches[1]] = $value;
            } else {
                // specific fallback or ignore nulls
                // For now, let's assume if it has a number, that's the year.
            }
        }

        // Gender Counts
        $genderStats = User::where('role', 'student')
            ->selectRaw('gender, count(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        return view('counselor.students.index', compact('students', 'colleges', 'yearLevels', 'totalStudents', 'yearStats', 'genderStats'));
    }

    /**
     * Display the specified student
     */
    public function show(User $student)
    {
        // Ensure the user is a student
        if ($student->role !== 'student') {
            abort(404);
        }

        $assessments = $student->assessments()->latest()->get();
        $appointments = $student->appointments()
            ->where('counselor_id', auth()->id())
            ->with('sessionNotes')
            ->latest()
            ->get();

        $attendances = SeminarAttendance::where('user_id', $student->id)->get();

        $attendanceMatrix = [];
        foreach ($attendances as $attendance) {
            $attendanceMatrix[$attendance->year_level][$attendance->seminar_name] = [
                'attended' => true,
                'schedule_id' => $attendance->seminar_schedule_id,
            ];
        }

        return view('counselor.students.show', compact('student', 'assessments', 'appointments', 'attendanceMatrix'));
    }
}

