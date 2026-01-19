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
            @include('student.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="container-fluid px-4 py-4">
                        <style>
                            /* Modern Appointments Theme */
                            .page-header {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                margin-bottom: 2rem;
                                padding-bottom: 1rem;
                                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                            }

                            .page-title {
                                font-size: 1.75rem;
                                font-weight: 700;
                                color: var(--text-dark);
                                margin-bottom: 0;
                                display: flex;
                                align-items: center;
                                gap: 0.75rem;
                            }

                            .page-title i {
                                color: var(--forest-green);
                                background: rgba(31, 122, 45, 0.1);
                                width: 48px;
                                height: 48px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                border-radius: 12px;
                                font-size: 1.5rem;
                            }

                            .stats-pill {
                                background: var(--light-green);
                                color: var(--forest-green);
                                font-size: 0.9rem;
                                font-weight: 600;
                                padding: 0.5rem 1rem;
                                border-radius: 100px;
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                            }

                            /* Modern Card Design */
                            .appointment-card {
                                background: #fff;
                                border: 1px solid rgba(0, 0, 0, 0.04);
                                border-radius: 16px;
                                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
                                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                                overflow: hidden;
                                height: 100%;
                                position: relative;
                            }

                            .appointment-card:hover {
                                transform: translateY(-5px);
                                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
                                border-color: rgba(31, 122, 45, 0.1);
                            }

                            .appointment-card::before {
                                content: '';
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 4px;
                                height: 100%;
                                background: var(--bg-light);
                                transition: background 0.3s;
                            }

                            .appointment-card.status-pending::before {
                                background: var(--warning);
                            }

                            .appointment-card.status-accepted::before {
                                background: var(--success);
                            }

                            .appointment-card.status-completed::before {
                                background: var(--primary-green);
                            }

                            .appointment-card.status-declined::before {
                                background: var(--danger);
                            }

                            .appointment-card.status-rescheduled::before {
                                background: var(--info);
                            }

                            .card-header-styled {
                                padding: 1.25rem 1.5rem;
                                border-bottom: 1px solid rgba(0, 0, 0, 0.03);
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                background: #fff;
                            }

                            .counselor-info {
                                display: flex;
                                align-items: center;
                                gap: 1rem;
                            }

                            .counselor-avatar {
                                width: 48px;
                                height: 48px;
                                border-radius: 12px;
                                object-fit: cover;
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
                            }

                            .counselor-details h5 {
                                font-size: 1rem;
                                font-weight: 700;
                                margin: 0;
                                color: var(--text-dark);
                            }

                            .counselor-details span {
                                font-size: 0.85rem;
                                color: var(--text-light);
                            }

                            .card-body-styled {
                                padding: 1.5rem;
                            }

                            .time-badge {
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                                background: var(--bg-light);
                                color: var(--text-dark);
                                font-weight: 600;
                                padding: 0.6rem 1rem;
                                border-radius: 8px;
                                margin-bottom: 1rem;
                                font-size: 0.95rem;
                                width: 100%;
                            }

                            .time-badge i {
                                color: var(--forest-green);
                            }

                            .status-badge-styled {
                                font-size: 0.85rem;
                                font-weight: 600;
                                padding: 0.4rem 0.85rem;
                                border-radius: 6px;
                                display: inline-block;
                            }

                            .bg-status-pending {
                                background: #fff8e1;
                                color: #b78900;
                            }

                            .bg-status-accepted {
                                background: #e8f5e9;
                                color: #2e7d32;
                            }

                            .bg-status-completed {
                                background: #e3f2fd;
                                color: #1565c0;
                            }

                            .bg-status-declined {
                                background: #ffebee;
                                color: #c62828;
                            }

                            .bg-status-rescheduled {
                                background: #e0f7fa;
                                color: #00838f;
                            }

                            .btn-book-new {
                                background: var(--forest-green);
                                color: white;
                                padding: 0.75rem 1.5rem;
                                border-radius: 12px;
                                font-weight: 600;
                                border: none;
                                box-shadow: 0 4px 15px rgba(31, 122, 45, 0.2);
                                transition: all 0.3s;
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                                text-decoration: none;
                            }

                            .btn-book-new:hover {
                                background: var(--forest-green-dark);
                                transform: translateY(-2px);
                                box-shadow: 0 8px 20px rgba(31, 122, 45, 0.3);
                                color: white;
                            }

                            .session-indicator {
                                position: absolute;
                                top: 1rem;
                                right: 1rem;
                                font-size: 0.75rem;
                                font-weight: 700;
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                                color: var(--text-light);
                                background: #f0f2f5;
                                padding: 0.25rem 0.75rem;
                                border-radius: 4px;
                            }
                        </style>

                        <div class="page-header">
                            <div>
                                <h1 class="page-title">
                                    <i class="bi bi-calendar-check-fill"></i>
                                    My Appointments
                                </h1>
                                <p class="text-muted mt-2 mb-0 ms-1">Manage your counseling sessions and feedback.</p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="stats-pill d-none d-md-flex">
                                    <i class="bi bi-graph-up"></i>
                                    {{ $appointments->count() }} Total
                                </div>
                                <a href="{{ route('appointments.create') }}" class="btn-book-new">
                                    <i class="bi bi-plus-lg"></i>
                                    <span>Book Appointment</span>
                                </a>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill fs-5 me-3"></i>
                                <div class="fw-medium">{{ session('success') }}</div>
                            </div>
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

                                        $statusClass = 'status-pending';
                                        if ($appointment->status === 'accepted')
                                            $statusClass = 'status-accepted';
                                        elseif ($appointment->status === 'completed')
                                            $statusClass = 'status-completed';
                                        elseif ($appointment->status === 'declined' || $appointment->status === 'cancelled')
                                            $statusClass = 'status-declined';
                                        elseif ($appointment->status === 'rescheduled_pending')
                                            $statusClass = 'status-rescheduled';

                                        $sessionNoteForThisAppointment = $appointment->sessionNotes->first();
                                    @endphp
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="appointment-card {{ $statusClass }}">
                                            <div class="card-header-styled">
                                                <div class="counselor-info">
                                                    <img src="{{ $appointment->counselor->avatar_url }}"
                                                        alt="{{ $appointment->counselor->name }}" class="counselor-avatar">
                                                    <div class="counselor-details">
                                                        <h5>{{ $appointment->counselor->name ?? 'Unknown Counselor' }}</h5>
                                                        <span>Counselor</span>
                                                    </div>
                                                </div>
                                                @if($sessionNoteForThisAppointment)
                                                    <div class="session-indicator">Session
                                                        {{ $sessionNoteForThisAppointment->session_number }}</div>
                                                @endif
                                            </div>
                                            <div class="card-body-styled">
                                                <div class="time-badge">
                                                    <i class="bi bi-clock-history"></i>
                                                    {{ $start->format('M d, Y') }} • {{ $start->format('g:i A') }}
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <span class="text-muted small fw-bold text-uppercase">Status</span>
                                                    @if($appointment->status === 'pending')
                                                        <span class="status-badge-styled bg-status-pending"><i
                                                                class="bi bi-hourglass-split me-1"></i>Pending</span>
                                                    @elseif($appointment->status === 'accepted')
                                                        <span class="status-badge-styled bg-status-accepted"><i
                                                                class="bi bi-check-circle me-1"></i>Approved</span>
                                                    @elseif($appointment->status === 'completed')
                                                        <span class="status-badge-styled bg-status-completed"><i
                                                                class="bi bi-check-all me-1"></i>Completed</span>
                                                    @elseif($appointment->status === 'declined')
                                                        <span class="status-badge-styled bg-status-declined"><i
                                                                class="bi bi-x-circle me-1"></i>Declined</span>
                                                    @elseif($appointment->status === 'rescheduled_pending')
                                                        <span class="status-badge-styled bg-status-rescheduled"><i
                                                                class="bi bi-arrow-repeat me-1"></i>Rescheduled</span>
                                                    @endif
                                                </div>

                                                <div class="message-box p-3 rounded-3 bg-light border border-light">
                                                    @if($appointment->status === 'accepted')
                                                        <div class="d-flex gap-2">
                                                            <i class="bi bi-info-circle text-success mt-1"></i>
                                                            <small class="text-success fw-medium">Confirmed. Please proceed to GCC on
                                                                schedule.</small>
                                                        </div>
                                                    @elseif($appointment->status === 'completed')
                                                        <div class="d-flex gap-2">
                                                            <i class="bi bi-journal-check text-primary mt-1"></i>
                                                            <div>
                                                                <small class="text-primary fw-medium d-block">Session completed.</small>
                                                                @if($appointment->sessionNotes->count() > 0)
                                                                    <a href="{{ route('appointments.completedWithNotes') }}"
                                                                        class="text-primary small text-decoration-underline mt-1 d-block">View
                                                                        Session Notes</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @elseif($appointment->status === 'rescheduled_pending')
                                                        <div class="mb-2">
                                                            <small class="text-info fw-bold d-block mb-2">New time proposed:</small>
                                                            <div class="d-flex gap-2">
                                                                <form
                                                                    action="{{ route('appointments.acceptReschedule', $appointment->id) }}"
                                                                    method="POST">
                                                                    @csrf @method('PATCH')
                                                                    <button type="submit" class="btn btn-success btn-sm py-1 px-3"
                                                                        style="font-size: 0.8rem;">Approve</button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('appointments.declineReschedule', $appointment->id) }}"
                                                                    method="POST">
                                                                    @csrf @method('PATCH')
                                                                    <button type="submit"
                                                                        class="btn btn-outline-danger btn-sm py-1 px-3"
                                                                        style="font-size: 0.8rem;">Decline</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @elseif($appointment->notes)
                                                        <div class="d-flex gap-2">
                                                            <i class="bi bi-sticky text-muted mt-1"></i>
                                                            <small
                                                                class="text-muted module-text">{{ Str::limit($appointment->notes, 80) }}</small>
                                                        </div>
                                                    @else
                                                        <small class="text-muted fst-italic">No additional notes.</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <div
                                        style="width: 80px; height: 80px; background: var(--light-green); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-calendar-range text-success" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <h3 class="fw-bold text-dark">No Appointments Yet</h3>
                                <p class="text-muted mb-4">You haven't booked any counseling sessions yet.<br>We're here to
                                    listen whenever you're ready.</p>
                                <a href="{{ route('appointments.create') }}" class="btn-book-new px-4 py-2">
                                    Start Your Journey
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