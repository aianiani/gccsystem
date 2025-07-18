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
    // Placeholder data for AI features
    $ai_emotions = $assessment->ai_emotions ?? ['Sadness', 'Anxiety']; // Example: ['Sadness', 'Anxiety']
    $ai_key_phrases = $assessment->ai_key_phrases ?? ['overwhelmed by exams', 'trouble sleeping'];
    $ai_urgent = $assessment->ai_urgent ?? false; // Example: true if crisis language detected
    $ai_summary = $assessment->ai_summary ?? 'The student is experiencing high stress due to academic workload and is feeling isolated.';
    $ai_suggested_actions = $assessment->ai_suggested_actions ?? ['Schedule a one-on-one session', 'Provide resources on stress management'];
    $ai_trend = $assessment->ai_trend ?? 'Sentiment has shifted from neutral to negative over the last 3 assessments.';
    $ai_resource = $assessment->ai_resource ?? ['title' => 'Coping with Exam Stress', 'url' => '#'];
@endphp

<div class="card shadow-lg p-4">
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
      <div class="d-flex align-items-center mb-3">
        <img src="{{ $avatarUrl }}" class="rounded-circle me-3" width="60" height="60" alt="Avatar">
        <div>
          <h4 class="mb-0">{{ $assessment->user->name ?? 'N/A' }}</h4>
          <div class="text-muted">{{ $assessment->user->email ?? 'N/A' }}</div>
        </div>
        <div class="ms-auto text-end">
          <span class="badge bg-light text-dark">{{ $assessment->type }}</span>
          <div class="text-muted small">{{ $assessment->created_at->format('M d, Y h:i A') }}</div>
        </div>
      </div>
      <div class="mb-3">
        @if($assessment->risk_level==='high')
          <span class="badge bg-danger fs-5"><i class="bi bi-exclamation-triangle-fill"></i> High Risk</span>
        @elseif($assessment->risk_level==='moderate')
          <span class="badge bg-warning text-dark fs-5"><i class="bi bi-exclamation-circle-fill"></i> Moderate Risk</span>
        @else
          <span class="badge bg-success fs-5"><i class="bi bi-check-circle-fill"></i> Normal</span>
        @endif
        <span class="ms-2 text-muted small" data-bs-toggle="tooltip" title="Risk is based on assessment scores.">What does this mean?</span>
      </div>
      <div class="row mb-3">
        @if($assessment->type === 'DASS-21')
          <div class="col">
            <div class="fw-bold">Depression</div>
            <div class="progress mb-1" style="height: 8px;">
              <div class="progress-bar bg-primary" style="width: {{ isset($scores['depression']) ? min($scores['depression']/42*100,100) : 0 }}%"></div>
            </div>
            <span>{{ $scores['depression'] ?? '-' }}/42</span>
          </div>
          <div class="col">
            <div class="fw-bold">Anxiety</div>
            <div class="progress mb-1" style="height: 8px;">
              <div class="progress-bar bg-info" style="width: {{ isset($scores['anxiety']) ? min($scores['anxiety']/42*100,100) : 0 }}%"></div>
            </div>
            <span>{{ $scores['anxiety'] ?? '-' }}/42</span>
          </div>
          <div class="col">
            <div class="fw-bold">Stress</div>
            <div class="progress mb-1" style="height: 8px;">
              <div class="progress-bar bg-secondary" style="width: {{ isset($scores['stress']) ? min($scores['stress']/42*100,100) : 0 }}%"></div>
            </div>
            <span>{{ $scores['stress'] ?? '-' }}/42</span>
          </div>
        @else
          <div class="col">
            <div class="fw-bold">Total Score</div>
            <div class="progress mb-1" style="height: 8px;">
              <div class="progress-bar bg-primary" style="width: {{ $max > 0 ? min($total/$max*100,100) : 0 }}%"></div>
            </div>
            <span>{{ $total }}/{{ $max }}</span>
          </div>
        @endif
      </div>
      <!-- Enhanced AI Insights Section -->
      <div class="mb-3">
        <div class="fw-bold mb-1">AI Insights <i class="bi bi-robot"></i></div>
        <div class="card mb-2 p-3 bg-light border-0">
          <!-- Urgent Alert -->
          @if($ai_urgent)
            <div class="alert alert-danger mb-2"><i class="bi bi-exclamation-octagon me-1"></i> <strong>Urgent:</strong> Language indicating possible crisis detected. Please review immediately.</div>
          @endif
          <!-- Sentiment & Emotions -->
          <div class="mb-2">
            @if($assessment->ai_sentiment)
              <span class="badge 
                @if($assessment->ai_sentiment === 'positive') bg-success
                @elseif($assessment->ai_sentiment === 'negative') bg-danger
                @else bg-secondary @endif
                me-2">
                <i class="bi 
                  @if($assessment->ai_sentiment === 'positive') bi-emoji-smile
                  @elseif($assessment->ai_sentiment === 'negative') bi-emoji-frown
                  @else bi-emoji-neutral @endif
                "></i>
                {{ ucfirst($assessment->ai_sentiment) }}
              </span>
            @endif
            @if(!empty($ai_emotions))
              @foreach($ai_emotions as $emotion)
                <span class="badge bg-info text-dark me-1" data-bs-toggle="tooltip" title="Detected emotion">{{ $emotion }}</span>
              @endforeach
            @endif
          </div>
          <!-- AI Summary -->
          <div class="mb-2">
            <strong>AI Summary:</strong> <span class="text-muted">{{ $ai_summary }}</span>
          </div>
          <!-- Key Phrases -->
          @if(!empty($ai_key_phrases))
            <div class="mb-2">
              <strong>Key Topics:</strong>
              @foreach($ai_key_phrases as $phrase)
                <span class="badge bg-secondary me-1">{{ $phrase }}</span>
              @endforeach
            </div>
          @endif
          <!-- Suggested Actions -->
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
          <!-- Trend Analysis -->
          <div class="mb-2">
            <strong>Trend:</strong> <span class="text-muted">{{ $ai_trend }}</span>
          </div>
          <!-- Resource Recommendation -->
          @if(!empty($ai_resource['title']))
            <div class="mb-2">
              <strong>Recommended Resource:</strong> <a href="{{ $ai_resource['url'] }}" target="_blank">{{ $ai_resource['title'] }}</a>
            </div>
          @endif
          <!-- Student Comment -->
          @if($assessment->student_comment)
            <blockquote class="blockquote mt-2 p-2 bg-white border-start border-4 border-info">
              <p class="mb-0">{{ $assessment->student_comment }}</p>
            </blockquote>
          @endif
        </div>
      </div>
      <div class="d-flex justify-content-end gap-2">
        <button class="btn btn-outline-primary"><i class="bi bi-download"></i> Download</button>
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
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
          @if($assessment->ai_sentiment === 'negative')
            <li>Review the student's comment for signs of distress and consider additional support or intervention.</li>
          @elseif($assessment->ai_sentiment === 'neutral')
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
</style> 