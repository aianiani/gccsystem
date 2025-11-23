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
        
        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
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
        
        .welcome-card .welcome-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .main-content-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        
        .main-content-card .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .main-content-card .card-body {
            padding: 1.25rem;
        }
        
        .dashboard-stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem 1rem;
            text-align: center;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .dashboard-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17,94,37,0.06);
        }
        
        .btn-outline-primary {
            border-color: var(--forest-green);
            color: var(--forest-green);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        
        @media (max-width: 991.98px) { 
            .main-dashboard-content { 
                margin-left: 200px; 
            } 
        }
        @media (max-width: 767.98px) { 
            .main-dashboard-content { 
                margin-left: 0; 
            } 
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
            <div class="welcome-card">
                <div>
                    <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                    <div class="welcome-text">Assessment Results</div>
                    <div style="font-size: 0.9rem; margin-top: 0.5rem;">View and analyze student assessment data</div>
                </div>
                <div class="welcome-avatar">
                    <img src="{{ auth()->user()->avatar_url }}" 
                         alt="{{ auth()->user()->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
            </div>

            @php
                $total = $assessments->total();
                $high = $assessments->where('risk_level', 'high')->count();
                $moderate = $assessments->where('risk_level', 'moderate')->count();
                $normal = $assessments->where('risk_level', 'normal')->count();
                $dassAssessments = $assessments->whereIn('type', ['DASS-42', 'DASS-21']);
                $avgDepression = $dassAssessments->count() ? $dassAssessments->avg(function($a) {
                    $score = is_array($a->score) ? $a->score : json_decode($a->score, true);
                    return $score['depression'] ?? 0;
                }) : 0;
                $avgAnxiety = $dassAssessments->count() ? $dassAssessments->avg(function($a) {
                    $score = is_array($a->score) ? $a->score : json_decode($a->score, true);
                    return $score['anxiety'] ?? 0;
                }) : 0;
                $avgStress = $dassAssessments->count() ? $dassAssessments->avg(function($a) {
                    $score = is_array($a->score) ? $a->score : json_decode($a->score, true);
                    return $score['stress'] ?? 0;
                }) : 0;
            @endphp
            
            <div class="dashboard-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 0.75rem; margin-bottom: 1.5rem;">
                <div class="dashboard-stat-card">
                    <div class="stat-value" style="font-size: 1.5rem; font-weight: 700; color: var(--forest-green); margin-bottom: 0.5rem;">{{ $total }}</div>
                    <div class="stat-label" style="font-size: 1rem; color: var(--forest-green-light);">Total Assessments</div>
                </div>
                <div class="dashboard-stat-card" style="border-left: 4px solid var(--danger);">
                    <div class="stat-value" style="font-size: 1.5rem; font-weight: 700; color: var(--danger); margin-bottom: 0.5rem;"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $high }}</div>
                    <div class="stat-label" style="font-size: 1rem; color: var(--forest-green-light);">High Risk</div>
                </div>
                <div class="dashboard-stat-card" style="border-left: 4px solid var(--warning);">
                    <div class="stat-value" style="font-size: 1.5rem; font-weight: 700; color: var(--warning); margin-bottom: 0.5rem;"><i class="bi bi-exclamation-circle-fill me-1"></i>{{ $moderate }}</div>
                    <div class="stat-label" style="font-size: 1rem; color: var(--forest-green-light);">Moderate Risk</div>
                </div>
                <div class="dashboard-stat-card" style="border-left: 4px solid var(--success);">
                    <div class="stat-value" style="font-size: 1.5rem; font-weight: 700; color: var(--success); margin-bottom: 0.5rem;"><i class="bi bi-check-circle-fill me-1"></i>{{ $normal }}</div>
                    <div class="stat-label" style="font-size: 1rem; color: var(--forest-green-light);">Normal</div>
                </div>
            </div>
            
            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Assessment Results</h5>
                </div>
                <div class="card-body">
                    {{-- Filter Bar --}}
                    <form method="GET" class="mb-3">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label mb-1">Assessment Type</label>
                                <select name="type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="DASS-42" @if(request('type')=='DASS-42') selected @endif>DASS-42</option>
                                    <option value="DASS-21" @if(request('type')=='DASS-21') selected @endif>DASS-21</option>
                                    <option value="Academic Stress Survey" @if(request('type')=='Academic Stress Survey') selected @endif>Academic Stress Survey</option>
                                    <option value="Wellness Check" @if(request('type')=='Wellness Check') selected @endif>Wellness Check</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1">Risk Level</label>
                                <select name="risk" class="form-select">
                                    <option value="">All Levels</option>
                                    <option value="high" @if(request('risk')=='high') selected @endif>High</option>
                                    <option value="moderate" @if(request('risk')=='moderate') selected @endif>Moderate</option>
                                    <option value="normal" @if(request('risk')=='normal') selected @endif>Normal</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-1">Student Name/Email</label>
                                <input type="text" name="student" class="form-control" value="{{ request('student') }}" placeholder="Search...">
                            </div>
                            <div class="col-md-2 d-grid">
                                <button class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                            </div>
                        </div>
                    </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 w-100" style="min-width:900px;">
                    <thead class="table-light sticky-top" style="z-index:1;">
                        <tr>
                            <th class="text-center" style="width: 120px;">Type</th>
                            <th class="text-center" style="width: 170px; white-space:nowrap;">Date</th>
                            <th class="text-start" style="min-width: 160px;">Student</th>
                            <th class="text-start" style="min-width: 200px; max-width: 260px;">Email</th>
                            <th class="text-center" style="width: 120px;">Risk Level</th>
                            <th class="text-end" style="width: 110px;">Depression</th>
                            <th class="text-end" style="width: 110px;">Anxiety</th>
                            <th class="text-end" style="width: 110px;">Stress</th>
                            <th class="text-end" style="width: 110px;">Total Score</th>
                            <th class="text-center" style="width: 120px;">Sentiment</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sentimentAnalyzer = new \PHPInsight\Sentiment(); @endphp
                        @forelse($assessments as $assessment)
                            @php 
                                $scores = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true); 
                                $comment = $assessment->student_comment ?? '';
                                $ai_sentiment = $comment ? $sentimentAnalyzer->categorise($comment) : 'neu';
                            @endphp
                            <tr class="align-middle @if($assessment->risk_level==='high') table-danger @elseif($assessment->risk_level==='moderate') table-warning @endif">
                                <td class="text-center align-middle"><span class="badge rounded-pill bg-light text-dark border border-1">{{ $assessment->type }}</span></td>
                                <td class="text-center align-middle" style="white-space:nowrap;">{{ $assessment->created_at->format('M d, Y h:i A') }}</td>
                                <td class="text-start align-middle">{{ $assessment->user->name ?? 'N/A' }}</td>
                                <td class="text-start align-middle" style="max-width: 240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $assessment->user->email ?? 'N/A' }}">{{ $assessment->user->email ?? 'N/A' }}</td>
                                <td class="text-center align-middle">
                                    @if($assessment->risk_level==='high')
                                        <span class="badge bg-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i> High</span>
                                    @elseif($assessment->risk_level==='moderate')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle-fill me-1"></i> Moderate</span>
                                    @else
                                        <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i> Normal</span>
                                    @endif
                                </td>
                                @if($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21')
                                    <td class="text-end align-middle"><span class="badge bg-primary">{{ $scores['depression'] ?? '-' }}</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-info text-dark">{{ $scores['anxiety'] ?? '-' }}</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-secondary">{{ $scores['stress'] ?? '-' }}</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-primary">-</span></td>
                                @else
                                    <td class="text-end align-middle"><span class="badge bg-primary">-</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-info text-dark">-</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-secondary">-</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-primary">{{ is_array($assessment->score) ? ($assessment->score['score'] ?? '-') : (is_numeric($assessment->score) ? $assessment->score : '-') }}</span></td>
                                @endif
                                <td class="text-center align-middle">
                                    @if($ai_sentiment === 'pos')
                                        <span class="badge bg-success"><i class="bi bi-emoji-smile"></i> Positive</span>
                                    @elseif($ai_sentiment === 'neg')
                                        <span class="badge bg-danger"><i class="bi bi-emoji-frown"></i> Negative</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-emoji-neutral"></i> Neutral</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('counselor.assessments.show', $assessment->id) }}" class="btn btn-outline-info btn-sm" style="white-space:nowrap; min-width:80px;">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <button class="btn btn-outline-success btn-sm mt-1 ai-insights-btn" style="white-space:nowrap; min-width:80px;"
                                        data-bs-toggle="modal" data-bs-target="#aiInsightsModal-{{ $assessment->id }}"
                                    >
                                        <i class="bi bi-robot"></i> AI Insights
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="11" class="text-center text-muted py-4">No assessment results found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $assessments->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
    </div>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
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
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
<!-- Render all modals after the table -->
@foreach($assessments as $assessment)
    @php $scores = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true); @endphp
    <!-- View Summary Modal -->
    <div class="modal fade" id="summaryModal-{{ $assessment->id }}" tabindex="-1" aria-labelledby="summaryModalLabel-{{ $assessment->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="summaryModalLabel-{{ $assessment->id }}">Assessment Summary</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @include('counselor.assessments.partials.summary', ['assessment' => $assessment, 'scores' => $scores])
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- AI Insights Modal -->
    <div class="modal fade" id="aiInsightsModal-{{ $assessment->id }}" tabindex="-1" aria-labelledby="aiInsightsModalLabel-{{ $assessment->id }}" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="aiInsightsModalLabel-{{ $assessment->id }}">AI Sentiment Analysis</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="card shadow-sm border-0" style="background: #f8fafd;">
              <div class="card-body">
                @if($assessment->ai_sentiment)
                    <div class="d-flex align-items-center mb-2">
                        @if($assessment->ai_sentiment === 'positive')
                            <span class="badge bg-success px-3 py-2 me-2"><i class="bi bi-emoji-smile"></i> Positive</span>
                        @elseif($assessment->ai_sentiment === 'negative')
                            <span class="badge bg-danger px-3 py-2 me-2"><i class="bi bi-emoji-frown"></i> Negative</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2 me-2"><i class="bi bi-emoji-neutral"></i> Neutral</span>
                        @endif
                        <span class="text-muted small">(Based on student comment)</span>
                    </div>
                    @if($assessment->student_comment)
                        <div class="mb-2 p-2 rounded bg-light border"><strong>Student Comment:</strong><br>{{ $assessment->student_comment }}</div>
                    @endif
                @else
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        No AI analysis available for this assessment. The student may not have provided a comment.
                    </div>
                @endif
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@endforeach

            {{-- Summary Graphs and Suggestions at the Bottom --}}
            <div class="main-content-card" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Analytics & Insights</h5>
                </div>
                <div class="card-body">
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3 h-100">
                <h6 class="fw-bold mb-2">Risk Level Distribution</h6>
                <canvas id="riskPieChart" width="300" height="300"></canvas>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3 h-100">
                <h6 class="fw-bold mb-2">Assessment Type Breakdown</h6>
                <canvas id="typeBarChart" width="300" height="300"></canvas>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3 h-100">
                <h6 class="fw-bold mb-2">DASS Subscale Averages</h6>
                <canvas id="dassBarChart" width="300" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold mb-2"><i class="bi bi-lightbulb me-2"></i>Actionable Suggestions</h6>
                <ul class="mb-0">
                    <li>Prioritize follow-up with students flagged as <span class="fw-bold text-danger">High Risk</span>. Consider scheduling immediate counseling sessions.</li>
                    <li>If you see an increase in high/moderate risk or rising average scores, consider group interventions or workshops.</li>
                    <li>If some students have not completed assessments, send reminders or encourage participation.</li>
                    <li>Review <span class="fw-bold">AI Insights</span> for negative/neutral sentiment comments for early warning signs not captured by scores.</li>
                    <li>Use the data to identify students who may benefit from additional wellness resources.</li>
                </ul>
            </div>
        </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxRisk = document.getElementById('riskPieChart').getContext('2d');
