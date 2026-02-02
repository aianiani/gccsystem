@extends('layouts.app')

@section('content')
    <style>
        :root {
            /* Executive Color System - HSL for better control */
            --primary-h: 129;
            --primary-s: 60%;
            --primary-l: 30%;

            --forest-green: hsl(var(--primary-h), var(--primary-s), var(--primary-l));
            --forest-green-dark: hsl(var(--primary-h), var(--primary-s), 20%);
            --forest-green-light: hsl(var(--primary-h), var(--primary-s), 45%);
            --forest-green-soft: hsla(var(--primary-h), var(--primary-s), var(--primary-l), 0.08);

            --maize-yellow: #FFCB05;
            --maize-yellow-glow: rgba(255, 203, 5, 0.3);

            --glass-white: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(255, 255, 255, 0.6);
            --premium-shadow: 0 20px 40px -15px rgba(0, 50, 0, 0.15);
            --card-radius: 24px;
        }

        .home-zoom {
            zoom: 0.75;
            padding: 2rem;
            background: radial-gradient(circle at 0% 0%, #f7faf7 0%, #ffffff 100%);
            min-height: 100vh;
        }

        /* Dashboard Header */
        .executive-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            animation: fadeInDown 0.6s ease-out;
        }

        .header-title h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--forest-green-dark);
            letter-spacing: -1px;
            margin-bottom: 0.25rem;
        }

        .header-title p {
            font-size: 1.1rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .date-chip {
            background: var(--glass-white);
            border: 1px solid var(--glass-border);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: var(--forest-green);
        }

        /* Executive Stats Row */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .premium-stat-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 180px;
        }

        .premium-stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--premium-shadow);
            border-color: var(--forest-green-light);
        }

        .premium-stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: var(--forest-green-soft);
            border-radius: 0 0 0 100%;
            transition: all 0.4s ease;
        }

        .premium-stat-card:hover::after {
            width: 100%;
            height: 100%;
            border-radius: 0;
            opacity: 0.5;
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--forest-green);
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .stat-info .value {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--forest-green-dark);
            line-height: 1;
        }

        .stat-info .label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
        }

        /* Charts Section */
        .chart-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .premium-card {
            background: var(--glass-white);
            backdrop-filter: blur(15px);
            border-radius: var(--card-radius);
            border: 1px solid var(--glass-border);
            padding: 2rem;
            box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.05);
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .card-header-flex h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--forest-green-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header-flex .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        /* Critical Alerts */
        .alert-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 16px;
            background: white;
            margin-bottom: 1rem;
            border: 1px solid rgba(220, 53, 69, 0.1);
            transition: all 0.3s ease;
        }

        .alert-item:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 15px -5px rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
        }

        .alert-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .alert-details h4 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            color: var(--forest-green-dark);
        }

        .alert-details p {
            font-size: 0.85rem;
            margin: 0;
            color: var(--text-light);
        }

        .alert-risk {
            margin-left: auto;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .risk-extremely-severe {
            background: #f82b60;
            color: white;
        }

        .risk-severe {
            background: #ff4d4d;
            color: white;
        }

        /* Quick Action Grid */
        .action-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        .action-button {
            background: white;
            border: 1px solid var(--glass-border);
            padding: 1.5rem;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            color: var(--forest-green-dark);
            font-weight: 700;
            text-decoration: none !important;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .action-button:hover {
            background: var(--forest-green);
            color: var(--maize-yellow);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px -5px rgba(31, 122, 45, 0.3);
        }

        .action-button i {
            font-size: 1.8rem;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1200px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .chart-layout {
                grid-template-columns: 1fr;
            }

            .action-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="home-zoom">
        <!-- Dashboard Header -->
        <header class="executive-header">
            <div class="header-title">
                <h1>CMU Guidance and Counseling Center</h1>
                <p>Strategic overview of GCC student wellness and operations.</p>
            </div>
            <div class="date-chip">
                <i class="bi bi-calendar3"></i>
                <span>{{ now()->format('l, F j, Y') }}</span>
            </div>
        </header>

        <!-- Premium Stats Row -->
        <div class="stat-grid">
            <div class="premium-stat-card">
                <i class="bi bi-people-fill stat-icon"></i>
                <div class="stat-info">
                    <div class="value">{{ number_format($stats['total_users']) }}</div>
                    <div class="label">Total Enrolled</div>
                </div>
            </div>
            <div class="premium-stat-card">
                <i class="bi bi-calendar-check-fill stat-icon"></i>
                <div class="stat-info">
                    <div class="value">{{ number_format($analytics['action_items']['pending_appointments']) }}</div>
                    <div class="label">Active Sessions</div>
                </div>
            </div>
            <div class="premium-stat-card">
                <i class="bi bi-shield-exclamation stat-icon" style="color: #dc3545;"></i>
                <div class="stat-info">
                    <div class="value">{{ $analytics['critical_alerts']->count() }}</div>
                    <div class="label">Critical Cases</div>
                </div>
            </div>
            <div class="premium-stat-card">
                <i class="bi bi-person-plus-fill stat-icon" style="color: var(--maize-yellow);"></i>
                <div class="stat-info">
                    <div class="value">{{ $analytics['action_items']['pending_approvals'] }}</div>
                    <div class="label">Pending Access</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="action-strip">
            <a href="{{ route('users.index') }}" class="action-button">
                <i class="bi bi-person-gear"></i>
                Manage Users
            </a>
            <a href="{{ route('admin.registration-approvals.index') }}" class="action-button">
                <i class="bi bi-shield-check"></i>
                Student Approvals
            </a>
            <a href="{{ route('announcements.index') }}" class="action-button">
                <i class="bi bi-broadcast"></i>
                Announcements
            </a>
            <a href="{{ route('admin.reports.index') }}" class="action-button">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Reports
            </a>
        </div>

        <!-- NEW: Reports Generated Section -->





        <!-- Student Demographic Intel Section -->
        <div class="header-title mb-4">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--forest-green-dark);">Student Demographic
                Intelligence</h2>
            <p style="font-size: 0.9rem;">Deep-dive into organizational composition and distribution.</p>
        </div>

        <div class="stat-grid" style="grid-template-columns: repeat(2, 1fr); margin-bottom: 2.5rem;">
            <!-- Gender Distribution -->
            <div class="premium-card">
                <div class="card-header-flex">
                    <h2 style="font-size: 1.1rem;"><i class="bi bi-gender-ambiguous"></i> Sex Distribution</h2>
                </div>
                <div style="height: 220px;">
                    <canvas id="genderDonut"></canvas>
                </div>
            </div>



            <!-- Top Programs -->
            <div class="premium-card">
                <div class="card-header-flex">
                    <h2 style="font-size: 1.1rem;"><i class="bi bi-journal-check"></i> High-Density Programs</h2>
                </div>
                <div class="list-group list-group-flush pt-2">
                    @foreach($analytics['demographics']['top_courses']['labels'] as $index => $course)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="badge rounded-pill bg-success-subtle text-success">{{ $index + 1 }}</div>
                                <span class="fw-600 text-dark small">{{ Str::limit($course, 25) }}</span>
                            </div>
                            <span
                                class="badge bg-light text-dark">{{ $analytics['demographics']['top_courses']['data'][$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- NEW: Detailed Gender Analytics -->
        <div class="chart-layout">
            <!-- Gender by College -->
            <div class="premium-card">
                <div class="card-header-flex">
                    <h2 style="font-size: 1.1rem;"><i class="bi bi-buildings"></i> Sex Distribution by College</h2>
                </div>
                <div style="height: 300px;">
                    <canvas id="genderCollegeChart"></canvas>
                </div>
            </div>

            <!-- Gender by Year Level -->
            <div class="premium-card">
                <div class="card-header-flex">
                    <h2 style="font-size: 1.1rem;"><i class="bi bi-mortarboard-fill"></i> Sex Distribution by Year</h2>
                </div>
                <div style="height: 300px;">
                    <canvas id="genderYearChart"></canvas>
                </div>
            </div>
        </div>

        <!-- NEW: College Distribution & Population Table -->
        <div class="chart-layout" style="grid-template-columns: 1fr;">
            <!-- College Distribution Bar -->
            <div class="premium-card">
                <div class="card-header-flex">
                    <h2 style="font-size: 1.1rem;"><i class="bi bi-building"></i> Students by College</h2>
                </div>
                <div style="height: 300px;">
                    <canvas id="collegeBar"></canvas>
                </div>
            </div>
        </div>

        <div class="premium-card mb-4">
            <div class="card-header-flex">
                <h2 style="font-size: 1.1rem;"><i class="bi bi-table"></i> Student Population Matrix (College x Year Level)
                </h2>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="demographicsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">College</th>
                            <th class="text-center">1st Year</th>
                            <th class="text-center">2nd Year</th>
                            <th class="text-center">3rd Year</th>
                            <th class="text-center">4th Year+</th>
                            <th class="text-center fw-bold">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandTotalY1 = 0;
                            $grandTotalY2 = 0;
                            $grandTotalY3 = 0;
                            $grandTotalY4 = 0;
                            $grandTotal = 0;
                            $maxVal = 0;

                            // Pre-calculate max value for heatmap
                            foreach ($analytics['demographics']['college']['labels'] as $college) {
                                $row = $analytics['demographics']['matrix'][$college] ?? collect([]);
                                $v1 = $row['1'] ?? $row['1st Year'] ?? 0;
                                $v2 = $row['2'] ?? $row['2nd Year'] ?? 0;
                                $v3 = $row['3'] ?? $row['3rd Year'] ?? 0;
                                $v4 = ($row['4'] ?? 0) + ($row['4th Year'] ?? 0) + ($row['5'] ?? 0) + ($row['5th Year'] ?? 0);
                                $maxVal = max($maxVal, $v1, $v2, $v3, $v4);
                            }
                        @endphp

                        @foreach($analytics['demographics']['college']['labels'] as $college)
                            @php
                                $matrixRow = $analytics['demographics']['matrix'][$college] ?? collect([]);
                                $y1 = $matrixRow['1'] ?? $matrixRow['1st Year'] ?? 0;
                                $y2 = $matrixRow['2'] ?? $matrixRow['2nd Year'] ?? 0;
                                $y3 = $matrixRow['3'] ?? $matrixRow['3rd Year'] ?? 0;
                                $y4 = ($matrixRow['4'] ?? 0) + ($matrixRow['4th Year'] ?? 0) + ($matrixRow['5'] ?? 0) + ($matrixRow['5th Year'] ?? 0);
                                $total = $y1 + $y2 + $y3 + $y4;

                                $grandTotalY1 += $y1;
                                $grandTotalY2 += $y2;
                                $grandTotalY3 += $y3;
                                $grandTotalY4 += $y4;
                                $grandTotal += $total;
                            @endphp
                            <tr>
                                <td class="ps-3 fw-600 text-dark">{{ $college ?: 'Unassigned' }}</td>
                                <td class="text-center heat-cell" data-value="{{ $y1 }}">{{ $y1 ?: '-' }}</td>
                                <td class="text-center heat-cell" data-value="{{ $y2 }}">{{ $y2 ?: '-' }}</td>
                                <td class="text-center heat-cell" data-value="{{ $y3 }}">{{ $y3 ?: '-' }}</td>
                                <td class="text-center heat-cell" data-value="{{ $y4 }}">{{ $y4 ?: '-' }}</td>
                                <td class="text-center fw-bold text-success">{{ $total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light fw-bold">
                        <tr>
                            <td class="ps-3 text-dark">TOTAL</td>
                            <td class="text-center text-primary">{{ $grandTotalY1 }}</td>
                            <td class="text-center text-primary">{{ $grandTotalY2 }}</td>
                            <td class="text-center text-primary">{{ $grandTotalY3 }}</td>
                            <td class="text-center text-primary">{{ $grandTotalY4 }}</td>
                            <td class="text-center text-success fs-6">{{ $grandTotal }}</td>
                        </tr>
                    </tfoot>
                </table>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const maxVal = {{ $maxVal > 0 ? $maxVal : 1 }};
                        const cells = document.querySelectorAll('.heat-cell');

                        cells.forEach(cell => {
                            const val = parseInt(cell.getAttribute('data-value')) || 0;
                            if (val > 0) {
                                const intensity = val / maxVal;
                                // Forest green base: 31, 122, 45. Alpha varies.
                                cell.style.backgroundColor = `rgba(31, 122, 45, ${intensity * 0.25})`; // Much softer alpha
                                if (intensity > 0.7) {
                                    cell.style.backgroundColor = `rgba(31, 122, 45, ${intensity * 0.6})`; // Stronger for high values
                                    cell.style.color = 'white';
                                    cell.style.fontWeight = 'bold';
                                }
                            }
                        });
                    });
                </script>
            </div>
        </div>


        <!-- Last Section: Announcements Preview -->
        <div class="premium-card mb-5">
            <div class="card-header-flex">
                <h2><i class="bi bi-broadcast"></i> Recent Announcements</h2>
                <a href="{{ route('announcements.index') }}" class="text-decoration-none small fw-bold"
                    style="color: var(--forest-green);">Manage All</a>
            </div>

            @if($recentAnnouncements->count() > 0)
                <div class="row">
                    @foreach($recentAnnouncements as $announcement)
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded-4 h-100 position-relative hover-shadow transition-all bg-white">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3">
                                        {{ $announcement->created_at->format('M d') }}
                                    </span>
                                </div>
                                <h5 class="fw-bold mb-2 text-dark">{{ Str::limit($announcement->title, 40) }}</h5>
                                <p class="text-muted small mb-3">{{ Str::limit(strip_tags($announcement->content), 80) }}</p>
                                <a href="{{ route('announcements.show', $announcement->id) }}"
                                    class="stretched-link text-decoration-none fw-600 small" style="color: var(--forest-green);">
                                    Read More <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-megaphone text-muted display-4 mb-3 opacity-50"></i>
                    <p class="text-muted fw-500">No recent announcements posted.</p>
                    <a href="{{ route('announcements.create') }}" class="btn btn-sm btn-outline-success rounded-pill px-4 mt-2">
                        Create New
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Chart.defaults.font.family = "'Plus Jakarta Sans', 'Inter', sans-serif";
            Chart.defaults.color = '#64748b';

            // 1. Gender Distribution Donut
            const genderCtx = document.getElementById('genderDonut').getContext('2d');
            new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($analytics['demographics']['sex']['labels']),
                    datasets: [{
                        data: @json($analytics['demographics']['sex']['data']),
                        backgroundColor: ['#1f7a2d', '#FFCB05', '#17a2b8', '#ff7043', '#adb5bd'],
                        borderWidth: 0,
                        hoverOffset: 15,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 8, padding: 15, font: { weight: 600, size: 10 } } }
                    }
                }
            });







            // 3. Gender Contribution by College (Stacked)
            const genderCollegeCtx = document.getElementById('genderCollegeChart').getContext('2d');
            const collegeKeys = @json($analytics['demographics']['gender_by_college']->keys());
            const collegeLabels = collegeKeys.map(name => {
                if (!name) return 'Unknown';
                // Extract all uppercase letters to form acronym (e.g., "College of Arts and Sciences" -> "CAS")
                const matches = name.match(/[A-Z]/g);
                return matches ? matches.join('') : name.substring(0, 3).toUpperCase();
            });
            const collegeMales = @json($analytics['demographics']['gender_by_college']->pluck('male'));
            const collegeFemales = @json($analytics['demographics']['gender_by_college']->pluck('female'));

            new Chart(genderCollegeCtx, {
                type: 'bar',
                data: {
                    labels: collegeLabels,
                    datasets: [
                        { label: 'Male', data: collegeMales, backgroundColor: '#1f7a2d', stack: 'Stack 0' },
                        { label: 'Female', data: collegeFemales, backgroundColor: '#FFCB05', stack: 'Stack 0' }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: { display: false },
                            ticks: { precision: 0 }
                        },
                        y: {
                            stacked: true,
                            grid: { display: false },
                            ticks: { font: { size: 9 } }
                        }
                    }
                }
            });

            // 4. Gender Contribution by Year Level (Stacked)
            const genderYearCtx = document.getElementById('genderYearChart').getContext('2d');
            const yearKeys = @json($analytics['demographics']['gender_by_year']->keys());
            const yearLabels = yearKeys.map(k => {
                if (String(k).toLowerCase().includes('year')) return k;
                const map = { '1': 'st', '2': 'nd', '3': 'rd' };
                return k + (map[k] || 'th') + ' Year';
            });
            const yearMales = @json($analytics['demographics']['gender_by_year']->pluck('male'));
            const yearFemales = @json($analytics['demographics']['gender_by_year']->pluck('female'));

            new Chart(genderYearCtx, {
                type: 'bar',
                data: {
                    labels: yearLabels,
                    datasets: [
                        { label: 'Male', data: yearMales, backgroundColor: '#1f7a2d', stack: 'Stack 0' },
                        { label: 'Female', data: yearFemales, backgroundColor: '#FFCB05', stack: 'Stack 0' }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: { display: false }
                        },
                        y: {
                            stacked: true,
                            grid: { color: 'rgba(0,0,0,0.03)' },
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // 8. College Distribution Bar
            const collegeCtx = document.getElementById('collegeBar').getContext('2d');
            const collegeGeneralKeys = @json($analytics['demographics']['college']['labels']);
            const collegeGeneralLabels = collegeGeneralKeys.map(name => {
                if (!name) return 'Unknown';
                // Extract all uppercase letters to form acronym
                const matches = name.match(/[A-Z]/g);
                return matches ? matches.join('') : name.substring(0, 3).toUpperCase();
            });

            new Chart(collegeCtx, {
                type: 'bar',
                data: {
                    labels: collegeGeneralLabels,
                    datasets: [{
                        label: 'Total Students',
                        data: @json($analytics['demographics']['college']['data']),
                        backgroundColor: '#1f7a2d',
                        borderRadius: 6
                    }]
                },
                options: {
                    indexAxis: 'x', // Vertical bars
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        });
    </script>
@endsection