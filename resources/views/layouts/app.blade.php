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
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --forest-green: #2d5016;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #f4d03f;
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: #f8f9fa;
            --gray-100: #f1f3f4;
            --gray-600: #6c757d;
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 16px;
            --input-radius: 10px;
            --transition: 0.2s;
        }
        html { font-size: 18px; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e8f5e8 100%);
            min-height: 100vh;
            color: var(--forest-green);
            line-height: 1.7;
            transition: background 0.3s, color 0.3s;
        }
        .container { max-width: 1200px; }
        .card, .card-header, .card-body, .form-control, .form-select {
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
        .card-body { padding: 2rem; }
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
        .btn-primary, .btn-success, .btn-warning, .btn-danger, .btn-secondary {
            color: white;
        }
        .btn-primary { background: var(--forest-green); }
        .btn-primary:hover, .btn-primary:focus { background: var(--forest-green-light); }
        .btn-success { background: var(--success); }
        .btn-success:hover, .btn-success:focus { background: #218838; }
        .btn-warning { background: var(--yellow-maize); color: var(--forest-green); }
        .btn-warning:hover, .btn-warning:focus { background: #ffe066; color: var(--forest-green); }
        .btn-danger { background: var(--danger); }
        .btn-danger:hover, .btn-danger:focus { background: #b52a37; }
        .btn-secondary { background: var(--gray-600); }
        .btn-secondary:hover, .btn-secondary:focus { background: #495057; }
        .btn-outline-primary {
            border: 2px solid var(--forest-green);
            color: var(--forest-green);
            background: transparent;
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background: var(--forest-green-light);
            color: white;
        }
        .badge {
            border-radius: 999px;
            font-size: 1rem;
            font-weight: 600;
            padding: 0.5em 1.2em;
            box-shadow: 0 2px 8px rgba(44,62,80,0.08);
        }
        .form-control, .form-select {
            border-radius: var(--input-radius);
            border: 1.5px solid var(--gray-100);
            padding: 0.75rem 1.2rem;
            font-size: 1rem;
            box-shadow: 0 1px 3px var(--shadow-sm);
            margin-bottom: 1.2rem;
        }
        .form-control:focus, .form-select:focus {
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
            box-shadow: 0 2px 8px 0 rgba(30,41,59,0.07);
            margin-bottom: 1.25rem;
            opacity: 0.97;
        }
        .alert-success { background: #e6f9f0; color: #15803d; }
        .alert-danger, .alert-error { background: #fbeaea; color: #b91c1c; }
        .alert-warning { background: #fff7e6; color: #b45309; }
        .alert-info { background: #e0f2fe; color: #0369a1; }
        /* Sidebar, navbar, and section headers can be further themed as needed */
        @media (max-width: 480px) {
            .container { padding: 1rem 0.75rem; }
            .card { padding: 2rem 1.5rem; border-radius: 12px; }
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
</head>
<body>

    @auth
        @if(auth()->user()->isAdmin())
            <!-- Admin Top Navbar -->
            <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%); color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border-bottom: none; border-radius: 0; margin-bottom: 0;">
                <div class="container-fluid" style="padding-left: 0;">
                    <button id="sidebarToggle" class="btn btn-link text-white me-3" style="font-size: 1.5rem;" type="button">
                        <i class="bi bi-list"></i>
                    </button>
                    <span class="navbar-brand fw-bold" style="color: var(--yellow-maize); font-size: 1.3rem;"><i class="bi bi-people-fill me-2"></i>Admin Panel</span>
                    <div class="d-flex align-items-center ms-auto">
                        <!-- Notification Bell -->
                        <a href="#" class="nav-link position-relative" title="Notifications">
                            <i class="bi bi-bell" style="font-size: 1.6rem;"></i>
                            <!-- Optionally, add a badge for unread notifications -->
                            <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span> -->
                        </a>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="" width="32" height="32" class="rounded-circle me-2">
                                <strong style="color: var(--yellow-maize);">{{ auth()->user()->name }}</strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminNavbarDropdown">
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
                    </div>
                </div>
            </nav>
            <div class="d-flex" style="min-height: 100vh;">
                <!-- Sidebar -->
                <nav id="adminSidebar" class="d-flex flex-column flex-shrink-0 p-3" style="width: 250px; min-height: 100vh; background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%); color: #fff; transition: width 0.2s; border-right: none; border-radius: 0; margin-top: 0;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Removed: Admin Panel name and icon -->
                    </div>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li>
                            <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" style="background: {{ request()->routeIs('profile') ? 'var(--yellow-maize)' : 'transparent' }}; color: {{ request()->routeIs('profile') ? 'var(--forest-green)' : '#fff' }}; border-radius: 12px; margin-bottom: 0.5rem;">
                                <i class="bi bi-person me-2"></i><span class="sidebar-label">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="background: {{ request()->routeIs('dashboard') ? 'var(--yellow-maize)' : 'transparent' }}; color: {{ request()->routeIs('dashboard') ? 'var(--forest-green)' : '#fff' }}; border-radius: 12px; margin-bottom: 0.5rem;">
                                <i class="bi bi-speedometer2 me-2"></i><span class="sidebar-label">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" style="background: {{ request()->routeIs('users.*') ? 'var(--yellow-maize)' : 'transparent' }}; color: {{ request()->routeIs('users.*') ? 'var(--forest-green)' : '#fff' }}; border-radius: 12px; margin-bottom: 0.5rem;">
                                <i class="bi bi-people me-2"></i><span class="sidebar-label">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('announcements.index') }}" class="nav-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}" style="background: {{ request()->routeIs('announcements.*') ? 'var(--yellow-maize)' : 'transparent' }}; color: {{ request()->routeIs('announcements.*') ? 'var(--forest-green)' : '#fff' }}; border-radius: 12px; margin-bottom: 0.5rem;">
                                <i class="bi bi-megaphone me-2"></i><span class="sidebar-label">Announcements</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('activities') }}" class="nav-link {{ request()->routeIs('activities') ? 'active' : '' }}" style="background: {{ request()->routeIs('activities') ? 'var(--yellow-maize)' : 'transparent' }}; color: {{ request()->routeIs('activities') ? 'var(--forest-green)' : '#fff' }}; border-radius: 12px; margin-bottom: 0.5rem;">
                                <i class="bi bi-activity me-2"></i><span class="sidebar-label">Activity Logs</span>
                            </a>
                        </li>
                    </ul>
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
                #adminSidebar {
                    transition: width 0.2s, padding 0.2s;
                }
                #adminSidebar.collapsed {
                    width: 60px !important;
                    padding-left: 0.5rem !important;
                    padding-right: 0.5rem !important;
                }
                #adminSidebar .nav-link {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    justify-content: flex-start;
                    transition: justify-content 0.2s, padding 0.2s;
                }
                #adminSidebar.collapsed .nav-link {
                    justify-content: center;
                    padding-left: 0.25rem;
                    padding-right: 0.25rem;
                }
                #adminSidebar .nav-link i {
                    font-size: 1.25rem;
                    transition: font-size 0.2s;
                }
                #adminSidebar.collapsed .nav-link i {
                    font-size: 1.5rem;
                }
                #adminSidebar .sidebar-label {
                    transition: opacity 0.2s, width 0.2s;
                    white-space: nowrap;
                }
                #adminSidebar.collapsed .sidebar-label {
                    opacity: 0;
                    width: 0;
                    overflow: hidden;
                    display: none !important;
                }
                #adminSidebar .badge {
                    transition: opacity 0.2s;
                }
                #adminSidebar.collapsed .badge {
                    opacity: 0;
                    display: none !important;
                }
                #adminSidebar .dropdown, #adminSidebar .dropdown-menu, #adminSidebar .dropdown-toggle {
                    width: 100%;
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
                        transition: transform 0.2s, width 0.2s;
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
                    // Add tooltips to icons when sidebar is collapsed
                    function updateTooltips() {
                        const navLinks = sidebar.querySelectorAll('.nav-link');
                        navLinks.forEach(link => {
                            const label = link.querySelector('.sidebar-label');
                            if (sidebar.classList.contains('collapsed')) {
                                if (label) link.setAttribute('title', label.textContent.trim());
                            } else {
                                link.removeAttribute('title');
                            }
                        });
                    }
                    if (toggleBtn && sidebar && mainContent) {
                        toggleBtn.addEventListener('click', function() {
                            sidebar.classList.toggle('collapsed');
                            mainContent.classList.toggle('sidebar-collapsed');
                            updateTooltips();
                        });
                        updateTooltips();
                    }
                });
            </script>
        @else
            @if(auth()->user()->role === 'student')
            <!-- Notification Bell for students only -->
            <div style="position: fixed; top: 24px; right: 36px; z-index: 1050;">
                <div class="dropdown">
                    <a href="#" id="notifBell" class="nav-link position-relative" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                        <i class="bi bi-bell" style="font-size: 1.7rem; color: #2d5016;"></i>
                        <span id="notifBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifBell" id="notifDropdownMenu" style="min-width: 320px; max-width: 95vw; max-height: 350px; overflow-y: auto;">
                        <li class="dropdown-header">Notifications</li>
                        <li id="notifLoading" class="dropdown-item text-center text-muted">Loading...</li>
                    </ul>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                function fetchNotifications() {
                    fetch('/notifications')
                        .then(res => res.json())
                        .then(data => {
                            const notifDropdown = document.getElementById('notifDropdownMenu');
                            notifDropdown.querySelectorAll('li:not(.dropdown-header)').forEach(e => e.remove());
                            if (data.notifications.length === 0) {
                                const empty = document.createElement('li');
                                empty.className = 'dropdown-item text-center text-muted';
                                empty.textContent = 'No notifications';
                                notifDropdown.appendChild(empty);
                            } else {
                                data.notifications.forEach(n => {
                                    const li = document.createElement('li');
                                    li.className = 'dropdown-item' + (n.read_at ? '' : ' fw-bold');
                                    let messageHtml = `${n.data.message || n.type} <br><small class='text-muted'>${n.created_at}</small>`;
                                    if (n.data.url) {
                                        messageHtml += ` <a href='${n.data.url}' style='font-size:0.95em; color:#198754; text-decoration:underline; margin-left:8px;' target='_blank'>view</a>`;
                                    }
                                    li.innerHTML = messageHtml;
                                    notifDropdown.appendChild(li);
                                });
                            }
                            const badge = document.getElementById('notifBadge');
                            if (data.unread_count > 0) {
                                badge.style.display = 'inline-block';
                                badge.textContent = data.unread_count;
                            } else {
                                badge.style.display = 'none';
                            }
                        });
                }
                document.getElementById('notifBell').addEventListener('click', fetchNotifications);
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
    <script src="https://js.puter.com/v2/"></script>
</body>
</html> 