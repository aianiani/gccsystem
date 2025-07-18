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
        @if($assessment->type === 'DASS-21')
            <div class="mb-1"><strong>Depression:</strong> {{ $scores['depression'] ?? '-' }} <span class="badge {{ ($score_interpretation['depression'] ?? '') === 'Severe' || ($score_interpretation['depression'] ?? '') === 'Extremely Severe' ? 'bg-danger' : (($score_interpretation['depression'] ?? '') === 'Moderate' ? 'bg-warning' : (($score_interpretation['depression'] ?? '') === 'Mild' ? 'bg-info' : 'bg-success')) }}">{{ $score_interpretation['depression'] ?? '' }}</span></div>
            <div class="mb-1"><strong>Anxiety:</strong> {{ $scores['anxiety'] ?? '-' }} <span class="badge {{ ($score_interpretation['anxiety'] ?? '') === 'Severe' || ($score_interpretation['anxiety'] ?? '') === 'Extremely Severe' ? 'bg-danger' : (($score_interpretation['anxiety'] ?? '') === 'Moderate' ? 'bg-warning' : (($score_interpretation['anxiety'] ?? '') === 'Mild' ? 'bg-info' : 'bg-success')) }}">{{ $score_interpretation['anxiety'] ?? '' }}</span></div>
            <div class="mb-1"><strong>Stress:</strong> {{ $scores['stress'] ?? '-' }} <span class="badge {{ ($score_interpretation['stress'] ?? '') === 'Severe' || ($score_interpretation['stress'] ?? '') === 'Extremely Severe' ? 'bg-danger' : (($score_interpretation['stress'] ?? '') === 'Moderate' ? 'bg-warning' : (($score_interpretation['stress'] ?? '') === 'Mild' ? 'bg-info' : 'bg-success')) }}">{{ $score_interpretation['stress'] ?? '' }}</span></div>
        @else
            <div class="mb-1"><strong>Total Score:</strong> {{ $graph_data['scores'][0] ?? '-' }} / {{ $graph_data['max'] ?? '-' }} <span class="badge bg-info">{{ $graph_data['score_level'] ?? '' }}</span></div>
        @endif
    </div>

    <div class="section">
        <div class="subtitle">AI Insights</div>
        <div class="mb-1"><strong>AI Summary:</strong> {{ $ai_summary }}</div>
        @if(isset($percentile))
            <div class="mb-1"><strong>Percentile:</strong> {{ round($percentile) }}th percentile <span class="small">({{ $percentile > 50 ? 'Higher' : 'Lower' }} than most students)</span></div>
        @endif
        @if(isset($trend))
            <div class="mb-1"><strong>Trend:</strong> <span class="badge {{ $trend > 0 ? 'bg-danger' : ($trend < 0 ? 'bg-success' : 'bg-secondary') }}">{{ $trend > 0 ? '+' : '' }}{{ $trend }}</span> <span class="small">{{ $trend > 0 ? 'Score increased (worsening)' : ($trend < 0 ? 'Score decreased (improving)' : 'No change') }} since last assessment</span></div>
        @endif
        @if(!empty($redFlags))
            <div class="mb-1"><strong>Areas of Concern:</strong> {{ implode(', ', $redFlags) }}</div>
        @endif
        @if(!empty($strengths))
            <div class="mb-1"><strong>Strengths:</strong> {{ implode(', ', $strengths) }}</div>
        @endif
        @if(!empty($ai_suggested_actions))
            <div class="mb-1"><strong>AI Suggested Actions:</strong>
                <ul>
                    @foreach($ai_suggested_actions as $action)
                        <li>{{ $action }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(!empty($dynamicResources))
            <div class="mb-1"><strong>Recommended Resources (Personalized):</strong>
                <ul>
                    @foreach($dynamicResources as $res)
                        <li>{{ $res['title'] }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(!empty($actionPlan))
            <div class="mb-1"><strong>Action Plan:</strong>
                <ol>
                    @foreach($actionPlan as $step)
                        <li>{{ $step }}</li>
                    @endforeach
                </ol>
            </div>
        @endif
        @if($assessment->student_comment)
            <div class="mb-1"><strong>Student Comment:</strong> {{ $assessment->student_comment }}</div>
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