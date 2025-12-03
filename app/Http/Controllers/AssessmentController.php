<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AssessmentController extends Controller
{
    // Show the assessments page for students
    public function index()
    {
        return view('assessments', [
            'dass42_questions' => $this->getDass42Questions(),
            'academic_questions' => $this->getAcademicQuestions(),
            'wellness_questions' => $this->getWellnessQuestions(),
        ]);
    }

    // Show dedicated DASS-42 assessment page
    public function dass42Page()
    {
        // Require consent first
        if (!auth()->user() || !auth()->user()->consent_agreed) {
            return redirect()->route('consent.show')
                ->with('error', 'Please agree to the consent information before taking the assessment.');
        }

        return view('assessments.dass42', [
            'dass42_questions' => $this->getDass42Questions(),
        ]);
    }

    // Handle DASS-42 form submission
    public function submitDass42(Request $request)
    {
        $request->validate([
            'answers' => 'required|array|size:42',
            'answers.*' => 'required|in:0,1,2,3',
        ]);
        $answers = $request->input('answers');
        // DASS-42 scoring: 14 questions per scale (0-indexed)
        // Standard DASS-42 mapping (1-indexed to 0-indexed conversion):
        // Depression: 3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42 (1-indexed)
        // Anxiety: 2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41 (1-indexed)
        // Stress: 1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39 (1-indexed)
        // Converting to 0-indexed:
        $depression_idx = [2, 4, 9, 12, 15, 16, 20, 23, 25, 30, 33, 36, 37, 41];
        $anxiety_idx = [1, 3, 6, 8, 14, 18, 19, 22, 24, 27, 29, 35, 39, 40];
        $stress_idx = [0, 5, 7, 10, 11, 13, 17, 21, 26, 28, 31, 32, 34, 38];
        $depression = array_sum(array_intersect_key($answers, array_flip($depression_idx)));
        $anxiety = array_sum(array_intersect_key($answers, array_flip($anxiety_idx)));
        $stress = array_sum(array_intersect_key($answers, array_flip($stress_idx)));
        // Determine risk level based on DASS-42 interpretation guide
        // Map the worst subscale severity to a risk category with finer granularity:
        // Normal -> low
        // Mild -> low-moderate
        // Moderate -> moderate
        // Severe -> high
        // Extremely Severe -> very-high
        $depression_severity = $depression >= 28 ? 'Extremely Severe' : ($depression >= 21 ? 'Severe' : ($depression >= 14 ? 'Moderate' : ($depression >= 10 ? 'Mild' : 'Normal')));
        $anxiety_severity = $anxiety >= 20 ? 'Extremely Severe' : ($anxiety >= 15 ? 'Severe' : ($anxiety >= 10 ? 'Moderate' : ($anxiety >= 8 ? 'Mild' : 'Normal')));
        $stress_severity = $stress >= 34 ? 'Extremely Severe' : ($stress >= 26 ? 'Severe' : ($stress >= 19 ? 'Moderate' : ($stress >= 15 ? 'Mild' : 'Normal')));

        // severity ranking
        $severity_rank = ['Normal' => 0, 'Mild' => 1, 'Moderate' => 2, 'Severe' => 3, 'Extremely Severe' => 4];
        $worst = max(
            $severity_rank[$depression_severity] ?? 0,
            $severity_rank[$anxiety_severity] ?? 0,
            $severity_rank[$stress_severity] ?? 0
        );

        $risk_level = 'low';
        if ($worst === 0) {
            $risk_level = 'low';
        } elseif ($worst === 1) {
            $risk_level = 'low-moderate';
        } elseif ($worst === 2) {
            $risk_level = 'moderate';
        } elseif ($worst === 3) {
            $risk_level = 'high';
        } elseif ($worst === 4) {
            $risk_level = 'very-high';
        }
        $comment = $request->input('student_comment');

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'DASS-42',
            'score' => json_encode(['depression'=>$depression,'anxiety'=>$anxiety,'stress'=>$stress]),
            'risk_level' => $risk_level,
            'student_comment' => $comment,
        ]);
        
        // After completing the assessment send user to booking (appointments.create)
        return redirect()->route('appointments.create')
            ->with('success', 'DASS-42 assessment completed successfully. You may now continue to booking.');
    }

    // Counselor: View all DASS-42 assessment results
    public function counselorIndex()
    {
        // Only allow counselors
        if (!auth()->user()->isCounselor()) {
            abort(403);
        }
        $assessments = \App\Models\Assessment::with('user')
            ->orderByDesc('created_at')
            ->paginate(20);
        return view('counselor.assessments.index', compact('assessments'));
    }

    // Handle Academic Stress Survey submission
    public function submitAcademicSurvey(Request $request)
    {
        $request->validate([
            'academic_answers' => 'required|array|size:15',
            'academic_answers.*' => 'required|in:0,1,2,3',
        ]);
        $score = array_sum($request->input('academic_answers'));
        $risk_level = 'normal';
        if ($score >= 30) {
            $risk_level = 'high';
        } elseif ($score >= 20) {
            $risk_level = 'moderate';
        }
        $comment = $request->input('student_comment');

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'Academic Stress Survey',
            'score' => $score,
            'risk_level' => $risk_level,
            'student_comment' => $comment,
        ]);
        return redirect()->route('assessments.index')->with(['show_thank_you' => true, 'last_assessment_type' => 'Academic Stress Survey']);
    }

    // Handle Wellness Check submission
    public function submitWellnessCheck(Request $request)
    {
        $request->validate([
            'wellness_answers' => 'required|array|size:12',
            'wellness_answers.*' => 'required|in:0,1,2,3',
        ]);
        $score = array_sum($request->input('wellness_answers'));
        $risk_level = 'normal';
        if ($score >= 24) {
            $risk_level = 'high';
        } elseif ($score >= 16) {
            $risk_level = 'moderate';
        }
        $comment = $request->input('student_comment');

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'Wellness Check',
            'score' => $score,
            'risk_level' => $risk_level,
            'student_comment' => $comment,
        ]);
        return redirect()->route('assessments.index')->with(['show_thank_you' => true, 'last_assessment_type' => 'Wellness Check']);
    }

    // Helper for DASS-42 questions
    private function getDass42Questions()
    {
        return [
            'I found myself getting upset by quite trivial things',
            'I was aware of dryness of my mouth',
            'I couldn\'t seem to experience any positive feeling at all',
            'I experienced breathing difficulty (e.g. excessively rapid breathing, breathlessness in the absence of physical exertion)',
            'I just couldn\'t seem to get going',
            'I tended to over-react to situations',
            'I had a feeling of shakiness (e.g. legs going to give way)',
            'I found it difficult to relax',
            'I found myself in situations that made me so anxious I was most relieved when they ended',
            'I felt that I had nothing to look forward to',
            'I found myself getting upset rather easily',
            'I felt that I was using a lot of nervous energy',
            'I felt sad and depressed',
            'I found myself getting impatient when I was delayed in any way (e.g. elevators, traffic lights, being kept waiting)',
            'I had feeling of faintness',
            'I felt that I had lost interest in just about everything',
            'I felt I wasn\'t worth much as a person',
            'I felt that I was rather touchy',
            'I perspired noticeably (e.g. hands sweaty) in the absence of high temperatures or physical exertion',
            'I felt scared without any good reason',
            'I felt that life wasn\'t worthwhile',
            'I found it hard to wind down',
            'I had difficulty in swallowing',
            'I couldn\'t seem to get any enjoyment out of the things I did',
            'I was aware of the action of my heart in the absence of physical exertion (e.g. sense of heart rate increase, heart missing a beat)',
            'I felt down-hearted and blue',
            'I found that I was very irritable',
            'I felt I was close to panic',
            'I found it hard to calm down after something upset me',
            'I feared that I would be "thrown" by some trivial but unfamiliar task',
            'I was unable to become enthusiastic about anything',
            'I found it difficult to tolerate interruptions to what I was doing',
            'I was in a state of nervous tension',
            'I felt I was pretty worthless',
            'I was intolerant of anything that kept me from getting on with what I was doing',
            'I felt terrified',
            'I could see nothing in the future to be hopeful about',
            'I felt that life was meaningless',
            'I found myself getting agitated',
            'I was worried about situations in which I might panic and make a fool of myself',
            'I experienced trembling (e.g. in the hands)',
            'I found it difficult to work up the initiative to do things',
        ];
    }
    // Helper for Academic Stress Survey questions
    private function getAcademicQuestions()
    {
        return [
            'I feel overwhelmed by my academic workload.',
            'I have trouble meeting assignment deadlines.',
            'I worry about my grades and academic performance.',
            'I find it hard to balance school and personal life.',
            'I feel pressure to succeed academically.',
            'I have difficulty concentrating on my studies.',
            'I feel anxious before exams or presentations.',
            'I struggle to keep up with class material.',
            'I feel unsupported by teachers or peers.',
            'I have trouble sleeping due to academic stress.',
            'I feel like giving up on my studies.',
            'I avoid academic tasks because of stress.',
            'I feel isolated or alone in my academic journey.',
            'I experience physical symptoms (e.g., headaches) due to stress.',
            'I find it hard to relax after schoolwork.',
        ];
    }
    // Helper for Wellness Check questions
    private function getWellnessQuestions()
    {
        return [
            'I feel energetic and motivated most days.',
            'I am able to manage my emotions effectively.',
            'I have a strong support system of friends or family.',
            'I feel satisfied with my personal relationships.',
            'I am able to cope with daily stressors.',
            'I feel confident in my ability to handle challenges.',
            'I take time for self-care and relaxation.',
            'I feel a sense of purpose in my life.',
            'I am able to maintain a healthy work-life balance.',
            'I feel optimistic about my future.',
            'I am able to adapt to changes in my life.',
            'I feel content and at peace with myself.',
        ];
    }

    public function show($id)
    {
        $assessment = \App\Models\Assessment::with('user')->findOrFail($id);
        $scores = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true);

        $score_interpretation = [];

        if ($assessment->type === 'DASS-42') {
            $depression = $scores['depression'] ?? 0;
            $anxiety = $scores['anxiety'] ?? 0;
            $stress = $scores['stress'] ?? 0;

            // DASS-42 Interpretation Guide
            $score_interpretation['depression'] = $depression >= 28 ? 'Extremely Severe' : ($depression >= 21 ? 'Severe' : ($depression >= 14 ? 'Moderate' : ($depression >= 10 ? 'Mild' : 'Normal')));
            $score_interpretation['anxiety'] = $anxiety >= 20 ? 'Extremely Severe' : ($anxiety >= 15 ? 'Severe' : ($anxiety >= 10 ? 'Moderate' : ($anxiety >= 8 ? 'Mild' : 'Normal')));
            $score_interpretation['stress'] = $stress >= 34 ? 'Extremely Severe' : ($stress >= 26 ? 'Severe' : ($stress >= 19 ? 'Moderate' : ($stress >= 15 ? 'Mild' : 'Normal')));
        }

        return view('counselor.assessments.show', compact('assessment', 'scores', 'score_interpretation'));
    }

    public function saveNotes(Request $request, $id)
    {
        $assessment = \App\Models\Assessment::findOrFail($id);
        $assessment->case_notes = $request->input('case_notes');
        $assessment->save();

        return redirect()->route('counselor.assessments.show', $assessment->id)
            ->with('success', 'Case management notes updated.');
    }

    public function exportPdf($id)
    {
        $assessment = \App\Models\Assessment::with('user')->findOrFail($id);
        $scores = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true);

        $score_interpretation = [];

        if ($assessment->type === 'DASS-42') {
            $depression = $scores['depression'] ?? 0;
            $anxiety = $scores['anxiety'] ?? 0;
            $stress = $scores['stress'] ?? 0;

            $score_interpretation['depression'] = $depression >= 28 ? 'Extremely Severe' : ($depression >= 21 ? 'Severe' : ($depression >= 14 ? 'Moderate' : ($depression >= 10 ? 'Mild' : 'Normal')));
            $score_interpretation['anxiety'] = $anxiety >= 20 ? 'Extremely Severe' : ($anxiety >= 15 ? 'Severe' : ($anxiety >= 10 ? 'Moderate' : ($anxiety >= 8 ? 'Mild' : 'Normal')));
            $score_interpretation['stress'] = $stress >= 34 ? 'Extremely Severe' : ($stress >= 26 ? 'Severe' : ($stress >= 19 ? 'Moderate' : ($stress >= 15 ? 'Mild' : 'Normal')));
        }

        $pdf = Pdf::loadView('counselor.assessments.export', compact(
            'assessment', 'scores', 'score_interpretation'
        ));
        return $pdf->download('assessment-summary-'.$assessment->id.'.pdf');
    }
} 