<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Assessment Summary</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #222; }
        .header { border-bottom: 2px solid #237728; margin-bottom: 20px; padding-bottom: 10px; }
        .section { margin-bottom: 18px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-right: 4px; }
        .bg-danger { background: #dc3545; color: #fff; }
        .bg-warning { background: #ffc107; color: #222; }
        .bg-success { background: #198754; color: #fff; }
        .bg-info { background: #0dcaf0; color: #222; }
        .bg-secondary { background: #6c757d; color: #fff; }
        .title { color: #237728; font-size: 22px; font-weight: bold; }
        .subtitle { color: #555; font-size: 16px; font-weight: bold; margin-bottom: 6px; }
        ul, ol { margin: 0 0 0 18px; }
        .mb-1 { margin-bottom: 6px; }
        .mb-2 { margin-bottom: 12px; }
        .mb-3 { margin-bottom: 18px; }
        .border-box { border: 1px solid #e0e0e0; border-radius: 6px; padding: 10px; margin-bottom: 12px; }
        .small { font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Assessment Summary</div>
        <div><strong>Student:</strong> {{ $assessment->user->name ?? 'N/A' }} ({{ $assessment->user->email ?? 'N/A' }})</div>
        <div><strong>Assessment Type:</strong> {{ $assessment->type }}</div>
        <div><strong>Date:</strong> {{ $assessment->created_at->format('M d, Y h:i A') }}</div>
        <div><strong>Risk Level:</strong>
            @if($assessment->risk_level==='high')
                <span class="badge bg-danger">High</span>
            @elseif($assessment->risk_level==='moderate')
                <span class="badge bg-warning">Moderate</span>
            @else
                <span class="badge bg-success">Normal</span>
            @endif
        </div>
    </div>

    <div class="section">
        <div class="subtitle">Scores & Interpretation</div>
        @if($assessment->type === 'DASS-42')
            <div class="mb-1"><strong>Depression:</strong> {{ $scores['depression'] ?? '-' }} <span class="badge {{ ($score_interpretation['depression'] ?? '') === 'Severe' || ($score_interpretation['depression'] ?? '') === 'Extremely Severe' ? 'bg-danger' : (($score_interpretation['depression'] ?? '') === 'Moderate' ? 'bg-warning' : (($score_interpretation['depression'] ?? '') === 'Mild' ? 'bg-info' : 'bg-success')) }}">{{ $score_interpretation['depression'] ?? '' }}</span></div>
            <div class="mb-1"><strong>Anxiety:</strong> {{ $scores['anxiety'] ?? '-' }} <span class="badge {{ ($score_interpretation['anxiety'] ?? '') === 'Severe' || ($score_interpretation['anxiety'] ?? '') === 'Extremely Severe' ? 'bg-danger' : (($score_interpretation['anxiety'] ?? '') === 'Moderate' ? 'bg-warning' : (($score_interpretation['anxiety'] ?? '') === 'Mild' ? 'bg-info' : 'bg-success')) }}">{{ $score_interpretation['anxiety'] ?? '' }}</span></div>
            <div class="mb-1"><strong>Stress:</strong> {{ $scores['stress'] ?? '-' }} <span class="badge {{ ($score_interpretation['stress'] ?? '') === 'Severe' || ($score_interpretation['stress'] ?? '') === 'Extremely Severe' ? 'bg-danger' : (($score_interpretation['stress'] ?? '') === 'Moderate' ? 'bg-warning' : (($score_interpretation['stress'] ?? '') === 'Mild' ? 'bg-info' : 'bg-success')) }}">{{ $score_interpretation['stress'] ?? '' }}</span></div>
        @else
            <div class="mb-1"><strong>Total Score:</strong> {{ $graph_data['scores'][0] ?? '-' }} / {{ $graph_data['max'] ?? '-' }} <span class="badge bg-info">{{ $graph_data['score_level'] ?? '' }}</span></div>
        @endif
    </div>

    <div class="section">
        <div class="subtitle">Student Comment</div>
        @if($assessment->student_comment)
            <div class="border-box">{{ $assessment->student_comment }}</div>
        @else
            <div class="text-muted">No comment provided</div>
        @endif
    </div>

    <div class="section">
        <div class="subtitle">Case Management Notes</div>
        <div style="min-height: 60px; border: 1px dashed #aaa; padding: 8px;">
            {{ $assessment->case_notes ?? '' }}
        </div>
    </div>
</body>
</html> 