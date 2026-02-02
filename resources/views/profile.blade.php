@extends('layouts.app')

@section('content')
@section('full_width', true)
    <style>
        /* Sidebar Alignment Fix */
        .main-dashboard-content {
            margin-left: 280px !important;
            /* Force margin to match sidebar */
            padding: 2rem;
            /* Added padding for spacing */
            transition: margin-left 0.3s ease;
            width: auto !important;
            /* Ensure it takes available width */
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 0 !important;
            }
        }

        /* Premium Design Variables */
        :root {
            /* Primary Brand Colors - Richer & Deep */
            --primary-green: #1b5e20;
            /* Deep Forest Green */
            --primary-green-light: #2e7d32;
            /* Lighter Forest */
            --primary-green-dark: #003300;
            /* Almost Black Green */

            /* Accents */
            --accent-gold: #FFD700;
            /* Premium Gold */
            --accent-gold-light: #fff9c4;
            --accent-orange: #f57f17;

            /* Backgrounds */
            --bg-body: #f4f6f8;
            /* Soft Blue-Grey */
            --bg-card: #ffffff;
            --bg-glass: rgba(255, 255, 255, 0.9);

            /* Text */
            --text-main: #1a1a1a;
            --text-secondary: #5f6368;
            --text-light: #9aa0a6;

            /* Shadows & Effects */
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 8px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 16px 32px rgba(0, 0, 0, 0.12);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);

            --glass-border: 1px solid rgba(255, 255, 255, 0.5);
            --radius-xl: 24px;
            --radius-lg: 16px;
            --radius-md: 12px;

            --hero-gradient: linear-gradient(135deg, #1b5e20 0%, #0d3b10 100%);
            --gold-gradient: linear-gradient(135deg, #FFD700 0%, #FFC107 100%);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: var(--text-main);
        }

        /* Home Zoom Wrapper */
        @media (max-width: 768px) {
            .home-zoom {
                zoom: 1 !important;
                transform: none !important;
            }
        }

        /* ----------------------
                                               Layout & Sidebar 
                                               ---------------------- */

        .main-dashboard-content {
            background: var(--bg-body);
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            .main-dashboard-content {
                padding: 1rem 0.75rem !important;
            }
        }

        /* Ensure sidebar links are styled if not inherited */
        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2.5rem 1.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.05);
        }

        .custom-sidebar .sidebar-logo h3 {
            font-family: 'Segoe UI', sans-serif;
            /* Fallback */
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        /* ----------------------
                                               Premium Components 
                                               ---------------------- */

        /* Profile Header Banner */
        .profile-header-wrapper {
            position: relative;
            margin-bottom: 80px;
            /* Space for floating avatar */
        }

        .profile-banner {
            background: var(--hero-gradient);
            min-height: 250px;
            /* Allow growth */
            border-radius: var(--radius-xl);
            position: relative;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            display: flex;
            /* Enable flex layout */
            align-items: center;
            /* Vertically center content */
        }

        .profile-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .banner-content {
            width: 100%;
            padding: 30px 40px;
            /* Adjusted padding */
            color: white;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .profile-header-wrapper {
                margin-bottom: 60px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .profile-banner {
                min-height: auto;
                height: auto;
                padding: 1.5rem 1rem;
            }

            .banner-content {
                padding: 0;
                text-align: center;
                flex-direction: column !important;
                gap: 1.25rem;
            }

            .banner-content .d-flex.flex-column {
                align-items: center !important;
                width: 100%;
                text-align: center;
            }

            .banner-content .d-flex.flex-wrap {
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 0.5rem !important;
            }

            .banner-content .d-flex.flex-wrap > div {
                justify-content: center !important;
            }

            .banner-content .text-truncate {
                max-width: 100% !important;
                white-space: normal !important;
            }

            .profile-avatar-wrapper {
                position: relative;
                bottom: 0;
                right: 0;
                margin-top: -50px;
                margin-bottom: 0;
                display: flex;
                justify-content: center;
                width: 100%;
                z-index: 5;
            }

            .profile-avatar-lg {
                width: 100px;
                height: 100px;
            }
            
            .flex-shrink-0.ms-4.position-relative {
                margin-left: 0 !important;
                margin-top: 1rem;
                display: flex;
                justify-content: center;
                width: 100%;
            }
        }

        /* Fixed Floating Avatar to align relative to the wrapper, not the clipped banner */
        .profile-avatar-wrapper {
            position: absolute;
            bottom: -60px;
            right: 40px;
            z-index: 2;
        }

        .profile-avatar-lg {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.8);
            box-shadow: var(--shadow-lg);
            object-fit: cover;
            background: white;
        }

        .avatar-edit-overlay {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--accent-gold);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
            border: 2px solid white;
        }

        .avatar-edit-overlay:hover {
            transform: scale(1.1);
        }

        /* Premium Cards */
        .premium-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .premium-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-header-premium {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-title-premium {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-green);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title-icon {
            background: var(--primary-green);
            /* Fallback */
            background: linear-gradient(135deg, var(--primary-green-light) 0%, var(--primary-green) 100%);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(31, 122, 45, 0.2);
        }

        /* Form Styling */
        .form-label-premium {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control-premium {
            border: 2px solid #f0f0f0;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-main);
            transition: all 0.2s;
            background: #fafafa;
        }

        .form-control-premium:focus {
            background: white;
            border-color: var(--primary-green-light);
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
            outline: none;
        }

        .form-control-premium::placeholder {
            color: #ccc;
        }

        /* Buttons */
        .btn-premium {
            background: var(--hero-gradient);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(27, 94, 32, 0.3);
            transition: all 0.3s;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(27, 94, 32, 0.4);
            color: white;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-inactive {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* Info Lists */
        .info-list-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px dashed #e0e0e0;
        }

        .info-list-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            color: var(--primary-green-light);
            font-size: 1.2rem;
            margin-right: 1rem;
            width: 24px;
            text-align: center;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 0.2rem;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-main);
        }

        /* Seminar Badges Redesign */
        .seminar-badge-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            background: #f8f9fa;
            border: 1px solid #eee;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
        }

        .seminar-badge-card.earned {
            background: white;
            border-color: var(--accent-gold);
            box-shadow: var(--shadow-sm);
        }

        .badge-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* Mobile Sidebar adjustments */
        @media (max-width: 767.98px) {
            .welcome-text {
                font-size: 1.35rem;
            }

            /* Mobile Adjustments handled in app.blade.php */
        }
    </style>

    @if(auth()->user()->isAdmin())
        <div class="main-dashboard-inner">
    @else
            <div class="home-zoom">
                <div class="d-flex">
                    <!-- Mobile Sidebar Toggle -->
                    <button id="studentSidebarToggle" class="d-md-none">
                        <i class="bi bi-list"></i>
                    </button>
                    <!-- Sidebar -->
                    <!-- Sidebar -->
                    @if(auth()->user()->isCounselor())
                        <div class="custom-sidebar">
                            <div class="sidebar-logo">
                                <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo"
                                    style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <h3
                                    style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
                                    CMU Guidance and Counseling Center</h3>
                                <p
                                    style="margin: 0; font-size: 0.8rem; color: #fff; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
                                    Counselor Portal</p>
                            </div>
                            <nav class="sidebar-nav">
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
                            </nav>
                            <div class="sidebar-bottom w-100">
                                <a href="{{ route('logout') }}" class="sidebar-link logout"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">
                                    <i class="bi bi-box-arrow-right"></i>Logout
                                </a>
                                <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        @include('student.sidebar')
                    @endif

                    <!-- Main Content -->
                    <div class="main-dashboard-content flex-grow-1">
                        <div class="main-dashboard-inner">
        @endif
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                style="border-radius: 8px; margin-bottom: 1rem;">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="border-radius: 8px; margin-bottom: 1rem;">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Profile Premium Header -->
                        <!-- Profile Premium Header -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="profile-header-wrapper">
                                    <div class="profile-banner">
                                        <div class="banner-content d-flex justify-content-between align-items-center h-100">
                                            <!-- Left Side: Info -->
                                            <div class="d-flex flex-column justify-content-center h-100 flex-grow-1">
                                                <div class="d-flex align-items-center gap-3 mb-1">
                                                    <h1 class="welcome-text text-white mb-0">Hello,
                                                        {{ explode(' ', $user->name)[0] }}!</h1>

                                                    <!-- Seminar Badges (Beside Greetings) -->
                                                    @if(isset($attendanceMatrix))
                                                        <div class="d-flex gap-1">
                                                            @php
                                                                $badges = [
                                                                    'New Student Orientation Program' => ['icon' => 'bi-compass-fill', 'year' => 1],
                                                                    'IDREAMS' => ['icon' => 'bi-clouds-fill', 'year' => 1],
                                                                    '10C' => ['icon' => 'bi-lightbulb-fill', 'year' => 2],
                                                                    'LEADS' => ['icon' => 'bi-people-fill', 'year' => 3],
                                                                    'IMAGE' => ['icon' => 'bi-person-badge-fill', 'year' => 4],
                                                                ];
                                                            @endphp
                                                            @foreach($badges as $seminarName => $style)
                                                                @php
                                                                    $isAttended = isset($attendanceMatrix[$style['year']][$seminarName]);
                                                                @endphp
                                                                @if($isAttended)
                                                                    <div class="d-flex align-items-center justify-content-center rounded-circle"
                                                                        style="width: 28px; height: 28px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4);"
                                                                        title="{{ $seminarName }}">
                                                                        <i class="bi {{ $style['icon'] }}"
                                                                            style="color: #ffd700; font-size: 0.9rem;"></i>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>

                                                <p class="welcome-sub text-white-50 mb-3">{{ $user->email }}</p>

                                                <!-- Student Details in Banner -->
                                                <div class="d-flex flex-column gap-2">
                                                    <!-- Row 1: Academic Info -->
                                                    <div class="d-flex flex-wrap align-items-center gap-4 text-white-50"
                                                        style="font-size: 0.9rem;">
                                                        @if($user->student_id)
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="bi bi-card-heading text-warning"></i>
                                                                <span
                                                                    class="fw-medium text-white">{{ $user->student_id }}</span>
                                                            </div>
                                                        @endif

                                                        @if($user->course)
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="bi bi-mortarboard text-warning"></i>
                                                                <span class="text-white text-truncate"
                                                                    style="max-width: 300px;">{{ $user->course }}</span>
                                                            </div>
                                                        @endif

                                                        @if($user->college)
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="bi bi-building text-warning"></i>
                                                                <span class="text-white text-truncate"
                                                                    style="max-width: 200px;">{{ $user->college }}</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Row 2: Personal Info -->
                                                    <div class="d-flex flex-wrap align-items-center gap-4 text-white-50"
                                                        style="font-size: 0.9rem;">
                                                        @if($user->contact_number)
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="bi bi-telephone text-warning"></i>
                                                                <span class="text-white">{{ $user->contact_number }}</span>
                                                            </div>
                                                        @endif

                                                        @if($user->address)
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="bi bi-geo-alt text-warning"></i>
                                                                <span class="text-white text-truncate"
                                                                    style="max-width: 400px;">{{ $user->address }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Side: Avatar (Inside Card) -->
                                            <div class="flex-shrink-0 ms-4 position-relative">
                                                <img src="{{ $user->avatar_url }}" alt="Profile" class="profile-avatar-lg">
                                                <form method="POST" action="{{ route('profile.avatar') }}"
                                                    enctype="multipart/form-data" id="avatarForm">
                                                    @csrf
                                                    <input type="file" name="avatar" id="avatarInput" accept="image/*"
                                                        style="display:none" onchange="this.form.submit()">
                                                    <label for="avatarInput" class="avatar-edit-overlay"
                                                        title="Change Photo"
                                                        style="width: 28px; height: 28px; right: 5px; bottom: 5px;">
                                                        <i class="bi bi-camera-fill text-white"
                                                            style="font-size: 0.75rem;"></i>
                                                    </label>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <!-- Left Column: Account Info & Badges -->
                                        <div class="col-lg-4">
                                            <!-- Status Card -->
                                            <div class="premium-card text-center pb-4 pt-5">
                                                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                                                <p class="text-muted mb-4">{{ $user->email }}</p>

                                                <div class="d-flex justify-content-center gap-2 mb-4">
                                                    <span
                                                        class="status-badge status-active">{{ ucfirst($user->role) }}</span>
                                                    <span
                                                        class="status-badge {{ $user->isActive() ? 'status-active' : 'status-inactive' }}">
                                                        {{ $user->isActive() ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>

                                                <div class="text-start mt-4 pt-3 border-top">
                                                    <h6 class="text-uppercase text-secondary fw-bold small mb-3 ls-1">
                                                        Account Details
                                                    </h6>

                                                    <div class="info-list-item">
                                                        <div class="info-icon"><i class="bi bi-shield-check"></i></div>
                                                        <div>
                                                            <div class="info-label">Registration Status</div>
                                                            <div class="info-value">
                                                                @if($user->registration_status === 'approved')
                                                                    <span class="text-success">Approved</span>
                                                                @elseif($user->registration_status === 'pending')
                                                                    <span class="text-warning">Pending</span>
                                                                @elseif($user->registration_status === 'rejected')
                                                                    <span class="text-danger">Rejected</span>
                                                                @else
                                                                    <span class="text-muted">Pending</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="info-list-item">
                                                        <div class="info-icon"><i class="bi bi-calendar-check"></i></div>
                                                        <div>
                                                            <div class="info-label">Member Since</div>
                                                            <div class="info-value">
                                                                {{ $user->created_at->format('M j, Y') }}</div>
                                                        </div>
                                                    </div>

                                                    <div class="info-list-item">
                                                        <div class="info-icon"><i class="bi bi-clock-history"></i></div>
                                                        <div>
                                                            <div class="info-label">Last Login</div>
                                                            <div class="info-value">
                                                                {{ $user->updated_at->format('M j, Y g:i A') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Seminar Badges (Student Only) -->
                                            @if(isset($attendanceMatrix))
                                                <div class="premium-card">
                                                    <div class="card-header-premium border-0 p-0 mb-3">
                                                        <div class="card-title-premium" style="font-size: 1.1rem">
                                                            <i class="bi bi-award-fill text-warning me-2"
                                                                style="font-size: 1.5rem;"></i>
                                                            Seminar Badges
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column gap-2">
                                                        @php
                                                            $badges = [
                                                                'New Student Orientation Program' => ['color' => 'bg-secondary-subtle text-secondary', 'icon' => 'bi-compass-fill', 'year' => 1, 'label' => 'NSOP'],
                                                                'IDREAMS' => ['color' => 'bg-primary-subtle text-primary', 'icon' => 'bi-clouds-fill', 'year' => 1],
                                                                '10C' => ['color' => 'bg-warning-subtle text-warning', 'icon' => 'bi-lightbulb-fill', 'year' => 2],
                                                                'LEADS' => ['color' => 'bg-info-subtle text-info', 'icon' => 'bi-people-fill', 'year' => 3],
                                                                'IMAGE' => ['color' => 'bg-success-subtle text-success', 'icon' => 'bi-person-badge-fill', 'year' => 4],
                                                            ];
                                                        @endphp

                                                        @foreach($badges as $seminarName => $style)
                                                            @php
                                                                $isAttended = isset($attendanceMatrix[$style['year']][$seminarName]);
                                                            @endphp
                                                            <div class="seminar-badge-card {{ $isAttended ? 'earned' : '' }}">
                                                                <div
                                                                    class="badge-icon-box {{ $isAttended ? $style['color'] : 'bg-light text-muted' }}">
                                                                    <i class="bi {{ $style['icon'] }}"></i>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div
                                                                        class="fw-bold {{ $isAttended ? 'text-dark' : 'text-muted' }}">
                                                                        {{ $style['label'] ?? $seminarName }}
                                                                    </div>
                                                                    <div
                                                                        class="small {{ $isAttended ? 'text-success' : 'text-muted' }}">
                                                                        {{ $isAttended ? 'Earned' : 'Locked' }}
                                                                    </div>
                                                                </div>
                                                                @if($isAttended)
                                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                                @else
                                                                    <i class="bi bi-lock-fill text-muted opacity-50"></i>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Right Column: Edit Forms -->
                                        <div class="col-lg-8">
                                            <!-- Personal Information Form -->
                                            <div class="premium-card">
                                                <div class="card-header-premium">
                                                    <div class="card-title-premium">
                                                        <div class="card-title-icon"><i class="bi bi-person-lines-fill"></i>
                                                        </div>
                                                        Personal Information
                                                    </div>
                                                </div>
                                                <form method="POST" action="{{ route('profile.update') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="name" class="form-label-premium">Full
                                                                    Name</label>
                                                                <input type="text"
                                                                    class="form-control-premium @error('name') is-invalid @enderror"
                                                                    id="name" name="name"
                                                                    value="{{ old('name', $user->name) }}" required>
                                                                @error('name')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="email" class="form-label-premium">Email
                                                                    Address</label>
                                                                <input type="email"
                                                                    class="form-control-premium @error('email') is-invalid @enderror"
                                                                    id="email" name="email"
                                                                    value="{{ old('email', $user->email) }}" required>
                                                                @error('email')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="contact_number"
                                                                    class="form-label-premium">Contact
                                                                    Number</label>
                                                                <input type="tel"
                                                                    class="form-control-premium @error('contact_number') is-invalid @enderror"
                                                                    id="contact_number" name="contact_number"
                                                                    value="{{ old('contact_number', $user->contact_number ?? '') }}"
                                                                    placeholder="e.g., 09XXXXXXXXX">
                                                                @error('contact_number')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="address" class="form-label-premium">Home
                                                                    Address</label>
                                                                <input type="text"
                                                                    class="form-control-premium @error('address') is-invalid @enderror"
                                                                    id="address" name="address"
                                                                    value="{{ old('address', $user->address ?? '') }}"
                                                                    placeholder="House/Street, Barangay, City/Province">
                                                                @error('address')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-0">
                                                                <label for="sex" class="form-label-premium">Sex</label>
                                                                <select
                                                                    class="form-control-premium @error('sex') is-invalid @enderror"
                                                                    id="sex" name="sex">
                                                                    <option value="">Select Sex</option>
                                                                    <option value="male" {{ old('sex', $user->sex ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                                                                    <option value="female" {{ old('sex', $user->sex ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                                                                </select>
                                                                @error('sex')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-end mt-4">
                                                            <button type="submit" class="btn btn-premium">
                                                                <i class="bi bi-check-circle me-2"></i>Save Changes
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Student Information Form -->
                                            <div class="premium-card">
                                                <div class="card-header-premium">
                                                    <div class="card-title-premium">
                                                        <div class="card-title-icon"><i class="bi bi-mortarboard-fill"></i>
                                                        </div>
                                                        Student Information
                                                    </div>
                                                </div>
                                                <form method="POST" action="{{ route('profile.update') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="student_id" class="form-label-premium">Student
                                                                    ID</label>
                                                                <input type="text"
                                                                    class="form-control-premium @error('student_id') is-invalid @enderror"
                                                                    id="student_id" name="student_id"
                                                                    value="{{ old('student_id', $user->student_id ?? '') }}"
                                                                    placeholder="e.g., 2021-12345">
                                                                @error('student_id')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="college"
                                                                    class="form-label-premium">College</label>
                                                                <input type="text"
                                                                    class="form-control-premium @error('college') is-invalid @enderror"
                                                                    id="college" name="college"
                                                                    value="{{ old('college', $user->college ?? '') }}"
                                                                    placeholder="e.g., College of Engineering">
                                                                @error('college')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="course" class="form-label-premium">Course /
                                                                    Program</label>
                                                                <input type="text"
                                                                    class="form-control-premium @error('course') is-invalid @enderror"
                                                                    id="course" name="course"
                                                                    value="{{ old('course', $user->course ?? '') }}"
                                                                    placeholder="e.g., Bachelor of Science in Computer Science">
                                                                @error('course')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="year_level" class="form-label-premium">Year
                                                                    Level</label>
                                                                <select
                                                                    class="form-control-premium @error('year_level') is-invalid @enderror"
                                                                    id="year_level" name="year_level">
                                                                    <option value="">Select</option>
                                                                    <option value="1st Year" {{ old('year_level', $user->year_level ?? '') === '1st Year' ? 'selected' : '' }}>1st Year</option>
                                                                    <option value="2nd Year" {{ old('year_level', $user->year_level ?? '') === '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                                                    <option value="3rd Year" {{ old('year_level', $user->year_level ?? '') === '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                                                    <option value="4th Year" {{ old('year_level', $user->year_level ?? '') === '4th Year' ? 'selected' : '' }}>4th Year</option>
                                                                    <option value="5th Year" {{ old('year_level', $user->year_level ?? '') === '5th Year' ? 'selected' : '' }}>5th Year</option>
                                                                </select>
                                                                @error('year_level')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-end mt-4">
                                                            <button type="submit" class="btn btn-premium">
                                                                <i class="bi bi-check-circle me-2"></i>Save Changes
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Change Password Form -->
                                            <div class="premium-card">
                                                <div class="card-header-premium">
                                                    <div class="card-title-premium">
                                                        <div class="card-title-icon"><i class="bi bi-shield-lock-fill"></i>
                                                        </div>
                                                        Security & Password
                                                    </div>
                                                </div>
                                                <form method="POST" action="{{ route('profile.password') }}">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="current_password"
                                                                    class="form-label-premium">Current
                                                                    Password</label>
                                                                <input type="password"
                                                                    class="form-control-premium @error('current_password') is-invalid @enderror"
                                                                    id="current_password" name="current_password" required>
                                                                @error('current_password')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="password" class="form-label-premium">New
                                                                    Password</label>
                                                                <input type="password"
                                                                    class="form-control-premium @error('password') is-invalid @enderror"
                                                                    id="password" name="password" required>
                                                                @error('password')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label for="password_confirmation"
                                                                    class="form-label-premium">Confirm
                                                                    New Password</label>
                                                                <input type="password" class="form-control-premium"
                                                                    id="password_confirmation" name="password_confirmation"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-end mt-4">
                                                            <button type="submit" class="btn btn-premium">
                                                                <i class="bi bi-shield-check me-2"></i>Update Password
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!auth()->user()->isAdmin())
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
                        @endif
@endsection