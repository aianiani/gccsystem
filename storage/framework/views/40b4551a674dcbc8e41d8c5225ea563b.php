<?php $__env->startSection('content'); ?>
<?php $__env->startSection('full_width', true); ?>
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

        /* Appointments Page Custom Styles */
        .main-dashboard-content {
            margin-left: 280px !important;
            padding: 2rem;
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            width: auto !important;
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 0 !important;
            }

            .custom-sidebar {
                transform: translateX(-100%);
            }

            .custom-sidebar.show {
                transform: translateX(0) !important;
                z-index: 1100;
                visibility: visible;
            }
        }

        /* Constrain inner content and center it within the available area */
        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="studentSidebarToggle" class="d-lg-none">
                <i class="bi bi-list"></i>
            </button>
            <!-- Sidebar -->
            <?php echo $__env->make('student.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="container-fluid px-4 py-4">
                        <style>
                            /* Modern Appointments Theme */
                            .page-header {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                margin-bottom: 2rem;
                                padding-bottom: 1rem;
                                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                            }

                            .page-title {
                                font-size: 1.75rem;
                                font-weight: 700;
                                color: var(--text-dark);
                                margin-bottom: 0;
                                display: flex;
                                align-items: center;
                                gap: 0.75rem;
                            }

                            .page-title i {
                                color: var(--forest-green);
                                background: rgba(31, 122, 45, 0.1);
                                width: 48px;
                                height: 48px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                border-radius: 12px;
                                font-size: 1.5rem;
                            }

                            .stats-pill {
                                background: var(--light-green);
                                color: var(--forest-green);
                                font-size: 0.9rem;
                                font-weight: 600;
                                padding: 0.5rem 1rem;
                                border-radius: 100px;
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                            }

                            /* Modern Card Design */
                            .appointment-card {
                                background: #fff;
                                border: 1px solid rgba(0, 0, 0, 0.04);
                                border-radius: 16px;
                                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
                                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                                overflow: hidden;
                                height: 100%;
                                position: relative;
                            }

                            .appointment-card:hover {
                                transform: translateY(-5px);
                                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
                                border-color: rgba(31, 122, 45, 0.1);
                            }

                            .appointment-card::before {
                                content: '';
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 4px;
                                height: 100%;
                                background: var(--bg-light);
                                transition: background 0.3s;
                            }

                            .appointment-card.status-pending::before {
                                background: var(--warning);
                            }

                            .appointment-card.status-accepted::before {
                                background: var(--success);
                            }

                            .appointment-card.status-completed::before {
                                background: var(--primary-green);
                            }

                            .appointment-card.status-declined::before {
                                background: var(--danger);
                            }

                            .appointment-card.status-rescheduled::before {
                                background: var(--info);
                            }

                            .card-header-styled {
                                padding: 1.25rem 1.5rem;
                                border-bottom: 1px solid rgba(0, 0, 0, 0.03);
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                background: #fff;
                            }

                            .counselor-info {
                                display: flex;
                                align-items: center;
                                gap: 1rem;
                            }

                            .counselor-avatar {
                                width: 48px;
                                height: 48px;
                                border-radius: 12px;
                                object-fit: cover;
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
                            }

                            .counselor-details h5 {
                                font-size: 1rem;
                                font-weight: 700;
                                margin: 0;
                                color: var(--text-dark);
                            }

                            .counselor-details span {
                                font-size: 0.85rem;
                                color: var(--text-light);
                            }

                            .card-body-styled {
                                padding: 1.5rem;
                            }

                            .time-badge {
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                                background: var(--bg-light);
                                color: var(--text-dark);
                                font-weight: 600;
                                padding: 0.6rem 1rem;
                                border-radius: 8px;
                                margin-bottom: 1rem;
                                font-size: 0.95rem;
                                width: 100%;
                            }

                            .time-badge i {
                                color: var(--forest-green);
                            }

                            .status-badge-styled {
                                font-size: 0.85rem;
                                font-weight: 600;
                                padding: 0.4rem 0.85rem;
                                border-radius: 6px;
                                display: inline-block;
                            }

                            .bg-status-pending {
                                background: #fff8e1;
                                color: #b78900;
                            }

                            .bg-status-accepted {
                                background: #e8f5e9;
                                color: #2e7d32;
                            }

                            .bg-status-completed {
                                background: #e3f2fd;
                                color: #1565c0;
                            }

                            .bg-status-declined {
                                background: #ffebee;
                                color: #c62828;
                            }

                            .bg-status-rescheduled {
                                background: #e0f7fa;
                                color: #00838f;
                            }

                            .btn-book-new {
                                background: var(--forest-green);
                                color: white;
                                padding: 0.75rem 1.5rem;
                                border-radius: 12px;
                                font-weight: 600;
                                border: none;
                                box-shadow: 0 4px 15px rgba(31, 122, 45, 0.2);
                                transition: all 0.3s;
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                                text-decoration: none;
                            }

                            .btn-book-new:hover {
                                background: var(--forest-green-dark);
                                transform: translateY(-2px);
                                box-shadow: 0 8px 20px rgba(31, 122, 45, 0.3);
                                color: white;
                            }

                            .session-indicator {
                                position: absolute;
                                top: 1.25rem;
                                right: 1.25rem;
                                font-size: 0.7rem;
                                font-weight: 800;
                                text-transform: uppercase;
                                letter-spacing: 0.8px;
                                color: var(--forest-green);
                                background: var(--light-green);
                                padding: 0.35rem 0.75rem;
                                border-radius: 6px;
                                border: 1px solid rgba(31, 122, 45, 0.1);
                            }

                            @media (max-width: 576px) {
                                .page-header {
                                    text-align: center;
                                    flex-direction: column;
                                    gap: 1.5rem;
                                    margin-bottom: 2rem;
                                }

                                .page-title {
                                    justify-content: center;
                                    font-size: 1.5rem;
                                }

                                .appointment-card {
                                    border-radius: 20px;
                                }

                                .card-header-styled {
                                    padding: 1.25rem;
                                    flex-direction: column;
                                    align-items: center;
                                    text-align: center;
                                    gap: 1rem;
                                }

                                .counselor-info {
                                    flex-direction: column;
                                    gap: 0.75rem;
                                }

                                .session-indicator {
                                    position: static;
                                    margin-top: 0.25rem;
                                }

                                .card-body-styled {
                                    padding: 1.25rem;
                                }

                                .time-badge {
                                    padding: 0.75rem;
                                    justify-content: center;
                                }
                            }
                        </style>

                        <div class="page-header flex-wrap gap-3">
                            <div>
                                <h1 class="page-title">
                                    <i class="bi bi-calendar-check-fill"></i>
                                    My Appointments
                                </h1>
                                <p class="text-muted mt-2 mb-0 ms-1">Manage your counseling sessions and feedback.</p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="stats-pill d-none d-md-flex">
                                    <i class="bi bi-graph-up"></i>
                                    <?php echo e(count($appointments)); ?> Total
                                </div>
                                <a href="#" class="btn-book-new w-100 justify-content-center js-book-appointment-trigger">
                                    <i class="bi bi-plus-lg"></i>
                                    <span>Book Appointment</span>
                                </a>

                            </div>
                        </div>

                        <?php if(session('success')): ?>
                            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill fs-5 me-3"></i>
                                <div class="fw-medium"><?php echo e(session('success')); ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if(count($appointments)): ?>
                            <div class="row g-4">
                                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $start = $appointment->scheduled_at;
                                        $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                                            ->where('start', $start)
                                            ->first();
                                        $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);

                                        $statusClass = 'status-pending';
                                        if ($appointment->status === 'accepted')
                                            $statusClass = 'status-accepted';
                                        elseif ($appointment->status === 'completed')
                                            $statusClass = 'status-completed';
                                        elseif ($appointment->status === 'declined' || $appointment->status === 'cancelled')
                                            $statusClass = 'status-declined';
                                        elseif ($appointment->status === 'rescheduled_pending')
                                            $statusClass = 'status-rescheduled';

                                        $sessionNoteForThisAppointment = $appointment->sessionNotes->first();
                                    ?>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="appointment-card <?php echo e($statusClass); ?>">
                                            <div class="card-header-styled">
                                                <div class="counselor-info">
                                                    <img src="<?php echo e($appointment->counselor->avatar_url); ?>"
                                                        alt="<?php echo e($appointment->counselor->name); ?>" class="counselor-avatar">
                                                    <div class="counselor-details">
                                                        <h5><?php echo e($appointment->counselor->name ?? 'Unknown Counselor'); ?></h5>
                                                        <span>Counselor</span>
                                                    </div>
                                                </div>
                                                <?php if($sessionNoteForThisAppointment): ?>
                                                    <div class="session-indicator">Session
                                                        <?php echo e($sessionNoteForThisAppointment->session_number); ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body-styled">
                                                <div class="time-badge">
                                                    <i class="bi bi-clock-history"></i>
                                                    <?php echo e($start->format('M d, Y')); ?> • <?php echo e($start->format('g:i A')); ?>

                                                </div>

                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <span class="text-muted small fw-bold text-uppercase">Status</span>
                                                    <?php if($appointment->status === 'pending'): ?>
                                                        <span class="status-badge-styled bg-status-pending"><i
                                                                class="bi bi-hourglass-split me-1"></i>Pending</span>
                                                    <?php elseif($appointment->status === 'accepted'): ?>
                                                        <span class="status-badge-styled bg-status-accepted"><i
                                                                class="bi bi-check-circle me-1"></i>Approved</span>
                                                    <?php elseif($appointment->status === 'completed'): ?>
                                                        <span class="status-badge-styled bg-status-completed"><i
                                                                class="bi bi-check-all me-1"></i>Completed</span>
                                                    <?php elseif($appointment->status === 'declined'): ?>
                                                        <span class="status-badge-styled bg-status-declined"><i
                                                                class="bi bi-x-circle me-1"></i>Declined</span>
                                                    <?php elseif($appointment->status === 'rescheduled_pending'): ?>
                                                        <span class="status-badge-styled bg-status-rescheduled"><i
                                                                class="bi bi-arrow-repeat me-1"></i>Rescheduled</span>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="message-box p-3 rounded-3 bg-light border border-light">
                                                    <?php if($appointment->status === 'accepted'): ?>
                                                        <div class="d-flex gap-2">
                                                            <i class="bi bi-info-circle text-success mt-1"></i>
                                                            <small class="text-success fw-medium">Confirmed. Please proceed to GCC on
                                                                schedule.</small>
                                                        </div>
                                                    <?php elseif($appointment->status === 'completed'): ?>
                                                        <div class="d-flex gap-2">
                                                            <i class="bi bi-journal-check text-primary mt-1"></i>
                                                            <div>
                                                                <small class="text-primary fw-medium d-block">Session completed.</small>
                                                                <?php if($appointment->sessionNotes->count() > 0): ?>
                                                                    <a href="<?php echo e(route('appointments.completedWithNotes')); ?>"
                                                                        class="text-primary small text-decoration-underline mt-1 d-block">View
                                                                        Session Notes</a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php elseif($appointment->status === 'rescheduled_pending'): ?>
                                                        <div class="mb-2">
                                                            <small class="text-info fw-bold d-block mb-2">New time proposed:</small>
                                                            <div class="d-flex gap-2">
                                                                <form
                                                                    action="<?php echo e(route('appointments.acceptReschedule', $appointment->id)); ?>"
                                                                    method="POST">
                                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                                    <button type="submit" class="btn btn-success btn-sm py-1 px-3"
                                                                        style="font-size: 0.8rem;">Approve</button>
                                                                </form>
                                                                <form
                                                                    action="<?php echo e(route('appointments.declineReschedule', $appointment->id)); ?>"
                                                                    method="POST">
                                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                                    <button type="submit"
                                                                        class="btn btn-outline-danger btn-sm py-1 px-3"
                                                                        style="font-size: 0.8rem;">Decline</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    <?php elseif($appointment->notes): ?>
                                                        <div class="d-flex gap-2">
                                                            <i class="bi bi-sticky text-muted mt-1"></i>
                                                            <small
                                                                class="text-muted module-text"><?php echo e(Str::limit($appointment->notes, 80)); ?></small>
                                                        </div>
                                                    <?php else: ?>
                                                        <small class="text-muted fst-italic">No additional notes.</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <div
                                        style="width: 80px; height: 80px; background: var(--light-green); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-calendar-range text-success" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark">No Appointments Yet</h3>
                                <p class="text-muted mb-4">You haven't booked any counseling sessions yet.<br>We're here to
                                    listen whenever you're ready.</p>
                                    <a href="#" class="btn-book-new px-4 py-2 js-book-appointment-trigger">
                                        Start Your Journey
                                    </a>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DASS-42 reminder modal -->
    <div class="modal fade" id="dassReminderModal" tabindex="-1" aria-labelledby="dassReminderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered dass-modal">
            <div class="modal-content">
                <style>
                    .dass-modal .modal-content {
                        border: none;
                        border-radius: 16px;
                        overflow: hidden;
                        box-shadow: var(--shadow-lg);
                    }
                    .dass-modal-header {
                        background: var(--hero-gradient);
                        padding: 1.25rem 1.5rem;
                        color: white !important;
                    }
                    .dass-modal-icon {
                        width: 42px;
                        height: 42px;
                        background: rgba(255, 255, 255, 0.15);
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.25rem;
                        color: white;
                    }
                    .dass-modal-title {
                        font-weight: 700;
                        font-size: 1.1rem;
                        color: white !important;
                        margin-bottom: 0.1rem;
                    }
                    .dass-modal-body {
                        padding: 1.5rem;
                    }
                    .dass-modal-footer {
                        padding: 1rem 1.5rem;
                        background: #f9fafb;
                        border-top: 1px solid rgba(0,0,0,0.05);
                        display: flex;
                        justify-content: flex-end;
                        gap: 0.75rem;
                    }
                    .btn-dass-later {
                        background: #fff;
                        border: 1px solid #e2e8f0;
                        color: #64748b;
                        font-weight: 600;
                        font-size: 0.9rem;
                        padding: 0.5rem 1.25rem;
                        border-radius: 8px;
                        transition: all 0.2s;
                    }
                    .btn-dass-later:hover {
                        background: #f8fafc;
                        color: #1e293b;
                        border-color: #cbd5e1;
                    }
                    .btn-dass-primary {
                        background: var(--forest-green);
                        color: #white;
                        font-weight: 600;
                        font-size: 0.9rem;
                        padding: 0.5rem 1.5rem;
                        border-radius: 8px;
                        border: none;
                        box-shadow: 0 4px 12px rgba(31, 122, 45, 0.2);
                        transition: all 0.2s;
                    }
                    .btn-dass-primary:hover {
                        background: var(--forest-green-dark);
                        transform: translateY(-1px);
                        box-shadow: 0 6px 15px rgba(31, 122, 45, 0.3);
                        color: white;
                    }
                    .dass-info-box {
                        display: flex;
                        gap: 0.75rem;
                        background: #f1f5f9;
                        padding: 1rem;
                        border-radius: 12px;
                        font-size: 0.875rem;
                        color: #475569;
                    }
                </style>
                <div class="dass-modal-header position-relative">
                    <div class="d-flex align-items-start gap-3 w-100">
                        <div class="dass-modal-icon flex-shrink-0">
                            <i class="bi bi-clipboard-heart"></i>
                        </div>
                        <div class="flex-grow-1 pt-1">
                            <h5 class="dass-modal-title mb-1">Complete the DASS-42 Assessment</h5>
                            <p class="mb-0 text-white-50 small">This helps counselors tailor your session</p>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="dass-modal-body">
                    <p class="mb-3" style="font-size: 0.95rem; line-height: 1.6; color: var(--text-dark);">
                        Prior to booking, students are required to complete the DASS-42 assessment to help counselors support you effectively.
                    </p>
                    <div class="dass-info-box">
                        <i class="bi bi-info-circle-fill mt-0.5 text-primary opacity-75"></i>
                        <span>Once finished, you can proceed with booking your appointment immediately.</span>
                    </div>
                </div>
                <div class="dass-modal-footer">
                    <button type="button" class="btn-dass-later" data-bs-dismiss="modal">Maybe Later</button>
                    <a href="<?php echo e(route('consent.show', ['context' => 'booking'])); ?>" class="btn-dass-primary">
                        Proceed to Assessment
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gate appointment booking behind DASS-42 modal
            const dassModalElement = document.getElementById('dassReminderModal');
            if (dassModalElement) {
                const dassModal = new bootstrap.Modal(dassModalElement);
                document.querySelectorAll('.js-book-appointment-trigger').forEach(function (trigger) {
                    trigger.addEventListener('click', function (event) {
                        event.preventDefault();
                        dassModal.show();
                    });
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/appointments/index.blade.php ENDPATH**/ ?>