

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

            @media (max-width: 768px) {
                .home-zoom {
                    zoom: 1 !important;
                    transform: none !important;
                }
            }

            body,
            .profile-card,
            .stats-card,
            .main-content-card {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .custom-sidebar .sidebar-logo {
                text-align: center;
                padding: 2.5rem 1.5rem 1.5rem 1.5rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                background: rgba(0, 0, 0, 0.05);
            }

            .custom-sidebar .sidebar-logo h3 {
                font-family: 'Outfit', sans-serif;
                letter-spacing: 0.5px;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .custom-sidebar .sidebar-logo p {
                letter-spacing: 1px;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.8rem !important;
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
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                margin: 0.1rem 0;
            }

            .custom-sidebar .sidebar-link:hover {
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
                transform: translateX(5px);
            }

            .custom-sidebar .sidebar-link.active {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                color: #f4d03f;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .custom-sidebar .sidebar-link.active::before {
                content: '';
                position: absolute;
                left: -0.75rem;
                top: 15%;
                bottom: 15%;
                width: 5px;
                background: #f4d03f;
                border-radius: 0 6px 6px 0;
                box-shadow: 2px 0 15px rgba(244, 208, 63, 0.5);
            }

            .custom-sidebar .sidebar-link .bi {
                font-size: 1.25rem;
                transition: all 0.3s ease;
            }

            .custom-sidebar .sidebar-link.active .bi {
                transform: scale(1.1);
                filter: drop-shadow(0 0 5px rgba(244, 208, 63, 0.3));
            }

            .custom-sidebar .sidebar-bottom {
                padding: 1.5rem 1rem;
                background: rgba(0, 0, 0, 0.1);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .custom-sidebar .sidebar-link.logout {
                background: rgba(255, 255, 255, 0.05);
                color: rgba(255, 255, 255, 0.9);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                text-align: left;
                padding: 0.85rem 1.25rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 1.1rem;
            }

            .custom-sidebar .sidebar-link.logout:hover {
                background: #dc3545;
                color: #fff;
                border-color: #dc3545;
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(220, 53, 69, 0.4);
            }

            @media (max-width: 991.98px) {
                .custom-sidebar {
                    width: 200px;
                }

                .main-dashboard-content {
                    margin-left: 200px;
                }
            }

            @media (max-width: 991.98px) {
                /* Off-canvas behavior on mobile */
                .custom-sidebar {
                    position: fixed;
                    z-index: 1040;
                    height: 100vh;
                    left: 0;
                    top: 0;
                    width: 240px;
                    transform: translateX(-100%);
                    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    flex-direction: column;
                    padding: 0;
                    box-shadow: 10px 0 30px rgba(0, 0, 0, 0.2);
                }

                .custom-sidebar.show {
                    transform: translateX(0);
                }

                .main-dashboard-content {
                    margin-left: 0;
                    padding: 1rem 0.75rem;
                }

                /* Toggle button */
                #studentSidebarToggle {
                    position: fixed;
                    top: 1rem;
                    left: 1rem;
                    z-index: 1100;
                    background: var(--forest-green);
                    color: #fff;
                    border: none;
                    border-radius: 10px;
                    padding: 0.6rem 0.8rem;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                    display: flex !important;
                    align-items: center;
                    justify-content: center;
                }
            }

            .main-dashboard-content {
                background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
                min-height: 100vh;
                padding: 1rem 1.5rem;
                margin-left: 240px;
                transition: margin-left 0.2s;
            }

            .main-dashboard-inner {
                max-width: 1180px;
                margin: 0 auto;
            }

            /* Specific Page Styles similar to appointments.index */
            .appointments-hero {
                background: linear-gradient(135deg, #1a3d0f 0%, var(--primary-green) 50%, var(--accent-green) 100%);
                color: white;
                padding: 2rem 1.5rem;
                border-radius: 16px;
                box-shadow: var(--shadow-lg);
                margin-bottom: 2rem;
                position: relative;
                overflow: hidden;
            }

            .appointments-hero::before {
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

            @media (max-width: 576px) {
                .appointments-hero {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
                }
                .appointments-hero .title {
                    font-size: 1.4rem;
                }
            }

            .appointments-hero .title {
                font-size: 1.75rem;
                font-weight: 700;
                position: relative;
                z-index: 1;
            }

            .appointments-hero .small {
                position: relative;
                z-index: 1;
                font-size: 1.05rem;
            }

            .appointment-card {
                background: white;
                border-radius: 16px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
                border: 1px solid rgba(31, 122, 45, 0.08);
                margin-bottom: 1.5rem;
                overflow: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .appointment-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 20px rgba(31, 122, 45, 0.12);
                border-color: rgba(31, 122, 45, 0.15);
            }

            .appointment-header {
                background: linear-gradient(135deg, #f0f9f1 0%, #e8f5e8 100%);
                color: var(--forest-green);
                padding: 1.25rem 1.5rem;
                border-bottom: 1px solid rgba(31, 122, 45, 0.08);
                font-weight: 600;
            }

            .appointment-header h6 {
                font-size: 1.05rem;
                color: var(--text-dark);
            }

            .appointment-header .badge {
                font-size: 0.85rem;
                font-weight: 600;
                padding: 0.5rem 1.25rem;
                background: var(--forest-green) !important;
            }

            .appointment-body {
                padding: 1.5rem;
            }

            .counselor-avatar {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid white;
                box-shadow: 0 2px 8px rgba(31, 122, 45, 0.15);
            }

            .appointment-body .text-muted {
                color: var(--text-light) !important;
                font-size: 0.95rem;
            }

            .appointment-body .text-dark {
                color: var(--text-dark) !important;
                font-weight: 600;
            }

            .session-note {
                background: linear-gradient(135deg, #f8fcf9 0%, #f0f9f1 100%);
                border-radius: 12px;
                padding: 1.5rem;
                margin-top: 1.25rem;
                border-left: 4px solid var(--forest-green);
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            }

            .session-note h6 {
                color: var(--forest-green);
                font-size: 1.05rem;
            }

            /* Enhanced Feedback Section */
            .feedback-section {
                background: linear-gradient(135deg, #fffbf0 0%, #fff9e6 100%);
                border: 2px dashed rgba(255, 203, 5, 0.3);
                border-radius: 12px;
                padding: 1.5rem;
                margin-top: 1.5rem;
                transition: all 0.3s ease;
            }

            .feedback-section:hover {
                border-color: rgba(255, 203, 5, 0.5);
                box-shadow: 0 4px 12px rgba(255, 203, 5, 0.1);
            }

            .feedback-section h6 {
                font-size: 1.05rem;
                color: var(--text-dark);
            }

            .feedback-section .btn-outline-success {
                border: 2px solid var(--forest-green);
                color: var(--forest-green);
                font-weight: 600;
                padding: 0.5rem 1.75rem;
                transition: all 0.3s ease;
            }

            .feedback-section .btn-outline-success:hover {
                background: var(--forest-green);
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(31, 122, 45, 0.25);
            }

            .feedback-section .badge {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
                font-weight: 600;
            }

            .empty-state {
                text-align: center;
                padding: 4rem 3rem;
                color: var(--gray-600);
                background: white;
                border-radius: 16px;
                border: 2px dashed var(--gray-100);
            }

            .empty-state i {
                font-size: 4rem;
                color: #d1d5db;
                margin-bottom: 1.5rem;
            }
        </style>

        <div class="home-zoom">
            <div class="d-flex">
                <!-- Mobile Sidebar Toggle -->
                <button id="studentSidebarToggle" class="d-lg-none">
                    <i class="bi bi-list"></i>
                </button>

                <!-- Sidebar -->
                <!-- Sidebar -->
                <?php echo $__env->make('student.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <!-- Main Content -->
                <div class="main-dashboard-content flex-grow-1">
                    <div class="main-dashboard-inner">
                        <div class="container py-1">

                            <!-- Hero Section -->
                            <div class="appointments-hero d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="title mb-1">
                                        <i class="bi bi-star-fill me-2"></i>Completed Sessions & Feedback
                                    </div>
                                    <div class="opacity-75 small">Review your completed session history and provide feedback</div>
                                </div>
                                <!-- Keeping logic simple: no big button here needed, or maybe back to dashboard? -->
                                <!-- User already has sidebar, so back button is less critical, but good for UX -->
                            </div>

                            <?php if(session('success')): ?>
                                <div class="alert alert-success mb-4 rounded-3 shadow-sm border-0"><?php echo e(session('success')); ?></div>
                            <?php endif; ?>

                            <?php if($completedAppointments->count() > 0): ?>
                                <div class="row g-4">
                                    <?php $__currentLoopData = $completedAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-12">
                                            <div class="appointment-card">
                                                <div class="appointment-header d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <?php if($appointment->counselor->avatar): ?>
                                                            <img src="<?php echo e($appointment->counselor->avatar_url); ?>" alt="<?php echo e($appointment->counselor->name); ?>" class="counselor-avatar">
                                                        <?php else: ?>
                                                            <div class="counselor-avatar d-flex align-items-center justify-content-center bg-success text-white">
                                                                <?php echo e(strtoupper(substr($appointment->counselor->name ?? 'C', 0, 1))); ?>

                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold"><?php echo e($appointment->counselor->name ?? 'Counselor'); ?></h6>
                                                            <div class="small opacity-75">Counseling Session</div>
                                                        </div>
                                                    </div>
                                                    <span class="badge bg-success rounded-pill px-3 py-2">Completed</span>
                                                </div>

                                                <div class="appointment-body">
                                                    <div class="row mb-4">
                                                        <div class="col-md-6 mb-2">
                                                            <div class="d-flex align-items-center text-muted">
                                                                <i class="bi bi-calendar-event me-2"></i>
                                                                <span class="fw-medium text-dark"><?php echo e($appointment->scheduled_at->format('F j, Y')); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <div class="d-flex align-items-center text-muted">
                                                                <i class="bi bi-clock me-2"></i>
                                                                <span><?php echo e($appointment->scheduled_at->format('g:i A')); ?> - <?php echo e($appointment->scheduled_at->addMinutes(30)->format('g:i A')); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Session Notes -->
                                                    <?php $__currentLoopData = $appointment->sessionNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sessionNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="session-note">
                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                <h6 class="fw-bold text-success mb-0">
                                                                    <i class="bi bi-journal-text me-2"></i>Session Note #<?php echo e($sessionNote->id); ?>

                                                                </h6>
                                                                <small class="text-muted"><?php echo e($sessionNote->created_at->format('M j, g:i A')); ?></small>
                                                            </div>

                                                            <?php if($sessionNote->content): ?>
                                                                <div class="mb-3">
                                                                    <div class="bg-white p-3 rounded border">
                                                                        <?php if(auth()->check() && auth()->user()->role === 'counselor'): ?>
                                                                            <?php echo nl2br(e($sessionNote->content)); ?>

                                                                        <?php else: ?>
                                                                            <div class="text-muted fst-italic">Private note — visible only to your counselor.</div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>

                                                            <?php if($sessionNote->recommendations): ?>
                                                                <div class="alert alert-light border">
                                                                    <strong>Recommendations:</strong>
                                                                    <div class="mt-1"><?php echo nl2br(e($sessionNote->recommendations)); ?></div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <!-- Feedback Section -->
                                                    <?php
                                                        $existingFeedback = \App\Models\SessionFeedback::where('appointment_id', $appointment->id)->first();
                                                    ?>
                                                    <div class="feedback-section">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-1 fw-bold">
                                                                    <i class="bi bi-star me-2 text-warning"></i>Session Feedback
                                                                </h6>
                                                                <?php if($existingFeedback): ?>
                                                                    <div class="d-flex align-items-center gap-2 mt-2">
                                                                        <div class="d-flex">
                                                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                                                <i class="bi bi-star<?php echo e($i <= $existingFeedback->rating ? '-fill' : ''); ?> text-warning"></i>
                                                                            <?php endfor; ?>
                                                                        </div>
                                                                        <span class="text-muted small">(<?php echo e($existingFeedback->rating); ?>/5)</span>
                                                                    </div>
                                                                    <p class="mb-0 text-muted small mt-1"><?php echo e(Str::limit($existingFeedback->comments, 100)); ?></p>
                                                                <?php else: ?>
                                                                    <p class="mb-0 text-muted small">How was your session? Let us know.</p>
                                                                <?php endif; ?>
                                                            </div>

                                                            <?php if(!$existingFeedback): ?>
                                                                <a href="<?php echo e(route('session-feedback.create', $appointment->id)); ?>" class="btn btn-outline-success btn-sm rounded-pill px-4">
                                                                    Provide Feedback
                                                                </a>
                                                            <?php else: ?>
                                                                <span class="badge bg-light text-success border border-success rounded-pill px-3">
                                                                    <i class="bi bi-check-circle me-1"></i>Submitted
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <div class="mb-3">
                                        <i class="bi bi-journal-x" style="font-size: 3rem; color: #d1d5db;"></i>
                                    </div>
                                    <h4 class="fw-bold text-secondary">No Completed Sessions Yet</h4>
                                    <p class="text-muted">You don't have any completed counseling sessions yet.</p>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/appointments/completed-with-notes.blade.php ENDPATH**/ ?>