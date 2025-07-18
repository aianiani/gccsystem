@extends('layouts.app')

@section('content')
<style>
    .assessment-header {
        color: #2d5016;
        font-weight: 700;
        font-size: 2.5rem;
        margin-top: 2.5rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    .assessment-subtitle {
        color: #3d5c2d;
        font-size: 1.15rem;
        margin-bottom: 2.5rem;
        text-align: center;
    }
    .assessment-cards-row {
        display: flex;
        justify-content: center;
        gap: 2.5rem;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
    }
    .assessment-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
        padding: 2.5rem 2rem 2rem 2rem;
        width: 340px;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.2s;
    }
    .assessment-card:hover {
        box-shadow: 0 8px 32px rgba(44, 80, 22, 0.13);
    }
    .assessment-icon {
        font-size: 2.8rem;
        color: #2d5016;
        margin-bottom: 1.2rem;
    }
    .assessment-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
        text-align: center;
    }
    .assessment-desc {
        color: #3d5c2d;
        font-size: 1.05rem;
        margin-bottom: 1.2rem;
        text-align: center;
    }
    .assessment-list {
        list-style: none;
        padding: 0;
        margin-bottom: 1.5rem;
        width: 100%;
    }
    .assessment-list li {
        display: flex;
        align-items: center;
        color: #2d5016;
        font-size: 1.08rem;
        margin-bottom: 0.5rem;
        gap: 0.5rem;
    }
    .assessment-list .bi {
        color: #2d9a36;
        font-size: 1.5rem;
    }
    .assessment-btn {
        background: #2d9a36;
        color: #fff;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 0;
        width: 100%;
        margin-top: 0.5rem;
        transition: background 0.2s;
    }
    .assessment-btn:hover {
        background: #237728;
        color: #fff;
    }
    @media (max-width: 1100px) {
        .assessment-cards-row {
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }
    }
