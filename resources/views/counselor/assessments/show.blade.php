@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 950px;">
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h2 class="fw-bold mb-0 d-flex align-items-center gap-2 university-brand">
                <i class="bi bi-clipboard-data"></i> Assessment Summary
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('counselor.assessments.index') }}" class="btn btn-outline-secondary shadow-sm"><i class="bi bi-arrow-left"></i> Back to List</a>
            </div>
        </div>
        <div class="row g-2 mb-2">
            <div class="col-md-4 col-6">
                <div class="card shadow-sm text-center py-2 border-0 bg-light">
                    <div class="fw-bold" style="font-size:1.2rem;">{{ $assessment->type }}</div>
                    <div class="text-muted small">Assessment Type</div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="card shadow-sm text-center py-2 border-0 bg-light">
                    <div class="fw-bold" style="font-size:1.2rem;">{{ $assessment->created_at->format('M d, Y h:i A') }}</div>
                    <div class="text-muted small">Date Taken</div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card shadow-sm text-center py-2 border-0 bg-light">
                    @if($assessment->risk_level==='high')
                        <span class="badge bg-danger fs-6"><i class="bi bi-exclamation-triangle-fill"></i> High Risk</span>
                    @elseif($assessment->risk_level==='moderate')
                        <span class="badge bg-warning text-dark fs-6"><i class="bi bi-exclamation-circle-fill"></i> Moderate Risk</span>
                    @else
                        <span class="badge bg-success fs-6"><i class="bi bi-check-circle-fill"></i> Normal</span>
                    @endif
                    <div class="text-muted small">Risk Level</div>
                </div>
            </div>
        </div>
    </div>
    @php
        $studentName = $assessment->user->name ?? 'Student';
        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($studentName) . '&background=0D8ABC&color=fff';
        if ($assessment->type === 'Academic Stress Survey') {
            $max = 45;
            $total = is_array($assessment->score) ? ($assessment->score['score'] ?? 0) : (is_numeric($assessment->score) ? $assessment->score : 0);
        } elseif ($assessment->type === 'Wellness Check') {
            $max = 36;
            $total = is_array($assessment->score) ? ($assessment->score['score'] ?? 0) : (is_numeric($assessment->score) ? $assessment->score : 0);
        } else {
            $max = 0; // Not used for DASS-21
            $total = 0;
        }
    @endphp
    <div class="card shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('counselor.assessments.export', $assessment->id) }}" class="btn btn-outline-primary" target="_blank">
                <i class="bi bi-printer"></i> Export/Print Summary
            </a>
        </div>
        <div class="d-flex align-items-center mb-4 gap-3 flex-wrap">
            <img src="{{ $avatarUrl }}" class="rounded-circle border border-3" width="80" height="80" alt="Avatar">
            <div class="flex-grow-1">
                <h3 class="fw-bold mb-1" style="color:#2d5016;">{{ $assessment->user->name ?? 'N/A' }}</h3>
                <div class="text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $assessment->user->email ?? '' }}</div>
                <span class="badge bg-primary">Student</span>
            </div>
        </div>
        <ul class="nav nav-tabs mb-3" id="assessmentSummaryTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summaryTab" type="button" role="tab" aria-controls="summaryTab" aria-selected="true">Summary</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="suggestions-tab" data-bs-toggle="tab" data-bs-target="#suggestionsTab" type="button" role="tab" aria-controls="suggestionsTab" aria-selected="false">Suggestions</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="graphs-tab" data-bs-toggle="tab" data-bs-target="#graphsTab" type="button" role="tab" aria-controls="graphsTab" aria-selected="false">Graphs</button>
            </li>
        </ul>
        <div class="tab-content" id="assessmentSummaryTabsContent">
            <!-- Summary Tab -->
            <div class="tab-pane fade show active" id="summaryTab" role="tabpanel" aria-labelledby="summary-tab">
                <div class="row mb-4 g-3">
                    @if($assessment->type === 'DASS-42' || $assessment->type === 'DASS-21')
                        <div class="col-md-4">
                            <div class="card shadow-sm p-3 h-100">
                                <div class="fw-bold mb-1">Depression</div>
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar bg-primary" style="width: {{ isset($scores['depression']) ? min($scores['depression']/42*100,100) : 0 }}%"></div>
                                </div>
                                <span class="fw-bold">{{ $scores['depression'] ?? '-' }}/42</span>
                                @if(isset($score_interpretation['depression']))
                                    <div class="mt-1">
                                        <span class="badge 
                                            @if($score_interpretation['depression'] === 'Extremely Severe' || $score_interpretation['depression'] === 'Severe') bg-danger
                                            @elseif($score_interpretation['depression'] === 'Moderate') bg-warning text-dark
                                            @elseif($score_interpretation['depression'] === 'Mild') bg-info text-dark
                                            @else bg-success @endif">
                                            {{ $score_interpretation['depression'] }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm p-3 h-100">
                                <div class="fw-bold mb-1">Anxiety</div>
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar bg-info" style="width: {{ isset($scores['anxiety']) ? min($scores['anxiety']/42*100,100) : 0 }}%"></div>
                                </div>
                                <span class="fw-bold">{{ $scores['anxiety'] ?? '-' }}/42</span>
                                @if(isset($score_interpretation['anxiety']))
                                    <div class="mt-1">
                                        <span class="badge 
                                            @if($score_interpretation['anxiety'] === 'Extremely Severe' || $score_interpretation['anxiety'] === 'Severe') bg-danger
                                            @elseif($score_interpretation['anxiety'] === 'Moderate') bg-warning text-dark
                                            @elseif($score_interpretation['anxiety'] === 'Mild') bg-info text-dark
                                            @else bg-success @endif">
                                            {{ $score_interpretation['anxiety'] }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm p-3 h-100">
                                <div class="fw-bold mb-1">Stress</div>
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar bg-secondary" style="width: {{ isset($scores['stress']) ? min($scores['stress']/42*100,100) : 0 }}%"></div>
                                </div>
                                <span class="fw-bold">{{ $scores['stress'] ?? '-' }}/42</span>
                                @if(isset($score_interpretation['stress']))
                                    <div class="mt-1">
                                        <span class="badge 
                                            @if($score_interpretation['stress'] === 'Extremely Severe' || $score_interpretation['stress'] === 'Severe') bg-danger
                                            @elseif($score_interpretation['stress'] === 'Moderate') bg-warning text-dark
                                            @elseif($score_interpretation['stress'] === 'Mild') bg-info text-dark
                                            @else bg-success @endif">
                                            {{ $score_interpretation['stress'] }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="card shadow-sm p-3 h-100">
                                <div class="fw-bold mb-1">Total Score</div>
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $max > 0 ? min($total/$max*100,100) : 0 }}%"></div>
                                </div>
                                <span class="fw-bold">{{ $total }}/{{ $max }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- AI Insights Section (Sentiment Only) -->
                <div class="mb-3">
                    <div class="fw-bold mb-2 fs-5"><i class="bi bi-robot me-1"></i>AI Insights</div>
                    <div class="card mb-2 p-3 bg-light border-0 shadow-sm">
                        {{-- Sentiment Badge --}}
                        <div class="mb-2">
                            @if($ai_sentiment === 'positive')
                                <span class="badge bg-success"><i class="bi bi-emoji-smile"></i> Positive Sentiment</span>
                            @elseif($ai_sentiment === 'negative')
                                <span class="badge bg-danger"><i class="bi bi-emoji-frown"></i> Negative Sentiment</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-emoji-neutral"></i> Neutral Sentiment</span>
                            @endif
                        </div>
                        {{-- Mini-Graph --}}
                        @if(isset($graph_data['labels']) && count($graph_data['labels']) > 1)
                            <div class="mb-3">
                                <canvas id="aiMiniGraph" height="120"></canvas>
                            </div>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                new Chart(document.getElementById('aiMiniGraph').getContext('2d'), {
                                    type: 'bar',
                                    data: {
                                        labels: {!! json_encode($graph_data['labels']) !!},
                                        datasets: [{
                                            label: 'Score',
                                            data: {!! json_encode($graph_data['scores']) !!},
                                            backgroundColor: ['#0d6efd', '#0dcaf0', '#6c757d']
                                        }]
                                    },
                                    options: {
                                        plugins: { legend: { display: false } },
                                        scales: { y: { beginAtZero: true, max: 42 } }
                                    }
                                });
                            </script>
                        @endif
                        {{-- Severity Badges --}}
                        @if(isset($score_interpretation) && count($score_interpretation))
                            <div class="mb-2">
                                @foreach($score_interpretation as $label => $severity)
                                    <span class="badge 
                                        @if($severity === 'Extremely Severe' || $severity === 'Severe') bg-danger
                                        @elseif($severity === 'Moderate') bg-warning text-dark
                                        @elseif($severity === 'Mild') bg-info text-dark
                                        @else bg-success @endif
                                        me-1">
                                        {{ ucfirst($label) }}: {{ $severity }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        {{-- AI Summary --}}
                        <div class="mb-2">
                            <strong>AI Summary:</strong> <span class="text-muted">{{ $ai_summary }}</span>
                        </div>
                        {{-- Percentile --}}
                        @if(isset($percentile))
                            <div class="mb-2">
                                <strong>Percentile:</strong>
                                <span class="badge bg-info text-dark">{{ round($percentile) }}th percentile</span>
                                <span class="text-muted">({{ $percentile > 50 ? 'Higher' : 'Lower' }} than most students)</span>
                            </div>
                        @endif
                        {{-- Trend --}}
                        @if(isset($trend))
                            <div class="mb-2">
                                <strong>Trend:</strong>
                                <span class="badge {{ $trend > 0 ? 'bg-danger' : ($trend < 0 ? 'bg-success' : 'bg-secondary') }}">
                                    {{ $trend > 0 ? '+' : '' }}{{ $trend }}
                                </span>
                                <span class="text-muted">
                                    {{ $trend > 0 ? 'Score increased (worsening)' : ($trend < 0 ? 'Score decreased (improving)' : 'No change') }} since last assessment
                                </span>
                            </div>
                        @endif
                        {{-- Per-question Analysis --}}
                        @if(!empty($redFlags))
                            <div class="mb-2">
                                <strong>Areas of Concern:</strong>
                                <ul>
                                    @foreach($redFlags as $flag)
                                        <li>{{ $flag }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(!empty($strengths))
                            <div class="mb-2">
                                <strong>Strengths:</strong>
                                <ul>
                                    @foreach($strengths as $strength)
                                        <li>{{ $strength }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Suggestions --}}
                        @if(!empty($ai_suggested_actions))
                            <div class="mb-2">
                                <strong>AI Suggested Actions:</strong>
                                <ul class="mb-1">
                                    @foreach($ai_suggested_actions as $action)
                                        <li>{{ $action }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Dynamic Resource Recommendations --}}
                        @if(!empty($dynamicResources))
                            <div class="mb-2">
                                <strong>Recommended Resources (Personalized):</strong>
                                <ul class="mb-1">
                                    @foreach($dynamicResources as $res)
                                        <li><a href="{{ $res['url'] }}" target="_blank">{{ $res['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- Action Plan --}}
                        @if(!empty($actionPlan))
                            <div class="mb-2">
                                <strong>Action Plan:</strong>
                                <ol class="mb-1">
                                    @foreach($actionPlan as $step)
                                        <li>{{ $step }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                        {{-- Resource Recommendation --}}
                        @if(!empty($ai_resource['title']))
                            <div class="mb-2">
                                <strong>Recommended Resource:</strong>
                                <a href="{{ $ai_resource['url'] }}" target="_blank">{{ $ai_resource['title'] }}</a>
                                <a href="/files/self-help-guide.pdf" class="btn btn-sm btn-outline-primary ms-2" download>
                                    <i class="bi bi-download"></i> Download PDF
                                </a>
                            </div>
                        @endif
                        {{-- Student Comment --}}
                        @if($assessment->student_comment)
                            <blockquote class="blockquote mt-2 p-2 bg-white border-start border-4 border-info">
                                <p class="mb-0">{{ $assessment->student_comment }}</p>
                            </blockquote>
                        @endif
                    </div>
                </div>
                <form method="POST" action="{{ route('counselor.assessments.saveNotes', $assessment->id) }}">
    @csrf
    <div class="mb-2">
        <label for="case_notes" class="form-label fw-bold">Case Management Notes</label>
        <textarea name="case_notes" id="case_notes" rows="4" class="form-control mb-2">{{ old('case_notes', $assessment->case_notes ?? '') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save Notes</button>
</form>
            </div>
            <!-- Suggestions Tab -->
            <div class="tab-pane fade" id="suggestionsTab" role="tabpanel" aria-labelledby="suggestions-tab">
                <div class="p-3">
                    <h5 class="fw-bold mb-3"><i class="bi bi-lightbulb me-2"></i>Actionable Suggestions</h5>
                    <ul>
                        @if($assessment->risk_level === 'high')
                            <li>Immediate follow-up is recommended for this student due to <span class="fw-bold text-danger">High Risk</span> status.</li>
                        @elseif($assessment->risk_level === 'moderate')
                            <li>Monitor this student closely and consider scheduling a check-in session.</li>
                        @else
                            <li>This student is currently at <span class="fw-bold text-success">Normal</span> risk. Continue regular monitoring.</li>
                        @endif
                        @if($ai_sentiment === 'neg')
                            <li>Review the student's comment for signs of distress and consider additional support or intervention.</li>
                        @elseif($ai_sentiment === 'neu')
                            <li>Encourage the student to share more about their experience in future assessments.</li>
                        @endif
                        @if($assessment->type === 'DASS-21')
                            <li>Review subscale scores for targeted intervention (Depression, Anxiety, Stress).</li>
                        @else
                            <li>Encourage completion of DASS-21 for a more comprehensive mental health profile.</li>
                        @endif
                    </ul>
                </div>
            </div>
            <!-- Graphs Tab -->
            <div class="tab-pane fade" id="graphsTab" role="tabpanel" aria-labelledby="graphs-tab">
                <div class="p-3">
                    <h5 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2"></i>Assessment Graphs</h5>
                    <div class="row">
                        @if($assessment->type === 'DASS-21')
                            <div class="col-md-6 mb-3">
                                <canvas id="dass21SubscaleChart-{{ $assessment->id }}" height="180"></canvas>
                            </div>
                        @else
                            <div class="col-md-6 mb-3">
                                <canvas id="totalScoreChart-{{ $assessment->id }}" height="180"></canvas>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <canvas id="riskLevelChart-{{ $assessment->id }}" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// DASS-21 Subscale Chart
@if($assessment->type === 'DASS-21')
  new Chart(document.getElementById('dass21SubscaleChart-{{ $assessment->id }}').getContext('2d'), {
    type: 'bar',
    data: {
      labels: ['Depression', 'Anxiety', 'Stress'],
      datasets: [{
        label: 'Score',
        data: [{{ $scores['depression'] ?? 0 }}, {{ $scores['anxiety'] ?? 0 }}, {{ $scores['stress'] ?? 0 }}],
        backgroundColor: ['#0d6efd', '#0dcaf0', '#6c757d']
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, max: 42 } }
    }
  });
@else
  new Chart(document.getElementById('totalScoreChart-{{ $assessment->id }}').getContext('2d'), {
    type: 'bar',
    data: {
      labels: ['Total Score'],
      datasets: [{
        label: 'Score',
        data: [{{ $total }}],
        backgroundColor: ['#0d6efd']
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, max: {{ $max }} } }
    }
  });
@endif
// Risk Level Pie Chart
new Chart(document.getElementById('riskLevelChart-{{ $assessment->id }}').getContext('2d'), {
  type: 'doughnut',
  data: {
    labels: ['High', 'Moderate', 'Normal'],
    datasets: [{
      data: [
        {{ $assessment->risk_level === 'high' ? 1 : 0 }},
        {{ $assessment->risk_level === 'moderate' ? 1 : 0 }},
        {{ $assessment->risk_level === 'normal' ? 1 : 0 }}
      ],
      backgroundColor: ['#dc3545', '#ffc107', '#198754']
    }]
  },
  options: {
    plugins: { legend: { position: 'bottom' } }
  }
});
</script>
<style>
    .nav-tabs .nav-link.active {
        background-color: #f8f9fa;
        border-color: #dee2e6 #dee2e6 #fff;
    }
    .tab-content > .tab-pane {
        min-height: 200px;
    }
    .university-brand {
        color: #237728;
        letter-spacing: 1px;
    }
    .card {
        border-radius: 1rem;
    }
    .progress {
        background: #e9ecef;
    }
    .badge.bg-primary {
        background-color: #237728 !important;
    }
</style>
@endsection 