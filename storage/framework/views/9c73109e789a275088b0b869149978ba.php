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

        /* Apply page zoom - CRITICAL */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top left;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
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
            padding: 1.5rem 2rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 1400px;
            margin: 0 auto;
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem;
            }
        }

        /* Page Header */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            background: var(--hero-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.primary {
            background: var(--light-green);
            color: var(--primary-green);
        }

        .stat-icon.warning {
            background: #fff8e1;
            color: #f57f17;
        }

        .stat-icon.info {
            background: #e0f2fe;
            color: #0284c7;
        }

        .stat-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-dark);
        }

        .stat-info p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Filter Bar */
        .filter-bar {
            background: #fff;
            padding: 1.25rem;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
            align-items: end;
        }

        .filter-input-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .filter-input-group label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            height: 38px;
            width: 100%;
            background: #fff;
        }

        .btn-filter-submit {
            background: var(--primary-green);
            color: #fff;
            border: none;
            border-radius: 8px;
            height: 38px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .btn-filter-submit:hover {
            background: var(--primary-green-2);
            color: #fff;
        }

        .btn-reset-filter {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            height: 38px;
            width: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-reset-filter:hover {
            background: #e2e8f0;
            color: var(--text-dark);
        }

        /* Content Card & Table */
        .content-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
            position: relative;
        }

        .bulk-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 54px;
            background: var(--primary-green);
            color: #fff;
            display: none;
            align-items: center;
            padding: 0 1.25rem;
            z-index: 10;
            gap: 1rem;
        }

        .bulk-bar.active {
            display: flex;
        }

        .bulk-bar .count {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .bulk-bar .btn-bulk {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: background 0.2s;
        }

        .bulk-bar .btn-bulk:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .premium-table {
            width: 100%;
            border-collapse: collapse;
        }

        .premium-table thead th {
            background: #f8fafc;
            padding: 0.9rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }

        .premium-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }

        .premium-table tbody tr:hover {
            background: #fcfcfd;
        }

        /* User Info Cell */
        .user-info-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .user-details h6 {
            margin: 0;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .user-details span {
            font-size: 0.8rem;
            color: #64748b;
            display: block;
        }

        /* Status & Score Badges */
        .type-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid #e2e8f0;
        }

        .score-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-right: 0.25rem;
        }

        .score-dep {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .score-anx {
            background: #ecfdf5;
            color: #047857;
        }

        .score-str {
            background: #fef2f2;
            color: #b91c1c;
        }

        /* Actions */
        .actions-cell {
            display: flex;
            gap: 0.4rem;
            justify-content: flex-end;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.2s;
            background: transparent;
            border: none;
        }

        .btn-action:hover {
            background: #f1f5f9;
            color: var(--primary-green);
        }

        .btn-action.view:hover {
            color: #0284c7;
            background: #e0f2fe;
        }

        .btn-action.delete:hover {
            color: #dc2626;
            background: #fee2e2;
        }

        /* Pagination */
        .pagination-wrap {
            padding: 1rem 1.25rem;
            border-top: 1px solid #f1f5f9;
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Sidebar -->
            <?php echo $__env->make('counselor.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">

                    <?php
                        $total = $assessments->total();
                        $dassAssessments = $assessments->where('type', 'DASS-42');

                        // Compute aggregates
                        $depSum = 0;
                        $anxSum = 0;
                        $strSum = 0;
                        $count = 0;
                        foreach ($dassAssessments as $a) {
                            $raw = is_array($a->score) ? $a->score : json_decode($a->score, true);
                            if (!empty($raw) && is_array($raw)) {
                                $depSum += $raw['depression'] ?? 0;
                                $anxSum += $raw['anxiety'] ?? 0;
                                $strSum += $raw['stress'] ?? 0;
                                $count++;
                            }
                        }
                        $avgDep = $count ? $depSum / $count : 0;
                        $avgAnx = $count ? $anxSum / $count : 0;
                        $avgStr = $count ? $strSum / $count : 0;
                    ?>

                    <!-- Page Header -->
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">Assessments</h1>
                            <p class="text-muted mb-0 mt-1">Review student mental health and personality reports</p>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="stats-row">
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="bi bi-clipboard2-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo e(number_format($total)); ?></h3>
                                <p>Total Assessments</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon info">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo e(number_format($count)); ?></h3>
                                <p>DASS-42 Submissions</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="stat-info">
                                <h3 style="font-size: 1.2rem; line-height: 1.2;">
                                    <span class="text-primary"><?php echo e(number_format($avgDep, 1)); ?></span> /
                                    <span class="text-success"><?php echo e(number_format($avgAnx, 1)); ?></span> /
                                    <span class="text-danger"><?php echo e(number_format($avgStr, 1)); ?></span>
                                </h3>
                                <p>Avg. DASS Scores (D/A/S)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Bar -->
                    <div class="filter-bar">
                        <form method="GET" action="<?php echo e(route('counselor.assessments.index')); ?>">
                            <div class="filter-row">
                                <div class="filter-input-group" style="grid-column: span 2;">
                                    <label>Search Student</label>
                                    <input type="text" name="student" class="filter-control" placeholder="Name or email..."
                                        value="<?php echo e(request('student')); ?>">
                                </div>

                                <div class="filter-input-group">
                                    <label>Type</label>
                                    <select name="type" class="filter-control">
                                        <option value="">All Types</option>
                                        <option value="DASS-42" <?php echo e(request('type') == 'DASS-42' ? 'selected' : ''); ?>>DASS-42
                                        </option>
                                        <option value="GRIT Scale" <?php echo e(request('type') == 'GRIT Scale' ? 'selected' : ''); ?>>
                                            GRIT Scale</option>
                                        <option value="Personality (NEO-FFI)" <?php echo e(request('type') == 'Personality (NEO-FFI)' ? 'selected' : ''); ?>>NEO-FFI</option>
                                        <option value="Work Values Inventory" <?php echo e(request('type') == 'Work Values Inventory' ? 'selected' : ''); ?>>WVI</option>
                                    </select>
                                </div>

                                <div class="filter-input-group">
                                    <label>College</label>
                                    <select name="college" class="filter-control">
                                        <option value="">All Colleges</option>
                                        <?php $colleges = ['CAS', 'CVM', 'CFES', 'CBM', 'CON', 'CHE', 'CA', 'CISC', 'CED', 'COE']; ?>
                                        <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($col); ?>" <?php echo e(request('college') == $col ? 'selected' : ''); ?>>
                                                <?php echo e($col); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="filter-input-group">
                                    <label>Year</label>
                                    <select name="year" class="filter-control">
                                        <option value="">All Years</option>
                                        <?php $__currentLoopData = ['1st', '2nd', '3rd', '4th']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($y); ?> Year" <?php echo e(request('year') == "$y Year" ? 'selected' : ''); ?>>
                                                <?php echo e($y); ?> Year
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="filter-input-group">
                                    <label>Sort By</label>
                                    <select name="sort_by" class="filter-select">
                                        <option value="newest" <?php echo e(request('sort_by') == 'newest' ? 'selected' : ''); ?>>Newest
                                            First</option>
                                        <option value="oldest" <?php echo e(request('sort_by') == 'oldest' ? 'selected' : ''); ?>>Oldest
                                            First</option>
                                        <option value="name_az" <?php echo e(request('sort_by') == 'name_az' ? 'selected' : ''); ?>>Name
                                            A-Z</option>
                                        <option value="name_za" <?php echo e(request('sort_by') == 'name_za' ? 'selected' : ''); ?>>Name
                                            Z-A</option>
                                    </select>
                                </div>

                                <div class="filter-input-group">
                                    <label>Per Page</label>
                                    <select name="per_page" class="filter-select" style="min-width: 100px;">
                                        <option value="10" <?php echo e(request('per_page', 10) == '10' ? 'selected' : ''); ?>>10 Per Page
                                        </option>
                                        <option value="20" <?php echo e(request('per_page') == '20' ? 'selected' : ''); ?>>20 Per Page
                                        </option>
                                        <option value="30" <?php echo e(request('per_page') == '30' ? 'selected' : ''); ?>>30 Per Page
                                        </option>
                                        <option value="50" <?php echo e(request('per_page') == '50' ? 'selected' : ''); ?>>50 Per Page
                                        </option>
                                        <option value="100" <?php echo e(request('per_page') == '100' ? 'selected' : ''); ?>>100 Per Page
                                        </option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-filter-submit px-4 flex-grow-1">
                                        <i class="bi bi-funnel"></i> Filter
                                    </button>
                                    <a href="<?php echo e(route('counselor.assessments.index')); ?>" class="btn-reset-filter"
                                        title="Reset">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Content Card -->
                    <div class="content-card">
                        <!-- Bulk Overlay -->
                        <div class="bulk-bar" id="bulkBar">
                            <span class="count"><span id="selectedCount">0</span> selected</span>
                            <div class="vr bg-white opacity-25" style="height: 20px;"></div>
                            <button type="button" id="bulkDeleteBtn" class="btn-bulk delete">
                                <i class="bi bi-trash3"></i> Delete Selected
                            </button>
                            <button type="button" class="btn-close btn-close-white ms-auto" id="closeBulkBar"
                                style="font-size: 0.6rem;"></button>
                        </div>

                        <form id="bulk-delete-form" action="<?php echo e(route('counselor.assessments.bulkDestroy')); ?>" method="POST"
                            class="d-none">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        </form>

                        <?php if($assessments->count() > 0): ?>
                            <div class="table-responsive">
                                <table class="premium-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </th>
                                            <th>Student</th>
                                            <th>Assessment Type</th>
                                            <th>Date Submitted</th>
                                            <th>Score Preview (D/A/S)</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <input class="form-check-input item-checkbox" type="checkbox"
                                                        value="<?php echo e($assessment->id); ?>">
                                                </td>
                                                <td>
                                                    <div class="user-info-cell">
                                                        <img src="<?php echo e($assessment->user->avatar_url); ?>" class="user-avatar" alt="">
                                                        <div class="user-details">
                                                            <h6><?php echo e($assessment->user->name); ?></h6>
                                                            <span><?php echo e($assessment->user->student_id ?? '-'); ?> •
                                                                <?php echo e($assessment->user->college ?? ''); ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="type-badge"><?php echo e($assessment->type); ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="fw-semibold"><?php echo e($assessment->created_at->format('M d, Y')); ?></span>
                                                        <span
                                                            class="text-muted small"><?php echo e($assessment->created_at->format('g:i A')); ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if($assessment->type === 'DASS-42'): ?>
                                                        <?php $s = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true); ?>
                                                        <span class="score-badge score-dep"
                                                            title="Depression"><?php echo e($s['depression'] ?? 0); ?></span>
                                                        <span class="score-badge score-anx"
                                                            title="Anxiety"><?php echo e($s['anxiety'] ?? 0); ?></span>
                                                        <span class="score-badge score-str"
                                                            title="Stress"><?php echo e($s['stress'] ?? 0); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="actions-cell">
                                                        <a href="<?php echo e(route('counselor.assessments.show', $assessment->id)); ?>"
                                                            class="btn-action view" title="View Details">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>
                                                        <button type="button" class="btn-action delete" title="Delete"
                                                            onclick="confirmDelete(<?php echo e($assessment->id); ?>)">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                        <form id="delete-form-<?php echo e($assessment->id); ?>"
                                                            action="<?php echo e(route('counselor.assessments.destroy', $assessment->id)); ?>"
                                                            method="POST" class="d-none">
                                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="pagination-wrap">
                                <?php echo e($assessments->links('vendor.pagination.premium')); ?>

                            </div>
                        <?php else: ?>
                            <div class="empty-state text-center py-5">
                                <i class="bi bi-clipboard-x fs-1 text-muted opacity-25"></i>
                                <h5 class="mt-3 fw-bold">No assessments found</h5>
                                <p class="text-muted">New submissions will appear here.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const bulkBar = document.getElementById('bulkBar');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');
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

            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    Swal.fire({
                        title: 'Delete Selected?',
                        text: `You are about to delete ${ids.length} assessment(s). This cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'Yes, Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            bulkDeleteForm.innerHTML = '<?php echo csrf_field(); ?> <?php echo method_field("DELETE"); ?>';
                            ids.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                bulkDeleteForm.appendChild(input);
                            });
                            bulkDeleteForm.submit();
                        }
                    });
                });
            }
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete Assessment?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/assessments/index.blade.php ENDPATH**/ ?>