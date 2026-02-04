<?php $__env->startSection('content'); ?>
    <style>
        /* Homepage theme variables */
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
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
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2.5rem 1.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.05);
        }

        .custom-sidebar .sidebar-logo h3 {
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .sidebar-logo p {
            letter-spacing: 1px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem !important;
        }

        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: 0.9rem 1.25rem;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin: 0.1rem 0;
        }

        .custom-sidebar .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .custom-sidebar .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: #f4d03f;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            top: 15%;
            bottom: 15%;
            width: 5px;
            background: #f4d03f;
            border-radius: 0 6px 6px 0;
            box-shadow: 2px 0 15px rgba(244, 208, 63, 0.5);
        }

        .custom-sidebar .sidebar-link .bi {
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .custom-sidebar .sidebar-link.active .bi {
            transform: scale(1.1);
            filter: drop-shadow(0 0 5px rgba(244, 208, 63, 0.3));
        }

        .custom-sidebar .sidebar-bottom {
            padding: 1.5rem 1rem;
            background: rgba(0, 0, 0, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-sidebar .sidebar-link.logout {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            text-align: left;
            padding: 0.85rem 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 1.1rem;
        }

        .custom-sidebar .sidebar-link.logout:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.4);
        }

        .main-dashboard-content {
            margin-left: 240px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
        }

        @media (max-width: 991.98px) {
            .custom-sidebar {
                width: 200px;
            }

            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 991.98px) {
            .custom-sidebar {
                transform: translateX(-100%);
                width: 240px;
            }

            .custom-sidebar.show {
                transform: translateX(0);
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.2);
            }

            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem 0.75rem;
            }

            #studentSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--forest-green);
                color: #fff;
                border: none;
                border-radius: 10px;
                padding: 0.6rem 0.8rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                display: flex !important;
                align-items: center;
                justify-content: center;
            }
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
            padding: 0 1rem;
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
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
            transition: box-shadow 0.2s;
            position: relative;
        }

        @media (max-width: 576px) {
            .assessment-card {
                width: 100%;
                max-width: 340px;
            }
        }

        .assessment-card:hover {
            box-shadow: 0 8px 32px rgba(44, 80, 22, 0.13);
        }

        /* Year badge to guide students */
        .year-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .badge-1st {
            background: #e3f2fd;
            color: #0d47a1;
        }

        .badge-2nd {
            background: #e8f5e9;
            color: #1b5e20;
        }

        .badge-3rd {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-4th {
            background: #f3e5f5;
            color: #4a148c;
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
            font-size: 1rem;
            margin-bottom: 1rem;
            text-align: center;
            min-height: 3rem;
            /* Align buttons */
        }

        .assessment-btn {
            background: #2d9a36;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 0;
            width: 100%;
            margin-top: auto;
            transition: background 0.2s;
        }

        .assessment-btn:hover {
            background: #237728;
            color: #fff;
        }

        /* Form container styles */
        .assessment-form-container {
            display: none;
            /* hidden by default */
            max-width: 700px;
            margin: 0 auto;
        }

        .form-card {
            background: #f8f9fa;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
            overflow: hidden;
        }

        .form-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #f8f9fa;
            padding: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .question-item {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid #e0e0e0;
        }

        .option-radio {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .option-radio:hover {
            background: #f1f8e9;
        }

        .option-radio input {
            margin-right: 10px;
            transform: scale(1.2);
        }

        /* Locked Card Styling */
        .assessment-card.locked {
            filter: grayscale(1);
            opacity: 0.8;
            cursor: not-allowed;
            pointer-events: none;
        }

        .assessment-card.locked .assessment-btn {
            background-color: #6c757d !important;
            cursor: not-allowed;
        }

        .lock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            border-radius: 16px;
        }

        .lock-icon-big {
            font-size: 3.5rem;
            color: rgba(0, 0, 0, 0.5);
        }

        .locked-notice {
            position: absolute;
            bottom: 60px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.85rem;
            color: #d32f2f;
            font-weight: 700;
            z-index: 6;
            padding: 0 10px;
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="studentSidebarToggle" class="d-lg-none">
                <i class="bi bi-list"></i>
            </button>
            <!-- Sidebar -->
            <!-- Sidebar -->
            <?php echo $__env->make('student.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1" id="mainContent">
                <div class="container py-1">
                    <div id="assessment-page-header">
                        <div class="assessment-header">Student Assessments</div>
                        <div class="assessment-subtitle">
                            Select the assessment corresponding to your year level.
                        </div>
                    </div>

                    <!-- Card Selection Grid -->
                    <div class="assessment-cards-row" id="assessment-cards">
                        <?php
                            $userYear = (int) auth()->user()->year_level;
                        ?>

                        <!-- 1st Year: GRIT -->
                        <div class="assessment-card <?php echo e($userYear !== 1 ? 'locked' : ''); ?>">
                            <?php if($userYear !== 1): ?>
                                <div class="lock-overlay"><i class="bi bi-lock-fill lock-icon-big"></i></div>
                                <div class="locked-notice">Available for 1st Year Students only</div>
                            <?php endif; ?>
                            <span class="year-badge badge-1st">1st Year</span>
                            <div class="assessment-icon"><i class="bi bi-lightning-charge"></i></div>
                            <div class="assessment-title">GRIT Scale</div>
                            <div class="assessment-desc">Measure your passion and perseverance for long-term goals.</div>
                            <button class="assessment-btn" <?php echo e($userYear !== 1 ? 'disabled' : ''); ?>

                                onclick="openAssessment('grit')"><?php echo e($userYear !== 1 ? 'LOCKED' : 'START GRIT TEST'); ?></button>
                        </div>

                        <!-- 2nd Year: DASS-42 -->
                        <div class="assessment-card <?php echo e($userYear !== 2 ? 'locked' : ''); ?>">
                            <?php if($userYear !== 2): ?>
                                <div class="lock-overlay"><i class="bi bi-lock-fill lock-icon-big"></i></div>
                                <div class="locked-notice">Available for 2nd Year Students only</div>
                            <?php endif; ?>
                            <span class="year-badge badge-2nd">2nd Year</span>
                            <div class="assessment-icon"><i class="bi bi-activity"></i></div>
                            <div class="assessment-title">DASS-42</div>
                            <div class="assessment-desc">Depression, Anxiety, and Stress Scale assessment.</div>
                            <?php if($userYear === 2): ?>
                                <a href="<?php echo e(route('assessments.dass42')); ?>"
                                    class="assessment-btn text-decoration-none text-center">START DASS-42</a>
                            <?php else: ?>
                                <button class="assessment-btn" disabled>LOCKED</button>
                            <?php endif; ?>
                        </div>

                        <!-- 3rd Year: NEO -->
                        <div class="assessment-card <?php echo e($userYear !== 3 ? 'locked' : ''); ?>">
                            <?php if($userYear !== 3): ?>
                                <div class="lock-overlay"><i class="bi bi-lock-fill lock-icon-big"></i></div>
                                <div class="locked-notice">Available for 3rd Year Students only</div>
                            <?php endif; ?>
                            <span class="year-badge badge-3rd">3rd Year</span>
                            <div class="assessment-icon"><i class="bi bi-person-lines-fill"></i></div>
                            <div class="assessment-title">NEO Personality</div>
                            <div class="assessment-desc">Understand your personality traits (Big Five).</div>
                            <button class="assessment-btn" <?php echo e($userYear !== 3 ? 'disabled' : ''); ?>

                                onclick="openAssessment('neo')"><?php echo e($userYear !== 3 ? 'LOCKED' : 'START NEO TEST'); ?></button>
                        </div>

                        <!-- 4th Year: WVI -->
                        <div class="assessment-card <?php echo e($userYear !== 4 ? 'locked' : ''); ?>">
                            <?php if($userYear !== 4): ?>
                                <div class="lock-overlay"><i class="bi bi-lock-fill lock-icon-big"></i></div>
                                <div class="locked-notice">Available for 4th Year Students only</div>
                            <?php endif; ?>
                            <span class="year-badge badge-4th">4th Year</span>
                            <div class="assessment-icon"><i class="bi bi-briefcase"></i></div>
                            <div class="assessment-title">Work Values</div>
                            <div class="assessment-desc">Identify what matters most to you in your career.</div>
                            <button class="assessment-btn" <?php echo e($userYear !== 4 ? 'disabled' : ''); ?>

                                onclick="openAssessment('wvi')"><?php echo e($userYear !== 4 ? 'LOCKED' : 'START WVI TEST'); ?></button>
                        </div>

                    </div>

                    <!-- FORMS (Hidden by default) -->

                    <!-- GRIT FORM -->
                    <div id="grit-form-container" class="assessment-form-container">
                        <form method="POST" action="<?php echo e(route('assessments.grit.submit')); ?>" class="form-card">
                            <?php echo csrf_field(); ?>
                            <div class="form-header text-center">
                                <h3>GRIT Scale</h3>
                                <p class="text-muted mb-0">Please respond to the following statements truthfully.</p>
                            </div>
                            <div class="p-4">
                                <?php $__currentLoopData = $grit_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="question-item">
                                        <p class="fw-bold mb-3"><?php echo e($idx + 1); ?>. <?php echo e($q); ?></p>
                                        <?php
                                            $gritOptions = [
                                                5 => 'Not at all like me',
                                                4 => 'Not much like me',
                                                3 => 'Somewhat like me',
                                                2 => 'Mostly like me',
                                                1 => 'Very much like me'
                                            ];
                                        ?>
                                        <?php $__currentLoopData = $gritOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="option-radio">
                                                <input type="radio" name="grit_answers[<?php echo e($idx); ?>]" value="<?php echo e($val); ?>" required>
                                                <?php echo e($label); ?>

                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <label class="form-label mt-3">Comments (Optional)</label>
                                <textarea class="form-control mb-4" name="student_comment" rows="2"></textarea>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="closeAssessment()">Cancel</button>
                                    <button type="submit" class="btn btn-success px-5">Submit GRIT Scale</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- NEO FORM -->
                    <div id="neo-form-container" class="assessment-form-container">
                        <form method="POST" action="<?php echo e(route('assessments.neo.submit')); ?>" class="form-card">
                            <?php echo csrf_field(); ?>
                            <div class="form-header text-center">
                                <h3>NEO Personality Inventory</h3>
                                <p class="text-muted mb-0">Rate how accurately each statement describes you.</p>
                            </div>
                            <div class="p-4">
                                <?php $__currentLoopData = $neo_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="question-item">
                                        <p class="fw-bold mb-3"><?php echo e($idx + 1); ?>. <?php echo e($q); ?></p>
                                        <div class="d-flex flex-wrap gap-2 justify-content-between">
                                            <?php
                                                $neoOptions = [
                                                    1 => 'Not True',
                                                    2 => '2',
                                                    3 => '3',
                                                    4 => 'Somewhat',
                                                    5 => '5',
                                                    6 => '6',
                                                    7 => 'Very True'
                                                ];
                                            ?>
                                            <?php $__currentLoopData = $neoOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <label
                                                    class="option-radio flex-fill text-center d-flex flex-column align-items-center p-2"
                                                    style="min-width: 80px; border: 1px solid #eee;">
                                                    <span class="small text-muted mb-1"><?php echo e($label); ?></span>
                                                    <input type="radio" name="neo_answers[<?php echo e($idx); ?>]" value="<?php echo e($val); ?>" required
                                                        class="m-0">
                                                </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <label class="form-label mt-3">Comments (Optional)</label>
                                <textarea class="form-control mb-4" name="student_comment" rows="2"></textarea>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="closeAssessment()">Cancel</button>
                                    <button type="submit" class="btn btn-success px-5">Submit NEO Test</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- WVI FORM -->
                    <div id="wvi-form-container" class="assessment-form-container">
                        <form method="POST" action="<?php echo e(route('assessments.wvi.submit')); ?>" class="form-card">
                            <?php echo csrf_field(); ?>
                            <div class="form-header text-center">
                                <h3>Work Values Inventory (WVI)</h3>
                                <p class="text-muted mb-0">How important are these values to you in your career?</p>
                            </div>
                            <div class="p-4">
                                <?php $__currentLoopData = $wvi_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="question-item">
                                        <p class="fw-bold mb-3"><?php echo e($idx + 1); ?>. <?php echo e($q); ?></p>
                                        <div class="d-flex flex-wrap gap-2 justify-content-between">
                                            <?php
                                                $wviOptions = [
                                                    5 => 'Very Important',
                                                    4 => 'Important',
                                                    3 => 'Moderately Important',
                                                    2 => 'Of Little Importance',
                                                    1 => 'Unimportant'
                                                ];
                                            ?>
                                            <?php $__currentLoopData = $wviOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <label
                                                    class="option-radio flex-fill text-center d-flex flex-column align-items-center p-2"
                                                    style="min-width: 90px; border: 1px solid #eee;">
                                                    <span class="small text-muted mb-1"><?php echo e($label); ?></span>
                                                    <input type="radio" name="wvi_answers[<?php echo e($idx); ?>]" value="<?php echo e($val); ?>" required
                                                        class="m-0">
                                                </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <label class="form-label mt-3">Comments (Optional)</label>
                                <textarea class="form-control mb-4" name="student_comment" rows="2"></textarea>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="closeAssessment()">Cancel</button>
                                    <button type="submit" class="btn btn-success px-5">Submit WVI</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php if(session('show_thank_you')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Assessment Completed!',
                    text: 'Thank you for completing the <?php echo e(session('last_assessment_type')); ?>. Your results have been submitted for review.',
                    icon: 'success',
                    confirmButtonText: 'Back to Dashboard',
                    confirmButtonColor: '#1f7a2d',
                    showCancelButton: true,
                    cancelButtonText: 'Stay Here',
                    cancelButtonColor: '#6c757d',
                    backdrop: `rgba(31, 122, 45, 0.2)`
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo e(route('dashboard')); ?>";
                    }
                });
            });
        </script>
    <?php endif; ?>

    <script>
        function openAssessment(type) {
            const assessmentInfo = {
                'grit': {
                    title: 'GRIT Scale',
                    time: '2-3 minutes',
                    icon: 'bi-lightning-charge'
                },
                'neo': {
                    title: 'NEO Personality Inventory',
                    time: '10-15 minutes',
                    icon: 'bi-person-lines-fill'
                },
                'wvi': {
                    title: 'Work Values Inventory',
                    time: '5-8 minutes',
                    icon: 'bi-briefcase'
                }
            };

            const info = assessmentInfo[type];

            Swal.fire({
                title: 'Start ' + info.title + '?',
                html: `
                                <div class="mb-3">
                                    <i class="bi ${info.icon}" style="font-size: 3rem; color: #2d9a36;"></i>
                                </div>
                                <p>You are about to start the <strong>${info.title}</strong>.</p>
                                <p class="text-muted"><i class="bi bi-clock-history mr-1"></i> Estimated time: <strong>${info.time}</strong></p>
                            `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2d9a36',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Start Now',
                cancelButtonText: 'Not Yet',
                backdrop: `rgba(31, 122, 45, 0.1)`
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Success!',
                        text: info.title + ' has started. Good luck!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById('assessment-page-header').style.display = 'none';
                        document.getElementById('assessment-cards').style.display = 'none';
                        // Hide all forms first
                        document.querySelectorAll('.assessment-form-container').forEach(el => el.style.display = 'none');
                        // Show selected form
                        document.getElementById(type + '-form-container').style.display = 'block';
                        window.scrollTo(0, 0);
                    });
                }
            });
        }

        // Intercept DASS-42 link
        document.addEventListener('DOMContentLoaded', function () {
            const dassBtn = document.querySelector('a[href*="assessments.dass42"]');
            if (dassBtn) {
                const originalUrl = dassBtn.href;
                dassBtn.addEventListener('click', function (e) {
                    if (this.classList.contains('disabled')) return;
                    e.preventDefault();

                    Swal.fire({
                        title: 'Start DASS-42 Assessment?',
                        html: `
                                        <div class="mb-3">
                                            <i class="bi bi-activity" style="font-size: 3rem; color: #2d9a36;"></i>
                                        </div>
                                        <p>You are about to start the <strong>DASS-42</strong> (Depression, Anxiety, and Stress Scale).</p>
                                        <p class="text-muted"><i class="bi bi-clock-history mr-1"></i> Estimated time: <strong>5-10 minutes</strong></p>
                                    `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#2d9a36',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, Start Now',
                        cancelButtonText: 'Not Yet',
                        backdrop: `rgba(31, 122, 45, 0.1)`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'DASS-42 Assessment has started. Good luck!',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = originalUrl;
                            });
                        }
                    });
                });
            }
        });

        function closeAssessment() {
            document.querySelectorAll('.assessment-form-container').forEach(el => el.style.display = 'none');
            document.getElementById('assessment-page-header').style.display = 'block';
            document.getElementById('assessment-cards').style.display = 'flex';
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/assessments.blade.php ENDPATH**/ ?>