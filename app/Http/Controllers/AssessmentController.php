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

        // GRIT Scoring (Based on user image 10-item scale)
        // Questions 1, 3, 5, 7, 9 = Passion
        // Questions 2, 4, 6, 8, 10 = Perseverance
        // Score Mapping:
        // Not at all like me = 5
        // Not much like me = 4
        // Somewhat like me = 3
        // Mostly like me = 2
        // Very much like me = 1

        $answers = $request->input('grit_answers');
        $passion_indices = [0, 2, 4, 6, 8];
        $perseverance_indices = [1, 3, 5, 7, 9];

        $passion_sum = 0;
        $perseverance_sum = 0;

        foreach ($answers as $idx => $val) {
            $val = (int) $val;
            if (in_array($idx, $passion_indices)) {
                // Passion: raw value
                $passion_sum += $val;
            } else {
                // Perseverance: reverse scored (6 - raw value)
                $perseverance_sum += (6 - $val);
            }
        }

        $passion_index = $passion_sum / 5;
        $perseverance_index = $perseverance_sum / 5;
        $total_grit_index = ($passion_index + $perseverance_index) / 2;

        $risk_level = 'low';
        // Interpretation for flagging:
        // High grit (Total Index >= 3.5) = low risk
        // Moderate grit (Total Index 3.0 - 3.4) = moderate risk
        // Low grit (Total Index < 3.0) = high risk
        if ($total_grit_index < 3.0) {
            $risk_level = 'high';
        } elseif ($total_grit_index < 3.5) {
            $risk_level = 'moderate';
        }

        $scorePayload = [
            'total_index' => number_format($total_grit_index, 2),
            'passion_index' => number_format($passion_index, 2),
            'perseverance_index' => number_format($perseverance_index, 2),
            'answers' => $answers
        ];

        $comment = $request->input('student_comment');

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'GRIT Scale',
            'score' => json_encode($scorePayload),
            'risk_level' => $risk_level,
            'student_comment' => $comment,
        ]);
        return redirect()->route('assessments.index')->with([
            'show_thank_you' => true,
            'last_assessment_type' => 'GRIT Scale',
            'success' => 'GRIT assessment completed successfully!'
        ]);
    }

    // Handle NEO-FFI submission
    public function submitNeo(Request $request)
    {
        $questions = $this->getNeoQuestions();
        $request->validate([
            'neo_answers' => 'required|array|size:' . count($questions),
            'neo_answers.*' => 'required|in:1,2,3,4,5,6,7',
        ]);

        $answers = $request->input('neo_answers'); // 0-indexed internally

        // OCEAN Domain Scoring (1-indexed mapping from image)
        // Convert 1-indexed to 0-indexed: subtract 1
        $domains = [
            'Neuroticism' => [
                'pos' => [6, 11, 21, 26, 36, 41, 51, 56],
                'neg' => [1, 16, 31, 46]
            ],
            'Extroversion' => [
                'pos' => [2, 7, 17, 22, 32, 37, 47, 52], // Note: user's list says "3+7..." but item 3 is O-. Item 2 is "I like to have a lot of people..." which is E+.
                'neg' => [12, 27, 42, 57]
            ],
            'Openness' => [
                'pos' => [13, 28, 43, 53, 58],
                'neg' => [3, 8, 18, 23, 33, 38, 48]
            ],
            'Agreeableness' => [
                'pos' => [4, 19, 34, 49],
                'neg' => [9, 14, 24, 29, 39, 44, 54, 59]
            ],
            'Conscientiousness' => [
                'pos' => [5, 10, 20, 25, 35, 40, 50, 60],
                'neg' => [15, 30, 45, 55]
            ],
        ];

        // Self-correction on Extroversion: image says 3, but the text for item 3 is daydreaming.
        // Let's re-verify from the text provided by user:
        // E+: 2, 7, 17, 22, 32, 37, 47, 52
        // E-: 12, 27, 42, 57
        // Wait, image says E = (3+7+17+22+32+37+47+52) - (12+27+42+57)
        // Let's check text again: 3. I don't like to waste my time daydreaming.
        // That's typically Openness (low daydreaming).
        // Let's stick to the mapping provided in the image for the indexing, but adjust to 0-based.
        // Correction: The image's handwritten/typed scoring key:
        // O = (13+28+43+53+58) - (3+8+18+23+33+38+48) -> Item 3 is here!
        // E = (2+7+17+22+32+37+47+52) - (12+27+42+57) -> Item 2 is here.
        // Wait, let me look at image 2 again. 
        // E = (2+7... wait, is that a 2 or a 3? Looks like a 2 in my previous thought, let me look closer at the image.
        // Ah, it actually says 2+7. My bad.

        $results = [];
        foreach ($domains as $domain => $config) {
            $sum = 0;
            foreach ($config['pos'] as $item) {
                $sum += (int) ($answers[$item - 1] ?? 0);
            }
            foreach ($config['neg'] as $item) {
                // For 1-7 scale, reverse is 8 - X
                $val = (int) ($answers[$item - 1] ?? 0);
                if ($val > 0) {
                    $sum += (8 - $val);
                }
            }
            $results[$domain] = $sum;
        }

        $scorePayload = [
            'domains' => $results,
            'answers' => $answers,
            'scale' => 7
        ];

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'Personality (NEO-FFI)',
            'score' => json_encode($scorePayload),
            'risk_level' => 'normal',
            'student_comment' => $request->input('student_comment'),
        ]);

        return redirect()->route('assessments.index')->with([
            'show_thank_you' => true,
            'last_assessment_type' => 'NEO-FFI',
            'success' => 'NEO-FFI assessment completed successfully!'
        ]);
    }

    // Handle Work Values Inventory submission
    public function submitWvi(Request $request)
    {
        $questions = $this->getWviQuestions();
        $request->validate([
            'wvi_answers' => 'required|array|size:' . count($questions),
            'wvi_answers.*' => 'required|in:1,2,3,4,5',
        ]);

        $answers = $request->input('wvi_answers'); // 0-indexed internally

        // Value Scales (1-indexed mapping from image)
        $scales = [
            'Creativity' => [15, 16, 45],
            'Management' => [14, 24, 37],
            'Achievement' => [13, 17, 44],
            'Surroundings' => [12, 25, 36],
            'Supervisory Relationships' => [11, 18, 43],
            'Way of Life' => [10, 26, 35],
            'Security' => [9, 19, 42],
            'Associates' => [8, 27, 34],
            'Aesthetic' => [7, 20, 41],
            'Prestige' => [6, 28, 33],
            'Independence' => [5, 21, 40],
            'Variety' => [4, 29, 32],
            'Economic Return' => [3, 22, 39],
            'Altruism' => [2, 30, 31],
            'Intellectual Stimulation' => [1, 23, 38],
        ];

        $results = [];
        foreach ($scales as $name => $items) {
            $sum = 0;
            foreach ($items as $item) {
                $sum += (int) ($answers[$item - 1] ?? 0);
            }
            $results[$name] = $sum;
        }

        $scorePayload = [
            'scales' => $results,
            'answers' => $answers,
            'scale_range' => 5
        ];

        $assessment = \App\Models\Assessment::create([
            'user_id' => auth()->id(),
            'type' => 'Work Values Inventory',
            'score' => json_encode($scorePayload),
            'risk_level' => 'normal',
            'student_comment' => $request->input('student_comment'),
        ]);

        return redirect()->route('assessments.index')->with([
            'show_thank_you' => true,
            'last_assessment_type' => 'Work Values Inventory',
            'success' => 'Work Values Inventory completed successfully!'
        ]);
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

    public function getGritQuestions()
    {
        return [
            'New ideas and projects sometimes distract me from previous ones',
            'Setbacks don\'t discourage me. I don\'t give up easily.',
            'I often set a goal but later choose to pursue a different one.',
            'I am a hard worker.',
            'I have difficulty maintaining my focus on projects that take more than a few months to complete.',
            'I finish whatever I begin.',
            'My interests change from year to year.',
            'I am diligent. I never give up.',
            'I have been obsessed with a certain idea or project for a short time but later lost interest.',
            'I have overcome setbacks to conquer an important challenge.',
        ];
    }

    // Helper for NEO questions (Short Big Five)
    public function getNeoQuestions()
    {
        return [
            'I am not a worrier.',
            'I like to have a lot of people around me.',
            'I don\'t like to waste my time daydreaming.',
            'I try to be courteous to everyone I meet.',
            'I keep my belongings clean and neat.',
            'I often feel inferior to others.',
            'I laugh easily.',
            'Once I find the right way to do something, I stick to it.',
            'I often get into arguments with my family and co-workers.',
            'I\'m pretty good about pacing myself so as to get things done on time.',
            'When I\'m under a great deal of stress, sometimes I feel like I\'m going to pieces.',
            'I don\'t consider myself especially "lighthearted."',
            'I am intrigued by the patterns I find in art and nature.',
            'Some people think I\'m selfish and egotistical.',
            'I am not a very methodical person.',
            'I rarely feel lonely or blue.',
            'I really enjoy talking to people.',
            'I believe letting students hear controversial speakers can only confuse and mislead them.',
            'I would rather cooperate with others than compete with them.',
            'I try to perform all the tasks assigned to me conscientiously.',
            'I often feel tense and jittery.',
            'I like to be where the action is.',
            'Poetry has little or no effect on me.',
            'I tend to be cynical and skeptical of other\'s intentions.',
            'I have a clear set of goals and work toward them in an orderly fashion.',
            'Sometimes I feel completely worthless.',
            'I usually prefer to do things alone.',
            'I often try new and foreign foods.',
            'I believe that most people will take advantage of you if you let them.',
            'I waste a lot of time before settling down to work.',
            'I rarely feel fearful or anxious.',
            'I often feel as if I am bursting with energy.',
            'I seldom notice the moods or feelings that different environments produce.',
            'Most people I know like me.',
            'I work hard to accomplish my goals.',
            'I often get angry at the way people treat me.',
            'I am a cheerful, high-spirited person.',
            'I believe we should look to our religious authorities for decisions on moral issues.',
            'Some people think of me as cold and calculating.',
            'When I make a commitment, I can always be counted on to follow through.',
            'Too often, when things go wrong, I get discouraged and feel like giving up.',
            'I am not a cheerful optimist.',
            'Sometimes when I am reading poetry or looking at a work of art, I feel a chill or wave of excitement.',
            'I\'m hard-headed and tough-minded in my attitudes.',
            'Sometimes I\'m not as dependable or reliable as I should be.',
            'I am seldom sad or depressed.',
            'My life is fast-paced.',
            'I have little interest in speculating on the nature of the universe or the human condition.',
            'I generally try to be thoughtful and considerate.',
            'I am a productive person who always gets the job done.',
            'I often feel helpless and want someone else to solve my problems.',
            'I am a very active person.',
            'I have a lot of intellectual curiosity.',
            'If I don\'t like people, I let them know it.',
            'I never seem to be able to get organized.',
            'At times I have been so ashamed I just wanted to hide.',
            'I would rather go my own way than be a leader of others.',
            'I often enjoy playing with theories or abstract ideas.',
            'If necessary, I am willing to manipulate people.',
            'I strive for excellence in everything I do.',
        ];
    }

    // Helper for WVI questions
    public function getWviQuestions()
    {
        return [
            'have to keep solving problems',
            'help others',
            'can get a raise',
            'look forward to changes in your job',
            'have freedom in your area',
            'gain prestige in your field',
            'need to have artistic ability',
            'are one of the gang',
            'know your job will last',
            'can be the kind of person you would like to be',
            'have a boss who gives you a fair deal',
            'like the setting in which your work is done',
            'get the feeling of having done a good day\'s work',
            'have the authority over others',
            'try out new ideas and suggestions',
            'create something new',
            'know by the results when you\'ve done a good job',
            'have a boss who is reasonable',
            'are sure of always having a job',
            'add beauty to the world',
            'make your own decisions',
            'have pay increases that keep up with the cost of living',
            'are mentally challenged',
            'use leadership abilities',
            'have adequate lounge, toilet and other facilities',
            'have a way of life, while not on the job, that you like',
            'form friendships with your fellow employees',
            'know that others consider your work important',
            'do not do the same thing all the time',
            'feel you have helped another person',
            'add to the well-being of other people',
            'do many different things',
            'are looked up to by others',
            'have good connections with fellow workers',
            'lead the kind of life you most enjoy',
            'have a good place in which to work (quiet, calm, etc.)',
            'plan and organize the work of others',
            'need to be mentally alert',
            'are paid enough to live very well',
            'are your own boss',
            'make attractive products',
            'are sure of another job in the company if your present job ends',
            'have a supervisor who is considerate',
            'see the result of your efforts',
            'contribute new ideas',
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

        $grit_questions = $assessment->type === 'GRIT Scale' ? $this->getGritQuestions() : [];
        $neo_questions = $assessment->type === 'Personality (NEO-FFI)' ? $this->getNeoQuestions() : [];
        $wvi_questions = $assessment->type === 'Work Values Inventory' ? $this->getWviQuestions() : [];

        return view('counselor.assessments.show', compact('assessment', 'scores', 'score_interpretation', 'grit_questions', 'neo_questions', 'wvi_questions'));
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
        } elseif ($assessment->type === 'GRIT Scale') {
            $viewData['grit_questions'] = $this->getGritQuestions();
        } elseif ($assessment->type === 'Personality (NEO-FFI)') {
            $viewData['neo_questions'] = $this->getNeoQuestions();
        } elseif ($assessment->type === 'Work Values Inventory') {
            $viewData['wvi_questions'] = $this->getWviQuestions();
        }

        $pdf = Pdf::loadView('counselor.assessments.export', $viewData);
        return $pdf->download('assessment-summary-' . $assessment->id . '.pdf');
    }
}