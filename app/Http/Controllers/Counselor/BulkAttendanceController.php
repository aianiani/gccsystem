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
        // $seminars and $colleges are now handled directly in the view or via static lists
        // to ensure all options are always available.
        $students = collect();

        if ($request->has('year_level') && $request->has('seminar_name')) {
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
                $query->where('college', 'like', '%' . $request->college . '%');
            }

            $students = $query->orderBy('name')->get();
        }

        return view('counselor.guidance.bulk_create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seminar_name' => 'required|exists:seminars,name',
            'year_level' => 'nullable|integer|min:1|max:6',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $seminar = Seminar::where('name', $request->seminar_name)->firstOrFail();
        $status = $request->input('status', 'unlocked'); // Default to unlocked if not specified, but UI should specify.

        // Merge manual selections with session-based selections
        $manualIds = $request->input('student_ids', []);
        $sessionIds = session('guidance_selected_ids', []);
        $allIds = array_unique(array_merge($manualIds, $sessionIds));

        if (empty($allIds)) {
            return redirect()->back()->with('error', 'No students selected.');
        }

        foreach ($allIds as $studentId) {
            $student = User::find($studentId);
            if (!$student)
                continue;

            // Map seminars to their target curriculum year
            $seminarYearMap = [
                'New Student Orientation Program' => 1,
                'IDREAMS' => 1,
                '10C' => 2,
                'LEADS' => 3,
                'IMAGE' => 4,
            ];

            // Use mapped year if available, otherwise fallback to student's year level or request
            $targetYearLevel = $seminarYearMap[$request->seminar_name] ?? ($student->year_level ?? ($request->year_level ?: 1));

            // Extract integer from year level if needed (though map values are ints)
            $targetYearLevel = (int) filter_var($targetYearLevel, FILTER_SANITIZE_NUMBER_INT);

            // Safety check: if extraction failed or result is 0/empty, fallback to 1 or log error
            if ($targetYearLevel < 1 || $targetYearLevel > 6) {
                // Try to fallback to request or just default to 1 if we really can't determine it. 
                // But for now let's just default to 1 to prevent crash, or maybe skip?
                // Let's fallback to 1 as safe default if data is messy
                $targetYearLevel = 1;
            }

            $attendance = SeminarAttendance::where([
                'user_id' => $studentId,
                'seminar_name' => $request->seminar_name,
                'year_level' => $targetYearLevel,
            ])->first();

            if (!$attendance || $attendance->status !== 'completed') {
                $statusToApply = $status;

                $attendance = SeminarAttendance::updateOrCreate([
                    'user_id' => $studentId,
                    'seminar_name' => $request->seminar_name,
                    'year_level' => $targetYearLevel,
                ], [
                    'attended_at' => now(),
                    'status' => $statusToApply,
                ]);

                if ($statusToApply === 'unlocked') {
                    $student->notify(new \App\Notifications\SeminarUnlocked($request->seminar_name));
                }
            }
        }

        // Clear session after bulk action
        session()->forget(['guidance_selected_ids', 'guidance_target_seminar', 'guidance_target_year']);

        $redirectParams = ['seminar_name' => $request->seminar_name];
        if ($request->filled('year_level')) {
            $redirectParams['year_level'] = $request->year_level;
        }

        return redirect()->route('counselor.guidance.index', $redirectParams)
            ->with('success', 'Bulk attendance marked successfully for ' . count($allIds) . ' students.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'seminar_name' => 'required|exists:seminars,name',
            'year_level' => 'required|integer|min:1|max:4',
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $seminarName = $request->seminar_name;
        $yearLevel = $request->year_level;
        $file = $request->file('csv_file');

        if (($handle = fopen($file->getRealPath(), 'r')) === false) {
            return redirect()->back()->with('error', 'Could not open CSV file.');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return redirect()->back()->with('error', 'Empty CSV file.');
        }

        $header = array_map('strtolower', $header);
        $idIndex = array_search('student_id', $header);
        if ($idIndex === false)
            $idIndex = array_search('id_number', $header);
        if ($idIndex === false)
            $idIndex = array_search('id', $header);
        if ($idIndex === false)
            $idIndex = 0;

        $studentIdsFromCsv = [];
        while (($row = fgetcsv($handle)) !== false) {
            if (isset($row[$idIndex])) {
                $val = trim($row[$idIndex]);
                if (!empty($val))
                    $studentIdsFromCsv[] = $val;
            }
        }
        fclose($handle);

        if (empty($studentIdsFromCsv)) {
            return redirect()->back()->with('error', 'No student IDs found in the CSV.');
        }

        // Fetch user internal IDs
        $students = User::role('student')
            ->whereIn('student_id', $studentIdsFromCsv)
            ->get(['id', 'student_id']);

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No matching students found in the database. Please verify the IDs in your CSV.');
        }

        $foundStudentIds = $students->pluck('id')->toArray();
        $missingIdsCount = count(array_diff($studentIdsFromCsv, $students->pluck('student_id')->toArray()));

        // Store selections and target details in session
        session([
            'guidance_selected_ids' => $foundStudentIds,
            'guidance_target_seminar' => $seminarName,
            'guidance_target_year' => $yearLevel,
        ]);

        $message = "CSV Scanned: " . count($foundStudentIds) . " students found and selected across pages.";
        if ($missingIdsCount > 0) {
            $message .= " Note: $missingIdsCount IDs were not found.";
        }

        return redirect()->route('counselor.guidance.index', [
            'year_level' => $yearLevel,
            'seminar_name' => $seminarName,
        ])->with('success', $message);
    }
}
