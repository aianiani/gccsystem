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
  $gender = $assessment->user->gender ?? null;
  $metaParts = [];
  foreach ([$course, $year, $gender] as $p) {
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

<div class="web-view">
  <div class="card shadow-sm border-0 p-2">
    <div class="row g-2 align-items-start">
      <!-- Header: left (avatar + name) and right (meta + risk) -->
      <div class="col-12">
        <div class="student-header rounded mb-3 p-3">
          <div class="d-flex align-items-start gap-3">
            <img src="{{ $avatarUrl }}" class="rounded-circle summary-avatar" width="80" height="80" alt="Avatar">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                  <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0 fw-semibold text-white" style="font-size:1.1rem;margin:0;">
                      {{ $assessment->user->name ?? 'N/A' }}
                    </h5>
                    <span class="badge bg-white text-success"
                      style="font-size:0.7rem;padding:.25rem .4rem;">Student</span>
                  </div>
                  <div class="small text-white-50" style="font-size:0.85rem;">{{ $assessment->user->email ?? 'N/A' }}
                  </div>
                  <div class="small text-white-50" style="font-size:0.85rem;">{{ $assessment->type }} • {{ $createdAt }}
                  </div>
                </div>

                <div class="d-flex align-items-center">
                  <a href="{{ route('counselor.assessments.export', $assessment->id) }}" target="_blank"
                    class="btn btn-sm export-pdf-btn ms-3"><i class="bi bi-file-earmark-pdf-fill me-1"></i>Export
                    PDF</a>
                </div>
              </div>

              <div class="student-meta-grid-enhanced mt-2 small text-white-50">
                <div><span class="fw-semibold">ID:</span> <span
                    class="text-white">{{ $assessment->user->student_id ?? '-' }}</span></div>
                <div><span class="fw-semibold">College:</span> <span
                    class="text-white">{{ $assessment->user->college ?? '-' }}</span></div>
                <div><span class="fw-semibold">Course:</span> <span
                    class="text-white">{{ $assessment->user->course ?? '-' }}</span></div>
                <div><span class="fw-semibold">Year:</span> <span
                    class="text-white">{{ $assessment->user->year_level ?? ($assessment->user->year ?? '-') }}</span>
                </div>
                <div><span class="fw-semibold">Gender:</span> <span
                    class="text-white">{{ ucfirst($assessment->user->gender ?? '-') }}</span></div>
                <div><span class="fw-semibold">Phone:</span> <span
                    class="text-white">{{ $assessment->user->contact_number ?? '-' }}</span></div>
                @if(!empty($assessment->user->address))
                  <div class="col-span-2"><span class="fw-semibold">Address:</span> <span
                      class="text-white">{{ \Illuminate\Support\Str::limit($assessment->user->address, 80) }}</span></div>
                @endif
              </div>
            </div>
          </div>
        </div>
        {{-- Student comment removed from summary per request --}}
      </div>
      <ul class="nav nav-tabs mb-3" id="assessmentTabs-{{ $assessment->id }}" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="details-tab-{{ $assessment->id }}" data-bs-toggle="tab"
            data-bs-target="#details-{{ $assessment->id }}" type="button" role="tab"
            aria-controls="details-{{ $assessment->id }}" aria-selected="true"><i class="bi bi-calendar-event me-1"></i>
            Appointment Details</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="score-tab-{{ $assessment->id }}" data-bs-toggle="tab"
            data-bs-target="#score-{{ $assessment->id }}" type="button" role="tab"
            aria-controls="score-{{ $assessment->id }}" aria-selected="false"><i class="bi bi-grid-1x2 me-1"></i> Score
            Sheet</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="insights-tab-{{ $assessment->id }}" data-bs-toggle="tab"
            data-bs-target="#insights-{{ $assessment->id }}" type="button" role="tab"
            aria-controls="insights-{{ $assessment->id }}" aria-selected="false"><i class="bi bi-lightbulb me-1"></i>
            Insights</button>
        </li>
      </ul>

      <div class="tab-content" id="assessmentTabsContent-{{ $assessment->id }}">
        <div class="tab-pane fade show active" id="details-{{ $assessment->id }}" role="tabpanel"
          aria-labelledby="details-tab-{{ $assessment->id }}">
          <div class="row gx-3">
            <div class="col-md-12">
              <div class="card border-0 bg-light p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="fw-bold">Key Scores</div>
                  <div class="small text-muted">Interpretation based on subscale severity</div>
                </div>
                @if($assessment->type === 'DASS-42')
                  @php
                    // Use computed totals to ensure consistency with score sheet
                    $dep = $depressionTotal;
                    $anx = $anxietyTotal;
                    $str = $stressTotal;
                  @endphp
                  <div class="row g-3">
                    <!-- Depression Column -->
                    <div class="col-md-4">
                      <div class="score-row d-flex justify-content-between small mb-2">
                        <div class="fw-semibold">Depression</div>
                        <div>{{ $dep ?? '-' }}/42</div>
                      </div>
                      <div class="progress" style="height:10px; margin-bottom:0.5rem;">
                        <div class="progress-bar" role="progressbar"
                          style="width: {{ isset($dep) ? min($dep / 42 * 100, 100) : 0 }}%; background-color:#0d6efd;">
                        </div>
                      </div>
                      <div class="text-center">
                        <span class="badge"
                          style="background-color:#0d6efd;color:#fff;padding:0.35rem 0.7rem;border-radius:0.375rem;font-size:0.8rem;">{{ $severityDep($dep ?? 0) }}</span>
                      </div>
                    </div>

                    <!-- Anxiety Column -->
                    <div class="col-md-4">
                      <div class="score-row d-flex justify-content-between small mb-2">
                        <div class="fw-semibold">Anxiety</div>
                        <div>{{ $anx ?? '-' }}/42</div>
                      </div>
                      <div class="progress" style="height:10px; margin-bottom:0.5rem;">
                        <div class="progress-bar" role="progressbar"
                          style="width: {{ isset($anx) ? min($anx / 42 * 100, 100) : 0 }}%; background-color:#0099ff;">
                        </div>
                      </div>
                      <div class="text-center">
                        <span class="badge"
                          style="background-color:#0099ff;color:#fff;padding:0.35rem 0.7rem;border-radius:0.375rem;font-size:0.8rem;">{{ $severityAnx($anx ?? 0) }}</span>
                      </div>
                    </div>

                    <!-- Stress Column -->
                    <div class="col-md-4">
                      <div class="score-row d-flex justify-content-between small mb-2">
                        <div class="fw-semibold">Stress</div>
                        <div>{{ $str ?? '-' }}/42</div>
                      </div>
                      <div class="progress" style="height:10px; margin-bottom:0.5rem;">
                        <div class="progress-bar" role="progressbar"
                          style="width: {{ isset($str) ? min($str / 42 * 100, 100) : 0 }}%; background-color:#666;"></div>
                      </div>
                      <div class="text-center">
                        <span class="badge"
                          style="background-color:#666;color:#fff;padding:0.35rem 0.7rem;border-radius:0.375rem;font-size:0.8rem;">{{ $severityStr($str ?? 0) }}</span>
                      </div>
                    </div>
                  </div>
                @else
                  <div class="small">Score: <strong>{{ $scores['score'] ?? ($assessment->score ?? '-') }}</strong></div>
                @endif
              </div>

              @if($assessment->type === 'DASS-42')
                  @includeIf('counselor.assessments.partials.dass42_questionnaire')
                </div>
              @endif

            {{-- Case management notes removed from Appointment Details (kept in Insights) --}}
          </div>


        </div>
      </div>

      <div class="tab-pane fade" id="score-{{ $assessment->id }}" role="tabpanel"
        aria-labelledby="score-tab-{{ $assessment->id }}">
        <div class="card shadow-sm p-3 dass-score-sheet">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-grid-1x2 me-2"></i> DASS-42 Score Sheet Table</h5>
          </div>
          <div class="card-body p-3">
            @includeIf('counselor.assessments.partials.score_sheet')
          </div>
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
</div>

<style>
  .card .progress {
    background: rgba(0, 0, 0, 0.04);
  }

  .card .badge.white {
    background: #fff;
    color: #222;
  }

  .summary-avatar {
    width: 64px;
    height: 64px;
    object-fit: cover;
  }

  .student-header {
    background: linear-gradient(180deg, #0b6623, #07521a);
  }

  .student-header .summary-avatar {
    border: 3px solid rgba(255, 255, 255, 0.12);
  }

  .student-header .text-white {
    color: #fff !important;
  }

  .student-header .text-white-50 {
    color: rgba(255, 255, 255, 0.85) !important;
  }

  .student-header .badge.bg-white {
    background: #fff;
  }

  @media (max-width: 767.98px) {
    .summary-avatar {
      width: 56px;
      height: 56px;
    }
  }

  .key-scores .score-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .key-scores .progress {
    margin-bottom: 0.5rem;
  }

  .nav-tabs .nav-link i {
    font-size: 1rem;
    vertical-align: middle;
  }

  .nav-tabs .nav-link.active {
    border-color: transparent;
    color: #0b6623;
  }

  /* Web view layout and alignment fixes */
  .web-view {
    max-width: 100%;
    margin: 18px auto;
    zoom: 1;
  }

  .web-view .card {
    width: 100%;
  }

  .web-view .card {
    box-shadow: 0 8px 28px rgba(13, 46, 29, 0.06);
  }

  /* Responsive typography to reduce zoom/overflow issues */
  .web-view {
    font-size: clamp(14px, 1.2vw, 15.5px);
  }

  .student-meta-grid {
    display: grid;
    gap: 0.5rem 1rem;
    grid-template-columns: 1fr;
  }

  @media (min-width: 576px) {
    .student-meta-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 992px) {
    .student-meta-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  /* Enhanced grid for better space utilization */
  .student-meta-grid-enhanced {
    display: grid;
    gap: 0.4rem 1.5rem;
    grid-template-columns: 1fr;
    font-size: 0.85rem;
  }

  @media (min-width: 576px) {
    .student-meta-grid-enhanced {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (min-width: 992px) {
    .student-meta-grid-enhanced {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .student-meta-grid-enhanced .col-span-2 {
    grid-column: span 2;
  }

  .student-meta-grid .fw-semibold {
    color: rgba(255, 255, 255, 0.95);
  }

  @media (max-width: 575.98px) {
    .web-view {
      padding: 0 8px;
    }

    .student-header .d-flex {
      gap: 0.8rem;
    }
  }

  .export-pdf-btn {
    background: #fff;
    color: #0b6623;
    border: 1px solid rgba(0, 0, 0, 0.04);
    padding: 6px 10px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
  }

  .export-pdf-btn i {
    color: #d6332a;
  }
</style>

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