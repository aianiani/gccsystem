

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
                    <div class="mb-6">
                        <a href="<?php echo e(route('counselor.students.index')); ?>" class="btn-secondary-custom">
                            <i class="bi bi-arrow-left"></i> Back to Student List
                        </a>
                    </div>

                    <!-- Student Profile Header (Seminar Highlight Version) -->
                    <div class="page-header py-4 px-4">
                        <div class="row g-4 align-items-center">
                            
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
                                                    'IDREAMS' => ['color' => 'bg-info bg-opacity-25 text-white border-info', 'icon' => 'bi-clouds-fill', 'year' => 1],
                                                    '10C' => ['color' => 'bg-warning bg-opacity-25 text-white border-warning', 'icon' => 'bi-lightbulb-fill', 'year' => 2],
                                                    'LEADS' => ['color' => 'bg-primary bg-opacity-25 text-white border-primary', 'icon' => 'bi-people-fill', 'year' => 3],
                                                    'IMAGE' => ['color' => 'bg-teal bg-opacity-25 text-white border-teal', 'icon' => 'bi-person-badge-fill', 'year' => 4],
                                                ];
                                            ?>
                                            <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seminarName => $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $isAttended = isset($attendanceMatrix[$style['year']][$seminarName]); ?>
                                                <div class="col-6 col-sm-3">
                                                    <div class="d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 border transition-all text-center
                                                        <?php echo e($isAttended ? $style['color'] . ' shadow-sm' : 'bg-white/5 border-white/10 text-white-50'); ?>"
                                                        style="backdrop-filter: blur(4px);">
                                                        <?php if($isAttended): ?>
                                                            <i class="bi <?php echo e($style['icon']); ?>"></i>
                                                            <span class="fw-bold small"><?php echo e($seminarName); ?></span>
                                                        <?php else: ?>
                                                            <i class="bi bi-lock-fill opacity-50"></i>
                                                            <span class="small opacity-75"><?php echo e($seminarName); ?></span>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Assessments Card -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h3 class="text-lg font-bold text-gray-800 m-0">Recent Assessments</h3>
                            </div>
                            <div class="p-4">
                                <?php $__empty_1 = true; $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="border-b border-gray-100 last:border-0 pb-3 mb-3 last:pb-0 last:mb-0">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="font-semibold text-gray-800"><?php echo e(ucfirst($assessment->type)); ?>

                                                    Assessment</div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo e($assessment->created_at ? $assessment->created_at->format('M d, Y') : 'Date not set'); ?></div>
                                            </div>
                                            <a href="<?php echo e(route('counselor.assessments.show', $assessment)); ?>"
                                                class="text-sm text-primary-green hover:underline">View</a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-center text-gray-500 py-4">No assessments found.</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Appointments Card -->
                        <div class="content-card">
                            <div class="card-header-custom">
                                <h3 class="text-lg font-bold text-gray-800 m-0">Recent Appointments</h3>
                            </div>
                            <div class="p-4">
                                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="border-b border-gray-100 last:border-0 pb-3 mb-3 last:pb-0 last:mb-0">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="font-semibold text-gray-800"><?php echo e($appointment->appointment_type); ?>

                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    <?php echo e($appointment->scheduled_at ? $appointment->scheduled_at->format('M d, Y \a\t h:i A') : 'Date not set'); ?></div>
                                                <div class="text-xs mt-1">
                                                    <span
                                                        class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600"><?php echo e(ucfirst($appointment->status)); ?></span>
                                                </div>
                                            </div>
                                            <a href="<?php echo e(route('counselor.appointments.show', $appointment->id)); ?>"
                                                class="text-sm text-primary-green hover:underline">View</a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-center text-gray-500 py-4">No appointments found.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle for mobile
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
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
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/students/show.blade.php ENDPATH**/ ?>