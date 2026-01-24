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
            --card-radius: 20px;
        }

        .home-zoom {
            zoom: 0.75;
            padding: 2rem;
            background: radial-gradient(circle at 0% 0%, #f7faf7 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            margin-top: 2.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--forest-green-soft);
        }

        .section-header h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--forest-green-dark);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .chart-card {
            background: var(--glass-white);
            border-radius: var(--card-radius);
            padding: 1.5rem;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.03);
            height: 100%;
            transition: transform 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px -10px rgba(31, 122, 45, 0.1);
        }

        .chart-title {
            font-size: 1rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .metric-badge {
            background: var(--forest-green-soft);
            color: var(--forest-green-dark);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }
    </style>

    <div class="home-zoom">
        <header class="mb-5 d-flex justify-content-between align-items-end">
            <div>
                <h1 class="display-5 fw-bold" style="color: var(--forest-green-dark);">System Analytics</h1>
                <p class="text-muted fw-500 mb-0">Comprehensive intelligence on Demographics, Services, and Assessments.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-success fw-bold rounded-pill px-4" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Print Report
                </button>
            </div>
        </header>

        <!-- 1. DEMOGRAPHICS -->
        <div class="section-header">
            <i class="bi bi-people-fill fs-3 text-success"></i>
            <h2>Student Demographics</h2>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="bi bi-gender-ambiguous"></i> Sex Distribution
                    </div>
                    <div style="height: 200px;">
                        <canvas id="sexChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="bi bi-layers-fill"></i> Year Levels
                    </div>
                    <div style="height: 200px;">
                        <canvas id="yearChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="bi bi-building"></i> College Enrollment
                        <span class="metric-badge ms-auto">{{ $demographics['college']->sum() }} Students</span>
                    </div>
                    <div style="height: 200px;">
                        <canvas id="collegeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. COUNSELING -->
        <div class="section-header">
            <i class="bi bi-chat-heart-fill fs-3 text-success"></i>
            <h2>Counseling Services</h2>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="chart-title"><i class="bi bi-pie-chart-fill"></i> Status Breakdown</div>
                    <div style="height: 250px;"><canvas id="counselingStatusChart"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="chart-title"><i class="bi bi-shuffle"></i> Nature of Visit</div>
                    <div style="height: 250px;"><canvas id="counselingNatureChart"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="chart-title"><i class="bi bi-person-workspace"></i> Counselor Load</div>
                    <div style="height: 250px;"><canvas id="counselorLoadChart"></canvas></div>
                </div>
            </div>
        </div>

        <!-- 3. ASSESSMENTS -->
        <div class="section-header">
            <i class="bi bi-clipboard-data-fill fs-3 text-success"></i>
            <h2>Assessments (Who Tested)</h2>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="bi bi-stack"></i> Completion by Type
                        <span class="metric-badge ms-auto">{{ $assessmentTypeStats->sum() }} Total</span>
                    </div>
                    <div style="height: 250px;"><canvas id="assessmentTypeChart"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="chart-title"><i class="bi bi-graph-up"></i> Participation Trend (6M)</div>
                    <div style="height: 250px;"><canvas id="assessmentTrendChart"></canvas></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-card">
                    <div class="chart-title"><i class="bi bi-geo-alt-fill"></i> Participation by College</div>
                    <div style="height: 250px;"><canvas id="assessmentCollegeChart"></canvas></div>
                </div>
            </div>
        </div>

        <!-- 4. GUIDANCE -->
        <div class="section-header">
            <i class="bi bi-compass-fill fs-3 text-success"></i>
            <h2>Guidance Seminars</h2>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-title">
                        <i class="bi bi-people-fill"></i> Seminar Attendance
                        <span class="metric-badge ms-auto">{{ $seminarStats->sum() }} Attendees</span>
                    </div>
                    <div style="height: 300px;"><canvas id="seminarChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Chart.defaults.font.family = "'Plus Jakarta Sans', 'Inter', sans-serif";
            Chart.defaults.color = '#64748b';

            const colors = {
                primary: '#1f7a2d',
                secondary: '#FFCB05',
                info: '#17a2b8',
                danger: '#dc3545',
                gray: '#adb5bd',
                palette: ['#1f7a2d', '#FFCB05', '#17a2b8', '#ff7043', '#6610f2', '#e83e8c', '#20c997']
            };

            // 1. Demographics Charts
            new Chart(document.getElementById('sexChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($demographics['sex']->keys()),
                    datasets: [{ data: @json($demographics['sex']->values()), backgroundColor: [colors.primary, colors.secondary, colors.gray] }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            new Chart(document.getElementById('yearChart'), {
                type: 'bar',
                data: {
                    labels: @json($demographics['year_level']->keys()->map(fn($k) => $k . (is_numeric($k) ? 'th Year' : ''))),
                    datasets: [{ label: 'Students', data: @json($demographics['year_level']->values()), backgroundColor: colors.primary, borderRadius: 5 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { display: false } } }
            });

            new Chart(document.getElementById('collegeChart'), {
                type: 'bar',
                data: {
                    labels: @json($demographics['college']->keys()),
                    datasets: [{ label: 'Enrollment', data: @json($demographics['college']->values()), backgroundColor: colors.info, borderRadius: 5 }]
                },
                options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', plugins: { legend: { display: false } } }
            });

            // 2. Counseling Charts
            new Chart(document.getElementById('counselingStatusChart'), {
                type: 'pie',
                data: {
                    labels: @json($counselingStatus->keys()->map(fn($s) => ucfirst($s))),
                    datasets: [{ data: @json($counselingStatus->values()), backgroundColor: colors.palette }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            new Chart(document.getElementById('counselingNatureChart'), {
                type: 'bar',
                data: {
                    labels: @json(array_keys($counselingNature)),
                    datasets: [{ label: 'Appointments', data: @json(array_values($counselingNature)), backgroundColor: [colors.primary, colors.info, colors.secondary, colors.gray], borderRadius: 8 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            new Chart(document.getElementById('counselorLoadChart'), {
                type: 'bar',
                data: {
                    labels: @json($counselorWorkload->keys()),
                    datasets: [{ label: 'Session Notes', data: @json($counselorWorkload->values()), backgroundColor: colors.primary, borderRadius: 8 }]
                },
                options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', plugins: { legend: { display: false } } }
            });

            // 3. Assessment Charts
            new Chart(document.getElementById('assessmentTypeChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($assessmentTypeStats->keys()),
                    datasets: [{ data: @json($assessmentTypeStats->values()), backgroundColor: colors.palette }]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '60%' }
            });

            new Chart(document.getElementById('assessmentTrendChart'), {
                type: 'line',
                data: {
                    labels: @json($assessmentTrend->keys()),
                    datasets: [{ label: 'Assessments Taken', data: @json($assessmentTrend->values()), borderColor: colors.primary, backgroundColor: 'rgba(31, 122, 45, 0.1)', fill: true, tension: 0.4 }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            new Chart(document.getElementById('assessmentCollegeChart'), {
                type: 'bar',
                data: {
                    labels: @json($assessmentParticipation->keys()),
                    datasets: [{ label: 'Unique Participants', data: @json($assessmentParticipation->values()), backgroundColor: colors.secondary, borderRadius: 5 }]
                },
                options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', plugins: { legend: { display: false } } }
            });

            // 4. Guidance Chart
            new Chart(document.getElementById('seminarChart'), {
                type: 'bar',
                data: {
                    labels: @json($seminarStats->keys()),
                    datasets: [{ label: 'Attendees', data: @json($seminarStats->values()), backgroundColor: colors.info, borderRadius: 10, maxBarThickness: 50 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        });
    </script>
@endsection