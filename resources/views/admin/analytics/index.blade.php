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
        <header class="mb-3 d-flex justify-content-between align-items-center px-3">
            <div>
                <h1 class="display-6 fw-bold" style="color: var(--forest-green-dark); margin-bottom: 0.2rem;">Analytics
                    Overview</h1>
                <p class="text-muted fw-500 small mb-0">Three-pillar analysis of system performance.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.analytics.export', request()->all()) }}"
                    class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center"
                    target="_blank">
                    <i class="bi bi-file-earmark-pdf-fill me-2"></i>Export PDF
                </a>
            </div>
        </header>

        <!-- Filter Selection (Always Visible) -->
        <div class="mb-4 px-3">
            <div class="analytics-card p-3">
                <form action="{{ route('admin.analytics.index') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-2">
                        <label class="small fw-bold text-muted mb-1">Frequency</label>
                        <select name="frequency" class="form-select form-select-sm">
                            <option value="daily" {{ request('frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ request('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ request('frequency', 'monthly') == 'monthly' ? 'selected' : '' }}>
                                Monthly</option>
                            <option value="annual" {{ request('frequency') == 'annual' ? 'selected' : '' }}>Annual</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold text-muted mb-1">Start Date</label>
                        <input type="date" name="start_date" class="form-control form-control-sm"
                            value="{{ $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold text-muted mb-1">End Date</label>
                        <input type="date" name="end_date" class="form-control form-control-sm"
                            value="{{ $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold text-muted mb-1">College</label>
                        <select name="college" class="form-select form-select-sm">
                            <option value="">All Colleges</option>
                            @foreach($colleges as $col)
                                <option value="{{ $col }}" {{ request('college') == $col ? 'selected' : '' }}>{{ $col }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold text-muted mb-1">Program</label>
                        <select name="program" class="form-select form-select-sm">
                            <option value="">All Programs</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog }}" {{ request('program') == $prog ? 'selected' : '' }}>
                                    {{ Str::limit($prog, 15) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">Apply</button>
                        <a href="{{ route('admin.analytics.index') }}" class="btn btn-light btn-sm w-auto"
                            title="Clear Filters">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
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
                        <div class="kpi-icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($totalAppointments) }}</h3>
                            <p>Total Sessions</p>
                        </div>
                    </div>
                </div>
                <!-- Satisfaction -->
                <div class="col-md-3">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($sentimentScore, 1) }}<span class="fs-6 text-muted fw-normal">/5.0</span>
                            </h3>
                            <p>Avg. Satisfaction</p>
                        </div>
                    </div>
                </div>
                <!-- Unique Reach -->
                <div class="col-md-3">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($uniqueStudentsReached) }}</h3>
                            <p>Unique Students</p>
                        </div>
                    </div>
                </div>
                <!-- Pending -->
                <div class="col-md-3">
                    <div class="analytics-card kpi-stat-card">
                        <div class="kpi-icon-box bg-warning bg-opacity-10 text-warning">
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

            <!-- Row 2: Trend & Sex by College -->
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
                <!-- NEW: Sex by College -->
                <div class="col-md-6">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-buildings text-primary"></i> Counseling by College
                                (Sex)</div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="counselingCollegeSexChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 3: Sex by Year & Problems -->
            <div class="row g-4">
                <!-- NEW: Sex by Year -->
                <div class="col-md-6">
                    <div class="analytics-card">
                        <div class="card-header-row">
                            <div class="card-title-text"><i class="bi bi-bar-chart-steps text-primary"></i> Counseling by
                                Year Level (Sex)</div>
                        </div>
                        <div style="height: 250px;">
                            <canvas id="counselingYearSexChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
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
                        <div class="kpi-icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-clipboard-data-fill"></i>
                        </div>
                        <div class="kpi-content">
                            <h3>{{ number_format($totalAssessments) }}</h3>
                            <p>Total Assessments</p>
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
                        <div class="kpi-icon-box bg-primary bg-opacity-10 text-primary">
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
                        <div class="kpi-icon-box bg-success bg-opacity-10 text-success">
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
                            <h3>{{ number_format($avgSeminarRating, 1) }}<span class="fs-6 text-muted fw-normal">/5.0</span>
                            </h3>
                            <p>Seminar Satisfaction</p>
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
                                        {{ $fb->appointment->student->name }} <span class="text-muted fw-normal">({{ $fb->appointment->student->college_acronym }})</span>
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
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            };

            const colors = {
                primary: '#1f7a2d', // Forest Green (Completed)
                secondary: '#6c757d',
                success: '#28a745', // Green (Accepted/Approved)
                danger: '#dc3545',  // Red (Cancelled/Declined)
                warning: '#FFCB05', // Yellow (Pending)
                info: '#0dcaf0',    // Cyan (Rescheduled)
                gray: '#cbd5e1'
            };

            // 1. Status Chart (Donut) - Correctly Mapped Colors
            const statusKeys = @json($appointmentStatus->keys());
            const statusValues = @json($appointmentStatus->values());
            const statusColorMap = {
                'pending': colors.warning,
                'accepted': colors.success,
                'completed': colors.primary,
                'cancelled': colors.danger,
                'declined': colors.danger,
                'rescheduled_pending': colors.info
            };
            const statusBg = statusKeys.map(k => statusColorMap[k] || colors.gray);

            new Chart(document.getElementById('statusChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: statusKeys.map(k => k.charAt(0).toUpperCase() + k.slice(1).replace('_', ' ')),
                    datasets: [{
                        data: statusValues,
                        backgroundColor: statusBg,
                        borderWidth: 0
                    }]
                },
                options: {                 ...commonOptions,
                            cutout: '70%',
                            plugins: {
                                legend: { display: true, position: 'right' },
                                tooltip: { callbacks: { label: (c) => ` ${c.label}: ${c.raw}` } }
                            },
                            scales: { x: { display: false }, y: { display: false } }
                        }
                    });

                    // 2. Demand Trend (Sessions over Time) - Simplified Bar
                    new Chart(document.getElementById('demandChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: @json($counselingTrend->keys()),
                            datasets: [{
                                label: 'Total Sessions',
                                data: @json($counselingTrend->values()),
                                backgroundColor: colors.primary,
                                borderRadius: 4,
                                maxBarThickness: 50
                            }]
                        },
                        options: { 
                            ...commonOptions, 
                            scales: { 
                                y: { beginAtZero: true, ticks: { precision: 0 }, title: { display: true, text: 'No. of Sessions' } },
                                x: { grid: { display: false } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: { callbacks: { label: (c) => ` Sessions: ${c.raw}` } }
                            }
                        }
                    });

                    // 3. Counseling by College (Sex) - Stacked
                    const collegeSexCtx = document.getElementById('counselingCollegeSexChart').getContext('2d');
                    const cSexData = @json($counselingSexByCollege);
                    const cSexLabels = Object.keys(cSexData);

                    new Chart(collegeSexCtx, {
                        type: 'bar',
                        data: {
                            labels: cSexLabels,
                            datasets: [
                                {
                                    label: 'Male',
                                    data: cSexLabels.map(col => cSexData[col]['Male'] || 0),
                                    backgroundColor: '#0dcaf0',
                                    borderRadius: 4
                                },
                                {
                                    label: 'Female',
                                    data: cSexLabels.map(col => cSexData[col]['Female'] || 0),
                                    backgroundColor: '#d63384',
                                    borderRadius: 4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: { stacked: true, grid: { display: false } },
                                y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } }
                            }
                        }
                    });

                    // 4. Counseling by Year (Sex) - Stacked
                    const yearSexCtx = document.getElementById('counselingYearSexChart').getContext('2d');
                    const ySexData = @json($counselingSexByYear);
                    const ySexLabels = ['1', '2', '3', '4']; // Ensure sorted order

                    new Chart(yearSexCtx, {
                        type: 'bar',
                        data: {
                            labels: ySexLabels.map(y => 'Year ' + y),
                            datasets: [
                                {
                                    label: 'Male',
                                    data: ySexLabels.map(y => (ySexData[y] && ySexData[y]['Male']) ? ySexData[y]['Male'] : 0),
                                    backgroundColor: '#0dcaf0',
                                    borderRadius: 4
                                },
                                {
                                    label: 'Female',
                                    data: ySexLabels.map(y => (ySexData[y] && ySexData[y]['Female']) ? ySexData[y]['Female'] : 0),
                                    backgroundColor: '#d63384',
                                    borderRadius: 4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: { stacked: true, grid: { display: false } },
                                y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } }
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
                        options: {
                            ...commonOptions,
                            indexAxis: 'y',
                            scales: {
                                x: { beginAtZero: true, ticks: { precision: 0 } },
                                y: { grid: { display: false } }
                            }
                        }
                    });

                    // 4. Mood (Bar)
                    new Chart(document.getElementById('moodChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: @json($moodTrend->keys()),
                            datasets: [{
                                label: 'Avg Severity Score',
                                data: @json($moodTrend->values()),
                                backgroundColor: colors.danger,
                                borderRadius: 4,
                                maxBarThickness: 50
                            }]
                        },
                        options: {
                            ...commonOptions,
                            scales: { y: { beginAtZero: true, ticks: { precision: 0 }, title: {display: true, text: 'Avg Severity'} } }
                        }
                    });

                    // 5. Risk Dist (Pie) - Correct Colors
                    const riskLabels = @json($riskDistribution->keys());
                    const riskData   = @json($riskDistribution->values());
                    const riskColorMap = {
                        'Normal': colors.success,
                        'Mild': colors.info,
                        'Moderate': colors.warning,
                        'High': '#fd7e14',           // Orange
                        'Severe': colors.danger,     // Red
                        'Extremely Severe': '#8B0000' // Dark Red
                    };

                    new Chart(document.getElementById('riskChart').getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: riskLabels,
                            datasets: [{
                                data: riskData,
                                backgroundColor: riskLabels.map(l => riskColorMap[l] || '#6c757d'),
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

                    // 7. Seminar (Bar - Horizontal)
                    new Chart(document.getElementById('seminarChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: @json($seminarAttendance->keys()),
                            datasets: [{
                                label: 'Attendees',
                                data: @json($seminarAttendance->values()),
                                backgroundColor: colors.info,
                                borderRadius: 4,
                                maxBarThickness: 40
                            }]
                        },
                        options: { 
                            ...commonOptions, 
                            indexAxis: 'y',
                            scales: { x: { beginAtZero: true, ticks: { precision: 0 } }, y: { grid: { display: false } } } 
                        }
                    });



                    // Auto-update dates on frequency change
                    const fSelect = document.querySelector('select[name="frequency"]');
                    const sInput = document.querySelector('input[name="start_date"]');
                    const eInput = document.querySelector('input[name="end_date"]');

                    if (fSelect && sInput && eInput) {
                        fSelect.addEventListener('change', function () {
                            const freq = this.value;
                            const end = new Date();
                            let start = new Date();

                            switch (freq) {
                                case 'daily': start.setDate(end.getDate() - 30); break;
                                case 'weekly': start.setDate(end.getDate() - 90); break;
                                case 'monthly': start.setFullYear(end.getFullYear() - 1); start.setDate(1); break;
                                case 'annual': start.setFullYear(end.getFullYear() - 5); start.setMonth(0, 1); break;
                            }

                            const fmt = (date) => {
                                let d = new Date(date),
                                    month = '' + (d.getMonth() + 1),
                                    day = '' + d.getDate(),
                                    year = d.getFullYear();

                                if (month.length < 2) month = '0' + month;
                                if (day.length < 2) day = '0' + day;

                                return [year, month, day].join('-');
                            };

                            sInput.value = fmt(start);
                            eInput.value = fmt(end);
                        });
                    }

                });


            </script>
@endsection