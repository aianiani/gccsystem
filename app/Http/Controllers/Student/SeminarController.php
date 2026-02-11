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
        $mandatorySeminars = ['IDREAMS', '10C', 'LEADS', 'IMAGE', 'New Student Orientation Program'];

        $seminars = Seminar::whereIn('name', $mandatorySeminars)
            ->with([
                'evaluations' => function ($query) {
                    $query->where('user_id', Auth::id());
                }
            ])
            ->get();

        // Define explicit order for display
        $seminarOrder = [
            'New Student Orientation Program' => 1,
            'IDREAMS' => 2,
            '10C' => 3,
            'LEADS' => 4,
            'IMAGE' => 5,
        ];

        // Sort collection by defined order
        $seminars = $seminars->sortBy(function ($seminar) use ($seminarOrder) {
            return $seminarOrder[$seminar->name] ?? 99;
        });

        // Map to include 'is_evaluated' and 'is_unlocked' flags
        $seminars->transform(function ($seminar) {
            $seminar->is_evaluated = $seminar->evaluations->isNotEmpty();

            // Check if there's an attendance record that is at least 'unlocked'
            $attendance = SeminarAttendance::where('user_id', Auth::id())
                ->where('seminar_name', $seminar->name)
                ->first();

            $seminar->is_unlocked = $attendance && ($attendance->status === 'unlocked' || $attendance->status === 'completed');
            $seminar->attendance_status = $attendance ? $attendance->status : null;

            // Extra check: If status is 'attended', it is NOT unlocked.
            if ($attendance && $attendance->status === 'attended') {
                $seminar->is_unlocked = false;
            }

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

        if ($seminar->name === 'New Student Orientation Program') {
            $rules['comments'] = 'required|string';
            foreach (range(1, 25) as $i) {
                $rules["answers.q$i"] = 'required|string';
            }
            foreach (range(1, 5) as $i) {
                $rules["answers.c$i"] = 'required|integer|min:1|max:5';
            }
            // CC
            $rules['answers.cc1'] = 'required|string';
            $rules['answers.cc2'] = 'required|string';
            $rules['answers.cc3'] = 'required|string';
            // SQD
            foreach (range(0, 8) as $i) {
                $rules["answers.sqd$i"] = 'required|string';
            }
        }

        $request->validate($rules);

        // Double check evaluation existence to prevent duplicates
        if ($seminar->evaluations()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('student.seminars.index')
                ->with('error', 'You have already evaluated this seminar.');
        }

        $rating = $request->rating;
        // Calculate average rating from satisfaction criteria for all with criteria
        if (in_array($seminar->name, ['IMAGE', 'IDREAMS', '10C', 'LEADS', 'New Student Orientation Program']) && isset($request->answers)) {
            $criteria = ['c1', 'c2', 'c3', 'c4', 'c5'];
            $total = 0;
            foreach ($criteria as $c) {
                if (isset($request->answers[$c])) {
                    $total += $request->answers[$c];
                }
            }
            $rating = count($criteria) > 0 ? round($total / count($criteria)) : 5;
        }

        if ($seminar->name === 'New Student Orientation Program') {
            // Scoring Logic
            $correctAnswers = [
                'q1' => 'Irregular Student',
                'q2' => 'A grade of W',
                'q3' => 'The student was not able to get a score of 50% or higher in the removal examination', // Standardized typo/correction
                'q4' => 'Gender and Development Service Unit',
                'q5' => 'Guidance and Counseling Center',
                'q6' => 'Fraternities and Sororities',
                'q7' => '1.0000-1.4500', // Standardized to hyphen
                'q8' => 'GWA of 2.5 or better',
                'q9' => 'University Hospital',
                'q10' => 'All of the above',
                'q11' => 'University Center for Gender and Development',
                'q12' => 'Facilitates the licensing and renewal of firearms in the university',
                'q13' => 'Mandates to administer and implement the Data Privacy Act, and to monitor and ensure compliance',
                'q14' => 'Consent',
                'q15' => 'Data Transformation Office',
                'q16' => 'Sidlak',
                'q17' => 'To represent the students who are pursuing legal cases',
                'q18' => 'Environmental Science',
                'q19' => 'mind - true heart', // Standardized to hyphen
                'q20' => 'bulwark - fatherland', // Standardized to hyphen
                'q21' => 'R.A. No. 11053',
                'q22' => 'Initiation rite',
                'q23' => 'Hazing',
                'q24' => 'None of the above',
                'q25' => 'Only choices A, B, and C',
            ];

            $score = 0;
            $userAnswers = $request->input('answers');

            // Normalize function for comparison
            $normalize = function ($str) {
                $str = str_replace('–', '-', $str); // En dash to hyphen
                return trim($str);
            };

            foreach ($correctAnswers as $q => $correct) {
                if (isset($userAnswers[$q])) {
                    if ($normalize($userAnswers[$q]) === $normalize($correct)) {
                        $score++;
                    }
                }
            }

            $passed = $score >= 14;
            $finalAnswers = array_merge($userAnswers, ['score' => $score, 'passed' => $passed]);

            SeminarEvaluation::create([
                'seminar_id' => $seminar->id,
                'user_id' => Auth::id(),
                'rating' => $rating,
                'comments' => $request->comments,
                'answers' => $finalAnswers,
            ]);

            if (!$passed) {
                // Do NOT mark attendance as completed.
                // Just return with error.
                return redirect()->route('student.seminars.index')
                    ->with('error', "You scored $score/25. You failed to pass (requires 14). There will be no issuance of certificate. Please take the re-take Post-test via the QR Code included in the Enrollment Process.");
            }

            // If passed, proceed to mark attendance as completed (common logic below)
        } else {
            // For other seminars, simply create evaluation
            SeminarEvaluation::create([
                'seminar_id' => $seminar->id,
                'user_id' => Auth::id(),
                'rating' => $rating,
                'comments' => $request->comments,
                'answers' => $request->answers,
            ]);
        }

        // Mark attendance as completed
        SeminarAttendance::where('user_id', Auth::id())
            ->where('seminar_name', $seminar->name)
            ->update(['status' => 'completed']);

        return redirect()->route('student.seminars.index')
            ->with('success', 'Thank you for your feedback! Your evaluation has been submitted.');
    }
}
