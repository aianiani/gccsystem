

<?php $__env->startSection('content'); ?>
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d;
            /* Homepage forest green */
            --primary-green-2: #13601f;
            /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

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
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        body,
        .profile-card,
        .stats-card,
        .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
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

        .custom-sidebar .sidebar-link.active,
        .custom-sidebar .sidebar-link:hover {
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

            .custom-sidebar .sidebar-logo {
                display: block;
            }

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

        /* Small informational banner shown at top of the assessment */
        .info-banner {
            max-width: 760px;
            margin: 0.25rem auto 1rem auto;
            background: #eaf5ea;
            border: 1px solid #cfe8d0;
            color: #1f6b2a;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            font-size: 0.95rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(44, 80, 22, 0.04);
        }

        .dass42-form {
            background: #f8f9fa;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
            max-width: 700px;
            margin: 0 auto;
            padding: 0;
        }

        .dass42-questions-list {
            margin-bottom: 0;
            padding: 0;
        }

        .dass42-question-item {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(44, 80, 22, 0.06);
            padding: 1.2rem 1rem 0.7rem 1rem;
            margin-bottom: 1.2rem;
            border: 2px solid transparent;
            transition: border 0.2s;
            display: none;
            list-style: none;
        }

        .dass42-question-item.active {
            display: block;
            border: 2px solid #2d9a36;
            box-shadow: 0 4px 16px rgba(44, 80, 22, 0.13);
        }

        .dass42-options-row {
            margin-top: 0.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: flex-end;
            /* Aligns boxes to bottom baseline */
        }

        .dass42-options-row>div {
            flex: 1 1 calc(25% - 0.5rem);
            /* 4 columns on desktop */
            min-width: 200px;
            /* Stack on mobile */
        }

        .dass42-option-check {
            background: #e8f5e8;
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            min-height: 60px;
            /* Single consistent height */
            margin-bottom: 0.3rem;
        }

        /*
            .dass42-option-check[data-value="0"] { min-height: 42px; font-size: 0.94rem; padding: 0.45rem 0.6rem; }
            .dass42-option-check[data-value="1"] { min-height: 50px; font-size: 0.96rem; padding: 0.5rem 0.65rem; }
            .dass42-option-check[data-value="2"] { min-height: 58px; font-size: 0.99rem; padding: 0.55rem 0.7rem; }
            .dass42-option-check[data-value="3"] { min-height: 66px; font-size: 1.02rem; padding: 0.6rem 0.75rem; }
            */
        .dass42-option-check {
            transition: background 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease, min-height 0.18s ease, padding 0.18s ease;
        }

        /* Hide the native radio visually but keep it in the DOM for accessibility */
        .dass42-option-check input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            margin: 0;
            pointer-events: none;
        }

        .dass42-option-check label {
            margin-bottom: 0;
            flex: 1 1 0%;
            display: block;
            align-items: center;
            font-size: 0.98rem;
            cursor: pointer;
            width: 100%;
            height: 100%;
            padding-left: 0.25rem;
        }

        /* Visual selected state when an option is chosen */
        .dass42-option-check.selected {
            background: #dff0d8;
            border: 1px solid #2d9a36;
            box-shadow: 0 2px 8px rgba(44, 80, 22, 0.06);
        }

        .dass42-option-check.selected[data-value="0"] {
            transform: scale(1.01);
        }

        .dass42-option-check.selected[data-value="1"] {
            transform: scale(1.02);
        }

        .dass42-option-check.selected[data-value="2"] {
            transform: scale(1.035);
        }

        .dass42-option-check.selected[data-value="3"] {
            transform: scale(1.05);
        }

        .dass42-option-check input[type="radio"]:checked+label {
            font-weight: bold;
            color: #2d5016;
        }

        .dass42-sticky-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #f8f9fa;
            padding: 0.9rem 1rem 0.5rem 1rem;
            border-radius: 18px 18px 0 0;
            box-shadow: 0 2px 8px rgba(44, 80, 22, 0.04);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .dass42-sticky-header h3 {
            margin-bottom: 1rem;
            text-align: center;
            color: #2d5016;
        }

        .progress {
            height: 18px;
        }

        .progress-bar {
            font-weight: bold;
        }

        .dass42-question-wrapper {
            padding: 1.5rem;
            padding-bottom: 0;
        }

        .dass42-nav-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem 1.5rem 1.5rem;
            background: #f8f9fa;
            border-radius: 0 0 18px 18px;
            gap: 0.5rem;
        }

        .dass42-nav-controls .btn {
            min-width: 130px;
            padding: 0.75rem 1.25rem;
        }

        /* Yellow submit buttons to match dashboard accent */
        #dass42-submit,
        #dass42-summary .btn-success,
        .dass42-form .btn-success {
            background: var(--accent-orange) !important;
            color: #1f2b10 !important;
            border-color: rgba(0, 0, 0, 0.06) !important;
            box-shadow: none !important;
        }

        #dass42-submit:hover,
        #dass42-summary .btn-success:hover,
        .dass42-form .btn-success:hover {
            filter: brightness(0.95);
            color: #0f1a0b !important;
        }

        .dass42-nav-controls button {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 8px;
        }

        /* Review list layout: keep question and answer badge aligned */
        .dass42-review-list {
            width: 100%;
        }

        .dass42-review-item {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(44, 80, 22, 0.06);
            border: 1px solid #e0e0e0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1.5rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
        }

        .dass42-review-question {
            flex: 1 1 auto;
            color: #2d5016;
            font-size: 1rem;
            line-height: 1.4;
            word-break: break-word;
        }

        .dass42-review-answer {
            flex: 0 0 auto;
            padding-top: 0.2rem;
        }

        .dass42-review-answer .badge {
            font-size: 1rem;
            min-width: 160px;
            max-width: 200px;
            padding: 0.5rem 1rem !important;
            text-align: center;
            background: #2d9a36;
            color: #fff;
            border: none;
            white-space: normal;
            word-break: break-word;
        }

        @media (max-width: 768px) {
            .dass42-review-item {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }

            .dass42-review-answer {
                flex: 0 0 auto;
                padding-top: 0;
            }

            .dass42-review-answer .badge {
                width: 100%;
                min-width: auto;
                max-width: none;
            }
        }

        @media (max-width: 600px) {
            .dass42-form {
                padding: 0.5rem !important;
            }

            .dass42-question-item {
                padding: 0.7rem 0.5rem;
            }

            .dass42-sticky-header {
                padding: 1rem 0.5rem 0.5rem 0.5rem;
            }

            .dass42-nav-controls {
                padding: 0.75rem 0.5rem !important;
                flex-wrap: wrap;
            }

            .das42-nav-controls button {
                font-size: 0.9rem;
                padding: 0.6rem 1rem;
            }

            .assessment-header {
                font-size: 1.3rem;
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
                    <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="CMU Logo"
                        style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto;">
                    <h3
                        style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
                        CMU Guidance and Counseling Center</h3>
                    <p style="margin: 0; font-size: 0.95rem; color: #fff; opacity: 0.7;">Student Portal</p>
                </div>
                <nav class="sidebar-nav flex-grow-1">
                    <a href="<?php echo e(route('profile')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('profile') ? ' active' : ''); ?>"><i
                            class="bi bi-person"></i>Profile</a>
                    <a href="<?php echo e(route('dashboard')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('dashboard') ? ' active' : ''); ?>"><i
                            class="bi bi-house-door"></i>Dashboard</a>
                    <a href="<?php echo e(route('appointments.index')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('appointments.*') ? ' active' : ''); ?>"><i
                            class="bi bi-calendar-check"></i>Appointments</a>
                    <a href="<?php echo e(route('assessments.index')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('assessments.*') ? ' active' : ''); ?>"><i
                            class="bi bi-clipboard-data"></i>Assessments</a>
                    <a href="<?php echo e(route('chat.selectCounselor')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('chat.selectCounselor') ? ' active' : ''); ?>"><i
                            class="bi bi-chat-dots"></i>Chat with a Counselor</a>
                </nav>
                <div class="sidebar-bottom w-100">
                    <a href="<?php echo e(route('logout')); ?>" class="sidebar-link logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>Logout
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="container py-1">
                        <div class="assessment-header">DASS-42 Assessment</div>
                        <div class="assessment-subtitle">
                            Depression, Anxiety, and Stress Scale — Please take your time to answer all 42 questions
                            honestly.
                        </div>

                        <div class="info-banner" role="status" aria-live="polite">
                            Quick heads-up: You’ll answer 42 quick questions in about 5–10 minutes. Your responses are
                            private and help us understand how to support you. You can pause and return anytime.
                        </div>

                        <!-- DASS-42 Assessment Form -->
                        <form method="POST" action="<?php echo e(route('assessments.dass42.submit')); ?>" class="dass42-form">
                            <?php echo csrf_field(); ?>
                            <div class="dass42-sticky-header">
                                <h3 style="margin:0;">DASS-42 Assessment</h3>
                                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.35rem;">
                                    <div id="dass42-counter" class="small text-muted" aria-live="polite">Question 1 of 42
                                    </div>
                                    <div class="progress mb-0" style="width: 220px;">
                                        <div id="dass42-progress" class="progress-bar bg-success" role="progressbar"
                                            style="width: 0%; font-weight: bold;" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="42">0/42</div>
                                    </div>
                                </div>
                            </div>

                            <div id="dass42-question-wrapper" class="dass42-question-wrapper">
                                <ol class="dass42-questions-list">
                                    <?php $__currentLoopData = $dass42_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="dass42-question-item" data-question="<?php echo e($idx); ?>">
                                            <div class="fw-bold mb-2"><?php echo e(($idx + 1) . ". " . $question); ?></div>
                                            <div class="row g-2 align-items-center dass42-options-row">
                                                <?php for($i = 0; $i <= 3; $i++): ?>
                                                    <div class="col-12 col-md-6 col-lg-3">
                                                        <div class="form-check dass42-option-check w-100" data-value="<?php echo e($i); ?>">
                                                            <input class="form-check-input" type="radio" name="answers[<?php echo e($idx); ?>]"
                                                                id="q<?php echo e($idx); ?>_<?php echo e($i); ?>" value="<?php echo e($i); ?>" required tabindex="-1">
                                                            <label class="form-check-label w-100" for="q<?php echo e($idx); ?>_<?php echo e($i); ?>"
                                                                style="font-size: 0.98rem;">
                                                                <?php echo e([0 => 'Did not apply to me at all', 1 => 'Applied to me to some degree, or some of the time', 2 => 'Applied to me to a considerable degree, or a good part of time', 3 => 'Applied to me very much, or most of the time'][$i]); ?>

                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                            </div>

                            <div class="dass42-nav-controls">
                                <button type="button" class="btn btn-outline-secondary" id="dass42-prev"
                                    style="visibility:hidden;">Previous</button>
                                <button type="button" class="btn btn-outline-success" id="dass42-next">Next</button>
                                <button type="submit" class="btn btn-success" id="dass42-submit"
                                    style="display:none;">Submit Assessment</button>
                            </div>

                            <!-- Free-text comment removed as requested -->

                            <!-- Summary/Review section (hidden by default) -->
                            <div id="dass42-summary" style="display:none;" class="p-4">
                                <h4 class="mb-3 text-center" style="color:#2d5016;">Review Your Answers</h4>
                                <div class="dass42-review-list mb-3">
                                    <?php $__currentLoopData = $dass42_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="dass42-review-item">
                                            <div class="dass42-review-question"><span
                                                    class="fw-semibold"><?php echo e(($idx + 1) . ". " . $question); ?></span></div>
                                            <div class="dass42-review-answer">
                                                <span class="badge dass42-summary-answer px-3 py-2"
                                                    data-summary="<?php echo e($idx); ?>">Not answered</span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-outline-secondary px-4 py-2" id="dass42-edit">Edit
                                        Answers</button>
                                    <button type="submit" class="btn btn-success px-5 py-2 ms-2">Submit Assessment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Navigation logic
            const totalQuestions = 42;
            let currentQuestion = 0;
            const questions = document.querySelectorAll('.dass42-question-item');
            const prevBtn = document.getElementById('dass42-prev');
            const nextBtn = document.getElementById('dass42-next');
            const submitBtn = document.getElementById('dass42-submit');
            const summaryDiv = document.getElementById('dass42-summary');
            const questionWrapper = document.getElementById('dass42-question-wrapper');
            const radios = document.querySelectorAll('input[type="radio"]');
            const progressBar = document.getElementById('dass42-progress');

            function showDass42Question(idx) {
                questions.forEach((q, i) => {
                    q.classList.toggle('active', i === idx);
                });
                prevBtn.style.visibility = idx === 0 ? 'hidden' : 'visible';
                nextBtn.style.display = idx === totalQuestions - 1 ? 'none' : '';
                submitBtn.style.display = idx === totalQuestions - 1 ? '' : 'none';
                summaryDiv.style.display = 'none';
                questionWrapper.style.display = '';
                updateProgress();
                if (typeof refreshSelectedStates === 'function') refreshSelectedStates();
                // Update counter in sticky header
                const counterEl = document.getElementById('dass42-counter');
                if (counterEl) counterEl.textContent = 'Question ' + (idx + 1) + ' of ' + totalQuestions;
                // Focus first radio for accessibility
                const firstRadio = questions[idx].querySelector('input[type="radio"]');
                if (firstRadio) firstRadio.focus();
            }

            prevBtn.onclick = () => { if (currentQuestion > 0) showDass42Question(--currentQuestion); };
            nextBtn.onclick = () => {
                // Require answer before next
                const checked = questions[currentQuestion].querySelector('input[type="radio"]:checked');
                if (!checked) {
                    questions[currentQuestion].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    questions[currentQuestion].classList.add('border-danger');
                    setTimeout(() => questions[currentQuestion].classList.remove('border-danger'), 1000);
                    return;
                }
                if (currentQuestion < totalQuestions - 1) showDass42Question(++currentQuestion);
            };

            // Progress bar logic
            function updateProgress() {
                const answered = new Set();
                radios.forEach(r => { if (r.checked) answered.add(r.name); });
                const count = answered.size;
                const percent = Math.round((count / totalQuestions) * 100);
                progressBar.style.width = percent + '%';
                progressBar.setAttribute('aria-valuenow', count);
                progressBar.textContent = count + '/42';
            }
            radios.forEach(r => r.addEventListener('change', updateProgress));

            // Make the entire option bar clickable and update visual selection
            function refreshSelectedStates() {
                document.querySelectorAll('.dass42-option-check').forEach(opt => {
                    const radio = opt.querySelector('input[type="radio"]');
                    if (radio && radio.checked) opt.classList.add('selected'); else opt.classList.remove('selected');
                });
            }

            document.querySelectorAll('.dass42-option-check').forEach(opt => {
                opt.addEventListener('click', function (e) {
                    // Prefer clicking the radio if present
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio && !radio.checked) {
                        radio.checked = true;
                        radio.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    // Ensure visual state updates
                    refreshSelectedStates();
                });
            });

            // ensure selected visuals are in sync on load
            refreshSelectedStates();

            // Show summary before submit
            submitBtn.onclick = function (e) {
                e.preventDefault();
                // Fill summary
                document.querySelectorAll('.dass42-summary-answer').forEach(span => {
                    const idx = span.getAttribute('data-summary');
                    const checked = document.querySelector('input[name="answers[' + idx + ']"]:checked');
                    if (checked) {
                        span.textContent = checked.nextElementSibling.textContent;
                        span.className = 'badge bg-success dass42-summary-answer';
                    } else {
                        span.textContent = 'Not answered';
                        span.className = 'badge bg-danger dass42-summary-answer';
                    }
                });
                summaryDiv.style.display = '';
                questionWrapper.style.display = 'none';
                prevBtn.style.display = nextBtn.style.display = submitBtn.style.display = 'none';
            };

            var dass42EditBtn = document.getElementById('dass42-edit');
            if (dass42EditBtn) {
                dass42EditBtn.onclick = function () {
                    summaryDiv.style.display = 'none';
                    questionWrapper.style.display = '';
                    showDass42Question(currentQuestion);
                    prevBtn.style.display = nextBtn.style.display = '';
                    submitBtn.style.display = currentQuestion === totalQuestions - 1 ? '' : 'none';
                };
            }

            // Allow final submit button in summary to submit the form
            var summarySubmitBtn = document.querySelector('#dass42-summary .btn-success');
            if (summarySubmitBtn) {
                summarySubmitBtn.onclick = function (e) {
                    // Allow form to submit (don't prevent default)
                    return true;
                };
            }

            // Show first question on load
            showDass42Question(0);
        });

        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('studentSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function (e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/assessments/dass42.blade.php ENDPATH**/ ?>