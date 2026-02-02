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
            zoom: 0.75;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
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

        .btn-secondary-custom {
            background: #fff;
            border: 1px solid #e0e0e0;
            color: var(--text-dark);
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary-custom:hover {
            background: #f8f9fa;
            border-color: #d6d8db;
            color: var(--primary-green);
        }

        .form-control-custom,
        .form-select-custom {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
            outline: none;
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
                    <div class="mb-6">
                        <a href="{{ route('counselor.seminars.index') }}" class="btn-secondary-custom">
                            <i class="bi bi-arrow-left"></i> Back to Seminars
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 alert alert-success"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Edit Seminar Details -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Edit Seminar Details</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('counselor.seminars.update', $seminar) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Seminar Name</label>
                                    <input type="text" name="name" id="name" value="{{ $seminar->name }}"
                                        class="form-control-custom w-full" required>
                                </div>

                                <div class="mb-4">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="form-control-custom w-full">{{ $seminar->description }}</textarea>
                                </div>

                                <div class="mb-6">
                                    <label for="target_year_level" class="block text-sm font-medium text-gray-700 mb-2">Target Year
                                        Level</label>
                                    <select name="target_year_level" id="target_year_level" class="form-select-custom w-full"
                                        required>
                                        <option value="1" {{ $seminar->target_year_level == 1 ? 'selected' : '' }}>1st Year</option>
                                        <option value="2" {{ $seminar->target_year_level == 2 ? 'selected' : '' }}>2nd Year</option>
                                        <option value="3" {{ $seminar->target_year_level == 3 ? 'selected' : '' }}>3rd Year</option>
                                        <option value="4" {{ $seminar->target_year_level == 4 ? 'selected' : '' }}>4th Year</option>
                                    </select>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="btn-primary-custom">Update Seminar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Manage Schedules -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Manage Schedules</h3>
                        </div>
                        <div class="p-6">
                            <!-- Add Schedule Form -->
                            <form action="{{ route('counselor.seminars.schedules.store', $seminar) }}" method="POST"
                                class="mb-8 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                @csrf
                                <h4 class="text-md font-semibold mb-4 text-gray-700">Add New Schedule</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                                    <div>
                                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                        <input type="date" name="date" id="date" class="form-control-custom w-full" required>
                                    </div>
                                    <div>
                                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                        <input type="text" name="location" id="location" class="form-control-custom w-full"
                                            placeholder="e.g. University Hall">
                                    </div>
                                    <div>
                                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic
                                            Year</label>
                                        <input type="text" name="academic_year" id="academic_year"
                                            class="form-control-custom w-full" placeholder="e.g. 2025-2026">
                                    </div>
                                    <div>
                                        <label for="session_type" class="block text-sm font-medium text-gray-700 mb-1">Session Type</label>
                                        <select name="session_type" id="session_type" class="form-select-custom w-full" required>
                                            <option value="Morning">Morning (8:00 AM - 12:00 PM)</option>
                                            <option value="Afternoon">Afternoon (1:00 PM - 5:00 PM)</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign Colleges</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-48 overflow-y-auto border border-gray-200 rounded p-2 bg-white">
                                            @php
                                                $colleges = [
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
                                            @foreach($colleges as $college)
                                                <div class="flex items-center">
                                                    <input type="checkbox" name="colleges[]" value="{{ $college }}" id="college_{{ $loop->index }}" class="mr-2">
                                                    <label for="college_{{ $loop->index }}" class="text-sm text-gray-700">{{ $college }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="md:col-span-2">
                                        <button type="submit" class="btn-primary-custom w-full">Add Schedule</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Schedules List -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-custom text-sm">
                                    <thead>
                                        <tr>
                                            <th class="w-1/4">Date & Time</th>
                                            <th class="w-1/4">Location</th>
                                            <th class="w-1/3">Target Colleges</th>
                                            <th class="w-1/6 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($seminar->schedules as $schedule)
                                            <tr>
                                                <td class="align-top">
                                                    <div class="font-bold text-gray-800 text-base mb-1">{{ $schedule->date->format('F d, Y') }}</div>
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $schedule->session_type === 'Morning' ? 'bg-yellow-100 text-yellow-800' : 'bg-orange-100 text-orange-800' }}">
                                                            {{ $schedule->session_type }} Session
                                                        </span>
                                                        <span class="text-xs text-gray-500 font-medium">
                                                            @if($schedule->session_type === 'Morning')
                                                                (8:00 AM - 12:00 PM)
                                                            @else
                                                                (1:00 PM - 5:00 PM)
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="text-xs text-gray-400">AY {{ $schedule->academic_year }}</div>
                                                </td>
                                                <td class="align-top font-medium text-gray-700">
                                                    <div class="flex items-start gap-2">
                                                        <i class="bi bi-geo-alt-fill text-gray-400 mt-1"></i>
                                                        <span>{{ $schedule->location ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-top">
                                                    @if($schedule->colleges)
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($schedule->colleges as $college)
                                                                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs border border-gray-200">
                                                                    {{-- Abbreviate common college names if needed, or just show full --}}
                                                                    {{ $college }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-xs font-medium border border-green-100">All Colleges</span>
                                                    @endif
                                                </td>
                                                <td class="text-right align-top">
                                                    <form action="{{ route('counselor.seminars.schedules.destroy', $schedule) }}"
                                                        method="POST" class="delete-form" data-confirm-message="Delete this schedule?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition-colors" title="Delete Schedule">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-8 text-gray-400 italic">
                                                    <div class="mb-2"><i class="bi bi-calendar-x" style="font-size: 2rem;"></i></div>
                                                    No schedules configured yet.
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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