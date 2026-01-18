@extends('layouts.app')

@section('content')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .filter-card .form-select,
        .filter-card .form-control {
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

        .chart-container {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            height: 350px;
            position: relative;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .report-section-card,
            .chart-container {
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
                <div class="welcome-text">Administrative Reports</div>
                <div style="font-size: 0.9rem; margin-top: 0.5rem;">
                    Comprehensive reports for Testing, Guidance, and Counseling
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button onclick="window.print()" class="btn btn-light no-print">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
                <a href="{{ route('admin.reports.export', ['format' => 'pdf', 'frequency' => $frequency, 'month' => $month, 'year' => $year, 'week' => $week]) }}"
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
                <div class="col-md-3">
                    <label class="form-label">Report Frequency</label>
                    <select name="frequency" id="frequencyStart" class="form-select" onchange="toggleInputs()">
                        <option value="weekly" {{ $frequency == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ $frequency == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="annual" {{ $frequency == 'annual' ? 'selected' : '' }}>Annual</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Year</label>
                    <select name="year" class="form-select" required>
                        @foreach(range(date('Y') - 5, date('Y') + 2) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 input-month" style="display: {{ $frequency == 'monthly' ? 'block' : 'none' }};">
                    <label class="form-label">Month</label>
                    <select name="month" class="form-select">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 input-week" style="display: {{ $frequency == 'weekly' ? 'block' : 'none' }};">
                    <label class="form-label">Week Number</label>
                    <input type="number" name="week" class="form-control" min="1" max="52" value="{{ $week }}">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>

        <!-- Chart Section -->
        <div class="row no-print">
            <div class="col-12">
                <div class="chart-container">
                    <canvas id="reportChart"></canvas>
                </div>
            </div>
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

        <!-- Dynamic Banner Display -->
        <div class="month-banner">
            <h3>
                <i class="bi bi-calendar-event me-2"></i>
                {{ $bannerText }}
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
                             @php $rowCount = count($test['rows']); @endphp
                             @foreach($test['rows'] as $index => $row)
                                <tr>
                                    @if($index === 0)
                                        <td rowspan="{{ $rowCount }}" style="vertical-align: middle; background-color: #f8f9fa;">
                                            <strong>{{ $test['category'] }}</strong>
                                        </td>
                                    @endif

                                    <!-- Administration -->
                                    <td class="text-start" style="font-size: 0.75rem;">{{ $row['college'] }}</td>
                                    <td class="text-center">{{ $row['administration']['male'] }}</td>
                                    <td class="text-center">{{ $row['administration']['female'] }}</td>
                                    <td class="text-center"><strong>{{ $row['administration']['total'] }}</strong></td>
                                    <td class="text-center"><strong>{{ $row['administration']['total_enrolled'] }}</strong></td>

                                    <!-- Checking -->
                                    <td class="text-start" style="font-size: 0.75rem;">{{ $row['college'] }}</td>
                                    <td class="text-center">{{ $row['checking_scoring']['male'] }}</td>
                                    <td class="text-center">{{ $row['checking_scoring']['female'] }}</td>
                                    <td class="text-center"><strong>{{ $row['checking_scoring']['total'] }}</strong></td>

                                    <!-- Interpretation -->
                                    <td class="text-start" style="font-size: 0.75rem;">{{ $row['college'] }}</td>
                                    <td class="text-center">{{ $row['interpretation']['male'] }}</td>
                                    <td class="text-center">{{ $row['interpretation']['female'] }}</td>
                                    <td class="text-center"><strong>{{ $row['interpretation']['total'] }}</strong></td>

                                    <!-- Report -->
                                    <td class="text-start" style="font-size: 0.75rem;">{{ $row['college'] }}</td>
                                    <td class="text-center">{{ $row['report_result']['male'] }}</td>
                                    <td class="text-center">{{ $row['report_result']['female'] }}</td>
                                    <td class="text-center"><strong>{{ $row['report_result']['total'] }}</strong></td>
                                </tr>
                                
                                @php
                                    $totalAdmin['male'] += $row['administration']['male'];
                                    $totalAdmin['female'] += $row['administration']['female'];
                                    $totalAdmin['total'] += $row['administration']['total'];
                                    $totalAdmin['enrolled'] += $row['administration']['total_enrolled'];
                                    
                                    $totalChecking['male'] += $row['checking_scoring']['male'];
                                    $totalChecking['female'] += $row['checking_scoring']['female'];
                                    $totalChecking['total'] += $row['checking_scoring']['total'];
                                    
                                    $totalInterpretation['male'] += $row['interpretation']['male'];
                                    $totalInterpretation['female'] += $row['interpretation']['female'];
                                    $totalInterpretation['total'] += $row['interpretation']['total'];
                                    
                                    $totalReport['male'] += $row['report_result']['male'];
                                    $totalReport['female'] += $row['report_result']['female'];
                                    $totalReport['total'] += $row['report_result']['total'];
                                @endphp
                             @endforeach
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
                            <th>EVALUATION</th>
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
                            @php $rowCount = count($guidance['rows']); @endphp
                            @foreach($guidance['rows'] as $index => $row)
                                <tr>
                                    @if($index === 0)
                                        <td rowspan="{{ $rowCount }}" style="vertical-align: middle; background-color: #f8f9fa;">
                                            {{ $guidance['date'] }}
                                        </td>
                                        <td rowspan="{{ $rowCount }}" style="vertical-align: middle; background-color: #f8f9fa;">
                                            <strong>{{ $guidance['topic'] }}</strong>
                                        </td>
                                    @endif
                                    
                                    <td class="text-start" style="font-size: 0.75rem;">{{ $row['college'] }}</td>
                                    <td class="text-center">{{ $row['male'] }}</td>
                                    <td class="text-center">{{ $row['female'] }}</td>
                                    <td class="text-center"><strong>{{ $row['total_attended'] }}</strong></td>
                                    <td class="text-center"><strong>{{ $row['total_enrolled'] }}</strong></td>
                                    <td></td> <!-- Evaluation Column Empty -->
                                </tr>
                                @php
                                    $totalMale += $row['male'];
                                    $totalFemale += $row['female'];
                                    $totalAttended += $row['total_attended'];
                                    $totalEnrolled += $row['total_enrolled'];
                                @endphp
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
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
                                <td></td>
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
                            @php $rowCount = count($counseling['rows']); @endphp
                            @foreach($counseling['rows'] as $index => $row)
                                <tr>
                                    @if($index === 0)
                                        <td rowspan="{{ $rowCount }}" style="vertical-align: middle; background-color: #f8f9fa;">
                                            <strong>{{ $counseling['nature'] }}</strong>
                                        </td>
                                    @endif
                                    
                                    <td class="text-start" style="font-size: 0.75rem;">{{ $row['college'] }}</td>
                                    <td class="text-center">{{ $row['year_level'] }}</td>
                                    <td class="text-start" style="font-size: 0.75rem;">{{ $row['presenting_problem'] }}</td>
                                    <td class="text-center">{{ $row['male'] }}</td>
                                    <td class="text-center">{{ $row['female'] }}</td>
                                    <td class="text-center"><strong>{{ $row['total'] }}</strong></td>
                                </tr>
                                @php
                                    $totalMale += $row['male'];
                                    $totalFemale += $row['female'];
                                    $totalCount += $row['total'];
                                @endphp
                            @endforeach
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

    <script>
        function toggleInputs() {
            const freq = document.getElementById('frequencyStart').value;
            const monthDiv = document.querySelector('.input-month');
            const weekDiv = document.querySelector('.input-week');

            if (freq === 'weekly') {
                monthDiv.style.display = 'none';
                weekDiv.style.display = 'block';
            } else if (freq === 'monthly') {
                monthDiv.style.display = 'block';
                weekDiv.style.display = 'none';
            } else { // annual
                monthDiv.style.display = 'none';
                weekDiv.style.display = 'none';
            }
        }

        // Initialize Chart
        const ctx = document.getElementById('reportChart').getContext('2d');
        const reportChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tested', 'Guided', 'Counseled (In Session)'],
                datasets: [{
                    label: 'Total Count',
                    data: [{{ $totalTested ?? 0 }}, {{ $totalGuided ?? 0 }}, {{ $totalCounseled ?? 0 }}],
                    backgroundColor: [
                        'rgba(31, 122, 45, 0.7)', // Forest Green
                        'rgba(255, 203, 5, 0.7)', // Maize Yellow
                        'rgba(3, 105, 161, 0.7)'  // Blue
                    ],
                    borderColor: [
                        'rgba(31, 122, 45, 1)',
                        'rgba(255, 203, 5, 1)',
                        'rgba(3, 105, 161, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Overview Summary'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
@endsection