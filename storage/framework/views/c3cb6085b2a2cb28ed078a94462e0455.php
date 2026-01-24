

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
            min-width: 120px;
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

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
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

        .action-buttons {
            margin-bottom: 1.5rem;
        }
    </style>

    <div class="home-zoom">
        <div class="main-dashboard-inner">
            <!-- Page Header -->
            <div class="page-header-card">
                <div>
                    <h1>
                        <i class="bi bi-person-badge me-2"></i>
                        Registration Details
                    </h1>
                    <p class="mb-0">Review and process student registration</p>
                </div>
                <a href="<?php echo e(route('admin.registration-approvals.index')); ?>" class="btn btn-light">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Approvals
                </a>
            </div>

            <!-- Action Buttons -->
            <?php if($user->registration_status === 'pending'): ?>
                <div class="action-buttons">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal"
                                data-bs-target="#approveModal">
                                <i class="bi bi-check-circle me-2"></i>
                                Approve Registration
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger btn-lg w-100" data-bs-toggle="modal"
                                data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-2"></i>
                                Reject Registration
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Student Information Card -->
            <div class="registration-detail">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-person me-2"></i>
                            Student Information
                        </h5>
                        <span class="status-badge status-<?php echo e($user->registration_status); ?>">
                            <?php echo e(ucfirst($user->registration_status)); ?>

                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Avatar and Name Header -->
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="student-avatar-container me-3">
                            <?php if($user->avatar): ?>
                                <img src="<?php echo e($user->avatar_url); ?>" alt="<?php echo e($user->name); ?>" class="rounded-circle">
                            <?php else: ?>
                                <div class="avatar-placeholder">
                                    <?php echo e(strtoupper(substr($user->name ?? 'U', 0, 1))); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold"><?php echo e($user->name ?? 'N/A'); ?></h4>
                            <p class="text-muted mb-0"><?php echo e($user->email ?? 'N/A'); ?></p>
                        </div>
                    </div>

                    <!-- Information Grid -->
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="info-row">
                                <span class="info-label">Full Name:</span>
                                <span class="info-value fw-bold"><?php echo e($user->name ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value"><?php echo e($user->email ?? 'N/A'); ?></span>
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
                            <?php if($user->contact_number): ?>
                                <div class="info-row">
                                    <span class="info-label">Contact:</span>
                                    <span class="info-value"><?php echo e($user->contact_number); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($user->gender): ?>
                                <div class="info-row">
                                    <span class="info-label">Sex:</span>
                                    <span class="info-value"><?php echo e(ucfirst($user->gender)); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($user->address): ?>
                                <div class="info-row">
                                    <span class="info-label">Address:</span>
                                    <span class="info-value"><?php echo e($user->address); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="info-row">
                                <span class="info-label">Registered:</span>
                                <span
                                    class="info-value"><?php echo e($user->created_at ? $user->created_at->format('M d, Y') : 'N/A'); ?></span>
                            </div>
                            <?php if($user->approved_at): ?>
                                <div class="info-row">
                                    <span class="info-label">Processed:</span>
                                    <span class="info-value"><?php echo e($user->approved_at->format('M d, Y')); ?></span>
                                </div>
                                <?php if($user->approvedBy): ?>
                                    <div class="info-row">
                                        <span class="info-label">By:</span>
                                        <span class="info-value"><?php echo e($user->approvedBy->name); ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($user->rejection_reason): ?>
                                <div class="info-row">
                                    <span class="info-label">Rejection Reason:</span>
                                    <span class="info-value text-danger"><?php echo e($user->rejection_reason); ?></span>
                                </div>
                            <?php endif; ?>
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
        </div>
    </div>
    </div>
    </div>

    <!-- Approve Modal -->
    <?php if($user->registration_status === 'pending'): ?>
        <div class="modal fade" id="approveModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Approve Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?php echo e(route('admin.registration-approvals.approve', $user->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <p>Are you sure you want to approve the registration for <strong><?php echo e($user->name); ?></strong>?</p>
                            <p class="text-muted">This will activate their account and send them an approval email.</p>
                            <div class="mb-3">
                                <label for="registration_notes" class="form-label">Approval Notes (Optional)</label>
                                <textarea class="form-control" id="registration_notes" name="registration_notes" rows="3"
                                    placeholder="Add any notes about this approval..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?php echo e(route('admin.registration-approvals.reject', $user->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <p>Are you sure you want to reject the registration for <strong><?php echo e($user->name); ?></strong>?</p>
                            <p class="text-muted">This will deactivate their account and send them a rejection email.</p>
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label">Rejection Reason <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"
                                    placeholder="Please provide a reason for rejection..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/admin/registration-approvals/show.blade.php ENDPATH**/ ?>