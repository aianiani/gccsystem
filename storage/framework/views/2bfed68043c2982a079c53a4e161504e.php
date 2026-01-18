<?php $__env->startSection('content'); ?>
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

        /* Apply the same page zoom used on the homepage */
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
        .profile-card,
        .stats-card,
        .main-content-card {
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
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 100%;
            margin: 0 auto;
        }

        .welcome-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            min-height: 100px;
        }

        .welcome-card .welcome-text {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }

        .welcome-card .welcome-date {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .welcome-card .welcome-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
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
        }

        .main-content-card .card-body {
            padding: 1.25rem;
        }

        .student-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .student-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-light);
        }

        .student-header {
            background: linear-gradient(135deg, var(--forest-green-lighter) 0%, var(--yellow-maize-light) 100%);
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .student-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--forest-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 2rem;
            margin: 0 auto 1rem;
            border: 4px solid white;
            box-shadow: var(--shadow-sm);
        }

        .student-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
        }

        .student-role {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .status-indicator {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #28a745;
            border: 2px solid white;
            box-shadow: 0 0 0 2px var(--forest-green-lighter);
        }

        .student-body {
            padding: 1.5rem;
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: var(--gray-50);
            border-radius: 8px;
        }

        .student-info i {
            color: var(--forest-green);
            font-size: 1.1rem;
            width: 20px;
        }

        .student-info span {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .student-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 8px;
            border: 1px solid var(--gray-100);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .chat-btn {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            text-decoration: none;
            box-shadow: 0 6px 18px rgba(17, 94, 37, 0.06);
        }

        .chat-btn:hover {
            background: var(--forest-green-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
            color: white;
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-600);
            background: var(--gray-50);
            border-radius: 16px;
            border: 2px dashed var(--gray-200);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--gray-600);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info,
        .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17, 94, 37, 0.06);
        }

        .btn-outline-primary {
            border-color: var(--forest-green);
            color: var(--forest-green);
        }

        .btn-outline-primary:hover {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 2rem 1rem;
                margin-bottom: 2rem;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .student-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .student-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none">
                <i class="bi bi-list"></i>
            </button>
            <!-- Sidebar -->
            <?php echo $__env->make('counselor.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="welcome-card">
                        <div>
                            <div class="welcome-date"><?php echo e(now()->format('F j, Y')); ?></div>
                            <div class="welcome-text">Choose a Student to Chat With</div>
                            <div style="font-size: 0.9rem; margin-top: 0.5rem;">Select a student to start a conversation and
                                provide support</div>
                        </div>
                        <div class="welcome-avatar">
                            <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="<?php echo e(auth()->user()->name); ?>"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        </div>
                    </div>

                    <div class="main-content-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-chat-dots me-2"></i>Available Students</h5>
                        </div>
                        <div class="card-body">

                            <?php if($students->count() > 0): ?>
                                <div class="inbox-list">
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('chat.index', $student->id)); ?>" class="inbox-item">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <img src="<?php echo e($student->avatar_url); ?>" alt="Avatar" class="rounded-circle"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div class="status-indicator"></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h6 class="mb-0 font-weight-bold text-dark"><?php echo e($student->name); ?></h6>
                                                        <?php if($student->last_message): ?>
                                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                                <?php echo e($student->last_message->created_at->diffForHumans(null, true, true)); ?>

                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <p class="mb-0 text-muted small text-truncate" style="max-width: 250px;">
                                                        <?php if($student->last_message): ?>
                                                            <?php if($student->last_message->sender_id === auth()->id()): ?>
                                                                <span class="fw-bold text-dark">You:</span>
                                                            <?php endif; ?>
                                                            <?php echo e($student->last_message->content ?: ($student->last_message->image ? 'Sent an image' : '')); ?>

                                                        <?php else: ?>
                                                            <?php echo e($student->email); ?>

                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                                <i class="bi bi-chevron-right text-muted"></i>
                                            </div>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <style>
                                    .inbox-list {
                                        background: white;
                                        border-radius: 12px;
                                        overflow: hidden;
                                        box-shadow: var(--shadow-sm);
                                        border: 1px solid var(--gray-100);
                                    }

                                    .inbox-item {
                                        display: block;
                                        padding: 1rem 1.5rem;
                                        border-bottom: 1px solid var(--gray-100);
                                        transition: background-color 0.2s;
                                        text-decoration: none;
                                    }

                                    .inbox-item:last-child {
                                        border-bottom: none;
                                    }

                                    .inbox-item:hover {
                                        background-color: var(--gray-50);
                                        text-decoration: none;
                                    }

                                    .status-indicator {
                                        position: absolute;
                                        bottom: 0;
                                        right: 0;
                                        width: 12px;
                                        height: 12px;
                                        border-radius: 50%;
                                        background: #28a745;
                                        border: 2px solid white;
                                    }
                                </style>
                            <?php else: ?>
                                <div class="empty-state">
                                    <i class="bi bi-people"></i>
                                    <h3>No Students Available</h3>
                                    <p class="mb-0">There are currently no students available for chat. Please check back later
                                        or contact support for assistance.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/chat_select_student.blade.php ENDPATH**/ ?>