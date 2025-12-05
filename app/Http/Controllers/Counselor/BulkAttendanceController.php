<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seminar;
use App\Models\SeminarAttendance;
use Illuminate\Http\Request;

class BulkAttendanceController extends Controller
{
    public function create(Request $request)
    {
        $seminars = Seminar::all();
        $students = collect();

        $colleges = User::role('student')
            ->whereNotNull('college')
            ->distinct()
            ->pluck('college')
            ->filter()
            ->sort()
            ->values();

        if ($request->has('year_level') && $request->has('seminar_id')) {
            $yearLevel = $request->year_level;
            $query = User::role('student')
                ->where(function ($q) use ($yearLevel) {
                    $q->where('year_level', $yearLevel)
                        ->orWhere('year_level', (string) $yearLevel)
                        ->orWhere('year_level', $yearLevel . 'st Year')
                        ->orWhere('year_level', $yearLevel . 'nd Year')
                        ->orWhere('year_level', $yearLevel . 'rd Year')
                        ->orWhere('year_level', $yearLevel . 'th Year');
                });

            if ($request->has('college') && $request->college) {
                $query->where('college', $request->college);
            }

            $students = $query->orderBy('name')->get();
        }

        return view('counselor.guidance.bulk_create', compact('seminars', 'students', 'colleges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seminar_id' => 'required|exists:seminars,id',
            'year_level' => 'required|integer|min:1|max:4',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $seminar = Seminar::findOrFail($request->seminar_id);

        foreach ($request->student_ids as $studentId) {
            SeminarAttendance::firstOrCreate([
                'user_id' => $studentId,
                'seminar_name' => $seminar->name, // Keeping name for backward compatibility/simplicity
                'year_level' => $request->year_level,
            ], [
                'attended_at' => now(),
            ]);
        }

        return redirect()->route('counselor.guidance.index')
            ->with('success', 'Bulk attendance marked successfully for ' . count($request->student_ids) . ' students.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'seminar_id' => 'required|exists:seminars,id',
            'year_level' => 'required|integer|min:1|max:4',
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $seminar = Seminar::findOrFail($request->seminar_id);
        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data); // Assume first row is header

        // Normalize header to lowercase
        $header = array_map('strtolower', $header);

        // Find the index of the ID column
        $idIndex = array_search('student_id', $header);
        if ($idIndex === false) {
            $idIndex = array_search('id_number', $header);
        }
        if ($idIndex === false) {
            $idIndex = array_search('id', $header);
        }

        // If no header match found, fallback to first column if it looks like an ID
        if ($idIndex === false) {
            // If the header row itself looks like data (e.g. numeric), maybe there is no header?
            // For safety, let's require a header or assume column 0 if user forces it.
            // For now, let's assume column 0.
            $idIndex = 0;
            // Re-add the header row to data if we think it might be data
            // But usually CSVs have headers. Let's stick to searching or defaulting to 0.
        }

        $count = 0;
        $errors = [];

        foreach ($data as $row) {
            if (!isset($row[$idIndex]))
                continue;

            $studentIdNumber = trim($row[$idIndex]);
            if (empty($studentIdNumber))
                continue;

            $student = User::role('student')->where('student_id', $studentIdNumber)->first();

            if ($student) {
                SeminarAttendance::firstOrCreate([
                    'user_id' => $student->id,
                    'seminar_name' => $seminar->name,
                    'year_level' => $request->year_level,
                ], [
                    'attended_at' => now(),
                ]);
                $count++;
            } else {
                $errors[] = $studentIdNumber;
            }
        }

        $message = "Successfully imported attendance for $count students.";
        if (count($errors) > 0) {
            $message .= " Could not find " . count($errors) . " students (IDs: " . implode(', ', array_slice($errors, 0, 5)) . (count($errors) > 5 ? '...' : '') . ").";
        }

        return redirect()->route('counselor.guidance.index')->with('success', $message);
    }
}
