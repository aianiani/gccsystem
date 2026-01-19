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

        /* Apply page zoom consistent with other counselor pages */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        body,
        .session-note-detail-page {
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

        .session-card {
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            border: 1px solid rgba(31, 122, 45, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .session-card:hover {
            box-shadow: var(--shadow-lg);
        }

        .meta-label {
            color: var(--forest-green);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .note-body {
            min-height: 180px;
            font-size: 1rem;
            line-height: 1.6;
            background: var(--gray-50) !important;
            border: 1px solid var(--gray-100) !important;
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
                <div class="session-note-detail-page" style="max-width:100%; margin: 0 auto; padding: 0 1rem;">

                    <?php
                        $student = $note->appointment->student ?? null;
                        $appointment = $note->appointment ?? null;
                        $counselorName = optional($note->counselor)->name ?? optional($note->appointment->counselor)->name ?? 'Counselor';
                        $avatar = $student->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($student->name ?? 'Student') . '&background=1f7a2d&color=fff');
                    ?>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <a href="<?php echo e(route('counselor.session_notes.index')); ?>" class="btn btn-outline-secondary"><i
                                    class="bi bi-arrow-left me-1"></i> Back</a>
                            <h2 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: var(--forest-green);"><i
                                    class="bi bi-journal-text"></i> Session Note</h2>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('counselor.session_notes.edit', $note->id)); ?>"
                                class="btn btn-outline-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
                        </div>
                    </div>

                    <div class="page-hero mb-4">
                        <div class="page-hero-grid">
                            <img src="<?php echo e($avatar); ?>" alt="Avatar" class="hero-avatar">
                            <div class="text-white">
                                <div class="fw-bold" style="font-size:1.15rem"><?php echo e($student->name ?? 'N/A'); ?></div>
                                <div class="small"><?php echo e($student->email ?? ''); ?></div>
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
                            <div class="hero-right text-end text-white small">
                                <div class="d-flex flex-column align-items-end justify-content-center">
                                    <div class="mb-1"><i class="bi bi-calendar-event me-1"></i>
                                        <?php echo e(optional($appointment->scheduled_at)->format('F j, Y') ?? '-'); ?></div>
                                    <div class="mb-2"><i class="bi bi-clock me-1"></i>
                                        <?php echo e(optional($appointment->scheduled_at)->format('g:i A') ?? '-'); ?></div>
                                    <div><span
                                            class="badge bg-light text-dark"><?php echo e(ucfirst($appointment->status ?? 'N/A')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card session-card mb-4 p-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="meta-label">Session</div>
                                        <div class="fw-bold">#<?php echo e($note->session_number ?? '-'); ?></div>
                                    </div>
                                    <div class="text-muted small">Created:
                                        <?php echo e($note->created_at ? $note->created_at->format('F j, Y g:i A') : '-'); ?>

                                    </div>
                                </div>

                                <div class="meta-label mb-2">Counselor</div>
                                <div class="mb-3"><?php echo e($counselorName); ?></div>

                                <div class="meta-label">Session Note</div>
                                <div class="bg-light p-3 rounded border note-body">
                                    <?php echo nl2br(e($note->note)); ?>

                                </div>

                                <div class="mt-3 d-flex gap-2">
                                    <?php
                                        $hasNextAppointment = \App\Models\Appointment::where('counselor_id', $note->counselor_id)
                                            ->where('student_id', $note->appointment->student_id)
                                            ->where('scheduled_at', $note->next_session)
                                            ->exists();
                                    ?>
                                    <?php if($note->next_session && !$hasNextAppointment): ?>
                                        <form action="<?php echo e(route('counselor.session_notes.create_next_appointment', $note->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-outline-success"><i
                                                    class="bi bi-calendar-plus me-1"></i>Create Next Appointment</button>
                                        </form>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('counselor.session_notes.remind', $note->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-info"><i class="bi bi-bell me-1"></i>Send
                                            Reminder</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card session-card p-3 mb-4">
                                <div class="meta-label">Appointment Details</div>
                                <div class="mt-2 small text-muted">Scheduled</div>
                                <div class="fw-medium">
                                    <?php echo e(optional($appointment->scheduled_at)->format('F j, Y \a\t g:i A') ?? '-'); ?>

                                </div>
                                <hr>
                                <div class="meta-label">Nature of Problem</div>
                                <div class="small text-muted"><?php echo e($appointment->nature_of_problem ?? 'N/A'); ?></div>
                                <hr>
                                <div class="meta-label">Next Session</div>
                                <div class="small">
                                    <?php echo e($note->next_session ? \Carbon\Carbon::parse($note->next_session)->format('F j, Y g:i A') : 'Not scheduled'); ?>

                                </div>
                                <hr>
                                <div class="meta-label">Last Updated</div>
                                <div class="small"><?php echo e($note->updated_at ? $note->updated_at->diffForHumans() : '-'); ?></div>
                            </div>

                            <div class="card session-card p-3">
                                <div class="meta-label">Quick Actions</div>
                                <div class="d-flex flex-column mt-2 gap-2">
                                    <a href="<?php echo e(route('counselor.appointments.show', $appointment->id)); ?>"
                                        class="btn btn-outline-primary">View Appointment</a>
                                    <a href="<?php echo e(route('counselor.session_notes.index')); ?>"
                                        class="btn btn-outline-secondary">All Session Notes</a>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/session_notes/show.blade.php ENDPATH**/ ?>