@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        .home-zoom {
            zoom: 75%;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top left;
                width: 133.33%;
            }
        }

        body {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%) !important;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            background: var(--hero-gradient);
            color: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(60px);
        }

        .evaluate-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .evaluate-header {
            background: var(--light-green);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .main-dashboard-content {
            margin-left: 240px;
        }

        .btn-submit {
            background: var(--forest-green);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(31, 122, 45, 0.2);
            color: white;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            font-size: 2.5rem;
            color: #ddd;
            transition: color 0.2s;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: var(--yellow-maize);
        }

        .form-check.border {
            border-width: 2px !important;
            border-color: #e0e0e0 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            padding: 0.75rem 1rem !important;
            margin-bottom: 0.5rem;
        }

        .form-check.border:hover {
            border-color: var(--seminar-color) !important;
            opacity: 0.9;
        }

        .form-check-input:checked+.form-check-label {
            font-weight: 700;
            color: var(--seminar-color);
        }

        .form-check.border:has(.form-check-input:checked) {
            border-color: var(--seminar-color) !important;
            background-color: var(--seminar-bg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Thicker circles for radio inputs */
        .form-check-input {
            border-width: 2px !important;
            border-color: #adb5bd !important;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-check-input:hover {
            border-color: var(--seminar-color) !important;
            box-shadow: 0 0 0 0.25rem rgba(0, 0, 0, 0.05);
        }

        .form-check-input:checked {
            background-color: var(--seminar-color) !important;
            border-color: var(--seminar-color) !important;
        }

        .seminar-section-title {
            color: var(--seminar-color);
            border-bottom: 2px solid var(--seminar-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
    </style>

    <div class="d-flex home-zoom">
        @include('student.sidebar')

        <div class="main-dashboard-content flex-grow-1">
            <div class="container-fluid py-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div style="z-index: 2; position: relative;">
                            <h1 class="mb-2 fw-bold" style="color: var(--yellow-maize);">
                                <i class="bi bi-pencil-square me-2"></i>
                                Evaluate Seminar
                            </h1>
                            <p class="mb-0 opacity-90 fs-5">Share your feedback for {{ $seminar->name }}</p>
                        </div>
                        <div style="z-index: 2;">
                            <a href="{{ route('student.seminars.index') }}" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left me-2"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        @php
                            $branding = [
                                'IDREAMS' => ['color' => '#0dcaf0', 'icon' => 'bi-clouds-fill', 'bg' => 'rgba(13, 202, 240, 0.08)'],
                                '10C' => ['color' => '#FFCB05', 'icon' => 'bi-lightbulb-fill', 'bg' => 'rgba(255, 203, 5, 0.08)'],
                                'LEADS' => ['color' => '#0d6efd', 'icon' => 'bi-people-fill', 'bg' => 'rgba(13, 110, 253, 0.08)'],
                                'IMAGE' => ['color' => '#198754', 'icon' => 'bi-person-badge-fill', 'bg' => 'rgba(25, 135, 84, 0.08)'],
                            ];
                            $style = $branding[$seminar->name] ?? ['color' => '#198754', 'icon' => 'bi-award', 'bg' => '#eaf5ea'];
                        @endphp
                        <div class="evaluate-card"
                            style="--seminar-color: {{ $style['color'] }}; --seminar-bg: {{ $style['bg'] }};">
                            <div class="evaluate-header" style="background: var(--seminar-bg);">
                                <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px; border: 2px solid var(--seminar-color);">
                                    <i class="bi {{ $style['icon'] }} fs-3" style="color: var(--seminar-color);"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold" style="color: var(--seminar-color);">{{ $seminar->name }}</h3>
                                    <p class="mb-0 text-muted small">{{ $seminar->description }}</p>
                                </div>
                            </div>
                            <div class="p-4 p-md-5">
                                <form action="{{ route('student.seminars.store', $seminar->id) }}" method="POST">
                                    @csrf

                                    @if($seminar->name === 'IMAGE')
                                        <div class="mb-5">
                                            <h4 class="fw-bold seminar-section-title">Seminar Questions</h4>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">1. What are your compelling visual as a future
                                                    employee can effectively convey the fundamental values of perseverance,
                                                    humility and commitment in the work setting? <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="answers[q1]" class="form-control" rows="3" required></textarea>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">2. What is your definition of success? <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="answers[q2]" class="form-control" rows="2" required></textarea>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">3. What makes a Filipino leader? <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="answers[q3]" class="form-control" rows="2" required></textarea>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">4. What are the 4 Key traits of GRIT? <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="answers[q4]" class="form-control" rows="2" required></textarea>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">5. How to build GRIT as fresh graduate? <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="answers[q5]" class="form-control" rows="2" required></textarea>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">6. How can you be a resilient board taker
                                                    towards failures & uncertainties? <span class="text-danger">*</span></label>
                                                <textarea name="answers[q6]" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>

                                        <div class="mb-5">
                                            <h4 class="fw-bold seminar-section-title">Evaluation</h4>
                                            <p class="text-muted small mb-4">Kindly provide your honest evaluation by clicking
                                                the number that corresponds to your level of satisfaction for each criterion
                                                using the scale below:</p>
                                            <div
                                                class="bg-light p-3 rounded mb-4 d-flex justify-content-between flex-wrap gap-2 small fw-bold">
                                                <span>5 - Strongly Agree</span>
                                                <span>4 - Highly Agree</span>
                                                <span>3 - Agree</span>
                                                <span>2 - Disagree</span>
                                                <span>1 - Strongly Disagree</span>
                                            </div>

                                            @php
                                                $criteria = [
                                                    'c1' => '1. I have gained information that are useful for my development.',
                                                    'c2' => '2. The program had helped me learn techniques that can be useful in my academic adjustments.',
                                                    'c3' => '3. Through the program, my confidence to enhance my learning for my development improvement was strengthened.',
                                                    'c4' => '4. The speakers have presented the discussion themes with mastery and facilitative attitude.',
                                                    'c5' => '5. The program logistics (registration, facilities, etc.) were provided and attended.'
                                                ];
                                            @endphp

                                            @foreach($criteria as $key => $label)
                                                <div class="mb-4 pb-3 border-bottom border-light">
                                                    <label class="form-label fw-bold d-block mb-3">{{ $label }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="d-flex justify-content-between align-items-center"
                                                        style="max-width: 800px; margin: 0 auto;">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <div class="form-check form-check-inline text-center mx-0">
                                                                <input class="form-check-input d-block mx-auto mb-1" type="radio"
                                                                    name="answers[{{ $key }}]" id="{{ $key }}_{{ $i }}" value="{{ $i }}"
                                                                    required>
                                                                <label class="form-check-label small fw-bold" for="{{ $key }}_{{ $i }}">
                                                                    {{ $i }}
                                                                    <div
                                                                        style="font-size: 0.65rem; font-weight: normal; margin-top: 2px;">
                                                                        @if($i == 5) Strongly Agree
                                                                        @elseif($i == 4) Highly Agree
                                                                        @elseif($i == 3) Agree
                                                                        @elseif($i == 2) Disagree
                                                                        @elseif($i == 1) Strongly Disagree
                                                                        @endif
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <h4 class="fw-bold seminar-section-title">COMMENTS AND SUGGESTIONS</h4>
                                                    <label for="comments" class="form-label fw-bold small text-muted">Kindly share any
                                                        other feedback you have *</label>
                                                    <textarea class="form-control bg-light" id="comments" name="comments" rows="4"
                                                        required placeholder="Type your comments and suggestions here..."></textarea>
                                                </div>

                                                <input type="hidden" name="rating" value="5">
                                    @elseif($seminar->name === 'IDREAMS')
                                            <div class="mb-5">
                                                <h4 class="fw-bold seminar-section-title">Seminar Questions</h4>

                                                @php
                                                    $idreams_questions = [
                                                        'q1' => [
                                                            'label' => '1. Emotion is a habit of ____?',
                                                            'options' => ['Mutual Trust', 'Mutual Understanding', 'Mutual Benefits', 'Empathy', 'Management', 'Initiative', 'Communication']
                                                        ],
                                                        'q2' => [
                                                            'label' => '2. Relate is a habit of ____?',
                                                            'options' => ['Mutual Trust', 'Understanding', 'Mutual Benefits', 'Expression', 'Management', 'Attitude', 'Direction']
                                                        ],
                                                        'q3' => [
                                                            'label' => '3. Direction is a habit of____?',
                                                            'options' => ['Initiative', 'Choice', 'Relate', 'Self-Care', 'Vision', 'Mutual Trust', 'Self-esteem']
                                                        ],
                                                        'q4' => [
                                                            'label' => '4. Initiative is a habit of_____?',
                                                            'options' => ['Initiative', 'Direction', 'Relate', 'Choice', 'Management', 'Benefits', 'Self-Care']
                                                        ],
                                                    ];
                                                @endphp

                                                @foreach($idreams_questions as $key => $data)
                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold">{{ $data['label'] }} <span
                                                                class="text-danger">*</span></label>
                                                        <div class="row g-2">
                                                            @foreach($data['options'] as $option)
                                                                <div class="col-md-6 col-lg-3">
                                                                    <div
                                                                        class="form-check p-2 border rounded hover-bg-light transition-all">
                                                                        <input class="form-check-input ms-0 me-2" type="radio"
                                                                            name="answers[{{ $key }}]"
                                                                            id="{{ $key }}_{{ Str::slug($option) }}" value="{{ $option }}"
                                                                            required>
                                                                        <label class="form-check-label w-100 cursor-pointer"
                                                                            for="{{ $key }}_{{ Str::slug($option) }}">
                                                                            {{ $option }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="mb-5">
                                                <h4 class="fw-bold seminar-section-title">Evaluation</h4>
                                                <p class="text-muted small mb-4">Kindly provide your honest evaluation by clicking
                                                    the number that corresponds to your level of satisfaction for each criterion
                                                    using the scale below:</p>
                                                <div
                                                    class="bg-light p-3 rounded mb-4 d-flex justify-content-between flex-wrap gap-2 small fw-bold">
                                                    <span>5 - Strongly Agree</span>
                                                    <span>4 - Highly Agree</span>
                                                    <span>3 - Agree</span>
                                                    <span>2 - Disagree</span>
                                                    <span>1 - Strongly Disagree</span>
                                                </div>

                                                @php
                                                    $criteria = [
                                                        'c1' => '1. I have gained information that are useful for my development.',
                                                        'c2' => '2. The program had helped me learn techniques that can be useful in my academic adjustments.',
                                                        'c3' => '3. Through the program, my confidence to enhance my learning for my development improvement was strengthened.',
                                                        'c4' => '4. The speakers have presented the discussion themes with mastery and facilitative attitude.',
                                                        'c5' => '5. The program logistics (registration, facilities, etc.) were provided and attended.'
                                                    ];
                                                @endphp

                                                @foreach($criteria as $key => $label)
                                                    <div class="mb-4 pb-3 border-bottom border-light">
                                                        <label class="form-label fw-bold d-block mb-3">{{ $label }} <span
                                                                class="text-danger">*</span></label>
                                                        <div class="d-flex justify-content-between align-items-center"
                                                            style="max-width: 800px; margin: 0 auto;">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <div class="form-check form-check-inline text-center mx-0">
                                                                    <input class="form-check-input d-block mx-auto mb-1" type="radio"
                                                                        name="answers[{{ $key }}]" id="{{ $key }}_{{ $i }}" value="{{ $i }}"
                                                                        required>
                                                                    <label class="form-check-label small fw-bold" for="{{ $key }}_{{ $i }}">
                                                                        {{ $i }}
                                                                        <div
                                                                            style="font-size: 0.65rem; font-weight: normal; margin-top: 2px;">
                                                                            @if($i == 5) Strongly Agree
                                                                            @elseif($i == 4) Highly Agree
                                                                            @elseif($i == 3) Agree
                                                                            @elseif($i == 2) Disagree
                                                                            @elseif($i == 1) Strongly Disagree
                                                                            @endif
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                                <h4 class="fw-bold seminar-section-title">COMMENTS AND SUGGESTIONS</h4>
                                                <label for="comments" class="form-label fw-bold small text-muted">Kindly share any
                                                    other feedback you have *</label>
                                                <textarea class="form-control bg-light" id="comments" name="comments" rows="4"
                                                    required placeholder="Type your comments and suggestions here..."></textarea>
                                            </div>

                                            <input type="hidden" name="rating" value="5">
                                        @elseif($seminar->name === '10C')
                                            <div class="mb-5">
                                                <h4 class="fw-bold seminar-section-title">Seminar Questions</h4>

                                                @php
                                                    $ten_c_questions = [
                                                        'q1' => [
                                                            'label' => '1. The title topic for challenging negative thought is...',
                                                            'options' => ['Contribution', 'Cognizance', 'Consciousness', 'Control', 'Cause', 'Competence', 'Coping', 'Connection', 'Confidence', 'Character']
                                                        ],
                                                        'q2' => [
                                                            'label' => '2. The title topic for making the right choice is...',
                                                            'options' => ['Contribution', 'Cognizance', 'Consciousness', 'Control', 'Cause', 'Competence', 'Coping', 'Connection', 'Confidence', 'Character']
                                                        ],
                                                        'q3' => [
                                                            'label' => '3. The title topic for solving problem is...',
                                                            'options' => ['Contribution', 'Cognizance', 'Consciousness', 'Control', 'Cause', 'Competence', 'Coping', 'Connection', 'Confidence', 'Character']
                                                        ],
                                                        'q4' => [
                                                            'label' => '4. The title topic for learning mindfulness is...',
                                                            'options' => ['Contribution', 'Cognizance', 'Consciousness', 'Control', 'Cause', 'Competence', 'Coping', 'Connection', 'Confidence', 'Character']
                                                        ],
                                                        'q5' => [
                                                            'label' => '5. The title topic for recognizing goodness and strengths is...',
                                                            'options' => ['Contribution', 'Cognizance', 'Consciousness', 'Control', 'Cause', 'Competence', 'Coping', 'Connection', 'Confidence', 'Character']
                                                        ],
                                                    ];
                                                @endphp

                                                @foreach($ten_c_questions as $key => $data)
                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold">{{ $data['label'] }} <span
                                                                class="text-danger">*</span></label>
                                                        <div class="row g-2">
                                                            @foreach($data['options'] as $option)
                                                                <div class="col-md-6 col-lg-3">
                                                                    <div
                                                                        class="form-check p-2 border rounded hover-bg-light transition-all">
                                                                        <input class="form-check-input ms-0 me-2" type="radio"
                                                                            name="answers[{{ $key }}]"
                                                                            id="{{ $key }}_{{ Str::slug($option) }}" value="{{ $option }}"
                                                                            required>
                                                                        <label class="form-check-label w-100 cursor-pointer"
                                                                            for="{{ $key }}_{{ Str::slug($option) }}">
                                                                            {{ $option }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="mb-5">
                                                <h4 class="fw-bold seminar-section-title">Evaluation</h4>
                                                <p class="text-muted small mb-4">Kindly provide your honest evaluation by clicking
                                                    the number that corresponds to your level of satisfaction for each criterion
                                                    using the scale below:</p>
                                                <div
                                                    class="bg-light p-3 rounded mb-4 d-flex justify-content-between flex-wrap gap-2 small fw-bold">
                                                    <span>5 - Strongly Agree</span>
                                                    <span>4 - Highly Agree</span>
                                                    <span>3 - Agree</span>
                                                    <span>2 - Disagree</span>
                                                    <span>1 - Strongly Disagree</span>
                                                </div>

                                                @php
                                                    $criteria = [
                                                        'c1' => '1. I have gained information that are useful for my development.',
                                                        'c2' => '2. The program had helped me learn techniques that can be useful in my academic adjustments.',
                                                        'c3' => '3. Through the program, my confidence to enhance my learning for my development improvement was strengthened.',
                                                        'c4' => '4. The speakers have presented the discussion themes with mastery and facilitative attitude.',
                                                        'c5' => '5. The program logistics (registration, facilities, etc.) were provided and attended.'
                                                    ];
                                                @endphp

                                                @foreach($criteria as $key => $label)
                                                    <div class="mb-4 pb-3 border-bottom border-light">
                                                        <label class="form-label fw-bold d-block mb-3">{{ $label }} <span
                                                                class="text-danger">*</span></label>
                                                        <div class="d-flex justify-content-between align-items-center"
                                                            style="max-width: 800px; margin: 0 auto;">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <div class="form-check form-check-inline text-center mx-0">
                                                                    <input class="form-check-input d-block mx-auto mb-1" type="radio"
                                                                        name="answers[{{ $key }}]" id="{{ $key }}_{{ $i }}" value="{{ $i }}"
                                                                        required>
                                                                    <label class="form-check-label small fw-bold" for="{{ $key }}_{{ $i }}">
                                                                        {{ $i }}
                                                                        <div
                                                                            style="font-size: 0.65rem; font-weight: normal; margin-top: 2px;">
                                                                            @if($i == 5) Strongly Agree
                                                                            @elseif($i == 4) Highly Agree
                                                                            @elseif($i == 3) Agree
                                                                            @elseif($i == 2) Disagree
                                                                            @elseif($i == 1) Strongly Disagree
                                                                            @endif
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="mb-4">
                                                <h4 class="fw-bold seminar-section-title">COMMENTS AND SUGGESTIONS</h4>
                                                <label for="comments" class="form-label fw-bold small text-muted">Kindly share any
                                                    other feedback you have *</label>
                                                <textarea class="form-control bg-light" id="comments" name="comments" rows="4"
                                                    required placeholder="Type your comments and suggestions here..."></textarea>
                                            </div>

                                            <input type="hidden" name="rating" value="5">
                                        @elseif($seminar->name === 'LEADS')
                                            <div class="mb-5">
                                                <h4 class="fw-bold seminar-section-title">Seminar Questions</h4>

                                                @php
                                                    $leads_questions = [
                                                        'q1' => [
                                                            'label' => '1. It is the psychological traits that plays a major role in people.',
                                                            'options' => ['Attitude', 'Behavior', 'Personality', 'None of the above']
                                                        ],
                                                        'q2' => [
                                                            'label' => '2. It is the way that people reacts or does things depending on a given circumstance.',
                                                            'options' => ['Attitude', 'Behavior', 'Personality', 'None of the above']
                                                        ],
                                                        'q3' => [
                                                            'label' => "3. It is a person's disposition or thought process.",
                                                            'options' => ['Attitude', 'Behavior', 'Personality', 'None of the above']
                                                        ],
                                                        'q4' => [
                                                            'label' => "4. Which of the choices below does not contribute in determining one's personality?",
                                                            'options' => ['Ability to handle pressure', 'Words you speak', 'Body language', 'Thoughts and ideas', 'None of the above']
                                                        ],
                                                        'q5' => [
                                                            'label' => '5. Which of the choices below does not belong on ways to make people like you?',
                                                            'options' => ['Make the other person feel important and do it sincerely.', 'Be a good listener.', 'Become genuinely interested in other people.', 'Smiling', "Talk in terms of the other person's interest.", 'None of the above', 'All of the above']
                                                        ],
                                                        'q6' => [
                                                            'label' => '6. Why do people get angry?',
                                                            'options' => ['Because of the "I" mentality', 'Authoritative mentality', 'habituated to controlling everybody and everything.', 'Stubbornness', "Other's status and thinking power are below their level an dignity", 'None of the above', 'All of the above']
                                                        ],
                                                        'q7' => [
                                                            'label' => '7. It is our mental, physical, emotional, and behavioral reactions to any perceived demands or threats.',
                                                            'options' => ['Eustress', 'Anger', 'Defense mechanisms', 'Coping', 'Stress', 'None of the above']
                                                        ],
                                                        'q8' => [
                                                            'label' => '8. It is a form of stress that is positive and beneficial.',
                                                            'options' => ['Stress Management', 'Coping mechanism', 'Eustress', 'Flight', 'Fight', 'None of the above']
                                                        ],
                                                        'q9' => [
                                                            'label' => "9. It is knowing when your resources are running low, and stepping back to replenish them rather than letting them all drain away. It's about being kind to yourself as you would be to others.",
                                                            'options' => ['Stress Management', 'Coping mechanism', 'Eustress', 'Self-Care', 'Break', 'None of the above']
                                                        ],
                                                        'q10' => [
                                                            'label' => "10. TRUE or FALSE: In time management, the key is not to prioritize what's in your schedule, but to schedule your priorities.",
                                                            'options' => ['TRUE', 'FALSE']
                                                        ],
                                                    ];
                                                @endphp

                                                @foreach($leads_questions as $key => $data)
                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold">{{ $data['label'] }} <span
                                                                class="text-danger">*</span></label>
                                                        <div class="row g-2">
                                                            @foreach($data['options'] as $option)
                                                                <div class="{{ $key === 'q10' ? 'col-md-6' : 'col-md-6 col-lg-3' }}">
                                                                    <div
                                                                        class="form-check p-2 border rounded hover-bg-light transition-all">
                                                                        <input class="form-check-input ms-0 me-2" type="radio"
                                                                            name="answers[{{ $key }}]"
                                                                            id="{{ $key }}_{{ Str::slug($option) }}" value="{{ $option }}"
                                                                            required>
                                                                        <label class="form-check-label w-100 cursor-pointer"
                                                                            for="{{ $key }}_{{ Str::slug($option) }}">
                                                                            {{ $option }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="mb-5">
                                                <h4 class="fw-bold seminar-section-title">Evaluation</h4>
                                                <p class="text-muted small mb-4">Kindly provide your honest evaluation by clicking
                                                    the number that corresponds to your level of satisfaction for each criterion
                                                    using the scale below:</p>
                                                <div
                                                    class="bg-light p-3 rounded mb-4 d-flex justify-content-between flex-wrap gap-2 small fw-bold">
                                                    <span>5 - Strongly Agree</span>
                                                    <span>4 - Highly Agree</span>
                                                    <span>3 - Agree</span>
                                                    <span>2 - Disagree</span>
                                                    <span>1 - Strongly Disagree</span>
                                                </div>

                                                @php
                                                    $criteria = [
                                                        'c1' => '1. I have gained information that are useful for my development.',
                                                        'c2' => '2. The program had helped me learn techniques that can be useful in my academic adjustments.',
                                                        'c3' => '3. Through the program, my confidence to enhance my learning for my development improvement was strengthened.',
                                                        'c4' => '4. The speakers have presented the discussion themes with mastery and facilitative attitude.',
                                                        'c5' => '5. The program logistics (registration, facilities, etc.) were provided and attended.'
                                                    ];
                                                @endphp

                                                @foreach($criteria as $key => $label)
                                                    <div class="mb-4 pb-3 border-bottom border-light">
                                                        <label class="form-label fw-bold d-block mb-3">{{ $label }} <span
                                                                class="text-danger">*</span></label>
                                                        <div class="d-flex justify-content-between align-items-center"
                                                            style="max-width: 800px; margin: 0 auto;">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <div class="form-check form-check-inline text-center mx-0">
                                                                    <input class="form-check-input d-block mx-auto mb-1" type="radio"
                                                                        name="answers[{{ $key }}]" id="{{ $key }}_{{ $i }}" value="{{ $i }}"
                                                                        required>
                                                                    <label class="form-check-label small fw-bold" for="{{ $key }}_{{ $i }}">
                                                                        {{ $i }}
                                                                        <div
                                                                            style="font-size: 0.65rem; font-weight: normal; margin-top: 2px;">
                                                                            @if($i == 5) Strongly Agree
                                                                            @elseif($i == 4) Highly Agree
                                                                            @elseif($i == 3) Agree
                                                                            @elseif($i == 2) Disagree
                                                                            @elseif($i == 1) Strongly Disagree
                                                                            @endif
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="mb-4">
                                                <h4 class="fw-bold seminar-section-title">COMMENTS AND SUGGESTIONS</h4>
                                                <label for="comments" class="form-label fw-bold small text-muted">Kindly share any
                                                    other feedback you have *</label>
                                                <textarea class="form-control bg-light" id="comments" name="comments" rows="4"
                                                    required placeholder="Type your comments and suggestions here..."></textarea>
                                            </div>

                                            <input type="hidden" name="rating" value="5">
                                        @else
                                            <div class="mb-5 text-center">
                                                <label class="form-label d-block mb-3 fw-bold fs-5 text-dark">How would you rate
                                                    this seminar?</label>
                                                <div class="star-rating justify-content-center">
                                                    <input type="radio" id="star5" name="rating" value="5" required />
                                                    <label for="star5" title="5 stars"><i class="bi bi-star-fill"></i></label>

                                                    <input type="radio" id="star4" name="rating" value="4" />
                                                    <label for="star4" title="4 stars"><i class="bi bi-star-fill"></i></label>

                                                    <input type="radio" id="star3" name="rating" value="3" />
                                                    <label for="star3" title="3 stars"><i class="bi bi-star-fill"></i></label>

                                                    <input type="radio" id="star2" name="rating" value="2" />
                                                    <label for="star2" title="2 stars"><i class="bi bi-star-fill"></i></label>

                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                    <label for="star1" title="1 star"><i class="bi bi-star-fill"></i></label>
                                                </div>
                                                @error('rating')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="comments" class="form-label fw-bold">Additional Comments
                                                    (Optional)</label>
                                                <textarea class="form-control bg-light" id="comments" name="comments" rows="5"
                                                    placeholder="Share your key takeaways or suggestions..."></textarea>
                                                @error('comments')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endif

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-submit btn-lg px-5">
                                                <i class="bi bi-send me-2"></i> Submit Evaluation
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection