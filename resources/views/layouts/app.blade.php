<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Management App') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-black: #0a0a0a;
            --secondary-black: #1a1a1a;
            --tertiary-black: #2a2a2a;
            --primary-white: #ffffff;
            --light-gray: #f5f5f5;
            --medium-gray: #9ca3af;
            --dark-gray: #6b7280;
            --border-gray: #e5e7eb;
            --focus-gray: #374151;
            --error-red: #dc2626;
            --shadow-light: rgba(0, 0, 0, 0.04);
            --shadow-medium: rgba(0, 0, 0, 0.1);
        }
        .dark-mode {
            --primary-black: #f4f4f4;
            --secondary-black: #e5e7eb;
            --tertiary-black: #d1d5db;
            --primary-white: #181a1b;
            --light-gray: #23262f;
            --medium-gray: #a1a1aa;
            --dark-gray: #9ca3af;
            --border-gray: #23262f;
            --focus-gray: #a1a1aa;
            --error-red: #f87171;
            --shadow-light: rgba(0,0,0,0.32);
            --shadow-medium: rgba(0,0,0,0.64);
        }
        body.dark-mode {
            background: linear-gradient(135deg, #181a1b 0%, #23262f 100%);
            color: var(--primary-black);
        }
        .card, .card-header, .card-body, .form-control, .form-select {
            background: var(--primary-white) !important;
            color: var(--primary-black) !important;
        }
        .card-header {
            background: var(--light-gray) !important;
            color: var(--primary-black) !important;
        }
        .btn, .btn-outline {
            background: var(--primary-black);
            color: var(--primary-white);
        }
        .btn-outline {
            background: transparent;
            color: var(--primary-black);
            border: 1.5px solid var(--primary-black);
        }
        .btn:focus, .btn:hover, .btn-outline:focus, .btn-outline:hover {
            background: var(--secondary-black);
            color: var(--primary-white);
        }
        .form-control, .form-select {
            background: var(--primary-white);
            color: var(--primary-black);
            border: 1.5px solid var(--border-gray);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--focus-gray);
            box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);
            outline: none;
        }
        .form-label {
            color: var(--primary-black);
        }
        .invalid-feedback {
            color: var(--error-red);
        }
        * { box-sizing: border-box; }
        html { font-size: 17px; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            color: var(--primary-black);
            line-height: 1.6;
            transition: background 0.3s, color 0.3s;
        }
        .container { max-width: 1200px; }
        .card {
            background: var(--primary-white);
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px var(--shadow-light), 0 20px 40px var(--shadow-medium), 0 0 0 1px rgba(0,0,0,0.02);
            transition: box-shadow 0.2s, transform 0.2s, background 0.3s;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 6px 24px 0 rgba(30,41,59,0.12);
        }
        .card-header {
            background: var(--primary-black);
            color: white;
            border: none;
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: background 0.3s;
        }
        .card-body { padding: 2rem; }
        .btn {
            font-weight: 600;
            border-radius: 8px;
            padding: 0.875rem 1.5rem;
            font-size: 0.9375rem;
            transition: all 0.2s;
            border: none;
            position: relative;
            overflow: hidden;
            outline: none;
            letter-spacing: 0.01em;
        }
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 2px 8px 0 rgba(30,41,59,0.07);
            margin-bottom: 1.25rem;
            opacity: 0.97;
        }
        .alert-success { background: #e6f9f0; color: #15803d; }
        .alert-danger, .alert-error { background: #fbeaea; color: #b91c1c; }
        .alert-warning { background: #fff7e6; color: #b45309; }
        .alert-info { background: #e0f2fe; color: #0369a1; }
        /* Responsive design */
        @media (max-width: 480px) {
            .container { padding: 1rem 0.75rem; }
            .card { padding: 2rem 1.5rem; border-radius: 12px; }
        }
    </style>
</head>
<body>
@if(auth()->check())
    <form action="{{ route('logout') }}" method="POST" style="position: fixed; top: 18px; right: 32px; z-index: 2000;">
        @csrf
        <button type="submit" class="btn btn-danger rounded-pill px-4 shadow">
            <i class="bi bi-box-arrow-right me-1"></i>Logout
        </button>
    </form>
@endif
    @auth
        @if(auth()->user()->isAdmin())
            <div class="d-flex" style="min-height: 100vh;">
                <!-- Sidebar -->
                <nav id="adminSidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-light border-end" style="width: 250px; min-height: 100vh; transition: width 0.2s;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                            <span class="fs-4 fw-bold sidebar-label"><i class="bi bi-people-fill me-2"></i>Admin Panel</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                            @csrf
                            <button type="submit" class="btn btn-danger rounded-pill px-3 py-1" title="Logout">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2 me-2"></i><span class="sidebar-label">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="bi bi-people me-2"></i><span class="sidebar-label">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('announcements.index') }}" class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                                <i class="bi bi-megaphone me-2"></i><span class="sidebar-label">Announcements</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('activities') }}" class="nav-link {{ request()->routeIs('activities') ? 'active' : '' }}">
                                <i class="bi bi-activity me-2"></i><span class="sidebar-label">Activity Logs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                                <i class="bi bi-person me-2"></i><span class="sidebar-label">Profile</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong class="sidebar-label">{{ auth()->user()->name }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- Main Content -->
                <div class="flex-grow-1" id="mainContent">
                    <main class="fade-in">
                        <div class="container py-4">
                            @yield('content')
                        </div>
                    </main>
                </div>
            </div>
            <style>
                #adminSidebar.collapsed {
                    width: 60px !important;
                }
                #adminSidebar.collapsed .sidebar-label {
                    display: none !important;
                }
                #mainContent.sidebar-collapsed {
                    margin-left: 60px !important;
                }
                @media (max-width: 991.98px) {
                    #adminSidebar {
                        position: fixed;
                        z-index: 1040;
                        height: 100vh;
                        left: 0;
                        top: 0;
                        transition: transform 0.2s;
                        transform: translateX(-100%);
                    }
                    #adminSidebar.show {
                        transform: translateX(0);
                    }
                    #mainContent {
                        margin-left: 0 !important;
                    }
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebar = document.getElementById('adminSidebar');
                    const mainContent = document.getElementById('mainContent');
                    const toggleBtn = document.getElementById('sidebarToggle');
                    if (toggleBtn) {
                        toggleBtn.addEventListener('click', function() {
                            sidebar.classList.toggle('collapsed');
                            mainContent.classList.toggle('sidebar-collapsed');
                            // For mobile: also toggle show class
                            if (window.innerWidth < 992) {
                                sidebar.classList.toggle('show');
                            }
                        });
                    }
                });
            </script>
        @else
            <!-- Non-admin layout (navbar as before) -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
                <div class="container">
                    <a class="navbar-brand university-brand d-flex align-items-center gap-2" href="/">
                        <img src="/images/cmu-logo.png" alt="CMU Logo" style="height: 32px;">
                        <span>CMU Guidance and Counseling Center</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                </a>
                            </li>
                            @if(auth()->user()->isStudent())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}" href="{{ route('announcements.index') }}">
                                        <i class="bi bi-megaphone me-1"></i>Announcements
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}" href="{{ route('appointments.index') }}">
                                        <i class="bi bi-calendar-check me-1"></i>Appointments
                                    </a>
                                </li>
                            @elseif(auth()->user()->isCounselor())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}" href="{{ route('announcements.index') }}">
                                        <i class="bi bi-megaphone me-1"></i>Announcements
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('counselor.appointments.*') ? 'active' : '' }}" href="{{ route('counselor.appointments.index') }}">
                                        <i class="bi bi-calendar-check me-1"></i>Appointments
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item me-2">
                                <span class="fw-semibold">{{ auth()->user()->name }}</span>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded-pill px-4 ms-2">
                                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // SweetAlert2 Toast Notification
        document.addEventListener('DOMContentLoaded', function() {
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
        document.getElementById('darkModeToggle').onclick = function() {
            setDarkMode(!document.body.classList.contains('dark-mode'));
        };
        // On load, set dark mode if preferred
        if (localStorage.getItem('darkMode') === '1' ||
            (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            setDarkMode(true);
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', async function() {
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
</body>
</html> 