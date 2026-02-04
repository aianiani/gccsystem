<?php $__env->startSection('content'); ?>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* Apply page zoom */
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
            background-color: var(--bg-light);
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
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header Styles */
        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: var(--hero-gradient);
            padding: 1.5rem 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            color: #fff;
        }

        .header-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-meta {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        /* Card Styles matching Index */
        .content-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-lighter);
        }

        .card-title-styled {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--forest-green-lighter);
        }

        /* Highlighted Notes Card */
        .notes-card {
            background: var(--yellow-maize-light);
            border: 1px solid var(--yellow-maize);
        }

        .notes-card .card-title-styled {
            border-bottom-color: var(--yellow-maize);
            color: #b78900;
        }

        /* Info Rows */
        .info-group {
            margin-bottom: 1rem;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        /* Avatar & Profile */
        .student-profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .student-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid var(--forest-green);
            padding: 3px;
            background: #fff;
            object-fit: cover;
            margin-bottom: 0.75rem;
            box-shadow: var(--shadow-sm);
        }

        /* Status Badges */
        .status-badge-lg {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge-pending {
            background: var(--warning);
            color: #856404;
        }

        .badge-accepted {
            background: var(--success);
            color: #fff;
        }

        .badge-completed {
            background: var(--primary-green);
            color: #fff;
        }

        .badge-cancelled {
            background: var(--danger);
            color: #fff;
        }

        /* Buttons */
        .btn-action {
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-success {
            background-color: var(--success);
            border-color: var(--success);
        }

        .btn-primary {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
        }

        .btn-primary:hover {
            background-color: var(--forest-green-dark);
            border-color: var(--forest-green-dark);
        }

        .btn-outline-primary {
            color: var(--forest-green);
            border-color: var(--forest-green);
        }

        .btn-outline-primary:hover {
            background-color: var(--forest-green);
            color: #fff;
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

            /* Off-canvas behavior on mobile */
            .custom-sidebar {
                position: fixed;
                z-index: 1040;
                height: 100vh;
                left: 0;
                top: 0;
                width: 240px;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
                flex-direction: column;
                padding: 0;
            }

            .custom-sidebar.show {
                transform: translateX(0);
            }
        }

        /* Privacy Blur */
        .privacy-blur {
            filter: blur(8px);
            user-select: none;
            pointer-events: none;
            transition: all 0.5s ease;
        }

        .privacy-revealed {
            filter: blur(0);
            user-select: auto;
            pointer-events: auto;
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none"
                style="position: fixed; top: 1rem; left: 1rem; z-index: 1100; background: var(--forest-green); color: #fff; border: none; border-radius: 8px; padding: 0.5rem 0.75rem;">
                <i class="bi bi-list"></i>
            </button>

            <!-- Sidebar -->
            <?php echo $__env->make('counselor.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <a href="<?php echo e(route('counselor.appointments.index')); ?>"
                        class="btn btn-link text-muted mb-3 px-0 text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Back to Appointments
                    </a>

                    <!-- Header -->
                    <div class="details-header">
                        <div class="header-title">
                            <h1>
                                <i class="bi bi-calendar-event-fill text-white"></i>
                                Appointment Details
                            </h1>
                            <div class="header-meta">
                                Reference: <span
                                    class="font-monospace text-white"><?php echo e($appointment->reference_number); ?></span> •
                                Session #<?php echo e($appointment->session_number); ?>

                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <?php
                                $statusClass = 'badge-pending';
                                if ($appointment->status === 'accepted')
                                    $statusClass = 'badge-accepted';
                                elseif ($appointment->status === 'completed')
                                    $statusClass = 'badge-completed';
                                elseif ($appointment->status === 'declined' || $appointment->status === 'cancelled')
                                    $statusClass = 'badge-cancelled';
                            ?>
                            <span class="status-badge-lg <?php echo e($statusClass); ?>">
                                <i class="bi bi-info-circle"></i>
                                <?php echo e($appointment->status === 'accepted' ? 'Approved' : ucfirst(str_replace('_', ' ', $appointment->status))); ?>

                            </span>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Main Content (Full Width) -->
                        <div class="col-12">
                            <!-- Actions Card -->
                            <div class="content-card mb-4">
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="fw-bold text-dark">Actions</div>
                                        <button id="privacyToggleBtn" class="btn btn-sm btn-outline-secondary"
                                            title="Toggle Privacy">
                                            <i class="bi bi-eye-slash-fill" id="privacyIcon"></i> Toggle Details
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <?php if($appointment->status === 'pending'): ?>
                                            <form method="POST"
                                                action="<?php echo e(route('counselor.appointments.accept', $appointment->id)); ?>"
                                                data-confirm="Approve this appointment?">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                <button class="btn btn-success btn-action"><i class="bi bi-check-lg"></i>
                                                    Approve</button>
                                            </form>
                                            <a href="<?php echo e(route('counselor.appointments.reschedule', $appointment->id)); ?>"
                                                class="btn btn-warning btn-action text-dark">
                                                <i class="bi bi-clock-history"></i> Reschedule
                                            </a>
                                            <form method="POST"
                                                action="<?php echo e(route('counselor.appointments.decline', $appointment->id)); ?>"
                                                data-confirm="Decline this appointment?">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                <button class="btn btn-outline-danger btn-action"><i class="bi bi-x-lg"></i>
                                                    Decline</button>
                                            </form>
                                        <?php elseif($appointment->status === 'accepted'): ?>
                                            <form method="POST"
                                                action="<?php echo e(route('counselor.appointments.complete', $appointment->id)); ?>"
                                                data-confirm="Mark as complete?">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                <button class="btn btn-primary btn-action"><i class="bi bi-check2-square"></i>
                                                    Mark Complete</button>
                                            </form>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('chat.index', $appointment->student->id)); ?>"
                                            class="btn btn-outline-primary btn-action">
                                            <i class="bi bi-chat-dots"></i> Chat
                                        </a>
                                        <a href="<?php echo e(route('appointments.downloadPdf', $appointment->id)); ?>"
                                            class="btn btn-outline-danger btn-action" target="_blank">
                                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                                        </a>

                                        <!-- Session Note Button -->
                                        <?php if($appointment->status === 'accepted' || $appointment->status === 'completed'): ?>
                                            <?php
                                                $existingNote = $appointment->sessionNotes()->first();
                                            ?>
                                            <?php if($existingNote): ?>
                                                <a href="<?php echo e(route('counselor.session_notes.show', $existingNote->id)); ?>"
                                                    class="btn btn-outline-warning btn-action text-dark">
                                                    <i class="bi bi-journal-text"></i> View Note
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('counselor.session_notes.create', $appointment->id)); ?>"
                                                    class="btn btn-warning btn-action text-dark">
                                                    <i class="bi bi-journal-plus"></i> Add Note
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <!-- Schedule Information -->
                                <div class="col-lg-6">
                                    <div id="schedulePrivacyContainer" class="privacy-blur h-100">
                                        <div class="content-card h-100">
                                            <div class="card-title-styled"><i class="bi bi-clock"></i> Schedule Information
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-12 info-group">
                                                    <div class="info-label">Date & Time</div>
                                                    <?php
                                                        $start = $appointment->scheduled_at;
                                                        $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)->where('start', $start)->first();
                                                        $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                                                    ?>
                                                    <div class="info-value">
                                                        <?php echo e($start->format('l, F j, Y')); ?><br>
                                                        <?php echo e($start->format('h:i A')); ?> – <?php echo e($end->format('h:i A')); ?>

                                                    </div>
                                                </div>
                                                <div class="col-12 info-group">
                                                    <div class="info-label">Appointment Type</div>
                                                    <div class="info-value">
                                                        <?php echo e($appointment->appointment_type ?? 'Not specified'); ?>

                                                    </div>
                                                </div>
                                                <div class="col-12 info-group">
                                                    <div class="info-label">Nature of Problem</div>
                                                    <div class="info-value">
                                                        <?php echo e($appointment->nature_of_problem ?? 'Not specified'); ?>

                                                        <?php if($appointment->nature_of_problem_other): ?>
                                                            <div class="small text-muted">
                                                                (<?php echo e($appointment->nature_of_problem_other); ?>)</div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($appointment->appointment_type === 'Referral'): ?>
                                                <hr class="my-3 text-muted opacity-25">
                                                <div class="row g-3">
                                                    <div class="col-12 info-group">
                                                        <div class="info-label">Referrer Name</div>
                                                        <div class="info-value">
                                                            <?php echo e($appointment->referrer_name ?? 'Not specified'); ?></div>
                                                    </div>
                                                    <div class="col-12 info-group">
                                                        <div class="info-label">Reason for Referral</div>
                                                        <div class="info-value">
                                                            <?php echo e($appointment->referral_reason ?? 'Not specified'); ?></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Information -->
                                <div class="col-lg-6">
                                    <div id="studentPrivacyContainer" class="privacy-blur h-100">
                                        <div class="content-card h-100">
                                            <div class="student-profile-header mb-4">
                                                <img src="<?php echo e($appointment->student->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($appointment->student->name)); ?>"
                                                    alt="Student" class="student-avatar">
                                                <h4 class="mb-1 text-dark fw-bold"><?php echo e($appointment->student->name); ?></h4>
                                                <div class="badge bg-light text-dark border">
                                                    <?php echo e($appointment->student->student_id ?? 'No ID'); ?>

                                                </div>
                                            </div>

                                            <div class="info-group">
                                                <div class="info-label">Contact</div>
                                                <div class="info-value text-break">
                                                    <i class="bi bi-envelope me-1 text-muted"></i>
                                                    <?php echo e($appointment->student->email); ?><br>
                                                    <i class="bi bi-phone me-1 text-muted"></i>
                                                    <?php echo e($appointment->student->contact_number ?? 'N/A'); ?>

                                                </div>
                                            </div>

                                            <hr class="my-3 text-muted opacity-25">

                                            <div class="row g-2">
                                                <div class="col-6 info-group">
                                                    <div class="info-label">College</div>
                                                    <div class="info-value"><?php echo e($appointment->student->college ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                                <div class="col-6 info-group">
                                                    <div class="info-label">Year Level</div>
                                                    <div class="info-value"><?php echo e($appointment->student->year_level ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                                <div class="col-6 info-group">
                                                    <div class="info-label">Course</div>
                                                    <div class="info-value"><?php echo e($appointment->student->course ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                                <div class="col-6 info-group">
                                                    <div class="info-label">Sex</div>
                                                    <div class="info-value">
                                                        <?php echo e(ucfirst($appointment->student->sex ?? 'N/A')); ?></div>
                                                </div>
                                            </div>

                                            <?php if($appointment->student->address): ?>
                                                <hr class="my-3 text-muted opacity-25">
                                                <div class="info-group">
                                                    <div class="info-label">Full Address</div>
                                                    <div><?php echo e($appointment->student->address); ?></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="content-card mb-4">
                                <div class="card-title-styled"><i class="bi bi-shield-check"></i> Guardian</div>
                                <div id="guardianPrivacyContainer" class="privacy-blur">
                                    <div class="info-group">
                                        <div class="info-label">Primary Guardian</div>
                                        <div class="info-value"><?php echo e($appointment->guardian1_name ?? 'N/A'); ?></div>
                                        <div class="small text-muted"><?php echo e($appointment->guardian1_relationship); ?> •
                                            <?php echo e($appointment->guardian1_contact); ?>

                                        </div>
                                    </div>
                                    <?php if($appointment->guardian2_name): ?>
                                        <hr class="my-3 text-muted opacity-25">
                                        <div class="info-group">
                                            <div class="info-label">Secondary Guardian</div>
                                            <div class="info-value"><?php echo e($appointment->guardian2_name); ?></div>
                                            <div class="small text-muted"><?php echo e($appointment->guardian2_relationship); ?> •
                                                <?php echo e($appointment->guardian2_contact); ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Assessment Data -->
                            <?php if(!empty($latestAssessment)): ?>
                                <div id="assessmentPrivacyContainer" class="privacy-blur mb-4">
                                    <div class="content-card">
                                        <div class="card-title-styled"><i class="bi bi-bar-chart-fill"></i> Latest Assessment
                                            Data
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <strong><?php echo e($latestAssessment->type); ?></strong>
                                                <div class="small text-muted">
                                                    <?php echo e($latestAssessment->created_at->format('M d, Y h:i A')); ?>

                                                </div>
                                            </div>
                                            <a href="<?php echo e(route('counselor.assessments.show', [$latestAssessment->id, 'from_appointment' => $appointment->id])); ?>"
                                                class="btn btn-sm btn-outline-primary">View Full Report</a>
                                        </div>

                                        <?php
                                            $laScores = is_array($latestAssessment->score) ? $latestAssessment->score : (is_string($latestAssessment->score) ? json_decode($latestAssessment->score, true) : []);
                                        ?>
                                        <?php if($latestAssessment->type === 'DASS-42'): ?>
                                            <?php
                                                // Normalize answers to 1-indexed (exact same logic as score_sheet.blade.php)
                                                $studentAnswers = [];
                                                if (!empty($laScores) && is_array($laScores)) {
                                                    // Check if 0-based keys are used
                                                    if (isset($laScores[0])) {
                                                        foreach ($laScores as $k => $v) {
                                                            if (is_numeric($k)) {
                                                                $ik = (int) $k;
                                                                if ($ik >= 0 && $ik <= 41) {
                                                                    $studentAnswers[$ik + 1] = (int) $v;
                                                                    continue;
                                                                }
                                                            }
                                                            $studentAnswers[$k] = $v;
                                                        }
                                                    } else {
                                                        // Already 1-based or has other keys
                                                        $studentAnswers = $laScores;
                                                    }
                                                }

                                                // DASS-42 Scoring items (CORRECTED mapping with Q42 in Depression)
                                                $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
                                                $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
                                                $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];

                                                // Calculate scores (raw sums of item values only)
                                                $dep = 0;
                                                $anx = 0;
                                                $str = 0;
                                                foreach ($depressionItems as $item) {
                                                    $dep += (int) ($studentAnswers[$item] ?? 0);
                                                }
                                                foreach ($anxietyItems as $item) {
                                                    $anx += (int) ($studentAnswers[$item] ?? 0);
                                                }
                                                foreach ($stressItems as $item) {
                                                    $str += (int) ($studentAnswers[$item] ?? 0);
                                                }
                                            ?>
                                            <div class="row g-3">
                                                <div class="col-4 text-center">
                                                    <div class="h4 mb-0 text-primary"><?php echo e($dep); ?></div>
                                                    <div class="small text-muted">Depression</div>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <div class="h4 mb-0 text-info"><?php echo e($anx); ?></div>
                                                    <div class="small text-muted">Anxiety</div>
                                                </div>
                                                <div class="col-4 text-center">
                                                    <div class="h4 mb-0 text-secondary"><?php echo e($str); ?></div>
                                                    <div class="small text-muted">Stress</div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="p-3 bg-light rounded">Score:
                                                <?php echo e(is_array($laScores) ? ($laScores['score'] ?? json_encode($laScores)) : ($latestAssessment->score ?? 'N/A')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Notes Section (Prominent) -->
                            <div id="notesPrivacyContainer" class="privacy-blur mb-4">
                                <div class="content-card notes-card">
                                    <div class="card-title-styled">
                                        <i class="bi bi-sticky-fill"></i> Student Notes / Concerns
                                    </div>
                                    <?php if($appointment->notes): ?>
                                        <div class="p-3 bg-white rounded border border-warning">
                                            <p class="mb-0 fs-5" style="color: #444;"><?php echo e($appointment->notes); ?></p>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted fst-italic">No additional notes provided by the student.</div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- History -->
                            <?php if(isset($appointmentHistory) && $appointmentHistory->count() > 0): ?>
                                <div class="content-card p-0 overflow-hidden">
                                    <div class="p-3 bg-light border-bottom fw-bold"><i class="bi bi-clock-history"></i> History
                                    </div>
                                    <div class="list-group list-group-flush">
                                        <?php $__currentLoopData = $appointmentHistory->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(route('counselor.appointments.show', $hist->id)); ?>"
                                                class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <small
                                                        class="fw-bold text-dark"><?php echo e(\Carbon\Carbon::parse($hist->scheduled_at)->format('M d, Y')); ?></small>
                                                    <small
                                                        class="badge bg-secondary"><?php echo e($hist->status === 'accepted' ? 'Approved' : ucfirst($hist->status)); ?></small>
                                                </div>
                                                <small class="text-muted"><?php echo e($hist->nature_of_problem); ?></small>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php if($appointmentHistory->count() > 3): ?>
                                        <div class="p-2 text-center text-muted small bg-light">
                                            +<?php echo e($appointmentHistory->count() - 3); ?> more records
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals & Scripts -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p id="confirmModalMessage" class="mb-0 fs-5 text-center text-dark"></p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4" id="confirmModalOk">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle logic matching student directory
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function (e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }

            // Confirmation Logic
            const confirmModalEl = document.getElementById('confirmModal');
            let bsConfirmModal = new bootstrap.Modal(confirmModalEl);
            let confirmTarget = null;

            document.querySelectorAll('[data-confirm]').forEach(el => {
                el.addEventListener('click', e => {
                    e.preventDefault();
                    // If label clicks trigger check, ensure we have the form
                    let target = el.closest('form') || el;
                    if (target.tagName === 'BUTTON') target = target.form || target;

                    document.getElementById('confirmModalMessage').textContent = el.getAttribute('data-confirm');
                    confirmTarget = target;
                    bsConfirmModal.show();
                });
            });

            document.getElementById('confirmModalOk').addEventListener('click', () => {
                if (confirmTarget) {
                    if (confirmTarget.tagName === 'FORM') confirmTarget.submit();
                    else window.location.href = confirmTarget.href;
                }
                bsConfirmModal.hide();
            });


            // Privacy Toggle Logic
            const privacyBtn = document.getElementById('privacyToggleBtn');
            const privacyIcon = document.getElementById('privacyIcon');
            const studentContainer = document.getElementById('studentPrivacyContainer');
            const guardianContainer = document.getElementById('guardianPrivacyContainer');
            const assessmentContainer = document.getElementById('assessmentPrivacyContainer');
            const scheduleContainer = document.getElementById('schedulePrivacyContainer');
            const notesContainer = document.getElementById('notesPrivacyContainer');
            let isRevealed = false;

            if (privacyBtn) {
                privacyBtn.addEventListener('click', function () {
                    if (!isRevealed) {
                        Swal.fire({
                            title: 'Enter Passkey',
                            input: 'password',
                            inputLabel: 'To view student details, please enter the passkey:',
                            inputPlaceholder: 'Enter passkey',
                            showCancelButton: true,
                            confirmButtonText: 'Reveal',
                            confirmButtonColor: '#1f7a2d',
                            cancelButtonColor: '#6c757d',
                            preConfirm: (passkey) => {
                                if (!passkey) {
                                    Swal.showValidationMessage('Please enter a passkey');
                                }
                                return passkey;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Default fallback passkey if not set in profile
                                const userPasskey = '<?php echo e(auth()->user()->passkey ?? "GCC2026"); ?>';

                                if (result.value === userPasskey) {
                                    isRevealed = true;
                                    studentContainer.classList.remove('privacy-blur');
                                    studentContainer.classList.add('privacy-revealed');
                                    guardianContainer.classList.remove('privacy-blur');
                                    guardianContainer.classList.add('privacy-revealed');
                                    if (assessmentContainer) {
                                        assessmentContainer.classList.remove('privacy-blur');
                                        assessmentContainer.classList.add('privacy-revealed');
                                    }
                                    if (scheduleContainer) {
                                        scheduleContainer.classList.remove('privacy-blur');
                                        scheduleContainer.classList.add('privacy-revealed');
                                    }
                                    if (notesContainer) {
                                        notesContainer.classList.remove('privacy-blur');
                                        notesContainer.classList.add('privacy-revealed');
                                    }
                                    privacyIcon.classList.remove('bi-eye-slash-fill');
                                    privacyIcon.classList.add('bi-eye-fill');
                                    privacyBtn.classList.remove('btn-light');
                                    privacyBtn.classList.add('btn-warning');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Access Granted',
                                        text: 'Student details revealed.',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Access Denied',
                                        text: 'Incorrect passkey.',
                                        confirmButtonColor: '#dc3545'
                                    });
                                }
                            }
                        });
                    } else {
                        // Re-hide
                        isRevealed = false;
                        studentContainer.classList.add('privacy-blur');
                        studentContainer.classList.remove('privacy-revealed');
                        guardianContainer.classList.add('privacy-blur');
                        guardianContainer.classList.remove('privacy-revealed');
                        if (assessmentContainer) {
                            assessmentContainer.classList.add('privacy-blur');
                            assessmentContainer.classList.remove('privacy-revealed');
                        }
                        if (scheduleContainer) {
                            scheduleContainer.classList.add('privacy-blur');
                            scheduleContainer.classList.remove('privacy-revealed');
                        }
                        if (notesContainer) {
                            notesContainer.classList.add('privacy-blur');
                            notesContainer.classList.remove('privacy-revealed');
                        }
                        privacyIcon.classList.add('bi-eye-slash-fill');
                        privacyIcon.classList.remove('bi-eye-fill');
                        privacyBtn.classList.add('btn-light');
                        privacyBtn.classList.remove('btn-warning');
                    }
                });
            }
        });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/appointments/show.blade.php ENDPATH**/ ?>