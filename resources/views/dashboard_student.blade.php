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
            background: rgba(255,255,255,0.2);
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
            align-items: stretch; /* ensure children stretch to equal height */
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
            min-height: 140px; /* ensure consistent card height */
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
            background: linear-gradient(90deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 100%);
            border: 2px solid rgba(255,255,255,0.12);
            color: #fff;
            padding: 0.9rem 1.6rem;
            border-radius: 999px;
            font-weight: 700;
            box-shadow: 0 8px 30px rgba(17, 94, 37, 0.18);
            transition: transform 0.12s ease, box-shadow 0.12s ease;
        }
        .btn-hero:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(17, 94, 37, 0.22); }
        .btn-ghost {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255,255,255,0.14);
            padding: 0.8rem 1.4rem;
            border-radius: 999px;
            font-weight: 600;
        }

        /* Make main content cards use flex so headers and bodies behave predictably */
        .main-content-card, .quick-actions-sidebar {
            display: flex;
            flex-direction: column;
            min-height: 120px;
        }
        .main-content-card .card-body, .quick-actions-sidebar .card-body {
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
            background: linear-gradient(180deg, rgba(34,139,34,0.06), rgba(34,139,34,0.02));
            color: var(--forest-green);
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }
        
        .quick-actions-sidebar .card-body {
            padding: 1rem;
        }
        
        .btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17,94,37,0.06);
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
        
        .btn-outline-success:hover, .btn-outline-info:hover, .btn-outline-warning:hover {
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
        .sidebar-logo img { box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .sidebar-link { padding-left: 1.1rem; padding-right: 1.1rem; }
        .sidebar-link i { font-size: 1.1rem; }
        
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
            <div class="welcome-card">
                <div>
                    <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                    <div class="welcome-text">Welcome back, {{ auth()->user()->first_name ?? auth()->user()->name }}!</div>
                    <div style="font-size: 0.9rem; margin-top: 0.5rem;">Always stay updated in your student portal</div>
                </div>
                <div class="welcome-avatar">
                    <img src="{{ auth()->user()->avatar_url }}" 
                         alt="{{ auth()->user()->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
            </div>
            
            <div class="dashboard-layout">
                <div class="dashboard-stats">
                    <div class="dashboard-stat-card">
                        <div class="stat-value">{{ $studentStats['sessionProgress'] }}%</div>
                        <div class="stat-label">Session Progress</div>
                        <div class="stat-subtitle">{{ $studentStats['totalSessions'] }}/{{ $studentStats['totalScheduled'] }} completed</div>
                        <div class="stat-progress">
                            <div class="stat-progress-bar progress-success" style="width: {{ $studentStats['sessionProgress'] }}%"></div>
                        </div>
                    </div>
                    <div class="dashboard-stat-card wellness-card {{ $studentStats['currentRiskLevel'] }}">
                        <div class="stat-value">
                            <i class="bi bi-heart-fill text-{{ $studentStats['currentRiskLevel'] === 'normal' ? 'success' : ($studentStats['currentRiskLevel'] === 'moderate' ? 'warning' : 'danger') }}"></i>
                            {{ ucfirst($studentStats['currentRiskLevel']) }}
                        </div>
                        <div class="stat-label">Wellness Level</div>
                        <div class="stat-subtitle">{{ $studentStats['consecutiveSessions'] }} week streak</div>
                    </div>
                    <div class="dashboard-stat-card">
                        <div class="stat-value">{{ $studentStats['assessmentProgress'] }}%</div>
                        <div class="stat-label">Assessments Done</div>
                        <div class="stat-subtitle">{{ $studentStats['completedAssessments'] }}/{{ $studentStats['totalAssessments'] }} completed</div>
                        <div class="stat-progress">
                            <div class="stat-progress-bar progress-info" style="width: {{ $studentStats['assessmentProgress'] }}%"></div>
                        </div>
                    </div>
                    <div class="dashboard-stat-card">
                        <div class="stat-value">
                            <i class="bi bi-journal-text text-primary"></i>
                            {{ $studentStats['sessionsWithNotes'] }}
                        </div>
                        <div class="stat-label">Session Notes</div>
                        <div class="stat-subtitle">{{ $studentStats['sessionsWithNotes'] }} notes available for review</div>
                        @if($studentStats['sessionsWithNotes'] > 0)
                            <div class="stat-progress">
                                <div class="stat-progress-bar progress-warning" style="width: 100%"></div>
                            </div>
                        @else
                            <div class="stat-progress">
                                <div class="stat-progress-bar" style="width: 0%"></div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Quick Actions Section - Beside Session Notes -->
                <div class="quick-actions-sidebar">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h6>
                    </div>
                    <div class="card-body">
                                            <div class="d-flex flex-column gap-2">
                        <a href="{{ route('assessments.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-clipboard-check me-1"></i>Take Assessment
                        </a>
                        <a href="{{ route('chat.selectCounselor') }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-chat-dots me-1"></i>Message Counselor
                        </a>
                        <a href="{{ route('appointments.create') }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-calendar-plus me-1"></i>Book Session
                        </a>
                        @if($studentStats['sessionsWithNotes'] > 0)
                            <a href="{{ route('appointments.completedWithNotes') }}" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-journal-text me-1"></i>View Session Notes
                            </a>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
            
            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Upcoming Appointments</h5>
                    <a href="{{ route('appointments.create') }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Book a new appointment">
                        <i class="bi bi-calendar-plus me-1"></i>Book Appointment
                    </a>
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
                                        <i class="bi bi-person me-1"></i>{{ $appointment->counselor->name ?? 'Counselor' }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-calendar me-1"></i>{{ $start->format('F j, Y') }} at {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}
                                    </p>
                                    @if($appointment->status === 'accepted')
                                        <div class="mt-1 text-success small">
                                            <i class="bi bi-journal-text me-1"></i>Your Appointment has been accepted, please proceed to GCC on {{ $start->format('M d, Y') }} at {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}.
                                        </div>
                                    @elseif($appointment->status === 'completed')
                                        <div class="mt-1 text-primary small">
                                            <i class="bi bi-journal-text me-1"></i>Session notes available.
                                        </div>
                                    @elseif($appointment->status === 'declined')
                                        <div class="mt-1 text-danger small">
                                            <i class="bi bi-journal-text me-1"></i>Your appointment was declined. Please select another available slot or contact the GCC for assistance.
                                        </div>
                                    @elseif($appointment->status === 'rescheduled_pending')
                                        <div class="mt-1 text-info small">
                                            <i class="bi bi-arrow-repeat me-1"></i>Your counselor has proposed a new slot. Please accept or decline below.
                                        </div>
                                        <div class="mt-2">
                                            <form action="{{ route('appointments.acceptReschedule', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm me-2">
                                                    <i class="bi bi-check-circle me-1"></i>Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('appointments.declineReschedule', $appointment->id) }}" method="POST" class="d-inline">
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
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-success" data-bs-toggle="tooltip" title="View all your appointments">
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
                        <div class="announcement-item">
                            <h6 class="mb-1 fw-bold small">{{ $announcement->title }}</h6>
                            <p class="mb-1 small text-muted">{{ Str::limit($announcement->content, 80) }}</p>
                            <small class="text-muted">{{ $announcement->created_at->format('F j, Y') }}</small>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-megaphone"></i>
                            <p class="mb-0">No announcements available.</p>
                        </div>
                    @endforelse
                    <div class="text-center mt-3">
                        <a href="{{ route('announcements.index') }}" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="View all announcements">
                            <i class="bi bi-eye me-1"></i>View All
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Recent Messages</h5>
                    <a href="{{ route('chat.selectCounselor') }}" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Open chat with your counselor">
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
                            <a href="{{ route('chat.selectCounselor') }}" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="View all your messages">
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