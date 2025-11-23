<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use PHPInsight\Sentiment;
use App\Services\CohereService;
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
        // Extremely Severe or Severe = high risk
        // Moderate = moderate risk
        // Mild or Normal = normal risk
        $risk_level = 'normal';
        $depression_severity = $depression >= 28 ? 'Extremely Severe' : ($depression >= 21 ? 'Severe' : ($depression >= 14 ? 'Moderate' : ($depression >= 10 ? 'Mild' : 'Normal')));
        $anxiety_severity = $anxiety >= 20 ? 'Extremely Severe' : ($anxiety >= 15 ? 'Severe' : ($anxiety >= 10 ? 'Moderate' : ($anxiety >= 8 ? 'Mild' : 'Normal')));
        $stress_severity = $stress >= 34 ? 'Extremely Severe' : ($stress >= 26 ? 'Severe' : ($stress >= 19 ? 'Moderate' : ($stress >= 15 ? 'Mild' : 'Normal')));
        
        if ($depression_severity === 'Extremely Severe' || $depression_severity === 'Severe' || 
            $anxiety_severity === 'Extremely Severe' || $anxiety_severity === 'Severe' || 
            $stress_severity === 'Extremely Severe' || $stress_severity === 'Severe') {
            $risk_level = 'high';
        } elseif ($depression_severity === 'Moderate' || $anxiety_severity === 'Moderate' || $stress_severity === 'Moderate') {
            $risk_level = 'moderate';
        }
        $comment = $request->input('student_comment');
        $sentiment = $comment ? $this->simpleSentiment($comment) : null;

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'DASS-42',
            'score' => json_encode(['depression'=>$depression,'anxiety'=>$anxiety,'stress'=>$stress]),
            'risk_level' => $risk_level,
            'student_comment' => $comment,
            'ai_sentiment' => $sentiment,
        ]);
        
        // Redirect to consent page after DASS-42 completion
        return redirect()->route('consent.show')
            ->with('success', 'DASS-42 assessment completed successfully. Please proceed to the consent page.');
    }

    // Counselor: View all DASS-21 assessment results
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
        $sentiment = $comment ? $this->simpleSentiment($comment) : null;

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'Academic Stress Survey',
            'score' => $score,
            'risk_level' => $risk_level,
            'student_comment' => $comment,
            'ai_sentiment' => $sentiment,
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
        $sentiment = $comment ? $this->simpleSentiment($comment) : null;

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'Wellness Check',
            'score' => $score,
            'risk_level' => $risk_level,
            'student_comment' => $comment,
            'ai_sentiment' => $sentiment,
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

    public function simpleSentiment($text) {
        $positive = ['happy', 'good', 'great', 'fantastic', 'positive', 'well', 'better', 'improved', 'relieved', 'hopeful', 'excited', 'calm'];
        $negative = ['sad', 'bad', 'depressed', 'anxious', 'stressed', 'unhappy', 'worse', 'hopeless', 'angry', 'tired', 'worried', 'afraid'];
        $text = strtolower($text);
        foreach ($positive as $word) {
            if (strpos($text, $word) !== false) return 'positive';
        }
        foreach ($negative as $word) {
            if (strpos($text, $word) !== false) return 'negative';
        }
        return 'neutral';
    }

    public function show($id)
    {
        $assessment = \App\Models\Assessment::with('user')->findOrFail($id);
        $scores = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true);

        $ai_summary = '';
        $ai_suggested_actions = [];
        $ai_resource = null;
        $score_interpretation = [];
        $graph_data = [];
        $redFlags = [];
        $strengths = [];
        $percentile = null;
        $trend = null;
        $dynamicResources = [];
        $actionPlan = [];

        // Example mapping for DASS-21 (customize for your survey)
        $questionTopics = [
            'q1' => 'Difficulty relaxing',
            'q2' => 'Dryness of mouth',
            'q3' => 'Lack of positive feeling',
            'q4' => 'Breathing difficulty',
            'q5' => 'Difficulty initiating tasks',
            'q6' => 'Tendency to over-react',
            'q7' => 'Trembling',
            'q8' => 'Difficulty winding down',
            'q9' => 'Lack of enthusiasm',
            'q10' => 'Nervous energy',
            'q11' => 'Feeling worthless',
            'q12' => 'Agitation',
            'q13' => 'Difficulty relaxing',
            'q14' => 'Intolerant',
            'q15' => 'Fear without reason',
            'q16' => 'Meaninglessness',
            'q17' => 'Irritability',
            'q18' => 'Difficulty sleeping',
            'q19' => 'Feeling down-hearted',
            'q20' => 'Feeling close to panic',
            'q21' => 'Unable to become enthusiastic',
            // ...add more for other surveys
        ];

        // Resource map for flagged topics
        $resourceMap = [
            'Difficulty sleeping' => ['title' => 'Sleep Hygiene Tips', 'url' => '#'],
            'Difficulty relaxing' => ['title' => 'Relaxation Techniques', 'url' => '#'],
            'Feeling worthless' => ['title' => 'Self-Esteem Support', 'url' => '#'],
            'Fear without reason' => ['title' => 'Anxiety Management', 'url' => '#'],
            'Trembling' => ['title' => 'Grounding Exercises', 'url' => '#'],
            // ...add more mappings as needed
        ];

        // Per-question analysis
        $answers = $scores['answers'] ?? [];
        foreach ($answers as $q => $val) {
            // For DASS-21: 0=Did not apply, 1=Applied to some degree, 2=Applied a considerable degree, 3=Applied very much
            if ($val >= 3) {
                $topic = $questionTopics[$q] ?? $q;
                $redFlags[] = $topic;
                if (isset($resourceMap[$topic])) $dynamicResources[] = $resourceMap[$topic];
            } elseif ($val == 0) {
                $strengths[] = $questionTopics[$q] ?? $q;
            }
        }

        // Calculate total score for percentile/trend
        if ($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21') {
            $total = ($scores['depression'] ?? 0) + ($scores['anxiety'] ?? 0) + ($scores['stress'] ?? 0);
        } else {
            $total = is_array($assessment->score) ? ($assessment->score['score'] ?? 0) : (is_numeric($assessment->score) ? $assessment->score : 0);
        }

        // Percentile calculation
        $allScores = \App\Models\Assessment::where('type', $assessment->type)->pluck('score');
        $allTotals = $allScores->map(function($s) use ($assessment) {
            $arr = is_array($s) ? $s : json_decode($s, true);
            if ($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21') {
                return ($arr['depression'] ?? 0) + ($arr['anxiety'] ?? 0) + ($arr['stress'] ?? 0);
            }
            return is_array($arr) ? ($arr['score'] ?? 0) : (is_numeric($arr) ? $arr : 0);
        });
        $percentile = $allTotals->filter(fn($s) => $s < $total)->count() / max(1, $allTotals->count()) * 100;

        // Trend calculation (compare to previous assessment for this user and type)
        $previous = \App\Models\Assessment::where('user_id', $assessment->user_id)
            ->where('type', $assessment->type)
            ->where('id', '<', $assessment->id)
            ->orderByDesc('id')->first();
        if ($previous) {
            $prevScore = is_array($previous->score) ? ($previous->score['score'] ?? 0) : (is_numeric($previous->score) ? $previous->score : 0);
            if ($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21') {
                $prevArr = is_array($previous->score) ? $previous->score : json_decode($previous->score, true);
                $prevScore = ($prevArr['depression'] ?? 0) + ($prevArr['anxiety'] ?? 0) + ($prevArr['stress'] ?? 0);
            }
            $trend = $total - $prevScore;
            // Action plan based on trend
            if ($trend > 0) {
                $actionPlan[] = 'Schedule a follow-up session to address worsening scores.';
            } elseif ($trend < 0) {
                $actionPlan[] = 'Acknowledge improvement and reinforce positive behaviors.';
            }
        }

        // Dynamic recommendations based on percentile/trend
        if ($percentile !== null && $percentile > 80) {
            $ai_suggested_actions[] = 'Student is among the most at-risk. Consider urgent intervention.';
            $actionPlan[] = 'Refer to campus counseling center for urgent support.';
        }
        if ($trend !== null && $trend > 0) {
            $ai_suggested_actions[] = 'Score has increased since last assessment (worsening). Escalate support.';
        } elseif ($trend !== null && $trend < 0) {
            $ai_suggested_actions[] = 'Score has decreased since last assessment (improving). Reinforce positive changes.';
        }
        if (!empty($strengths)) {
            $actionPlan[] = 'Leverage student strengths (e.g., ' . implode(', ', array_slice($strengths, 0, 2)) . ') in counseling.';
        }

        if ($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21') {
            $depression = $scores['depression'] ?? 0;
            $anxiety = $scores['anxiety'] ?? 0;
            $stress = $scores['stress'] ?? 0;

            // Use DASS-42 interpretation guide if DASS-42, otherwise use DASS-21 interpretation
            if ($assessment->type === 'DASS-42') {
                // DASS-42 Interpretation Guide:
                // Normal: D 0-9, A 0-7, S 0-14
                // Mild: D 10-13, A 8-9, S 15-18
                // Moderate: D 14-20, A 10-14, S 19-25
                // Severe: D 21-27, A 15-19, S 26-33
                // Extremely Severe: D 28+, A 20+, S 34+
                $score_interpretation['depression'] = $depression >= 28 ? 'Extremely Severe' : ($depression >= 21 ? 'Severe' : ($depression >= 14 ? 'Moderate' : ($depression >= 10 ? 'Mild' : 'Normal')));
                $score_interpretation['anxiety'] = $anxiety >= 20 ? 'Extremely Severe' : ($anxiety >= 15 ? 'Severe' : ($anxiety >= 10 ? 'Moderate' : ($anxiety >= 8 ? 'Mild' : 'Normal')));
                $score_interpretation['stress'] = $stress >= 34 ? 'Extremely Severe' : ($stress >= 26 ? 'Severe' : ($stress >= 19 ? 'Moderate' : ($stress >= 15 ? 'Mild' : 'Normal')));
            } else {
                // DASS-21 interpretation (multiplied by 2)
                $score_interpretation['depression'] = $depression >= 28 ? 'Extremely Severe' : ($depression >= 21 ? 'Severe' : ($depression >= 14 ? 'Moderate' : ($depression >= 10 ? 'Mild' : 'Normal')));
                $score_interpretation['anxiety'] = $anxiety >= 20 ? 'Extremely Severe' : ($anxiety >= 15 ? 'Severe' : ($anxiety >= 10 ? 'Moderate' : ($anxiety >= 8 ? 'Mild' : 'Normal')));
                $score_interpretation['stress'] = $stress >= 34 ? 'Extremely Severe' : ($stress >= 27 ? 'Severe' : ($stress >= 19 ? 'Moderate' : ($stress >= 15 ? 'Mild' : 'Normal')));
            }

            $dassType = $assessment->type === 'DASS-42' ? 'DASS-42' : 'DASS-21';
            $ai_summary = "$dassType Subscale Scores: Depression ($depression, {$score_interpretation['depression']}), Anxiety ($anxiety, {$score_interpretation['anxiety']}), Stress ($stress, {$score_interpretation['stress']}).";

            if ($depression >= 21) $ai_suggested_actions[] = 'Refer for depression support.';
            if ($anxiety >= 15) $ai_suggested_actions[] = 'Provide anxiety coping strategies.';
            if ($stress >= 26) $ai_suggested_actions[] = 'Discuss stress management techniques.';

            $ai_resource = ['title' => "$dassType Self-Help Guide", 'url' => '#'];
            $graph_data = [
                'labels' => ['Depression', 'Anxiety', 'Stress'],
                'scores' => [$depression, $anxiety, $stress],
                'interpretation' => [$score_interpretation['depression'], $score_interpretation['anxiety'], $score_interpretation['stress']],
            ];
        } else {
            $max = $assessment->type === 'Academic Stress Survey' ? 45 : ($assessment->type === 'Wellness Check' ? 36 : 0);
            // Score level interpretation
            if ($max > 0) {
                if ($total >= 0.8 * $max) {
                    $score_level = 'Very High';
                    $ai_suggested_actions[] = 'Urgent follow-up and intervention recommended.';
                } elseif ($total >= 0.6 * $max) {
                    $score_level = 'High';
                    $ai_suggested_actions[] = 'Monitor closely and provide support resources.';
                } elseif ($total >= 0.4 * $max) {
                    $score_level = 'Moderate';
                    $ai_suggested_actions[] = 'Encourage healthy coping strategies.';
                } else {
                    $score_level = 'Low';
                    $ai_suggested_actions[] = 'Continue regular monitoring.';
                }
                $ai_summary = "Total Score: $total out of $max ($score_level).";
                $graph_data = [
                    'labels' => ['Total Score'],
                    'scores' => [$total],
                    'max' => $max,
                    'score_level' => $score_level,
                ];
            } else {
                $ai_summary = "Total Score: $total.";
                $ai_suggested_actions[] = $assessment->risk_level === 'high'
                    ? 'Immediate follow-up recommended due to high risk.'
                    : ($assessment->risk_level === 'moderate'
                        ? 'Monitor and schedule a check-in session.'
                        : 'Continue regular monitoring.');
                $graph_data = [
                    'labels' => ['Total Score'],
                    'scores' => [$total],
                    'max' => 0,
                    'score_level' => '',
                ];
            }
            $ai_resource = ['title' => 'Academic Stress Coping Tips', 'url' => '#'];
        }

        // Sentiment (from Cohere)
        $cohere = new CohereService();
        $comment = $assessment->student_comment ?? '';
        $ai_sentiment = $comment ? $cohere->sentiment($comment) : 'neutral';

        return view('counselor.assessments.show', compact(
            'assessment', 'scores', 'ai_sentiment', 'ai_summary', 'ai_suggested_actions', 'ai_resource', 'score_interpretation', 'graph_data', 'redFlags', 'strengths', 'percentile', 'trend', 'dynamicResources', 'actionPlan'
        ));
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
        // Reuse your show() logic to get all variables
        // ... (copy the logic from show() to get $scores, $ai_summary, etc.)
        // For brevity, let's assume you have all variables as in show()
        extract($this->getAssessmentSummaryData($assessment)); // You may want to refactor show() logic into a private method

        $pdf = Pdf::loadView('counselor.assessments.export', compact(
            'assessment', 'scores', 'ai_sentiment', 'ai_summary', 'ai_suggested_actions', 'ai_resource', 'score_interpretation', 'graph_data', 'redFlags', 'strengths', 'percentile', 'trend', 'dynamicResources', 'actionPlan'
        ));
        return $pdf->download('assessment-summary-'.$assessment->id.'.pdf');
    }

    private function getAssessmentSummaryData($assessment) {
        $scores = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true);

        $ai_summary = '';
        $ai_suggested_actions = [];
        $ai_resource = null;
        $score_interpretation = [];
        $graph_data = [];
        $redFlags = [];
        $strengths = [];
        $percentile = null;
        $trend = null;
        $dynamicResources = [];
        $actionPlan = [];

        // Example mapping for DASS-21 (customize for your survey)
        $questionTopics = [
            'q1' => 'Difficulty relaxing',
            'q2' => 'Dryness of mouth',
            'q3' => 'Lack of positive feeling',
            'q4' => 'Breathing difficulty',
            'q5' => 'Difficulty initiating tasks',
            'q6' => 'Tendency to over-react',
            'q7' => 'Trembling',
            'q8' => 'Difficulty winding down',
            'q9' => 'Lack of enthusiasm',
            'q10' => 'Nervous energy',
            'q11' => 'Feeling worthless',
            'q12' => 'Agitation',
            'q13' => 'Difficulty relaxing',
            'q14' => 'Intolerant',
            'q15' => 'Fear without reason',
            'q16' => 'Meaninglessness',
            'q17' => 'Irritability',
            'q18' => 'Difficulty sleeping',
            'q19' => 'Feeling down-hearted',
            'q20' => 'Feeling close to panic',
            'q21' => 'Unable to become enthusiastic',
            // ...add more for other surveys
        ];

        // Resource map for flagged topics
        $resourceMap = [
            'Difficulty sleeping' => ['title' => 'Sleep Hygiene Tips', 'url' => '#'],
            'Difficulty relaxing' => ['title' => 'Relaxation Techniques', 'url' => '#'],
            'Feeling worthless' => ['title' => 'Self-Esteem Support', 'url' => '#'],
            'Fear without reason' => ['title' => 'Anxiety Management', 'url' => '#'],
            'Trembling' => ['title' => 'Grounding Exercises', 'url' => '#'],
            // ...add more mappings as needed
        ];

        // Per-question analysis
        $answers = $scores['answers'] ?? [];
        foreach ($answers as $q => $val) {
            // For DASS-21: 0=Did not apply, 1=Applied to some degree, 2=Applied a considerable degree, 3=Applied very much
            if ($val >= 3) {
                $topic = $questionTopics[$q] ?? $q;
                $redFlags[] = $topic;
                if (isset($resourceMap[$topic])) $dynamicResources[] = $resourceMap[$topic];
            } elseif ($val == 0) {
                $strengths[] = $questionTopics[$q] ?? $q;
            }
        }

        // Calculate total score for percentile/trend
        if ($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21') {
            $total = ($scores['depression'] ?? 0) + ($scores['anxiety'] ?? 0) + ($scores['stress'] ?? 0);
        } else {
            $total = is_array($assessment->score) ? ($assessment->score['score'] ?? 0) : (is_numeric($assessment->score) ? $assessment->score : 0);
        }

        // Percentile calculation
        $allScores = \App\Models\Assessment::where('type', $assessment->type)->pluck('score');
        $allTotals = $allScores->map(function($s) use ($assessment) {
            $arr = is_array($s) ? $s : json_decode($s, true);
            if ($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21') {
                return ($arr['depression'] ?? 0) + ($arr['anxiety'] ?? 0) + ($arr['stress'] ?? 0);
            }
            return is_array($arr) ? ($arr['score'] ?? 0) : (is_numeric($arr) ? $arr : 0);
        });
        $percentile = $allTotals->filter(fn($s) => $s < $total)->count() / max(1, $allTotals->count()) * 100;

        // Trend calculation (compare to previous assessment for this user and type)
        $previous = \App\Models\Assessment::where('user_id', $assessment->user_id)
            ->where('type', $assessment->type)
            ->where('id', '<', $assessment->id)
            ->orderByDesc('id')->first();
        if ($previous) {
            $prevScore = is_array($previous->score) ? ($previous->score['score'] ?? 0) : (is_numeric($previous->score) ? $previous->score : 0);
            if ($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21') {
                $prevArr = is_array($previous->score) ? $previous->score : json_decode($previous->score, true);
                $prevScore = ($prevArr['depression'] ?? 0) + ($prevArr['anxiety'] ?? 0) + ($prevArr['stress'] ?? 0);
            }
            $trend = $total - $prevScore;
            // Action plan based on trend
            if ($trend > 0) {
                $actionPlan[] = 'Schedule a follow-up session to address worsening scores.';
            } elseif ($trend < 0) {
                $actionPlan[] = 'Acknowledge improvement and reinforce positive behaviors.';
            }
        }

        // Dynamic recommendations based on percentile/trend
        if ($percentile !== null && $percentile > 80) {
            $ai_suggested_actions[] = 'Student is among the most at-risk. Consider urgent intervention.';
            $actionPlan[] = 'Refer to campus counseling center for urgent support.';
        }
        if ($trend !== null && $trend > 0) {
            $ai_suggested_actions[] = 'Score has increased since last assessment (worsening). Escalate support.';
        } elseif ($trend !== null && $trend < 0) {
            $ai_suggested_actions[] = 'Score has decreased since last assessment (improving). Reinforce positive changes.';
        }
        if (!empty($strengths)) {
            $actionPlan[] = 'Leverage student strengths (e.g., ' . implode(', ', array_slice($strengths, 0, 2)) . ') in counseling.';
        }

        if ($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21') {
            $depression = $scores['depression'] ?? 0;
            $anxiety = $scores['anxiety'] ?? 0;
            $stress = $scores['stress'] ?? 0;

            // Use DASS-42 interpretation guide if DASS-42, otherwise use DASS-21 interpretation
            if ($assessment->type === 'DASS-42') {
                // DASS-42 Interpretation Guide:
                // Normal: D 0-9, A 0-7, S 0-14
                // Mild: D 10-13, A 8-9, S 15-18
                // Moderate: D 14-20, A 10-14, S 19-25
                // Severe: D 21-27, A 15-19, S 26-33
                // Extremely Severe: D 28+, A 20+, S 34+
                $score_interpretation['depression'] = $depression >= 28 ? 'Extremely Severe' : ($depression >= 21 ? 'Severe' : ($depression >= 14 ? 'Moderate' : ($depression >= 10 ? 'Mild' : 'Normal')));
                $score_interpretation['anxiety'] = $anxiety >= 20 ? 'Extremely Severe' : ($anxiety >= 15 ? 'Severe' : ($anxiety >= 10 ? 'Moderate' : ($anxiety >= 8 ? 'Mild' : 'Normal')));
                $score_interpretation['stress'] = $stress >= 34 ? 'Extremely Severe' : ($stress >= 26 ? 'Severe' : ($stress >= 19 ? 'Moderate' : ($stress >= 15 ? 'Mild' : 'Normal')));
            } else {
                // DASS-21 interpretation (multiplied by 2)
                $score_interpretation['depression'] = $depression >= 28 ? 'Extremely Severe' : ($depression >= 21 ? 'Severe' : ($depression >= 14 ? 'Moderate' : ($depression >= 10 ? 'Mild' : 'Normal')));
                $score_interpretation['anxiety'] = $anxiety >= 20 ? 'Extremely Severe' : ($anxiety >= 15 ? 'Severe' : ($anxiety >= 10 ? 'Moderate' : ($anxiety >= 8 ? 'Mild' : 'Normal')));
                $score_interpretation['stress'] = $stress >= 34 ? 'Extremely Severe' : ($stress >= 27 ? 'Severe' : ($stress >= 19 ? 'Moderate' : ($stress >= 15 ? 'Mild' : 'Normal')));
            }

            $dassType = $assessment->type === 'DASS-42' ? 'DASS-42' : 'DASS-21';
            $ai_summary = "$dassType Subscale Scores: Depression ($depression, {$score_interpretation['depression']}), Anxiety ($anxiety, {$score_interpretation['anxiety']}), Stress ($stress, {$score_interpretation['stress']}).";

            if ($depression >= 21) $ai_suggested_actions[] = 'Refer for depression support.';
            if ($anxiety >= 15) $ai_suggested_actions[] = 'Provide anxiety coping strategies.';
            if ($stress >= 26) $ai_suggested_actions[] = 'Discuss stress management techniques.';

            $ai_resource = ['title' => "$dassType Self-Help Guide", 'url' => '#'];
            $graph_data = [
                'labels' => ['Depression', 'Anxiety', 'Stress'],
                'scores' => [$depression, $anxiety, $stress],
                'interpretation' => [$score_interpretation['depression'], $score_interpretation['anxiety'], $score_interpretation['stress']],
            ];
        } else {
            $max = $assessment->type === 'Academic Stress Survey' ? 45 : ($assessment->type === 'Wellness Check' ? 36 : 0);
            // Score level interpretation
            if ($max > 0) {
                if ($total >= 0.8 * $max) {
                    $score_level = 'Very High';
                    $ai_suggested_actions[] = 'Urgent follow-up and intervention recommended.';
                } elseif ($total >= 0.6 * $max) {
                    $score_level = 'High';
                    $ai_suggested_actions[] = 'Monitor closely and provide support resources.';
                } elseif ($total >= 0.4 * $max) {
                    $score_level = 'Moderate';
                    $ai_suggested_actions[] = 'Encourage healthy coping strategies.';
                } else {
                    $score_level = 'Low';
                    $ai_suggested_actions[] = 'Continue regular monitoring.';
                }
                $ai_summary = "Total Score: $total out of $max ($score_level).";
                $graph_data = [
                    'labels' => ['Total Score'],
                    'scores' => [$total],
                    'max' => $max,
                    'score_level' => $score_level,
                ];
            } else {
                $ai_summary = "Total Score: $total.";
                $ai_suggested_actions[] = $assessment->risk_level === 'high'
                    ? 'Immediate follow-up recommended due to high risk.'
                    : ($assessment->risk_level === 'moderate'
                        ? 'Monitor and schedule a check-in session.'
                        : 'Continue regular monitoring.');
                $graph_data = [
                    'labels' => ['Total Score'],
                    'scores' => [$total],
                    'max' => 0,
                    'score_level' => '',
                ];
            }
            $ai_resource = ['title' => 'Academic Stress Coping Tips', 'url' => '#'];
        }

        // Sentiment (from Cohere)
        $cohere = new CohereService();
        $comment = $assessment->student_comment ?? '';
        $ai_sentiment = $comment ? $cohere->sentiment($comment) : 'neutral';

        return compact(
            'assessment', 'scores', 'ai_sentiment', 'ai_summary', 'ai_suggested_actions', 'ai_resource', 'score_interpretation', 'graph_data', 'redFlags', 'strengths', 'percentile', 'trend', 'dynamicResources', 'actionPlan'
        );
    }
} 