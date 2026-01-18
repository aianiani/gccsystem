

<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #eef6ee;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
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

        .main-dashboard-inner {
            padding: 2rem;
        }

        .registration-detail {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .registration-detail .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .registration-detail .card-body {
            padding: 1.5rem;
        }

        .info-row {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-600);
            display: inline-block;
            min-width: 140px;
        }

        .info-value {
            color: #333;
        }

        .student-avatar-container {
            text-align: center;
        }

        .student-avatar-container img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 3px solid var(--forest-green-lighter);
        }

        .avatar-placeholder {
            width: 80px;
            height: 80px;
            background: var(--forest-green);
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .page-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .page-header-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }

        .action-icon-btn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .action-icon-btn:hover {
            transform: translateY(-2px);
        }
    </style>

    <div class="home-zoom">
        <div class="main-dashboard-inner">
            <!-- Page Header -->
            <div class="page-header-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h1>
                            <i class="bi bi-person-lines-fill me-2"></i>
                            User Details
                        </h1>
                        <p class="mb-0">View and manage user information and activity</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-light">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>Edit User
                        </a>

                        <?php if($user->id !== auth()->id()): ?>
                            <form action="<?php echo e(route('users.toggle-status', $user)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-<?php echo e($user->isActive() ? 'outline-light' : 'success'); ?>"
                                    data-bs-toggle="tooltip" title="<?php echo e($user->isActive() ? 'Deactivate' : 'Activate'); ?>">
                                    <i class="bi bi-<?php echo e($user->isActive() ? 'pause-circle' : 'play-circle'); ?> me-1"></i>
                                    <?php echo e($user->isActive() ? 'Deactivate' : 'Activate'); ?>

                                </button>
                            </form>
                            <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" id="delete-user-form"
                                data-username="<?php echo e($user->name); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Delete User">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- User Information Card -->
            <div class="registration-detail">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-person me-2"></i>
                            User Information
                        </h5>
                        <div class="d-flex gap-2">
                            <span
                                class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : ($user->role === 'counselor' ? 'success' : 'primary')); ?> status-badge">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                            <span class="badge bg-<?php echo e($user->isActive() ? 'success' : 'danger'); ?> status-badge">
                                <?php echo e($user->isActive() ? 'Active' : 'Inactive'); ?>

                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Avatar and Name Header -->
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="student-avatar-container me-3">
                            <img src="<?php echo e($user->avatar_url); ?>" alt="<?php echo e($user->name); ?>" class="rounded-circle">
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold"><?php echo e($user->name); ?></h4>
                            <p class="text-muted mb-0"><?php echo e($user->email); ?></p>
                        </div>
                    </div>

                    <!-- Information Grid -->
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label">Full Name:</span>
                                <span class="info-value fw-bold"><?php echo e($user->name); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value"><?php echo e($user->email); ?></span>
                            </div>
                            <?php if($user->student_id): ?>
                                <div class="info-row">
                                    <span class="info-label">Student ID:</span>
                                    <span class="info-value fw-bold"><?php echo e($user->student_id); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($user->college): ?>
                                <div class="info-row">
                                    <span class="info-label">College:</span>
                                    <span class="info-value"><?php echo e($user->college); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($user->course): ?>
                                <div class="info-row">
                                    <span class="info-label">Course:</span>
                                    <span class="info-value"><?php echo e($user->course); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($user->year_level): ?>
                                <div class="info-row">
                                    <span class="info-label">Year Level:</span>
                                    <span class="info-value"><?php echo e($user->year_level); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label">Role:</span>
                                <span class="info-value"><?php echo e(ucfirst($user->role)); ?></span>
                            </div>
                            <?php if($user->gender): ?>
                                <div class="info-row">
                                    <span class="info-label">Gender:</span>
                                    <span class="info-value"><?php echo e(ucfirst($user->gender)); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($user->contact_number): ?>
                                <div class="info-row">
                                    <span class="info-label">Contact:</span>
                                    <span class="info-value"><?php echo e($user->contact_number); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($user->address): ?>
                                <div class="info-row">
                                    <span class="info-label">Address:</span>
                                    <span class="info-value"><?php echo e($user->address); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="info-row">
                                <span class="info-label">Joined:</span>
                                <span class="info-value"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Last Updated:</span>
                                <span class="info-value"><?php echo e($user->updated_at->format('M d, Y')); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- COR File -->
                    <?php if($user->cor_file): ?>
                        <div class="mt-4 p-3 bg-light rounded border">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="bi bi-file-earmark-pdf text-danger me-2 fs-4"></i>
                                    <span class="fw-bold">Certificate of Registration</span>
                                </div>
                                <a href="<?php echo e(asset('storage/cor_files/' . $user->cor_file)); ?>" target="_blank"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i> View COR
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Activity History -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-success">
                        <i class="bi bi-activity me-2"></i>Activity History
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($activities->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold text-dark"><?php echo e(ucfirst($activity->action)); ?></div>
                                            <small class="text-secondary"><?php echo e($activity->description); ?></small>
                                            <?php if($activity->ip_address): ?>
                                                <br><small class="text-muted"><i class="bi bi-globe me-1"></i>IP:
                                                    <?php echo e($activity->ip_address); ?></small>
                                            <?php endif; ?>
                                            <?php if($activity->user_agent): ?>
                                                <br><small class="text-muted"><i class="bi bi-browser-chrome me-1"></i>Browser:
                                                    <?php echo e(getBrowserName($activity->user_agent)); ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted"><?php echo e($activity->created_at->format('M d, Y H:i')); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($activities->links('vendor.pagination.bootstrap-5')); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-activity fs-3 text-muted"></i>
                            </div>
                            <h6 class="text-secondary">No activities found</h6>
                            <p class="text-muted small">This user hasn't performed any actions yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <script src="<?php echo e(asset('vendor/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script>
        const deleteForm = document.getElementById('delete-user-form');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const userName = deleteForm.getAttribute('data-username');
                Swal.fire({
                    title: `Delete user "${userName}"?`,
                    text: 'This action will permanently delete the user and cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        }
    </script>
    <?php
        function getBrowserName($userAgent)
        {
            if (!$userAgent)
                return 'Unknown';
            if (stripos($userAgent, 'Brave') !== false || $userAgent === 'Brave')
                return 'Brave';
            if (stripos($userAgent, 'Edg') !== false)
                return 'Microsoft Edge';
            if (stripos($userAgent, 'OPR') !== false || stripos($userAgent, 'Opera') !== false)
                return 'Opera';
            if (stripos($userAgent, 'Chrome') !== false && stripos($userAgent, 'Edg') === false && stripos($userAgent, 'OPR') === false)
                return 'Google Chrome';
            if (stripos($userAgent, 'Safari') !== false && stripos($userAgent, 'Chrome') === false)
                return 'Safari';
            if (stripos($userAgent, 'Firefox') !== false)
                return 'Mozilla Firefox';
            if (stripos($userAgent, 'MSIE') !== false || stripos($userAgent, 'Trident') !== false)
                return 'Internet Explorer';
            return 'Other';
        }
    ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/users/show.blade.php ENDPATH**/ ?>