@php
    // DASS-42 Questions
    $questions = [
        1 => "I found myself getting upset by quite trivial things.",
        2 => "I was aware of dryness of my mouth.",
        3 => "I couldn't seem to experience any positive feeling at all.",
        4 => "I experienced breathing difficulty (e.g. excessively rapid breathing, breathlessness in the absence of physical exertion).",
        5 => "I just couldn't seem to get going.",
        6 => "I tended to over-react to situations.",
        7 => "I had a feeling of shakiness (e.g. legs going to give way).",
        8 => "I found it difficult to relax.",
        9 => "I found myself in situations that made me so anxious I was most relieved when they ended.",
        10 => "I felt that I had nothing to look forward to.",
        11 => "I found myself getting upset rather easily.",
        12 => "I felt that I was using a lot of nervous energy.",
        13 => "I felt sad and depressed.",
        14 => "I found myself getting impatient when I was delayed in any way (e.g. elevators, traffic lights, being kept waiting).",
        15 => "I had a feeling of faintness.",
        16 => "I felt that I had lost interest in just about everything.",
        17 => "I felt I wasn't worth much as a person.",
        18 => "I felt that I was rather touchy.",
        19 => "I perspired noticeably (e.g. hands sweaty) in the absence of high temperatures or physical exertion.",
        20 => "I felt scared without any good reason.",
        21 => "I felt that life wasn't worthwhile.",
        22 => "I found it hard to wind down.",
        23 => "I had difficulty in swallowing.",
        24 => "I couldn't seem to get any enjoyment out of the things I did.",
        25 => "I was aware of dryness of my heart in the absence of physical exertion (e.g. sense of heart rate increase, heart pounding).",
        26 => "I felt down-hearted and blue.",
        27 => "I found that I was very irritable.",
        28 => "I felt I was close to panic.",
        29 => "I found it hard to calm down after something upset me.",
        30 => "I feared that I would be 'thrown' by some trivial unfamiliar task.",
        31 => "I was unable to become enthusiastic about anything.",
        32 => "I found it difficult to tolerate interruptions to what I was doing.",
        33 => "I was in a state of nervous tension.",
        34 => "I felt I was pretty worthless.",
        35 => "I was intolerant of anything that kept me from getting on with what I was doing.",
        36 => "I felt terrified.",
        37 => "I could see nothing in the future to be hopeful about.",
        38 => "I felt that life was meaningless.",
        39 => "I found myself getting agitated.",
        40 => "I was worried about situations in which I might panic and make a fool of myself.",
        41 => "I experienced trembling (e.g. in the hands).",
        42 => "I found it difficult to work up the initiative to do things.",
    ];
    
    // Get student answers from assessment->score
    $studentAnswers = [];
    if ($assessment->score) {
        if (is_array($assessment->score)) {
            $studentAnswers = $assessment->score;
        } elseif (is_string($assessment->score)) {
            $studentAnswers = json_decode($assessment->score, true) ?? [];
        }
    }
@endphp

<div class="dass42-questionnaire">
    <!-- Rating Scale Instructions -->
    <div class="card mb-4 border-0 shadow-sm" style="background: #f8f9fa;">
        <div class="card-body">
            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Rating Scale Instructions</h6>
            <p class="small mb-2">Please read each statement and circle a number 0, 1, 2 or 3 which indicates how much the statement applied to the student over the past week. There are no right or wrong answers. Do not spend too much time on any one statement.</p>
            
            <div class="mt-3">
                <p class="small fw-bold mb-2">The rating scale is as follows:</p>
                <ul class="small mb-0" style="list-style: none; padding-left: 0;">
                    <li><span class="badge bg-success">0</span> <strong>Did not apply</strong> - Did not apply to me at all</li>
                    <li><span class="badge bg-info">1</span> <strong>Sometimes</strong> - Applied to me to some degree, or some of the time</li>
                    <li><span class="badge bg-warning text-dark">2</span> <strong>Often</strong> - Applied to me to a considerable degree, or a good part of time</li>
                    <li><span class="badge bg-danger">3</span> <strong>Very Much</strong> - Applied to me very much, or most of the time</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Questions Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px; text-align: center;">Q</th>
                    <th>Statement</th>
                    <th style="width: 80px; text-align: center;">0</th>
                    <th style="width: 80px; text-align: center;">1</th>
                    <th style="width: 80px; text-align: center;">2</th>
                    <th style="width: 80px; text-align: center;">3</th>
                    <th style="width: 100px; text-align: center;">Answer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $qNum => $question)
                    @php
                        $answer = $studentAnswers[$qNum] ?? null;
                    @endphp
                    <tr>
                        <td style="text-align: center; font-weight: bold; background: #f8f9fa;">{{ $qNum }}</td>
                        <td>{{ $question }}</td>
                        <td style="text-align: center;">
                            @if($answer === 0 || $answer === '0')
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 1.2rem;"></i>
                            @else
                                <span class="text-muted">○</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($answer === 1 || $answer === '1')
                                <i class="bi bi-check-circle-fill text-info" style="font-size: 1.2rem;"></i>
                            @else
                                <span class="text-muted">○</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($answer === 2 || $answer === '2')
                                <i class="bi bi-check-circle-fill text-warning" style="font-size: 1.2rem;"></i>
                            @else
                                <span class="text-muted">○</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($answer === 3 || $answer === '3')
                                <i class="bi bi-check-circle-fill text-danger" style="font-size: 1.2rem;"></i>
                            @else
                                <span class="text-muted">○</span>
                            @endif
                        </td>
                        <td style="text-align: center; font-weight: bold; background: #f8f9fa;">
                            @if($answer !== null)
                                <span class="badge 
                                    @if($answer === 0 || $answer === '0') bg-success
                                    @elseif($answer === 1 || $answer === '1') bg-info
                                    @elseif($answer === 2 || $answer === '2') bg-warning text-dark
                                    @elseif($answer === 3 || $answer === '3') bg-danger
                                    @endif">
                                    {{ $answer }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Legend -->
    <div class="card mt-4 border-0 shadow-sm" style="background: #f0f8f0;">
        <div class="card-body">
            <h6 class="fw-bold mb-2"><i class="bi bi-bookmark me-2"></i>Color Legend</h6>
            <div class="row g-2 small">
                <div class="col-md-3">
                    <span class="badge bg-success me-2">0</span> Not Applicable
                </div>
                <div class="col-md-3">
                    <span class="badge bg-info me-2">1</span> Some Degree
                </div>
                <div class="col-md-3">
                    <span class="badge bg-warning text-dark me-2">2</span> Considerable Degree
                </div>
                <div class="col-md-3">
                    <span class="badge bg-danger me-2">3</span> Very Much
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dass42-questionnaire .table {
        margin-bottom: 0;
    }
    
    .dass42-questionnaire .table th {
        background-color: #f0f0f0;
        color: #1f7a2d;
        font-weight: 700;
        border-color: #ddd;
    }
    
    .dass42-questionnaire .table td {
        vertical-align: middle;
        border-color: #ddd;
    }
    
    .dass42-questionnaire .table tbody tr:hover {
        background-color: #f9f9f9;
    }
    
    @media (max-width: 768px) {
        .dass42-questionnaire .table {
            font-size: 0.85rem;
        }
        
        .dass42-questionnaire .table thead th {
            padding: 0.5rem 0.25rem;
        }
        
        .dass42-questionnaire .table td {
            padding: 0.5rem 0.25rem;
        }
    }
</style>
