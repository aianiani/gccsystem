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

        /* Risk indicator dots and legend */
        .risk-dot {
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08);
            border: 2px solid #fff;
        }
        .risk-dot.low { background: #4caf50; }
        .risk-dot.low-moderate { background: #ffb300; }
        .risk-dot.moderate { background: #f39c12; }
        .risk-dot.high { background: #e74c3c; }
        .risk-dot.very-high { background: #8b1e3f; }

        .risk-legend { display:flex; gap:12px; align-items:center; margin-bottom:0.75rem; }
        .risk-legend .legend-item { display:flex; align-items:center; gap:8px; font-size:0.95rem; color:var(--text-dark); }
        .risk-legend .legend-item .pill { width:12px; height:12px; border-radius:50%; display:inline-block; }
        .risk-legend .legend-item .pill.low { background:#4caf50; }
        .risk-legend .legend-item .pill.low-moderate { background:#ffb300; }
        .risk-legend .legend-item .pill.moderate { background:#f39c12; }
        .risk-legend .legend-item .pill.high { background:#e74c3c; }
        .risk-legend .legend-item .pill.very-high { background:#8b1e3f; }
        
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

        /* Filter action buttons sizing and alignment */
        .filter-actions {
            align-items: center;
            justify-content: flex-end;
            /* Nudge the action buttons slightly upward to match input baseline */
            transform: translateY(-6px);
        }
        .filter-actions .btn {
            height: 44px;
            padding: 0.45rem 0.9rem;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }
        .filter-actions .btn i { margin-right: 6px; }
        /* Reset button: compact circular style that lines up with inputs */
        .filter-actions .btn-reset {
            padding: 0.35rem 0.45rem;
            width: 44px;
            min-width: 44px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        /* Filter button slightly more prominent */
        .filter-actions .btn-filter { padding-left: 0.85rem; padding-right: 0.85rem; }
        @media (max-width: 576px) {
            .filter-actions .btn { height: 40px; padding: 0.35rem 0.6rem; font-size: 0.95rem; }
            .filter-actions .btn-reset { width: 40px; min-width: 40px; }
        }

        /* Make filter inputs align with filter buttons by matching heights in this form */
        .main-content-card .card-body > form .form-control,
        .main-content-card .card-body > form .form-select {
            height: 44px;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
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
                // new detailed risk categories
                $low = $assessments->where('risk_level', 'low')->count() + $assessments->where('risk_level', 'normal')->count(); // include legacy 'normal'
                $lowModerate = $assessments->where('risk_level', 'low-moderate')->count();
                $moderate = $assessments->where('risk_level', 'moderate')->count();
                $high = $assessments->where('risk_level', 'high')->count();
                $veryHigh = $assessments->where('risk_level', 'very-high')->count();
                $dassAssessments = $assessments->where('type', 'DASS-42');
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
                $avgOverall = ($avgDepression + $avgAnxiety + $avgStress) / 3;
            @endphp
            
            <!-- Compact Hero / Summary Cards (reduced) -->
            <div class="row g-3 mb-3 hero-cards">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="dashboard-stat-card">
                        <div style="font-size:0.85rem; color:var(--text-light);">Total Assessments</div>
                        <div style="font-size:1.35rem; font-weight:700; margin-top:0.35rem;">{{ number_format($total) }}</div>
                        <div style="font-size:0.8rem; color:var(--text-light); margin-top:0.25rem;">All types</div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="dashboard-stat-card">
                        <div style="font-size:0.85rem; color:var(--text-light);">DASS-42 Count</div>
                        <div style="font-size:1.35rem; font-weight:700; margin-top:0.35rem;">{{ $dassAssessments->count() }}</div>
                        <div style="font-size:0.8rem; color:var(--text-light); margin-top:0.25rem;">Completed DASS-42</div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="dashboard-stat-card">
                        <div style="font-size:0.85rem; color:var(--text-light);">Average DASS Score</div>
                        <div style="font-size:1.35rem; font-weight:700; margin-top:0.35rem;">{{ number_format($avgOverall,1) }}</div>
                        <div style="font-size:0.8rem; color:var(--text-light); margin-top:0.25rem;">Mean of Depression, Anxiety, Stress</div>
                    </div>
                </div>
            </div>

            <!-- Risk category counts -->
            <div class="row g-3 mb-3">
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="dashboard-stat-card text-center">
                        <div style="font-size:0.85rem; color:var(--text-light);">Low Risk</div>
                        <div style="font-size:1.25rem; font-weight:700; margin-top:0.4rem;">{{ $low }}</div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="dashboard-stat-card text-center">
                        <div style="font-size:0.85rem; color:var(--text-light);">Low-Moderate</div>
                        <div style="font-size:1.25rem; font-weight:700; margin-top:0.4rem;">{{ $lowModerate }}</div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="dashboard-stat-card text-center">
                        <div style="font-size:0.85rem; color:var(--text-light);">Moderate</div>
                        <div style="font-size:1.25rem; font-weight:700; margin-top:0.4rem;">{{ $moderate }}</div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="dashboard-stat-card text-center">
                        <div style="font-size:0.85rem; color:var(--text-light);">High</div>
                        <div style="font-size:1.25rem; font-weight:700; margin-top:0.4rem;">{{ $high }}</div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-2">
                    <div class="dashboard-stat-card text-center">
                        <div style="font-size:0.85rem; color:var(--text-light);">Very High</div>
                        <div style="font-size:1.25rem; font-weight:700; margin-top:0.4rem;">{{ $veryHigh }}</div>
                    </div>
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
                            <div class="col-md-2">
                                <label class="form-label mb-1">Assessment Type</label>
                                <select name="type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="DASS-42" @if(request('type')=='DASS-42') selected @endif>DASS-42</option>
                                    <option value="Academic Stress Survey" @if(request('type')=='Academic Stress Survey') selected @endif>Academic Stress Survey</option>
                                    <option value="Wellness Check" @if(request('type')=='Wellness Check') selected @endif>Wellness Check</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Risk Level</label>
                                <select name="risk" class="form-select">
                                    <option value="">All</option>
                                    <option value="low" @if(request('risk')=='low') selected @endif>Low</option>
                                    <option value="low-moderate" @if(request('risk')=='low-moderate') selected @endif>Low-Moderate</option>
                                    <option value="moderate" @if(request('risk')=='moderate') selected @endif>Moderate</option>
                                    <option value="high" @if(request('risk')=='high') selected @endif>High</option>
                                    <option value="very-high" @if(request('risk')=='very-high') selected @endif>Very High</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Date From</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-1">Date To</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1">Student Name/Email</label>
                                <input type="text" name="student" class="form-control" value="{{ request('student') }}" placeholder="Search...">
                            </div>
                            <div class="col-md-1 d-flex gap-2 filter-actions align-items-end">
                                <button type="submit" class="btn btn-primary btn-filter" title="Filter"><i class="bi bi-funnel"></i></button>
                                <a href="{{ route('counselor.assessments.index') }}" class="btn btn-outline-secondary btn-reset" title="Reset filters"><i class="bi bi-arrow-counterclockwise"></i></a>
                            </div>
                        </div>
                    </form>
                    {{-- Risk legend --}}
                    <div class="risk-legend">
                        <div class="legend-item"><span class="pill low"></span>Low</div>
                        <div class="legend-item"><span class="pill low-moderate"></span>Low-Moderate</div>
                        <div class="legend-item"><span class="pill moderate"></span>Moderate</div>
                        <div class="legend-item"><span class="pill high"></span>High</div>
                        <div class="legend-item"><span class="pill very-high"></span>Very High</div>
                    </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 w-100" id="assessments-table">
                    <colgroup>
                        <col style="width:10%;" />
                        <col style="width:15%;" />
                        <col style="width:15%;" />
                        <col style="width:20%;" />
                        <col style="width:10%;" />
                        <col style="width:10%;" />
                        <col style="width:10%;" />
                        <col style="width:10%;" />
                    </colgroup>
                    <thead class="table-light sticky-top" style="z-index:1;">
                        <tr>
                            <th class="text-center" style="width: 120px;">Type</th>
                            <th class="text-center" style="width: 170px; white-space:nowrap;">Date</th>
                            <th class="text-start" style="min-width: 160px;">Student</th>
                            <th class="text-start" style="min-width: 200px; max-width: 260px;">Email</th>
                            <th class="text-end" style="width: 110px;">Depression</th>
                            <th class="text-end" style="width: 110px;">Anxiety</th>
                            <th class="text-end" style="width: 110px;">Stress</th>
                            <!-- Total Score column removed -->
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assessments as $assessment)
                            @php 
                                $scores = is_array($assessment->score) ? $assessment->score : json_decode($assessment->score, true); 
                            @endphp
                            <tr class="align-middle">
                                <td class="text-center align-middle"><span class="badge rounded-pill bg-light text-dark border border-1">{{ $assessment->type }}</span></td>
                                <td class="text-center align-middle" style="white-space:nowrap;">{{ $assessment->created_at->format('M d, Y h:i A') }}</td>
                                <td class="text-start align-middle">
                                    @php $riskCls = strtolower($assessment->risk_level ?? 'normal'); @endphp
                                    <span class="risk-dot {{ $riskCls }}" title="{{ ucwords(str_replace('-', ' ', $assessment->risk_level ?? 'normal')) }}"></span>
                                    {{ $assessment->user->name ?? 'N/A' }}
                                </td>
                                <td class="text-start align-middle" style="max-width: 240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $assessment->user->email ?? 'N/A' }}">{{ $assessment->user->email ?? 'N/A' }}</td>
                                <!-- Risk indicator removed -->
                                @if($assessment->type === 'DASS-42')
                                    <td class="text-end align-middle"><span class="badge bg-primary">{{ $scores['depression'] ?? '-' }}</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-info text-dark">{{ $scores['anxiety'] ?? '-' }}</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-secondary">{{ $scores['stress'] ?? '-' }}</span></td>
                                @else
                                    <td class="text-end align-middle"><span class="badge bg-primary">-</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-info text-dark">-</span></td>
                                    <td class="text-end align-middle"><span class="badge bg-secondary">-</span></td>
                                @endif
                                <td class="text-center align-middle">
                                    <a href="{{ route('counselor.assessments.show', $assessment->id) }}" class="btn btn-outline-info btn-sm" style="white-space:nowrap; min-width:80px;">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">No assessment results found.</td></tr>
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
@endforeach
            </div>
        </div>
    </div>
    
    </div>
<style>
    .sticky-top { position: sticky !important; top: 0; background: #f8f9fa; }
    .table-hover tbody tr:hover { background: #f4f8fb !important; }
    .table th, .table td { vertical-align: middle !important; }
    /* Improved table responsiveness and alignment */
    .table-responsive { overflow-x: auto; }
    .table { width: 100%; table-layout: fixed; }
    /* Prevent header/body misalignment by constraining cell overflow */
    .table th, .table td { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    /* Allow wrapping for long student names on small screens */
    @media (max-width: 768px) {
        #assessments-table th:nth-child(3), #assessments-table td:nth-child(3) {
            white-space: normal;
        }
        #assessments-table th:nth-child(4), #assessments-table td:nth-child(4) {
            white-space: nowrap; max-width: 180px;
        }
    }
    .table td.text-center.align-middle, .table th.text-center { text-align: center; }
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