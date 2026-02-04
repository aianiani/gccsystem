

<?php $__env->startSection('content'); ?>
    <style>
        /* Premium Theme Variables */
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
            --forest-green: var(--primary-green);
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

        /* Page Header */
        .page-header {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: end;
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

        /* Stats Cards */
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

        .stat-icon.info {
            background: #e0f2fe;
            color: #0284c7;
        }

        .stat-icon.warning {
            background: #fffbeb;
            color: #b45309;
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

        /* Filter styling relative to premium theme */
        .filter-bar {
            background: #fff;
            padding: 1rem 1.25rem;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .filter-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary-green);
            text-transform: uppercase;
            margin-bottom: 0.4rem;
            display: block;
        }

        .filter-input,
        .filter-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            width: 100%;
            height: 38px;
        }

        .filter-input:focus,
        .filter-select:focus {
            border-color: var(--primary-green);
            outline: none;
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
        }

        /* Premium Table */
        .content-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.04);
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

        /* User Cell */
        .user-cell {
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

        .user-info h6 {
            margin: 0;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .user-info span {
            font-size: 0.8rem;
            color: #64748b;
            display: block;
        }

        .user-me-badge {
            font-size: 0.7rem;
            color: var(--primary-green);
            background: var(--light-green);
            padding: 1px 6px;
            border-radius: 4px;
            border: 1px solid rgba(31, 122, 45, 0.2);
            margin-left: 6px;
        }

        /* Badges */
        .premium-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .badge-role-admin {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .badge-role-student {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .badge-role-counselor {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge-status-active {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-status-inactive {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Actions */
        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-action:hover {
            background: #f1f5f9;
            color: var(--text-dark);
        }

        .btn-action.edit:hover {
            background: #fff7ed;
            color: #c2410c;
        }

        .btn-action.delete:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        /* Checkbox */
        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            cursor: pointer;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }
    </style>

    <div class="main-dashboard-inner home-zoom">
        <!-- Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Users Management</h1>
                <p class="text-muted mb-0 mt-1">Manage, monitor, and administrate system users</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-danger btn-sm fw-semibold shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#importDeleteModal">
                    <i class="bi bi-person-x me-2"></i>Import to Delete
                </button>
                <a href="<?php echo e(route('users.export', request()->all())); ?>"
                    class="btn btn-success btn-sm fw-semibold shadow-sm text-white"
                    style="background: var(--primary-green); border: none;">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export
                </a>
                <a href="<?php echo e(route('users.create')); ?>" class="btn btn-dark btn-sm fw-semibold shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i>New User
                </a>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo e(number_format($users->total())); ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success" style="background: #f0fdf4; color: #15803d;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo e(number_format($users->where('is_active', true)->count())); ?></h3>
                    <p>Active Account</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo e($users->where('role', 'admin')->count()); ?></h3>
                    <p>Administrators</p>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="filter-bar">
            <form method="GET" action="<?php echo e(route('users.index')); ?>" id="filterForm">
                <input type="hidden" name="sort" value="<?php echo e(request('sort', 'created_at')); ?>">
                <input type="hidden" name="direction" value="<?php echo e(request('direction', 'desc')); ?>">
                <input type="hidden" name="per_page" value="<?php echo e(request('per_page', 15)); ?>">

                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-4">
                        <label class="filter-label"><i class="bi bi-search me-1"></i> Search</label>
                        <input type="text" class="filter-input" name="search" placeholder="Name, email, or ID..."
                            value="<?php echo e(request('search')); ?>">
                    </div>

                    <!-- Filters -->
                    <div class="col-md-2">
                        <label class="filter-label">College</label>
                        <select class="filter-select" name="college" onchange="this.form.submit()">
                            <option value="">All Colleges</option>
                            <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($college); ?>" <?php echo e(request('college') == $college ? 'selected' : ''); ?>>
                                    <?php echo e($college); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Course</label>
                        <select class="filter-select" name="course" onchange="this.form.submit()">
                            <option value="">All Courses</option>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($course); ?>" <?php echo e(request('course') == $course ? 'selected' : ''); ?>><?php echo e($course); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Role</label>
                        <select class="filter-select" name="role" onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                            <option value="student" <?php echo e(request('role') === 'student' ? 'selected' : ''); ?>>Student</option>
                            <option value="counselor" <?php echo e(request('role') === 'counselor' ? 'selected' : ''); ?>>Counselor
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Status</label>
                        <select class="filter-select" name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive
                            </option>
                        </select>
                    </div>

                    <!-- Collapsible Advanced Filters -->
                    <div class="col-12 mt-2">
                        <button type="button" class="btn btn-link text-decoration-none small fw-bold text-success p-0"
                            id="advancedFiltersToggle" onclick="toggleAdvancedFilters()"
                            aria-expanded="<?php echo e(request()->anyFilled(['year_level', 'sex', 'date_from', 'date_to']) ? 'true' : 'false'); ?>"
                            aria-controls="advancedFilters">
                            <i class="bi bi-sliders me-1"></i> More Filters (Year, Sex, Dates)
                        </button>
                        <?php if(request()->anyFilled(['year_level', 'sex', 'date_from', 'date_to'])): ?>
                            <span class="badge bg-success ms-2" style="font-size: 0.65rem;">Active Filters</span>
                        <?php endif; ?>
                    </div>

                    <script>
                        function toggleAdvancedFilters() {
                            const target = document.getElementById('advancedFilters');
                            const btn = document.getElementById('advancedFiltersToggle');
                                                                                                   if (target) {
                                    if (target.classList.contains('d-none')) {
                                        target.classList.remove('d-none');
                                        if(btn) btn.setAttribute('aria-expanded', 'true');
                                    } else {
                                        target.classList.add('d-none');
                                        if(btn) btn.setAttribute('aria-expanded', 'false');
                                    }
                                }
                            }
                        </script>

                        <div class="col-12">
                            <div class="<?php echo e(request()->anyFilled(['year_level', 'sex', 'date_from', 'date_to']) ? '' : 'd-none'); ?>"
                                id="advancedFilters">
                                <div class="row g-3 pt-2">
                                <div class="col-md-2">
                                    <label class="filter-label">Year Level</label>
                                    <select class="filter-select" name="year_level" onchange="this.form.submit()">
                                        <option value="">All Years</option>
                                        <option value="1st Year" <?php echo e(request('year_level') === '1st Year' ? 'selected' : ''); ?>>1st
                                            Year</option>
                                        <option value="2nd Year" <?php echo e(request('year_level') === '2nd Year' ? 'selected' : ''); ?>>2nd
                                            Year</option>
                                        <option value="3rd Year" <?php echo e(request('year_level') === '3rd Year' ? 'selected' : ''); ?>>3rd
                                            Year</option>
                                        <option value="4th Year" <?php echo e(request('year_level') === '4th Year' ? 'selected' : ''); ?>>4th
                                            Year</option>
                                        <option value="Graduated" <?php echo e(request('year_level') === 'Graduated' ? 'selected' : ''); ?>>
                                            Graduated</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="filter-label">Sex</label>
                                    <select class="filter-select" name="sex" onchange="this.form.submit()">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $sexes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sex); ?>" <?php echo e(request('sex') == $sex ? 'selected' : ''); ?>>
                                                <?php echo e(ucfirst($sex)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="filter-label">From Date</label>
                                    <input type="date" class="filter-input" name="date_from" value="<?php echo e(request('date_from')); ?>"
                                        onchange="this.form.submit()">
                                </div>
                                <div class="col-md-3">
                                    <label class="filter-label">To Date</label>
                                    <input type="date" class="filter-input" name="date_to" value="<?php echo e(request('date_to')); ?>"
                                        onchange="this.form.submit()">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <?php if(request()->anyFilled(['search', 'college', 'course', 'year_level', 'role', 'sex', 'status', 'date_from', 'date_to'])): ?>
                                        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-danger w-100"
                                            style="height: 38px;">
                                            <i class="bi bi-x-lg me-1"></i> Clear All
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Content Card -->
            <div class="content-card">
                <?php if($users->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th class="ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th>
                                        <a href="?<?php echo e(http_build_query(array_merge(request()->except(['sort', 'direction']), ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc']))); ?>"
                                            class="text-decoration-none text-secondary d-flex align-items-center gap-1">
                                            USER
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?<?php echo e(http_build_query(array_merge(request()->except(['sort', 'direction']), ['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc']))); ?>"
                                            class="text-decoration-none text-secondary d-flex align-items-center gap-1">
                                            EMAIL
                                        </a>
                                    </th>
                                    <th>ROLE</th>
                                    <th>STATUS</th>
                                    <th>JOINED</th>
                                    <th class="text-end pe-4">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4">
                                            <input type="checkbox" class="form-check-input user-checkbox" value="<?php echo e($user->id); ?>" <?php echo e($user->id === auth()->id() ? 'disabled' : ''); ?>>
                                        </td>
                                        <td>
                                            <div class="user-cell">
                                                <img src="<?php echo e($user->avatar_url); ?>" alt="Avatar" class="user-avatar">
                                                <div class="user-info">
                                                    <h6>
                                                        <?php echo e($user->name); ?>

                                                        <?php if($user->id === auth()->id()): ?>
                                                            <span class="user-me-badge">You</span>
                                                        <?php endif; ?>
                                                    </h6>
                                                    <span><?php echo e($user->student_id ?? ucfirst($user->role)); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-muted small"><?php echo e($user->email); ?></div>
                                        </td>
                                        <td>
                                            <span class="premium-badge badge-role-<?php echo e($user->role); ?>">
                                                <?php if($user->role == 'admin'): ?> <i class="bi bi-shield-fill"></i>
                                                <?php elseif($user->role == 'student'): ?> <i class="bi bi-person"></i>
                                                <?php else: ?> <i class="bi bi-person-badge"></i> <?php endif; ?>
                                                <?php echo e(ucfirst($user->role)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="premium-badge badge-status-<?php echo e($user->isActive() ? 'active' : 'inactive'); ?>">
                                                <i class="bi bi-circle-fill" style="font-size: 6px;"></i>
                                                <?php echo e($user->isActive() ? 'Active' : 'Inactive'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted small fw-medium"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-1">
                                                <a href="<?php echo e(route('users.show', $user)); ?>" class="btn-action" data-bs-toggle="tooltip"
                                                    title="View Profile">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn-action edit"
                                                    data-bs-toggle="tooltip" title="Edit User">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <?php if($user->id !== auth()->id()): ?>
                                                    <form action="<?php echo e(route('users.toggle-status', $user)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn-action" data-bs-toggle="tooltip"
                                                            title="<?php echo e($user->isActive() ? 'Deactivate' : 'Activate'); ?>">
                                                            <i
                                                                class="bi bi-<?php echo e($user->isActive() ? 'toggle-on text-success' : 'toggle-off text-muted'); ?> fs-5"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center p-3 border-top">
                        <div class="text-muted small">
                            Showing <strong><?php echo e($users->firstItem() ?? 0); ?></strong> - <strong><?php echo e($users->lastItem() ?? 0); ?></strong>
                            of <strong><?php echo e($users->total()); ?></strong>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <select class="form-select form-select-sm" style="width: auto; border-radius: 6px;"
                                onchange="changePerPage(this.value)">
                                <option value="15" <?php echo e(request('per_page', 15) == 15 ? 'selected' : ''); ?>>15 / page</option>
                                <option value="30" <?php echo e(request('per_page') == 30 ? 'selected' : ''); ?>>30 / page</option>
                                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 / page</option>
                                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100 / page</option>
                                <option value="500" <?php echo e(request('per_page') == 500 ? 'selected' : ''); ?>>500 / page</option>
                                <option value="1000" <?php echo e(request('per_page') == 1000 ? 'selected' : ''); ?>>1000 / page</option>
                            </select>
                            <?php echo e($users->links('vendor.pagination.premium-simple')); ?>

                        </div>
                    </div>

                    <script>
                        function changePerPage(perPage) {
                            const url = new URL(window.location.href);
                            url.searchParams.set('per_page', perPage);
                            url.searchParams.delete('page');
                            window.location.href = url.toString();
                        }
                    </script>

                <?php else: ?>
                    <div class="empty-state py-5 text-center">
                        <div class="mb-3">
                            <i class="bi bi-people text-muted opacity-25" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="fw-bold text-secondary">No users found</h5>
                        <p class="text-muted mb-4">Try adjusting your filters or search terms.</p>
                        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary btn-sm">
                            Clear Filters
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bulk Action Bar (sticky) -->
        <!-- Bulk Action Bar (sticky) -->
        <div id="bulkActionBar" class="position-fixed bottom-0 start-50 translate-middle-x mb-4"
            style="display: none; z-index: 1050;">
            <div
                class="d-flex align-items-center gap-3 bg-dark text-white p-2 px-3 rounded-pill shadow-lg border border-secondary bg-opacity-90 backdrop-blur">
                <!-- Selection Count -->
                <div class="d-flex align-items-center border-end border-secondary pe-3 me-1">
                    <span class="fw-bold me-2 text-warning"><span id="selectedCount">0</span></span>
                    <span class="text-white-50 small me-2 d-none d-sm-inline">Selected</span>
                    <button type="button" class="btn btn-link text-white-50 btn-sm p-0 text-decoration-none"
                        onclick="clearSelection()" title="Clear Selection">
                        <i class="bi bi-x-circle-fill hover-white transition-colors"></i>
                    </button>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2">
                    <button type="button"
                        class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 hover-success"
                        onclick="submitBulkAction('activate')" title="Activate Users" style="width: 32px; height: 32px;">
                        <i class="bi bi-check-lg fs-6"></i>
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 hover-warning"
                        onclick="submitBulkAction('deactivate')" title="Deactivate Users" style="width: 32px; height: 32px;">
                        <i class="bi bi-pause-fill fs-6"></i>
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 hover-info"
                        onclick="submitBulkAction('promote')" title="Promote Users" style="width: 32px; height: 32px;">
                        <i class="bi bi-graph-up-arrow fs-6"></i>
                    </button>

                    <div class="vr bg-secondary opacity-50 mx-1"></div>

                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                        <i class="bi bi-trash3-fill"></i> <span class="small fw-semibold d-none d-sm-inline">Delete</span>
                    </button>
                </div>
            </div>
        </div>

        <style>
            .backdrop-blur {
                backdrop-filter: blur(8px);
            }

            .hover-white:hover {
                color: #fff !important;
            }

            .hover-success:hover {
                background-color: #198754;
                border-color: #198754;
                color: white;
            }

            .hover-warning:hover {
                background-color: #ffc107;
                border-color: #ffc107;
                color: black;
            }

            .hover-info:hover {
                background-color: #0dcaf0;
                border-color: #0dcaf0;
                color: black;
            }
        </style>

        <!-- Hidden Forms for Bulk Actions -->
        <form id="bulkActivateForm" method="POST" action="<?php echo e(route('users.bulk-activate')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <div id="bulkActivateInputs"></div>
        </form>

        <form id="bulkDeactivateForm" method="POST" action="<?php echo e(route('users.bulk-deactivate')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <div id="bulkDeactivateInputs"></div>
        </form>

        <form id="bulkPromoteForm" method="POST" action="<?php echo e(route('users.bulk-promote')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <div id="bulkPromoteInputs"></div>
        </form>

        <form id="bulkDeleteForm" method="POST" action="<?php echo e(route('users.bulk-delete')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <div id="bulkDeleteInputs"></div>
        </form>



        <!-- Bulk Delete Confirmation Modal -->
        <div class="modal fade" id="bulkDeleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Confirm Bulk Delete</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to permanently delete <strong><span id="deleteCount">0</span> user(s)</strong>?
                        </p>
                        <p class="text-danger mb-0"><i class="bi bi-exclamation-circle me-1"></i>This action cannot be undone!
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="confirmBulkDelete()">
                            <i class="bi bi-trash me-1"></i>Delete Users
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Import Match Modal -->
        <div class="modal fade" id="importDeleteModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-file-earmark-person me-2"></i>Match Users from File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Upload your student list</strong> (Excel or CSV). Matched users will be automatically
                            selected in the list below so you can perform bulk actions on them.
                        </div>

                        <form id="importDeleteForm" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="import_file" class="form-label">Upload Student List (Excel/CSV)</label>
                                <input type="file" class="form-control" id="import_file" name="import_file"
                                    accept=".xlsx,.xls,.csv" required>
                                <div class="form-text">
                                    File must contain a <strong>Student ID</strong> column. You may also include
                                    <strong>Name</strong> and <strong>Email</strong> columns to help you identify users.
                                </div>
                            </div>
                        </form>
                        <div id="importError" class="alert alert-danger d-none mt-2"></div>

                        <!-- Results Area -->
                        <div id="verificationResults" class="mt-3"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="verifyImport(this)">
                            <i class="bi bi-search me-1"></i>Process File
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Bulk Action Bar (sticky) -->
        <div id="bulkActionBar" class="position-fixed bottom-0 start-50 translate-middle-x mb-4"
            style="display: none; z-index: 1050;">
            <div
                class="d-flex align-items-center gap-3 bg-dark text-white p-2 px-3 rounded-pill shadow-lg border border-secondary bg-opacity-90 backdrop-blur">
                <!-- Selection Count -->
                <div class="d-flex align-items-center border-end border-secondary pe-3 me-1">
                    <span class="fw-bold me-2 text-warning"><span id="selectedCount">0</span></span>
                    <span class="text-white-50 small me-2 d-none d-sm-inline">Selected</span>
                    <button type="button" class="btn btn-link text-white-50 btn-sm p-0 text-decoration-none"
                        onclick="clearSelection()" title="Clear Selection">
                        <i class="bi bi-x-circle-fill hover-white transition-colors"></i>
                    </button>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2">
                    <button type="button"
                        class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 hover-success"
                        onclick="submitBulkAction('activate')" title="Activate Users" style="width: 32px; height: 32px;">
                        <i class="bi bi-check-lg fs-6"></i>
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 hover-warning"
                        onclick="submitBulkAction('deactivate')" title="Deactivate Users" style="width: 32px; height: 32px;">
                        <i class="bi bi-pause-fill fs-6"></i>
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center border-0 hover-info"
                        onclick="submitBulkAction('promote')" title="Promote Users" style="width: 32px; height: 32px;">
                        <i class="bi bi-graph-up-arrow fs-6"></i>
                    </button>

                    <div class="vr bg-secondary opacity-50 mx-1"></div>

                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                        <i class="bi bi-trash3-fill"></i> <span class="small fw-semibold d-none d-sm-inline">Delete</span>
                    </button>
                </div>
            </div>
        </div>

        <style>
            .backdrop-blur {
                backdrop-filter: blur(8px);
            }

            .hover-white:hover {
                color: #fff !important;
            }

            .hover-success:hover {
                background-color: #198754;
                border-color: #198754;
                color: white;
            }

            .hover-warning:hover {
                background-color: #ffc107;
                border-color: #ffc107;
                color: black;
            }

            .hover-info:hover {
                background-color: #0dcaf0;
                border-color: #0dcaf0;
                color: black;
            }
        </style>

        <!-- Hidden Forms for Bulk Actions -->
        <form id="bulkActivateForm" method="POST" action="<?php echo e(route('users.bulk-activate')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div id="bulkActivateInputs"></div>
        </form>

        <form id="bulkDeactivateForm" method="POST" action="<?php echo e(route('users.bulk-deactivate')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div id="bulkDeactivateInputs"></div>
        </form>

        <form id="bulkPromoteForm" method="POST" action="<?php echo e(route('users.bulk-promote')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div id="bulkPromoteInputs"></div>
        </form>

        <form id="bulkDeleteForm" method="POST" action="<?php echo e(route('users.bulk-delete')); ?>" style="display: none;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div id="bulkDeleteInputs"></div>
        </form>

        <!-- Bulk Delete Confirmation Modal -->
        <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Bulk Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete <span id="deleteCount" class="fw-bold"></span> selected users?
                        This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="confirmBulkDelete()">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            console.log('Users Page Scripts Loading...');

            // Global selection manager
            window.SelectionManager = {
                storageKey: 'selected_user_ids',
                selectedIds: new Set(),
                init: function () {
                    this.load();
                    this.sync();
                    this.update();
                    this.bind();
                },
                load: function () {
                    try {
                        let saved = sessionStorage.getItem(this.storageKey);
                        if (saved) {
                            let arr = JSON.parse(saved);
                            this.selectedIds = new Set(arr.map(String));
                        }
                    } catch (e) { console.error('Storage Load Error', e); }
                },
                save: function () {
                    try {
                        sessionStorage.setItem(this.storageKey, JSON.stringify(Array.from(this.selectedIds)));
                    } catch (e) { console.error('Storage Save Error', e); }
                },
                sync: function () {
                    document.querySelectorAll('.user-checkbox').forEach(cb => {
                        cb.checked = this.selectedIds.has(cb.value);
                    });
                    let all = document.getElementById('selectAll');
                    if (all) {
                        let pageCbs = document.querySelectorAll('.user-checkbox:not(:disabled)');
                        all.checked = pageCbs.length > 0 && Array.from(pageCbs).every(c => c.checked);
                    }
                },
                update: function () {
                    let count = this.selectedIds.size;
                    ['selectedCount', 'deleteCount'].forEach(id => {
                        let el = document.getElementById(id);
                        if (el) el.textContent = count;
                    });
                    let bar = document.getElementById('bulkActionBar');
                    if (bar) bar.style.display = count > 0 ? 'block' : 'none';
                },
                add: function (id) { this.selectedIds.add(String(id)); this.save(); this.update(); },
                remove: function (id) { this.selectedIds.delete(String(id)); this.save(); this.update(); },
                addAll: function (ids) { ids.forEach(id => this.selectedIds.add(String(id))); this.save(); this.sync(); this.update(); },
                clear: function () { this.selectedIds.clear(); this.save(); this.sync(); this.update(); },
                bind: function () {
                    document.addEventListener('change', (e) => {
                        if (e.target.classList.contains('user-checkbox')) {
                            if (e.target.checked) this.add(e.target.value);
                            else this.remove(e.target.value);
                            this.sync();
                        }
                    });
                    let all = document.getElementById('selectAll');
                    if (all) {
                        all.addEventListener('change', (e) => {
                            document.querySelectorAll('.user-checkbox:not(:disabled)').forEach(cb => {
                                cb.checked = e.target.checked;
                                if (e.target.checked) this.selectedIds.add(cb.value);
                                else this.selectedIds.delete(cb.value);
                            });
                            this.save(); this.update();
                        });
                    }
                }
            };

            window.clearSelection = function () { window.SelectionManager.clear(); };

            window.submitBulkAction = function (action) {
                let ids = Array.from(window.SelectionManager.selectedIds);
                if (ids.length === 0) {
                    Swal.fire('Error', 'Please select at least one user', 'error');
                    return;
                }
                let formId, inputContainerId;
                switch (action) {
                    case 'activate': formId = 'bulkActivateForm'; inputContainerId = 'bulkActivateInputs'; break;
                    case 'deactivate': formId = 'bulkDeactivateForm'; inputContainerId = 'bulkDeactivateInputs'; break;
                    case 'promote': formId = 'bulkPromoteForm'; inputContainerId = 'bulkPromoteInputs'; break;
                }
                let form = document.getElementById(formId);
                let container = document.getElementById(inputContainerId);
                if (form && container) {
                    container.innerHTML = '';
                    ids.forEach(id => {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'user_ids[]';
                        input.value = id;
                        container.appendChild(input);
                    });
                    form.submit();
                }
            };

            window.confirmBulkDelete = function () {
                let ids = Array.from(window.SelectionManager.selectedIds);
                if (ids.length === 0) {
                    Swal.fire('Error', 'Please select at least one user', 'error');
                    return;
                }
                let form = document.getElementById('bulkDeleteForm');
                let container = document.getElementById('bulkDeleteInputs');
                if (form && container) {
                    container.innerHTML = '';
                    ids.forEach(id => {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'user_ids[]';
                        input.value = id;
                        container.appendChild(input);
                    });
                    form.submit();
                }
            };

            window.verifyImport = function (btn) {
                console.log('Button clicked:', btn);
                // alert('DEBUG: verifyImport function called successfully.');

                let form = document.getElementById('importDeleteForm');
                let fileInput = document.getElementById('import_file');
                let results = document.getElementById('verificationResults');
                let errDiv = document.getElementById('importError');

                if (!form || !fileInput) {
                    alert('Error: Form or File Input not found in the page.');
                    return;
                }

                if (!fileInput.files.length) {
                    alert('Please select a file first.');
                    fileInput.focus();
                    return;
                }

                let originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

                let formData = new FormData(form);
                let token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch('<?php echo e(route("users.verify-import-delete")); ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                    .then(async response => {
                        const contentType = response.headers.get("content-type");
                        if (!response.ok) {
                            // Start by trying to parse JSON error (e.g. valid 422 validation error)
                            try {
                                const errorData = await response.json();
                                if (errorData.message) {
                                    throw new Error(errorData.message);
                                }
                            } catch (ignore) { }

                            // If not JSON, try text
                            const text = await response.text();
                            let errorMsg = 'Server Error: ' + response.status;
                            if (text) {
                                let match = text.match(/<title>(.*?)<\/title>/i);
                                if (match) errorMsg += ' - ' + match[1];
                                else errorMsg += ' - ' + text.substring(0, 100);
                            }
                            throw new Error(errorMsg);
                        }
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            return response.json();
                        } else {
                            // Got success status but not JSON?
                            const text = await response.text();
                            throw new Error("Expected JSON but got: " + text.substring(0, 100));
                        }
                    })
                    .then(data => {
                        if (data.success) {
                            if (data.matched_ids && data.matched_ids.length > 0) {
                                window.SelectionManager.addAll(data.matched_ids);
                                results.innerHTML = '<div class="alert alert-success mt-3"><h6>Success!</h6><p>Matched <strong>' + data.count + '</strong> users.</p></div>';
                            } else {
                                results.innerHTML = '<div class="alert alert-warning mt-3"><h6>No matches found.</h6></div>';
                            }
                        } else {
                            alert('Error: ' + (data.message || 'Verification failed.'));
                        }
                    })
                    .catch(e => {
                        console.error('Fetch Error:', e);
                        // Clean up the error message for display
                        let msg = e.message.replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
                        alert('System Error: ' + msg);
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    });
            };

            document.addEventListener('DOMContentLoaded', () => {
                window.SelectionManager.init();
            });
        </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/users/index.blade.php ENDPATH**/ ?>