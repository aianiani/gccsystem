@extends('layouts.app')

@section('content')
@section('full_width', true)
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

        /* DASS reminder modal styles */
        .dass-modal .modal-content {
            border: none;
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .dass-modal-header {
            background: var(--hero-gradient);
            color: #fff;
            border: none;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dass-modal-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dass-modal-body {
            padding: 2rem;
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
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.3;
        }

        .dass-modal-footer {
            padding: 1.5rem 2rem;
            background: #f9fafb;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
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

        /* Hero Section - The "Showstopper" */
        .welcome-card {
            background: var(--hero-gradient);
            position: relative;
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            padding: 2.5rem 3rem;
            margin-bottom: 2.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Abstract Background Pattern for Hero */
        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 203, 5, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-card-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 2rem;
            width: 100%;
        }

        .welcome-avatar-wrapper {
            position: relative;
        }

        .welcome-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            padding: 4px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .welcome-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .welcome-text h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
            color: #ffffff;
            /* Explicitly white for better contrast */
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-date {
            font-size: 0.95rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 0, 0, 0.2);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            margin-bottom: 0.75rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
        }

        /* Seminar Badges with Glassmorphism */
        .seminar-badges-container {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 20px;
            padding: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            min-width: 320px;
        }

        .seminar-badge {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 1rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
            cursor: default;
        }

        .seminar-badge.completed {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .seminar-badge.completed i {
            color: var(--accent-orange);
            filter: drop-shadow(0 0 5px rgba(255, 203, 5, 0.6));
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

        /* Responsive */
        @media (max-width: 991px) {
            .welcome-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 2rem;
                gap: 2rem;
            }

            .welcome-card-content {
                flex-direction: column;
                text-align: center;
            }

            .seminar-badges-container {
                width: 100%;
                min-width: unset;
            }
        }

        @media (max-width: 768px) {
            .welcome-card {
                padding: 1.25rem 1rem !important;
                border-radius: 16px;
                gap: 1.25rem !important;
            }

            .welcome-avatar {
                width: 70px;
                height: 70px;
            }

            .welcome-text h1 {
                font-size: 1.35rem;
                margin-bottom: 0.25rem;
            }

            .welcome-date {
                font-size: 0.85rem;
                padding: 0.2rem 0.6rem;
                margin-bottom: 0.5rem;
            }

            .seminar-badge {
                min-width: 70px !important;
                padding: 0.4rem 0.6rem !important;
                font-size: 0.75rem !important;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="studentSidebarToggle" class="d-md-none">
                <i class="bi bi-list"></i>
            </button>

            <!-- Sidebar -->
            @include('student.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">

                    <!-- Premium Hero Section -->
                    <div class="welcome-card position-relative overflow-hidden">
                        <!-- Hero Content... -->
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-3 gap-md-4 position-relative"
                            style="z-index: 2;">
                            <div class="d-flex flex-column flex-md-row align-items-center gap-3 gap-md-4">
                                <div class="welcome-avatar flex-shrink-0">
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 3px solid rgba(255,255,255,0.3);">
                                </div>
                                <div>
                                    <div class="welcome-date mb-1 opacity-75"><i
                                            class="bi bi-calendar-event me-2"></i>{{ now()->format('F j, Y') }}</div>
                                    <div class="welcome-text mb-2">Welcome back,
                                        {{ auth()->user()->first_name ?? auth()->user()->name }}!
                                    </div>
                                    <div style="font-size: 0.95rem; opacity: 0.9;">Always stay updated in your student
                                        portal</div>
                                </div>
                            </div>
                            <!-- Seminar Badges... -->
                            <div class="d-flex flex-column align-items-end">
                                <div class="text-white-50 text-uppercase fw-bold mb-2"
                                    style="font-size: 0.7rem; letter-spacing: 0.5px;">Seminar Progress</div>
                                <div class="d-flex flex-wrap gap-2 justify-content-end">
                                    @php
                                        $badges = [
                                            'New Student Orientation Program' => ['color' => 'bg-secondary bg-opacity-25 text-white border-secondary', 'icon' => 'bi-compass-fill', 'year' => 1, 'label' => 'NSOP'],
                                            'IDREAMS' => ['color' => 'bg-info bg-opacity-25 text-white border-info', 'icon' => 'bi-clouds-fill', 'year' => 1],
                                            '10C' => ['color' => 'bg-warning bg-opacity-25 text-white border-warning', 'icon' => 'bi-lightbulb-fill', 'year' => 2],
                                            'LEADS' => ['color' => 'bg-primary bg-opacity-25 text-white border-primary', 'icon' => 'bi-people-fill', 'year' => 3],
                                            'IMAGE' => ['color' => 'bg-success bg-opacity-25 text-white border-success', 'icon' => 'bi-person-badge-fill', 'year' => 4],
                                        ];
                                    @endphp

                                    @foreach($badges as $seminarName => $style)
                                        @php
                                            $attendance = $attendanceMatrix[$style['year']][$seminarName] ?? null;
                                            $isCompleted = $attendance && ($attendance['status'] ?? '') === 'completed';
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 border transition-all text-center
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $isCompleted ? $style['color'] . ' shadow-sm' : 'border-white-10 text-white-50' }}"
                                            style="background: {{ $isCompleted ? '' : 'rgba(255, 255, 255, 0.05)' }};
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                border-color: {{ $isCompleted ? '' : 'rgba(255, 255, 255, 0.1)' }};
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                backdrop-filter: blur(4px); min-width: 100px;">
                                            @if($isCompleted)
                                                <i class="bi {{ $style['icon'] }}"></i>
                                                <span class="fw-bold small">{{ $style['label'] ?? $seminarName }}</span>
                                            @else
                                                <i class="bi bi-lock-fill opacity-50"></i>
                                                <span class="small opacity-75">{{ $style['label'] ?? $seminarName }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Stats Grid -->
                    <div class="stats-grid">
                        {{-- Notification Bell (Same as Counselor) --}}
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
                        @php
                            $unreadCount = auth()->user()->unreadNotifications()->count();
                            // Show ALL notifications (both read and unread) - most recent 10
                            $recentNotifications = auth()->user()->notifications()->latest()->take(10)->get();
                        @endphp
                        {{-- DEBUG: Notification count: {{ $recentNotifications->count() }}, Unread: {{ $unreadCount }} --}}
                        <div class="notification-bell-wrapper"
                            style="position: fixed; top: 1.5rem; right: 2.5rem; z-index: 9999;">
                            <div class="dropdown me-3">
                                <button
                                    class="btn notification-bell position-relative p-0{{ $unreadCount > 0 ? ' pulse' : '' }}"
                                    type="button" id="notificationDropdown" onclick="toggleNotificationDropdown()">
                                    <i class="bi bi-bell"></i>
                                    @if($unreadCount > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge notification-bell-badge">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </button>
                                <ul class="notification-dropdown-menu" id="notificationMenu" style="display: none;">
                                    <li class="notification-dropdown-header">Notifications</li>
                                    @forelse($recentNotifications as $notification)
                                        <li class="notification-item{{ is_null($notification->read_at) ? ' bg-light' : '' }}">
                                            <div class="notification-icon">
                                                @if(isset($notification->data['appointment_id']))
                                                    <i class="bi bi-calendar-check"></i>
                                                @else
                                                    <i class="bi bi-info-circle"></i>
                                                @endif
                                            </div>
                                            <div class="notification-content">
                                                {{ $notification->data['message'] ?? 'You have a new notification.' }}
                                                @if(is_null($notification->read_at))
                                                    <span class="badge bg-primary ms-2" style="font-size: 0.7rem;">New</span>
                                                @endif
                                                <div class="text-muted small mt-1">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <div class="notification-actions">
                                                @if(isset($notification->data['appointment_id']))
                                                    <a href="{{ route('appointments.index') }}" class="btn-view"
                                                        title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @elseif(isset($notification->data['type']) && $notification->data['type'] === 'seminar_unlocked')
                                                    <a href="{{ route('student.seminars.index') }}" class="btn-view"
                                                        title="View Guidance Program">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                                <form method="POST"
                                                    action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link" title="Dismiss">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="notification-empty">
                                            <i class="bi bi-bell-slash"></i>
                                            <div>No new notifications</div>
                                        </li>
                                    @endforelse
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
                                <div class="stat-value">{{ $studentStats['sessionProgress'] }}%</div>
                                <div class="stat-label">Session Progress</div>
                                <div class="stat-meta">
                                    {{ $studentStats['totalSessions'] }}/{{ $studentStats['totalScheduled'] }}
                                    completed
                                </div>
                            </div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: {{ $studentStats['sessionProgress'] }}%"></div>
                            </div>
                        </div>

                        <div class="dashboard-stat-card">
                            <i class="bi bi-file-earmark-text bg-icon"></i>
                            <div>
                                <div class="stat-value">{{ $studentStats['assessmentProgress'] }}%</div>
                                <div class="stat-label">Assessments Done</div>
                                <div class="stat-meta">
                                    {{ $studentStats['completedAssessments'] }}/{{ $studentStats['totalAssessments'] }}
                                    completed
                                </div>
                            </div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: {{ $studentStats['assessmentProgress'] }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Seminar Progress Card -->
                        <div class="dashboard-stat-card">
                            <i class="bi bi-people bg-icon"></i>
                            @php
                                $attendedSeminars = 0;
                                $totalSeminars = 4;
                                if (isset($attendanceMatrix)) {
                                    foreach ($attendanceMatrix as $year => $seminars) {
                                        $attendedSeminars += count($seminars);
                                    }
                                }
                                $seminarProgress = ($attendedSeminars / $totalSeminars) * 100;
                            @endphp
                            <div>
                                <div class="stat-value">{{ $attendedSeminars }}/{{ $totalSeminars }}</div>
                                <div class="stat-label">Seminars Attended</div>
                                <div class="stat-meta">Required seminars completed</div>
                            </div>
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: {{ $seminarProgress }}%"></div>
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
                                @forelse($upcomingAppointments as $appointment)
                                    @php
                                        $start = $appointment->scheduled_at;
                                        $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                                            ->where('start', $start)
                                            ->first();
                                        $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                                    @endphp
                                    <div class="appointment-item p-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Counselor Avatar -->
                                            <div class="flex-shrink-0">
                                                <img src="{{ $appointment->counselor->avatar_url }}"
                                                    alt="{{ $appointment->counselor->name }}" class="rounded-circle border"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>

                                            <!-- Appointment Details -->
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold text-dark">
                                                        {{ $appointment->counselor->name ?? 'Counselor' }}
                                                    </h6>
                                                    <span
                                                        class="badge bg-primary rounded-pill px-3">{{ $appointment->status === 'accepted' ? 'Approved' : ucfirst($appointment->status) }}</span>
                                                </div>

                                                <div class="text-muted small mb-2">
                                                    <i class="bi bi-calendar-event me-1"></i>{{ $start->format('F j, Y') }}
                                                    &bull;
                                                    <i class="bi bi-clock me-1 ms-1"></i>{{ $start->format('g:i A') }} –
                                                    {{ $end->format('g:i A') }}
                                                </div>

                                                @if($appointment->status === 'accepted')
                                                    <div
                                                        class="bg-success bg-opacity-10 text-success p-2 rounded-3 small border border-success border-opacity-10">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        <strong>Approved!</strong> Please proceed to GCC on scheduled time.
                                                    </div>
                                                @elseif($appointment->status === 'completed')
                                                    <div
                                                        class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 small border border-primary border-opacity-10">
                                                        <i class="bi bi-journal-check me-1"></i>
                                                        Session completed. <a href="{{ route('appointments.completedWithNotes') }}"
                                                            class="fw-bold text-primary">View Notes</a>
                                                    </div>
                                                @elseif($appointment->status === 'declined')
                                                    <div
                                                        class="bg-danger bg-opacity-10 text-danger p-2 rounded-3 small border border-danger border-opacity-10">
                                                        <i class="bi bi-x-circle-fill me-1"></i>
                                                        Appointment declined. Please book another slot.
                                                    </div>
                                                @elseif($appointment->status === 'rescheduled_pending')
                                                    <div
                                                        class="bg-info bg-opacity-10 text-info p-2 rounded-3 small border border-info border-opacity-10">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                            <span><i class="bi bi-arrow-repeat me-1"></i>Reschedule proposed</span>
                                                            <div>
                                                                <form
                                                                    action="{{ route('appointments.acceptReschedule', $appointment->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf @method('PATCH')
                                                                    <button type="submit" class="btn btn-success btn-xs py-0 px-2"
                                                                        style="font-size: 0.75rem;">Accept</button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('appointments.declineReschedule', $appointment->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf @method('PATCH')
                                                                    <button type="submit" class="btn btn-danger btn-xs py-0 px-2"
                                                                        style="font-size: 0.75rem;">Decline</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($appointment->notes)
                                                    <div class="bg-light p-2 rounded-3 small text-muted border">
                                                        <i class="bi bi-sticky me-1"></i>{{ Str::limit($appointment->notes, 60) }}
                                                    </div>
                                                @else
                                                    <div class="text-muted small fst-italic ps-1">
                                                        Topc: {{ $appointment->nature_of_problem ?? 'General Counseling' }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-state">
                                        <i class="bi bi-calendar-x"></i>
                                        <p class="mb-0">No upcoming appointments.</p>
                                    </div>
                                @endforelse
                                <div class="text-center mt-3">
                                    <a href="{{ route('appointments.index') }}" class="btn btn-outline-success"
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
                                @forelse($recentAnnouncements as $announcement)
                                    <div class="announcement-item p-0 mb-4 overflow-hidden border bg-white"
                                        style="border-radius: 12px; box-shadow: var(--shadow-sm);">
                                        @if(!empty($announcement->images) && is_array($announcement->images) && count($announcement->images) > 0)
                                            <div class="announcement-image" style="height: 250px; overflow: hidden;">
                                                <img src="{{ asset('storage/' . $announcement->images[0]) }}"
                                                    alt="Announcement Image" class="w-100 h-100"
                                                    style="object-fit: cover; object-position: center;">
                                            </div>
                                        @endif
                                        <div class="p-4">
                                            <h4 class="mb-3 fw-bold text-success">{{ $announcement->title }}</h4>
                                            <div class="mb-3 text-dark text-break"
                                                style="font-size: 1.05rem; line-height: 1.7; opacity: 0.9;">
                                                {{ Str::limit($announcement->content, 600) }}
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                                <small class="text-muted">
                                                    <i
                                                        class="bi bi-calendar-event me-2"></i>{{ $announcement->created_at->format('F j, Y, g:i a') }}
                                                </small>
                                                <a href="{{ route('announcements.show', $announcement) }}"
                                                    class="btn btn-sm btn-link text-decoration-none fw-bold text-success">
                                                    Read Full Post <i class="bi bi-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-state">
                                        <i class="bi bi-megaphone"></i>
                                        <p class="mb-0">No announcements available.</p>
                                    </div>
                                @endforelse
                                <div class="text-center mt-4 mb-4">
                                    <a href="{{ route('announcements.index') }}"
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
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="dass-modal-body">
                            <p class="mb-3" style="font-size: 1.05rem; line-height: 1.6; color: var(--text-dark);">
                                Prior to booking an appointment, students are required to complete the DASS-42 assessment. 
                                This brief assessment provides counselors with essential insights to support you effectively.
                            </p>
                            <div class="d-flex gap-2 text-muted small align-items-start bg-light p-3 rounded-3">
                                <i class="bi bi-info-circle-fill mt-1 flex-shrink-0 text-primary opacity-75"></i>
                                <span>Once you finish the assessment, you’ll be able to proceed with booking your appointment immediately.</span>
                            </div>
                        </div>
                        <div class="dass-modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Maybe Later</button>
                            <a href="{{ route('consent.show') }}" class="btn btn-success px-4 fw-semibold">
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
                    // Sidebar toggle for mobile
                    const sidebar = document.querySelector('.custom-sidebar');
                    const toggleBtn = document.getElementById('studentSidebarToggle');
                    const closeBtn = document.getElementById('studentSidebarClose');

                    if (toggleBtn && sidebar) {
                        toggleBtn.addEventListener('click', function () {
                            sidebar.classList.toggle('show');
                        });

                        if (closeBtn) {
                            closeBtn.addEventListener('click', function () {
                                sidebar.classList.remove('show');
                            });
                        }

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
@endsection