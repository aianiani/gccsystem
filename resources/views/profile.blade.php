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
            zoom: 0.85;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }

        body,
        .profile-card,
        .stats-card,
        .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        @if(auth()->user()->isAdmin())
            .main-dashboard-inner {
                padding: 2rem;
            }

        @endif

        /* Profile Page Specific Styles */
        .profile-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .profile-avatar-section {
            text-align: center;
            margin-bottom: 1rem;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            margin-bottom: 0.75rem;
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

        .avatar-upload-section {
            text-align: center;
            margin-top: 0.75rem;
        }

        .avatar-upload-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .avatar-upload-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Hero Container Information Styles */
        .hero-info-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-section-title {
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .hero-info-item:last-child {
            border-bottom: none;
        }

        .hero-info-icon {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            margin-top: 0.2rem;
            min-width: 18px;
        }

        .hero-info-content {
            flex: 1;
        }

        .hero-info-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            margin-bottom: 0.2rem;
        }

        .hero-info-value {
            font-size: 0.9rem;
            color: #fff;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .profile-header-card {
                padding: 1.25rem;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
            }

            .profile-name {
                font-size: 1.25rem;
            }

            .hero-info-section {
                margin-top: 1rem;
            }

            .hero-section-title {
                font-size: 0.95rem;
            }

            .hero-info-value {
                font-size: 0.85rem;
            }
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
                    <div class="custom-sidebar">
                        <div class="sidebar-logo mb-4">
                            <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo"
                                style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto;">
                            <h3
                                style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
                                CMU Guidance and Counseling Center</h3>
                            <p style="margin: 0; font-size: 0.95rem; color: #fff; opacity: 0.7;">
                                {{ auth()->user()->isCounselor() ? 'Counselor Portal' : 'Student Portal' }}</p>
                        </div>
                        <nav class="sidebar-nav flex-grow-1">
                            <a href="{{ route('profile') }}"
                                class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i
                                    class="bi bi-person"></i>Profile</a>
                            <a href="{{ route('dashboard') }}"
                                class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i
                                    class="bi bi-house-door"></i>Dashboard</a>
                            @if(auth()->user()->isStudent())
                                <a href="{{ route('appointments.index') }}"
                                    class="sidebar-link{{ request()->routeIs('appointments.*') ? ' active' : '' }}"><i
                                        class="bi bi-calendar-check"></i>Appointments</a>
                                <a href="{{ route('assessments.index') }}"
                                    class="sidebar-link{{ request()->routeIs('assessments.*') ? ' active' : '' }}"><i
                                        class="bi bi-clipboard-data"></i>Assessments</a>
                                <a href="{{ route('chat.selectCounselor') }}"
                                    class="sidebar-link{{ request()->routeIs('chat.selectCounselor') ? ' active' : '' }}"><i
                                        class="bi bi-chat-dots"></i>Chat with a Counselor</a>
                            @endif
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

                        <div class="row g-4">
                            <!-- Left Column: Profile Summary & Account Info -->
                            <div class="col-lg-4">
                                <!-- Profile Summary Card -->
                                <div class="profile-info-card text-center">
                                    <div class="profile-avatar-section">
                                        <img src="{{ $user->avatar_url }}" alt="Profile Picture" class="profile-avatar">
                                        <div class="profile-name">{{ $user->name }}</div>
                                        <div class="profile-email">{{ $user->email }}</div>
                                        <form method="POST" action="{{ route('profile.avatar') }}"
                                            enctype="multipart/form-data" class="avatar-upload-section">
                                            @csrf
                                            <input type="file" name="avatar" id="avatarInput" accept="image/*"
                                                style="display: none;" onchange="this.form.submit()">
                                            <label for="avatarInput" class="btn btn-sm btn-outline-success mt-2">
                                                <i class="bi bi-camera me-1"></i>Change Photo
                                            </label>
                                        </form>
                                    </div>
                                    <hr class="my-3">
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge-status badge-active">{{ ucfirst($user->role) }}</span>
                                        <span class="badge-status {{ $user->isActive() ? 'badge-active' : 'badge-inactive' }}">
                                            {{ $user->isActive() ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Account Information Card -->
                                <div class="profile-info-card">
                                    <div class="card-title">
                                        <i class="bi bi-shield-check"></i>
                                        Account Details
                                    </div>
                                    <div class="info-item">
                                        <i class="bi bi-file-check info-item-icon"></i>
                                        <div class="info-item-content">
                                            <div class="info-item-label">Registration</div>
                                            <div class="info-item-value">
                                                @if($user->registration_status === 'approved')
                                                    <span class="text-success fw-bold">Approved</span>
                                                @elseif($user->registration_status === 'pending')
                                                    <span class="text-warning fw-bold">Pending</span>
                                                @elseif($user->registration_status === 'rejected')
                                                    <span class="text-danger fw-bold">Rejected</span>
                                                @else
                                                    <span class="text-muted">Pending</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="bi bi-calendar-check info-item-icon"></i>
                                        <div class="info-item-content">
                                            <div class="info-item-label">Member Since</div>
                                            <div class="info-item-value">{{ $user->created_at->format('M j, Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="bi bi-clock-history info-item-icon"></i>
                                        <div class="info-item-content">
                                            <div class="info-item-label">Last Login</div>
                                            <div class="info-item-value">{{ $user->updated_at->format('M j, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seminar Badges (Student Only) -->
                                @if(isset($attendanceMatrix))
                                <div class="profile-info-card">
                                    <div class="card-title">
                                        <i class="bi bi-award"></i>
                                        Seminar Badges
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @php
                                            $badges = [
                                                'IDREAMS' => ['color' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => 'bi-clouds-fill', 'year' => 1],
                                                '10C' => ['color' => 'bg-orange-100 text-orange-800 border-orange-200', 'icon' => 'bi-lightbulb-fill', 'year' => 2],
                                                'LEADS' => ['color' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'bi-people-fill', 'year' => 3],
                                                'IMAGE' => ['color' => 'bg-teal-100 text-teal-800 border-teal-200', 'icon' => 'bi-person-badge-fill', 'year' => 4],
                                            ];
                                        @endphp
                                        
                                        @foreach($badges as $seminarName => $style)
                                            @php
                                                $isAttended = isset($attendanceMatrix[$style['year']][$seminarName]);
                                            @endphp
                                            <div class="d-flex align-items-center gap-1 px-2 py-1 rounded-pill border {{ $isAttended ? $style['color'] : 'bg-gray-100 text-gray-400 border-gray-200' }}" style="font-size: 0.8rem;">
                                                @if($isAttended)
                                                    <i class="bi {{ $style['icon'] }}"></i>
                                                    <span class="fw-bold">{{ $seminarName }}</span>
                                                    <i class="bi bi-check-circle-fill opacity-75"></i>
                                                @else
                                                    <i class="bi bi-lock-fill"></i>
                                                    <span class="fw-medium">{{ $seminarName }}</span>
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
                                <div class="form-section">
                                    <div class="form-section-title">
                                        <i class="bi bi-person-lines-fill"></i>
                                        Personal Information
                                    </div>
                                    <form method="POST" action="{{ route('profile.update') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Full Name</label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                    @error('email')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="contact_number" class="form-label">Contact Number</label>
                                                    <input type="tel"
                                                        class="form-control @error('contact_number') is-invalid @enderror"
                                                        id="contact_number" name="contact_number"
                                                        value="{{ old('contact_number', $user->contact_number ?? '') }}"
                                                        placeholder="e.g., 09XXXXXXXXX">
                                                    @error('contact_number')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address" class="form-label">Home Address</label>
                                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                                        id="address" name="address"
                                                        value="{{ old('address', $user->address ?? '') }}"
                                                        placeholder="House/Street, Barangay, City/Province">
                                                    @error('address')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary-custom">
                                                <i class="bi bi-check-circle me-1"></i>Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Student Information Form -->
                                <div class="form-section">
                                    <div class="form-section-title">
                                        <i class="bi bi-mortarboard"></i>
                                        Student Information
                                    </div>
                                    <form method="POST" action="{{ route('profile.update') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="student_id" class="form-label">Student ID</label>
                                                    <input type="text"
                                                        class="form-control @error('student_id') is-invalid @enderror"
                                                        id="student_id" name="student_id"
                                                        value="{{ old('student_id', $user->student_id ?? '') }}"
                                                        placeholder="e.g., 2021-12345">
                                                    @error('student_id')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="college" class="form-label">College</label>
                                                    <input type="text"
                                                        class="form-control @error('college') is-invalid @enderror"
                                                        id="college" name="college"
                                                        value="{{ old('college', $user->college ?? '') }}"
                                                        placeholder="e.g., College of Engineering">
                                                    @error('college')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="course" class="form-label">Course / Program</label>
                                                    <input type="text" class="form-control @error('course') is-invalid @enderror"
                                                        id="course" name="course" value="{{ old('course', $user->course ?? '') }}"
                                                        placeholder="e.g., Bachelor of Science in Computer Science">
                                                    @error('course')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="year_level" class="form-label">Year Level</label>
                                                    <select class="form-control @error('year_level') is-invalid @enderror"
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
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary-custom">
                                                <i class="bi bi-check-circle me-1"></i>Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Change Password Form -->
                                <div class="form-section">
                                    <div class="form-section-title">
                                        <i class="bi bi-key"></i>
                                        Security
                                    </div>
                                    <form method="POST" action="{{ route('profile.password') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="current_password" class="form-label">Current Password</label>
                                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                                        id="current_password" name="current_password" required>
                                                    @error('current_password')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">New Password</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                        id="password" name="password" required>
                                                    @error('password')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                                    <input type="password" class="form-control" id="password_confirmation"
                                                        name="password_confirmation" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary-custom">
                                                <i class="bi bi-shield-lock me-1"></i>Update Password
                                            </button>
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
    @endif
@endsection