

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
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply 75% zoom consistent with other counselor pages */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        /* Tighter hero layout using grid to utilize horizontal space */
        .page-hero {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
            color: #fff;
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            box-shadow: var(--shadow-lg);
            margin-bottom: 1.5rem;
        }

        .page-hero-grid {
            display: grid;
            grid-template-columns: 88px 1fr auto;
            gap: 1.25rem;
            align-items: center;
        }

        .hero-avatar {
            width: 88px;
            height: 88px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.25);
        }

        .hero-meta {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .hero-meta i {
            font-size: 1rem;
            opacity: 0.95;
        }

        .hero-right {
            min-width: 160px;
        }

        .hero-right .badge {
            border-radius: 999px;
            padding: 0.5rem 0.9rem;
        }

        .timeline-card {
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            background: white;
            border: 1px solid rgba(31, 122, 45, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .timeline-card:hover {
            box-shadow: var(--shadow-lg);
        }

        .timeline-entry {
            border-left: 3px solid rgba(31, 122, 45, 0.15);
            padding-left: 1.25rem;
            margin-left: 0.75rem;
        }

        .timeline-item {
            padding: 1.25rem;
            background: var(--gray-50);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
        }

        .timeline-item:hover {
            background: white;
            transform: translateX(3px);
        }

        .timeline-meta {
            font-size: 0.9rem;
            color: var(--gray-600);
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

            .page-hero-grid {
                grid-template-columns: 72px 1fr;
            }

            .hero-right {
                display: none;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <?php echo $__env->make('counselor.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="main-dashboard-content flex-grow-1">
                <div style="max-width:100%; margin: 0 auto; padding: 0 1rem;">

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <a href="<?php echo e(route('counselor.session_notes.index')); ?>" class="btn btn-outline-secondary"><i
                                    class="bi bi-arrow-left me-1"></i> Back</a>
                            <h2 class="mb-0 fw-bold d-flex align-items-center gap-2" style="color: var(--forest-green);"><i
                                    class="bi bi-clock-history"></i> Session History Timeline</h2>
                        </div>
                    </div>

                    <?php if($student): ?>
                        <div class="page-hero mb-4">
                            <div class="page-hero-grid">
                                <img src="<?php echo e($student->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=1f7a2d&color=fff')); ?>"
                                    alt="Avatar" class="hero-avatar">
                                <div class="text-white">
                                    <div class="fw-bold" style="font-size:1.15rem"><?php echo e($student->name); ?></div>
                                    <div class="small"><?php echo e($student->email); ?></div>
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        <div class="hero-meta small"><i
                                                class="bi bi-telephone"></i><span><?php echo e($student->contact_number ?? 'N/A'); ?></span>
                                        </div>
                                        <div class="hero-meta small"><i
                                                class="bi bi-building"></i><span><?php echo e($student->college ?? 'N/A'); ?></span></div>
                                        <div class="hero-meta small"><i
                                                class="bi bi-mortarboard"></i><span><?php echo e($student->course ?? 'N/A'); ?></span></div>
                                        <div class="hero-meta small"><i
                                                class="bi bi-calendar-check"></i><span><?php echo e($student->year_level ?? 'N/A'); ?></span>
                                        </div>
                                        <div class="hero-meta small"><i
                                                class="bi bi-person-badge"></i><span><?php echo e($student->student_id ?? 'N/A'); ?></span>
                                        </div>
                                        <div class="hero-meta small"><i
                                                class="bi bi-gender-ambiguous"></i><span><?php echo e($student->gender ? ucfirst($student->gender) : 'N/A'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="hero-right text-end text-white">
                                    <div class="d-flex flex-column align-items-end justify-content-center">
                                        <div class="small opacity-75 mb-1">Total Sessions</div>
                                        <div class="display-5 fw-bold lh-1"><?php echo e($sessionNotes->count()); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                    <div class="timeline-card p-3">
                        <?php if($sessionNotes->count()): ?>
                            <div class="d-flex flex-column gap-3">
                                <?php $__currentLoopData = $sessionNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $status = $note->session_status;
                                        $statusMap = [
                                            'scheduled' => ['label' => 'Scheduled', 'class' => 'bg-info text-dark', 'icon' => 'calendar-event'],
                                            'completed' => ['label' => 'Completed', 'class' => 'bg-success', 'icon' => 'check-circle'],
                                            'missed' => ['label' => 'Missed', 'class' => 'bg-warning text-dark', 'icon' => 'clock'],
                                            'expired' => ['label' => 'Expired', 'class' => 'bg-danger', 'icon' => 'exclamation-triangle'],
                                        ];
                                    ?>
                                    <div class="timeline-entry">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="flex-shrink-0 text-center" style="width:72px;">
                                                <div class="small text-muted"><?php echo e($note->appointment->scheduled_at->format('M j')); ?>

                                                </div>
                                                <div class="fw-bold"><?php echo e($note->appointment->scheduled_at->format('g:i A')); ?></div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="fw-semibold">Session <?php echo e($note->session_number); ?></div>
                                                    <div>
                                                        <?php if(isset($statusMap[$status])): ?>
                                                            <span
                                                                class="badge <?php echo e($statusMap[$status]['class']); ?> d-inline-flex align-items-center gap-1 px-3 py-2"
                                                                style="font-size: 0.85rem;">
                                                                <i class="bi bi-<?php echo e($statusMap[$status]['icon']); ?>"></i>
                                                                <?php echo e($statusMap[$status]['label']); ?>

                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">N/A</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="mb-2 timeline-meta"><strong>Counselor:</strong>
                                                        <?php echo e(optional($note->counselor)->name ?? 'N/A'); ?></div>
                                                    <div class="mb-2"><?php echo nl2br(e($note->note)); ?></div>
                                                    <?php if($note->attendance === 'missed' && $note->absence_reason): ?>
                                                        <div class="text-danger small mt-2"><strong>Absence Reason:</strong>
                                                            <?php echo e($note->absence_reason); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="p-3">No session notes found for this student.</div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4">
                        <a href="<?php echo e(route('counselor.session_notes.index')); ?>" class="btn btn-outline-secondary"><i
                                class="bi bi-arrow-left me-1"></i> Back to Session Notes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/session_notes/timeline.blade.php ENDPATH**/ ?>