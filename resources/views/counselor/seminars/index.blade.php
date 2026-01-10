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

        /* Constrain inner content and center it within the available area */
        .main-dashboard-inner {
            max-width: 100%;
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
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom:hover {
            background: var(--primary-green-2);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(31, 122, 45, 0.4);
            color: #fff;
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
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="text-2xl font-bold m-0">Seminar Management</h2>
                            <p class="opacity-90 m-0 mt-1">Configure seminars and schedules</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="bi bi-calendar-event" style="font-size: 3rem; opacity: 0.2;"></i>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 alert alert-success"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">All Seminars</h3>
                            <a href="{{ route('counselor.seminars.create') }}" class="btn-primary-custom">
                                <i class="bi bi-plus-lg mr-1"></i> Create New Seminar
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full table-custom">
                                <thead>
                                    <tr>
                                        <th class="w-[20%]">Name</th>
                                        <th class="w-[8%] text-center">Year</th>
                                        <th class="w-[22%]">Participation</th>
                                        <th class="w-[35%]">Schedules</th>
                                        <th class="w-[15%] text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($seminars as $seminar)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td>
                                                <div class="font-bold text-gray-900 text-base">{{ $seminar->name }}</div>
                                                <div class="text-sm text-gray-500 mt-1">
                                                    {{ Str::limit($seminar->description, 60) }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-700 font-bold text-sm border border-blue-100">
                                                    {{ $seminar->target_year_level }}
                                                </span>
                                            </td>
                                            <td class="align-middle px-4">
                                                <div class="w-full">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <span class="text-xs font-semibold text-gray-700">{{ $seminar->stats['completed'] }}/{{ $seminar->stats['total'] }}</span>
                                                        <span class="text-xs font-bold text-green-700">{{ $seminar->stats['percentage'] }}%</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: {{ $seminar->stats['percentage'] }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="flex flex-wrap gap-2">
                                                    @forelse($seminar->schedules as $schedule)
                                                        <div
                                                            class="inline-flex flex-col bg-white border border-gray-200 rounded px-2 py-1 shadow-sm text-xs">
                                                            <div class="font-semibold text-gray-800">
                                                                {{ $schedule->date->format('M d, Y') }}
                                                            </div>
                                                            <div class="flex items-center gap-1 text-gray-500">
                                                                <span>{{ $schedule->session_type }}</span>
                                                                @if($schedule->location)
                                                                    <span>&bull;</span>
                                                                    <span>{{ $schedule->location }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <span class="text-gray-400 italic text-sm">No schedules configured</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="text-right whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('counselor.seminars.edit', $seminar) }}"
                                                        class="text-amber-600 hover:text-amber-700 font-medium text-sm px-3 py-1.5 rounded hover:bg-amber-50 transition-colors">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('counselor.seminars.destroy', $seminar) }}"
                                                        method="POST" class="inline-block"
                                                        onsubmit="return confirm('Are you sure you want to delete this seminar?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-700 font-medium text-sm px-3 py-1.5 rounded hover:bg-red-50 transition-colors">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-12 text-gray-400">
                                                <div class="mb-3">
                                                    <i class="bi bi-calendar-x" style="font-size: 2.5rem; opacity: 0.5;"></i>
                                                </div>
                                                <p class="text-lg font-medium text-gray-500">No seminars found</p>
                                                <p class="text-sm">Get started by creating a new seminar.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle for mobile
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
            }
        });
    </script>
@endsection