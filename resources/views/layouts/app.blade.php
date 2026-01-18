<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GCC System') }}</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}" />
    <!-- SweetAlert2 -->
    <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- Google Fonts (Inter) - Local -->
    <link href="{{ asset('vendor/fonts/inter/inter.css') }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-light: #2e7d32;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #FFCB05;
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #eef6ee;
            --gray-600: #6c757d;
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --radius: 16px;
            --input-radius: 10px;
            --transition: 0.2s;

            /* Re-mapping university branding to ensure overrides */
            --university-blue: #1f7a2d;
            --university-light-blue: #e8f5e8;
            --primary: #1f7a2d;
            --primary-light: #e8f5e8;
            --accent: #FFCB05;
            --sidebar-bg: linear-gradient(135deg, #1f7a2d 0%, #13601f 100%);
        }

        #adminSidebar,
        .custom-sidebar {
            background: #1f7a2d !important;
            background: var(--sidebar-bg) !important;
        }

        /* Centralized home-zoom variables and behavior
           Ensures scaled pages correctly account for the fixed sidebar width
           so the sidebar does not overlap content when zooming. */
        :root {
            --sidebar-width: 275px;
            --home-zoom: 0.75;
            /* adjust this value to change overall zoom */
        }

        .home-zoom {
            --zoom: var(--home-zoom);
            zoom: var(--zoom);
        }

        /* For browsers that don't support `zoom` use CSS transform as fallback */
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(var(--zoom));
                transform-origin: top center;
            }
        }



        @media (max-width: 991.98px) {

            .home-zoom .main-dashboard-content,
            .home-zoom #mainContent {
                margin-left: calc(200px * var(--zoom)) !important;
            }
        }

        @media (max-width: 767.98px) {

            /* Disable zoom on small screens to avoid layout issues */
            .home-zoom {
                zoom: 1 !important;
                transform: none !important;
            }

            .home-zoom .main-dashboard-content,
            .home-zoom #mainContent {
                margin-left: 0 !important;
            }
        }

        html {
            font-size: 18px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e8f5e8 100%);
            min-height: 100vh;
            color: var(--forest-green);
            line-height: 1.7;
            transition: background 0.3s, color 0.3s;
        }

        .container {
            max-width: 1200px;
        }

        .card,
        .card-header,
        .card-body,
        .form-control,
        .form-select {
            background: var(--white) !important;
            color: var(--forest-green) !important;
            border-radius: var(--radius) !important;
        }

        .card {
            border: none;
            box-shadow: var(--shadow-sm);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background: var(--forest-green-lighter) !important;
            color: var(--forest-green) !important;
            border: none;
            padding: 1.5rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 2rem;
        }

        .btn {
            font-weight: 600;
            border-radius: 999px;
            padding: 0.8rem 1.7rem;
            font-size: 1rem;
            transition: all var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
            outline: none;
            letter-spacing: 0.01em;
            box-shadow: 0 1px 3px var(--shadow-sm);
        }

        .btn-primary,
        .btn-success,
        .btn-warning,
        .btn-danger,
        .btn-secondary {
            color: white;
        }

        .btn-primary {
            background: var(--forest-green);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--forest-green-light);
        }

        .btn-success {
            background: var(--success);
        }

        .btn-success:hover,
        .btn-success:focus {
            background: #218838;
        }

        .btn-warning {
            background: var(--yellow-maize);
            color: var(--forest-green);
        }

        .btn-warning:hover,
        .btn-warning:focus {
            background: #ffe066;
            color: var(--forest-green);
        }

        .btn-danger {
            background: var(--danger);
        }

        .btn-danger:hover,
        .btn-danger:focus {
            background: #b52a37;
        }

        .btn-secondary {
            background: var(--gray-600);
        }

        .btn-secondary:hover,
        .btn-secondary:focus {
            background: #495057;
        }

        .btn-outline-primary {
            border: 2px solid var(--forest-green);
            color: var(--forest-green);
            background: transparent;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            background: var(--forest-green-light);
            color: white;
        }

        .badge {
            border-radius: 999px;
            font-size: 1rem;
            font-weight: 600;
            padding: 0.5em 1.2em;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.08);
        }

        /* Prevent brand and user menu overlap in navbar */
        .navbar .container-fluid {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .navbar .navbar-brand {
            flex: 1 1 auto;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .navbar .ms-auto {
            flex-shrink: 0;
        }

        .form-control,
        .form-select {
            border-radius: var(--input-radius);
            border: 1.5px solid var(--gray-100);
            padding: 0.75rem 1.2rem;
            font-size: 1rem;
            box-shadow: 0 1px 3px var(--shadow-sm);
            margin-bottom: 1.2rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--forest-green-light);
            box-shadow: 0 0 0 3px rgba(44, 124, 89, 0.08);
            outline: none;
        }

        .form-label {
            color: var(--forest-green);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .alert {
            border: none;
            border-radius: var(--radius);
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 2px 8px 0 rgba(30, 41, 59, 0.07);
            margin-bottom: 1.25rem;
            opacity: 0.97;
        }

        .alert-success {
            background: #e6f9f0;
            color: #15803d;
        }

        .alert-danger,
        .alert-error {
            background: #fbeaea;
            color: #b91c1c;
        }

        .alert-warning {
            background: #fff7e6;
            color: #b45309;
        }

        .alert-info {
            background: #e0f2fe;
            color: #0369a1;
        }

        /* Sidebar, navbar, and section headers can be further themed as needed */
        @media (max-width: 480px) {
            .container {
                padding: 1rem 0.75rem;
            }

            .card {
                padding: 2rem 1.5rem;
                border-radius: 12px;
            }
        }

        #notifDropdownMenu .dropdown-item {
            max-width: 480px;
            white-space: normal;
            word-break: break-word;
            padding-right: 2.5rem;
        }

        #notifDropdownMenu {
            min-width: 320px;
            max-width: 600px !important;
            width: 100%;
        }

        #notifDropdownMenu .dropdown-item {
            max-width: 600px;
            white-space: normal;
            word-break: break-word;
            padding-right: 2.5rem;
        }
    </style>
    <style>
        /* Shared custom-sidebar styles to match student dashboard theme
               Increased specificity and some !important flags to ensure the
               sidebar appearance overrides other stylesheet rules. */
        .custom-sidebar,
        aside.custom-sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            height: auto !important;
            width: 275px !important;
            background: var(--forest-green, #2d5016) !important;
            color: #fff !important;
            z-index: 1040 !important;
            display: flex !important;
            flex-direction: column !important;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.08) !important;
            overflow-y: auto !important;
            box-sizing: border-box !important;
            transition: width 0.18s ease, padding 0.18s ease, transform 0.18s ease !important;
            padding-bottom: 1rem !important;
        }

        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 1.6rem 1rem 0.6rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .custom-sidebar .sidebar-logo img {
            display: block;
            margin: 0 auto 0.5rem;
        }

        .custom-sidebar .sidebar-logo h3 {
            margin: 0.25rem 0 0;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--yellow-maize, #f4d03f);
        }

        .custom-sidebar .sidebar-logo p {
            margin: 0;
            font-size: 0.9rem;
            color: #fff;
            opacity: 0.85;
        }

        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1rem 0.5rem 0.5rem 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .custom-sidebar .sidebar-link {
            display: flex !important;
            align-items: center !important;
            gap: 0.9rem !important;
            padding: 0.75rem 1rem !important;
            border-radius: 10px !important;
            color: #fff !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            transition: background 0.18s ease, color 0.18s ease, transform 0.12s ease !important;
            position: relative !important;
            overflow: visible !important;
        }

        .custom-sidebar .sidebar-link i {
            font-size: 1.12rem;
            width: 26px;
            text-align: center;
        }

        /* Active / hover state: light rounded panel with yellow accent */
        .custom-sidebar .sidebar-link.active,
        .custom-sidebar .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: var(--yellow-maize) !important;
            transform: translateX(4px) !important;
        }

        .custom-sidebar .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 4px;
            background: var(--yellow-maize);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px rgba(255, 203, 5, 0.4);
        }

        .custom-sidebar .sidebar-divider {
            margin: 0.75rem 0;
        }

        .custom-sidebar .sidebar-resources .text-uppercase {
            color: rgba(255, 255, 255, 0.75) !important;
            font-weight: 700;
        }

        .custom-sidebar .sidebar-bottom {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        .custom-sidebar .logout {
            background: transparent !important;
            color: #fff !important;
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            font-weight: 700;
        }

        .custom-sidebar .logout i {
            margin-right: 0.55rem;
        }

        .custom-sidebar .logout:hover {
            background: rgba(255, 255, 255, 0.03) !important;
            color: #fff !important;
        }

        /* Ensure main content is pushed to the right when sidebar exists */
        #mainContent {
            margin-left: 275px !important;
            transition: margin-left 0.18s ease !important;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .custom-sidebar {
                width: 200px !important;
            }

            #mainContent {
                margin-left: 200px !important;
            }
        }

        @media (max-width: 767.98px) {
            .custom-sidebar {
                transform: translateX(-100%);
                position: fixed;
            }

            .custom-sidebar.show {
                transform: translateX(0);
            }

            #mainContent {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body>

    @auth
        @if(auth()->user()->isAdmin())
            <div class="home-zoom">
                <div class="d-flex">
                    <!-- Mobile Sidebar Toggle -->
                    <button id="adminSidebarToggle" class="d-md-none"
                        style="position: fixed; top: 1rem; left: 1rem; z-index: 1050; background: var(--forest-green); color: white; border: none; border-radius: 8px; padding: 0.5rem 1rem; font-size: 1.5rem;">
                        <i class="bi bi-list"></i>
                    </button>
                    <!-- Sidebar -->
                    <div class="custom-sidebar" id="adminSidebar" style="background: var(--sidebar-bg) !important;">
                        <div class="sidebar-logo mb-4">
                            <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo"
                                style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto;">
                            <h3
                                style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
                                CMU Guidance and Counseling Center</h3>
                            <p style="margin: 0; font-size: 0.95rem; color: #fff; opacity: 0.7;">Admin Portal</p>
                        </div>
                        <nav class="sidebar-nav flex-grow-1">
                            <!-- Main Navigation -->
                            <a href="{{ route('dashboard') }}"
                                class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i
                                    class="bi bi-speedometer2"></i>Dashboard</a>
                            <a href="{{ route('profile') }}"
                                class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i
                                    class="bi bi-person"></i>Profile</a>

                            <div class="sidebar-divider"></div>

                            <!-- User Management -->
                            <a href="{{ route('users.index') }}"
                                class="sidebar-link{{ request()->routeIs('users.*') ? ' active' : '' }}"><i
                                    class="bi bi-people"></i>Users</a>
                            <a href="{{ route('admin.registration-approvals.index') }}"
                                class="sidebar-link{{ request()->routeIs('admin.registration-approvals.*') ? ' active' : '' }}"><i
                                    class="bi bi-person-check"></i>Registration Approvals</a>

                            <div class="sidebar-divider"></div>

                            <!-- Content & Communication -->
                            <a href="{{ route('announcements.index') }}"
                                class="sidebar-link{{ request()->routeIs('announcements.*') ? ' active' : '' }}"><i
                                    class="bi bi-megaphone"></i>Announcements</a>
                            <a href="{{ route('admin.hero-images.index') }}"
                                class="sidebar-link{{ request()->routeIs('admin.hero-images.*') ? ' active' : '' }}"><i
                                    class="bi bi-images"></i>Hero Images</a>

                            <div class="sidebar-divider"></div>

                            <!-- System & Monitoring -->
                            <a href="{{ route('activities') }}"
                                class="sidebar-link{{ request()->routeIs('activities') ? ' active' : '' }}"><i
                                    class="bi bi-activity"></i>Activity Logs</a>
                            <a href="{{ route('admin.reports.index') }}"
                                class="sidebar-link{{ request()->routeIs('admin.reports.*') ? ' active' : '' }}"><i
                                    class="bi bi-file-earmark-bar-graph"></i>Monthly Reports</a>
                            <a href="{{ route('admin.analytics.index') }}"
                                class="sidebar-link{{ request()->routeIs('admin.analytics.*') ? ' active' : '' }}"><i
                                    class="bi bi-graph-up-arrow"></i>Analytics</a>
                        </nav>
                        <div class="sidebar-bottom w-100">
                            <a href="{{ route('logout') }}" class="sidebar-link logout"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="main-dashboard-content flex-grow-1" id="mainContent">
                        <div class="main-dashboard-inner">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <style>
                /* Admin Dashboard Styles - Matching Student Dashboard */
                .main-dashboard-content {
                    margin-left: 275px;
                    min-height: 100vh;
                    background: linear-gradient(135deg, #f8fafc 0%, #e8f5e8 100%);
                    transition: margin-left 0.2s ease;
                }

                .main-dashboard-inner {
                    padding: 2rem;
                }

                /* Mobile Sidebar Toggle Button */
                #adminSidebarToggle {
                    position: fixed;
                    top: 1rem;
                    left: 1rem;
                    z-index: 1050;
                    background: var(--forest-green);
                    color: white;
                    border: none;
                    border-radius: 8px;
                    padding: 0.5rem 1rem;
                    font-size: 1.5rem;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                }

                #adminSidebarToggle:hover {
                    background: var(--forest-green-light);
                }

                /* Logout button styling */
                .custom-sidebar .sidebar-link.logout {
                    background: #dc3545 !important;
                    color: #fff !important;
                    border-radius: 8px;
                    text-align: center;
                    padding: 0.75rem 1rem;
                    font-weight: 600;
                    transition: background 0.2s;
                }

                .custom-sidebar .sidebar-link.logout:hover {
                    background: #b52a37 !important;
                    color: #fff !important;
                }

                /* Sidebar Divider */
                .sidebar-divider {
                    height: 1px;
                    background: rgba(255, 255, 255, 0.15);
                    margin: 0.75rem 1rem;
                }

                @media (max-width: 991.98px) {
                    .main-dashboard-content {
                        margin-left: 200px;
                    }
                }

                @media (max-width: 767.98px) {
                    .custom-sidebar {
                        transform: translateX(-100%);
                        position: fixed;
                    }

                    .custom-sidebar.show {
                        transform: translateX(0);
                    }

                    .main-dashboard-content {
                        margin-left: 0 !important;
                    }
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const sidebar = document.getElementById('adminSidebar');
                    const toggleBtn = document.getElementById('adminSidebarToggle');

                    if (toggleBtn && sidebar) {
                        toggleBtn.addEventListener('click', function () {
                            sidebar.classList.toggle('show');
                        });

                        // Close sidebar when clicking outside on mobile
                        document.addEventListener('click', function (e) {
                            if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                                const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                                if (!clickInside) {
                                    sidebar.classList.remove('show');
                                }
                            }
                        });

                        // Close sidebar on Escape key
                        document.addEventListener('keydown', function (e) {
                            if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                                sidebar.classList.remove('show');
                            }
                        });
                    }
                });
            </script>
        @else
            @if(auth()->user()->role === 'student' && request()->routeIs('dashboard'))
                <!-- Enhanced Notification Bell for students - Dashboard Only -->
                <style>
                    .notification-bell-container {
                        position: fixed !important;
                        top: 0.6rem !important;
                        right: 0.6rem !important;
                        z-index: 2080 !important;
                        pointer-events: auto;
                    }

                    .notification-bell {
                        background: var(--forest-green, #2d5016) !important;
                        border: none !important;
                        border-radius: 50% !important;
                        width: 56px !important;
                        height: 56px !important;
                        display: flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                        transition: all 0.18s ease !important;
                        box-shadow: 0 6px 18px rgba(45, 80, 22, 0.35) !important;
                    }

                    .notification-bell:hover {
                        transform: scale(1.1);
                        box-shadow: 0 6px 16px rgba(45, 80, 22, 0.4);
                    }

                    .notification-bell .bi-bell {
                        font-size: 1.5rem;
                        color: var(--yellow-maize, #f4d03f);
                        transition: all 0.3s ease;
                    }

                    .notification-bell.pulse .bi-bell {
                        animation: pulse 2s infinite;
                    }

                    @keyframes pulse {
                        0% {
                            transform: scale(1);
                        }

                        50% {
                            transform: scale(1.1);
                        }

                        100% {
                            transform: scale(1);
                        }
                    }

                    .notification-badge {
                        position: absolute;
                        top: -8px;
                        right: -8px;
                        background: #dc3545;
                        color: #fff;
                        border-radius: 50%;
                        width: 20px;
                        height: 20px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 0.75rem;
                        font-weight: bold;
                        border: 2px solid #fff;
                        animation: bounce 1s infinite;
                    }

                    @keyframes bounce {

                        0%,
                        20%,
                        50%,
                        80%,
                        100% {
                            transform: translateY(0);
                        }

                        40% {
                            transform: translateY(-3px);
                        }

                        60% {
                            transform: translateY(-2px);
                        }
                    }

                    .notification-dropdown {
                        min-width: 350px;
                        max-width: 95vw;
                        max-height: 400px;
                        overflow-y: auto;
                        border: none;
                        border-radius: 12px;
                        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
                    }

                    .notification-header {
                        background: var(--forest-green-lighter, #e8f5e8);
                        color: var(--forest-green, #2d5016);
                        font-weight: 600;
                        padding: 1rem 1.25rem;
                        border-bottom: 1px solid #dee2e6;
                        border-radius: 12px 12px 0 0;
                    }

                    .notification-item {
                        padding: 1rem 1.25rem;
                        border-bottom: 1px solid #f8f9fa;
                        transition: all 0.2s ease;
                        display: flex;
                        align-items: flex-start;
                        gap: 0.75rem;
                    }

                    .notification-item:hover {
                        background: var(--forest-green-lighter, #e8f5e8);
                    }

                    .notification-item:last-child {
                        border-bottom: none;
                    }

                    .notification-item.unread {
                        background: var(--yellow-maize-light, #fef9e7);
                        border-left: 4px solid var(--yellow-maize, #f4d03f);
                    }

                    .notification-icon {
                        width: 32px;
                        height: 32px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        flex-shrink: 0;
                        margin-top: 2px;
                    }

                    .notification-icon.appointment {
                        background: #e3f2fd;
                        color: #1976d2;
                    }

                    .notification-icon.message {
                        background: #e8f5e8;
                        color: #388e3c;
                    }

                    .notification-icon.general {
                        background: #fff3e0;
                        color: #f57c00;
                    }

                    .notification-content {
                        flex-grow: 1;
                        min-width: 0;
                    }

                    .notification-message {
                        font-size: 0.9rem;
                        line-height: 1.4;
                        margin-bottom: 0.25rem;
                    }

                    .notification-time {
                        font-size: 0.8rem;
                        color: #6c757d;
                    }

                    .notification-actions {
                        display: flex;
                        gap: 0.5rem;
                        margin-top: 0.5rem;
                    }

                    .notification-link {
                        color: var(--forest-green, #2d5016);
                        text-decoration: none;
                        font-size: 0.85rem;
                        font-weight: 500;
                        padding: 0.25rem 0.5rem;
                        border-radius: 4px;
                        background: rgba(45, 80, 22, 0.1);
                        transition: all 0.2s ease;
                    }

                    .notification-link:hover {
                        background: rgba(45, 80, 22, 0.2);
                        color: var(--forest-green, #2d5016);
                    }

                    .mark-read-btn {
                        background: none;
                        border: none;
                        color: #dc3545;
                        padding: 0.25rem;
                        border-radius: 4px;
                        transition: all 0.2s ease;
                        cursor: pointer;
                    }

                    .mark-read-btn:hover {
                        background: rgba(220, 53, 69, 0.1);
                        transform: scale(1.1);
                    }

                    .notification-empty {
                        text-align: center;
                        padding: 2rem;
                        color: #6c757d;
                    }

                    .notification-empty i {
                        font-size: 2rem;
                        margin-bottom: 0.5rem;
                        opacity: 0.5;
                    }
                </style>

                <div class="notification-bell-container">
                    <div class="dropdown">
                        <button class="btn notification-bell" type="button" id="notifBell" data-bs-toggle="dropdown"
                            aria-expanded="false" title="Notifications">
                            <i class="bi bi-bell"></i>
                            <span id="notifBadge" class="notification-badge" style="display:none;">0</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notifBell"
                            id="notifDropdownMenu">
                            <li class="notification-header">
                                <i class="bi bi-bell me-2"></i>Notifications
                            </li>
                            <li id="notifLoading" class="notification-item text-center text-muted">
                                <i class="bi bi-arrow-clockwise me-2"></i>Loading...
                            </li>
                        </ul>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        function getNotificationIcon(type, data) {
                            if (data && data.appointment_id) {
                                return '<i class="bi bi-calendar-event"></i>';
                            } else if (type.includes('Message')) {
                                return '<i class="bi bi-chat-dots"></i>';
                            } else {
                                return '<i class="bi bi-info-circle"></i>';
                            }
                        }

                        function getNotificationType(type, data) {
                            if (data && data.appointment_id) {
                                return 'appointment';
                            } else if (type.includes('Message')) {
                                return 'message';
                            } else {
                                return 'general';
                            }
                        }

                        function getNotificationUrl(data) {
                            if (data && data.appointment_id) {
                                return '/appointments';
                            } else if (data && data.url) {
                                return data.url;
                            }
                            return null;
                        }

                        function fetchNotifications() {
                            fetch('/notifications')
                                .then(res => res.json())
                                .then(data => {
                                    const notifDropdown = document.getElementById('notifDropdownMenu');
                                    notifDropdown.querySelectorAll('li:not(.notification-header)').forEach(e => e.remove());

                                    if (data.notifications.length === 0) {
                                        const empty = document.createElement('li');
                                        empty.className = 'notification-item notification-empty';
                                        empty.innerHTML = '<i class="bi bi-bell"></i><p class="mb-0">No notifications</p>';
                                        notifDropdown.appendChild(empty);
                                    } else {
                                        data.notifications.forEach(n => {
                                            const li = document.createElement('li');
                                            li.className = 'notification-item' + (n.read_at ? '' : ' unread');

                                            const iconType = getNotificationType(n.type, n.data);
                                            const icon = getNotificationIcon(n.type, n.data);
                                            const url = getNotificationUrl(n.data);

                                            let actionsHtml = '';
                                            if (url) {
                                                actionsHtml += `<a href="${url}" class="notification-link">View</a>`;
                                            }
                                            if (!n.read_at) {
                                                actionsHtml += `<button class="mark-read-btn" onclick="markAsRead('${n.id}')" title="Mark as read"><i class="bi bi-x-circle"></i></button>`;
                                            }

                                            li.innerHTML = `
                                                                                                                                                                                                                                                        <div class="notification-icon ${iconType}">
                                                                                                                                                                                                                                                            ${icon}
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                        <div class="notification-content">
                                                                                                                                                                                                                                                            <div class="notification-message">${n.data.message || n.type}</div>
                                                                                                                                                                                                                                                            <div class="notification-time">${n.created_at}</div>
                                                                                                                                                                                                                                                            ${actionsHtml ? `<div class="notification-actions">${actionsHtml}</div>` : ''}
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                    `;
                                            notifDropdown.appendChild(li);
                                        });
                                    }

                                    const badge = document.getElementById('notifBadge');
                                    const bell = document.getElementById('notifBell');

                                    if (data.unread_count > 0) {
                                        badge.style.display = 'flex';
                                        badge.textContent = data.unread_count;
                                        bell.classList.add('pulse');
                                    } else {
                                        badge.style.display = 'none';
                                        bell.classList.remove('pulse');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching notifications:', error);
                                    const notifDropdown = document.getElementById('notifDropdownMenu');
                                    notifDropdown.querySelectorAll('li:not(.notification-header)').forEach(e => e.remove());

                                    const errorLi = document.createElement('li');
                                    errorLi.className = 'notification-item notification-empty';
                                    errorLi.innerHTML = '<i class="bi bi-exclamation-triangle"></i><p class="mb-0">Error loading notifications</p>';
                                    notifDropdown.appendChild(errorLi);
                                });
                        }

                        function markAsRead(notificationId) {
                            fetch(`/notifications/${notificationId}/mark-as-read`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json',
                                }
                            })
                                .then(response => {
                                    if (response.ok) {
                                        fetchNotifications(); // Refresh notifications
                                    }
                                })
                                .catch(error => {
                                    console.error('Error marking notification as read:', error);
                                });
                        }

                        // Add global function for mark as read
                        window.markAsRead = markAsRead;

                        document.getElementById('notifBell').addEventListener('click', fetchNotifications);

                        // Auto-refresh notifications every 30 seconds
                        setInterval(fetchNotifications, 30000);
                    });
                </script>
            @endif
                    <main class="fade-in">
                        <div class="container py-4">
                            @yield('content')
                        </div>
                    </main>
        @endif
    @endauth
    @guest
        <main class="fade-in">
            <div class="container py-4">
                @yield('content')
            </div>
        </main>
    @endguest

    <!-- Bootstrap JS -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        // SweetAlert2 Toast Notification
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            @elseif(session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            @elseif(session('warning'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: 'Warning',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            @elseif(session('info'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Info',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            @endif
        });
    </script>
    @auth
        <!-- Global Two-Factor Authentication Modal -->
        <div class="modal fade" id="twoFactorGlobalModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4">
                    <div class="modal-header" style="border-bottom: none;">
                        <h5 class="modal-title" style="color: var(--forest-green);">Two-Factor Authentication</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-0">
                        <p class="small text-muted">Enter the 6-digit code sent to your email/phone.</p>
                        <form method="POST" action="{{ route('2fa.verify') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Authentication Code</label>
                                <input type="text" name="code" maxlength="6" class="form-control" required
                                    inputmode="numeric" pattern="[0-9]*">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Verify</button>
                        </form>
                        <div class="d-flex justify-content-between align-items-center mt-3 small">
                            <form method="POST" action="{{ route('2fa.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0"
                                    style="color: var(--forest-green); text-decoration: none;">Resend code</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(request()->routeIs('2fa.form'))
                var modalEl = document.getElementById('twoFactorGlobalModal');
                if (modalEl) {
                    var m = new bootstrap.Modal(modalEl);
                    m.show();
                }
            @endif
        });
    </script>
    <script>
        // Dark mode toggle logic
        function setDarkMode(enabled) {
            if (enabled) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('darkMode', '1');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', '0');
            }
        }
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            darkModeToggle.onclick = function () {
                setDarkMode(!document.body.classList.contains('dark-mode'));
            };
        }
        // On load, set dark mode if preferred
        if (localStorage.getItem('darkMode') === '1' ||
            (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            setDarkMode(true);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            if (navigator.brave && await navigator.brave.isBrave()) {
                document.querySelectorAll('form').forEach(form => {
                    if (!form.querySelector('input[name="browser_name"]')) {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'browser_name';
                        input.value = 'Brave';
                        form.appendChild(input);
                    }
                });
            }
        });
    </script>
    <!-- Removed problematic external script -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>