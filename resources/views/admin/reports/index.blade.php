@extends('layouts.app')

@section('content')
    <style>
        /* Dashboard theme variables */
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

            /* Map dashboard-specific names */
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

        /* Match admin zoom standard */
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
        .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            flex-wrap: wrap;
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

        .page-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .page-header-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            color: #fff;
        }

        .page-header-card p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .filter-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-card .form-label {
            font-weight: 600;
            color: var(--forest-green);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .filter-card .form-select {
            border-radius: 8px;
            border: 1px solid var(--gray-100);
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
        }

        .month-banner {
            background: var(--forest-green-lighter);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .month-banner h3 {
            color: var(--forest-green);
            font-weight: 700;
            margin: 0;
            font-size: 1.3rem;
        }

        .report-section-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .report-section-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            font-weight: 700;
            font-size: 1.1rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .report-table {
            width: 100%;
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .report-table thead {
            background: var(--forest-green);
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .report-table thead th {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .report-table thead th {
            padding: 0.85rem 0.75rem;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
            border: 1px solid var(--forest-green-light);
            font-size: 0.85rem;
        }

        .report-table tbody td {
            padding: 0.75rem 0.85rem;
            border: 1px solid #dee2e6;
            vertical-align: middle;
            font-size: 0.85rem;
        }

        .report-table tbody tr:hover {
            background: var(--gray-50);
        }

        .total-row {
            background: var(--forest-green-lighter) !important;
            font-weight: 700;
        }

        .total-row td {
            color: var(--forest-green);
        }

        .college-list {
            font-size: 0.8rem;
            color: var(--gray-600);
            font-style: italic;
            margin-top: 0.25rem;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .report-section-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>

    <div class="home-zoom">
        <!-- Welcome Card Header -->
        <div class="welcome-card">
            <div>
                <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                <div class="welcome-text">Monthly Reports</div>
                <div style="font-size: 0.9rem; margin-top: 0.5rem;">Comprehensive report for Testing, Guidance, and
                    Counseling
                    activities</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button onclick="window.print()" class="btn btn-light no-print">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
                <a href="{{ route('admin.reports.export', ['format' => 'pdf', 'month' => $month, 'year' => $year]) }}"
                    class="btn btn-light no-print">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-light no-print">
                    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-card no-print">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Month</label>
                    <select name="month" class="form-select" required>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Year</label>
                    <select name="year" class="form-select" required>
                        @foreach(range(date('Y') - 2, date('Y') + 1) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>

        <!-- Summary Metrics Cards -->
        <div class="row mb-4 no-print">
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-0"
                    style="background: linear-gradient(145deg, #e8f5e8 0%, #ffffff 100%);">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3"
                            style="background-color: var(--forest-green-lighter); color: var(--forest-green);">
                            <i class="bi bi-clipboard-check fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.8rem;">Total Tested</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalTested ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-0"
                    style="background: linear-gradient(145deg, #fff7e6 0%, #ffffff 100%);">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background-color: #fff7e6; color: #f4d03f;">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.8rem;">Total Guided</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalGuided ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-0"
                    style="background: linear-gradient(145deg, #e0f2fe 0%, #ffffff 100%);">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background-color: #e0f2fe; color: #0369a1;">
                            <i class="bi bi-heart-pulse fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.8rem;">Total Counseled
                            </h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalCounseled ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Month Display -->
        <div class="month-banner">
            <h3>
                <i class="bi bi-calendar-event me-2"></i>
                {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
            </h3>
        </div>

        <!-- A. TESTING SECTION -->
        <div class="report-section-card">
            <div class="report-section-header">
                A. TESTING
            </div>
            <div class="table-responsive">
                <table class="table table-bordered report-table mb-0">
                    <thead>
                        <tr>
                            <th rowspan="2">CLIENT / STUDENTS TEST</th>
                            <th colspan="5">ADMINISTRATION</th>
                            <th colspan="4">CHECKING / SCORING</th>
                            <th colspan="4">INTERPRETATION</th>
                            <th colspan="4">PSYCHOLOGICAL REPORT/RESULT</th>
                        </tr>
                        <tr>
                            <th>College</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total Attendees</th>
                            <th>Total Enrolled</th>
                            <th>College</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total Attendees</th>
                            <th>College</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total Attendees</th>
                            <th>College</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total Attendees</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAdmin = ['male' => 0, 'female' => 0, 'total' => 0, 'enrolled' => 0];
                            $totalChecking = ['male' => 0, 'female' => 0, 'total' => 0];
                            $totalInterpretation = ['male' => 0, 'female' => 0, 'total' => 0];
                            $totalReport = ['male' => 0, 'female' => 0, 'total' => 0];
                        @endphp

                        @forelse($testingData as $test)
                            <tr>
                                <td>
                                    <strong>{{ $test['category'] }}</strong>
                                </td>
                                <!-- Administration -->
                                <td class="text-start">
                                    @if(count($test['administration']['colleges']) > 0)
                                        <div style="font-size: 0.7rem; line-height: 1.1; max-width: 150px; min-width: 100px;">
                                            @foreach($test['administration']['colleges'] as $college)
                                                <div class="mb-1 text-muted fst-italic">{{ $college }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $test['administration']['male'] }}</td>
                                <td class="text-center">{{ $test['administration']['female'] }}</td>
                                <td class="text-center"><strong>{{ $test['administration']['total'] }}</strong></td>
                                <td class="text-center"><strong>{{ $test['administration']['total_enrolled'] }}</strong></td>

                                <!-- Checking -->
                                <td>
                                    @if(count($test['checking_scoring']['colleges']) > 0)
                                        <div style="font-size: 0.7rem; line-height: 1.1; max-width: 150px; min-width: 100px;">
                                            @foreach($test['checking_scoring']['colleges'] as $college)
                                                <div class="mb-1 text-muted fst-italic">{{ $college }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $test['checking_scoring']['male'] }}</td>
                                <td class="text-center">{{ $test['checking_scoring']['female'] }}</td>
                                <td class="text-center"><strong>{{ $test['checking_scoring']['total'] }}</strong></td>

                                <!-- Interpretation -->
                                <td>
                                    @if(count($test['interpretation']['colleges']) > 0)
                                        <div style="font-size: 0.7rem; line-height: 1.1; max-width: 150px; min-width: 100px;">
                                            @foreach($test['interpretation']['colleges'] as $college)
                                                <div class="mb-1 text-muted fst-italic">{{ $college }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $test['interpretation']['male'] }}</td>
                                <td class="text-center">{{ $test['interpretation']['female'] }}</td>
                                <td class="text-center"><strong>{{ $test['interpretation']['total'] }}</strong></td>

                                <!-- Report -->
                                <td>
                                    @if(count($test['report_result']['colleges']) > 0)
                                        <div style="font-size: 0.7rem; line-height: 1.1; max-width: 150px; min-width: 100px;">
                                            @foreach($test['report_result']['colleges'] as $college)
                                                <div class="mb-1 text-muted fst-italic">{{ $college }}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">{{ $test['report_result']['male'] }}</td>
                                <td class="text-center">{{ $test['report_result']['female'] }}</td>
                                <td class="text-center"><strong>{{ $test['report_result']['total'] }}</strong></td>
                            </tr>
                            @php
                                $totalAdmin['male'] += $test['administration']['male'];
                                $totalAdmin['female'] += $test['administration']['female'];
                                $totalAdmin['total'] += $test['administration']['total'];
                                $totalAdmin['enrolled'] += $test['administration']['total_enrolled'];
                                $totalChecking['male'] += $test['checking_scoring']['male'];
                                $totalChecking['female'] += $test['checking_scoring']['female'];
                                $totalChecking['total'] += $test['checking_scoring']['total'];
                                $totalInterpretation['male'] += $test['interpretation']['male'];
                                $totalInterpretation['female'] += $test['interpretation']['female'];
                                $totalInterpretation['total'] += $test['interpretation']['total'];
                                $totalReport['male'] += $test['report_result']['male'];
                                $totalReport['female'] += $test['report_result']['female'];
                                $totalReport['total'] += $test['report_result']['total'];
                            @endphp
                        @empty
                            <tr>
                                <td colspan="18" class="text-center text-muted py-4">
                                    No testing data available for this period
                                </td>
                            </tr>
                        @endforelse

                        @if(count($testingData) > 0)
                            <tr class="total-row">
                                <td><strong>GRAND TOTAL</strong></td>
                                <td></td> <!-- College -->
                                <td class="text-center">{{ $totalAdmin['male'] }}</td>
                                <td class="text-center">{{ $totalAdmin['female'] }}</td>
                                <td class="text-center"><strong>{{ $totalAdmin['total'] }}</strong></td>
                                <td class="text-center"><strong>{{ $totalAdmin['enrolled'] }}</strong></td>
                                <td></td> <!-- College -->
                                <td class="text-center">{{ $totalChecking['male'] }}</td>
                                <td class="text-center">{{ $totalChecking['female'] }}</td>
                                <td class="text-center"><strong>{{ $totalChecking['total'] }}</strong></td>
                                <td></td> <!-- College -->
                                <td class="text-center">{{ $totalInterpretation['male'] }}</td>
                                <td class="text-center">{{ $totalInterpretation['female'] }}</td>
                                <td class="text-center"><strong>{{ $totalInterpretation['total'] }}</strong></td>
                                <td></td> <!-- College -->
                                <td class="text-center">{{ $totalReport['male'] }}</td>
                                <td class="text-center">{{ $totalReport['female'] }}</td>
                                <td class="text-center"><strong>{{ $totalReport['total'] }}</strong></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- B. GUIDANCE SECTION -->
        <div class="report-section-card">
            <div class="report-section-header">
                B. GUIDANCE
            </div>
            <div class="table-responsive">
                <table class="table table-bordered report-table mb-0">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>TOPIC</th>
                            <th>COLLEGE</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total Attended</th>
                            <th>Total Enrolled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalMale = 0;
                            $totalFemale = 0;
                            $totalAttended = 0;
                            $totalEnrolled = 0;
                        @endphp

                        @forelse($guidanceData as $guidance)
                            <tr>
                                <td>{{ $guidance['date'] }}</td>
                                <td><strong>{{ $guidance['topic'] }}</strong></td>
                                <td>
                                    @if(count($guidance['colleges']) > 0)
                                        {{ $guidance['colleges']->implode(', ') }}
                                    @else
                                        <span class="text-muted">All Colleges</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $guidance['male'] }}</td>
                                <td class="text-center">{{ $guidance['female'] }}</td>
                                <td class="text-center"><strong>{{ $guidance['total_attended'] }}</strong></td>
                                <td class="text-center"><strong>{{ $guidance['total_enrolled'] }}</strong></td>
                            </tr>
                            @php
                                $totalMale += $guidance['male'];
                                $totalFemale += $guidance['female'];
                                $totalAttended += $guidance['total_attended'];
                                $totalEnrolled += $guidance['total_enrolled'];
                            @endphp
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No guidance/seminar data available for this period
                                </td>
                            </tr>
                        @endforelse

                        @if(count($guidanceData) > 0)
                            <tr class="total-row">
                                <td colspan="3"><strong>GRAND TOTAL</strong></td>
                                <td class="text-center">{{ $totalMale }}</td>
                                <td class="text-center">{{ $totalFemale }}</td>
                                <td class="text-center"><strong>{{ $totalAttended }}</strong></td>
                                <td class="text-center"><strong>{{ $totalEnrolled }}</strong></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- C. COUNSELING SECTION -->
        <div class="report-section-card">
            <div class="report-section-header">
                C. COUNSELING
            </div>
            <div class="table-responsive">
                <table class="table table-bordered report-table mb-0">
                    <thead>
                        <tr>
                            <th>NATURE</th>
                            <th>COLLEGE</th>
                            <th>YEAR LEVEL</th>
                            <th>PRESENTING PROBLEM</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total Attendees</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalMale = 0;
                            $totalFemale = 0;
                            $totalCount = 0;
                        @endphp

                        @forelse($counselingData as $counseling)
                            <tr>
                                <td><strong>{{ $counseling['nature'] }}</strong></td>
                                <td>
                                    @if(count($counseling['colleges']) > 0)
                                        {{ $counseling['colleges']->implode(', ') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(count($counseling['year_levels']) > 0)
                                        {{ $counseling['year_levels']->implode(', ') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if(count($counseling['presenting_problems']) > 0)
                                        {{ $counseling['presenting_problems']->implode(', ') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $counseling['male'] }}</td>
                                <td class="text-center">{{ $counseling['female'] }}</td>
                                <td class="text-center"><strong>{{ $counseling['total'] }}</strong></td>
                            </tr>
                            @php
                                $totalMale += $counseling['male'];
                                $totalFemale += $counseling['female'];
                                $totalCount += $counseling['total'];
                            @endphp
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No counseling data available for this period
                                </td>
                            </tr>
                        @endforelse

                        @if(count($counselingData) > 0)
                            <tr class="total-row">
                                <td colspan="4"><strong>GRAND TOTAL</strong></td>
                                <td class="text-center">{{ $totalMale }}</td>
                                <td class="text-center">{{ $totalFemale }}</td>
                                <td class="text-center"><strong>{{ $totalCount }}</strong></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection