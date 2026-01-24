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
            'grit_questions' => $this->getGritQuestions(),
            'neo_questions' => $this->getNeoQuestions(),
            'wvi_questions' => $this->getWviQuestions(),
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

        // Normalize answers to 1-indexed keys so views that expect questions 1..42 work
        $answers_assoc = [];
        foreach ($answers as $k => $v) {
            // If answers come as 0-indexed numeric array (keys may be strings), shift to 1-indexed
            if (is_numeric($k)) {
                $idx = (int) $k + 1;
            } else {
                $idx = $k;
            }
            $answers_assoc[$idx] = (int) $v;
        }

        // Merge per-question answers with the computed subscale totals so existing views
        // can read either the per-item values or the aggregated values via $scores['depression'] etc.
        $scorePayload = $answers_assoc;
        $scorePayload['depression'] = $depression;
        $scorePayload['anxiety'] = $anxiety;
        $scorePayload['stress'] = $stress;

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'DASS-42',
            'score' => json_encode($scorePayload),
            'risk_level' => $risk_level,
            'student_comment' => $comment,
        ]);

        // After completing the assessment send user to booking (appointments.create)
        return redirect()->route('appointments.create')
            ->with('success', 'DASS-42 assessment completed successfully. You may now continue to booking.');
    }

    // Counselor: View all DASS-42 assessment results
    public function counselorIndex(Request $request)
    {
        // Only allow counselors
        if (!auth()->user()->isCounselor()) {
            abort(403);
        }

        $query = \App\Models\Assessment::with('user')
            ->orderByDesc('created_at');

        // Filter by Assessment Type
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filter by Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // Filter by Student Name or Email
        if ($request->filled('student')) {
            $search = $request->input('student');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter by College
        if ($request->filled('college')) {
            $query->whereHas('user', function ($q) use ($request) {
                // Assuming 'college' is a column on the users table
                $q->where('college', $request->input('college'));
            });
        }

        // Filter by Year Level
        if ($request->filled('year')) {
            $query->whereHas('user', function ($q) use ($request) {
                // Assuming 'year_level' or 'year' is the column
                $q->where(function ($sub) use ($request) {
                    $sub->where('year_level', $request->input('year'))
                        ->orWhere('year', $request->input('year'));
                });
            });
        }

        // Filter by Sex
        if ($request->filled('sex')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('sex', $request->input('sex'));
            });
        }

        $assessments = $query->paginate(20)->withQueryString();

        return view('counselor.assessments.index', compact('assessments'));
    }

    // Handle GRIT Scale submission
    public function submitGrit(Request $request)
    {
        $questions = $this->getGritQuestions();
        $request->validate([
            'grit_answers' => 'required|array|size:' . count($questions),
            'grit_answers.*' => 'required|in:1,2,3,4,5',
        ]);

        // GRIT Scoring (Reverse scored items: 1, 3, 5, 6 in 8-item scale)
        // 1=Not at all like me, 5=Very much like me
        $reverse_items = [0, 2, 4, 5]; // 0-indexed indices for Q1, Q3, Q5, Q6
        $score = 0;
        $answers = $request->input('grit_answers');

        foreach ($answers as $idx => $val) {
            $val = (int) $val;
            if (in_array($idx, $reverse_items)) {
                // Reverse: 1->5, 2->4, 3->3, 4->2, 5->1
                $score += (6 - $val);
            } else {
                $score += $val;
            }
        }
        $final_score = $score / count($questions); // Average score 1-5

        $risk_level = 'low'; // High grit = low risk? Or just categorized.
        // Interpretation: 
        // 4.5-5: Extremely Gritty
        // 4.0-4.4: Very Gritty
        // 3.5-3.9: Gritty
        // 3.0-3.4: Somewhat Gritty
        // <3.0: Not Gritty

        // Mapping to system "risk_level" (used for flagging purposes)
        // perhaps "high" risk if low grit?
        if ($final_score < 3.0)
            $risk_level = 'high';
        elseif ($final_score < 3.5)
            $risk_level = 'moderate';

        $comment = $request->input('student_comment');

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'GRIT Scale',
            'score' => number_format($final_score, 2),
            'risk_level' => $risk_level,
            'student_comment' => $comment,
        ]);
        return redirect()->route('assessments.index')->with(['show_thank_you' => true, 'last_assessment_type' => 'GRIT Scale']);
    }

    // Handle NEO-FFI submission
    public function submitNeo(Request $request)
    {
        $questions = $this->getNeoQuestions();
        $request->validate([
            'neo_answers' => 'required|array|size:' . count($questions),
            'neo_answers.*' => 'required|in:1,2,3,4,5',
        ]);

        // Simple aggregate for demo purposes (real scoring is complex)
        $answers = $request->input('neo_answers');
        $scorePayload = $answers;

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'NEO-PI-R',
            'score' => json_encode($scorePayload),
            'risk_level' => 'normal', // Personality has no inherent risk
            'student_comment' => $request->input('student_comment'),
        ]);
        return redirect()->route('assessments.index')->with(['show_thank_you' => true, 'last_assessment_type' => 'NEO-PI-R']);
    }

    // Handle Work Values Inventory submission
    public function submitWvi(Request $request)
    {
        $questions = $this->getWviQuestions();
        $request->validate([
            'wvi_answers' => 'required|array|size:' . count($questions),
            'wvi_answers.*' => 'required|in:1,2,3,4,5',
        ]);

        $scorePayload = $request->input('wvi_answers');

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'Work Values Inventory',
            'score' => json_encode($scorePayload),
            'risk_level' => 'normal',
            'student_comment' => $request->input('student_comment'),
        ]);
        return redirect()->route('assessments.index')->with(['show_thank_you' => true, 'last_assessment_type' => 'Work Values Inventory']);
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

    // Helper for GRIT questions (Short Grit Scale)
    private function getGritQuestions()
    {
        return [
            'New ideas and projects sometimes distract me from previous ones.',
            'Setbacks don\'t discourage me. I don\'t give up easily.',
            'I have been obsessed with a certain idea or project for a short time but later lost interest.',
            'I am a hard worker.',
            'I often set a goal but later choose to pursue a different one.',
            'I have difficulty maintaining my focus on projects that take more than a few months to complete.',
            'I finish whatever I begin.',
            'I am diligent. I never give up.',
        ];
    }

    // Helper for NEO questions (Short Big Five)
    private function getNeoQuestions()
    {
        return [
            'I am the life of the party.',
            'I feel little concern for others.',
            'I am always prepared.',
            'I get stressed out easily.',
            'I have a rich vocabulary.',
            'I don\'t talk a lot.',
            'I am interested in people.',
            'I leave my belongings around.',
            'I am relaxed most of the time.',
            'I have difficulty understanding abstract ideas.',
        ];
    }

    // Helper for WVI questions
    private function getWviQuestions()
    {
        return [
            'It is important to me to have a secure job.',
            'I want to help others in my work.',
            'High income is my top priority.',
            'I want to be creative and original in my work.',
            'I prefer to work independently.',
            'I want a job with prestige and status.',
            'I value variety and change in my work.',
            'I want to have authority over others.',
            'I want to work in a pleasant environment.',
            'I want a job that contributes to society.',
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

        // If this is a DASS-42 assessment, include the questions so the export view
        // can render per-question answers.
        // Find the linked appointment (first one created/scheduled after assessment)
        $linkedAppointment = \App\Models\Appointment::where('student_id', $assessment->user_id)
            ->where('created_at', '>=', $assessment->created_at)
            ->orderBy('created_at', 'asc')
            ->first();

        $viewData = compact('assessment', 'scores', 'score_interpretation', 'linkedAppointment');
        if ($assessment->type === 'DASS-42') {
            $viewData['dass42_questions'] = $this->getDass42Questions();
        }

        $pdf = Pdf::loadView('counselor.assessments.export', $viewData);
        return $pdf->download('assessment-summary-' . $assessment->id . '.pdf');
    }
}