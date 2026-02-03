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
            .main-dashboard-content { margin-left: 200px; }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content { margin-left: 0; padding: 1rem; }
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
            border: 1px solid rgba(0,0,0,0.04);
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

        .stat-icon.primary { background: var(--light-green); color: var(--primary-green); }
        .stat-icon.success { background: #e8f5e9; color: #1b5e20; }
        .stat-icon.warning { background: #fff8e1; color: #f57f17; }

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
            border: 1px solid rgba(0,0,0,0.04);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
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
            border: 1px solid rgba(0,0,0,0.04);
            overflow: hidden;
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
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
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

        /* Badges */
        .session-badge {
            background: var(--light-green);
            color: var(--primary-green);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid var(--forest-green-lighter);
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-scheduled { background: #eff6ff; color: #1d4ed8; border: 1px solid #93c5fd; }
        .status-completed { background: #ecfdf5; color: #047857; border: 1px solid #6ee7b7; }
        .status-missed { background: #fffbeb; color: #b45309; border: 1px solid #fcd34d; }
        .status-expired { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Attendance Select */
        .attendance-select {
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
            background: #fff;
            min-width: 120px;
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
        }

        .btn-action.view:hover { color: #0284c7; background: #e0f2fe; }
        .btn-action.timeline:hover { color: #6d28d9; background: #f5f3ff; }
        .btn-action.edit:hover { color: #f59e0b; background: #fffbeb; }
        .btn-action.complete:hover { color: #059669; background: #d1fae5; }

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
                        // Assuming $sessionNotes is available from controller
                        $totalNotes = $sessionNotes->total();
                        $completedNotes = \App\Models\SessionNote::where('counselor_id', auth()->id())->where('session_status', 'completed')->count();
                        $missedNotes = \App\Models\SessionNote::where('counselor_id', auth()->id())->where('session_status', 'missed')->count();
                    ?>

                    <!-- Page Header -->
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">Session Notes</h1>
                            <p class="text-muted mb-0 mt-1">Detailed tracking of student guidance sessions</p>
                        </div>
                        <a href="<?php echo e(route('counselor.appointments.index')); ?>" class="btn btn-outline-success btn-sm d-flex align-items-center gap-2">
                             <i class="bi bi-calendar-check-fill"></i> Appointments List
                        </a>
                    </div>

                    <!-- Alert Messages -->
                    <?php if(session('success')): ?>
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3 py-2">
                            <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Stats Row -->
                    <div class="stats-row">
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo e(number_format($totalNotes)); ?></h3>
                                <p>Total Notes</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo e(number_format($completedNotes)); ?></h3>
                                <p>Sessions Completed</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>
                            <div class="stat-info">
                                <h3><?php echo e(number_format($missedNotes)); ?></h3>
                                <p>Sessions Missed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Bar -->
                    <div class="filter-bar">
                        <form method="GET" action="<?php echo e(route('counselor.session_notes.index')); ?>">
                            <div class="filter-row">
                                <div class="filter-input-group" style="grid-column: span 2;">
                                    <label>Search Student</label>
                                    <input type="text" name="student" class="filter-control" placeholder="Name or email..." value="<?php echo e(request('student')); ?>">
                                </div>

                                <div class="filter-input-group">
                                    <label>Status</label>
                                    <select name="status" class="filter-control">
                                        <option value="">All Statuses</option>
                                        <option value="scheduled" <?php echo e(request('status') == 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                                        <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                                        <option value="missed" <?php echo e(request('status') == 'missed' ? 'selected' : ''); ?>>Missed</option>
                                        <option value="expired" <?php echo e(request('status') == 'expired' ? 'selected' : ''); ?>>Expired</option>
                                    </select>
                                </div>

                                <div class="filter-input-group">
                                    <label>Time</label>
                                    <select name="filter" class="filter-control">
                                        <option value="">All Time</option>
                                        <option value="upcoming" <?php echo e(request('filter') == 'upcoming' ? 'selected' : ''); ?>>Upcoming</option>
                                        <option value="past" <?php echo e(request('filter') == 'past' ? 'selected' : ''); ?>>Past Sessions</option>
                                    </select>
                                </div>

                                <div class="filter-input-group">
                                    <label>Sort By</label>
                                    <select name="sort" class="filter-control">
                                        <option value="date_desc" <?php echo e(request('sort') == 'date_desc' ? 'selected' : ''); ?>>Newest First</option>
                                        <option value="date_asc" <?php echo e(request('sort') == 'date_asc' ? 'selected' : ''); ?>>Oldest First</option>
                                        <option value="student_asc" <?php echo e(request('sort') == 'student_asc' ? 'selected' : ''); ?>>Name A-Z</option>
                                    </select>
                                    <select name="per_page" class="filter-control" style="min-width: 100px;">
                                        <option value="10" <?php echo e(request('per_page') == '10' ? 'selected' : ''); ?>>10 Per Page</option>
                                        <option value="20" <?php echo e(request('per_page') == '20' ? 'selected' : ''); ?>>20 Per Page</option>
                                        <option value="30" <?php echo e(request('per_page') == '30' ? 'selected' : ''); ?>>30 Per Page</option>
                                        <option value="50" <?php echo e(request('per_page') == '50' ? 'selected' : ''); ?>>50 Per Page</option>
                                        <option value="100" <?php echo e(request('per_page') == '100' ? 'selected' : ''); ?>>100 Per Page</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-filter-submit px-4 flex-grow-1">
                                        <i class="bi bi-funnel-fill"></i> Filter
                                    </button>
                                    <a href="<?php echo e(route('counselor.session_notes.index')); ?>" class="btn-reset-filter" title="Reset">
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
                            <button type="button" id="bulkCompleteBtn" class="btn-bulk approve">
                                <i class="bi bi-check-circle"></i> Mark Completed
                            </button>
                            <button type="button" id="bulkDeleteBtn" class="btn-bulk delete">
                                <i class="bi bi-trash3"></i> Delete Selected
                            </button>
                            <button type="button" class="btn-close btn-close-white ms-auto" id="closeBulkBar" style="font-size: 0.6rem;"></button>
                        </div>

                        <form id="bulk-delete-form" action="<?php echo e(route('counselor.session_notes.bulkDestroy')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        </form>
                        <form id="bulk-complete-form" action="<?php echo e(route('counselor.session_notes.bulkComplete')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        </form>

                        <?php if($sessionNotes->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="premium-table">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </th>
                                        <th>Student</th>
                                        <th style="width: 120px;">Session</th>
                                        <th style="width: 150px;">Status</th>
                                        <th style="width: 150px;">Date & Time</th>
                                        <th style="width: 180px;">Attendance</th>
                                        <th class="text-end" style="width: 180px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $sessionNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <input class="form-check-input item-checkbox" type="checkbox" value="<?php echo e($note->id); ?>">
                                        </td>
                                        <td>
                                            <div class="user-info-cell">
                                                <img src="<?php echo e($note->appointment->student->avatar_url); ?>" class="user-avatar" alt="">
                                                <div class="user-details">
                                                    <h6><?php echo e($note->appointment->student->name); ?></h6>
                                                    <span><?php echo e($note->appointment->student->student_id ?? '-'); ?> • <?php echo e($note->appointment->student->college ?? ''); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="session-badge">Session #<?php echo e($note->session_number ?? '-'); ?></span>
                                        </td>
                                        <td>
                                            <?php
                                                $status = $note->session_status;
                                                $statusClasses = [
                                                    'scheduled' => 'status-scheduled',
                                                    'completed' => 'status-completed',
                                                    'missed' => 'status-missed',
                                                    'expired' => 'status-expired'
                                                ];
                                            ?>
                                            <span class="status-badge <?php echo e($statusClasses[$status] ?? 'status-scheduled'); ?>">
                                                <?php echo e(ucfirst($status)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold"><?php echo e($note->appointment->scheduled_at->format('M d, Y')); ?></span>
                                                <span class="text-muted small"><?php echo e($note->appointment->scheduled_at->format('g:i A')); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="<?php echo e(route('counselor.session_notes.update', $note->id)); ?>" method="POST" class="d-flex align-items-center gap-2">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                <select name="attendance" class="attendance-select" onchange="this.form.submit()">
                                                    <option value="unknown" <?php echo e($note->attendance === 'unknown' ? 'selected' : ''); ?>>Unknown</option>
                                                    <option value="attended" <?php echo e($note->attendance === 'attended' ? 'selected' : ''); ?>>Attended</option>
                                                    <option value="missed" <?php echo e($note->attendance === 'missed' ? 'selected' : ''); ?>>Missed</option>
                                                </select>
                                                <?php if($note->attendance === 'missed'): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-danger p-1" data-bs-toggle="modal" data-bs-target="#reasonModal<?php echo e($note->id); ?>" title="See Reason">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="actions-cell">
                                                <a href="<?php echo e(route('counselor.session_notes.show', $note->id)); ?>" class="btn-action view" title="View Details">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                <a href="<?php echo e(route('counselor.session_notes.timeline', $note->appointment->student->id)); ?>" class="btn-action timeline" title="Session History">
                                                    <i class="bi bi-clock-history"></i>
                                                </a>
                                                
                                                <?php if($note->session_status !== 'completed'): ?>
                                                <a href="<?php echo e(route('counselor.session_notes.edit', $note->id)); ?>" class="btn-action edit" title="Edit Note">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="<?php echo e(route('counselor.session_notes.complete', $note->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" class="btn-action complete" title="Mark Completed">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php if($note->attendance === 'missed'): ?>
                                    <!-- Reason Modal -->
                                    <div class="modal fade" id="reasonModal<?php echo e($note->id); ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold">Absence Reason</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?php echo e(route('counselor.session_notes.update', $note->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                    <div class="modal-body">
                                                        <p class="text-muted small mb-3">Please provide or update the reason why the student missed the session.</p>
                                                        <textarea name="absence_reason" class="form-control border-opacity-10" rows="4" placeholder="Enter reason here..." style="border-radius: 12px;"><?php echo e($note->absence_reason); ?></textarea>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                                                        <button type="submit" class="btn btn-primary px-4" style="background: var(--primary-green); border: none; border-radius: 10px;">Save Reason</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="pagination-wrap">
                            <?php echo e($sessionNotes->links('vendor.pagination.premium')); ?>

                        </div>
                        <?php else: ?>
                        <div class="empty-state text-center py-5">
                            <i class="bi bi-journal-x fs-1 text-muted opacity-25"></i>
                            <h5 class="mt-3 fw-bold">No session notes found</h5>
                            <p class="text-muted">New notes will appear when appointments are scheduled.</p>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const bulkBar = document.getElementById('bulkBar');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const bulkCompleteBtn = document.getElementById('bulkCompleteBtn');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');
            const bulkCompleteForm = document.getElementById('bulk-complete-form');
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
                selectAll.addEventListener('change', function() {
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
                        text: `You are about to delete ${ids.length} session note(s). This cannot be undone.`,
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

            if (bulkCompleteBtn) {
                bulkCompleteBtn.addEventListener('click', () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    Swal.fire({
                        title: 'Mark as Completed?',
                        text: `You are about to mark ${ids.length} session(s) as completed.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#1f7a2d',
                        confirmButtonText: 'Yes, Complete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            bulkCompleteForm.innerHTML = '<?php echo csrf_field(); ?> <?php echo method_field("PATCH"); ?>';
                            ids.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                bulkCompleteForm.appendChild(input);
                            });
                            bulkCompleteForm.submit();
                        }
                    });
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/session_notes/index.blade.php ENDPATH**/ ?>