</style>
<div class="container py-4">
    <!-- Back Button -->
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>
    <div class="assessment-header">Mental Health Assessment</div>
    <div class="assessment-subtitle">
        Take a moment to assess your mental well-being. Choose an assessment type below to get started.
    </div>
    <div class="assessment-cards-row" id="assessment-cards">
        <!-- DASS-21 Assessment Card -->
        <div class="assessment-card">
            <div class="assessment-icon"><i class="bi bi-brain"></i></div>
            <div class="assessment-title">DASS-21 Assessment</div>
            <div class="assessment-desc">Depression, Anxiety, and Stress Scale</div>
            <ul class="assessment-list">
                <li><i class="bi bi-check2"></i>21 questions</li>
                <li><i class="bi bi-check2"></i>5-10 minutes</li>
                <li><i class="bi bi-check2"></i>Comprehensive evaluation</li>
            </ul>
            <button class="assessment-btn" id="start-dass21">START ASSESSMENT</button>
        </div>
        <!-- Academic Stress Survey Card -->
        <div class="assessment-card">
            <div class="assessment-icon"><i class="bi bi-heart-pulse"></i></div>
            <div class="assessment-title">Academic Stress Survey</div>
            <div class="assessment-desc">Academic and Personal Stress Evaluation</div>
            <ul class="assessment-list">
                <li><i class="bi bi-check2"></i>15 questions</li>
                <li><i class="bi bi-check2"></i>3-5 minutes</li>
                <li><i class="bi bi-check2"></i>Focused on academic life</li>
            </ul>
            <button class="assessment-btn" id="start-academic">START SURVEY</button>
        </div>
        <!-- Wellness Check Card -->
        <div class="assessment-card">
            <div class="assessment-icon"><i class="bi bi-flower2"></i></div>
            <div class="assessment-title">Wellness Check</div>
            <div class="assessment-desc">Overall Mental Wellness Assessment</div>
            <ul class="assessment-list">
                <li><i class="bi bi-check2"></i>12 questions</li>
                <li><i class="bi bi-check2"></i>3-5 minutes</li>
                <li><i class="bi bi-check2"></i>Holistic approach</li>
            </ul>
            <button class="assessment-btn" id="start-wellness">START CHECK</button>
        </div>
    </div>
    <!-- DASS-21 Assessment Form (hidden by default) -->
    <div id="dass21-form-container" style="display:none;">
        <form method="POST" action="{{ route('assessments.dass21.submit') }}" class="card p-0 shadow-sm dass21-form" style="max-width: 700px; margin: 0 auto;">
            @csrf
            <div class="dass21-sticky-header" style="position:sticky;top:0;z-index:10;background:#f8f9fa;padding:1.2rem 1.5rem 0.5rem 1.5rem;border-radius:18px 18px 0 0;box-shadow:0 2px 8px rgba(44,80,22,0.04);">
                <h3 class="mb-2 text-center" style="color: #2d5016;">DASS-21 Assessment</h3>
                <div class="progress mb-0" style="height: 18px;">
                    <div id="dass21-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%; font-weight: bold;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="21">0/21</div>
                </div>
            </div>
            <div id="dass21-question-wrapper" class="p-4 pb-0">
                <ol class="dass21-questions-list" style="padding-left: 0;">
                    @foreach($dass21_questions as $idx => $question)
                        <li class="mb-4 dass21-question-item" data-question="{{ $idx }}" style="list-style: none; display: none;">
                            <div class="fw-bold mb-2">{{ ($idx+1) . ". " . $question }}</div>
                            <div class="row g-2 align-items-center dass21-options-row">
                                @for($i=0; $i<=3; $i++)
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-check dass21-option-check w-100">
                                            <input class="form-check-input" type="radio" name="answers[{{ $idx }}]" id="q{{ $idx }}_{{ $i }}" value="{{ $i }}" required tabindex="-1">
                                            <label class="form-check-label w-100" for="q{{ $idx }}_{{ $i }}" style="font-size: 0.98rem;">
                                                {{ [0=>'Did not apply to me at all', 1=>'Applied to me to some degree', 2=>'Applied to me to a considerable degree', 3=>'Applied to me very much or most of the time'][$i] }}
                                            </label>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div class="dass21-nav-controls d-flex justify-content-between align-items-center px-4 pb-4 pt-2" style="background:#f8f9fa;border-radius:0 0 18px 18px;">
                <button type="button" class="btn btn-outline-secondary px-4 py-2" id="dass21-prev" style="visibility:hidden;">Previous</button>
                <button type="button" class="btn btn-outline-success px-4 py-2" id="dass21-next">Next</button>
                <button type="submit" class="btn btn-success px-5 py-2" id="dass21-submit" style="display:none;">Submit Assessment</button>
            </div>
            <!-- Free-text field -->
            <div class="px-4 pb-4">
                <label for="dass21_comment" class="form-label">How are you feeling? (Optional)</label>
                <textarea class="form-control" name="student_comment" id="dass21_comment" rows="2" placeholder="Share anything you'd like with your counselor..."></textarea>
            </div>
            <div id="dass21-summary" style="display:none;" class="p-4">
                <h4 class="mb-3 text-center" style="color:#2d5016;">Review Your Answers</h4>
                <div class="dass21-review-list mb-3">
                    @foreach($dass21_questions as $idx => $question)
                        <div class="dass21-review-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-2 p-3">
                            <div class="dass21-review-question flex-grow-1 mb-2 mb-md-0"><span class="fw-semibold text-dark">{{ ($idx+1) . ". " . $question }}</span></div>
                            <div class="dass21-review-answer text-end">
                                <span class="badge dass21-summary-answer px-3 py-2" data-summary="{{ $idx }}" style="font-size:1rem;">Not answered</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" id="dass21-edit">Edit Answers</button>
                    <button type="submit" class="btn btn-success px-5 py-2 ms-2">Submit Assessment</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Academic Stress Survey Form (hidden by default) -->
    <div id="academic-form-container" style="display:none;">
        <form method="POST" action="{{ route('assessments.academic.submit') }}" class="card p-0 shadow-sm dass21-form" style="max-width: 700px; margin: 0 auto;">
            @csrf
            <div class="dass21-sticky-header" style="position:sticky;top:0;z-index:10;background:#f8f9fa;padding:1.2rem 1.5rem 0.5rem 1.5rem;border-radius:18px 18px 0 0;box-shadow:0 2px 8px rgba(44,80,22,0.04);">
                <h3 class="mb-2 text-center" style="color: #2d5016;">Academic Stress Survey</h3>
                <div class="progress mb-0" style="height: 18px;">
                    <div id="academic-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%; font-weight: bold;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="15">0/15</div>
                </div>
            </div>
            <div id="academic-question-wrapper" class="p-4 pb-0">
                <ol class="dass21-questions-list" style="padding-left: 0;">
                    @foreach($academic_questions as $idx => $question)
                        <li class="mb-4 academic-question-item" data-question="{{ $idx }}" style="list-style: none; display: none;">
                            <div class="fw-bold mb-2">{{ ($idx+1) . ". " . $question }}</div>
                            <div class="row g-2 align-items-center dass21-options-row">
                                @for($i=0; $i<=3; $i++)
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-check dass21-option-check w-100">
                                            <input class="form-check-input" type="radio" name="academic_answers[{{ $idx }}]" id="aq{{ $idx }}_{{ $i }}" value="{{ $i }}" required tabindex="-1">
                                            <label class="form-check-label w-100" for="aq{{ $idx }}_{{ $i }}" style="font-size: 0.98rem;">
                                                {{ [0=>'Never', 1=>'Sometimes', 2=>'Often', 3=>'Always'][$i] }}
                                            </label>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div class="dass21-nav-controls d-flex justify-content-between align-items-center px-4 pb-4 pt-2" style="background:#f8f9fa;border-radius:0 0 18px 18px;">
                <button type="button" class="btn btn-outline-secondary px-4 py-2" id="academic-prev" style="visibility:hidden;">Previous</button>
                <button type="button" class="btn btn-outline-success px-4 py-2" id="academic-next">Next</button>
                <button type="submit" class="btn btn-success px-5 py-2" id="academic-submit" style="display:none;">Submit Survey</button>
            </div>
            <!-- Free-text field -->
            <div class="px-4 pb-4">
                <label for="academic_comment" class="form-label">How are you feeling? (Optional)</label>
                <textarea class="form-control" name="student_comment" id="academic_comment" rows="2" placeholder="Share anything you'd like with your counselor..."></textarea>
            </div>
            <div id="academic-summary" style="display:none;" class="p-4">
                <h4 class="mb-3 text-center" style="color:#2d5016;">Review Your Answers</h4>
                <div class="dass21-review-list mb-3">
                    @foreach($academic_questions as $idx => $question)
                        <div class="dass21-review-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-2 p-3">
                            <div class="dass21-review-question flex-grow-1 mb-2 mb-md-0"><span class="fw-semibold text-dark">{{ ($idx+1) . ". " . $question }}</span></div>
                            <div class="dass21-review-answer text-end">
                                <span class="badge academic-summary-answer px-3 py-2" data-summary="{{ $idx }}" style="font-size:1rem;">Not answered</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" id="academic-edit">Edit Answers</button>
                    <button type="submit" class="btn btn-success px-5 py-2 ms-2">Submit Survey</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Wellness Check Form (hidden by default) -->
    <div id="wellness-form-container" style="display:none;">
        <form method="POST" action="{{ route('assessments.wellness.submit') }}" class="card p-0 shadow-sm dass21-form" style="max-width: 700px; margin: 0 auto;">
            @csrf
            <div class="dass21-sticky-header" style="position:sticky;top:0;z-index:10;background:#f8f9fa;padding:1.2rem 1.5rem 0.5rem 1.5rem;border-radius:18px 18px 0 0;box-shadow:0 2px 8px rgba(44,80,22,0.04);">
                <h3 class="mb-2 text-center" style="color: #2d5016;">Wellness Check</h3>
                <div class="progress mb-0" style="height: 18px;">
                    <div id="wellness-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%; font-weight: bold;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="12">0/12</div>
                </div>
            </div>
            <div id="wellness-question-wrapper" class="p-4 pb-0">
                <ol class="dass21-questions-list" style="padding-left: 0;">
                    @foreach($wellness_questions as $idx => $question)
                        <li class="mb-4 wellness-question-item" data-question="{{ $idx }}" style="list-style: none; display: none;">
                            <div class="fw-bold mb-2">{{ ($idx+1) . ". " . $question }}</div>
                            <div class="row g-2 align-items-center dass21-options-row">
                                @for($i=0; $i<=3; $i++)
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-check dass21-option-check w-100">
                                            <input class="form-check-input" type="radio" name="wellness_answers[{{ $idx }}]" id="wq{{ $idx }}_{{ $i }}" value="{{ $i }}" required tabindex="-1">
                                            <label class="form-check-label w-100" for="wq{{ $idx }}_{{ $i }}" style="font-size: 0.98rem;">
                                                {{ [0=>'Never', 1=>'Sometimes', 2=>'Often', 3=>'Always'][$i] }}
                                            </label>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div class="dass21-nav-controls d-flex justify-content-between align-items-center px-4 pb-4 pt-2" style="background:#f8f9fa;border-radius:0 0 18px 18px;">
                <button type="button" class="btn btn-outline-secondary px-4 py-2" id="wellness-prev" style="visibility:hidden;">Previous</button>
                <button type="button" class="btn btn-outline-success px-4 py-2" id="wellness-next">Next</button>
                <button type="submit" class="btn btn-success px-5 py-2" id="wellness-submit" style="display:none;">Submit Wellness Check</button>
            </div>
            <!-- Free-text field -->
            <div class="px-4 pb-4">
                <label for="wellness_comment" class="form-label">How are you feeling? (Optional)</label>
                <textarea class="form-control" name="student_comment" id="wellness_comment" rows="2" placeholder="Share anything you'd like with your counselor..."></textarea>
            </div>
            <div id="wellness-summary" style="display:none;" class="p-4">
                <h4 class="mb-3 text-center" style="color:#2d5016;">Review Your Answers</h4>
                <div class="dass21-review-list mb-3">
                    @foreach($wellness_questions as $idx => $question)
                        <div class="dass21-review-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-2 p-3">
                            <div class="dass21-review-question flex-grow-1 mb-2 mb-md-0"><span class="fw-semibold text-dark">{{ ($idx+1) . ". " . $question }}</span></div>
                            <div class="dass21-review-answer text-end">
                                <span class="badge wellness-summary-answer px-3 py-2" data-summary="{{ $idx }}" style="font-size:1rem;">Not answered</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" id="wellness-edit">Edit Answers</button>
                    <button type="submit" class="btn btn-success px-5 py-2 ms-2">Submit Wellness Check</button>
                </div>
            </div>
        </form>
    </div>
    <style>
        .dass21-form {
            background: #f8f9fa;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
        }
        .dass21-questions-list {
            margin-bottom: 0;
        }
        .dass21-question-item {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(44, 80, 22, 0.06);
            padding: 1.2rem 1rem 0.7rem 1rem;
            margin-bottom: 1.2rem;
            border: 2px solid transparent;
            transition: border 0.2s;
        }
        .dass21-question-item.active {
            border: 2px solid #2d9a36;
            box-shadow: 0 4px 16px rgba(44, 80, 22, 0.13);
        }
        .dass21-options-row {
            margin-top: 0.5rem;
        }
        .dass21-option-check {
            background: #e8f5e8;
            border-radius: 8px;
            padding: 0.5rem 0.7rem;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            min-height: 44px;
            margin-bottom: 0.3rem;
        }
        .dass21-option-check input[type="radio"] {
            margin-right: 0.7em;
            margin-top: 0;
            margin-bottom: 0;
            flex-shrink: 0;
            width: 1.2em;
            height: 1.2em;
        }
        .dass21-option-check label {
            margin-bottom: 0;
            flex: 1 1 0%;
            display: flex;
            align-items: center;
            font-size: 0.98rem;
            cursor: pointer;
        }
        .dass21-option-check input[type="radio"]:checked + label {
            font-weight: bold;
            color: #2d5016;
        }
        .dass21-nav-controls {
            border-top: 1px solid #e0e0e0;
        }
        .dass21-review-list {
            width: 100%;
        }
        .dass21-review-item {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(44,80,22,0.06);
            border: 1px solid #e0e0e0;
            min-height: 56px;
            transition: box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .dass21-review-question {
            font-size: 1.04rem;
            color: #2d5016;
            flex: 0 0 60%;
            word-break: break-word;
        }
        .dass21-review-answer {
            flex: 0 0 40%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 0;
        }
        .dass21-review-answer .badge {
            font-size: 1rem;
            min-width: 120px;
            text-align: center;
            background: #e8f5e8;
            color: #2d5016;
            border: 1px solid #c3e6cb;
            max-width: 100%;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }
        .dass21-review-answer .badge.bg-success {
            background: #2d9a36;
            color: #fff;
            border: none;
        }
        .dass21-review-answer .badge.bg-danger {
            background: #dc3545;
            color: #fff;
            border: none;
        }
        @media (max-width: 900px) {
            .dass21-review-question { flex-basis: 100%; }
            .dass21-review-answer { flex-basis: 100%; justify-content: flex-start; margin-top: 0.5rem; }
            .dass21-review-item { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        }
        @media (max-width: 600px) {
            .dass21-form { padding: 0.5rem !important; }
            .dass21-question-item { padding: 0.7rem 0.5rem; }
            .dass21-sticky-header { padding: 1rem 0.5rem 0.5rem 0.5rem; }
            .dass21-nav-controls { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
            .dass21-options-row > div { margin-bottom: 0.5rem; }
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('start-dass21').addEventListener('click', function() {
        document.getElementById('assessment-cards').style.display = 'none';
        document.getElementById('dass21-form-container').style.display = 'block';
        showDass21Question(0);
    });
    document.getElementById('start-academic').addEventListener('click', function() {
        document.getElementById('assessment-cards').style.display = 'none';
        document.getElementById('academic-form-container').style.display = 'block';
        showAcademicQuestion(0); // Ensure first question is shown
    });
    document.getElementById('start-wellness').addEventListener('click', function() {
        document.getElementById('assessment-cards').style.display = 'none';
        document.getElementById('wellness-form-container').style.display = 'block';
        showWellnessQuestion(0);
    });
    // Navigation logic
    const totalQuestions = 21;
    let currentQuestion = 0;
    const questions = document.querySelectorAll('.dass21-question-item');
    const prevBtn = document.getElementById('dass21-prev');
    const nextBtn = document.getElementById('dass21-next');
    const submitBtn = document.getElementById('dass21-submit');
    const summaryDiv = document.getElementById('dass21-summary');
    const questionWrapper = document.getElementById('dass21-question-wrapper');
    const radios = document.querySelectorAll('.dass21-form input[type="radio"]');
    const progressBar = document.getElementById('dass21-progress');
    function showDass21Question(idx) {
        questions.forEach((q, i) => {
            q.style.display = (i === idx) ? '' : 'none';
            q.classList.toggle('active', i === idx);
        });
        prevBtn.style.visibility = idx === 0 ? 'hidden' : 'visible';
        nextBtn.style.display = idx === totalQuestions-1 ? 'none' : '';
        submitBtn.style.display = idx === totalQuestions-1 ? '' : 'none';
        summaryDiv.style.display = 'none';
        questionWrapper.style.display = '';
        updateProgress();
        // Focus first radio for accessibility
        const firstRadio = questions[idx].querySelector('input[type="radio"]');
        if(firstRadio) firstRadio.focus();
    }
    prevBtn.onclick = () => { if(currentQuestion>0) showDass21Question(--currentQuestion); };
    nextBtn.onclick = () => {
        // Require answer before next
        const checked = questions[currentQuestion].querySelector('input[type="radio"]:checked');
        if(!checked) {
            questions[currentQuestion].scrollIntoView({behavior:'smooth',block:'center'});
            questions[currentQuestion].classList.add('border-danger');
            setTimeout(()=>questions[currentQuestion].classList.remove('border-danger'), 1000);
            return;
        }
        if(currentQuestion<totalQuestions-1) showDass21Question(++currentQuestion);
    };
    // Progress bar logic
    function updateProgress() {
        const answered = new Set();
        radios.forEach(r => { if(r.checked) answered.add(r.name); });
        const count = answered.size;
        const percent = Math.round((count/totalQuestions)*100);
        progressBar.style.width = percent + '%';
        progressBar.setAttribute('aria-valuenow', count);
        progressBar.textContent = count + '/21';
    }
    radios.forEach(r => r.addEventListener('change', updateProgress));
    // Show summary before submit
    submitBtn.onclick = function(e) {
        e.preventDefault();
        // Fill summary
        document.querySelectorAll('.dass21-summary-answer').forEach(span => {
            const idx = span.getAttribute('data-summary');
            const checked = document.querySelector('input[name="answers['+idx+']"]:checked');
            if(checked) {
                span.textContent = checked.nextElementSibling.textContent;
                span.className = 'badge bg-success dass21-summary-answer';
            } else {
                span.textContent = 'Not answered';
                span.className = 'badge bg-danger dass21-summary-answer';
            }
        });
        summaryDiv.style.display = '';
        questionWrapper.style.display = 'none';
        prevBtn.style.display = nextBtn.style.display = submitBtn.style.display = 'none';
    };
    var dass21EditBtn = document.getElementById('dass21-edit');
    if (dass21EditBtn) {
        dass21EditBtn.onclick = function() {
        summaryDiv.style.display = 'none';
        questionWrapper.style.display = '';
        showDass21Question(currentQuestion);
        prevBtn.style.display = nextBtn.style.display = '';
        submitBtn.style.display = currentQuestion === totalQuestions-1 ? '' : 'none';
    };
    }
    // On page load, show first question if form is visible
    if(document.getElementById('dass21-form-container').style.display !== 'none') showDass21Question(0);

    // Academic Survey Navigation
    const academicTotal = {{ count($academic_questions) }};
    let academicCurrent = 0;
    const academicQuestions = document.querySelectorAll('.academic-question-item');
    const academicPrevBtn = document.getElementById('academic-prev');
    const academicNextBtn = document.getElementById('academic-next');
    const academicSubmitBtn = document.getElementById('academic-submit');
    const academicSummaryDiv = document.getElementById('academic-summary');
    const academicWrapper = document.getElementById('academic-question-wrapper');
    const academicRadios = document.querySelectorAll('input[name^="academic_answers"]');
    const academicProgressBar = document.getElementById('academic-progress');
    function showAcademicQuestion(idx) {
        academicQuestions.forEach((q, i) => {
            q.style.display = (i === idx) ? '' : 'none';
            q.classList.toggle('active', i === idx);
        });
        academicPrevBtn.style.visibility = idx === 0 ? 'hidden' : 'visible';
        academicNextBtn.style.display = idx === academicTotal-1 ? 'none' : '';
        academicSubmitBtn.style.display = idx === academicTotal-1 ? '' : 'none';
        academicSummaryDiv.style.display = 'none';
        academicWrapper.style.display = '';
        updateAcademicProgress();
        const firstRadio = academicQuestions[idx].querySelector('input[type="radio"]');
        if(firstRadio) firstRadio.focus();
    }
    academicPrevBtn.onclick = () => { if(academicCurrent>0) showAcademicQuestion(--academicCurrent); };
    academicNextBtn.onclick = () => {
        const checked = academicQuestions[academicCurrent].querySelector('input[type="radio"]:checked');
        if(!checked) {
            academicQuestions[academicCurrent].scrollIntoView({behavior:'smooth',block:'center'});
            academicQuestions[academicCurrent].classList.add('border-danger');
            setTimeout(()=>academicQuestions[academicCurrent].classList.remove('border-danger'), 1000);
            return;
        }
        if(academicCurrent<academicTotal-1) showAcademicQuestion(++academicCurrent);
    };
    function updateAcademicProgress() {
        const answered = new Set();
        academicRadios.forEach(r => { if(r.checked) answered.add(r.name); });
        const count = answered.size;
        const percent = Math.round((count/academicTotal)*100);
        academicProgressBar.style.width = percent + '%';
        academicProgressBar.setAttribute('aria-valuenow', count);
        academicProgressBar.textContent = count + '/15';
    }
    academicRadios.forEach(r => r.addEventListener('change', updateAcademicProgress));
    academicSubmitBtn.onclick = function(e) {
        e.preventDefault();
        document.querySelectorAll('.academic-summary-answer').forEach(span => {
            const idx = span.getAttribute('data-summary');
            const checked = document.querySelector('input[name="academic_answers['+idx+']"]:checked');
            if(checked) {
                span.textContent = checked.nextElementSibling.textContent;
                span.className = 'badge bg-success academic-summary-answer';
            } else {
                span.textContent = 'Not answered';
                span.className = 'badge bg-danger academic-summary-answer';
            }
        });
        academicSummaryDiv.style.display = '';
        academicWrapper.style.display = 'none';
        academicPrevBtn.style.display = academicNextBtn.style.display = academicSubmitBtn.style.display = 'none';
    };
    var academicEditBtn = document.getElementById('academic-edit');
    if (academicEditBtn) {
        academicEditBtn.onclick = function() {
        academicSummaryDiv.style.display = 'none';
        academicWrapper.style.display = '';
        showAcademicQuestion(academicCurrent);
        academicPrevBtn.style.display = academicNextBtn.style.display = '';
        academicSubmitBtn.style.display = academicCurrent === academicTotal-1 ? '' : 'none';
    };
    }
    if(document.getElementById('academic-form-container').style.display !== 'none') showAcademicQuestion(0);

    // Wellness Check Navigation
    const wellnessTotal = {{ count($wellness_questions) }};
    let wellnessCurrent = 0;
    const wellnessQuestions = document.querySelectorAll('.wellness-question-item');
    const wellnessPrevBtn = document.getElementById('wellness-prev');
    const wellnessNextBtn = document.getElementById('wellness-next');
    const wellnessSubmitBtn = document.getElementById('wellness-submit');
    const wellnessSummaryDiv = document.getElementById('wellness-summary');
    const wellnessWrapper = document.getElementById('wellness-question-wrapper');
    const wellnessRadios = document.querySelectorAll('input[name^="wellness_answers"]');
    const wellnessProgressBar = document.getElementById('wellness-progress');
    function showWellnessQuestion(idx) {
        wellnessQuestions.forEach((q, i) => {
            q.style.display = (i === idx) ? '' : 'none';
            q.classList.toggle('active', i === idx);
        });
        wellnessPrevBtn.style.visibility = idx === 0 ? 'hidden' : 'visible';
        wellnessNextBtn.style.display = idx === wellnessTotal-1 ? 'none' : '';
        wellnessSubmitBtn.style.display = idx === wellnessTotal-1 ? '' : 'none';
        wellnessSummaryDiv.style.display = 'none';
        wellnessWrapper.style.display = '';
        updateWellnessProgress();
        const firstRadio = wellnessQuestions[idx].querySelector('input[type="radio"]');
        if(firstRadio) firstRadio.focus();
    }
    wellnessPrevBtn.onclick = () => { if(wellnessCurrent>0) showWellnessQuestion(--wellnessCurrent); };
    wellnessNextBtn.onclick = () => {
        const checked = wellnessQuestions[wellnessCurrent].querySelector('input[type="radio"]:checked');
        if(!checked) {
            wellnessQuestions[wellnessCurrent].scrollIntoView({behavior:'smooth',block:'center'});
            wellnessQuestions[wellnessCurrent].classList.add('border-danger');
            setTimeout(()=>wellnessQuestions[wellnessCurrent].classList.remove('border-danger'), 1000);
            return;
        }
        if(wellnessCurrent<wellnessTotal-1) showWellnessQuestion(++wellnessCurrent);
    };
    function updateWellnessProgress() {
        const answered = new Set();
        wellnessRadios.forEach(r => { if(r.checked) answered.add(r.name); });
        const count = answered.size;
        const percent = Math.round((count/wellnessTotal)*100);
        wellnessProgressBar.style.width = percent + '%';
        wellnessProgressBar.setAttribute('aria-valuenow', count);
        wellnessProgressBar.textContent = count + '/12';
    }
    wellnessRadios.forEach(r => r.addEventListener('change', updateWellnessProgress));
    wellnessSubmitBtn.onclick = function(e) {
        e.preventDefault();
        document.querySelectorAll('.wellness-summary-answer').forEach(span => {
            const idx = span.getAttribute('data-summary');
            const checked = document.querySelector('input[name="wellness_answers['+idx+']"]:checked');
            if(checked) {
                span.textContent = checked.nextElementSibling.textContent;
                span.className = 'badge bg-success wellness-summary-answer';
            } else {
                span.textContent = 'Not answered';
                span.className = 'badge bg-danger wellness-summary-answer';
            }
        });
        wellnessSummaryDiv.style.display = '';
        wellnessWrapper.style.display = 'none';
        wellnessPrevBtn.style.display = wellnessNextBtn.style.display = wellnessSubmitBtn.style.display = 'none';
    };
    var wellnessEditBtn = document.getElementById('wellness-edit');
    if (wellnessEditBtn) {
        wellnessEditBtn.onclick = function() {
        wellnessSummaryDiv.style.display = 'none';
        wellnessWrapper.style.display = '';
        showWellnessQuestion(wellnessCurrent);
        wellnessPrevBtn.style.display = wellnessNextBtn.style.display = '';
        wellnessSubmitBtn.style.display = wellnessCurrent === wellnessTotal-1 ? '' : 'none';
    };
    }
    if(document.getElementById('wellness-form-container').style.display !== 'none') showWellnessQuestion(0);
    });
    </script>
@if(session('show_thank_you'))
<!-- Thank You Modal -->
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center" id="thankYouModalLabel">Thank You!</h5>
      </div>
      <div class="modal-body text-center">
        @php $type = session('last_assessment_type', 'DASS-21'); @endphp
        @if($type === 'DASS-21')
        <p class="mb-3">Thank you for completing the DASS-21 assessment.<br>Your responses have been submitted for review by a counselor.<br><span class="text-muted small">If you have any urgent concerns, please reach out to the guidance office directly.</span></p>
        @elseif($type === 'Academic Stress Survey')
        <p class="mb-3">Thank you for completing the Academic Stress Survey.<br>Your responses have been submitted for review by a counselor.<br><span class="text-muted small">If you have any urgent concerns, please reach out to the guidance office directly.</span></p>
        @elseif($type === 'Wellness Check')
        <p class="mb-3">Thank you for completing the Wellness Check.<br>Your responses have been submitted for review by a counselor.<br><span class="text-muted small">If you have any urgent concerns, please reach out to the guidance office directly.</span></p>
        @else
        <p class="mb-3">Thank you for completing the assessment.<br>Your responses have been submitted for review by a counselor.<br><span class="text-muted small">If you have any urgent concerns, please reach out to the guidance office directly.</span></p>
        @endif
        <a href="{{ route('dashboard') }}" class="btn btn-success px-4">Back to Dashboard</a>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var thankYouModal = new bootstrap.Modal(document.getElementById('thankYouModal'));
    thankYouModal.show();
});
</script>
@endif
@endsection 