@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d; /* Homepage forest green */
            --primary-green-2: #13601f; /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);

            /* Map dashboard-specific names to homepage palette for compatibility */
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply the same page zoom used on the homepage */
        .home-zoom {
            zoom: 0.85;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }
        
        body, .profile-card, .stats-card, .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green) ;
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0,0,0,0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }
        
        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2rem 1rem 1rem 1rem;
            border-bottom: 1px solid #4a7c59;
        }
        
        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0.5rem 0 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            position: relative;
        }
        
        .custom-sidebar .sidebar-link.active, .custom-sidebar .sidebar-link:hover {
            background: #4a7c59;
            color: #f4d03f;
        }
        
        .custom-sidebar .sidebar-link .bi {
            font-size: 1.1rem;
        }
        
        .custom-sidebar .sidebar-bottom {
            padding: 1rem 0.5rem;
            border-top: 1px solid #4a7c59;
        }
        
        .custom-sidebar .sidebar-link.logout {
            background: #dc3545;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        
        .custom-sidebar .sidebar-link.logout:hover {
            background: #b52a37;
            color: #fff;
        }
        
        @media (max-width: 991.98px) {
            .custom-sidebar {
                width: 200px;
            }
            .main-dashboard-content {
                margin-left: 200px;
            }
        }
        @media (max-width: 767.98px) {
            /* Off-canvas behavior on mobile */
            .custom-sidebar {
                position: fixed;
                z-index: 1040;
                height: 100vh;
                left: 0;
                top: 0;
                width: 240px;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
                flex-direction: column;
                padding: 0;
            }
            .custom-sidebar.show {
                transform: translateX(0);
            }
            .custom-sidebar .sidebar-logo { display: block; }
            .custom-sidebar .sidebar-nav {
                flex-direction: column;
                gap: 0.25rem;
                padding: 1rem 0.5rem 1rem 0.5rem;
            }
            .custom-sidebar .sidebar-link {
                justify-content: flex-start;
                padding: 0.6rem 0.75rem;
                font-size: 1rem;
            }
            .main-dashboard-content {
                margin-left: 0;
            }
            /* Toggle button */
            #studentSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--forest-green);
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 0.5rem 0.75rem;
                box-shadow: var(--shadow-sm);
            }
        }
        
        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        /* Constrain inner content and center it within the available area */
        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }

    .assessment-header {
        color: #2d5016;
        font-weight: 700;
        font-size: 1.75rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    .assessment-subtitle {
        color: #3d5c2d;
        font-size: 1rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .assessment-cards-row {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .assessment-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
        padding: 1.5rem 1.25rem;
        width: 340px;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1rem;
        transition: box-shadow 0.2s;
    }
    .assessment-card:hover {
        box-shadow: 0 8px 32px rgba(44, 80, 22, 0.13);
    }
    .assessment-icon {
        font-size: 2rem;
        color: #2d5016;
        margin-bottom: 0.75rem;
    }
    .assessment-title {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
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

    <div class="home-zoom">
    <div class="d-flex">
        <!-- Mobile Sidebar Toggle -->
        <button id="studentSidebarToggle" class="d-md-none">
            <i class="bi bi-list"></i>
        </button>
        <!-- Sidebar -->
        <div class="custom-sidebar">
            <div class="sidebar-logo mb-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto;">
                <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">CMU Guidance and Counseling Center</h3>
                <p style="margin: 0; font-size: 0.95rem; color: #fff; opacity: 0.7;">Student Portal</p>
            </div>
            <nav class="sidebar-nav flex-grow-1">
                <a href="{{ route('profile') }}" class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i class="bi bi-person"></i>Profile</a>
                <a href="{{ route('dashboard') }}" class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i class="bi bi-house-door"></i>Dashboard</a>
                <a href="{{ route('appointments.index') }}" class="sidebar-link{{ request()->routeIs('appointments.*') ? ' active' : '' }}"><i class="bi bi-calendar-check"></i>Appointments</a>
                <a href="{{ route('assessments.index') }}" class="sidebar-link{{ request()->routeIs('assessments.*') ? ' active' : '' }}"><i class="bi bi-clipboard-data"></i>Assessments</a>
                <a href="{{ route('chat.selectCounselor') }}" class="sidebar-link{{ request()->routeIs('chat.selectCounselor') ? ' active' : '' }}"><i class="bi bi-chat-dots"></i>Chat with a Counselor</a>
            </nav>
            <div class="sidebar-bottom w-100">
                <a href="{{ route('logout') }}" class="sidebar-link logout"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-dashboard-content flex-grow-1">
            <div class="main-dashboard-inner">
<div class="container py-1">
    <div class="assessment-header">Mental Health Assessment</div>
    <div class="assessment-subtitle">
        Take a moment to assess your mental well-being. Choose an assessment type below to get started.
    </div>
    <div class="assessment-cards-row" id="assessment-cards">
        <!-- DASS-42 removed from hub: moved to its own dedicated flow -->
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
    <!-- DASS-42 form removed from hub: moved to its own dedicated flow -->
    <!-- Academic Stress Survey Form (hidden by default) -->
    <div id="academic-form-container" style="display:none;">
        <form method="POST" action="{{ route('assessments.academic.submit') }}" class="card p-0 shadow-sm dass42-form" style="max-width: 700px; margin: 0 auto;">
            @csrf
            <div class="dass42-sticky-header" style="position:sticky;top:0;z-index:10;background:#f8f9fa;padding:1.2rem 1.5rem 0.5rem 1.5rem;border-radius:18px 18px 0 0;box-shadow:0 2px 8px rgba(44,80,22,0.04);">
                <h3 class="mb-2 text-center" style="color: #2d5016;">Academic Stress Survey</h3>
                <div class="progress mb-0" style="height: 18px;">
                    <div id="academic-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%; font-weight: bold;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="15">0/15</div>
                </div>
            </div>
            <div id="academic-question-wrapper" class="p-4 pb-0">
                <ol class="dass42-questions-list" style="padding-left: 0;">
                    @foreach($academic_questions as $idx => $question)
                        <li class="mb-4 academic-question-item" data-question="{{ $idx }}" style="list-style: none; display: none;">
                            <div class="fw-bold mb-2">{{ ($idx+1) . ". " . $question }}</div>
                            <div class="row g-2 align-items-center dass42-options-row">
                                @for($i=0; $i<=3; $i++)
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-check dass42-option-check w-100">
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
            <div class="dass42-nav-controls d-flex justify-content-between align-items-center px-4 pb-4 pt-2" style="background:#f8f9fa;border-radius:0 0 18px 18px;">
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
                <div class="dass42-review-list mb-3">
                    @foreach($academic_questions as $idx => $question)
                        <div class="dass42-review-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-2 p-3">
                            <div class="dass42-review-question flex-grow-1 mb-2 mb-md-0"><span class="fw-semibold text-dark">{{ ($idx+1) . ". " . $question }}</span></div>
                            <div class="dass42-review-answer text-end">
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
        <form method="POST" action="{{ route('assessments.wellness.submit') }}" class="card p-0 shadow-sm dass42-form" style="max-width: 700px; margin: 0 auto;">
            @csrf
            <div class="dass42-sticky-header" style="position:sticky;top:0;z-index:10;background:#f8f9fa;padding:1.2rem 1.5rem 0.5rem 1.5rem;border-radius:18px 18px 0 0;box-shadow:0 2px 8px rgba(44,80,22,0.04);">
                <h3 class="mb-2 text-center" style="color: #2d5016;">Wellness Check</h3>
                <div class="progress mb-0" style="height: 18px;">
                    <div id="wellness-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%; font-weight: bold;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="12">0/12</div>
                </div>
            </div>
            <div id="wellness-question-wrapper" class="p-4 pb-0">
                <ol class="dass42-questions-list" style="padding-left: 0;">
                    @foreach($wellness_questions as $idx => $question)
                        <li class="mb-4 wellness-question-item" data-question="{{ $idx }}" style="list-style: none; display: none;">
                            <div class="fw-bold mb-2">{{ ($idx+1) . ". " . $question }}</div>
                            <div class="row g-2 align-items-center dass42-options-row">
                                @for($i=0; $i<=3; $i++)
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-check dass42-option-check w-100">
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
            <div class="dass42-nav-controls d-flex justify-content-between align-items-center px-4 pb-4 pt-2" style="background:#f8f9fa;border-radius:0 0 18px 18px;">
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
                <div class="dass42-review-list mb-3">
                    @foreach($wellness_questions as $idx => $question)
                        <div class="dass42-review-item d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-2 p-3">
                            <div class="dass42-review-question flex-grow-1 mb-2 mb-md-0"><span class="fw-semibold text-dark">{{ ($idx+1) . ". " . $question }}</span></div>
                            <div class="dass42-review-answer text-end">
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
        .dass42-form {
            background: #f8f9fa;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
        }
        .dass42-questions-list {
            margin-bottom: 0;
        }
        .dass42-question-item {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(44, 80, 22, 0.06);
            padding: 1.2rem 1rem 0.7rem 1rem;
            margin-bottom: 1.2rem;
            border: 2px solid transparent;
            transition: border 0.2s;
        }
        .dass42-question-item.active {
            border: 2px solid #2d9a36;
            box-shadow: 0 4px 16px rgba(44, 80, 22, 0.13);
        }
        .dass42-options-row {
            margin-top: 0.5rem;
        }
        .dass42-option-check {
            background: #e8f5e8;
            border-radius: 8px;
            padding: 0.5rem 0.7rem;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            min-height: 44px;
            margin-bottom: 0.3rem;
        }
        .dass42-option-check input[type="radio"] {
            margin-right: 0.7em;
            margin-top: 0;
            margin-bottom: 0;
            flex-shrink: 0;
            width: 1.2em;
            height: 1.2em;
        }
        .dass42-option-check label {
            margin-bottom: 0;
            flex: 1 1 0%;
            display: flex;
            align-items: center;
            font-size: 0.98rem;
            cursor: pointer;
        }
        .dass42-option-check input[type="radio"]:checked + label {
            font-weight: bold;
            color: #2d5016;
        }
        .dass42-nav-controls {
            border-top: 1px solid #e0e0e0;
        }
        .dass42-review-list {
            width: 100%;
        }
        .dass42-review-item {
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
        .dass42-review-question {
            font-size: 1.04rem;
            color: #2d5016;
            flex: 0 0 60%;
            word-break: break-word;
        }
        .dass42-review-answer {
            flex: 0 0 40%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 0;
        }
        .dass42-review-answer .badge {
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
        .dass42-review-answer .badge.bg-success {
            background: #2d9a36;
            color: #fff;
            border: none;
        }
        .dass42-review-answer .badge.bg-danger {
            background: #dc3545;
            color: #fff;
            border: none;
        }
        @media (max-width: 900px) {
            .dass42-review-question { flex-basis: 100%; }
            .dass42-review-answer { flex-basis: 100%; justify-content: flex-start; margin-top: 0.5rem; }
            .dass42-review-item { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        }
        @media (max-width: 600px) {
            .dass42-form { padding: 0.5rem !important; }
            .dass42-question-item { padding: 0.7rem 0.5rem; }
            .dass42-sticky-header { padding: 1rem 0.5rem 0.5rem 0.5rem; }
            .dass42-nav-controls { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
            .dass42-options-row > div { margin-bottom: 0.5rem; }
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // DASS-42 removed from hub: start button and inline flow were moved to a dedicated page/flow.
    // Initialize Academic and Wellness start buttons safely (only if present).
    const startAcademicBtn = document.getElementById('start-academic');
    if (startAcademicBtn) {
        startAcademicBtn.addEventListener('click', function() {
            document.getElementById('assessment-cards').style.display = 'none';
            document.getElementById('academic-form-container').style.display = 'block';
            showAcademicQuestion(0); // Ensure first question is shown
        });
    }
    const startWellnessBtn = document.getElementById('start-wellness');
    if (startWellnessBtn) {
        startWellnessBtn.addEventListener('click', function() {
            document.getElementById('assessment-cards').style.display = 'none';
            document.getElementById('wellness-form-container').style.display = 'block';
            showWellnessQuestion(0);
        });
    }

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
        @php $type = session('last_assessment_type', 'DASS-42'); @endphp
        @if($type === 'DASS-42')
        <p class="mb-3">Thank you for completing the DASS-42 assessment.<br>Your responses have been submitted for review by a counselor.<br><span class="text-muted small">If you have any urgent concerns, please reach out to the guidance office directly.</span></p>
        @elseif($type === 'Academic Stress Survey')
        <p class="mb-3">Thank you for completing the Academic Stress Survey.<br>Your responses have been submitted for review by a counselor.<br><span class="text-muted small">If you have any urgent concerns, please reach out to the guidance office directly.</span></p>
        @elseif($type === 'Wellness Check')
        <p class="mb-3">Thank you for completing the Wellness Check.<br>Your responses have been submitted for review by a counselor.<br><span class="text-muted small">If you have any urgent concerns, please reach out to the guidance office directly.</span></p>
        @else
        <p class="mb-3">Thank you for completing the assessment.<br>Your responses have been submitted for review by a counselor.<br><span class="text-muted small">If you have any urgent concerns, please reach out to the guidance office directly.</span></p>
        @endif
        <a href="{{ route('dashboard') }}" class="btn btn-success px-3">Return to Dashboard</a>
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
            </div>
        </div>
    </div>
    </div>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('studentSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endsection 