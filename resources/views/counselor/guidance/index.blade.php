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

        /* Constrain inner content and center it within the available area */
        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }

        /* Custom Styles for Guidance Module */
        .page-header {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            color: #fff;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
        }

        .page-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .card-header-custom {
            background: #fff;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--light-green);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-custom th {
            background-color: var(--light-green);
            color: var(--primary-green);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem 1.5rem;
            border: none;
        }

        .table-custom td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: var(--text-dark);
        }

        .table-custom tr:hover td {
            background-color: #fafdfa;
        }

        .btn-primary-custom {
            background: var(--primary-green);
            border: none;
            color: #fff;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(31, 122, 45, 0.3);
        }

        .btn-primary-custom:hover {
            background: var(--primary-green-2);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(31, 122, 45, 0.4);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--primary-green);
            color: var(--primary-green);
            padding: 0.4rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-outline-custom:hover {
            background: var(--light-green);
            color: var(--primary-green-2);
        }

        .form-control-custom,
        .form-select-custom {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        .badge-custom {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .badge-success-custom {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning-custom {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-locked-custom {
            background-color: #e9ecef;
            color: #6c757d;
        }

        .progress-custom {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            background: var(--hero-gradient);
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
                    
                    <!-- Header -->
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="page-title">Guidance Module</h2>
                            <p class="page-subtitle mt-1">Track and manage student seminar attendance</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="bi bi-compass" style="font-size: 3rem; opacity: 0.2;"></i>
                        </div>
                    </div>

                    <!-- Main Content Card -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Student List</h3>

                            <form method="GET" action="{{ route('counselor.guidance.index') }}"
                                class="row g-2 align-items-center">
                                <!-- Filter by Year -->
                                <div class="col-auto">
                                    <select name="year_level" class="form-select-custom" onchange="this.form.submit()">
                                        <option value="">All Years</option>
                                        <option value="1" {{ request('year_level') == '1' ? 'selected' : '' }}>1st Year</option>
                                        <option value="2" {{ request('year_level') == '2' ? 'selected' : '' }}>2nd Year</option>
                                        <option value="3" {{ request('year_level') == '3' ? 'selected' : '' }}>3rd Year</option>
                                        <option value="4" {{ request('year_level') == '4' ? 'selected' : '' }}>4th Year</option>
                                    </select>
                                </div>

                                <!-- Filter by College -->
                                <div class="col-auto">
                                    <select name="college" class="form-select-custom" onchange="this.form.submit()" style="max-width: 300px;">
                                        <option value="">All Colleges</option>
                                        <option value="College of Arts and Sciences" {{ request('college') == 'College of Arts and Sciences' ? 'selected' : '' }}>College of Arts and Sciences</option>
                                        <option value="College of Veterinary Medicine" {{ request('college') == 'College of Veterinary Medicine' ? 'selected' : '' }}>College of Veterinary Medicine</option>
                                        <option value="College of Forestry and Environmental Sciences" {{ request('college') == 'College of Forestry and Environmental Sciences' ? 'selected' : '' }}>College of Forestry and Environmental Sciences</option>
                                        <option value="College of Business and Management" {{ request('college') == 'College of Business and Management' ? 'selected' : '' }}>College of Business and Management</option>
                                        <option value="College of Nursing" {{ request('college') == 'College of Nursing' ? 'selected' : '' }}>College of Nursing</option>
                                        <option value="College of Human Ecology" {{ request('college') == 'College of Human Ecology' ? 'selected' : '' }}>College of Human Ecology</option>
                                        <option value="College of Agriculture" {{ request('college') == 'College of Agriculture' ? 'selected' : '' }}>College of Agriculture</option>
                                        <option value="College of Information Science and Computing" {{ request('college') == 'College of Information Science and Computing' ? 'selected' : '' }}>College of Information Science and Computing</option>
                                        <option value="College of Education" {{ request('college') == 'College of Education' ? 'selected' : '' }}>College of Education</option>
                                        <option value="College of Engineering" {{ request('college') == 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                                    </select>
                                </div>

                                <!-- Search -->
                                <div class="col-auto flex-grow-1">
                                    <div class="d-flex w-100">
                                        <input type="text" name="search" placeholder="Search student..." value="{{ request('search') }}"
                                            class="form-control-custom rounded-r-none w-100"
                                            style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                        <button type="submit" class="btn-primary-custom rounded-l-none"
                                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;">Search</button>
                                    </div>
                                </div>

                                <!-- Bulk Actions Link -->
                                <div class="col-auto border-start ps-3">
                                    <a href="{{ route('counselor.guidance.bulk.create') }}"
                                        class="btn-outline-custom no-underline d-flex align-items-center gap-2 text-nowrap">
                                        <i class="bi bi-check2-all"></i> Bulk Attendance
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full table-custom">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>ID Number</th>
                                        <th>College</th>
                                        <th>Year</th>
                                        <th class="text-center">Progress</th>
                                        <th class="text-center">Seminars</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $student)
                                        @php
                                            $seminarMap = [
                                                'IDREAMS' => 1,
                                                '10C' => 2,
                                                'LEADS' => 3,
                                                'IMAGE' => 4
                                            ];

                                            $completedCount = 0;
                                            $totalRequiredSoFar = 0;

                                            foreach ($seminarMap as $name => $targetYear) {
                                                if ($student->year_level >= $targetYear) {
                                                    $totalRequiredSoFar++;
                                                    $isAttended = \App\Models\SeminarAttendance::where('user_id', $student->id)
                                                        ->where('seminar_name', $name)
                                                        ->exists();
                                                    if ($isAttended)
                                                        $completedCount++;
                                                }
                                            }
                                            $progressPercent = $totalRequiredSoFar > 0 ? ($completedCount / $totalRequiredSoFar) * 100 : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="font-bold text-gray-800">{{ $student->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                            </td>
                                            <td class="text-sm font-medium">{{ $student->student_id ?? 'N/A' }}</td>
                                            <td class="text-sm font-medium">{{ $student->college ?? 'N/A' }}</td>
                                            <td class="text-sm font-medium">{{ $student->year_level ?? 'N/A' }}</td>

                                            <td class="align-middle" style="min-width: 120px;">
                                                <div class="progress-custom">
                                                    <div class="progress-bar-custom"
                                                        style="width: {{ $progressPercent }}%; height: 100%;"></div>
                                                </div>
                                                <div class="text-xs text-center text-gray-500 mt-1 font-medium">
                                                    {{ $completedCount }}/{{ $totalRequiredSoFar }} Completed</div>
                                            </td>

                                            <td class="text-center">
                                                <div class="flex justify-center gap-2">
                                                    @foreach($seminarMap as $seminarName => $targetYear)
                                                        @php
                                                            $isLocked = $student->year_level < $targetYear;
                                                            $isAttended = \App\Models\SeminarAttendance::where('user_id', $student->id)
                                                                ->where('seminar_name', $seminarName)
                                                                ->exists();

                                                            $badgeClass = 'badge-locked-custom';
                                                            $icon = 'bi-lock-fill';
                                                            $statusText = 'Locked (Year ' . $targetYear . ')';

                                                            if (!$isLocked) {
                                                                if ($isAttended) {
                                                                    $badgeClass = 'badge-success-custom';
                                                                    $icon = 'bi-check-circle-fill';
                                                                    $statusText = 'Completed';
                                                                } else {
                                                                    $badgeClass = 'badge-warning-custom';
                                                                    $icon = 'bi-exclamation-circle';
                                                                    $statusText = 'Pending / Missed';
                                                                }
                                                            }
                                                        @endphp

                                                        <span class="badge-custom {{ $badgeClass }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="{{ $seminarName }}: {{ $statusText }}"
                                                            style="cursor: help;">
                                                            <i class="bi {{ $icon }}"></i>
                                                            <span class="d-none d-lg-inline">{{ substr($seminarName, 0, 1) }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('counselor.guidance.show', $student) }}"
                                                    class="btn-outline-custom text-sm no-underline">
                                                    Manage
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-gray-500">
                                                <i class="bi bi-inbox text-4xl mb-2 block opacity-50"></i>
                                                No students found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="p-4 border-t border-gray-100">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Sidebar toggle for mobile
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
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
            }
        });
    </script>
@endsection