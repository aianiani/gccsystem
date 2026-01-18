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
            --gray-200: #e9ecef;
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

        .page-header {
            background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
            color: white;
            border-radius: 16px;
            padding: 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .counselor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .counselor-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .counselor-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--forest-green-light);
        }

        .counselor-header {
            background: linear-gradient(135deg, var(--forest-green-lighter) 0%, var(--yellow-maize-light) 100%);
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .counselor-avatar {
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

        .counselor-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
        }

        .counselor-role {
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

        .counselor-body {
            padding: 1.5rem;
        }

        .counselor-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: var(--gray-50);
            border-radius: 8px;
        }

        .counselor-info i {
            color: var(--forest-green);
            font-size: 1.1rem;
            width: 20px;
        }

        .counselor-info span {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .counselor-stats {
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
            background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
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
        }

        .chat-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
            text-decoration: none;
        }

        .chat-btn:active {
            transform: translateY(0);
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

        .back-btn {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            background: var(--forest-green-light);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 2rem 1rem;
                margin-bottom: 2rem;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .counselor-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .counselor-stats {
                grid-template-columns: 1fr;
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
                        onclick="event.preventDefault(); document.getElementById('logout-form-chat').submit();">
                        <i class="bi bi-box-arrow-right"></i>Logout
                    </a>
                    <form id="logout-form-chat" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="container-fluid py-1">
                        <div class="page-header">
                            <h1>
                                <i class="bi bi-chat-dots me-2"></i>
                                Choose Your Counselor
                            </h1>
                            <p>Select a counselor to start a conversation and get the support you need</p>
                        </div>

                        <div class="container">

                            @if($counselors->count() > 0)
                                <div class="inbox-list">
                                    @foreach($counselors as $counselor)
                                        <a href="{{ route('chat.index', $counselor->id) }}" class="inbox-item">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    @if($counselor->avatar)
                                                        <img src="{{ $counselor->avatar_url }}" alt="Avatar" class="rounded-circle"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-success text-white"
                                                            style="width: 50px; height: 50px; font-weight: bold; font-size: 1.2rem;">
                                                            {{ strtoupper(substr($counselor->name ?? 'C', 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div class="status-indicator"></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h6 class="mb-0 font-weight-bold text-dark">{{ $counselor->name }}</h6>
                                                        @if($counselor->last_message)
                                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                                {{ $counselor->last_message->created_at->diffForHumans(null, true, true) }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                    <p class="mb-0 text-muted small text-truncate" style="max-width: 250px;">
                                                        @if($counselor->last_message)
                                                            @if($counselor->last_message->sender_id === auth()->id())
                                                                <span class="fw-bold text-dark">You:</span>
                                                            @endif
                                                            {{ $counselor->last_message->content ?: ($counselor->last_message->image ? 'Sent an image' : '') }}
                                                        @else
                                                            {{ $counselor->email }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <i class="bi bi-chevron-right text-muted"></i>
                                            </div>
                                        </a>
                                    @endforeach
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
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-people"></i>
                                    <h3>No Counselors Available</h3>
                                    <p class="mb-0">There are currently no counselors available for chat. Please check back
                                        later or contact support for assistance.</p>
                                </div>
                            @endif
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
        });
    </script>
@endsection