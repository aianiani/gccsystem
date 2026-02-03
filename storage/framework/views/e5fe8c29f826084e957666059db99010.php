

<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #dee2e6;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
        }

        /* Match admin zoom standard */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
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

        .page-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }

        .page-header-card p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--gray-50);
            color: var(--forest-green);
            font-weight: 600;
            border-bottom: 2px solid var(--gray-100);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-100);
        }

        .table tbody tr:hover {
            background: var(--forest-green-lighter);
        }

        .status-badge {
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8f9fa;
            color: #6c757d;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }
    </style>

    <div class="main-dashboard-inner home-zoom">
        <div class="page-header-card">
            <div>
                <h1><i class="fas fa-images me-2"></i>Hero Images</h1>
                <p>Manage the sliding banner images displayed on the homepage</p>
            </div>
            <div>
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-light text-success fw-bold">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
                <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="main-content-card">
            <div class="card-header">
                <div><i class="fas fa-list me-2"></i>Current Images</div>
                <a href="<?php echo e(route('admin.hero-images.create')); ?>" class="btn btn-success btn-sm px-3 rounded-pill">
                    <i class="fas fa-plus me-1"></i> Add New Image
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table text-center align-middle bg-white">
                        <thead>
                            <tr>
                                <th width="15%">Preview</th>
                                <th>Title / Alt Text</th>
                                <th width="10%">Order</th>
                                <th width="10%">Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm"
                                            style="max-width: 150px; margin: 0 auto;">
                                            <img src="<?php echo e(asset($image->image_path)); ?>" alt="Hero Image"
                                                style="object-fit: cover;">
                                        </div>
                                    </td>
                                    <td class="fw-medium text-start ps-4"><?php echo e($image->title ?? 'N/A'); ?></td>
                                    <td><span class="badge bg-light text-dark border"><?php echo e($image->order); ?></span></td>
                                    <td>
                                        <?php if($image->is_active): ?>
                                            <span class="status-badge status-active">Active</span>
                                        <?php else: ?>
                                            <span class="status-badge status-inactive">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.hero-images.edit', $image->id)); ?>"
                                            class="btn btn-warning btn-sm btn-action text-white me-1" title="Edit">
                                            <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.hero-images.destroy', $image->id)); ?>" method="POST"
                                            class="d-inline delete-form"
                                            data-confirm-message="Are you sure you want to delete this image?">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm btn-action" title="Delete">
                                                <i class="fas fa-trash" style="font-size: 0.8rem;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="empty-state py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-images fa-3x mb-3 text-secondary opacity-50"></i>
                                            <p class="mb-0">No hero images found</p>
                                            <p class="small text-muted">Click "Add New Image" to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/admin/hero_images/index.blade.php ENDPATH**/ ?>