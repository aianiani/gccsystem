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

        body,
        .profile-card,
        .stats-card,
        .main-content-card {
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
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }

        /* Specific Page Styles similar to appointments.index */
        .appointments-hero {
            background: var(--hero-gradient);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .appointments-hero .title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .appointment-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .appointment-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .appointment-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .appointment-body {
            padding: 1.25rem;
        }

        .counselor-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(31, 122, 45, 0.1);
        }

        .session-note {
            background: var(--gray-50);
            border-radius: 10px;
            padding: 1.25rem;
            margin-top: 1rem;
            border-left: 4px solid var(--forest-green);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--gray-600);
            background: white;
            border-radius: 12px;
            border: 2px dashed var(--gray-100);
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
                    <p style="margin: 0; font-size: 0.8rem; color: #fff; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Student Portal</p>
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
                        <div class="text-uppercase small px-3 mb-2" style="color: rgba(255,255,255,0.5); font-weight:700; font-size: 0.75rem; letter-spacing: 1px;">
                            Resources</div>
                        <a href="#" class="sidebar-link"><i class="bi bi-play-circle"></i>Orientation</a>
                        <a href="#" class="sidebar-link"><i class="bi bi-book"></i>Library</a>
                        <a href="#" class="sidebar-link"><i class="bi bi-gear"></i>Settings</a>
                    </div>
                </nav>
                <div class="sidebar-bottom w-100">
                    <a href="{{ route('logout') }}" class="sidebar-link logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form-completed').submit();">
                        <i class="bi bi-box-arrow-right"></i>Logout
                    </a>
                    <form id="logout-form-completed" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="container py-1">
                        
                        <!-- Hero Section -->
                        <div class="appointments-hero d-flex align-items-center justify-content-between">
                            <div>
                                <div class="title mb-1">
                                    <i class="bi bi-star-fill me-2"></i>Completed Sessions & Feedback
                                </div>
                                <div class="opacity-75 small">Review your completed session history and provide feedback</div>
                            </div>
                            <!-- Keeping logic simple: no big button here needed, or maybe back to dashboard? -->
                            <!-- User already has sidebar, so back button is less critical, but good for UX -->
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success mb-4 rounded-3 shadow-sm border-0">{{ session('success') }}</div>
                        @endif

                        @if($completedAppointments->count() > 0)
                            <div class="row g-4">
                                @foreach($completedAppointments as $appointment)
                                    <div class="col-12">
                                        <div class="appointment-card">
                                            <div class="appointment-header d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($appointment->counselor->avatar)
                                                        <img src="{{ $appointment->counselor->avatar_url }}" alt="{{ $appointment->counselor->name }}" class="counselor-avatar">
                                                    @else
                                                        <div class="counselor-avatar d-flex align-items-center justify-content-center bg-success text-white">
                                                            {{ strtoupper(substr($appointment->counselor->name ?? 'C', 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $appointment->counselor->name ?? 'Counselor' }}</h6>
                                                        <div class="small opacity-75">Counseling Session</div>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success rounded-pill px-3 py-2">Completed</span>
                                            </div>
                                            
                                            <div class="appointment-body">
                                                <div class="row mb-4">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="d-flex align-items-center text-muted">
                                                            <i class="bi bi-calendar-event me-2"></i>
                                                            <span class="fw-medium text-dark">{{ $appointment->scheduled_at->format('F j, Y') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="d-flex align-items-center text-muted">
                                                            <i class="bi bi-clock me-2"></i>
                                                            <span>{{ $appointment->scheduled_at->format('g:i A') }} - {{ $appointment->scheduled_at->addMinutes(30)->format('g:i A') }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Session Notes -->
                                                @foreach($appointment->sessionNotes as $sessionNote)
                                                    <div class="session-note">
                                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                                            <h6 class="fw-bold text-success mb-0">
                                                                <i class="bi bi-journal-text me-2"></i>Session Note #{{ $sessionNote->id }}
                                                            </h6>
                                                            <small class="text-muted">{{ $sessionNote->created_at->format('M j, g:i A') }}</small>
                                                        </div>

                                                        @if($sessionNote->content)
                                                            <div class="mb-3">
                                                                <div class="bg-white p-3 rounded border">
                                                                    @if(auth()->check() && auth()->user()->role === 'counselor')
                                                                        {!! nl2br(e($sessionNote->content)) !!}
                                                                    @else
                                                                        <div class="text-muted fst-italic">Private note — visible only to your counselor.</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($sessionNote->recommendations)
                                                            <div class="alert alert-light border">
                                                                <strong>Recommendations:</strong>
                                                                <div class="mt-1">{!! nl2br(e($sessionNote->recommendations)) !!}</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                <!-- Feedback Section -->
                                                @php
                                                    $existingFeedback = \App\Models\SessionFeedback::where('appointment_id', $appointment->id)->first();
                                                @endphp
                                                <div class="mt-4 p-3 rounded-3" style="background-color: #f8f9fa; border: 1px dashed #dee2e6;">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1 fw-bold text-dark">
                                                                <i class="bi bi-star me-2 text-warning"></i>Session Feedback
                                                            </h6>
                                                            @if($existingFeedback)
                                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                                    <div class="d-flex">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            <i class="bi bi-star{{ $i <= $existingFeedback->rating ? '-fill' : '' }} text-warning"></i>
                                                                        @endfor
                                                                    </div>
                                                                    <span class="text-muted small">({{ $existingFeedback->rating }}/5)</span>
                                                                </div>
                                                                <p class="mb-0 text-muted small mt-1">{{ Str::limit($existingFeedback->comments, 100) }}</p>
                                                            @else
                                                                <p class="mb-0 text-muted small">How was your session? Let us know.</p>
                                                            @endif
                                                        </div>
                                                        
                                                        @if(!$existingFeedback)
                                                            <a href="{{ route('session-feedback.create', $appointment->id) }}" class="btn btn-outline-success btn-sm rounded-pill px-4">
                                                                Provide Feedback
                                                            </a>
                                                        @else
                                                            <span class="badge bg-light text-success border border-success rounded-pill px-3">
                                                                <i class="bi bi-check-circle me-1"></i>Submitted
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="mb-3">
                                    <i class="bi bi-journal-x" style="font-size: 3rem; color: #d1d5db;"></i>
                                </div>
                                <h4 class="fw-bold text-secondary">No Completed Sessions Yet</h4>
                                <p class="text-muted">You don't have any completed counseling sessions yet.</p>
                            </div>
                        @endif

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