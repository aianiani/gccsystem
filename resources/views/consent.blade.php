@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
        }

        .home-zoom {
            zoom: 0.85;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--primary-green);
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
        }
        
        .custom-sidebar .sidebar-link.active, .custom-sidebar .sidebar-link:hover {
            background: #4a7c59;
            color: #f4d03f;
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
        }
        
        .custom-sidebar .sidebar-link.logout:hover {
            background: #b52a37;
        }
        
        @media (max-width: 767.98px) {
            .custom-sidebar {
                position: fixed;
                z-index: 1040;
                height: 100vh;
                left: 0;
                top: 0;
                width: 240px;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
            }
            .custom-sidebar.show {
                transform: translateX(0);
            }
            .main-dashboard-content {
                margin-left: 0;
            }
            #studentSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--primary-green);
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 0.5rem 0.75rem;
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

        .consent-container {
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
            padding: 2.5rem;
        }

        .consent-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .consent-header h2 {
            color: #2d5016;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .consent-header p {
            color: #6c757d;
            font-size: 1rem;
        }

        .consent-content {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid #e0e0e0;
        }

        .consent-content h3 {
            color: #2d5016;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .consent-text {
            color: #333;
            font-size: 1.05rem;
            line-height: 1.8;
            text-align: justify;
        }

        .consent-checkbox {
            margin: 2rem 0;
            padding: 1.5rem;
            background: #fff;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
        }

        .consent-checkbox label {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            cursor: pointer;
            font-size: 1.05rem;
            color: #333;
        }

        .consent-checkbox input[type="checkbox"] {
            width: 24px;
            height: 24px;
            margin-top: 2px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .consent-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn-consent {
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-consent-primary {
            background: #2d9a36;
            color: #fff;
        }

        .btn-consent-primary:hover:not(:disabled) {
            background: #237728;
        }

        .btn-consent-primary:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .btn-consent-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-consent-secondary:hover {
            background: #5a6268;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
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
                    <div class="consent-container">
                        <div class="consent-header">
                            <h2>Consent for Counseling Services</h2>
                            <p>Please read and agree to the consent information below to proceed with booking an appointment</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-info">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('info'))
                            <div class="alert alert-info">
                                {{ session('info') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('consent.store') }}" id="consentForm">
                            @csrf
                            
                            <div class="consent-content">
                                <h3>CONSENT</h3>
                                <div class="consent-text">
                                    <p>I consent to avail the counseling services. For purposes of self-awareness, assessment and the like, I am therefore willing to submit information through interviews, data sheets, worksheets, and psychological tests. Nonetheless, I would like my right to privacy and confidentiality to be appropriately upheld, except situations in which I am perceived as been abused, suicidal, or a threat to the safety of others, or in which my counselor is called to testify in court. In addition, I want my right to be acknowledged when I choose to discontinue with the service that is no longer helpful in my development.</p>
                                </div>
                            </div>

                            <div class="consent-checkbox">
                                <label for="consent_agreed">
                                    <input type="checkbox" name="consent_agreed" id="consent_agreed" value="1" required>
                                    <span>I agree to the consent information above.</span>
                                </label>
                                @error('consent_agreed')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="consent-actions">
                                <button type="button" class="btn-consent btn-consent-secondary" onclick="window.location.href='{{ route('dashboard') }}'">
                                    Cancel
                                </button>
                                <button type="submit" class="btn-consent btn-consent-primary" id="submitBtn" disabled>
                                    Continue to Appointment Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('consent_agreed');
            const submitBtn = document.getElementById('submitBtn');

            checkbox.addEventListener('change', function() {
                submitBtn.disabled = !this.checked;
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

