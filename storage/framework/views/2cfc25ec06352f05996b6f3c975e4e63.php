

<?php $__env->startSection('content'); ?>
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
            zoom: 0.75;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
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
            #counselorSidebarToggle {
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
            max-width: 100%;
            margin: 0 auto;
        }

        /* Custom Styles for Guidance Module */
        .page-header {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            color: #fff;
        }

        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .card-header-custom {
            background: #fff;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--light-green);
        }

        .table-custom th {
            background-color: var(--light-green);
            color: var(--primary-green);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem 1.5rem;
            border: none;
        }

        .table-custom td {
            padding: 0.75rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: var(--text-dark);
        }

        .matrix-cell-active {
            position: relative;
            background-color: var(--cell-bg, transparent) !important;
            transition: all 0.2s ease;
        }

        .matrix-cell-active:hover {
            opacity: 0.9;
        }

        .status-badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge-attended {
            background-color: #e9ecef;
            color: #495057;
        }

        .status-badge-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .btn-secondary-custom {
            background: #fff;
            border: 1px solid #e0e0e0;
            color: var(--text-dark);
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary-custom:hover {
            background: #f8f9fa;
            border-color: #d6d8db;
            color: var(--primary-green);
        }

        .checkbox-custom {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 4px;
            border: 2px solid #ced4da;
            cursor: pointer;
        }

        .checkbox-custom:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* Evaluation Accordion Styles */
        .custom-accordion .accordion-item {
            border: 1px solid #eef6ee !important;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .custom-accordion .accordion-button:not(.collapsed) {
            background-color: var(--light-green);
            color: var(--primary-green);
            box-shadow: none;
        }

        .seminar-badge-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .eval-section-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--seminar-color, var(--primary-green));
            display: inline-block;
        }

        .question-card {
            background: #fff;
            padding: 1rem;
            border-radius: 12px;
            border-left: 4px solid var(--seminar-color, var(--primary-green));
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            margin-bottom: 1rem;
        }

        .criteria-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            background: #fff;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            border: 1px solid #f0f0f0;
        }

        .custom-accordion .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }

        .border-start-md {
            border-left: 1px solid #e0e0e0;
        }

        @media (max-width: 767.98px) {
            .border-start-md {
                border-left: none;
                border-top: 1px solid #e0e0e0;
                padding-top: 1.5rem;
                margin-top: 1.5rem;
            }
        }

        /* Fast transition to minimize flickering in zoomed layout without breaking Bootstrap transitions */
        .custom-accordion .accordion-collapse {
            transition: height 0.15s ease-out;
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none">
                <i class="bi bi-list"></i>
            </button>

            <!-- Sidebar -->
            <?php echo $__env->make('counselor.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">


                    <!-- Student Profile Header (Seminar Highlight Version) -->
                    <div class="page-header py-4 px-4 position-relative">
                        <a href="<?php echo e(route('counselor.guidance.index')); ?>" 
                           class="btn btn-light btn-sm position-absolute top-0 start-0 m-3 shadow-sm d-flex align-items-center gap-2 text-dark"
                           style="z-index: 10; border-radius: 8px; font-weight: 500;">
                            <i class="bi bi-arrow-left"></i> 
                            <span class="d-none d-md-inline">Back to Student List</span>
                        </a>
                        <div class="row g-4 align-items-center mt-2">
                            
                            <!-- Left: Identity (Wider Column) -->
                            <div class="col-xl-5 col-lg-6 border-end-xl border-white/10">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="position-relative flex-shrink-0">
                                        <div class="rounded-circle bg-white p-1 shadow-sm" style="width: 100px; height: 100px;">
                                            <img src="<?php echo e($student->avatar_url); ?>" alt="<?php echo e($student->name); ?>" 
                                                class="rounded-circle w-100 h-100 object-fit-cover">
                                        </div>
                                        <div class="position-absolute bottom-0 end-0 p-1">
                                            <span class="badge rounded-circle p-1 bg-warning border border-white text-dark shadow-sm" 
                                                  style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;" 
                                                  title="<?php echo e(ucfirst($student->role ?? 'Student')); ?>">
                                                <i class="bi bi-star-fill" style="font-size: 10px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <h1 class="h2 mb-1 fw-bold text-white lh-sm"><?php echo e($student->name); ?></h1>
                                        <div class="d-flex flex-column gap-1 text-white-50" style="font-size: 0.95rem;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-envelope opacity-75"></i> 
                                                <span class="text-truncate"><?php echo e($student->email); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="font-monospace bg-white/10 px-2 rounded text-white-75 small text-nowrap">
                                                    ID: <?php echo e($student->student_id ?? 'N/A'); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Details & Seminars -->
                            <div class="col-xl-7 col-lg-6 ps-xl-4">
                                <div class="d-flex flex-column gap-4">
                                    
                                    <!-- Top Row: Academic Info & Year Level -->
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3">
                                        <div class="text-white">
                                            <div class="d-flex align-items-start gap-2 mb-2">
                                                <i class="bi bi-mortarboard-fill mt-1 opacity-75 flex-shrink-0"></i>
                                                <div class="fw-medium text-white lh-sm" style="font-size: 1rem;"><?php echo e($student->course ?? 'No Course Assigned'); ?></div>
                                            </div>
                                            <div class="d-flex align-items-start gap-2 mb-2">
                                                <i class="bi bi-building-fill mt-1 opacity-75 flex-shrink-0"></i>
                                                <div class="text-white-75 lh-sm" style="font-size: 0.95rem;"><?php echo e($student->college ?? 'No College Assigned'); ?></div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-telephone-fill opacity-75 flex-shrink-0"></i>
                                                <span class="font-monospace text-white-75"><?php echo e($student->contact_number ?? 'N/A'); ?></span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-3 bg-white/5 rounded-4 p-3 border border-white/5 ms-md-auto text-nowrap">
                                            <div class="text-end">
                                                <div class="text-white-50 text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Year Level</div>
                                            </div>
                                            <div class="display-5 fw-bold text-white lh-1"><?php echo e(preg_replace('/[^0-9]/', '', $student->year_level ?? '0')); ?></div>
                                        </div>
                                    </div>

                                    <!-- Bottom Row: Seminar Badges (Highlighted) -->
                                    <div>
                                        <div class="text-white-50 text-uppercase fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Seminar Progress</div>
                                        <div class="row g-2">
                                            <?php
                                                $badges = [
                                                    'New Student Orientation Program' => ['color' => 'bg-secondary bg-opacity-25 text-white border-secondary', 'icon' => 'bi-compass-fill', 'year' => 1, 'label' => 'Orientation'],
                                                    'IDREAMS' => ['color' => 'bg-info bg-opacity-25 text-white border-info', 'icon' => 'bi-clouds-fill', 'year' => 1],
                                                    '10C' => ['color' => 'bg-warning bg-opacity-25 text-white border-warning', 'icon' => 'bi-lightbulb-fill', 'year' => 2],
                                                    'LEADS' => ['color' => 'bg-primary bg-opacity-25 text-white border-primary', 'icon' => 'bi-people-fill', 'year' => 3],
                                                    'IMAGE' => ['color' => 'bg-teal bg-opacity-25 text-white border-teal', 'icon' => 'bi-person-badge-fill', 'year' => 4],
                                                ];
                                            ?>
                                            <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seminarName => $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php 
                                                    $isAttended = isset($attendanceMatrix[$style['year']][$seminarName]);
                                                    $isCompleted = $isAttended && ($attendanceMatrix[$style['year']][$seminarName]['status'] ?? '') === 'completed';
                                                    $displayName = $style['label'] ?? $seminarName;
                                                ?>
                                                <div class="col-6 col-md-auto" style="flex: 1 0 0;">
                                                    <div class="d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 border transition-all text-center h-100
                                                        <?php echo e($isCompleted ? $style['color'] . ' shadow-sm' : 'bg-white/5 border-white/10 text-white-50'); ?>"
                                                        style="backdrop-filter: blur(4px);">
                                                        <?php if($isCompleted): ?>
                                                            <i class="bi <?php echo e($style['icon']); ?>"></i>
                                                            <span class="fw-bold small"><?php echo e($displayName); ?></span>
                                                        <?php else: ?>
                                                            <i class="bi bi-lock-fill opacity-50"></i>
                                                            <span class="small opacity-75"><?php echo e($displayName); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Seminar Attendance Matrix</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-100 table-custom" style="table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">Year Level</th>
                                        <?php $__currentLoopData = [
                                            'New Student Orientation Program' => ['icon' => 'bi-compass-fill', 'color' => 'text-secondary'],
                                            'IDREAMS' => ['icon' => 'bi-clouds-fill', 'color' => 'text-info'], 
                                            '10C' => ['icon' => 'bi-lightbulb-fill', 'color' => 'text-warning'], 
                                            'LEADS' => ['icon' => 'bi-people-fill', 'color' => 'text-primary'], 
                                            'IMAGE' => ['icon' => 'bi-person-badge-fill', 'color' => 'text-success']
                                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seminar => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="text-center" style="width: 20%;">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <i class="bi <?php echo e($details['icon']); ?> <?php echo e($details['color']); ?>"></i>
                                                    <?php echo e($seminar); ?>

                                                </div>
                                            </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($year = 1; $year <= 4; $year++): ?>
                                        <tr class="transition-colors hover:bg-gray-50 <?php echo e($student->year_level == $year ? 'bg-green-50/50' : ''); ?>">
                                            <td class="font-bold text-gray-700 py-3">
                                                <?php
                                                    $suffixes = [1 => 'st', 2 => 'nd', 3 => 'rd', 4 => 'th'];
                                                    $seminarMap = ['New Student Orientation Program', 'IDREAMS', '10C', 'LEADS', 'IMAGE'];
                                                    $seminarStyles = [
                                                        'IDREAMS' => 'rgba(13, 202, 240, 0.05)',
                                                        '10C' => 'rgba(255, 203, 5, 0.05)',
                                                        'LEADS' => 'rgba(13, 110, 253, 0.05)',
                                                        'IMAGE' => 'rgba(25, 135, 84, 0.08)',
                                                        'New Student Orientation Program' => 'rgba(111, 66, 193, 0.08)'
                                                    ];
                                                ?>
                                                <div class="d-flex align-items-center justify-content-between pe-4">
                                                    <span><?php echo e($year); ?><?php echo e($suffixes[$year] ?? 'th'); ?> Year</span>
                                                    <?php if($student->year_level == $year): ?>
                                                        <span class="badge bg-green-100 text-green-800 border border-green-200 shadow-sm rounded-pill px-3" style="font-size: 0.65rem;">Current</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <?php $__currentLoopData = $seminarMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $seminar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php 
                                                    $seminarYearMap = [
                                                      'New Student Orientation Program' => 1,
                                                      'IDREAMS' => 1,
                                                      '10C' => 2,
                                                      'LEADS' => 3,
                                                      'IMAGE' => 4
                                                    ];
                                                    $isActiveYear = ($year == ($seminarYearMap[$seminar] ?? 0));
                                                    $attendance = $attendanceMatrix[$year][$seminar] ?? null;
                                                    $status = $attendance['status'] ?? null;
                                                ?>
                                                <td class="text-center py-3 <?php echo e($isActiveYear ? 'matrix-cell-active' : ''); ?>" 
                                                    style="<?php echo e($isActiveYear ? '--cell-bg: ' . $seminarStyles[$seminar] : ''); ?>">
                                                    <div class="d-flex flex-column align-items-center justify-content-center gap-1">
                                                        <?php if($isActiveYear): ?>
                                                            <div class="form-check d-flex justify-content-center m-0">
                                                                <input type="checkbox" 
                                                                       class="attendance-checkbox checkbox-custom form-check-input shadow-sm"
                                                                       style="width: 1.25rem; height: 1.25rem; border-color: #adb5bd;"
                                                                       data-year="<?php echo e($year); ?>"
                                                                       data-seminar="<?php echo e($seminar); ?>"
                                                                       <?php echo e($attendance ? 'checked' : ''); ?>>
                                                            </div>
                                                            <?php if($attendance): ?>
                                                                <span class="status-badge <?php echo e($status === 'completed' ? 'status-badge-completed' : 'status-badge-attended'); ?>">
                                                                    <?php echo e($status === 'completed' ? 'Completed' : 'Attended'); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <div class="opacity-10 text-gray-300">
                                                                <i class="bi bi-dash-lg" style="font-size: 1.25rem;"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 bg-gray-50 text-sm text-gray-500 border-t border-gray-100">
                            <i class="bi bi-info-circle mr-1"></i> Changes are saved automatically when you click a checkbox.
                        </div>
                    </div>

                    <!-- Evaluation Details Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="content-card">
                                <div class="card-header-custom d-flex justify-content-between align-items-center">
                                    <h3 class="text-lg font-bold text-gray-800 m-0">Seminar Evaluations</h3>
                                    <span class="badge bg-light text-dark border"><?php echo e($evaluations->count()); ?> Submissions</span>
                                </div>
                                <div class="p-4">
                                    <?php if($evaluations->isEmpty()): ?>
                                        <div class="text-center py-5 text-muted">
                                            <i class="bi bi-clipboard-x display-4 d-block mb-3 opacity-25"></i>
                                            <p>No evaluations submitted yet.</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="accordion" id="evaluationAccordion">
                                            <?php
                                                $branding = [
                                                    'IDREAMS' => ['color' => '#0dcaf0', 'icon' => 'bi-cloud-sun-fill', 'bg' => 'rgba(13, 202, 240, 0.1)'],
                                                    '10C' => ['color' => '#FFCB05', 'icon' => 'bi-lightbulb-fill', 'bg' => 'rgba(255, 203, 5, 0.1)'],
                                                    'LEADS' => ['color' => '#0d6efd', 'icon' => 'bi-people-fill', 'bg' => 'rgba(13, 110, 253, 0.1)'],
                                                    'IMAGE' => ['color' => '#198754', 'icon' => 'bi-image-fill', 'bg' => 'rgba(25, 135, 84, 0.1)'],
                                                    'New Student Orientation Program' => ['color' => '#6f42c1', 'icon' => 'bi-compass-fill', 'bg' => 'rgba(111, 66, 193, 0.1)']
                                                ];
                                            ?>

                                            <?php $__currentLoopData = ['New Student Orientation Program', 'IDREAMS', '10C', 'LEADS', 'IMAGE']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seminarName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset($evaluations[$seminarName])): ?>
                                                    <?php 
                                                        $eval = $evaluations[$seminarName];
                                                        $brand = $branding[$seminarName] ?? ['color' => '#1f7a2d', 'icon' => 'bi-clipboard-check', 'bg' => '#f8f9fa'];
                                                        // Use reliable unique ID
                                                        $slug = Str::slug($seminarName);
                                                        $headingId = "heading_" . $slug;
                                                        $collapseId = "eval_" . $slug;
                                                    ?>
                                                    <div class="accordion-item border rounded-3 mb-3" 
                                                         style="--seminar-color: <?php echo e($brand['color']); ?>; --seminar-bg: <?php echo e($brand['bg']); ?>">
                                                        <h2 class="accordion-header" id="<?php echo e($headingId); ?>">
                                                            <button class="accordion-button collapsed px-4 py-3" type="button" 
                                                                    data-bs-toggle="collapse" data-bs-target="#<?php echo e($collapseId); ?>"
                                                                    aria-expanded="false" aria-controls="<?php echo e($collapseId); ?>">
                                                                <div class="d-flex align-items-center gap-3 w-100">
                                                                    <div class="seminar-badge-icon" style="background-color: var(--seminar-color); color: white;">
                                                                        <i class="bi <?php echo e($brand['icon']); ?>"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <div class="fw-bold text-dark"><?php echo e($seminarName); ?> Evaluation</div>
                                                                        <div class="small text-muted">Submitted <?php echo e($eval->created_at->format('M d, Y')); ?></div>
                                                                    </div>
                                                                    <div class="me-3">
                                                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                                                            <i class="bi bi-star-fill <?php echo e($i <= $eval->rating ? 'text-warning' : 'text-light'); ?>"></i>
                                                                        <?php endfor; ?>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </h2>
                                                        <div id="<?php echo e($collapseId); ?>" class="accordion-collapse collapse" 
                                                             aria-labelledby="<?php echo e($headingId); ?>">
                                                            <div class="accordion-body bg-light p-4">
                                                                <?php
                                                                    $questions = [];
                                                                    $criteria = [
                                                                        'c1' => 'Useful information',
                                                                        'c2' => 'Helped learn techniques',
                                                                        'c3' => 'Strengthened confidence',
                                                                        'c4' => 'Speaker mastery',
                                                                        'c5' => 'Program logistics'
                                                                    ];

                                                                    if($seminarName === 'IMAGE') {
                                                                        $questions = [
                                                                            'q1' => '1. Compelling visual as a future employee...',
                                                                            'q2' => '2. Definition of success',
                                                                            'q3' => '3. What makes a Filipino leader?',
                                                                            'q4' => '4. 4 Key traits of GRIT',
                                                                            'q5' => '5. How to build GRIT as fresh graduate?',
                                                                            'q6' => '6. Resilient board taker'
                                                                        ];
                                                                    } elseif($seminarName === 'IDREAMS') {
                                                                        $questions = [
                                                                            'q1' => '1. Emotion is a habit of ____?',
                                                                            'q2' => '2. Relate is a habit of ____?',
                                                                            'q3' => '3. Direction is a habit of____?',
                                                                            'q4' => '4. Initiative is a habit of_____?'
                                                                        ];
                                                                    } elseif($seminarName === '10C') {
                                                                        $questions = [
                                                                            'q1' => '1. Challenging negative thought',
                                                                            'q2' => '2. Making the right choice',
                                                                            'q3' => '3. Solving problem',
                                                                            'q4' => '4. Learning mindfulness',
                                                                            'q5' => '5. Recognizing goodness and strengths'
                                                                        ];
                                                                    } elseif($seminarName === 'LEADS') {
                                                                        $questions = [
                                                                            'q1' => '1. Psychological traits',
                                                                            'q2' => '2. Reaction to circumstances',
                                                                            'q3' => "3. Disposition or thought process",
                                                                            'q4' => "4. Not contributing in personality",
                                                                            'q5' => '5. Not belonging on ways to make people like you',
                                                                            'q6' => '6. Why do people get angry?',
                                                                            'q7' => '7. Reaction to perceived demands/threats',
                                                                            'q8' => '8. Positive and beneficial stress',
                                                                            'q9' => "9. Replenishing resources (Self-Care)",
                                                                            'q10' => '10. Time management: schedule priorities'
                                                                        ];
                                                                    } elseif($seminarName === 'New Student Orientation Program') {
                                                                        $questions = [
                                                                            'q1' => '1. Student Status',
                                                                            'q2' => '2. Dropping Subjects',
                                                                            'q3' => '3. Removing Incomplete Grades',
                                                                            'q4' => '4. GDSU meaning',
                                                                            'q5' => '5. GCC meaning',
                                                                            'q6' => '6. Prohibited Organizations',
                                                                            'q7' => '7. Magna Cum Laude GWA',
                                                                            'q8' => '8. Retention Policy',
                                                                            'q9' => '9. Medical Certificate Issuer',
                                                                            'q10' => '10. Student Handbook Knowledge',
                                                                            'q11' => '11. UCGD meaning',
                                                                            'q12' => '12. Office of Security Services',
                                                                            'q13' => '13. Data Protection Office',
                                                                            'q14' => '14. Consent Definition',
                                                                            'q15' => '15. DTO meaning',
                                                                            'q16' => '16. Mental Health Support Group',
                                                                            'q17' => '17. Student Legal Services',
                                                                            'q18' => '18. Not a CMU College',
                                                                            'q19' => '19. CMU Motto',
                                                                            'q20' => '20. CMU Hymn Phrase',
                                                                            'q21' => '21. Anti-Hazing Law',
                                                                            'q22' => '22. Initiation Rite',
                                                                            'q23' => '23. Hazing Definition',
                                                                            'q24' => '24. Hazing Participants',
                                                                            'q25' => '25. Hazing Liability'
                                                                        ];
                                                                    }
                                                                ?>


                                                                <?php if($seminarName === 'New Student Orientation Program'): ?>
                                                                     <div class="alert alert-info d-flex align-items-center mb-3">
                                                                         <i class="bi bi-info-circle-fill me-2"></i>
                                                                         <div>
                                                                             <strong>Score:</strong> <?php echo e($eval->answers['score'] ?? 'N/A'); ?> / 25
                                                                             <span class="badge ms-2 <?php echo e(($eval->answers['passed'] ?? false) ? 'bg-success' : 'bg-danger'); ?>">
                                                                                 <?php echo e(($eval->answers['passed'] ?? false) ? 'PASSED' : 'FAILED'); ?>

                                                                             </span>
                                                                         </div>
                                                                     </div>
                                                                <?php endif; ?>

                                                                <?php if(!empty($questions)): ?>
                                                                    <div class="row g-4">
                                                                        <div class="col-md-7">
                                                                            <h5 class="eval-section-title" style="color: var(--seminar-color)">Seminar Questions</h5>
                                                                            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div class="question-card shadow-sm">
                                                                                    <div class="small fw-bold text-muted mb-1"><?php echo e($label); ?></div>
                                                                                    <div class="text-dark"><?php echo e($eval->answers[$key] ?? 'N/A'); ?></div>
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <h5 class="eval-section-title" style="color: var(--seminar-color)">Satisfaction Criteria</h5>
                                                                            <?php $__currentLoopData = $criteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div class="criteria-row shadow-sm">
                                                                                    <span class="small fw-500"><?php echo e($label); ?></span>
                                                                                    <span class="badge" style="background-color: var(--seminar-color); color: white;">
                                                                                        <?php echo e($eval->answers[$key] ?? 'N/A'); ?> / 5
                                                                                    </span>
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                                            <div class="mt-4">
                                                                                <h5 class="eval-section-title" style="color: var(--seminar-color)">Comments</h5>
                                                                                <div class="bg-white p-3 rounded-3 shadow-sm italic text-dark border">
                                                                                    "<?php echo e($eval->comments ?: 'No comments provided.'); ?>"
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="bg-white p-4 rounded-3 shadow-sm border">
                                                                        <h6 class="fw-bold mb-3" style="color: var(--seminar-color)">General Evaluation</h6>
                                                                        <div class="mb-3">
                                                                            <span class="text-muted small d-block">Overall Rating</span>
                                                                            <span class="fw-bold h5 mb-0"><?php echo e($eval->rating); ?> / 5</span>
                                                                        </div>
                                                                        <div>
                                                                            <span class="text-muted small d-block">Comments</span>
                                                                            <p class="mb-0 italic">"<?php echo e($eval->comments ?: 'No comments provided.'); ?>"</p>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Selection Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-2xl">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title font-bold text-gray-800">Select Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-gray-600 text-sm mb-4">Please select the specific schedule the student attended for <span id="modalSeminarName" class="font-bold text-primary-green"></span>.</p>

                    <div id="scheduleOptions" class="space-y-2">
                        <!-- Options will be populated by JS -->
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light text-gray-600" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmScheduleBtn" class="btn-primary-custom">Confirm Attendance</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle for mobile
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                            sidebar.classList.remove('show');
                        }
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Data from backend
            const seminars = <?php echo json_encode($seminars, 15, 512) ?>;
            const attendanceMatrix = <?php echo json_encode($attendanceMatrix, 15, 512) ?>;
            let currentCheckbox = null;
            let currentYear = null;
            let currentSeminarName = null;

            // Modal instance
            const scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));

            // Attendance Checkbox Logic
            const checkboxes = document.querySelectorAll('.attendance-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function(e) {
                    const year = this.dataset.year;
                    const seminarName = this.dataset.seminar;
                    const isChecking = this.checked;

                    if (isChecking) {
                        e.preventDefault(); // Prevent immediate checking
                        currentCheckbox = this;
                        currentYear = year;
                        currentSeminarName = seminarName;

                        // Find seminar details
                        const seminar = seminars.find(s => s.name === seminarName);

                        if (seminar && seminar.schedules && seminar.schedules.length > 0) {
                            // Populate modal
                            document.getElementById('modalSeminarName').textContent = seminarName;
                            const optionsContainer = document.getElementById('scheduleOptions');
                            optionsContainer.innerHTML = '';

                            seminar.schedules.forEach(schedule => {
                                const date = new Date(schedule.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                                const div = document.createElement('div');
                                div.className = 'form-check p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors';
                                div.innerHTML = `
                                    <input class="form-check-input" type="radio" name="schedule_id" value="${schedule.id}" id="schedule_${schedule.id}">
                                    <label class="form-check-label w-full cursor-pointer ml-2" for="schedule_${schedule.id}">
                                        <div class="font-semibold text-gray-800">${date}</div>
                                        <div class="text-xs text-gray-500 flex gap-2 mt-1">
                                            <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded">${schedule.session_type}</span>
                                            <span>${schedule.location || 'No Location'}</span>
                                        </div>
                                    </label>
                                `;
                                optionsContainer.appendChild(div);

                                // Allow clicking the div to select radio
                                div.addEventListener('click', () => {
                                    div.querySelector('input').checked = true;
                                });
                            });

                            scheduleModal.show();
                        } else {
                            // No schedules found, just mark as attended (legacy behavior)
                            updateAttendance(year, seminarName, true, null);
                        }
                    } else {
                        // Unchecking - remove attendance
                        updateAttendance(year, seminarName, false, null);
                    }
                });
            });

            // Confirm Button Logic
            const confirmBtn = document.getElementById('confirmScheduleBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    const selectedSchedule = document.querySelector('input[name="schedule_id"]:checked');
                    if (selectedSchedule) {
                        updateAttendance(currentYear, currentSeminarName, true, selectedSchedule.value);
                        scheduleModal.hide();
                    } else {
                        alert('Please select a schedule.');
                    }
                });
            }

            function updateAttendance(year, seminarName, attended, scheduleId) {
                fetch(`<?php echo e(route('counselor.guidance.update', $student)); ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        year_level: year,
                        seminar_name: seminarName,
                        attended: attended,
                        seminar_schedule_id: scheduleId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (currentCheckbox) {
                            currentCheckbox.checked = attended;
                        } else {
                             const cb = document.querySelector(`.attendance-checkbox[data-year="${year}"][data-seminar="${seminarName}"]`);
                             if(cb) cb.checked = attended;
                        }
                    } else {
                        alert('Failed to update attendance');
                        if (currentCheckbox) currentCheckbox.checked = !attended;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                    if (currentCheckbox) currentCheckbox.checked = !attended;
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/guidance/show.blade.php ENDPATH**/ ?>