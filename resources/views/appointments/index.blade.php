@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d; /* Homepage forest green */
            --primary-green-2: #13601f; /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);

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
            zoom: 0.85;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }
        
        body, .profile-card, .stats-card, .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green) ;
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0,0,0,0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }
        
        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2rem 1rem 1rem 1rem;
            border-bottom: 1px solid #4a7c59;
        }
        
        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0.5rem 0 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            position: relative;
        }
        
        .custom-sidebar .sidebar-link.active, .custom-sidebar .sidebar-link:hover {
            background: #4a7c59;
            color: #f4d03f;
        }
        
        .custom-sidebar .sidebar-link .bi {
            font-size: 1.1rem;
        }
        
        .custom-sidebar .sidebar-bottom {
            padding: 1rem 0.5rem;
            border-top: 1px solid #4a7c59;
        }
        
        .custom-sidebar .sidebar-link.logout {
            background: #dc3545;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        
        .custom-sidebar .sidebar-link.logout:hover {
            background: #b52a37;
            color: #fff;
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
                transition: transform 0.2s ease;
                flex-direction: column;
                padding: 0;
            }
            .custom-sidebar.show {
                transform: translateX(0);
            }
            .custom-sidebar .sidebar-logo { display: block; }
            .custom-sidebar .sidebar-nav {
                flex-direction: column;
                gap: 0.25rem;
                padding: 1rem 0.5rem 1rem 0.5rem;
            }
            .custom-sidebar .sidebar-link {
                justify-content: flex-start;
                padding: 0.6rem 0.75rem;
                font-size: 1rem;
            }
            .main-dashboard-content {
                margin-left: 0;
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
                border-radius: 8px;
                padding: 0.5rem 0.75rem;
                box-shadow: var(--shadow-sm);
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
            <div class="sidebar-logo mb-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto;">
                <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">CMU Guidance and Counseling Center</h3>
                <p style="margin: 0; font-size: 0.95rem; color: #fff; opacity: 0.7;">Student Portal</p>
            </div>
            <nav class="sidebar-nav flex-grow-1">
                <a href="{{ route('profile') }}" class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i class="bi bi-person"></i>Profile</a>
                <a href="{{ route('dashboard') }}" class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i class="bi bi-house-door"></i>Dashboard</a>
                <a href="{{ route('appointments.index') }}" class="sidebar-link{{ request()->routeIs('appointments.*') ? ' active' : '' }}"><i class="bi bi-calendar-check"></i>Appointments</a>
                <a href="{{ route('assessments.index') }}" class="sidebar-link{{ request()->routeIs('assessments.*') ? ' active' : '' }}"><i class="bi bi-clipboard-data"></i>Assessments</a>
                <a href="{{ route('chat.selectCounselor') }}" class="sidebar-link{{ request()->routeIs('chat.selectCounselor') ? ' active' : '' }}"><i class="bi bi-chat-dots"></i>Chat with a Counselor</a>
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
        <div class="main-dashboard-content flex-grow-1">
            <div class="main-dashboard-inner">
<div class="container py-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title mb-0"><i class="bi bi-calendar-check me-2"></i>My Appointments</h2>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Book Appointment
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($appointments->count())
        <div class="row g-4">
            @foreach($appointments as $appointment)
                @php
                    $start = $appointment->scheduled_at;
                    $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                        ->where('start', $start)
                        ->first();
                    $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex align-items-center gap-2" style="background: var(--primary-light); color: var(--primary);">
                            <img src="{{ $appointment->counselor->avatar_url }}" 
                                 alt="{{ $appointment->counselor->name }}" 
                                 class="rounded-circle" 
                                 style="width: 40px; height: 40px; object-fit: cover; border: 2px solid var(--primary);">
                            <span class="fw-bold">{{ $appointment->counselor->name ?? 'N/A' }}</span>
                            @php
                                // Get the session note for this appointment (if any)
                                $sessionNoteForThisAppointment = $appointment->sessionNotes->first();
                            @endphp
                            @if($sessionNoteForThisAppointment)
                                <span class="badge bg-primary ms-auto">Session {{ $sessionNoteForThisAppointment->session_number }}</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <i class="bi bi-clock me-1 text-primary"></i>
                                <span class="fw-semibold">{{ $start->format('M d, Y - g:i A') }} – {{ $end->format('g:i A') }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="badge 
                                    @if($appointment->status === 'pending') bg-warning text-dark
                                    @elseif($appointment->status === 'accepted') bg-success
                                    @elseif($appointment->status === 'completed') bg-primary
                                    @elseif($appointment->status === 'declined' || $appointment->status === 'cancelled') bg-danger
                                    @elseif($appointment->status === 'rescheduled_pending') bg-info text-dark
                                    @else bg-secondary
                                    @endif
                                    px-3 py-2 fs-6 shadow-sm">
                                    <i class="bi bi-info-circle me-1"></i>{{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                            <div class="mb-2">
                                @if($appointment->status === 'accepted')
                                    <span class="text-success"><i class="bi bi-journal-text me-1"></i>Your Appointment has been accepted, please proceed to GCC on {{ $start->format('M d, Y') }} at {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}.</span>
                                @elseif($appointment->status === 'completed')
                                    <span class="text-primary"><i class="bi bi-journal-text me-1"></i>Session completed.</span>
                                @elseif($appointment->status === 'declined')
                                    <span class="text-danger"><i class="bi bi-journal-text me-1"></i>Your appointment was declined. Please select another available slot or contact the GCC for assistance.</span>
                                @elseif($appointment->status === 'rescheduled_pending')
                                    <span class="text-info"><i class="bi bi-arrow-repeat me-1"></i>Your counselor has proposed a new slot. Please accept or decline below.</span>
                                    <form action="{{ route('appointments.acceptReschedule', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm me-2"><i class="bi bi-check-circle me-1"></i>Accept</button>
                                    </form>
                                    <form action="{{ route('appointments.declineReschedule', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-circle me-1"></i>Decline</button>
                                    </form>
                                @elseif($appointment->notes)
                                    <span class="text-muted"><i class="bi bi-journal-text me-1"></i>{{ Str::limit($appointment->notes, 60) }}</span>
                                @else
                                    <span class="text-muted"><i class="bi bi-journal-text me-1"></i>No notes</span>
                                @endif
                            </div>
                            
                            {{-- Display Session Notes for Completed Appointments --}}
                            @if($appointment->status === 'completed' && $appointment->sessionNotes->count() > 0)
                                <div class="mt-3 p-3 bg-light rounded border-start border-3 border-primary">
                                    <h6 class="fw-bold text-primary mb-2">
                                        <i class="bi bi-journal-text me-1"></i>Session Notes
                                    </h6>
                                    @foreach($appointment->sessionNotes as $sessionNote)
                                        <div class="mb-3">
                                            @if($sessionNote->session_number)
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="badge bg-primary me-2">Session {{ $sessionNote->session_number }}</span>
                                                </div>
                                            @endif
                                            <div class="bg-white p-3 rounded border">
                                                <p class="mb-0">{{ $sessionNote->note }}</p>
                                            </div>
                                            {{-- Show the session's own completion date if completed --}}
                                            @if($sessionNote->session_status === 'completed')
                                                <div class="mt-2">
                                                    <small class="text-success">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        <strong>Session Completed:</strong> {{ $sessionNote->appointment->scheduled_at->format('F j, Y g:i A') }}
                                                    </small>
                                                </div>
                                            @endif
                                            {{-- Show the next session date if it exists and is not completed --}}
                                            @if($sessionNote->next_session)
                                                @php
                                                    $sessionDate = \Carbon\Carbon::parse($sessionNote->next_session);
                                                    // Check if there is a session note for this appointment and date with status completed
                                                    $nextCompleted = $appointment->sessionNotes->where('session_number', $sessionNote->session_number + 1)
                                                        ->where('session_status', 'completed')
                                                        ->first();
                                                @endphp
                                                <div class="mt-2">
                                                    @if($sessionNote->session_status === 'expired')
                                                        <small class="text-danger">
                                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                                            <strong>Session Expired:</strong> {{ $sessionDate->format('F j, Y g:i A') }}
                                                        </small>
                                                    @elseif($sessionNote->session_status === 'missed')
                                                        <small class="text-warning">
                                                            <i class="bi bi-clock me-1"></i>
                                                            <strong>Session Missed:</strong> {{ $sessionDate->format('F j, Y g:i A') }}
                                                        </small>
                                                    @elseif($nextCompleted)
                                                        <small class="text-success">
                                                            <i class="bi bi-check-circle me-1"></i>
                                                            <strong>Session Completed:</strong> {{ $sessionDate->format('F j, Y g:i A') }}
                                                        </small>
                                                    @else
                                                        <small class="text-info">
                                                            <i class="bi bi-calendar-event me-1"></i>
                                                            <strong>Next Session:</strong> {{ $sessionDate->format('F j, Y g:i A') }}
                                                        </small>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    

                                </div>
                            @elseif($appointment->status === 'completed')
                                <div class="mt-3 p-3 bg-light rounded border-start border-3 border-secondary">
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        No session notes available yet. Your counselor will add notes after the session.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="d-flex flex-column align-items-center justify-content-center py-5">
            <i class="bi bi-calendar-x display-1 mb-3 text-secondary"></i>
            <h4 class="mb-2 text-muted">No appointments found.</h4>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary mt-2">
                <i class="bi bi-plus-circle me-1"></i> Book Your First Appointment
            </a>
        </div>
    @endif
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
