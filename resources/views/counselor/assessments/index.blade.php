@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1100px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="fw-bold mb-0 university-brand d-flex align-items-center gap-3">
            <i class="bi bi-clipboard-data" style="font-size: 2rem;"></i> Assessment Results
        </h1>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
    </div>

    {{-- Summary Bar --}}
    @php
        $total = $assessments->total();
        $high = $assessments->where('risk_level', 'high')->count();
        $moderate = $assessments->where('risk_level', 'moderate')->count();
        $normal = $assessments->where('risk_level', 'normal')->count();
        $dassAssessments = $assessments->where('type', 'DASS-21');
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
    <div class="row g-3 mb-3">
        <div class="col-md-3 col-6">
            <div class="card shadow-sm text-center py-3">
                <div class="fw-bold" style="font-size:1.7rem;">{{ $total }}</div>
                <div class="text-muted">Total Assessments</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm text-center py-3 border-danger border-2">
                <div class="fw-bold text-danger" style="font-size:1.7rem;"><i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $high }}</div>
                <div class="text-danger">High Risk</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm text-center py-3 border-warning border-2">
                <div class="fw-bold text-warning" style="font-size:1.7rem;"><i class="bi bi-exclamation-circle-fill me-1"></i> {{ $moderate }}</div>
                <div class="text-warning">Moderate Risk</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm text-center py-3 border-success border-2">
                <div class="fw-bold text-success" style="font-size:1.7rem;"><i class="bi bi-check-circle-fill me-1"></i> {{ $normal }}</div>
                <div class="text-success">Normal</div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label mb-1">Assessment Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
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

    <div class="card shadow-sm mb-4">
        <div class="card-body">
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
                                @if($assessment->type === 'DASS-21')
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
<div class="container mt-5">
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
                <h6 class="fw-bold mb-2">DASS-21 Subscale Averages</h6>
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
        labels: ['DASS-21', 'Academic Stress Survey', 'Wellness Check'],
        datasets: [{
            label: 'Assessments',
            data: [
                {{ $assessments->where('type', 'DASS-21')->count() }},
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