<?php $__env->startSection('content'); ?>
<?php $__env->startSection('full_width', true); ?>
    <style>
        /* Sidebar Alignment Fix */
        .main-dashboard-content {
            margin-left: 280px;
            min-height: 100vh;
            /* background: linear-gradient(135deg, #f8fafc 0%, #e8f5e8 100%); */
            transition: margin-left 0.3s ease;
            padding: 2rem;
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem;
            }
        }

        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            /* Core Green Palette */
            --primary-green: #1f7a2d;
            --primary-green-dark: #14521e;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;

            /* Accent Colors */
            --accent-orange: #FFCB05;
            --accent-gold: #f4d03f;

            /* Neturals */
            --text-dark: #0f2915;
            --text-muted: #5a6e60;
            --bg-body: #f8faf9;
            --bg-card: #ffffff;

            /* Shadows - Smoother & deeper for premium feel */
            --shadow-sm: 0 2px 8px rgba(31, 122, 45, 0.06);
            --shadow-md: 0 8px 24px rgba(31, 122, 45, 0.08);
            --shadow-lg: 0 16px 48px rgba(31, 122, 45, 0.15);
            --shadow-hover: 0 20px 40px rgba(31, 122, 45, 0.12);

            /* Mapping legacy vars nicely */
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-dark);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --bg-light: var(--bg-body);
            --white: #ffffff;
            --gray-100: #eef2f0;
            --gray-600: var(--text-muted);

            /* Status Colors */
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;

            /* Gradients */
            --hero-gradient: linear-gradient(135deg, #1f7a2d 0%, #0b3d11 100%);
            --card-gradient: linear-gradient(180deg, #ffffff 0%, #fcfdfc 100%);
            --gold-gradient: linear-gradient(135deg, #FFCB05 0%, #f4b400 100%);
        }

        /* Stats Grid - 4 Columns */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Main Content - Single Column Stack */
        .dashboard-content-grid {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 991.98px) {

            .dashboard-content-grid,
            .stats-grid {
                grid-template-columns: 1fr;
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

        /* Apply the same page zoom used on the homepage */
        .home-zoom {
            zoom: 0.75;
            /* Adjusted as per request */
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
            font-family: 'Inter', 'Segoe UI', sans-serif;
            /* Clean modern font */
            background-color: var(--bg-body);
            color: var(--text-dark);
        }

        .dass-modal .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .dass-modal-header {
            background: var(--hero-gradient);
            color: #fff;
            border: none;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dass-modal-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .dass-modal-body {
            padding: 1.5rem;
        }

        .dass-modal-checklist li {
            background: var(--gray-100);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.75rem;
            border: 1px solid rgba(0, 0, 0, 0.03);
            transition: transform 0.2s;
        }

        .dass-modal-checklist li:hover {
            transform: translateX(4px);
            background: #fff;
            box-shadow: var(--shadow-sm);
        }

        .dass-modal-title {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.1rem;
        }

        .dass-modal-footer {
            padding: 1rem 1.5rem;
            background: #f9fafb;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
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
            color: white;
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

        /* Sidebar and Main Content base layout handled in app.blade.php */
        @media (max-width: 768px) {
            .main-dashboard-content {
                padding: 1rem 0.75rem;
            }

            #studentSidebarToggle {
                display: flex !important;
            }
        }

        /* Hero Section - Premium Design */
        .welcome-card {
            background: linear-gradient(135deg, #1f7a2d 0%, #145a1f 50%, #0a3d10 100%);
            position: relative;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(31, 122, 45, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            padding: 0;
            margin-bottom: 2rem;
            color: #fff;
            overflow: hidden;
        }

        /* Decorative Elements */
        .welcome-card::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(244, 208, 63, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-card-inner {
            display: flex;
            align-items: stretch;
            position: relative;
            z-index: 2;
        }

        /* Left Section - User Info */
        .welcome-user-section {
            flex: 1;
            padding: 2rem 2.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .welcome-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.1));
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
        }

        .welcome-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .welcome-info {
            flex: 1;
        }

        .welcome-date {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            background: rgba(255, 255, 255, 0.1);
            padding: 0.35rem 0.9rem;
            border-radius: 50px;
            margin-bottom: 0.75rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .welcome-date i {
            font-size: 0.85rem;
        }

        .welcome-greeting {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            color: #fff;
            line-height: 1.3;
        }

        .welcome-subtitle {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 400;
        }

        /* Right Section - Seminar Badges */
        .welcome-badges-section {
            background: rgba(0, 0, 0, 0.15);
            padding: 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 420px;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        .badges-header {
            margin-bottom: 1rem;
        }

        .badges-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.6);
        }

        .seminar-badges-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }

        .seminar-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.9rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
            border: 1px solid transparent;
        }

        .seminar-badge.locked {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.4);
        }

        .seminar-badge.locked i {
            opacity: 0.5;
        }

        .seminar-badge.completed {
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        /* NSOP - Purple */
        .seminar-badge.completed.nsop {
            background: rgba(111, 66, 193, 0.9);
            border-color: rgba(111, 66, 193, 0.5);
        }

        .seminar-badge.completed.nsop i {
            color: #d8b4fe;
        }

        /* IDREAMS - Cyan */
        .seminar-badge.completed.idreams {
            background: rgba(13, 202, 240, 0.9);
            border-color: rgba(13, 202, 240, 0.5);
        }

        .seminar-badge.completed.idreams i {
            color: #fff;
        }

        /* 10C - Yellow/Gold */
        .seminar-badge.completed.ten-c {
            background: rgba(255, 203, 5, 0.95);
            border-color: rgba(255, 203, 5, 0.5);
        }

        .seminar-badge.completed.ten-c i {
            color: #1a1a1a;
        }

        .seminar-badge.completed.ten-c span {
            color: #1a1a1a;
        }

        /* LEADS - Blue */
        .seminar-badge.completed.leads {
            background: rgba(13, 110, 253, 0.9);
            border-color: rgba(13, 110, 253, 0.5);
        }

        .seminar-badge.completed.leads i {
            color: #bfdbfe;
        }

        /* IMAGE - Green */
        .seminar-badge.completed.image {
            background: rgba(25, 135, 84, 0.9);
            border-color: rgba(25, 135, 84, 0.5);
        }

        .seminar-badge.completed.image i {
            color: #a7f3d0;
        }

        .seminar-badge:hover {
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .welcome-card-inner {
                flex-direction: column;
            }

            .welcome-badges-section {
                min-width: unset;
                border-left: none;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .welcome-user-section {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .welcome-user-section {
                flex-direction: column;
                text-align: center;
                padding: 1.25rem;
                gap: 1rem;
            }

            .welcome-avatar {
                width: 70px;
                height: 70px;
            }

            .welcome-greeting {
                font-size: 1.25rem;
            }

            .welcome-badges-section {
                padding: 1.25rem;
            }

            .seminar-badges-grid {
                justify-content: center;
            }

            .seminar-badge {
                padding: 0.4rem 0.7rem;
                font-size: 0.75rem;
            }
        }

        /* Stats Cards Redesign */
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .dashboard-stat-card {
            background: var(--card-gradient);
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            padding: 1.75rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(31, 122, 45, 0.15);
        }

        /* Artistic background icon for stats */
        .dashboard-stat-card .bg-icon {
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 5rem;
            opacity: 0.03;
            color: var(--primary-green);
            transform: rotate(15deg);
            pointer-events: none;
            transition: all 0.5s ease;
        }

        .dashboard-stat-card:hover .bg-icon {
            transform: rotate(0deg) scale(1.1);
            opacity: 0.06;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--hero-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.25rem;
            display: block;
            line-height: 1;
        }

        .stat-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .stat-meta {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1.2rem;
            font-weight: 500;
        }

        .stat-progress {
            height: 8px;
            background-color: var(--gray-100);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: inner 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .stat-progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 0.8s ease-in-out;
            background: linear-gradient(90deg, var(--primary-green) 0%, var(--accent-green) 100%);
            box-shadow: 0 2px 5px rgba(31, 122, 45, 0.3);
        }

        /* Action Card Special Styling */
        .action-card {
            background: #ffffff;
            border: 2px solid var(--accent-orange);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .action-icon-circle {
            width: 64px;
            height: 64px;
            background: #fff9e6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: var(--accent-orange);
            font-size: 1.8rem;
            transition: transform 0.4s ease;
        }

        .action-card:hover .action-icon-circle {
            transform: rotate(15deg) scale(1.1);
            background: var(--accent-orange);
            color: #fff;
        }

        .btn-action-premium {
            background: var(--gold-gradient);
            color: var(--text-dark);
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(255, 203, 5, 0.4);
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-action-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 203, 5, 0.5);
            background: linear-gradient(135deg, #f4b400 0%, #FFCB05 100%);
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

                    <!-- Premium Hero Section -->
                    <div class="welcome-card">
                        <div class="welcome-card-inner">
                            <!-- User Info Section -->
                            <div class="welcome-user-section">
                                <div class="welcome-avatar">
                                    <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="<?php echo e(auth()->user()->name); ?>">
                                </div>
                                <div class="welcome-info">
                                    <div class="welcome-date">
                                        <i class="bi bi-calendar3"></i>
                                        <?php echo e(now()->format('F j, Y')); ?>

                                    </div>
                                    <div class="welcome-greeting">Welcome back,
                                        <?php echo e(auth()->user()->first_name ?? auth()->user()->name); ?>!
                                    </div>
                                    <div class="welcome-subtitle">Always stay updated in your student portal</div>
                                </div>
                            </div>

                            <!-- Seminar Badges Section -->
                            <div class="welcome-badges-section">
                                <div class="badges-header">
                                    <span class="badges-title">Seminar Progress</span>
                                </div>
                                <div class="seminar-badges-grid">
                                    <?php
                                        $badges = [
                                            'New Student Orientation Program' => ['icon' => 'bi-compass-fill', 'year' => 1, 'label' => 'NSOP', 'class' => 'nsop'],
                                            'IDREAMS' => ['icon' => 'bi-clouds-fill', 'year' => 1, 'class' => 'idreams'],
                                            '10C' => ['icon' => 'bi-lightbulb-fill', 'year' => 2, 'class' => 'ten-c'],
                                            'LEADS' => ['icon' => 'bi-people-fill', 'year' => 3, 'class' => 'leads'],
                                            'IMAGE' => ['icon' => 'bi-person-badge-fill', 'year' => 4, 'class' => 'image'],
                                        ];
                                    ?>

                                    <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seminarName => $style): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $attendance = $attendanceMatrix[$style['year']][$seminarName] ?? null;
                                            $isCompleted = $attendance && ($attendance['status'] ?? '') === 'completed';
                                        ?>
                                        <div
                                            class="seminar-badge <?php echo e($isCompleted ? 'completed ' . $style['class'] : 'locked'); ?>">
                                            <?php if($isCompleted): ?>
                                                <i class="bi <?php echo e($style['icon']); ?>"></i>
                                            <?php else: ?>
                                                <i class="bi bi-lock-fill"></i>
                                            <?php endif; ?>
                                            <span><?php echo e($style['label'] ?? $seminarName); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Stats Grid -->
                    <div class="stats-grid">
                        
                        <style>
                            .notification-bell {
                                background: white !important;
                                border: none !important;
                                outline: none !important;
                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
                                position: relative;
                                transition: all 0.3s ease !important;
                                width: 75px !important;
                                height: 75px !important;
                                border-radius: 50% !important;
                                display: flex !important;
                                align-items: center !important;
                                justify-content: center !important;
                                padding: 0 !important;
                                min-width: 75px !important;
                            }

                            .notification-bell:hover {
                                background: var(--yellow-maize);
                                box-shadow: 0 6px 20px rgba(255, 203, 5, 0.4);
                                transform: translateY(-2px);
                            }

                            .notification-bell .bi-bell {
                                color: var(--forest-green);
                                font-size: 2.5rem;
                                transition: all 0.3s ease;
                            }

                            .notification-bell:hover .bi-bell {
                                color: var(--forest-green);
                                transform: scale(1.1);
                            }

                            .notification-bell.pulse {
                                animation: bell-shake 0.5s ease-in-out infinite;
                            }

                            @keyframes bell-shake {

                                0%,
                                100% {
                                    transform: rotate(0deg);
                                }

                                25% {
                                    transform: rotate(-10deg);
                                }

                                75% {
                                    transform: rotate(10deg);
                                }
                            }

                            .notification-bell-badge {
                                background: var(--danger);
                                color: white;
                                font-weight: bold;
                                font-size: 0.75rem;
                                border: 2px solid #fff;
                                box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4);
                                padding: 0.2em 0.5em;
                                border-radius: 999px;
                                top: -4px;
                                right: -4px;
                            }

                            @media (max-width: 768px) {
                                .notification-bell {
                                    width: 50px !important;
                                    height: 50px !important;
                                    min-width: 50px !important;
                                }

                                .notification-bell .bi-bell {
                                    font-size: 1.5rem;
                                }

                                .notification-bell-wrapper {
                                    top: 1rem !important;
                                    right: 1rem !important;
                                }
                            }

                            .notification-dropdown-menu {
                                min-width: 600px;
                                max-width: 95vw;
                                max-height: 500px;
                                overflow-y: auto;
                                border-radius: 12px;
                                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                                border: none;
                                padding: 0;
                                margin-top: 0.75rem;
                                background: white;
                                overflow-x: hidden;
                                z-index: 9999 !important;
                                position: absolute !important;
                                right: 0;
                                top: 70px;
                                list-style: none;
                            }

                            @media (max-width: 768px) {
                                .notification-dropdown-menu {
                                    min-width: auto !important;
                                    width: 90vw !important;
                                    right: -10px !important;
                                    left: auto !important;
                                    transform: translateX(5%);
                                }
                            }

                            .notification-dropdown-header {
                                background: linear-gradient(135deg, var(--forest-green), var(--forest-green-light));
                                color: white;
                                font-weight: 700;
                                padding: 1.25rem 1.5rem;
                                font-size: 1.1rem;
                                border-bottom: none;
                                font-family: inherit;
                            }

                            .notification-item {
                                display: flex;
                                align-items: flex-start;
                                gap: 1rem;
                                padding: 1.25rem 1.5rem;
                                font-size: 0.95rem;
                                background: white;
                                transition: background 0.2s;
                                border-bottom: 1px solid #f0f0f0;
                                font-family: inherit;
                                position: relative;
                            }

                            .notification-item:last-child {
                                border-bottom: none;
                            }

                            .notification-item:hover {
                                background: #f8f9fa;
                            }

                            .notification-item .notification-icon {
                                width: 40px;
                                height: 40px;
                                border-radius: 50%;
                                background: linear-gradient(135deg, #e3f2fd, #bbdefb);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                flex-shrink: 0;
                            }

                            .notification-item .notification-icon i {
                                color: #1976d2;
                                font-size: 1.1rem;
                            }

                            .notification-item .notification-content {
                                flex: 1;
                                line-height: 1.5;
                                color: #333;
                            }

                            .notification-item .notification-content strong {
                                color: var(--forest-green);
                                font-weight: 600;
                            }

                            .notification-item .notification-actions {
                                display: flex !important;
                                flex-direction: column !important;
                                gap: 0.5rem !important;
                                align-items: center !important;
                            }

                            .notification-item .btn-view {
                                background: var(--forest-green);
                                color: white;
                                border: none;
                                border-radius: 50%;
                                width: 36px;
                                height: 36px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 1rem;
                                transition: all 0.2s;
                                padding: 0;
                            }

                            .notification-item .btn-view:hover {
                                background: var(--forest-green-light);
                                transform: scale(1.1);
                            }

                            .notification-item .btn-link {
                                color: #dc3545;
                                font-size: 1rem;
                                width: 36px;
                                height: 36px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                padding: 0;
                                transition: all 0.2s;
                                background: none;
                                border: none;
                                border-radius: 50%;
                            }

                            .notification-item .btn-link:hover {
                                color: #c82333;
                                background: rgba(220, 53, 69, 0.1);
                                transform: scale(1.1);
                            }

                            .notification-empty {
                                padding: 2.5rem 1.5rem;
                                color: #999;
                                text-align: center;
                                font-size: 0.95rem;
                                font-family: inherit;
                            }

                            .notification-empty i {
                                font-size: 2.5rem;
                                color: #ddd;
                                margin-bottom: 0.75rem;
                                display: block;
                            }

                            @media (max-width: 500px) {
                                .notification-dropdown-menu {
                                    min-width: 90vw;
                                    padding: 0.25rem 0;
                                }

                                .notification-dropdown-header {
                                    font-size: 1rem;
                                    padding: 0.7rem 1rem;
                                }

                                .notification-item,
                                .notification-empty {
                                    padding: 0.7rem 1rem;
                                }
                            }
                        </style>
                        <?php
                            $unreadCount = auth()->user()->unreadNotifications()->count();
                            // Show ALL notifications (both read and unread) - most recent 10
                            $recentNotifications = auth()->user()->notifications()->latest()->take(10)->get();
                        ?>
                        
                        <div class="notification-bell-wrapper"
                            style="position: fixed; top: 1.5rem; right: 2.5rem; z-index: 9999;">
                            <div class="dropdown me-3">
                                <button
                                    class="btn notification-bell position-relative p-0<?php echo e($unreadCount > 0 ? ' pulse' : ''); ?>"
                                    type="button" id="notificationDropdown" onclick="toggleNotificationDropdown()">
                                    <i class="bi bi-bell"></i>
                                    <?php if($unreadCount > 0): ?>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge notification-bell-badge">
                                            <?php echo e($unreadCount); ?>

                                        </span>
                                    <?php endif; ?>
                                </button>
                                <ul class="notification-dropdown-menu" id="notificationMenu" style="display: none;">
                                    <li class="notification-dropdown-header">Notifications</li>
                                    <?php $__empty_1 = true; $__currentLoopData = $recentNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li class="notification-item<?php echo e(is_null($notification->read_at) ? ' bg-light' : ''); ?>">
                                            <div class="notification-icon">
                                                <?php if(isset($notification->data['appointment_id'])): ?>
                                                    <i class="bi bi-calendar-check"></i>
                                                <?php else: ?>
                                                    <i class="bi bi-info-circle"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="notification-content">
                                                <?php echo e($notification->data['message'] ?? 'You have a new notification.'); ?>

                                                <?php if(is_null($notification->read_at)): ?>
                                                    <span class="badge bg-primary ms-2" style="font-size: 0.7rem;">New</span>
                                                <?php endif; ?>
                                                <div class="text-muted small mt-1">
                                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                                </div>
                                            </div>
                                            <div class="notification-actions">
                                                <?php if(isset($notification->data['appointment_id'])): ?>
                                                    <a href="<?php echo e(route('appointments.index')); ?>" class="btn-view"
                                                        title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                <?php elseif(isset($notification->data['type']) && $notification->data['type'] === 'seminar_unlocked'): ?>
                                                    <a href="<?php echo e(route('student.seminars.index')); ?>" class="btn-view"
                                                        title="View Guidance Program">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <form method="POST"
                                                    action="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>"
                                                    class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-link" title="Dismiss">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li class="notification-empty">
                                            <i class="bi bi-bell-slash"></i>
                                            <div>No new notifications</div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>

                        <script>
                            // Custom dropdown toggle function (Bootstr                                                    ap dropdown wasn't working)
                            function toggleNotificationDropdown() {
                                const menu = document.getElementById('notificationMenu');
                                if (menu) {
                                    if (menu.style.display === 'none' || menu.style.display === '') {
                                        menu.style.display = 'block';
                                        console.log('Dropdown opened');
                                    } else {
                                        menu.style.display = 'none';
                                        console.log('Dropdown closed');
                                    }
                                } else {
                                    console.error('Notification menu not found!');
                                }
                            }

                            // Close dropdown when clicking outside
                            document.addEventListener('click', function (event) {
                                const bell = document.getElementById('notificationDropdown');
                                const menu = document.getElementById('notificationMenu');

                                if (bell && menu && !bell.contains(event.target) && !menu.contains(event.target)) {
                                    menu.style.display = 'none';
                                }
                            });

                            // Shake notification bell only once on page load if there are unread notifications
                            document.addEventListener('DOMContentLoaded', function () {
                                const notificationBell = document.getElementById('notificationDropdown');
                                if (notificationBell && notificationBell.classList.contains('pulse')) {
                                    // Shake for 2 seconds then remove the pulse class
                                    setTimeout(function () {
                                        notificationBell.classList.remove('pulse');
                                    }, 2000);
                                }
                            });
                        </script>

                        <div class="dashboard-stat-card">
                            <i class="bi bi-journal-check bg-icon"></i>
                            <div>
                                <div class="stat-value"><?php echo e($studentStats['sessionProgress']); ?>%</div>
                                <div class="stat-label">Session Progress</div>
                                <div class="stat-meta">
                                    <?php echo e($studentStats['totalSessions']); ?>/<?php echo e($studentStats['totalScheduled']); ?>

                                    completed
                                </div>
                            </div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: <?php echo e($studentStats['sessionProgress']); ?>%"></div>
                            </div>
                        </div>

                        <div class="dashboard-stat-card">
                            <i class="bi bi-file-earmark-text bg-icon"></i>
                            <div>
                                <div class="stat-value"><?php echo e($studentStats['assessmentProgress']); ?>%</div>
                                <div class="stat-label">Assessments Done</div>
                                <div class="stat-meta">
                                    <?php echo e($studentStats['completedAssessments']); ?>/<?php echo e($studentStats['totalAssessments']); ?>

                                    completed
                                </div>
                            </div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: <?php echo e($studentStats['assessmentProgress']); ?>%">
                                </div>
                            </div>
                        </div>

                        <!-- Seminar Progress Card -->
                        <div class="dashboard-stat-card">
                            <i class="bi bi-people bg-icon"></i>
                            <?php
                                $attendedSeminars = 0;
                                $totalSeminars = 4;
                                if (isset($attendanceMatrix)) {
                                    foreach ($attendanceMatrix as $year => $seminars) {
                                        $attendedSeminars += count($seminars);
                                    }
                                }
                                $seminarProgress = ($attendedSeminars / $totalSeminars) * 100;
                            ?>
                            <div>
                                <div class="stat-value"><?php echo e($attendedSeminars); ?>/<?php echo e($totalSeminars); ?></div>
                                <div class="stat-label">Seminars Attended</div>
                                <div class="stat-meta">Required seminars completed</div>
                            </div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: <?php echo e($seminarProgress); ?>%"></div>
                            </div>
                        </div>

                        <!-- Book Appointment CTA -->
                        <div class="dashboard-stat-card action-card h-100">
                            <div class="action-icon-circle">
                                <i class="bi bi-calendar-plus-fill"></i>
                            </div>
                            <h5 class="fw-bold mb-3" style="color: var(--text-dark);">Book a Session</h5>
                            <a href="#" class="btn-action-premium js-book-appointment-trigger text-decoration-none">
                                Book Now
                            </a>

                        </div>
                    </div>

                    <div class="dashboard-content-grid">
                        <!-- Left: Upcoming Appointments -->
                        <div class="main-content-card h-100">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Upcoming Appointments</h5>
                            </div>
                            <div class="card-body">
                                <?php $__empty_1 = true; $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $start = $appointment->scheduled_at;
                                        $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                                            ->where('start', $start)
                                            ->first();
                                        $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                                    ?>
                                    <div class="appointment-item p-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Counselor Avatar -->
                                            <div class="flex-shrink-0">
                                                <img src="<?php echo e($appointment->counselor->avatar_url); ?>"
                                                    alt="<?php echo e($appointment->counselor->name); ?>" class="rounded-circle border"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>

                                            <!-- Appointment Details -->
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold text-dark">
                                                        <?php echo e($appointment->counselor->name ?? 'Counselor'); ?>

                                                    </h6>
                                                    <span
                                                        class="badge bg-primary rounded-pill px-3"><?php echo e($appointment->status === 'accepted' ? 'Approved' : ucfirst($appointment->status)); ?></span>
                                                </div>

                                                <div class="text-muted small mb-2">
                                                    <i class="bi bi-calendar-event me-1"></i><?php echo e($start->format('F j, Y')); ?>

                                                    &bull;
                                                    <i class="bi bi-clock me-1 ms-1"></i><?php echo e($start->format('g:i A')); ?> –
                                                    <?php echo e($end->format('g:i A')); ?>

                                                </div>

                                                <?php if($appointment->status === 'accepted'): ?>
                                                    <div
                                                        class="bg-success bg-opacity-10 text-success p-2 rounded-3 small border border-success border-opacity-10">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        <strong>Approved!</strong> Please proceed to GCC on scheduled time.
                                                    </div>
                                                <?php elseif($appointment->status === 'completed'): ?>
                                                    <div
                                                        class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 small border border-primary border-opacity-10">
                                                        <i class="bi bi-journal-check me-1"></i>
                                                        Session completed. <a href="<?php echo e(route('appointments.completedWithNotes')); ?>"
                                                            class="fw-bold text-primary">View Notes</a>
                                                    </div>
                                                <?php elseif($appointment->status === 'declined'): ?>
                                                    <div
                                                        class="bg-danger bg-opacity-10 text-danger p-2 rounded-3 small border border-danger border-opacity-10">
                                                        <i class="bi bi-x-circle-fill me-1"></i>
                                                        Appointment declined. Please book another slot.
                                                    </div>
                                                <?php elseif($appointment->status === 'rescheduled_pending'): ?>
                                                    <div
                                                        class="bg-info bg-opacity-10 text-info p-2 rounded-3 small border border-info border-opacity-10">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                            <span><i class="bi bi-arrow-repeat me-1"></i>Reschedule proposed</span>
                                                            <div>
                                                                <form
                                                                    action="<?php echo e(route('appointments.acceptReschedule', $appointment->id)); ?>"
                                                                    method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                                    <button type="submit" class="btn btn-success btn-xs py-0 px-2"
                                                                        style="font-size: 0.75rem;">Accept</button>
                                                                </form>
                                                                <form
                                                                    action="<?php echo e(route('appointments.declineReschedule', $appointment->id)); ?>"
                                                                    method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                                    <button type="submit" class="btn btn-danger btn-xs py-0 px-2"
                                                                        style="font-size: 0.75rem;">Decline</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php elseif($appointment->notes): ?>
                                                    <div class="bg-light p-2 rounded-3 small text-muted border">
                                                        <i class="bi bi-sticky me-1"></i><?php echo e(Str::limit($appointment->notes, 60)); ?>

                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-muted small fst-italic ps-1">
                                                        Topc: <?php echo e($appointment->nature_of_problem ?? 'General Counseling'); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="empty-state">
                                        <i class="bi bi-calendar-x"></i>
                                        <p class="mb-0">No upcoming appointments.</p>
                                    </div>
                                <?php endif; ?>
                                <div class="text-center mt-3">
                                    <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-outline-success"
                                        data-bs-toggle="tooltip" title="View all your appointments">
                                        <i class="bi bi-eye me-1"></i>View All Appointments
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Announcements (Moved here) -->
                        <div class="main-content-card h-100">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-megaphone me-2"></i>Announcements</h6>
                            </div>
                            <div class="card-body">
                                <?php $__empty_1 = true; $__currentLoopData = $recentAnnouncements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="announcement-item p-0 mb-4 overflow-hidden border bg-white"
                                        style="border-radius: 12px; box-shadow: var(--shadow-sm);">
                                        <?php if(!empty($announcement->images) && is_array($announcement->images) && count($announcement->images) > 0): ?>
                                            <div class="announcement-image" style="height: 250px; overflow: hidden;">
                                                <img src="<?php echo e(asset('storage/' . $announcement->images[0])); ?>"
                                                    alt="Announcement Image" class="w-100 h-100"
                                                    style="object-fit: cover; object-position: center;">
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-4">
                                            <h4 class="mb-3 fw-bold text-success"><?php echo e($announcement->title); ?></h4>
                                            <div class="mb-3 text-dark text-break"
                                                style="font-size: 1.05rem; line-height: 1.7; opacity: 0.9;">
                                                <?php echo e(Str::limit($announcement->content, 600)); ?>

                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                                <small class="text-muted">
                                                    <i
                                                        class="bi bi-calendar-event me-2"></i><?php echo e($announcement->created_at->format('F j, Y, g:i a')); ?>

                                                </small>
                                                <a href="<?php echo e(route('announcements.show', $announcement)); ?>"
                                                    class="btn btn-sm btn-link text-decoration-none fw-bold text-success">
                                                    Read Full Post <i class="bi bi-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="empty-state">
                                        <i class="bi bi-megaphone"></i>
                                        <p class="mb-0">No announcements available.</p>
                                    </div>
                                <?php endif; ?>
                                <div class="text-center mt-4 mb-4">
                                    <a href="<?php echo e(route('announcements.index')); ?>"
                                        class="btn btn-outline-success px-5 py-2 fw-semibold rounded-pill"
                                        data-bs-toggle="tooltip" title="View all announcements">
                                        View All Announcements
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- DASS-42 reminder modal -->
            <div class="modal fade" id="dassReminderModal" tabindex="-1" aria-labelledby="dassReminderLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered dass-modal">
                    <div class="modal-content">
                        <div class="dass-modal-header position-relative">
                            <div class="d-flex align-items-start gap-3 w-100">
                                <div class="dass-modal-icon flex-shrink-0">
                                    <i class="bi bi-clipboard-heart"></i>
                                </div>
                                <div class="flex-grow-1 pt-1">
                                    <h5 class="dass-modal-title mb-1">Complete the DASS-42 Assessment</h5>
                                    <p class="mb-0 text-white-50 small">This helps counselors tailor your session</p>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="dass-modal-body">
                            <p class="mb-3" style="font-size: 0.95rem; line-height: 1.6; color: var(--text-dark);">
                                Prior to booking, students are required to complete the DASS-42 assessment to help
                                counselors support you effectively.
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
                // Enable Bootstrap tooltips
                document.addEventListener('DOMContentLoaded', function () {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                        new bootstrap.Tooltip(tooltipTriggerEl);
                    });


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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/dashboard_student.blade.php ENDPATH**/ ?>