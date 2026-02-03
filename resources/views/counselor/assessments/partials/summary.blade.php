@php
  $studentName = $assessment->user->name ?? 'Student';
  $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($studentName) . '&background=0D8ABC&color=fff&rounded=true&size=128';
  // Compatibility: accept both array and json score
  $scores = is_array($assessment->score) ? $assessment->score : (is_string($assessment->score) ? json_decode($assessment->score, true) : []);
  // Risk label and color map (matches index view)
  $risk = strtolower($assessment->risk_level ?? 'low');
  $riskLabel = ucwords(str_replace('-', ' ', $risk));
  $riskColors = [
    'low' => '#4caf50',
    'low-moderate' => '#ffb300',
    'moderate' => '#f39c12',
    'high' => '#e74c3c',
    'very-high' => '#8b1e3f',
  ];
  $riskColor = $riskColors[$risk] ?? '#6c757d';

  // Small helper to map DASS numeric score to severity label
  $severityLabel = function ($s) {
    $s = intval($s);
    if ($s <= 9)
      return 'Normal';
    if ($s <= 13)
      return 'Mild';
    if ($s <= 20)
      return 'Moderate';
    if ($s <= 27)
      return 'Severe';
    return 'Extremely Severe';
  };
  // Subscale-specific severity helpers (use correct thresholds per subscale)
  $severityDep = function ($s) {
    $s = intval($s);
    return $s >= 28 ? 'Extremely Severe' : ($s >= 21 ? 'Severe' : ($s >= 14 ? 'Moderate' : ($s >= 10 ? 'Mild' : 'Normal')));
  };
  $severityAnx = function ($s) {
    $s = intval($s);
    return $s >= 20 ? 'Extremely Severe' : ($s >= 15 ? 'Severe' : ($s >= 10 ? 'Moderate' : ($s >= 8 ? 'Mild' : 'Normal')));
  };
  $severityStr = function ($s) {
    $s = intval($s);
    return $s >= 34 ? 'Extremely Severe' : ($s >= 26 ? 'Severe' : ($s >= 19 ? 'Moderate' : ($s >= 15 ? 'Mild' : 'Normal')));
  };
  $createdAt = $assessment->created_at ? $assessment->created_at->format('M d, Y h:i A') : '';
  // compact student meta (only show when present and not placeholder '-')
  $course = $assessment->user->course ?? null;
  $year = $assessment->user->year ?? null;
  $sex = $assessment->user->sex ?? null;
  $metaParts = [];
  foreach ([$course, $year, $sex] as $p) {
    if ($p && $p !== '-' && trim((string) $p) !== '')
      $metaParts[] = $p;
  }
  $metaString = count($metaParts) ? implode(' • ', $metaParts) : null;
  // Normalize stored scores to per-question answers (1..42) for consistent computation
  $studentAnswers = [];
  if (!empty($scores) && is_array($scores)) {
    // Only run normalization if 0-based index is present
    if (isset($scores[0])) {
      foreach ($scores as $k => $v) {
        if (is_numeric($k)) {
          $ik = (int) $k;
          if ($ik >= 0 && $ik <= 41) {
            $studentAnswers[$ik + 1] = (int) $v;
            continue;
          }
        }
        $studentAnswers[$k] = $v;
      }
    } else {
      // Already 1-based (or non-numeric keys), just copy
      $studentAnswers = $scores;
    }
  }

  // DASS-42 group items (1-indexed)
  $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
  $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
  $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];

  // Compute totals from per-item answers so summary and score sheet match
  $depressionTotal = 0;
  $anxietyTotal = 0;
  $stressTotal = 0;
  foreach ($depressionItems as $it) {
    $depressionTotal += (int) ($studentAnswers[$it] ?? 0);
  }
  foreach ($anxietyItems as $it) {
    $anxietyTotal += (int) ($studentAnswers[$it] ?? 0);
  }
  foreach ($stressItems as $it) {
    $stressTotal += (int) ($studentAnswers[$it] ?? 0);
  }
@endphp




