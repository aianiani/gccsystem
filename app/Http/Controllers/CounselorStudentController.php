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

        // Filter by sex
        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
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

        // Standardized per_page
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 30, 50, 100]) ? $perPage : 10;

        $students = $query->with([
            'assessments' => function ($q) {
                $q->latest()->take(1);
            }
        ])->orderBy('name')
            ->paginate($perPage)
            ->appends($request->except('page'));

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

        // Sex Counts
        $sexStats = User::where('role', 'student')
            ->selectRaw('sex, count(*) as count')
            ->groupBy('sex')
            ->pluck('count', 'sex')
            ->toArray();

        return view('counselor.students.index', compact('students', 'colleges', 'yearLevels', 'totalStudents', 'yearStats', 'sexStats'));
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

    /**
     * Send a bulk message to selected students
     */
    public function bulkMessage(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $students = User::whereIn('id', $request->ids)->where('role', 'student')->get();
        $senderId = auth()->id();

        foreach ($students as $student) {
            \App\Models\Message::create([
                'sender_id' => $senderId,
                'recipient_id' => $student->id,
                'content' => $request->message,
                'is_read' => false,
            ]);
        }

        return redirect()->back()->with('success', count($students) . ' messages sent successfully.');
    }

    /**
     * Export selected students to CSV
     */
    public function bulkExport(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
        ]);

        $students = User::whereIn('id', $request->ids)
            ->where('role', 'student')
            ->orderBy('name')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students_export_' . now()->format('Ymd_His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Student ID', 'Name', 'Email', 'College', 'Course', 'Year Level', 'Sex', 'Join Date']);

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_id,
                    $student->name,
                    $student->email,
                    $student->college,
                    $student->course,
                    $student->year_level,
                    $student->sex,
                    $student->created_at->format('Y-m-d')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

