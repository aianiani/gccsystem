@extends('layouts.app')

@section('content')
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

        /* Page Zoom */
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
            padding: 2rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.3s ease;
        }

        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
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
                    <p style="margin: 0; font-size: 0.8rem; color: #fff; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
                        {{ auth()->user()->isCounselor() ? 'Counselor Portal' : 'Student Portal' }}</p>
                </div>
                <nav class="sidebar-nav">
                    @if(auth()->user()->isCounselor())
                        <a href="{{ route('counselor.appointments.index') }}"
                            class="sidebar-link{{ request()->routeIs('counselor.appointments.*') ? ' active' : '' }}"><i
                                class="bi bi-calendar-check"></i>Appointments</a>
                        <a href="{{ route('counselor.session_notes.index') }}"
                            class="sidebar-link{{ request()->routeIs('counselor.session_notes.*') ? ' active' : '' }}"><i
                                class="bi bi-journal-text"></i>Session Notes</a>
                        <a href="{{ route('counselor.assessments.index') }}"
                            class="sidebar-link{{ request()->routeIs('counselor.assessments.*') ? ' active' : '' }}"><i
                                class="bi bi-clipboard-data"></i>Assessments</a>
                        <a href="{{ route('profile') }}"
                            class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i
                                class="bi bi-person"></i>Profile</a>
                    @else
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
                            <div class="text-uppercase small px-3 mb-2" style="color: rgba(255,255,255,0.5); font-weight:700; font-size: 0.75rem; letter-spacing: 1px;">
                                Resources</div>
                            <a href="{{ route('resources') }}" class="sidebar-link active"><i class="bi bi-play-circle"></i>Orientation</a>
                            <a href="#" class="sidebar-link"><i class="bi bi-book"></i>Library</a>
                            <a href="#" class="sidebar-link"><i class="bi bi-gear"></i>Settings</a>
                        </div>
                    @endif
                </nav>
                <div class="sidebar-bottom w-100">
                    <a href="{{ route('logout') }}" class="sidebar-link logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form-resources').submit();">
                        <i class="bi bi-box-arrow-right"></i>Logout
                    </a>
                    <form id="logout-form-resources" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="container py-5 text-center">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card shadow-sm border-0 rounded-4 p-5" style="background: white;">
                                    <div class="mb-4">
                                        <i class="bi bi-journal-bookmark-fill display-1 text-success opacity-25"></i>
                                    </div>
                                    <h1 class="mb-3 fw-bold text-dark">Resources</h1>
                                    <p class="lead mb-4 text-muted">This feature is coming soon!</p>
                                    <div class="p-4 rounded-3 mb-4" style="background: var(--gray-50); border: 1px dashed var(--gray-600);">
                                        <p class="mb-0 text-dark">Guidance and counseling resources, orientation materials, and library links will be available in a future update to help you focus on your mental well-being and academic success.</p>
                                    </div>
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="{{ route('dashboard') }}" class="btn btn-success rounded-pill px-4 py-2">
                                            <i class="bi bi-house-door me-2"></i>Back to Dashboard
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle logic
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('studentSidebarToggle');
            
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endsection