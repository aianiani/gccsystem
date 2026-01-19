<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use App\Models\SeminarEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SeminarAttendance;

class SeminarController extends Controller
{
    public function index()
    {
        $mandatorySeminars = ['IDREAMS', '10C', 'LEADS', 'IMAGE'];

        $seminars = Seminar::whereIn('name', $mandatorySeminars)
            ->with([
                'evaluations' => function ($query) {
                    $query->where('user_id', Auth::id());
                }
            ])
            // Ensure consistent ordering based on target year level
            ->orderBy('target_year_level')
            ->get();

        // Map to include 'is_evaluated' and 'is_unlocked' flags
        $seminars->transform(function ($seminar) {
            $seminar->is_evaluated = $seminar->evaluations->isNotEmpty();

            // Check if there's an attendance record that is at least 'unlocked'
            $attendance = SeminarAttendance::where('user_id', Auth::id())
                ->where('seminar_name', $seminar->name)
                ->first();

            $seminar->is_unlocked = $attendance && ($attendance->status === 'unlocked' || $attendance->status === 'completed');
            $seminar->attendance_status = $attendance ? $attendance->status : null;

            return $seminar;
        });

        return view('student.seminars.index', compact('seminars'));
    }

    public function create(Seminar $seminar)
    {
        // Check if already evaluated
        if ($seminar->evaluations()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('student.seminars.index')
                ->with('error', 'You have already evaluated this seminar.');
        }

        // Check if unlocked by counselor
        $attendance = SeminarAttendance::where('user_id', Auth::id())
            ->where('seminar_name', $seminar->name)
            ->first();

        if (!$attendance || ($attendance->status !== 'unlocked' && $attendance->status !== 'completed')) {
            return redirect()->route('student.seminars.index')
                ->with('error', 'This evaluation is locked. Please attend the seminar first or wait for the counselor to verify your attendance.');
        }

        return view('student.seminars.evaluate', compact('seminar'));
    }

    public function store(Request $request, Seminar $seminar)
    {
        $rules = [
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
            'answers' => 'nullable|array',
        ];

        if ($seminar->name === 'IMAGE') {
            $rules['comments'] = 'required|string';
            $rules['answers.q1'] = 'required|string';
            $rules['answers.q2'] = 'required|string';
            $rules['answers.q3'] = 'required|string';
            $rules['answers.q4'] = 'required|string';
            $rules['answers.q5'] = 'required|string';
            $rules['answers.q6'] = 'required|string';
            $rules['answers.c1'] = 'required|integer|min:1|max:5';
            $rules['answers.c2'] = 'required|integer|min:1|max:5';
            $rules['answers.c3'] = 'required|integer|min:1|max:5';
            $rules['answers.c4'] = 'required|integer|min:1|max:5';
            $rules['answers.c5'] = 'required|integer|min:1|max:5';
        }

        if ($seminar->name === 'IDREAMS') {
            $rules['comments'] = 'required|string';
            $rules['answers.q1'] = 'required|string';
            $rules['answers.q2'] = 'required|string';
            $rules['answers.q3'] = 'required|string';
            $rules['answers.q4'] = 'required|string';
            $rules['answers.c1'] = 'required|integer|min:1|max:5';
            $rules['answers.c2'] = 'required|integer|min:1|max:5';
            $rules['answers.c3'] = 'required|integer|min:1|max:5';
            $rules['answers.c4'] = 'required|integer|min:1|max:5';
            $rules['answers.c5'] = 'required|integer|min:1|max:5';
        }

        if ($seminar->name === '10C') {
            $rules['comments'] = 'required|string';
            foreach (range(1, 5) as $i) {
                $rules["answers.q$i"] = 'required|string';
            }
            foreach (range(1, 5) as $i) {
                $rules["answers.c$i"] = 'required|integer|min:1|max:5';
            }
        }

        if ($seminar->name === 'LEADS') {
            $rules['comments'] = 'required|string';
            foreach (range(1, 10) as $i) {
                $rules["answers.q$i"] = 'required|string';
            }
            foreach (range(1, 5) as $i) {
                $rules["answers.c$i"] = 'required|integer|min:1|max:5';
            }
        }

        $request->validate($rules);

        // Double check evaluation existence to prevent duplicates
        if ($seminar->evaluations()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('student.seminars.index')
                ->with('error', 'You have already evaluated this seminar.');
        }

        $rating = $request->rating;
        if (in_array($seminar->name, ['IMAGE', 'IDREAMS', '10C', 'LEADS']) && isset($request->answers)) {
            // Calculate average rating from satisfaction criteria
            $criteria = ['c1', 'c2', 'c3', 'c4', 'c5'];
            $total = 0;
            foreach ($criteria as $c) {
                $total += $request->answers[$c] ?? 0;
            }
            $rating = round($total / count($criteria));
        }

        SeminarEvaluation::create([
            'seminar_id' => $seminar->id,
            'user_id' => Auth::id(),
            'rating' => $rating,
            'comments' => $request->comments,
            'answers' => $request->answers,
        ]);

        // Mark attendance as completed
        SeminarAttendance::where('user_id', Auth::id())
            ->where('seminar_name', $seminar->name)
            ->update(['status' => 'completed']);

        return redirect()->route('student.seminars.index')
            ->with('success', 'Thank you for your feedback! Your evaluation has been submitted.');
    }
}
