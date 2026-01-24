@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
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

        /* Fixed Alignment & Space Utilization */
        .home-zoom {
            zoom: 0.75;
            padding-right: 20px;
            /* Account for zoom shift */
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

        .custom-sidebar .sidebar-link.active,
        .custom-sidebar .sidebar-link:hover {
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

            .custom-sidebar .sidebar-logo {
                display: block;
            }

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
            #counselorSidebarToggle {
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

        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }

        .profile-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .profile-avatar-section {
            text-align: center;
            margin-bottom: 1rem;
        }

        .profile-avatar {
            display: block;
            margin: 0 auto 1rem auto;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.4);
            object-fit: cover;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .profile-email {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .avatar-upload-section {
            margin-top: 0.5rem;
        }

        .avatar-upload-btn {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-block;
        }

        .avatar-upload-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .hero-info-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .hero-section-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.5rem 0;
        }

        .hero-info-icon {
            color: var(--yellow-maize);
            font-size: 1.1rem;
            margin-top: 0.2rem;
            min-width: 20px;
        }

        .hero-info-content {
            flex: 1;
        }

        .hero-info-label {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-bottom: 0.25rem;
        }

        .hero-info-value {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .profile-info-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid var(--gray-100);
        }

        .profile-info-card .card-title {
            color: var(--forest-green);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--forest-green-lighter);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item-icon {
            color: var(--forest-green);
            font-size: 1.1rem;
            margin-top: 0.2rem;
            min-width: 20px;
        }

        .info-item-content {
            flex: 1;
        }

        .info-item-label {
            font-size: 0.85rem;
            color: var(--gray-600);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-item-value {
            font-size: 0.95rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        .info-item-value.empty {
            color: var(--gray-600);
            font-style: italic;
            font-weight: 400;
        }

        .edit-btn {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .edit-btn:hover {
            background: var(--forest-green-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .form-section {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid var(--gray-100);
        }

        .form-section-title {
            color: var(--forest-green);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--forest-green-lighter);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 1px solid var(--gray-100);
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--forest-green);
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        .btn-primary-custom {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary-custom:hover {
            background: var(--forest-green-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .badge-status {
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-active {
            background: var(--success);
            color: white;
        }

        .badge-inactive {
            background: var(--danger);
            color: white;
        }

        .badge-pending {
            background: var(--warning);
            color: var(--text-dark);
        }

        .badge-approved {
            background: var(--success);
            color: white;
        }

        .badge-rejected {
            background: var(--danger);
            color: white;
        }

        @media (max-width: 768px) {
            .profile-header-card {
                padding: 1.5rem;
            }

            .hero-info-section {
                padding: 0.75rem;
            }

            .hero-info-value {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none">
                <i class="bi bi-list"></i>
            </button>
            <!-- Sidebar -->
            @include('counselor.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="container py-1">
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

                        <div class="row g-4">
                            <!-- Left Column: Profile Card and Account Overview -->
                            <div class="col-lg-4">
                                <!-- Profile Header Card (Now more vertical) -->
                                <div class="profile-header-card h-100">
                                    <div class="profile-avatar-section text-center">
                                        <img src="{{ $user->avatar_url }}" alt="Profile Picture" class="profile-avatar">
                                        <div class="profile-name h3 fw-bold mb-1 text-white">{{ $user->name }}</div>
                                        <div class="profile-email mb-4 text-white opacity-75">{{ $user->email }}</div>


                                        <form method="POST" action="{{ route('profile.avatar') }}"
                                            enctype="multipart/form-data" class="avatar-upload-section mb-4">
                                            @csrf
                                            <input type="file" name="avatar" id="avatarInput" accept="image/*"
                                                style="display: none;" onchange="this.form.submit()">
                                            <label for="avatarInput" class="avatar-upload-btn">
                                                <i class="bi bi-camera me-1"></i>Change Photo
                                            </label>
                                        </form>
                                    </div>

                                    <div class="hero-info-section px-0 bg-transparent border-0">
                                        <div class="hero-section-title text-white border-white border-opacity-25 pb-3">
                                            <i class="bi bi-person-badge"></i>
                                            Overview
                                        </div>
                                        <div class="hero-info-item">
                                            <i class="bi bi-shield-check text-warning"></i>
                                            <div class="hero-info-content">
                                                <div class="hero-info-label text-white text-opacity-75">Account Status</div>
                                                <div class="hero-info-value">
                                                    <span
                                                        class="badge bg-white text-success rounded-pill px-3 py-2 small fw-bold">Active</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hero-info-item">
                                            <i class="bi bi-calendar-event text-warning"></i>
                                            <div class="hero-info-content">
                                                <div class="hero-info-label text-white text-opacity-75">Joined Date</div>
                                                <div class="hero-info-value text-white">
                                                    {{ $user->created_at->format('M j, Y') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hero-info-item">
                                            <i class="bi bi-key text-warning"></i>
                                            <div class="hero-info-content">
                                                <div class="hero-info-label text-white text-opacity-75">Privacy Passkey
                                                </div>
                                                <div class="hero-info-value">
                                                    @if($user->passkey)
                                                        <span class="text-white small fw-bold"><i
                                                                class="bi bi-patch-check-fill me-1"></i>Secure</span>
                                                    @else
                                                        <span class="text-white-50 small"><i
                                                                class="bi bi-exclamation-triangle-fill me-1"></i>Default</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="mt-auto pt-4 border-top border-white border-opacity-10 text-center text-white text-opacity-50 small">
                                        Last login: {{ $user->updated_at->format('M j, Y g:i A') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Forms and Detailed Info -->
                            <div class="col-lg-8">
                                <div class="row g-3">
                                    <!-- Personal Info Display (Horizontal) -->
                                    <div class="col-12">
                                        <div class="profile-info-card m-0">
                                            <div class="card-title">
                                                <i class="bi bi-info-circle-fill"></i> Contact Details
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 border-end border-light">
                                                    <div class="info-item border-0">
                                                        <i class="bi bi-telephone info-item-icon"></i>
                                                        <div class="info-item-content">
                                                            <div class="info-item-label">Contact Number</div>
                                                            <div class="info-item-value">
                                                                {{ $user->contact_number ?? 'Not provided' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-item border-0">
                                                        <i class="bi bi-geo-alt info-item-icon"></i>
                                                        <div class="info-item-content">
                                                            <div class="info-item-label">Home Address</div>
                                                            <div class="info-item-value">
                                                                {{ $user->address ?? 'Not provided' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Personal Information -->
                                    <div class="col-md-7">
                                        <div class="form-section h-100 mb-0">
                                            <div class="form-section-title">
                                                <i class="bi bi-pencil-square"></i> Update Profile
                                            </div>
                                            <form method="POST" action="{{ route('profile.update') }}">
                                                @csrf
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="name" class="form-label">Full Name</label>
                                                            <input type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                id="name" name="name" value="{{ old('name', $user->name) }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="email" class="form-label">Email Address</label>
                                                            <input type="email"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                id="email" name="email"
                                                                value="{{ old('email', $user->email) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contact_number" class="form-label">Contact
                                                                Number</label>
                                                            <input type="tel" class="form-control" id="contact_number"
                                                                name="contact_number"
                                                                value="{{ old('contact_number', $user->contact_number ?? '') }}"
                                                                placeholder="09XXXXXXXXX">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="address" class="form-label">Home Address</label>
                                                            <input type="text" class="form-control" id="address"
                                                                name="address"
                                                                value="{{ old('address', $user->address ?? '') }}"
                                                                placeholder="City/Province">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 pt-2">
                                                        <button type="submit" class="btn-primary-custom w-100">
                                                            Sync Changes
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Security & Password -->
                                    <div class="col-md-5">
                                        <!-- Passkey Form -->
                                        <div class="form-section mb-3">
                                            <div class="form-section-title">
                                                <i class="bi bi-shield-lock-fill"></i> Data Passkey
                                            </div>
                                            <form method="POST" action="{{ route('profile.update') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control @error('passkey') is-invalid @enderror"
                                                            id="passkey" name="passkey"
                                                            value="{{ old('passkey', $user->passkey ?? '') }}"
                                                            placeholder="New passkey">
                                                        <button class="btn btn-outline-success" type="button"
                                                            onclick="document.getElementById('passkey').value = Math.random().toString(36).slice(-8).toUpperCase()">Gen</button>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn-primary-custom w-100 py-2">
                                                    Update Passkey
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Password Form -->
                                        <div class="form-section mb-0">
                                            <div class="form-section-title">
                                                <i class="bi bi-key-fill"></i> Secure Password
                                            </div>
                                            <form method="POST" action="{{ route('profile.password') }}">
                                                @csrf
                                                <div class="form-group mb-2">
                                                    <input type="password" class="form-control" name="current_password"
                                                        placeholder="Current password" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="New password" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <input type="password" class="form-control" name="password_confirmation"
                                                        placeholder="Confirm password" required>
                                                </div>
                                                <button type="submit" class="btn-primary-custom w-100 py-2">
                                                    Update Password
                                                </button>
                                            </form>
                                        </div>
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
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
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