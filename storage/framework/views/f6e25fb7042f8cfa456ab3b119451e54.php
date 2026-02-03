

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

        .welcome-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            min-height: 100px;
        }

        .welcome-card .welcome-text {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }

        .welcome-card .welcome-date {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .welcome-card .welcome-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Reuse premium dashboard styles */
        .filter-control {
            background: #fff;
            border: 1.5px solid var(--gray-100);
            border-radius: 12px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            color: var(--text-dark);
            transition: all 0.2s;
            width: 100%;
        }

        .filter-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        .filter-select {
            background: #fff;
            border: 1.5px solid var(--gray-100);
            border-radius: 12px;
            padding: 0.6rem 2rem 0.6rem 1rem;
            font-size: 0.9rem;
            color: var(--text-dark);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-filter {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-filter:hover {
            background: var(--forest-green-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(31, 122, 45, 0.2);
        }

        .btn-reset {
            background: var(--gray-50);
            color: var(--text-light);
            border: 1.5px solid var(--gray-100);
            border-radius: 12px;
            padding: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-reset:hover {
            background: #fff;
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* Table Aesthetics */
        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--gray-50);
            margin-right: 0.85rem;
        }

        .user-details h6 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .user-details span {
            font-size: 0.75rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Bulk Actions Bar */
        .bulk-actions-bar {
            position: fixed;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            border: 1px solid var(--gray-100);
            border-radius: 100px;
            padding: 0.75rem;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            min-width: 500px;
        }

        .bulk-actions-bar.active {
            bottom: 30px;
        }

        .selected-badge {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 0.5rem 1rem;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .bulk-btn {
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .bulk-btn-delete {
            background: #fff;
            color: var(--text-dark);
            border: 1.5px solid var(--gray-100);
        }

        .bulk-btn-delete:hover {
            background: var(--bg-light);
            transform: translateY(-1px);
        }

        .btn-close-bulk {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.25rem;
            padding: 0 0.5rem;
            transition: color 0.2s;
        }

        .btn-close-bulk:hover {
            color: var(--danger);
        }

        .v-divider {
            width: 1px;
            height: 24px;
            background: var(--gray-100);
            margin: 0 0.5rem;
        }

        /* Custom Checkbox */
        .custom-checkbox {
            position: relative;
            width: 20px;
            height: 20px;
        }

        .custom-checkbox input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .custom-checkbox label {
            position: absolute;
            top: 0;
            left: 0;
            width: 20px;
            height: 20px;
            background: #fff;
            border: 2px solid var(--gray-100);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-checkbox input:checked + label {
            background: var(--primary-green);
            border-color: var(--primary-green);
        }

        .custom-checkbox input:checked + label:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid var(--gray-100);
            background: #fff;
        }

        .btn-action.view { color: var(--primary-green); }
        .btn-action.view:hover { background: var(--light-green); border-color: var(--primary-green); }
        .btn-action.chat:hover { background: #e7f3ff; border-color: #0d6efd; }

        .pagination-wrap {
            padding: 1.5rem;
            background: #fff;
            border-top: 1px solid var(--gray-50);
        }

        /* Stats Grid Styles */
        .averages-grid { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 0.5rem; 
            width: 100%; 
            margin-top: 0.25rem; 
        }
        .avg-item { 
            text-align: center; 
            background: var(--bg-light); 
            padding: 0.4rem; 
            border-radius: 8px; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .avg-label { 
            font-size: 0.7rem; 
            color: var(--text-light); 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
            font-weight: 700;
            line-height: 1;
        }
        .avg-val { 
            font-size: 1.1rem; 
            font-weight: 800; 
            line-height: 1; 
            margin-bottom: 4px;
        }

        /* Dashboard Stat Card */
        .dashboard-stat-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.primary { background: var(--light-green); color: var(--forest-green); }
        .stat-icon.info { background: #e0f7fa; color: #00acc1; }
        .stat-icon.warning { background: #fff8e1; color: #ffc107; }

        .stat-content { flex-grow: 1; min-width: 0; }
        .stat-label { font-size: 0.85rem; color: var(--text-light); font-weight: 600; margin-bottom: 0.25rem; }
        .stat-value { font-size: 1.75rem; font-weight: 800; color: var(--text-dark); line-height: 1.2; }
        .stat-hint { font-size: 0.75rem; color: #9aa0ac; margin-top: 0.25rem; }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none" 
                style="position: fixed; top: 10px; left: 10px; z-index: 1050; border: none; background: var(--forest-green); color: white; padding: 5px 10px; border-radius: 5px;">
                <i class="bi bi-list"></i>
            </button>
            
            <!-- Sidebar -->
            <?php echo $__env->make('counselor.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <!-- Header -->
                    <div class="welcome-card mb-4" style="min-height: auto; padding: 1.5rem;">
                        <div>
                            <div class="welcome-text" style="font-size: 1.5rem;">Students Directory</div>
                            <div style="font-size: 0.9rem; margin-top: 0.25rem; opacity: 0.9;">
                                View and manage all student profiles across the university.
                            </div>
                        </div>
                        <div class="d-none d-md-block" style="font-size: 2rem; opacity: 0.8;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="dashboard-stat-card">
                                <div class="stat-icon primary"><i class="bi bi-people"></i></div>
                                <div class="stat-content">
                                    <div class="stat-label">Total Students</div>
                                    <div class="stat-value"><?php echo e(number_format($totalStudents)); ?></div>
                                    <div class="stat-hint">Registered students</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="dashboard-stat-card ps-3 pe-3">
                                <div class="stat-content">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="stat-label mb-0">Year Distribution</div>
                                        <div class="stat-icon info" style="width: 32px; height: 32px; font-size: 1rem;"><i class="bi bi-mortarboard"></i></div>
                                    </div>
                                    <div class="averages-grid" style="grid-template-columns: repeat(4, 1fr);">
                                        <?php $__currentLoopData = [1, 2, 3, 4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="avg-item">
                                                <div class="avg-val" style="font-size: 1.1rem; color: var(--forest-green);"><?php echo e($yearStats[$yl] ?? 0); ?></div>
                                                <div class="avg-label"><?php echo e($yl); ?></div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="dashboard-stat-card ps-3 pe-3">
                                <div class="stat-content">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="stat-label mb-0">Sex Ratio</div>
                                        <div class="stat-icon warning" style="width: 32px; height: 32px; font-size: 1rem;"><i class="bi bi-gender-ambiguous"></i></div>
                                    </div>
                                    <div class="averages-grid">
                                        <div class="avg-item">
                                            <div class="avg-val" style="color: #0d6efd;"><?php echo e($sexStats['male'] ?? 0); ?></div>
                                            <div class="avg-label">Male</div>
                                        </div>
                                        <div class="avg-item">
                                            <div class="avg-val" style="color: #d63384;"><?php echo e($sexStats['female'] ?? 0); ?></div>
                                            <div class="avg-label">Female</div>
                                        </div>
                                        <?php $otherTotal = ($sexStats['other'] ?? 0) + ($sexStats['non-binary'] ?? 0) + ($sexStats['prefer_not_to_say'] ?? 0); ?>
                                        <div class="avg-item">
                                            <div class="avg-val" style="color: #6c757d;"><?php echo e($otherTotal); ?></div>
                                            <div class="avg-label">Other</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Bar -->
                    <div class="main-content-card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-body p-3">
                            <form action="<?php echo e(route('counselor.students.index')); ?>" method="GET" class="row g-2">
                                <div class="col-md-3">
                                    <div class="search-box position-relative">
                                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                        <input type="text" name="search" class="filter-control ps-5" 
                                            placeholder="Search name, ID, or email..." value="<?php echo e(request('search')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select name="college" class="filter-select w-100">
                                        <option value="">All Colleges</option>
                                        <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($college); ?>" <?php echo e(request('college') == $college ? 'selected' : ''); ?>><?php echo e($college); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="year_level" class="filter-select w-100">
                                        <option value="">Year Levels</option>
                                        <?php $__currentLoopData = $yearLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($yl); ?>" <?php echo e(request('year_level') == $yl ? 'selected' : ''); ?>><?php echo e($yl); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="sex" class="filter-select w-100">
                                        <option value="">All Sexes</option>
                                        <option value="male" <?php echo e(request('sex') == 'male' ? 'selected' : ''); ?>>Male</option>
                                        <option value="female" <?php echo e(request('sex') == 'female' ? 'selected' : ''); ?>>Female</option>
                                        <option value="other" <?php echo e(request('sex') == 'other' ? 'selected' : ''); ?>>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <select name="per_page" class="filter-select w-100 ps-2 pe-4">
                                        <?php $__currentLoopData = [10, 20, 30, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($count); ?>" <?php echo e(request('per_page') == $count ? 'selected' : ''); ?>><?php echo e($count); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn-filter flex-grow-1">
                                        <i class="bi bi-funnel-fill me-2"></i>Filter
                                    </button>
                                    <a href="<?php echo e(route('counselor.students.index')); ?>" class="btn-reset">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Bulk Actions Bar -->
                    <div id="bulkBar" class="bulk-actions-bar shadow-lg">
                        <div class="container-fluid d-flex align-items-center justify-content-between px-4">
                            <div class="d-flex align-items-center gap-3">
                                <span class="selected-badge"><span id="selectedCount">0</span> selected</span>
                                <div class="v-divider"></div>
                                <button type="button" id="bulkMessageBtn" class="bulk-btn" style="background: var(--light-green); color: var(--forest-green);">
                                    <i class="bi bi-chat-dots-fill me-2"></i>Bulk Message
                                </button>
                                <button type="button" id="bulkExportBtn" class="bulk-btn bulk-btn-delete">
                                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Export Selected
                                </button>
                            </div>
                            <button type="button" id="closeBulkBar" class="btn-close-bulk">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <form id="bulk-action-form" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                        <div id="bulk-ids-container"></div>
                    </form>

                    <!-- Students Table Card -->
                    <div class="main-content-card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4 py-3" style="width: 40px;">
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="selectAll">
                                                    <label for="selectAll"></label>
                                                </div>
                                            </th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold" style="letter-spacing: 0.5px;">Student Info</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold" style="letter-spacing: 0.5px;">College & Level</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold" style="letter-spacing: 0.5px; width: 120px;">Sessions</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold" style="letter-spacing: 0.5px; width: 120px;">Risk Level</th>
                                            <th class="pe-4 py-3 text-end text-secondary text-uppercase small font-weight-bold" style="letter-spacing: 0.5px; width: 120px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php
                                                $latestAssessment = $student->assessments->first();
                                                $riskLevel = $latestAssessment ? ($latestAssessment->risk_level ?? 'normal') : 'none';
                                                $totalApps = \App\Models\Appointment::where('student_id', $student->id)->where('counselor_id', auth()->id())->count();
                                                $completedApps = \App\Models\Appointment::where('student_id', $student->id)->where('counselor_id', auth()->id())->where('status', 'completed')->count();
                                            ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="custom-checkbox">
                                                        <input type="checkbox" class="item-checkbox" id="check-<?php echo e($student->id); ?>" value="<?php echo e($student->id); ?>">
                                                        <label for="check-<?php echo e($student->id); ?>"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?php echo e($student->avatar_url); ?>" class="user-avatar" alt="">
                                                        <div class="user-details">
                                                            <h6><?php echo e($student->name); ?></h6>
                                                            <span><?php echo e($student->student_id ?? 'No ID'); ?> • <?php echo e($student->email); ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bold text-dark" style="font-size: 0.85rem;"><?php echo e($student->college ?? 'No College'); ?></span>
                                                        <span class="text-muted small"><?php echo e($student->year_level ?? 'Unspecified'); ?> Level</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="text-center px-2 py-1 bg-light rounded" title="Total Sessions">
                                                            <div class="fw-bold text-dark lh-1"><?php echo e($totalApps); ?></div>
                                                            <div class="text-muted" style="font-size: 0.6rem;">TOTAL</div>
                                                        </div>
                                                        <div class="text-center px-2 py-1 rounded" style="background: var(--light-green);" title="Completed Sessions">
                                                            <div class="fw-bold text-success lh-1"><?php echo e($completedApps); ?></div>
                                                            <div class="text-muted" style="font-size: 0.6rem;">DONE</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if($riskLevel == 'high'): ?>
                                                        <span class="badge-risk high">High Risk</span>
                                                    <?php elseif($riskLevel == 'moderate'): ?>
                                                        <span class="badge-risk moderate">Moderate</span>
                                                    <?php elseif($riskLevel == 'normal' || $riskLevel == 'low'): ?>
                                                        <span class="badge-risk normal"><?php echo e(ucfirst($riskLevel)); ?></span>
                                                    <?php else: ?>
                                                        <span class="badge-risk text-muted bg-light border-0">No Data</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="pe-4 text-end">
                                                    <div class="actions-cell justify-content-end">
                                                        <a href="<?php echo e(route('counselor.students.show', $student->id)); ?>" 
                                                            class="btn-action view" title="View Profile">
                                                            <i class="bi bi-person-badge-fill"></i>
                                                        </a>
                                                        <a href="<?php echo e(route('chat.index', $student->id)); ?>" 
                                                            class="btn-action chat" style="color: #0d6efd;" title="Chat">
                                                            <i class="bi bi-chat-dots-fill"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <div class="empty-state">
                                                        <i class="bi bi-people"></i>
                                                        <h5 class="mb-2 fw-bold">No Students Found</h5>
                                                        <p class="mb-0 text-muted">Try adjusting your filters or search terms.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="pagination-wrap">
                                <?php echo e($students->links('vendor.pagination.premium')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle logic
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

            // Bulk actions logic
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const bulkBar = document.getElementById('bulkBar');
            const selectedCountSpan = document.getElementById('selectedCount');
            const closeBulkBar = document.getElementById('closeBulkBar');

            function updateBulkBar() {
                const checked = document.querySelectorAll('.item-checkbox:checked');
                selectedCountSpan.textContent = checked.length;
                if (checked.length > 0) {
                    bulkBar.classList.add('active');
                } else {
                    bulkBar.classList.remove('active');
                    if (selectAll) selectAll.checked = false;
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateBulkBar();
                });
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateBulkBar));

            if (closeBulkBar) {
                closeBulkBar.addEventListener('click', () => {
                    checkboxes.forEach(cb => cb.checked = false);
                    if (selectAll) selectAll.checked = false;
                    updateBulkBar();
                });
            }

            // Bulk Message Event
            const bulkMessageBtn = document.getElementById('bulkMessageBtn');
            const bulkExportBtn = document.getElementById('bulkExportBtn');
            const bulkActionForm = document.getElementById('bulk-action-form');
            const bulkIdsContainer = document.getElementById('bulk-ids-container');

            if (bulkMessageBtn) {
                bulkMessageBtn.addEventListener('click', async () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    const { value: text } = await Swal.fire({
                        title: 'Send Bulk Message',
                        input: 'textarea',
                        inputLabel: `Sending message to ${ids.length} students`,
                        inputPlaceholder: 'Type your message here...',
                        inputAttributes: {
                            'aria-label': 'Type your message here'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Send Message',
                        confirmButtonColor: '#1f7a2d',
                    });

                    if (text) {
                        bulkActionForm.action = "<?php echo e(route('counselor.students.bulkMessage')); ?>";
                        bulkIdsContainer.innerHTML = '';
                        ids.forEach(id => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = id;
                            bulkIdsContainer.appendChild(input);
                        });
                        const msgInput = document.createElement('input');
                        msgInput.type = 'hidden';
                        msgInput.name = 'message';
                        msgInput.value = text;
                        bulkIdsContainer.appendChild(msgInput);
                        bulkActionForm.submit();
                    }
                });
            }

            if (bulkExportBtn) {
                bulkExportBtn.addEventListener('click', () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    bulkActionForm.action = "<?php echo e(route('counselor.students.bulkExport')); ?>";
                    bulkIdsContainer.innerHTML = '';
                    ids.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        bulkIdsContainer.appendChild(input);
                    });
                    bulkActionForm.submit();
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/students/index.blade.php ENDPATH**/ ?>