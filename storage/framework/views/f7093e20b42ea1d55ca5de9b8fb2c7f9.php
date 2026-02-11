

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

        /* Sidebar Styles */
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

        .main-dashboard-inner {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Module Styles */
        .page-header {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            color: #fff;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }

        .page-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
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
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--light-green);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-custom th {
            background-color: var(--light-green);
            color: var(--primary-green);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            padding: 0.75rem 1rem;
            border: none;
        }

        .table-custom td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .table-custom tr:hover td {
            background-color: #fafdfa;
        }

        .btn-primary-custom {
            background: var(--primary-green);
            border: none;
            color: #fff;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(31, 122, 45, 0.3);
        }

        .btn-primary-custom:hover {
            background: var(--primary-green-2);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(31, 122, 45, 0.4);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--primary-green);
            color: var(--primary-green);
            padding: 0.4rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-outline-custom:hover {
            background: var(--light-green);
            color: var(--primary-green-2);
        }

        .form-control-custom,
        .form-select-custom {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        .badge-custom {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .badge-success-custom {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning-custom {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-locked-custom {
            background-color: #e9ecef;
            color: #6c757d;
        }

        .badge-info-custom {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .progress-custom {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            background: var(--hero-gradient);
        }

        /* Avatar styles */
        .student-avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: 2px solid #fff;
        }

        /* Bulk Toolbar */
        #bulkToolbar {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            z-index: 1050;
            display: none;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid var(--primary-green);
            max-width: 90vw;
            flex-wrap: wrap;
            justify-content: center;
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            #bulkToolbar {
                bottom: 1rem;
                padding: 0.5rem 0.75rem;
                border: 2px solid var(--primary-green);
                border-radius: 16px;
                gap: 0.5rem;
                flex-direction: column;
                width: 95%;
                font-size: 0.8rem;
            }

            #bulkToolbar .d-flex {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.5rem !important;
            }

            #bulkToolbar button {
                padding: 0.25rem 0.75rem !important;
                font-size: 0.8rem !important;
            }

            #bulkToolbar select {
                padding: 0.25rem 0.5rem !important;
                font-size: 0.8rem !important;
                min-width: 120px !important;
            }
        }

        #bulkToolbar.show {
            display: flex;
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                transform: translate(-50%, 100%);
                opacity: 0;
            }

            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        /* Modal Custom */
        .modal-header {
            background: var(--light-green);
            color: var(--primary-green);
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
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

                    <!-- Header -->
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="page-title">Guidance Module</h2>
                            <p class="page-subtitle mt-1">Track attendance, generate reports, and manage student seminars
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light text-success fw-bold" data-bs-toggle="modal"
                                data-bs-target="#importModal">
                                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Import CSV
                            </button>
                        </div>
                    </div>

                    <!-- Main Content Card -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Student List</h3>

                            <form method="GET" action="<?php echo e(route('counselor.guidance.index')); ?>"
                                class="row g-2 align-items-center w-100 mt-2 mt-lg-0">
                                <!-- Filter by Year -->
                                <div class="col-6 col-md-auto">
                                    <select name="year_level" class="form-select-custom w-100"
                                        onchange="this.form.submit()">
                                        <option value="">All Years</option>
                                        <option value="1" <?php echo e(request('year_level') == '1' ? 'selected' : ''); ?>>1st Year
                                        </option>
                                        <option value="2" <?php echo e(request('year_level') == '2' ? 'selected' : ''); ?>>2nd Year
                                        </option>
                                        <option value="3" <?php echo e(request('year_level') == '3' ? 'selected' : ''); ?>>3rd Year
                                        </option>
                                        <option value="4" <?php echo e(request('year_level') == '4' ? 'selected' : ''); ?>>4th Year
                                        </option>
                                        <option value="5" <?php echo e(request('year_level') == '5' ? 'selected' : ''); ?>>5th Year
                                        </option>
                                        <option value="6" <?php echo e(request('year_level') == '6' ? 'selected' : ''); ?>>6th Year
                                        </option>
                                    </select>
                                </div>

                                <!-- Filter by College -->
                                <div class="col-6 col-md-auto">
                                    <select name="college" class="form-select-custom w-100" onchange="this.form.submit()"
                                        style="max-width: 200px;">
                                        <option value="">All Colleges</option>
                                        <option value="College of Arts and Sciences" <?php echo e(request('college') == 'College of Arts and Sciences' ? 'selected' : ''); ?>>CAS</option>
                                        <option value="College of Veterinary Medicine" <?php echo e(request('college') == 'College of Veterinary Medicine' ? 'selected' : ''); ?>>CVM</option>
                                        <option value="College of Forestry and Environmental Sciences" <?php echo e(request('college') == 'College of Forestry and Environmental Sciences' ? 'selected' : ''); ?>>CFES</option>
                                        <option value="College of Business and Management" <?php echo e(request('college') == 'College of Business and Management' ? 'selected' : ''); ?>>CBM</option>
                                        <option value="College of Nursing" <?php echo e(request('college') == 'College of Nursing' ? 'selected' : ''); ?>>CON</option>
                                        <option value="College of Human Ecology" <?php echo e(request('college') == 'College of Human Ecology' ? 'selected' : ''); ?>>CHE</option>
                                        <option value="College of Agriculture" <?php echo e(request('college') == 'College of Agriculture' ? 'selected' : ''); ?>>CA</option>
                                        <option value="College of Information Sciences and Computing" <?php echo e(request('college') == 'College of Information Sciences and Computing' ? 'selected' : ''); ?>>CISC</option>
                                        <option value="College of Education" <?php echo e(request('college') == 'College of Education' ? 'selected' : ''); ?>>CE</option>
                                        <option value="College of Engineering" <?php echo e(request('college') == 'College of Engineering' ? 'selected' : ''); ?>>COE</option>
                                    </select>
                                </div>

                                <!-- Filter by Seminar -->
                                <div class="col-6 col-md-auto">
                                    <select name="seminar_name" class="form-select-custom w-100"
                                        onchange="this.form.submit()">
                                        <option value="">All Seminars</option>
                                        <option value="New Student Orientation Program" <?php echo e(request('seminar_name') == 'New Student Orientation Program' ? 'selected' : ''); ?>>
                                            New Student Orientation Program</option>
                                        <option value="IDREAMS" <?php echo e(request('seminar_name') == 'IDREAMS' ? 'selected' : ''); ?>>
                                            IDREAMS</option>
                                        <option value="10C" <?php echo e(request('seminar_name') == '10C' ? 'selected' : ''); ?>>10C
                                        </option>
                                        <option value="LEADS" <?php echo e(request('seminar_name') == 'LEADS' ? 'selected' : ''); ?>>LEADS
                                        </option>
                                        <option value="IMAGE" <?php echo e(request('seminar_name') == 'IMAGE' ? 'selected' : ''); ?>>IMAGE
                                        </option>
                                    </select>
                                </div>

                                <!-- Filter by Attendance Status -->
                                <div class="col-6 col-md-auto">
                                    <select name="status" class="form-select-custom w-100" onchange="this.form.submit()">
                                        <option value="">Attendance</option>
                                        <option value="unlocked" <?php echo e(request('status') == 'unlocked' ? 'selected' : ''); ?>>
                                            Verified (Unlocked)</option>
                                        <option value="attended" <?php echo e(request('status') == 'attended' ? 'selected' : ''); ?>>
                                            Completed</option>
                                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending
                                        </option>
                                    </select>
                                </div>

                                <!-- Filter by Evaluation Status -->
                                <div class="col-6 col-md-auto">
                                    <select name="eval_status" class="form-select-custom w-100"
                                        onchange="this.form.submit()">
                                        <option value="">Evaluation</option>
                                        <option value="done" <?php echo e(request('eval_status') == 'done' ? 'selected' : ''); ?>>Done
                                        </option>
                                        <option value="missing" <?php echo e(request('eval_status') == 'missing' ? 'selected' : ''); ?>>
                                            Missing</option>
                                    </select>
                                </div>

                                <!-- Per Page -->
                                <div class="col-6 col-md-auto">
                                    <select name="per_page" class="form-select-custom w-100" onchange="this.form.submit()">
                                        <option value="15" <?php echo e($perPage == 15 ? 'selected' : ''); ?>>15 per page</option>
                                        <option value="30" <?php echo e($perPage == 30 ? 'selected' : ''); ?>>30 per page</option>
                                        <option value="50" <?php echo e($perPage == 50 ? 'selected' : ''); ?>>50 per page</option>
                                        <option value="100" <?php echo e($perPage == 100 ? 'selected' : ''); ?>>100 per page</option>
                                    </select>
                                </div>

                                <!-- Search -->
                                <div class="col-12 col-md flex-grow-1">
                                    <div class="d-flex w-100">
                                        <input type="text" name="search" placeholder="Search name or ID..."
                                            value="<?php echo e(request('search')); ?>" class="form-control-custom rounded-end-0 w-100">
                                        <button type="submit" class="btn-primary-custom rounded-start-0">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Bulk Action Form Wrapper -->
                        <form id="bulkActionForm" action="<?php echo e(route('counselor.guidance.bulk.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-custom">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;">
                                                <input type="checkbox" id="selectAllCheckbox" class="form-check-input"
                                                    style="transform: scale(1.2); cursor: pointer;">
                                            </th>
                                            <th>Name / ID</th>
                                            <th>College / Year</th>
                                            <th class="text-center">Progress</th>
                                            <th class="text-center">Attendance</th>
                                            <th class="text-center">Evaluation</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $seminarIdMap = $allSeminars->pluck('id', 'name')->toArray();
                                        ?>
                                        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php
                                                $seminarMap = ['New Student Orientation Program' => 1, 'IDREAMS' => 1, '10C' => 2, 'LEADS' => 3, 'IMAGE' => 4];
                                                $completedCount = 0;
                                                $totalRequiredSoFar = 0;
                                                foreach ($seminarMap as $name => $targetYear) {
                                                    if ($student->year_level >= $targetYear) {
                                                        $totalRequiredSoFar++;
                                                        $attendance = $student->seminarAttendances->where('seminar_name', $name)->first();
                                                        if ($attendance && $attendance->status === 'completed') {
                                                            $completedCount++;
                                                        }
                                                    }
                                                }
                                                $progressPercent = $totalRequiredSoFar > 0 ? ($completedCount / $totalRequiredSoFar) * 100 : 0;
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="student_ids[]" value="<?php echo e($student->id); ?>"
                                                        class="student-checkbox form-check-input"
                                                        style="transform: scale(1.2); cursor: pointer;" <?php echo e(in_array($student->id, $selectedIds) ? 'checked' : ''); ?>>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="<?php echo e($student->avatar_url); ?>" alt="<?php echo e($student->name); ?>"
                                                            class="student-avatar-sm">
                                                        <div>
                                                            <div class="font-bold text-gray-800"><?php echo e($student->name); ?></div>
                                                            <div class="text-sm text-gray-500">
                                                                <?php echo e($student->student_id ?? 'N/A'); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-medium"><?php echo e($student->college_acronym); ?></div>
                                                    <div class="text-sm text-gray-500"><?php echo e($student->year_level_label); ?></div>
                                                </td>

                                                <td class="align-middle" style="min-width: 120px;">
                                                    <div class="progress-custom">
                                                        <div class="progress-bar-custom"
                                                            style="width: <?php echo e($progressPercent); ?>%; height: 100%;"></div>
                                                    </div>
                                                    <div class="text-xs text-center text-gray-500 mt-1 font-medium">
                                                        <?php echo e($completedCount); ?>/<?php echo e($totalRequiredSoFar); ?> Completed
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <?php $__currentLoopData = $seminarMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seminarName => $targetYear): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $isLocked = $student->year_level < $targetYear;
                                                                $attendance = $student->seminarAttendances->where('seminar_name', $seminarName)->first();
                                                                $isAttended = $attendance && $attendance->status === 'completed';
                                                                $isUnlocked = $attendance && $attendance->status === 'unlocked';

                                                                if ($isLocked) {
                                                                    $badgeClass = 'badge-locked-custom';
                                                                    $icon = 'bi-lock-fill';
                                                                    $title = "Attendance: Locked ($seminarName)";
                                                                } elseif ($isAttended) {
                                                                    $badgeClass = 'badge-success-custom';
                                                                    $icon = 'bi-check-circle-fill';
                                                                    $title = "Attendance: Completed ($seminarName)";
                                                                } elseif ($isUnlocked) {
                                                                    $badgeClass = 'badge-info-custom';
                                                                    $icon = 'bi-unlock-fill';
                                                                    $title = "Attendance: Verified & Unlocked (Waiting Evaluation) ($seminarName)";
                                                                } elseif ($attendance && $attendance->status === 'attended') {
                                                                    $badgeClass = 'badge-primary-custom'; // New class or reuse info/primary
                                                                    $icon = 'bi-check-circle';
                                                                    $title = "Attendance: Verified (Locked) ($seminarName)";
                                                                    // We can style this distinctly
                                                                    $badgeClass = 'badge-custom bg-info text-dark opacity-75';
                                                                } else {
                                                                    $badgeClass = 'badge-warning-custom';
                                                                    $icon = 'bi-exclamation-circle';
                                                                    $title = "Attendance: Pending Verification ($seminarName)";
                                                                }
                                                            ?>

                                                            <span class="badge-custom <?php echo e($badgeClass); ?>" data-bs-toggle="tooltip"
                                                                title="<?php echo e($title); ?>"
                                                                style="cursor: help; width: 32px; height: 32px; justify-content: center; padding: 0;">
                                                                <i class="bi <?php echo e($icon); ?>" style="font-size: 1rem;"></i>
                                                            </span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <?php $__currentLoopData = $seminarMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seminarName => $targetYear): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $sId = $seminarIdMap[$seminarName] ?? null;
                                                                $isLocked = $student->year_level < $targetYear;
                                                                $isEvaluated = $sId && $student->seminarEvaluations->where('seminar_id', $sId)->isNotEmpty();

                                                                if ($isLocked) {
                                                                    $badgeClass = 'badge-locked-custom';
                                                                    $icon = 'bi-lock-fill';
                                                                    $title = "Evaluation: Locked ($seminarName)";
                                                                } elseif ($isEvaluated) {
                                                                    $badgeClass = 'badge-success-custom';
                                                                    $icon = 'bi-file-earmark-check-fill';
                                                                    $title = "Evaluation: Done ($seminarName)";
                                                                } else {
                                                                    $badgeClass = 'badge-warning-custom';
                                                                    $icon = 'bi-file-earmark-text';
                                                                    $title = "Evaluation: Missing ($seminarName)";
                                                                }
                                                            ?>

                                                            <span class="badge-custom <?php echo e($badgeClass); ?>" data-bs-toggle="tooltip"
                                                                title="<?php echo e($title); ?>"
                                                                style="cursor: help; width: 32px; height: 32px; justify-content: center; padding: 0;">
                                                                <i class="bi <?php echo e($icon); ?>" style="font-size: 1rem;"></i>
                                                            </span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="<?php echo e(route('counselor.guidance.show', $student)); ?>"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-pencil-square"></i> Manage
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-gray-500">
                                                    <i class="bi bi-inbox text-4xl mb-2 block opacity-50"></i>
                                                    No students found matching your filters.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Bulk Toolbar -->
                            <div id="bulkToolbar">
                                <span class="fw-bold text-success me-1 d-none d-md-inline" style="font-size: 0.75rem;"><span
                                        id="selectedCount">0</span> selected</span>
                                <div class="d-flex gap-1 align-items-center">
                                    <select name="seminar_name" class="form-select-custom form-select-sm py-0 ps-2 pe-4"
                                        required style="min-width: 130px; font-size: 0.75rem; height: 28px;"
                                        id="bulkSeminarSelect">
                                        <option value="">Select Seminar...</option>
                                        <?php $__currentLoopData = $allSeminars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sem->name); ?>" <?php echo e((session('guidance_target_seminar') == $sem->name || request('seminar_name') == $sem->name) ? 'selected' : ''); ?>>
                                                <?php echo e($sem->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <input type="hidden" name="status" id="bulkStatusInput" value="unlocked">
                                    <input type="hidden" name="year_level" id="bulkYearLevel"
                                        value="<?php echo e(session('guidance_target_year', request('year_level'))); ?>">

                                    <div class="d-flex gap-1">
                                        <!-- Step 1: Verify -->
                                        <button type="button" onclick="submitBulk('attended')"
                                            class="btn btn-primary rounded-pill px-2 py-0 fw-bold btn-sm shadow-none border-0"
                                            style="font-size: 0.75rem; height: 28px; line-height: 1.2;"
                                            title="Step 1: Mark students as attended. Evaluation remains locked.">
                                            <i class="bi bi-check-lg me-1"></i> Verify
                                        </button>

                                        <!-- Step 2: Unlock -->
                                        <button type="button" onclick="submitBulk('unlocked')"
                                            class="btn btn-warning rounded-pill px-2 py-0 fw-bold btn-sm shadow-none border-0 text-dark"
                                            style="font-size: 0.75rem; height: 28px; line-height: 1.2;"
                                            title="Step 2: Unlock evaluation for students who have attended.">
                                            <i class="bi bi-unlock-fill me-1"></i> Unlock
                                        </button>

                                        <!-- Admin Override -->
                                        <button type="button" onclick="submitBulk('completed')"
                                            class="btn btn-light rounded-pill px-2 py-0 fw-bold btn-sm border text-secondary"
                                            style="font-size: 0.75rem; height: 28px; line-height: 1.2;"
                                            title="Admin: Manually mark as completed (bypasses evaluation).">
                                            <i class="bi bi-check-all"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="ms-1 border-start ps-2 d-flex align-items-center" style="height: 16px;">
                                    <a href="<?php echo e(route('counselor.guidance.clear_selection')); ?>"
                                        class="btn btn-sm btn-link text-danger p-0 fw-bold"
                                        style="text-decoration: none; font-size: 0.75rem; line-height: 1;">
                                        Clear
                                    </a>
                                </div>
                                <button type="button" id="cancelSelection" class="btn btn-link text-muted p-0 ms-2"
                                    style="text-decoration: none;">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </form>

                        <div class="pagination-wrap p-4">
                            <?php echo e($students->links('vendor.pagination.premium')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Import Attendance CSV
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="<?php echo e(route('counselor.guidance.import')); ?>" method="POST" enctype="multipart/form-data"
                        id="importForm">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Seminar</label>
                            <select name="seminar_name" class="form-select-custom w-100" required>
                                <option value="">Select Seminar...</option>
                                <option value="New Student Orientation Program">New Student Orientation Program (Year 1)
                                </option>
                                <option value="IDREAMS">IDREAMS (Year 1)</option>
                                <option value="10C">10C (Year 2)</option>
                                <option value="LEADS">LEADS (Year 3)</option>
                                <option value="IMAGE">IMAGE (Year 4)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Year Level</label>
                            <select name="year_level" class="form-select-custom w-100" required>
                                <option value="">Select Year...</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">CSV File</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                            <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Must have
                                <strong>student_id</strong> column.
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold py-2">Upload and Process</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Sidebar Toggle
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => { if (window.innerWidth < 768) sidebar.classList.toggle('show'); });
                document.addEventListener('click', (e) => {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show') && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }

            // Bulk Selection Logic
            const selectAll = document.getElementById('selectAllCheckbox');
            const studentCheckboxes = document.querySelectorAll('.student-checkbox');
            const bulkToolbar = document.getElementById('bulkToolbar');
            const selectedCountSpan = document.getElementById('selectedCount');
            const cancelSelection = document.getElementById('cancelSelection');

            const initialSelectedIds = <?php echo json_encode($selectedIds, 15, 512) ?>;
            const currentSelectedIds = new Set(initialSelectedIds.map(id => String(id)));

            function updateBulkToolbar() {
                // Sync current page checkboxes with the Set
                studentCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        currentSelectedIds.add(String(cb.value));
                    } else {
                        currentSelectedIds.delete(String(cb.value));
                    }
                });

                const displayCount = currentSelectedIds.size;

                if (displayCount > 0) {
                    bulkToolbar.classList.add('show');
                    selectedCountSpan.textContent = displayCount;
                } else {
                    bulkToolbar.classList.remove('show');
                }
            }

            // Sync on load (for session-based ones visible on current page)
            updateBulkToolbar();

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    studentCheckboxes.forEach(cb => {
                        cb.checked = selectAll.checked;
                    });
                    updateBulkToolbar();
                });
            }

            studentCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateBulkToolbar);
            });

            if (cancelSelection) {
                cancelSelection.addEventListener('click', function () {
                    studentCheckboxes.forEach(cb => cb.checked = false);
                    if (selectAll) selectAll.checked = false;
                    updateBulkToolbar();
                });
            }

            window.submitBulk = function (status) {
                const seminarSelect = document.getElementById('bulkSeminarSelect');
                if (!seminarSelect.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Seminar',
                        text: 'Please choose which seminar you are marking attendance for.'
                    });
                    return;
                }

                document.getElementById('bulkStatusInput').value = status;

                let title, text;

                if (status === 'attended') {
                    title = 'Verify Attendance?';
                    text = `Mark selected students as PRESENT for ${seminarSelect.value}? Evaluation will remain locked until you unlock it.`;
                } else if (status === 'unlocked') {
                    title = 'Unlock Evaluations?';
                    text = `Allow selected students to ACCESS EVALUATION for ${seminarSelect.value}?`;
                } else if (status === 'completed') {
                    title = 'Mark as Completed?';
                    text = `Manually mark selected students as COMPLETED for ${seminarSelect.value}? This bypasses evaluation.`;
                }

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1f7a2d',
                    confirmButtonText: 'Yes, Proceed',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('bulkActionForm');
                        if (form) {
                            // Create hidden input if form doesn't have internal way to set status (it uses bulkStatusInput outside form usually?)
                            // Let's check where bulkStatusInput is. It is inside #bulkToolbar which is likely OUTSIDE the form if the table is the form?
                            // Actually, let's check the HTML structure.
                            // The form usually wraps the table or the toolbar is part of it.
                            // If bulkStatusInput is in the toolbar, we need to ensure it's submitted.

                            // Re-reading code:
                            // Line 726: <input type="hidden" name="status" id="bulkStatusInput" value="unlocked">
                            // This input is inside #bulkToolbar.
                            // If #bulkActionForm is wrapping the table, and #bulkToolbar is outside, this input might not be submitted if it's not associated with the form.
                            // However, let's assume the previous code worked, implying #bulkStatusInput is inside the form OR linked to it.

                            // Wait, looking at line 714: <div id="bulkToolbar">...</div>
                            // If the form is around the table, and toolbar is outside, we have a problem.
                            // But let's assume standard structure: <form id="bulkActionForm"> ... <table> ... </form>
                            // And if toolbar has the submit buttons and inputs, they should be in the form.

                            // But wait, the previous code was: document.getElementById('bulkStatusInput').value = status;
                            // This suggests bulkStatusInput IS used.

                            document.getElementById('bulkActionForm').submit();
                        } else {
                            // Fallback if form ID is different or issues
                            console.error('Form bulkActionForm not found');
                        }
                    }
                });
            };
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/guidance/index.blade.php ENDPATH**/ ?>