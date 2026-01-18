@extends('layouts.app')

@section('content')
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

        /* DASS reminder modal styles */
        .dass-modal .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
        }

        .dass-modal-header {
            background: linear-gradient(135deg, var(--forest-green), var(--forest-green-dark));
            color: #fff;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dass-modal-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .dass-modal-body {
            padding: 1.75rem 1.75rem 1.25rem;
        }

        .dass-modal-body p {
            margin-bottom: 0.75rem;
            color: #4b5563;
        }

        .dass-modal-checklist {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .dass-modal-checklist li {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .dass-modal-checklist li i {
            color: var(--forest-green);
            margin-top: 2px;
        }

        .dass-modal-footer {
            padding: 0 1.75rem 1.75rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
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

        @media (max-width: 767.98px) {

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
                padding: 1rem;
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

        /* Constrain inner content and center it within the available area */
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

        .dashboard-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: start;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 0.75rem;
            align-items: stretch;
            /* ensure children stretch to equal height */
        }

        .dashboard-stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem 1rem;
            text-align: center;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 140px;
            /* ensure consistent card height */
        }

        .dashboard-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .dashboard-stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Hero CTA buttons inside welcome card */
        .btn-hero {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.06) 0%, rgba(255, 255, 255, 0.02) 100%);
            border: 2px solid rgba(255, 255, 255, 0.12);
            color: #fff;
            padding: 0.9rem 1.6rem;
            border-radius: 999px;
            font-weight: 700;
            box-shadow: 0 8px 30px rgba(17, 94, 37, 0.18);
            transition: transform 0.12s ease, box-shadow 0.12s ease;
        }

        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(17, 94, 37, 0.22);
        }

        .btn-ghost {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255, 255, 255, 0.14);
            padding: 0.8rem 1.4rem;
            border-radius: 999px;
            font-weight: 600;
        }

        /* Make main content cards use flex so headers and bodies behave predictably */
        .main-content-card,
        .quick-actions-sidebar {
            display: flex;
            flex-direction: column;
            min-height: 120px;
        }

        .main-content-card .card-body,
        .quick-actions-sidebar .card-body {
            flex: 1 1 auto;
        }

        .dashboard-stat-card .stat-label {
            font-size: 1rem;
            color: var(--forest-green-light);
            margin-bottom: 0.25rem;
        }

        .dashboard-stat-card .stat-subtitle {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 0.75rem;
        }

        .dashboard-stat-card .stat-progress {
            height: 6px;
            background-color: var(--gray-100);
            border-radius: 3px;
            overflow: hidden;
        }

        .dashboard-stat-card .stat-progress-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease-in-out;
        }

        .progress-success {
            background-color: var(--success);
        }

        .progress-warning {
            background-color: var(--warning);
        }

        .progress-info {
            background-color: var(--info);
        }

        .progress-danger {
            background-color: var(--danger);
        }

        .wellness-card {
            border-left: 4px solid var(--gray-100);
        }

        .wellness-card.normal {
            border-left-color: var(--success);
        }

        .wellness-card.moderate {
            border-left-color: var(--warning);
        }

        .wellness-card.high {
            border-left-color: var(--danger);
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
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .main-content-card .card-body {
            padding: 1.25rem;
        }

        .appointment-item {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
        }

        .appointment-item:hover {
            background: var(--forest-green-lighter);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .appointment-item:last-child {
            margin-bottom: 0;
        }

        .announcement-item {
            background: var(--gray-50);
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-left: 4px solid var(--forest-green);
            transition: all 0.2s ease;
        }

        .announcement-item:hover {
            background: var(--forest-green-lighter);
        }

        .announcement-item:last-child {
            margin-bottom: 0;
        }

        .message-preview {
            background: var(--gray-50);
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
        }

        .message-preview:hover {
            background: var(--forest-green-lighter);
        }

        .message-preview:last-child {
            margin-bottom: 0;
        }

        .quick-actions {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .quick-actions .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .quick-actions .card-body {
            padding: 1.5rem;
        }

        .quick-actions-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
            height: fit-content;
        }

        .quick-actions-sidebar .card-header {
            background: linear-gradient(180deg, rgba(34, 139, 34, 0.06), rgba(34, 139, 34, 0.02));
            color: var(--forest-green);
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .quick-actions-sidebar .card-body {
            padding: 1rem;
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

        .btn-outline-success:hover,
        .btn-outline-info:hover,
        .btn-outline-warning:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray-600);
            background: var(--gray-50);
            border-radius: 12px;
            border: 2px dashed var(--gray-100);
        }

        /* Small refinements for spacing */
        .sidebar-logo img {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .sidebar-link {
            padding-left: 1.1rem;
            padding-right: 1.1rem;
        }

        .sidebar-link i {
            font-size: 1.1rem;
        }

        .empty-state i {
            font-size: 2rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        @media (max-width: 991px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 1.2rem;
            }

            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 2rem 1.5rem;
                text-align: center;
            }

            .main-dashboard-content {
                padding: 1.5rem 1rem;
            }
        }

        @media (max-width: 768px) {
            .welcome-card .welcome-text {
                font-size: 1.8rem;
            }

            .dashboard-stat-card {
                padding: 1.5rem 1rem;
            }

            .main-content-card .card-header,
            .main-content-card .card-body,
            .quick-actions .card-header,
            .quick-actions .card-body {
                padding: 1rem;
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
            <div class="custom-sidebar">
                <div class="sidebar-logo">
                    <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo"
                        style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <h3
                        style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
                        CMU Guidance and Counseling Center</h3>
                    <p
                        style="margin: 0; font-size: 0.8rem; color: #fff; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
                        Student Portal</p>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i
                            class="bi bi-house-door"></i>Dashboard</a>
                    <a href="{{ route('profile') }}"
                        class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i
                            class="bi bi-person"></i>Profile</a>
                    <a href="{{ route('appointments.index') }}"
                        class="sidebar-link{{ request()->routeIs('appointments.*') && !request()->routeIs('appointments.completedWithNotes') ? ' active' : '' }}"><i
                            class="bi bi-calendar-check"></i>Appointments</a>
                    <a href="{{ route('appointments.completedWithNotes') }}"
                        class="sidebar-link{{ request()->routeIs('appointments.completedWithNotes') ? ' active' : '' }}"><i
                            class="bi bi-journal-text"></i>Sessions & Feedback</a>
                    <a href="{{ route('assessments.index') }}"
                        class="sidebar-link{{ request()->routeIs('assessments.*') ? ' active' : '' }}"><i
                            class="bi bi-clipboard-data"></i>Assessments</a>
                    <a href="{{ route('chat.selectCounselor') }}"
                        class="sidebar-link{{ request()->routeIs('chat.selectCounselor') ? ' active' : '' }}"><i
                            class="bi bi-chat-dots"></i>Chat with a Counselor</a>

                    <div class="sidebar-divider my-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"></div>
                    <div class="sidebar-resources">
                        <div class="text-uppercase small px-3 mb-2"
                            style="color: rgba(255,255,255,0.5); font-weight:700; font-size: 0.75rem; letter-spacing: 1px;">
                            Resources</div>
                        <a href="#" class="sidebar-link"><i class="bi bi-play-circle"></i>Orientation</a>
                        <a href="#" class="sidebar-link"><i class="bi bi-book"></i>Library</a>
                        <a href="#" class="sidebar-link"><i class="bi bi-gear"></i>Settings</a>
                    </div>
                </nav>
                <div class="sidebar-bottom w-100">
                    <a href="{{ route('logout') }}" class="sidebar-link logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form-dashboard').submit();">
                        <i class="bi bi-box-arrow-right"></i>Logout
                    </a>
                    <form id="logout-form-dashboard" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="welcome-card position-relative overflow-hidden">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4 position-relative"
                            style="z-index: 2;">
                            <div class="d-flex align-items-center gap-4">
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

                            <div class="d-flex flex-column align-items-end">
                                <div class="text-white-50 text-uppercase fw-bold mb-2"
                                    style="font-size: 0.7rem; letter-spacing: 0.5px;">Seminar Progress</div>
                                <div class="d-flex flex-wrap gap-2 justify-content-end">
                                    @php
                                        $badges = [
                                            'IDREAMS' => ['color' => 'bg-info bg-opacity-25 text-white border-info', 'icon' => 'bi-clouds-fill', 'year' => 1],
                                            '10C' => ['color' => 'bg-warning bg-opacity-25 text-white border-warning', 'icon' => 'bi-lightbulb-fill', 'year' => 2],
                                            'LEADS' => ['color' => 'bg-primary bg-opacity-25 text-white border-primary', 'icon' => 'bi-people-fill', 'year' => 3],
                                            'IMAGE' => ['color' => 'bg-success bg-opacity-25 text-white border-success', 'icon' => 'bi-person-badge-fill', 'year' => 4],
                                        ];
                                    @endphp

                                    @foreach($badges as $seminarName => $style)
                                        @php
                                            $isAttended = isset($attendanceMatrix[$style['year']][$seminarName]);
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-3 border transition-all text-center
                                                                                                    {{ $isAttended ? $style['color'] . ' shadow-sm' : 'border-white-10 text-white-50' }}"
                                            style="background: {{ $isAttended ? '' : 'rgba(255, 255, 255, 0.05)' }}; 
                                                                                                           border-color: {{ $isAttended ? '' : 'rgba(255, 255, 255, 0.1)' }};
                                                                                                           backdrop-filter: blur(4px); min-width: 100px;">
                                            @if($isAttended)
                                                <i class="bi {{ $style['icon'] }}"></i>
                                                <span class="fw-bold small">{{ $seminarName }}</span>
                                            @else
                                                <i class="bi bi-lock-fill opacity-50"></i>
                                                <span class="small opacity-75">{{ $seminarName }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>



                    <style>
                        /* Override for single column layout */
                        .dashboard-layout {
                            /* Simply a container now, no grid needed for layout split */
                            display: block;
                        }

                        /* Ensure stats grid can accommodate the new card nicely */
                        .dashboard-stats {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                            gap: 1.25rem;
                            align-items: stretch;
                        }
                    </style>

                    <div class="dashboard-layout">
                        <div class="dashboard-stats">
                            <div class="dashboard-stat-card">
                                <div class="stat-value">{{ $studentStats['sessionProgress'] }}%</div>
                                <div class="stat-label">Session Progress</div>
                                <div class="stat-subtitle">
                                    {{ $studentStats['totalSessions'] }}/{{ $studentStats['totalScheduled'] }} completed
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar progress-success"
                                        style="width: {{ $studentStats['sessionProgress'] }}%"></div>
                                </div>
                            </div>

                            <div class="dashboard-stat-card">
                                <div class="stat-value">{{ $studentStats['assessmentProgress'] }}%</div>
                                <div class="stat-label">Assessments Done</div>
                                <div class="stat-subtitle">
                                    {{ $studentStats['completedAssessments'] }}/{{ $studentStats['totalAssessments'] }}
                                    completed
                                </div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar progress-info"
                                        style="width: {{ $studentStats['assessmentProgress'] }}%"></div>
                                </div>
                            </div>

                            <!-- Seminar Progress Card -->
                            <div class="dashboard-stat-card">
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
                                <div class="stat-value">{{ $attendedSeminars }}/{{ $totalSeminars }}</div>
                                <div class="stat-label">Seminars Attended</div>
                                <div class="stat-subtitle">Required seminars completed</div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar progress-info" style="width: {{ $seminarProgress }}%">
                                    </div>
                                </div>
                            </div>



                            <!-- Book Appointment CTA (Merged into Grid) -->
                            <div class="dashboard-stat-card d-flex flex-column align-items-center justify-content-center p-4"
                                style="background: #fff; border: 1px solid var(--forest-green); box-shadow: var(--shadow-sm); min-height: 200px;">

                                <div class="mb-3">
                                    <div
                                        style="width: 48px; height: 48px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                        <i class="bi bi-calendar-plus-fill"
                                            style="color: var(--forest-green); font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold mb-4" style="color: var(--forest-green);">Book a Session</h5>
                                <a href="#" class="btn w-100 fw-bold js-book-appointment-trigger"
                                    style="background: var(--yellow-maize); color: var(--text-dark); border: none; border-radius: 50px; padding: 0.8rem 1rem; font-size: 1rem; box-shadow: var(--shadow-sm);">
                                    Book Appointment
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="main-content-card">
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
                                <div class="appointment-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-bold">Counseling Session</h6>
                                            <p class="text-muted mb-1">
                                                <i
                                                    class="bi bi-person me-1"></i>{{ $appointment->counselor->name ?? 'Counselor' }}
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="bi bi-calendar me-1"></i>{{ $start->format('F j, Y') }} at
                                                {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}
                                            </p>
                                            @if($appointment->status === 'accepted')
                                                <div class="mt-1 text-success small">
                                                    <i class="bi bi-journal-text me-1"></i>Your Appointment has been accepted,
                                                    please proceed to GCC on {{ $start->format('M d, Y') }} at
                                                    {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}.
                                                </div>
                                            @elseif($appointment->status === 'completed')
                                                <div class="mt-1 text-primary small">
                                                    <i class="bi bi-journal-text me-1"></i>Session notes available.
                                                </div>
                                            @elseif($appointment->status === 'declined')
                                                <div class="mt-1 text-danger small">
                                                    <i class="bi bi-journal-text me-1"></i>Your appointment was declined. Please
                                                    select another available slot or contact the GCC for assistance.
                                                </div>
                                            @elseif($appointment->status === 'rescheduled_pending')
                                                <div class="mt-1 text-info small">
                                                    <i class="bi bi-arrow-repeat me-1"></i>Your counselor has proposed a new slot.
                                                    Please accept or decline below.
                                                </div>
                                                <div class="mt-2">
                                                    <form action="{{ route('appointments.acceptReschedule', $appointment->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm me-2">
                                                            <i class="bi bi-check-circle me-1"></i>Accept
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('appointments.declineReschedule', $appointment->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-x-circle me-1"></i>Decline
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($appointment->notes)
                                                <div class="mt-1 text-muted small">
                                                    <i class="bi bi-journal-text me-1"></i>{{ Str::limit($appointment->notes, 60) }}
                                                </div>
                                            @else
                                                <div class="mt-1 text-muted small">
                                                    <i class="bi bi-journal-text me-1"></i>No notes
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-primary">{{ ucfirst($appointment->status) }}</span>
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

                    <div class="main-content-card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-megaphone me-2"></i>Announcements</h6>
                        </div>
                        <div class="card-body">
                            @forelse($recentAnnouncements as $announcement)
                                <div class="announcement-item p-0 mb-4 overflow-hidden border bg-white"
                                    style="border-radius: 12px; box-shadow: var(--shadow-sm);">
                                    @if(!empty($announcement->images) && is_array($announcement->images) && count($announcement->images) > 0)
                                        <div class="announcement-image" style="height: 250px; overflow: hidden;">
                                            <img src="{{ asset('storage/' . $announcement->images[0]) }}" alt="Announcement Image"
                                                class="w-100 h-100" style="object-fit: cover; object-position: center;">
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

                    <div class="main-content-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Recent Messages</h5>
                            <a href="{{ route('chat.selectCounselor') }}" class="btn btn-light btn-sm"
                                data-bs-toggle="tooltip" title="Open chat with your counselor">
                                <i class="bi bi-chat-dots me-1"></i>Open Chat
                            </a>
                        </div>
                        <div class="card-body">
                            @forelse($recentMessages as $message)
                                <div class="message-preview">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0 fw-bold">{{ $message['sender_name'] }}</h6>
                                        <small class="text-muted">{{ $message['time_ago'] }}</small>
                                    </div>
                                    <p class="mb-0 text-muted">{{ Str::limit($message['content'], 80) }}</p>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="bi bi-chat-dots"></i>
                                    <p class="mb-2">No recent messages</p>
                                    <a href="{{ route('chat.selectCounselor') }}" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-chat-dots me-1"></i>Start a Conversation
                                    </a>
                                </div>
                            @endforelse
                            @if($recentMessages->count() > 0)
                                <div class="text-center mt-3">
                                    <a href="{{ route('chat.selectCounselor') }}" class="btn btn-outline-success btn-sm"
                                        data-bs-toggle="tooltip" title="View all your messages">
                                        <i class="bi bi-eye me-1"></i>View All Messages
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- DASS-42 reminder modal -->
    <div class="modal fade" id="dassReminderModal" tabindex="-1" aria-labelledby="dassReminderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered dass-modal">
            <div class="modal-content">
                <div class="dass-modal-header">
                    <div class="dass-modal-icon">
                        <i class="bi bi-clipboard-heart"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-semibold" id="dassReminderLabel">Complete the DASS-42 Assessment</p>
                        <small class="text-white-50">This helps counselors tailor your session</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="dass-modal-body">
                    <p>Prior to booking an appointment, students are required to complete the DASS-42 assessment. This brief
                        assessment provides counselors with essential insights to support you effectively.</p>
                    <p class="text-muted small mb-0">Once you finish the assessment, you’ll be able to proceed with booking
                        your appointment</p>
                </div>
                <div class="dass-modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Maybe Later</button>
                    <a href="{{ route('consent.show') }}" class="btn btn-success">
                        Proceed
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