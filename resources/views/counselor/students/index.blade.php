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

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 100%;
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
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
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

        .student-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-light);
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--forest-green-light);
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info,
        .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17, 94, 37, 0.06);
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

        .btn-outline-success:hover,
        .btn-outline-info:hover,
        .btn-outline-warning:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--gray-600);
            background: var(--gray-50);
            border-radius: 12px;
            border: 2px dashed var(--gray-100);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .badge-risk {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-risk.high {
            background: #fee;
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .badge-risk.moderate {
            background: #fffbf0;
            color: var(--warning);
            border: 1px solid var(--warning);
        }

        .badge-risk.normal {
            background: #f0f9f0;
            color: var(--success);
            border: 1px solid var(--success);
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0;
            }
        }

        /* Stats Cards CSS */
        .dashboard-stat-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-lighter);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .stat-icon.primary { background: var(--light-green); color: var(--forest-green); }
        .stat-icon.info { background: #e0f7fa; color: #00acc1; }
        .stat-icon.warning { background: #fff8e1; color: #ffc107; }

        .stat-content { flex-grow: 1; min-width: 0; }
        .stat-label { font-size: 0.9rem; color: var(--text-light); font-weight: 500; margin-bottom: 0.25rem; }
        .stat-value { font-size: 1.85rem; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
        .stat-hint { font-size: 0.8rem; color: #9aa0ac; margin-top: 0.25rem; }

        .averages-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem; width: 100%; margin-top: 0.25rem; }
        .avg-item { text-align: center; background: var(--bg-light); padding: 0.4rem; border-radius: 8px; }
        .avg-label { font-size: 0.75rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;}
        .avg-val { font-size: 1.15rem; font-weight: 700; line-height: 1; margin-bottom: 2px;}
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
                    <div class="welcome-card">
                        <div>
                            <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                            <div class="welcome-text">Students Directory</div>
                            <div style="font-size: 0.9rem; margin-top: 0.5rem;">View and manage all student profiles</div>
                        </div>
                        <div class="welcome-avatar">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row g-3 mb-4 hero-cards">
                        <!-- Total Students -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="dashboard-stat-card">
                                <div class="stat-icon primary">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Total Students</div>
                                    <div class="stat-value">{{ number_format($totalStudents) }}</div>
                                    <div class="stat-hint">Registered students</div>
                                </div>
                            </div>
                        </div>

                        <!-- Year Level Stats -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="dashboard-stat-card ps-3 pe-3">
                                <div class="stat-content">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="stat-label mb-0">Year Level</div>
                                        <div class="stat-icon info" style="width: 32px; height: 32px; font-size: 1rem;">
                                            <i class="bi bi-calendar3"></i>
                                        </div>
                                    </div>
                                    <div class="averages-grid" style="grid-template-columns: repeat(4, 1fr);">
                                        @foreach([1, 2, 3, 4] as $yl)
                                            <div class="avg-item">
                                                <div class="avg-val" style="font-size: 1.1rem; color: var(--forest-green);">
                                                    {{ $yearStats[$yl] ?? 0 }}
                                                </div>
                                                <div class="avg-label">{{ $yl }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gender Stats -->
                        <div class="col-12 col-sm-12 col-md-4">
                            <div class="dashboard-stat-card ps-3 pe-3">
                                <div class="stat-content">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="stat-label mb-0">Sex Ratio</div>
                                        <div class="stat-icon warning" style="width: 32px; height: 32px; font-size: 1rem;">
                                            <i class="bi bi-gender-ambiguous"></i>
                                        </div>
                                    </div>
                                    <div class="averages-grid">
                                        <div class="avg-item">
                                            <div class="avg-val" style="color: #0d6efd;">{{ $sexStats['male'] ?? 0 }}</div>
                                            <div class="avg-label">Male</div>
                                        </div>
                                        <div class="avg-item">
                                            <div class="avg-val" style="color: #d63384;">{{ $sexStats['female'] ?? 0 }}</div>
                                            <div class="avg-label">Female</div>
                                        </div>
                                        @php
                                            $otherCount = ($sexStats['non-binary'] ?? 0) + ($sexStats['prefer_not_to_say'] ?? 0) + ($sexStats['other'] ?? 0);
                                        @endphp
                                        @if($otherCount > 0)
                                            <div class="avg-item">
                                                <div class="avg-val" style="color: #6c757d;">{{ $otherCount }}</div>
                                                <div class="avg-label">Other</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Card -->
                    <div class="filter-card">
                        <h5 class="mb-3" style="color: var(--forest-green); font-weight: 700;">
                            <i class="bi bi-funnel me-2"></i>Filter Students
                        </h5>
                        <form method="GET" action="{{ route('counselor.students.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="search" class="form-label"
                                    style="font-weight: 600; color: var(--text-dark);">Search</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}" placeholder="Name, Email, or Student ID">
                            </div>
                            <div class="col-md-3">
                                <label for="college" class="form-label"
                                    style="font-weight: 600; color: var(--text-dark);">College</label>
                                <select class="form-select" id="college" name="college">
                                    <option value="">All Colleges</option>
                                    @php
                                        $allColleges = [
                                            'College of Arts and Sciences',
                                            'College of Veterinary Medicine',
                                            'College of Forestry and Environmental Sciences',
                                            'College of Business and Management',
                                            'College of Nursing',
                                            'College of Human Ecology',
                                            'College of Agriculture',
                                            'College of Information Science and Computing',
                                            'College of Education',
                                            'College of Engineering'
                                        ];
                                    @endphp
                                    @foreach($allColleges as $college)
                                        <option value="{{ $college }}" {{ request('college') == $college ? 'selected' : '' }}>
                                            {{ $college }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="year_level" class="form-label"
                                    style="font-weight: 600; color: var(--text-dark);">Year Level</label>
                                <select class="form-select" id="year_level" name="year_level">
                                    <option value="">All Year Levels</option>
                                    @foreach($yearLevels as $yearLevel)
                                        <option value="{{ $yearLevel }}" {{ request('year_level') == $yearLevel ? 'selected' : '' }}>
                                            {{ $yearLevel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sex" class="form-label"
                                    style="font-weight: 600; color: var(--text-dark);">Sex</label>
                                <select class="form-select" id="sex" name="sex">
                                    <option value="">All Sexes</option>
                                    <option value="male" {{ request('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('sex') == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="non-binary" {{ request('sex') == 'non-binary' ? 'selected' : '' }}>
                                        Non-binary</option>
                                    <option value="prefer_not_to_say" {{ request('sex') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    <option value="other" {{ request('sex') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary w-100"
                                    style="background: var(--forest-green); border: none;">
                                    <i class="bi bi-funnel"></i>
                                </button>
                                <a href="{{ route('counselor.students.index') }}" class="btn btn-outline-secondary w-100" title="Clear Filters">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Students List Card -->
                    <div class="main-content-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-people me-2"></i>Students ({{ $students->total() }})</h5>
                        </div>
                        <div class="card-body">
                            @forelse($students as $student)
                                @php
                                    $latestAssessment = $student->assessments->first();
                                    $riskLevel = $latestAssessment ? $latestAssessment->risk_level : 'normal';
                                    $totalAppointments = $student->appointments()->where('counselor_id', auth()->id())->count();
                                    $completedSessions = $student->appointments()
                                        ->where('counselor_id', auth()->id())
                                        ->where('status', 'completed')
                                        ->count();
                                @endphp
                                <div class="student-card">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}"
                                                class="student-avatar">
                                            <div>
                                                <h6 class="mb-1 fw-bold" style="color: var(--forest-green); font-size: 1.1rem;">
                                                    {{ $student->name }}
                                                    @if($student->student_id)
                                                        <span class="text-muted fw-normal ms-2" style="font-size: 0.9rem;">
                                                            {{ $student->student_id }}
                                                        </span>
                                                    @endif
                                                </h6>
                                                <div class="d-flex align-items-center text-muted small">
                                                    <i class="bi bi-envelope me-2"></i>{{ $student->email }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-4 flex-wrap">
                                            <div class="d-flex gap-4 me-3">
                                                <div class="text-center">
                                                    <div class="fw-bold" style="color: var(--forest-green); font-size: 1.1rem;">
                                                        {{ $totalAppointments }}
                                                    </div>
                                                    <small class="text-muted" style="font-size: 0.8rem;">Sessions</small>
                                                </div>
                                                <div class="text-center">
                                                    <div class="fw-bold" style="color: var(--forest-green); font-size: 1.1rem;">
                                                        {{ $completedSessions }}
                                                    </div>
                                                    <small class="text-muted" style="font-size: 0.8rem;">Completed</small>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('counselor.students.show', $student->id) }}"
                                                    class="btn btn-outline-success btn-sm px-3">
                                                    <i class="bi bi-eye me-1"></i>View Profile
                                                </a>
                                                <a href="{{ route('chat.index', $student->id) }}"
                                                    class="btn btn-outline-success btn-sm px-3">
                                                    <i class="bi bi-chat-dots me-1"></i>Chat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="bi bi-people"></i>
                                    <h5 class="mb-2">No Students Found</h5>
                                    <p class="mb-0">Try adjusting your filters or check back later.</p>
                                </div>
                            @endforelse

                            <!-- Pagination -->
                            @if($students->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $students->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @endif
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