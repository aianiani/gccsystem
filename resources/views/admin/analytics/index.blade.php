@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-h: 129;
            --primary-s: 60%;
            --primary-l: 30%;
            --forest-green: hsl(var(--primary-h), var(--primary-s), var(--primary-l));
            --forest-green-dark: hsl(var(--primary-h), var(--primary-s), 20%);
            --forest-green-soft: hsla(var(--primary-h), var(--primary-s), var(--primary-l), 0.08);
            --maize-yellow: #FFCB05;
            --glass-white: rgba(255, 255, 255, 0.95);
            --premium-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.08);
            --card-radius: 20px;
        }

        .home-zoom {
            zoom: 0.75;
            padding: 2rem;
            background: #f8fafc;
            min-height: 100vh;
            scroll-behavior: smooth;
        }

        /* Sticky Section Nav */
        .analytics-nav {
            position: sticky;
            top: 1rem;
            z-index: 100;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 0.75rem;
            border-radius: 50px;
            display: inline-flex;
            gap: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .nav-pill-link {
            text-decoration: none;
            color: #64748b;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-pill-link:hover,
        .nav-pill-link.active {
            background: var(--forest-green);
            color: white;
        }

        /* Section Styling */
        .analytics-section {
            margin-bottom: 5rem;
            scroll-margin-top: 8rem;
            /* Offset for sticky nav */
        }

        .section-header-wrapper {
            margin-bottom: 2rem;
            border-left: 5px solid var(--forest-green);
            padding-left: 1.5rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--forest-green-dark);
            margin: 0;
            line-height: 1.2;
        }

        .section-subtitle {
            color: #64748b;
            font-size: 1rem;
            margin-top: 0.25rem;
        }

        /* Cards */
        .analytics-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 1.75rem;
            box-shadow: var(--premium-shadow);
            border: 1px solid rgba(0, 0, 0, 0.03);
            height: 100%;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
        }

        .analytics-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px -15px rgba(31, 122, 45, 0.15);
        }

        .kpi-stat-card {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .kpi-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .kpi-content h3 {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }

        .kpi-content p {
            margin: 0;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.25rem;
        }

        .card-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>

    <div class="home-zoom" style="position: relative;">

        <!-- Header -->
        <header class="mb-5 d-flex justify-content-between align-items-end px-3">
            <div>
                <h1 class="display-5 fw-bold" style="color: var(--forest-green-dark);">Analytics Overview</h1>
                <p class="text-muted fw-500 mb-0">Three-pillar analysis of system performance.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.analytics.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}"
                    class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" target="_blank">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Export PDF
                </a>
            </div>
        </header>

        <!-- Filter Selection (Always Visible) -->
        <div class="mb-4 px-3">
            <div class="analytics-card p-4">
                <form action="{{ route('admin.analytics.index') }}" method="GET" class="row g-3">
                    <!-- ... Copied filter inputs from previous version, concise ... -->
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted">College</label>
                        <select name="college" class="form-select">
                            <option value="">All Colleges</option>
                            @foreach($colleges as $col)
                                <option value="{{ $col }}" {{ request('college') == $col ? 'selected' : '' }}>{{ $col }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex flex-column justify-content-end">
                        <a href="{{ route('admin.analytics.index') }}"
                            class="small text-danger fw-bold text-decoration-none text-end mb-2">Clear Filters</a>
                        <button type="submit" class="btn btn-success w-100 fw-bold">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sticky Navigation -->
        <div class="d-flex justify-content-center">
            <nav class="analytics-nav">
                <a href="#counseling" class="nav-pill-link active" onclick="setActive(this)">
                    <i class="bi bi-people-fill"></i> Counseling
                </a>
                <a href="#assessment" class="nav-pill-link" onclick="setActive(this)">
                    <i class="bi bi-clipboard-data-fill"></i> Assessment
                </a>
                <a href="#guidance" class="nav-pill-link" onclick="setActive(this)">
                    <i class="bi bi-compass-fill"></i> Guidance
                </a>
            </nav>
        </div>

        <!-- SECTION 1: COUNSELING & APPOINTMENTS -->
        <section id="counseling" class="analytics-section">
            <div class="section-header-wrapper">
                <h2 class="section-title">Counseling & Appointments</h2>
                <div class="section-subtitle">Operational metrics, counselor workload, and case types.</div>
            </div>

            <!-- KPI Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($totalAppointments) }}</h3>
                            <p>Total Sessions</p>
                        </div>
                    </div>
                </div>
                <!-- Wait Time -->
                <div class="col-md-3">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($avgWaitTime, 1) }} <span class="fs-6 text-muted fw-normal">days</span>
                            </h3>
                            <p>Avg Wait Time</p>
                        </div>
                    </div>
                </div>
                <!-- Efficiency: Cancellation Rate -->
                <div class="col-md-3">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($cancellationRate, 1) }}%</h3>
                            <p>Cancellation Rate</p>
                        </div>
                    </div>
                </div>
                <!-- Pending -->
                <div class="col-md-3">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($pendingAppointments) }}</h3>
                            <p>Pending Request</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1: Status & Demand -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-pie-chart text-success"></i> Status Breakdown</div>
                        </div>
                        <div style="height: 250px;">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-grid-3x3 text-primary"></i> Peak Demand (Day vs
                                Time)</div>
                        </div>
                        <!-- Custom Heatmap Grid -->
                        <div class="heatmap-container" style="height: 250px; overflow-y: auto;">
                            <!-- We will render this via JS or PHP loop here. Let's use a Table for simplicity -->
                            <table class="table table-bordered table-sm text-center small mb-0"
                                style="border-color: rgba(0,0,0,0.05);">
                                <thead class="text-muted">
                                    <tr>
                                        <th></th>
                                        @foreach(range(8, 17) as $hour)
                                            <th>{{ $hour }}:00</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
                                        $dayMap = [2 => 'Mon', 3 => 'Tue', 4 => 'Wed', 5 => 'Thu', 6 => 'Fri'];
                                    @endphp
                                    @foreach($dayMap as $dayNum => $dayName)
                                        <tr>
                                            <td class="fw-bold text-muted">{{ $dayName }}</td>
                                            @foreach(range(8, 17) as $hour)
                                                @php
                                                    $count = $peakDemand->where('day', $dayNum)->where('hour', $hour)->first()->count ?? 0;
                                                    // Simple Intensity opacity
                                                    $max = $peakDemand->max('count') ?: 1;
                                                    $opacity = $count > 0 ? ($count / $max) : 0;
                                                    $bg = $count > 0 ? "rgba(31, 122, 45, $opacity)" : '#f8fafc';
                                                    $text = $opacity > 0.6 ? 'white' : 'black';
                                                @endphp
                                                <td style="background-color: {{ $bg }}; color: {{ $text }};"
                                                    title="{{ $count }} appointments">{{ $count > 0 ? $count : '' }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Trend & Usage -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-graph-up text-primary"></i> Counseling Demand Trend
                            </div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="demandChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-bar-chart-steps text-primary"></i> Counseling Usage
                                (Year & College)</div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="counselingUsageChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 3: Problems -->
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-list-ul text-warning"></i> Top Presenting Problems
                            </div>
                        </div>
                        <div style="height: 250px;">
                            <canvas id="problemChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: ASSESSMENT & TESTING -->
        <section id="assessment" class="analytics-section">
            <div class="section-header-wrapper" style="border-color: #dc3545;">
                <h2 class="section-title" style="color: #b91c1c;">Mental Health & Assessment</h2>
                <div class="section-subtitle">Student wellness data, risk profiling, and demographics.</div>
            </div>

            <!-- KPI Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3 class="text-danger">{{ number_format($criticalRiskCount) }}</h3>
                            <p>Critical Risk Cases</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <div class="kpi-content">
                            <!-- Placeholder for 'Avg Mood Score' if we had scalar, simplified here -->
                            <h3>Live</h3>
                            <p>Wellness Tracking</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-activity text-danger"></i> Campus Mood (DASS-42)
                            </div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="moodChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-shield-exclamation text-warning"></i> Risk
                                Distribution</div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="riskChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-12">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-building-exclamation text-danger"></i> High Risk
                                Areas by College</div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="collegeRiskChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3: GUIDANCE & SEMINARS -->
        <section id="guidance" class="analytics-section">
            <div class="section-header-wrapper" style="border-color: #0dcaf0;">
                <h2 class="section-title" style="color: #055160;">Guidance & Seminars</h2>
                <div class="section-subtitle">Outreach program impact and student engagement.</div>
            </div>

            <!-- KPI Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-easel-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($totalSeminars) }}</h3>
                            <p>Seminars Conducted</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($totalSeminarReach) }}</h3>
                            <p>Total Reach</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($sentimentScore, 1) }}</h3>
                            <p>Avg Rating</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-bar-chart-fill text-info"></i> Attendance by
                                Seminar Topic</div>
                        </div>
                        <div style="height: 350px;">
                            <canvas id="seminarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 4: QUALITATIVE FEEDBACK (APPENDED) -->
        <section id="feedback" class="analytics-section">
            <div class="section-header-wrapper" style="border-color: #6610f2;">
                <h2 class="section-title" style="color: #520dc2;">Service Quality & Feedback</h2>
                <div class="section-subtitle">Student ratings and qualitative comments.</div>
            </div>

            <div class="row g-4">
                <!-- Star Distribution -->
                <div class="col-md-5">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-star-half text-warning"></i> Rating Distribution
                            </div>
                            <div class="h4 fw-bold mb-0 text-warning">{{ number_format($sentimentScore, 1) }} <span
                                    class="fs-6 text-muted fw-normal">/ 5.0</span></div>
                        </div>
                        <div class="d-flex flex-column justify-content-center h-100 pb-3">
                            @foreach(range(5, 1) as $star)
                                @php
                                    $count = $feedbackDistribution[$star] ?? 0;
                                    $total = $feedbackDistribution->sum() ?: 1;
                                    $pct = ($count / $total) * 100;
                                @endphp
                                <div class="d-flex align-items-center mb-3">
                                    <div class="fw-bold me-3" style="width: 20px;">{{ $star }}</div>
                                    <i class="bi bi-star-fill text-warning me-3"></i>
                                    <div class="progress flex-grow-1" style="height: 8px; border-radius: 10px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $pct }}%">
                                        </div>
                                    </div>
                                    <div class="text-muted small ms-3 fw-bold" style="width: 30px; text-align: right;">
                                        {{ $count }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Comments -->
                <div class="col-md-7">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-chat-quote-fill text-info"></i> Recent Student
                                Feedback</div>
                        </div>
                        <div style="max-height: 350px; overflow-y: auto; padding-right: 0.5rem;">
                            @forelse($recentFeedback as $fb)
                                <div class="p-3 mb-3"
                                    style="background: #f8fafc; border-radius: 12px; border-left: 4px solid var(--forest-green);">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }} text-warning"
                                                    style="font-size: 0.7rem;"></i>
                                            @endfor
                                        </div>
                                        <div class="small text-muted">{{ $fb->created_at->diffForHumans() }}</div>
                                    </div>
                                    <p class="mb-0 text-secondary" style="font-size: 0.95rem; font-style: italic;">
                                        "{{ $fb->comments }}"</p>
                                    <div class="mt-2 text-end small fw-bold text-forest-green">
                                        - {{ $fb->appointment->student->college_acronym ?? 'Student' }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-chat-square-dots display-4 mb-3 d-block opacity-25"></i>
                                    No qualitative feedback recorded yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function setActive(element) {
            document.querySelectorAll('.nav-pill-link').forEach(el => el.classList.remove('active'));
            element.classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#64748b';

            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            };

            const colors = {
                primary: '#1f7a2d',
                danger: '#dc3545',
                warning: '#FFCB05',
                info: '#0dcaf0',
                gray: '#cbd5e1'
            };

            // 1. Status Chart (Donut)
            new Chart(document.getElementById('statusChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: @json($appointmentStatus->keys()->map(fn($k) => ucfirst($k))),
                    datasets: [{
                        data: @json($appointmentStatus->values()),
                        backgroundColor: [colors.primary, colors.danger, colors.warning, colors.info],
                        borderWidth: 0
                    }]
                },
                options: { ...commonOptions, cutout: '70%', plugins: { legend: { display: true, position: 'right' } } }
            });

            // 2. Demand Trend (Line)
            new Chart(document.getElementById('demandChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($counselingTrend->keys()),
                    datasets: [{
                        label: 'Sessions',
                        data: @json($counselingTrend->values()),
                        borderColor: colors.primary,
                        backgroundColor: 'rgba(31, 122, 45, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { ...commonOptions, scales: { y: { beginAtZero: true } } }
            });

            // 3. Counseling Usage (Stacked Bar)
            const usageCtx = document.getElementById('counselingUsageChart').getContext('2d');
            const usageData = @json($counselingUsage);
            const usageLabels = Object.keys(usageData); // Colleges
            const yearLevels = ['1', '2', '3', '4'];
            const usageDatasets = yearLevels.map((year, i) => ({
                label: 'Year ' + year,
                data: usageLabels.map(col => (usageData[col] && usageData[col][year]) ? usageData[col][year] : 0),
                backgroundColor: ['#1f7a2d', '#FFCB05', '#17a2b8', '#ff7043'][i] || '#adb5bd',
                borderRadius: 4
            }));

            new Chart(usageCtx, {
                type: 'bar',
                data: {
                    labels: usageLabels,
                    datasets: usageDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { stacked: true, grid: { display: false } },
                        y: { stacked: true, beginAtZero: true }
                    }
                }
            });

            // 3. Problems (Bar)
            new Chart(document.getElementById('problemChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($problemDistribution->keys()->take(5)),
                    datasets: [{
                        data: @json($problemDistribution->values()->take(5)),
                        backgroundColor: colors.warning,
                        borderRadius: 5
                    }]
                },
                options: { ...commonOptions, indexAxis: 'y' }
            });

            // 4. Mood (Line)
            new Chart(document.getElementById('moodChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($moodTrend->keys()),
                    datasets: [{
                        label: 'Severity',
                        data: @json($moodTrend->values()),
                        borderColor: colors.danger,
                        backgroundColor: 'rgba(220, 53, 69, 0.05)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { ...commonOptions, scales: { y: { beginAtZero: true } } }
            });

            // 5. Risk Dist (Pie)
            new Chart(document.getElementById('riskChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: @json($riskDistribution->keys()->map(fn($k) => ucfirst($k))),
                    datasets: [{
                        data: @json($riskDistribution->values()),
                        backgroundColor: [colors.primary, colors.warning, colors.info, '#fd7e14', colors.danger],
                        borderWidth: 0
                    }]
                },
                options: { ...commonOptions, plugins: { legend: { display: true, position: 'bottom' } } }
            });

            // 6. College Risk (Bar)
            new Chart(document.getElementById('collegeRiskChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($collegeRiskMap->keys()),
                    datasets: [{
                        data: @json($collegeRiskMap->values()),
                        backgroundColor: colors.danger,
                        borderRadius: 4
                    }]
                },
                options: { ...commonOptions }
            });

            // 7. Seminar (Bar)
            new Chart(document.getElementById('seminarChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($seminarAttendance->keys()),
                    datasets: [{
                        label: 'Attendees',
                        data: @json($seminarAttendance->values()),
                        backgroundColor: colors.info,
                        borderRadius: 8
                    }]
                },
                options: { ...commonOptions, scales: { y: { beginAtZero: true } } }
            });


        });


    </script>
@endsection