

<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        .home-zoom {
            zoom: 75%;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top left;
                width: 133.33%;
            }
        }

        body {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%) !important;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            background: var(--hero-gradient);
            color: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(60px);
        }

        .seminar-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .seminar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .seminar-header {
            background: var(--light-green);
            padding: 1.5rem;
            color: var(--forest-green);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .seminar-status {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .status-completed {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-pending {
            background: #fff3cd;
            color: #664d03;
        }

        .seminar-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .main-dashboard-content {
            margin-left: 240px;
        }

        .btn-evaluate {
            background: var(--forest-green);
            color: white;
            border: none;
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-evaluate:hover {
            background: var(--forest-green-dark);
            color: white;
            transform: translateY(-2px);
        }

        .btn-completed {
            background: #e9ecef;
            color: #495057;
            border: 1px solid #ced4da;
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: default;
        }
    </style>

    <div class="d-flex home-zoom">
        <?php echo $__env->make('student.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="main-dashboard-content flex-grow-1">
            <div class="container-fluid py-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div style="z-index: 2; position: relative;">
                            <h1 class="mb-2 fw-bold" style="color: var(--yellow-maize);">
                                <i class="bi bi-award me-2"></i>
                                Guidance Programs
                            </h1>
                            <p class="mb-0 opacity-90 fs-5">Complete your evaluations for the required student seminars</p>
                        </div>
                    </div>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <?php
                        $branding = [
                            'IDREAMS' => ['color' => '#0dcaf0', 'icon' => 'bi-clouds-fill', 'bg' => 'rgba(13, 202, 240, 0.08)'],
                            '10C' => ['color' => '#FFCB05', 'icon' => 'bi-lightbulb-fill', 'bg' => 'rgba(255, 203, 5, 0.08)'],
                            'LEADS' => ['color' => '#0d6efd', 'icon' => 'bi-people-fill', 'bg' => 'rgba(13, 110, 253, 0.08)'],
                            'IMAGE' => ['color' => '#198754', 'icon' => 'bi-person-badge-fill', 'bg' => 'rgba(25, 135, 84, 0.08)'],
                        ];
                    ?>
                    <?php $__currentLoopData = $seminars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seminar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $style = $branding[$seminar->name] ?? ['color' => 'var(--forest-green)', 'icon' => 'bi-award', 'bg' => 'var(--light-green)'];
                        ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="seminar-card">
                                <div class="seminar-header" style="background: <?php echo e($style['bg']); ?>;">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <?php if($seminar->is_evaluated): ?>
                                            <span class="seminar-status status-completed">
                                                <i class="bi bi-check-circle-fill me-1"></i> Completed
                                            </span>
                                        <?php else: ?>
                                            <span class="seminar-status status-pending">
                                                <i class="bi bi-hourglass-split me-1"></i> Pending
                                            </span>
                                        <?php endif; ?>
                                        <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px; border: 1px solid <?php echo e($style['color']); ?>40;">
                                            <i class="bi <?php echo e($style['icon']); ?>"
                                                style="color: <?php echo e($style['color']); ?>; font-size: 1.2rem;"></i>
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mb-0" style="color: <?php echo e($style['color']); ?>;"><?php echo e($seminar->name); ?></h3>
                                    <small class="text-muted fw-bold">Target Year: <?php echo e($seminar->target_year_level); ?></small>
                                </div>
                                <div class="seminar-body">
                                    <p class="text-secondary mb-4"><?php echo e(Str::limit($seminar->description, 100)); ?></p>

                                    <div class="mt-auto">
                                        <?php if($seminar->is_evaluated): ?>
                                            <button class="btn btn-completed" disabled>
                                                Evaluation Submitted
                                            </button>
                                        <?php elseif($seminar->is_unlocked): ?>
                                            <a href="<?php echo e(route('student.seminars.evaluate', $seminar->id)); ?>"
                                                class="btn btn-evaluate">
                                                <i class="bi bi-pencil-square me-2"></i> Evaluate Now
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-completed w-100" disabled
                                                style="background: #f8f9fa; color: #adb5bd;">
                                                <i class="bi bi-lock-fill me-2"></i> Locked
                                            </button>
                                            <div class="text-center mt-2">
                                                <small class="text-muted" style="font-size: 0.7rem;">Verified attendance required to
                                                    unlock</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/student/seminars/index.blade.php ENDPATH**/ ?>