const riskPieChart = new Chart(ctxRisk, {
    type: 'doughnut',
    data: {
        labels: ['High', 'Moderate', 'Normal'],
        datasets: [{
            data: [{{ $high }}, {{ $moderate }}, {{ $normal }}],
            backgroundColor: ['#dc3545', '#ffc107', '#198754'],
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
const ctxType = document.getElementById('typeBarChart').getContext('2d');
const typeBarChart = new Chart(ctxType, {
    type: 'bar',
    data: {
        labels: ['DASS-42', 'DASS-21', 'Academic Stress Survey', 'Wellness Check'],
        datasets: [{
            label: 'Assessments',
            data: [
                {{ $assessments->whereIn('type', ['DASS-42', 'DASS-21'])->count() }},
                {{ $assessments->where('type', 'Academic Stress Survey')->count() }},
                {{ $assessments->where('type', 'Wellness Check')->count() }}
            ],
            backgroundColor: ['#0d6efd', '#6610f2', '#20c997']
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        }
    }
});
const ctxDass = document.getElementById('dassBarChart').getContext('2d');
const dassBarChart = new Chart(ctxDass, {
    type: 'bar',
    data: {
        labels: ['Depression', 'Anxiety', 'Stress'],
        datasets: [{
            label: 'Average Score',
            data: [{{ round($avgDepression,1) }}, {{ round($avgAnxiety,1) }}, {{ round($avgStress,1) }}],
            backgroundColor: ['#0d6efd', '#0dcaf0', '#6c757d']
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true, max: 42 }
        }
    }
});
</script>
<style>
    .sticky-top { position: sticky !important; top: 0; background: #f8f9fa; }
    .table-hover tbody tr:hover { background: #f4f8fb !important; }
    .table th, .table td { vertical-align: middle !important; }
    @media (max-width: 900px) {
        .table th, .table td { font-size: 0.95rem; padding: 0.5rem 0.3rem; }
        .table th:nth-child(4), .table td:nth-child(4) { max-width: 120px; }
    }
    @media (max-width: 600px) {
        .table th, .table td { font-size: 0.90rem; padding: 0.4rem 0.2rem; }
        .table th:nth-child(4), .table td:nth-child(4) { max-width: 80px; }
    }
.ai-highlight {
  box-shadow: 0 0 0 4px #0dcaf0;
  background: #e0f7fa;
  transition: box-shadow 0.3s, background 0.3s;
}
</style>
@endsection 