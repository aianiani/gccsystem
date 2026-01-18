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

        .main-content-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .main-content-card .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .main-content-card .card-body {
            padding: 1.25rem;
        }

        .dashboard-stat-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-lighter);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .stat-icon.primary { background: var(--light-green); color: var(--forest-green); }
        .stat-icon.info { background: #e0f7fa; color: #00acc1; }

        .stat-content { flex-grow: 1; min-width: 0; }
        .stat-label { font-size: 0.9rem; color: var(--text-light); font-weight: 500; margin-bottom: 0.25rem; }
        .stat-value { font-size: 1.85rem; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
        .stat-hint { font-size: 0.8rem; color: #9aa0ac; margin-top: 0.25rem; }

        .averages-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem; width: 100%; margin-top: 0.25rem; }
        .avg-item { text-align: center; background: var(--bg-light); padding: 0.4rem; border-radius: 8px; }
        .avg-label { font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;}
        .avg-val { font-size: 1.15rem; font-weight: 700; line-height: 1; margin-bottom: 2px;}
        .avg-val.dep { color: #0d6efd; }
        .avg-val.anx { color: #0dcaf0; }
        .avg-val.str { color: #6c757d; }

        /* Risk indicator dots and legend */
        .risk-dot {
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            border: 2px solid #fff;
        }

        .risk-dot.low {
            background: #4caf50;
        }

        .risk-dot.low-moderate {
            background: #ffb300;
        }

        .risk-dot.moderate {
            background: #f39c12;
        }

        .risk-dot.high {
            background: #e74c3c;
        }

        .risk-dot.very-high {
            background: #8b1e3f;
        }

        .risk-legend {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .risk-legend .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            color: var(--text-dark);
        }

        .risk-legend .legend-item .pill {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        .risk-legend .legend-item .pill.low {
            background: #4caf50;
        }

        .risk-legend .legend-item .pill.low-moderate {
            background: #ffb300;
        }

        .risk-legend .legend-item .pill.moderate {
            background: #f39c12;
        }

        .risk-legend .legend-item .pill.high {
            background: #e74c3c;
        }

        .risk-legend .legend-item .pill.very-high {
            background: #8b1e3f;
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info,
        .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17, 94, 37, 0.06);
        }

        .btn-outline-primary {
            border-color: var(--forest-green);
            color: var(--forest-green);
        }

        .btn-outline-primary:hover {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        /* Filter action buttons sizing and alignment */
        .filter-actions {
            align-items: center;
            justify-content: flex-end;
            /* Nudge the action buttons slightly upward to match input baseline */
            transform: translateY(-6px);
        }

        .filter-actions .btn {
            height: 44px;
            padding: 0.45rem 0.9rem;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }

        .filter-actions .btn i {
            margin-right: 6px;
        }

        /* Reset button: compact circular style that lines up with inputs */
        .filter-actions .btn-reset {
            padding: 0.35rem 0.45rem;
            width: 44px;
            min-width: 44px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Filter button slightly more prominent */
        .filter-actions .btn-filter {
            padding-left: 0.85rem;
            padding-right: 0.85rem;
        }

        @media (max-width: 576px) {
            .filter-actions .btn {
                height: 40px;
                padding: 0.35rem 0.6rem;
                font-size: 0.95rem;
            }

            .filter-actions .btn-reset {
                width: 40px;
                min-width: 40px;
            }
        }

        /* Make filter inputs align with filter buttons by matching heights in this form */
        .main-content-card .card-body>form .form-control,
        .main-content-card .card-body>form .form-select {
            height: 44px;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0;
            }
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
                    <div class="welcome-card">
                        <div>
                            <div class="welcome-date"><?php echo e(now()->format('F j, Y')); ?></div>
                            <div class="welcome-text">Assessment Results</div>
                            <div style="font-size: 0.9rem; margin-top: 0.5rem;">View and analyze student assessment data
                            </div>
                        </div>
                        <div class="welcome-avatar">
                            <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="<?php echo e(auth()->user()->name); ?>"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        </div>
                    </div>

                    <?php
                        $total = $assessments->total();
                        // new detailed risk categories
                        $low = $assessments->where('risk_level', 'low')->count() + $assessments->where('risk_level', 'normal')->count(); // include legacy 'normal'
                        $lowModerate = $assessments->where('risk_level', 'low-moderate')->count();
                        $moderate = $assessments->where('risk_level', 'moderate')->count();
                        $high = $assessments->where('risk_level', 'high')->count();
                        $veryHigh = $assessments->where('risk_level', 'very-high')->count();
                        $dassAssessments = $assessments->where('type', 'DASS-42');
                        // Compute averages from computed per-item totals to avoid mismatch
                        $avgDepression = 0;
                        $avgAnxiety = 0;
                        $avgStress = 0;
                        if ($dassAssessments->count()) {
                            $depSum = 0;
                            $anxSum = 0;
                            $strSum = 0;
                            $count = 0;
                            foreach ($dassAssessments as $a) {
                                $raw = is_array($a->score) ? $a->score : json_decode($a->score, true);
                                $studentAnswers = [];
                                if (!empty($raw) && is_array($raw)) {
                                    foreach ($raw as $k => $v) {
                                        if (is_numeric($k)) {
                                            $ik = (int) $k;
                                            if ($ik >= 0 && $ik <= 41) {
                                                $studentAnswers[$ik + 1] = (int) $v;
                                                continue;
                                            }
                                        }
                                        $studentAnswers[$k] = $v;
                                    }
                                }
                                $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
                                $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
                                $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];
                                $dT = 0;
                                $aT = 0;
                                $sT = 0;
                                foreach ($depressionItems as $it) {
                                    $dT += (int) ($studentAnswers[$it] ?? 0);
                                }
                                foreach ($anxietyItems as $it) {
                                    $aT += (int) ($studentAnswers[$it] ?? 0);
                                }
                                foreach ($stressItems as $it) {
                                    $sT += (int) ($studentAnswers[$it] ?? 0);
                                }
                                $depSum += $dT;
                                $anxSum += $aT;
                                $strSum += $sT;
                                $count++;
                            }
                            $avgDepression = $count ? $depSum / $count : 0;
                            $avgAnxiety = $count ? $anxSum / $count : 0;
                            $avgStress = $count ? $strSum / $count : 0;
                        }
                        $avgOverall = ($avgDepression + $avgAnxiety + $avgStress) / 3;
                    ?>

                    <!-- Compact Hero / Summary Cards (reduced) -->
                    <div class="row g-3 mb-4 hero-cards">
                        <!-- Total Assessments -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="dashboard-stat-card">
                                <div class="stat-icon primary">
                                    <i class="bi bi-journal-check"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Total Assessments</div>
                                    <div class="stat-value"><?php echo e(number_format($total)); ?></div>
                                    <div class="stat-hint">All types included</div>
                                </div>
                            </div>
                        </div>

                        <!-- DASS-42 Count -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="dashboard-stat-card">
                                <div class="stat-icon info">
                                    <i class="bi bi-clipboard-data"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">DASS-42 Count</div>
                                    <div class="stat-value"><?php echo e(number_format($dassAssessments->count())); ?></div>
                                    <div class="stat-hint">Completed DASS-42</div>
                                </div>
                            </div>
                        </div>

                        <!-- Average Scores breakdown -->
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="dashboard-stat-card ps-3 pe-3">
                                <div class="stat-content">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="stat-label mb-0">Average Scores</div>
                                        <span class="badge bg-white text-dark border">DASS-42</span>
                                    </div>
                                    <div class="averages-grid">
                                        <div class="avg-item" title="Depression">
                                            <div class="avg-val dep"><?php echo e(number_format($avgDepression, 1)); ?></div>
                                            <div class="avg-label">Dep</div>
                                        </div>
                                        <div class="avg-item" title="Anxiety">
                                            <div class="avg-val anx"><?php echo e(number_format($avgAnxiety, 1)); ?></div>
                                            <div class="avg-label">Anx</div>
                                        </div>
                                        <div class="avg-item" title="Stress">
                                            <div class="avg-val str"><?php echo e(number_format($avgStress, 1)); ?></div>
                                            <div class="avg-label">Str</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="main-content-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Assessment Results</h5>
                        </div>
                        <div class="card-body">
                            
                            <form method="GET" class="mb-3">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-2">
                                <label class="form-label mb-1">Assessment Type</label>
                                <select name="type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="DASS-42" <?php if(request('type')=='DASS-42'): ?> selected <?php endif; ?>>DASS-42</option>
                                    <option value="GRIT Scale" <?php if(request('type')=='GRIT Scale'): ?> selected <?php endif; ?>>GRIT Scale</option>
                                    <option value="NEO-PI-R" <?php if(request('type')=='NEO-PI-R'): ?> selected <?php endif; ?>>NEO-PI-R</option>
                                    <option value="Work Values Inventory" <?php if(request('type')=='Work Values Inventory'): ?> selected <?php endif; ?>>Work Values Inventory</option>
                                </select>
                            </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">College</label>
                                        <select name="college" class="form-select">
                                            <option value="">All Colleges</option>
                                            <?php
                                                $colleges = [
                                                    'College of Arts and Sciences',
                                                    'College of Veterinary Medicine',
                                                    'College of Forestry and Environmental Sciences',
                                                    'College of Business and Management',
                                                    'College of Nursing',
                                                    'College of Human Ecology',
                                                    'College of Agriculture',
                                                    'College of Information Science and Computing',
                                                    'College of Education',
                                                    'College of Engineering'
                                                ];
                                            ?>
                                            <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($col); ?>" <?php if(request('college')==$col): ?> selected <?php endif; ?>><?php echo e($col); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">Year Level</label>
                                        <select name="year" class="form-select">
                                            <option value="">All Years</option>
                                            <option value="1st Year" <?php if(request('year') == '1st Year'): ?> selected <?php endif; ?>>1st
                                                Year</option>
                                            <option value="2nd Year" <?php if(request('year') == '2nd Year'): ?> selected <?php endif; ?>>2nd
                                                Year</option>
                                            <option value="3rd Year" <?php if(request('year') == '3rd Year'): ?> selected <?php endif; ?>>3rd
                                                Year</option>
                                            <option value="4th Year" <?php if(request('year') == '4th Year'): ?> selected <?php endif; ?>>4th
                                                Year</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="">All</option>
                                            <option value="Male" <?php if(request('gender') == 'Male'): ?> selected <?php endif; ?>>Male
                                            </option>
                                            <option value="Female" <?php if(request('gender') == 'Female'): ?> selected <?php endif; ?>>Female
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">Date From</label>
                                        <input type="date" name="date_from" class="form-control"
                                            value="<?php echo e(request('date_from')); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">Date To</label>
                                        <input type="date" name="date_to" class="form-control"
                                            value="<?php echo e(request('date_to')); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label mb-1">Student Name/Email</label>
                                        <input type="text" name="student" class="form-control"
                                            value="<?php echo e(request('student')); ?>" placeholder="Search...">
                                    </div>
                                    <div class="col-md-1 d-flex gap-2 filter-actions align-items-end">
                                        <button type="submit" class="btn btn-primary btn-filter" title="Filter"><i
                                                class="bi bi-funnel"></i></button>
                                        <a href="<?php echo e(route('counselor.assessments.index')); ?>"
                                            class="btn btn-outline-secondary btn-reset" title="Reset filters"><i
                                                class="bi bi-arrow-counterclockwise"></i></a>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 w-100" id="assessments-table">
                                    <colgroup>
                                        <col style="width:10%;" />
                                        <col style="width:15%;" />
                                        <col style="width:15%;" />
                                        <col style="width:20%;" />
                                        <col style="width:10%;" />
                                        <col style="width:10%;" />
                                        <col style="width:10%;" />
                                        <col style="width:10%;" />
                                    </colgroup>
                                    <thead class="table-light sticky-top" style="z-index:1;">
                                        <tr>
                                            <th class="text-center" style="width: 120px;">Type</th>
                                            <th class="text-center" style="width: 170px; white-space:nowrap;">Date</th>
                                            <th class="text-start" style="min-width: 160px;">Student</th>
                                            <th class="text-start" style="min-width: 200px; max-width: 260px;">Email</th>
                                            <th class="text-end" style="width: 110px;">Depression</th>
                                            <th class="text-end" style="width: 110px;">Anxiety</th>
                                            <th class="text-end" style="width: 110px;">Stress</th>
                                            <!-- Total Score column removed -->
                                            <th class="text-center" style="width: 120px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php
                                                // Normalize stored score payload (could be JSON string) and compute
                                                // subscale totals from per-item answers to ensure consistency.
                                                $rawScore = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true);
                                                $studentAnswers = [];
                                                if (!empty($rawScore) && is_array($rawScore)) {
                                                    foreach ($rawScore as $k => $v) {
                                                        if (is_numeric($k)) {
                                                            $ik = (int) $k;
                                                            if ($ik >= 0 && $ik <= 41) {
                                                                $studentAnswers[$ik + 1] = (int) $v;
                                                                continue;
                                                            }
                                                        }
                                                        $studentAnswers[$k] = $v;
                                                    }
                                                }
                                                // DASS groups (1-indexed)
                                                $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
                                                $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
                                                $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];
                                                $depTotal = 0;
                                                $anxTotal = 0;
                                                $strTotal = 0;
                                                foreach ($depressionItems as $it) {
                                                    $depTotal += (int) ($studentAnswers[$it] ?? 0);
                                                }
                                                foreach ($anxietyItems as $it) {
                                                    $anxTotal += (int) ($studentAnswers[$it] ?? 0);
                                                }
                                                foreach ($stressItems as $it) {
                                                    $strTotal += (int) ($studentAnswers[$it] ?? 0);
                                                }
                                                $scores = $rawScore;
                                            ?>
                                            <tr class="align-middle">
                                                <td class="text-center align-middle"><span
                                                        class="badge rounded-pill bg-light text-dark border border-1"><?php echo e($assessment->type); ?></span>
                                                </td>
                                                <td class="text-center align-middle" style="white-space:nowrap;">
                                                    <?php echo e($assessment->created_at->format('M d, Y h:i A')); ?></td>
                                                <td class="text-start align-middle">
                                                    <?php echo e($assessment->user->name ?? 'N/A'); ?>

                                                </td>
                                                <td class="text-start align-middle"
                                                    style="max-width: 240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"
                                                    title="<?php echo e($assessment->user->email ?? 'N/A'); ?>">
                                                    <?php echo e($assessment->user->email ?? 'N/A'); ?></td>
                                                <!-- Risk indicator removed -->
                                                <?php if($assessment->type === 'DASS-42'): ?>
                                                    <td class="text-end align-middle"><span
                                                            class="badge bg-primary"><?php echo e($depTotal ?? ($scores['depression'] ?? '-')); ?></span>
                                                    </td>
                                                    <td class="text-end align-middle"><span
                                                            class="badge bg-info text-dark"><?php echo e($anxTotal ?? ($scores['anxiety'] ?? '-')); ?></span>
                                                    </td>
                                                    <td class="text-end align-middle"><span
                                                            class="badge bg-secondary"><?php echo e($strTotal ?? ($scores['stress'] ?? '-')); ?></span>
                                                    </td>
                                                <?php else: ?>
                                                    <td class="text-end align-middle"><span class="badge bg-primary">-</span></td>
                                                    <td class="text-end align-middle"><span class="badge bg-info text-dark">-</span>
                                                    </td>
                                                    <td class="text-end align-middle"><span class="badge bg-secondary">-</span></td>
                                                <?php endif; ?>
                                                <td class="text-center align-middle">
                                                    <a href="<?php echo e(route('counselor.assessments.show', $assessment->id)); ?>"
                                                        class="btn btn-outline-info btn-sm"
                                                        style="white-space:nowrap; min-width:80px;">
                                                        <i class="bi bi-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">No assessment results found.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                <?php echo e($assessments->links('vendor.pagination.bootstrap-5')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
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
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
    <!-- Render all modals after the table -->
    <?php $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $scores = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true); ?>
        <!-- View Summary Modal -->
        <div class="modal fade" id="summaryModal-<?php echo e($assessment->id); ?>" tabindex="-1"
            aria-labelledby="summaryModalLabel-<?php echo e($assessment->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="summaryModalLabel-<?php echo e($assessment->id); ?>">Assessment Summary</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo $__env->make('counselor.assessments.partials.summary', ['assessment' => $assessment, 'scores' => $scores], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    </div>
    </div>

    </div>
    <style>
        .sticky-top {
            position: sticky !important;
            top: 0;
            background: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background: #f4f8fb !important;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
        }

        /* Improved table responsiveness and alignment */
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            table-layout: fixed;
        }

        /* Prevent header/body misalignment by constraining cell overflow */
        .table th,
        .table td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Allow wrapping for long student names on small screens */
        @media (max-width: 768px) {

            #assessments-table th:nth-child(3),
            #assessments-table td:nth-child(3) {
                white-space: normal;
            }

            #assessments-table th:nth-child(4),
            #assessments-table td:nth-child(4) {
                white-space: nowrap;
                max-width: 180px;
            }
        }

        .table td.text-center.align-middle,
        .table th.text-center {
            text-align: center;
        }

        @media (max-width: 900px) {

            .table th,
            .table td {
                font-size: 0.95rem;
                padding: 0.5rem 0.3rem;
            }

            .table th:nth-child(4),
            .table td:nth-child(4) {
                max-width: 120px;
            }
        }

        @media (max-width: 600px) {

            .table th,
            .table td {
                font-size: 0.90rem;
                padding: 0.4rem 0.2rem;
            }

            .table th:nth-child(4),
            .table td:nth-child(4) {
                max-width: 80px;
            }
        }

        .ai-highlight {
            box-shadow: 0 0 0 4px #0dcaf0;
            background: #e0f7fa;
            transition: box-shadow 0.3s, background 0.3s;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/assessments/index.blade.php ENDPATH**/ ?>