<ul class="nav nav-tabs mb-4 px-2" id="assessmentTabs-{{ $assessment->id }}" role="tablist"
  style="border-bottom: 2px solid #f0f0f0;">
  <li class="nav-item" role="presentation">
    <button class="nav-link active fw-bold" id="details-tab-{{ $assessment->id }}" data-bs-toggle="tab"
      data-bs-target="#details-{{ $assessment->id }}" type="button" role="tab"
      aria-controls="details-{{ $assessment->id }}" aria-selected="true"><i
        class="bi bi-bar-chart-fill me-2"></i>Results Overview</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-bold" id="score-tab-{{ $assessment->id }}" data-bs-toggle="tab"
      data-bs-target="#score-{{ $assessment->id }}" type="button" role="tab" aria-controls="score-{{ $assessment->id }}"
      aria-selected="false"><i class="bi bi-table me-2"></i>Score
      Sheet</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-bold" id="insights-tab-{{ $assessment->id }}" data-bs-toggle="tab"
      data-bs-target="#insights-{{ $assessment->id }}" type="button" role="tab"
      aria-controls="insights-{{ $assessment->id }}" aria-selected="false"><i
        class="bi bi-lightbulb-fill me-2"></i>Insights & Notes</button>
  </li>
</ul>

<div class="tab-content" id="assessmentTabsContent-{{ $assessment->id }}">
  <div class="tab-pane fade show active" id="details-{{ $assessment->id }}" role="tabpanel"
    aria-labelledby="details-tab-{{ $assessment->id }}">

    @if($assessment->type === 'DASS-42')
      <!-- DASS-42 Visuals -->
      <div class="row g-4 mb-4">
        @php
          $dep = $depressionTotal;
          $anx = $anxietyTotal;
          $str = $stressTotal;
          $depSev = $severityDep($dep);
          $anxSev = $severityAnx($anx);
          $strSev = $severityStr($str);

          $getSevColor = function ($sev) {
            if (str_contains($sev, 'Extremely'))
              return '#8b1e3f'; // Very High
            if ($sev === 'Severe')
              return '#dc3545'; // Red
            if ($sev === 'Moderate')
              return '#fd7e14'; // Orange
            if ($sev === 'Mild')
              return '#ffc107'; // Yellow
            return '#198754'; // Green
          };
         @endphp

        <!-- Depression Card -->
        <div class="col-md-4">
          <div class="content-card h-100 text-center p-3">
            <div class="mb-2">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background: #e7f1ff; color: #0d6efd;">
                <i class="bi bi-emoji-frown fs-5"></i>
              </div>
            </div>
            <div class="fw-bold text-muted small text-uppercase mb-1">Depression</div>
            <div class="h2 fw-bold mb-1" style="color: #0d6efd;">{{ $dep }}</div>
            <span class="badge rounded-pill px-2 py-1 small" style="background-color: #0d6efd;">{{ $depSev }}</span>
          </div>
        </div>

        <!-- Anxiety Card -->
        <div class="col-md-4">
          <div class="content-card h-100 text-center p-3">
            <div class="mb-2">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background: #e0f7fa; color: #0dcaf0;">
                <i class="bi bi-lightning-charge fs-5"></i>
              </div>
            </div>
            <div class="fw-bold text-muted small text-uppercase mb-1">Anxiety</div>
            <div class="h2 fw-bold mb-1" style="color: #0dcaf0;">{{ $anx }}</div>
            <span class="badge rounded-pill px-2 py-1 small text-dark"
              style="background-color: #0dcaf0;">{{ $anxSev }}</span>
          </div>
        </div>

        <!-- Stress Card -->
        <div class="col-md-4">
          <div class="content-card h-100 text-center p-3">
            <div class="mb-2">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background: #f8f9fa; color: #6c757d;">
                <i class="bi bi-activity fs-5"></i>
              </div>
            </div>
            <div class="fw-bold text-muted small text-uppercase mb-1">Stress</div>
            <div class="h2 fw-bold mb-1" style="color: #6c757d;">{{ $str }}</div>
            <span class="badge rounded-pill px-2 py-1 small" style="background-color: #6c757d;">{{ $strSev }}</span>
          </div>
        </div>
      </div>

    @elseif($assessment->type === 'GRIT Scale')
      <!-- GRIT Scale Visuals -->
      <div class="row g-4 mb-4">
        @php
          $totalIdx = $scores['total_index'] ?? 0;
          $passionIdx = $scores['passion_index'] ?? 0;
          $perseveranceIdx = $scores['perseverance_index'] ?? 0;

          $getGritColor = function ($idx) {
            if ($idx >= 3.5)
              return '#198754'; // High Grit
            if ($idx >= 3.0)
              return '#ffb300'; // Moderate
            return '#dc3545'; // Low Grit
          };
        @endphp

        <!-- Total Grit Card -->
        <div class="col-md-4">
          <div class="content-card h-100 text-center p-3">
            <div class="mb-2">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background: #e8f5e9; color: #2e7d32;">
                <i class="bi bi-star-fill fs-5"></i>
              </div>
            </div>
            <div class="fw-bold text-muted small text-uppercase mb-1">Total Grit Score</div>
            <div class="h2 fw-bold mb-1" style="color: {{ $getGritColor($totalIdx) }};">{{ $totalIdx }}</div>
            <span class="badge rounded-pill px-2 py-1 small"
              style="background-color: {{ $getGritColor($totalIdx) }};">Index</span>
          </div>
        </div>

        <!-- Passion Card -->
        <div class="col-md-4">
          <div class="content-card h-100 text-center p-3">
            <div class="mb-2">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background: #fff8e1; color: #ffa000;">
                <i class="bi bi-heart-fill fs-5"></i>
              </div>
            </div>
            <div class="fw-bold text-muted small text-uppercase mb-1">Passion Score</div>
            <div class="h2 fw-bold mb-1" style="color: #ffa000;">{{ $passionIdx }}</div>
            <span class="badge rounded-pill px-2 py-1 small text-dark" style="background-color: #ffca28;">Index</span>
          </div>
        </div>

        <!-- Perseverance Card -->
        <div class="col-md-4">
          <div class="content-card h-100 text-center p-3">
            <div class="mb-2">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background: #e3f2fd; color: #1976d2;">
                <i class="bi bi-shield-fill-check fs-5"></i>
              </div>
            </div>
            <div class="fw-bold text-muted small text-uppercase mb-1">Perseverance Score</div>
            <div class="h2 fw-bold mb-1" style="color: #1976d2;">{{ $perseveranceIdx }}</div>
            <span class="badge rounded-pill px-2 py-1 small" style="background-color: #1976d2;">Index</span>
          </div>
        </div>
      </div>
    @elseif($assessment->type === 'Personality (NEO-FFI)')
      <!-- Personality (NEO-FFI) Visuals -->
      <div class="row g-3 mb-4">
        @php
          $domains = $scores['domains'] ?? [];
          $domainConfigs = [
            'Neuroticism' => ['color' => '#dc3545', 'icon' => 'bi-wind', 'bg' => '#fdecea'],
            'Extroversion' => ['color' => '#fd7e14', 'icon' => 'bi-people', 'bg' => '#fff4e6'],
            'Openness' => ['color' => '#0d6efd', 'icon' => 'bi-lightbulb', 'bg' => '#e7f1ff'],
            'Agreeableness' => ['color' => '#20c997', 'icon' => 'bi-hand-thumbs-up', 'bg' => '#e6fcf5'],
            'Conscientiousness' => ['color' => '#198754', 'icon' => 'bi-check-circle', 'bg' => '#eaf5ea'],
          ];
        @endphp

        @foreach($domainConfigs as $name => $conf)
          <div class="col-md-4 col-sm-6">
            <div class="content-card h-100 p-3" style="border-left: 4px solid {{ $conf['color'] }} !important;">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                  <div class="fw-bold text-muted small text-uppercase mb-0">{{ $name }}</div>
                  <div class="h3 fw-bold mb-0" style="color: {{ $conf['color'] }};">{{ $domains[$name] ?? 12 }}</div>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: {{ $conf['bg'] }}; color: {{ $conf['color'] }};">
                  <i class="bi {{ $conf['icon'] }} fs-5"></i>
                </div>
              </div>
              <div class="progress" style="height: 4px; border-radius: 2px;">
                @php $percent = (($domains[$name] ?? 12) - 12) / (84 - 12) * 100; @endphp
                <div class="progress-bar" style="width: {{ $percent }}%; background-color: {{ $conf['color'] }};"></div>
              </div>
              <div class="d-flex justify-content-between mt-1 text-muted" style="font-size: 0.65rem;">
                <span>Min: 12</span>
                <span>Max: 84</span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @elseif($assessment->type === 'Work Values Inventory')
      <!-- Work Values Inventory (WVI) Visuals -->
      <div class="row g-2 mb-4">
        @php
          $scales = $scores['scales'] ?? [];
          $getWviColor = function ($sum) {
            if ($sum >= 13)
              return '#198754'; // Very Important
            if ($sum >= 10)
              return '#20c997'; // Important
            if ($sum >= 7)
              return '#ffb300'; // Moderately
            if ($sum >= 4)
              return '#fd7e14'; // Little Importance
            return '#6c757d'; // Unimportant
          };
          $getWviLabel = function ($sum) {
            if ($sum >= 13)
              return 'Very Important';
            if ($sum >= 10)
              return 'Important';
            if ($sum >= 7)
              return 'Moderately Important';
            if ($sum >= 4)
              return 'Little Importance';
            return 'Unimportant';
          };
        @endphp

        @foreach($scales as $name => $sum)
          <div class="col-md-4 col-sm-6">
            <div class="card h-100 p-2 border-0 shadow-sm"
              style="border-left: 3px solid {{ $getWviColor($sum) }} !important; background: #fafafa;">
              <div class="d-flex justify-content-between align-items-center">
                <div style="min-width: 0;">
                  <div class="fw-bold x-small text-uppercase text-muted" style="font-size: 0.65rem;">{{ $name }}</div>
                  <div class="fw-bold" style="font-size: 1.1rem; color: {{ $getWviColor($sum) }};">{{ $sum }}</div>
                </div>
                <div class="text-end">
                  <div class="badge rounded-pill" style="background-color: {{ $getWviColor($sum) }}; font-size: 0.6rem;">
                    {{ $getWviLabel($sum) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <!-- Non-DASS Fallback -->
      <div class="content-card p-4 text-center">
        <h3 class="display-6 fw-bold text-success">{{ $scores['score'] ?? ($assessment->score ?? '-') }}</h3>
        <p class="text-muted">Total Score</p>
      </div>
    @endif


    @if($assessment->type === 'DASS-42')
      <div class="mt-4">
        @includeIf('counselor.assessments.partials.dass42_questionnaire')
      </div>
    @endif
  </div>

  <div class="tab-pane fade" id="score-{{ $assessment->id }}" role="tabpanel"
    aria-labelledby="score-tab-{{ $assessment->id }}">
    <div class="card shadow-sm p-3 dass-score-sheet">
      <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-grid-1x2 me-2"></i> {{ $assessment->type }} Score Sheet Table</h5>
      </div>
      <div class="card-body p-3">
        @includeIf('counselor.assessments.partials.score_sheet')
      </div>
      @if($assessment->type === 'DASS-42')
        <div class="card-footer bg-white border-0 pt-3">
          <div class="interpretation-guide small text-muted">
            <h6 class="fw-bold">DASS-42 Interpretation Guide</h6>
            <p class="mb-1">The DASS-42 contains three subscales:</p>
            <ul class="mb-0">
              <li><strong>Depression (14 items):</strong> 3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42</li>
              <li><strong>Anxiety (14 items):</strong> 2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41</li>
              <li><strong>Stress (14 items):</strong> 1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39</li>
            </ul>
          </div>
        </div>
      @endif
    </div>
  </div>

  <div class="tab-pane fade" id="insights-{{ $assessment->id }}" role="tabpanel"
    aria-labelledby="insights-tab-{{ $assessment->id }}">
    <div class="p-3">
      <h5 class="fw-bold mb-3"><i class="bi bi-lightbulb me-2"></i>Insights</h5>
      <div class="row g-3">
        <div class="col-12">
          <div class="card border-0 p-3 mb-3" style="background: #fff; box-shadow: 0 6px 18px rgba(0,0,0,0.04);">
            <div class="fw-semibold mb-2">Quick Suggestions</div>
            <ul class="small mb-0">
              <li>Review high-severity subscales first.</li>
              <li>Consider scheduling a follow-up session.</li>
              <li>Share resources for self-care and crisis lines if needed.</li>
            </ul>
          </div>
        </div>

        <div class="col-12">
          <div class="card shadow-sm p-3 mb-3">
            <h6 class="fw-bold"><i class="bi bi-chat-left-text me-2"></i>Student Comment</h6>
            <div class="p-3 bg-light rounded border">
              @if($assessment->student_comment)
                <p class="mb-0 small">{{ $assessment->student_comment }}</p>
              @else
                <p class="mb-0 small text-muted italic">No comment provided by student.</p>
              @endif
            </div>
          </div>

          <div class="card shadow-sm p-3">
            <h6 class="fw-bold">Case Management Notes</h6>
            <form method="POST" action="{{ route('counselor.assessments.saveNotes', $assessment->id) }}">
              @csrf
              <div class="mb-2">
                <label for="case_notes_insights_{{ $assessment->id }}" class="form-label small">Add / Update
                  Notes</label>
                <textarea name="case_notes" id="case_notes_insights_{{ $assessment->id }}" rows="5"
                  class="form-control">{{ old('case_notes', $assessment->case_notes ?? '') }}</textarea>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Save Notes</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                  data-bs-target="#counselorNotes-{{ $assessment->id }}">Private Notes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="collapse mt-3" id="counselorNotes-{{ $assessment->id }}">
  <div class="card card-body">
    <form id="counselor-note-form-{{ $assessment->id }}" method="POST" action="#">
      <div class="mb-2">
        <label for="counselor_note_{{ $assessment->id }}" class="form-label small fw-semibold">Private Note (visible
          to counselors)</label>
        <textarea id="counselor_note_{{ $assessment->id }}" class="form-control" rows="4"
          placeholder="Add a private note..."></textarea>
      </div>
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary btn-sm" onclick="saveNote{{ $assessment->id }}()">Save
          Note</button>
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
          data-bs-target="#counselorNotes-{{ $assessment->id }}">Close</button>
      </div>
    </form>
  </div>
</div>

{{-- Download and Close buttons removed per request --}}
</div>




<script>
  function saveNote{{ $assessment->id }}() {
    const txtEl = document.getElementById('counselor_note_{{ $assessment->id }}');
    const txt = txtEl ? txtEl.value.trim() : '';
    if (!txt) { alert('Note is empty'); return; }
    const key = 'counselor_notes_{{ $assessment->id }}';
    const existing = JSON.parse(localStorage.getItem(key) || '[]');
    existing.push({ text: txt, created_at: new Date().toISOString() });
    localStorage.setItem(key, JSON.stringify(existing));
    alert('Note saved locally (not yet persisted to server)');
    if (txtEl) txtEl.value = '';
  }
  document.addEventListener('DOMContentLoaded', function () {
    const key = 'counselor_notes_{{ $assessment->id }}';
    const list = JSON.parse(localStorage.getItem(key) || '[]');
    // Optionally render local notes to console for now
    if (list.length) console.log('Loaded', list.length, 'local counselor notes for assessment {{ $assessment->id }}');
  });
  // Ensure viewport meta is present to avoid unexpected zooming on mobile
  (function () {
    try {
      var meta = document.querySelector('meta[name=viewport]');
      if (!meta) {
        meta = document.createElement('meta');
        meta.name = 'viewport';
        meta.content = 'width=device-width, initial-scale=1';
        document.getElementsByTagName('head')[0].appendChild(meta);
        console.log('Viewport meta injected for assessment summary web view');
      } else {
        // ensure expected content
        meta.content = meta.content || 'width=device-width, initial-scale=1';
      }
    } catch (e) { console.warn('Could not ensure viewport meta:', e); }
  })();
</script>