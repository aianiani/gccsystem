

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

            /* Map to common names */
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-200: #e9ecef;
            --gray-600: var(--text-light);
            --gray-800: #343a40;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        html {
            zoom: 75% !important;
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
            padding: 1.5rem;
            margin-bottom: 1.5rem;
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

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
            line-height: 1.1;
            color: var(--yellow-maize);
        }

        .page-header p {
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .feedback-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            overflow: hidden;
        }

        .feedback-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .feedback-header h4 {
            font-size: 1.25rem;
            letter-spacing: -0.3px;
        }

        .feedback-body {
            padding: 1.5rem;
        }

        .session-summary {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--forest-green);
            border: 1px solid var(--gray-100);
        }

        .session-summary h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: white;
            border-radius: 10px;
            border: 1px solid var(--gray-100);
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--hero-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
            border: 2px solid white;
            box-shadow: var(--shadow-sm);
        }

        .rating-box {
            background: var(--yellow-maize-light);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 203, 5, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stars {
            display: flex;
            gap: 0.25rem;
        }

        .star {
            font-size: 1.5rem;
            color: var(--yellow-maize);
        }

        .feedback-content {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
        }

        .feedback-content h6 {
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 0.75rem;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            text-decoration: none;
            transform: translateX(-3px);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .badge-rating {
            background: var(--forest-green);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
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
        }

        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.05);
        }

        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: 0.9rem 1.25rem;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .custom-sidebar .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .custom-sidebar .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #f4d03f;
            font-weight: 600;
        }

        .custom-sidebar .sidebar-bottom {
            padding: 1.5rem 1rem;
            background: rgba(0, 0, 0, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-sidebar .sidebar-link.logout:hover {
            background: #dc3545;
        }

        .main-dashboard-content {
            margin-left: 240px;
        }

        .meta-info {
            font-size: 0.85rem;
            color: var(--gray-600);
            display: flex;
            gap: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .meta-item i {
            color: var(--forest-green-light);
        }
    </style>

    <div class="d-flex">
        <?php if(auth()->user()->role === 'counselor'): ?>
            <?php echo $__env->make('counselor.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <!-- Fallback or Student sidebar if accessed by student (though route is counselor focused) -->
            <?php echo $__env->make('student.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        <div class="main-dashboard-content flex-grow-1">
            <div class="container-fluid py-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-2">
                                <i class="bi bi-star me-2"></i>
                                Session Feedback Details
                            </h1>
                            <p class="mb-0 opacity-75">Review student thoughts about your counseling session</p>
                        </div>
                        <a href="<?php echo e(route('counselor.feedback.index')); ?>" class="back-btn">
                            <i class="bi bi-arrow-left"></i>
                            Back to Feedback List
                        </a>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <h4 class="mb-0">
                                    <i class="bi bi-person-check me-2"></i>
                                    Feedback from <?php echo e($feedback->appointment->student->name); ?>

                                </h4>
                            </div>
                            <div class="feedback-body">
                                <div class="session-summary">
                                    <h5>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Session Details
                                    </h5>
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            <?php echo e(strtoupper(substr($feedback->appointment->student->name ?? 'S', 0, 1))); ?>

                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold"><?php echo e($feedback->appointment->student->name); ?></h6>
                                            <p class="mb-0 text-muted small"><?php echo e($feedback->appointment->student->email); ?>

                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2">
                                                <i class="bi bi-calendar3 me-2 text-primary"></i>
                                                <strong>Date:</strong>
                                                <?php echo e($feedback->appointment->scheduled_at->format('M j, Y')); ?>

                                            </p>
                                            <p class="mb-0">
                                                <i class="bi bi-clock me-2 text-primary"></i>
                                                <strong>Time:</strong>
                                                <?php echo e($feedback->appointment->scheduled_at->format('g:i A')); ?>

                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2">
                                                <i class="bi bi-hash me-2 text-success"></i>
                                                <strong>Session Number:</strong> <?php echo e($sessionNumber); ?>

                                            </p>
                                            <p class="mb-0">
                                                <i class="bi bi-journal-text me-2 text-success"></i>
                                                <strong>Notes:</strong> <?php echo e($feedback->appointment->sessionNotes->count()); ?>

                                                note(s)
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rating-box">
                                    <div>
                                        <h6 class="mb-2 fw-bold text-dark">Overall Rating</h6>
                                        <div class="stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi bi-star<?php echo e($i <= $feedback->rating ? '-fill' : ''); ?> star"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge-rating"><?php echo e($feedback->rating); ?> / 5 Stars</span>
                                    </div>
                                </div>

                                <div class="feedback-content">
                                    <h6>Student Comments</h6>
                                    <div class="p-2" style="line-height: 1.6; color: #444;">
                                        <?php echo nl2br(e($feedback->comments)); ?>

                                    </div>
                                </div>

                                <div class="meta-info">
                                    <div class="meta-item">
                                        <i class="bi bi-calendar-event"></i>
                                        Submitted on <?php echo e($feedback->created_at->format('F j, Y')); ?>

                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-clock-history"></i>
                                        <?php echo e($feedback->created_at->diffForHumans()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/session-feedback/show.blade.php ENDPATH**/ ?>