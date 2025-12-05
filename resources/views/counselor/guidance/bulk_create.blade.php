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

        .form-control-custom, .form-select-custom {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus, .form-select-custom:focus {
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
                        <a href="{{ route('counselor.guidance.index') }}" class="btn-secondary-custom">
                            <i class="bi bi-arrow-left"></i> Back to Student List
                        </a>
                    </div>

                    <div class="page-header">
                        <h2 class="text-2xl font-bold m-0">Bulk Attendance Marking</h2>
                        <p class="opacity-90 m-0 mt-1">Efficiently mark attendance for multiple students at once</p>
                    </div>

                    <div class="content-card mb-6">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Option 1: Select Manually</h3>
                        </div>
                        <div class="p-6">
                            <form method="GET" action="{{ route('counselor.guidance.bulk.create') }}">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                                    <div>
                                        <label for="year_level" class="block text-sm font-medium text-gray-700 mb-2">Year Level</label>
                                        <select name="year_level" id="year_level" class="form-select-custom w-full" required>
                                            <option value="">Select Year</option>
                                            <option value="1" {{ request('year_level') == '1' ? 'selected' : '' }}>1st Year</option>
                                            <option value="2" {{ request('year_level') == '2' ? 'selected' : '' }}>2nd Year</option>
                                            <option value="3" {{ request('year_level') == '3' ? 'selected' : '' }}>3rd Year</option>
                                            <option value="4" {{ request('year_level') == '4' ? 'selected' : '' }}>4th Year</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="college" class="block text-sm font-medium text-gray-700 mb-2">College (Optional)</label>
                                        <select name="college" id="college" class="form-select-custom w-full">
                                            <option value="">All Colleges</option>
                                            @foreach($colleges as $college)
                                                <option value="{{ $college }}" {{ request('college') == $college ? 'selected' : '' }}>{{ $college }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="seminar_id" class="block text-sm font-medium text-gray-700 mb-2">Seminar</label>
                                        <select name="seminar_id" id="seminar_id" class="form-select-custom w-full" required>
                                            <option value="">Select Seminar</option>
                                            @foreach($seminars as $seminar)
                                                <option value="{{ $seminar->id }}" {{ request('seminar_id') == $seminar->id ? 'selected' : '' }}>
                                                    {{ $seminar->name }} (Year {{ $seminar->target_year_level }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn-primary-custom w-full">Load Students</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if(request('year_level') && request('seminar_id'))
                        <div class="content-card mb-6">
                            <div class="card-header-custom d-flex justify-content-between align-items-center">
                                <h3 class="text-lg font-bold text-gray-800 m-0">Step 2: Select Students</h3>
                                <div class="space-x-2">
                                    <button type="button" onclick="toggleAll(true)" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Select All</button>
                                    <span class="text-gray-300">|</span>
                                    <button type="button" onclick="toggleAll(false)" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Deselect All</button>
                                </div>
                            </div>
                            
                            <form action="{{ route('counselor.guidance.bulk.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="year_level" value="{{ request('year_level') }}">
                                <input type="hidden" name="seminar_id" value="{{ request('seminar_id') }}">

                                <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                                    <table class="min-w-full table-custom">
                                        <thead class="sticky top-0 z-10">
                                            <tr>
                                                <th class="w-10">
                                                    <input type="checkbox" id="selectAllCheckbox" onchange="toggleAll(this.checked)" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 form-check-input">
                                                </th>
                                                <th>Name</th>
                                                <th>ID Number</th>
                                                <th>Year Level</th>
                                                <th>College</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($students as $student)
                                                @php
                                                    $seminarName = \App\Models\Seminar::find(request('seminar_id'))->name;
                                                    $isAttended = \App\Models\SeminarAttendance::where('user_id', $student->id)
                                                        ->where('seminar_name', $seminarName)
                                                        ->where('year_level', request('year_level'))
                                                        ->exists();
                                                @endphp
                                                <tr class="{{ $isAttended ? 'bg-green-50' : '' }}">
                                                    <td>
                                                        @if(!$isAttended)
                                                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 form-check-input">
                                                        @else
                                                            <i class="bi bi-check-circle-fill text-green-600"></i>
                                                        @endif
                                                    </td>
                                                    <td class="font-medium text-gray-900">{{ $student->name }}</td>
                                                    <td class="text-gray-500">{{ $student->student_id ?? 'N/A' }}</td>
                                                    <td class="text-gray-500">{{ $student->year_level ?? 'N/A' }}</td>
                                                    <td class="text-gray-500">{{ $student->college ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($isAttended)
                                                            <span class="text-green-700 font-medium text-sm bg-green-100 px-2 py-1 rounded-full">Attended</span>
                                                        @else
                                                            <span class="text-gray-500 text-sm">Pending</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-8 text-gray-500">
                                                        No students found for this year level.<br>
                                                        <span class="text-xs opacity-75">Please ensure students have their Year Level set in their profile.</span>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                                    <button type="submit" class="btn-primary-custom" {{ $students->isEmpty() ? 'disabled' : '' }}>
                                        Mark Selected as Attended
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Option 2: Import from CSV</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('counselor.guidance.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                                    <div>
                                        <label for="import_year_level" class="block text-sm font-medium text-gray-700 mb-2">Year Level</label>
                                        <select name="year_level" id="import_year_level" class="form-select-custom w-full" required>
                                            <option value="">Select Year</option>
                                            <option value="1">1st Year</option>
                                            <option value="2">2nd Year</option>
                                            <option value="3">3rd Year</option>
                                            <option value="4">4th Year</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="import_seminar_id" class="block text-sm font-medium text-gray-700 mb-2">Seminar</label>
                                        <select name="seminar_id" id="import_seminar_id" class="form-select-custom w-full" required>
                                            <option value="">Select Seminar</option>
                                            @foreach($seminars as $seminar)
                                                <option value="{{ $seminar->id }}">
                                                    {{ $seminar->name }} (Year {{ $seminar->target_year_level }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">CSV File</label>
                                        <input type="file" name="csv_file" id="csv_file" class="form-control-custom w-full" accept=".csv,.txt" required>
                                        <p class="text-xs text-gray-500 mt-1">Format: Header row with 'student_id' or 'id_number' column.</p>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn-primary-custom w-full">Import CSV</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAll(checked) {
            document.getElementById('selectAllCheckbox').checked = checked;
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(cb => cb.checked = checked);
        }

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
