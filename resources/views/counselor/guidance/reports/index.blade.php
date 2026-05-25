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

        

        

        

        

        .custom-sidebar .sidebar-link.active,
        

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

        

        @media (max-width: 767.98px) {

            /* Off-canvas behavior on mobile */
            

            .custom-sidebar.show {
                transform: translateX(0);
            }

            

            

            

            .main-dashboard-content {
                margin-left: 0;
            }

            /* Toggle button */
            
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

        .page-header h2 {
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
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            

            <!-- Sidebar -->
            @include('counselor.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="text-2xl font-bold m-0">Guidance Reports</h2>
                            <p class="opacity-90 m-0 mt-1">Generate attendance reports and analytics</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="bi bi-file-earmark-text" style="font-size: 3rem; opacity: 0.2;"></i>
                        </div>
                    </div>

                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Generate Report</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('counselor.guidance.reports.generate') }}" method="POST" target="_blank">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Report Type -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                                        <select name="report_type" class="form-select-custom w-full" required>
                                            <option value="summary">Attendance Summary (All Students)</option>
                                            <option value="missing">Students Missing Seminars</option>
                                            <option value="completed">Students Completed Seminars</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Select the type of data you want to export.
                                        </p>
                                    </div>

                                    <!-- Format -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                                        <select name="format" class="form-select-custom w-full" required>
                                            <option value="pdf">PDF Document</option>
                                            <option value="excel">Excel / CSV</option>
                                        </select>
                                    </div>

                                    <!-- Filters -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Year Level
                                            (Optional)</label>
                                        <select name="year_level" class="form-select-custom w-full">
                                            <option value="">All Year Levels</option>
                                            <option value="1">1st Year</option>
                                            <option value="2">2nd Year</option>
                                            <option value="3">3rd Year</option>
                                            <option value="4">4th Year</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Seminar
                                            (Optional)</label>
                                        <select name="seminar_id" class="form-select-custom w-full">
                                            <option value="">All Seminars</option>
                                            @foreach($seminars as $seminar)
                                                <option value="{{ $seminar->id }}">{{ $seminar->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-8 flex justify-end">
                                    <button type="submit" class="btn-primary-custom flex items-center gap-2">
                                        <i class="bi bi-download"></i> Generate Report
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            });
            }
        });
    </script>
@endsection