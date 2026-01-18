<?php
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
?>




<ul class="nav nav-tabs mb-4 px-2" id="assessmentTabs-<?php echo e($assessment->id); ?>" role="tablist"
  style="border-bottom: 2px solid #f0f0f0;">
  <li class="nav-item" role="presentation">
    <button class="nav-link active fw-bold" id="details-tab-<?php echo e($assessment->id); ?>" data-bs-toggle="tab"
      data-bs-target="#details-<?php echo e($assessment->id); ?>" type="button" role="tab"
      aria-controls="details-<?php echo e($assessment->id); ?>" aria-selected="true"><i
        class="bi bi-bar-chart-fill me-2"></i>Results Overview</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-bold" id="score-tab-<?php echo e($assessment->id); ?>" data-bs-toggle="tab"
      data-bs-target="#score-<?php echo e($assessment->id); ?>" type="button" role="tab" aria-controls="score-<?php echo e($assessment->id); ?>"
      aria-selected="false"><i class="bi bi-table me-2"></i>Score
      Sheet</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link fw-bold" id="insights-tab-<?php echo e($assessment->id); ?>" data-bs-toggle="tab"
      data-bs-target="#insights-<?php echo e($assessment->id); ?>" type="button" role="tab"
      aria-controls="insights-<?php echo e($assessment->id); ?>" aria-selected="false"><i
        class="bi bi-lightbulb-fill me-2"></i>Insights & Notes</button>
  </li>
</ul>

<div class="tab-content" id="assessmentTabsContent-<?php echo e($assessment->id); ?>">
  <div class="tab-pane fade show active" id="details-<?php echo e($assessment->id); ?>" role="tabpanel"
    aria-labelledby="details-tab-<?php echo e($assessment->id); ?>">

    <?php if($assessment->type === 'DASS-42'): ?>
      <!-- DASS-42 Visuals -->
      <div class="row g-4 mb-4">
        <?php
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
         ?>

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
            <div class="h2 fw-bold mb-1" style="color: #0d6efd;"><?php echo e($dep); ?></div>
            <span class="badge rounded-pill px-2 py-1 small" style="background-color: #0d6efd;"><?php echo e($depSev); ?></span>
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
            <div class="h2 fw-bold mb-1" style="color: #0dcaf0;"><?php echo e($anx); ?></div>
            <span class="badge rounded-pill px-2 py-1 small text-dark"
              style="background-color: #0dcaf0;"><?php echo e($anxSev); ?></span>
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
            <div class="h2 fw-bold mb-1" style="color: #6c757d;"><?php echo e($str); ?></div>
            <span class="badge rounded-pill px-2 py-1 small" style="background-color: #6c757d;"><?php echo e($strSev); ?></span>
          </div>
        </div>
      </div>

    <?php else: ?>
      <!-- Non-DASS Fallback -->
      <div class="content-card p-4 text-center">
        <h3 class="display-6 fw-bold text-success"><?php echo e($scores['score'] ?? ($assessment->score ?? '-')); ?></h3>
        <p class="text-muted">Total Score</p>
      </div>
    <?php endif; ?>


    <?php if($assessment->type === 'DASS-42'): ?>
      <div class="mt-4">
        <?php if ($__env->exists('counselor.assessments.partials.dass42_questionnaire')) echo $__env->make('counselor.assessments.partials.dass42_questionnaire', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="tab-pane fade" id="score-<?php echo e($assessment->id); ?>" role="tabpanel"
    aria-labelledby="score-tab-<?php echo e($assessment->id); ?>">
    <div class="card shadow-sm p-3 dass-score-sheet">
      <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-grid-1x2 me-2"></i> DASS-42 Score Sheet Table</h5>
      </div>
      <div class="card-body p-3">
        <?php if ($__env->exists('counselor.assessments.partials.score_sheet')) echo $__env->make('counselor.assessments.partials.score_sheet', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

  <div class="tab-pane fade" id="insights-<?php echo e($assessment->id); ?>" role="tabpanel"
    aria-labelledby="insights-tab-<?php echo e($assessment->id); ?>">
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
            <form method="POST" action="<?php echo e(route('counselor.assessments.saveNotes', $assessment->id)); ?>">
              <?php echo csrf_field(); ?>
              <div class="mb-2">
                <label for="case_notes_insights_<?php echo e($assessment->id); ?>" class="form-label small">Add / Update
                  Notes</label>
                <textarea name="case_notes" id="case_notes_insights_<?php echo e($assessment->id); ?>" rows="5"
                  class="form-control"><?php echo e(old('case_notes', $assessment->case_notes ?? '')); ?></textarea>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Save Notes</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
                  data-bs-target="#counselorNotes-<?php echo e($assessment->id); ?>">Private Notes</button>
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

<div class="collapse mt-3" id="counselorNotes-<?php echo e($assessment->id); ?>">
  <div class="card card-body">
    <form id="counselor-note-form-<?php echo e($assessment->id); ?>" method="POST" action="#">
      <div class="mb-2">
        <label for="counselor_note_<?php echo e($assessment->id); ?>" class="form-label small fw-semibold">Private Note (visible
          to counselors)</label>
        <textarea id="counselor_note_<?php echo e($assessment->id); ?>" class="form-control" rows="4"
          placeholder="Add a private note..."></textarea>
      </div>
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-primary btn-sm" onclick="saveNote<?php echo e($assessment->id); ?>()">Save
          Note</button>
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse"
          data-bs-target="#counselorNotes-<?php echo e($assessment->id); ?>">Close</button>
      </div>
    </form>
  </div>
</div>


</div>




<script>
  function saveNote<?php echo e($assessment->id); ?>() {
    const txtEl = document.getElementById('counselor_note_<?php echo e($assessment->id); ?>');
    const txt = txtEl ? txtEl.value.trim() : '';
    if (!txt) { alert('Note is empty'); return; }
    const key = 'counselor_notes_<?php echo e($assessment->id); ?>';
    const existing = JSON.parse(localStorage.getItem(key) || '[]');
    existing.push({ text: txt, created_at: new Date().toISOString() });
    localStorage.setItem(key, JSON.stringify(existing));
    alert('Note saved locally (not yet persisted to server)');
    if (txtEl) txtEl.value = '';
  }
  document.addEventListener('DOMContentLoaded', function () {
    const key = 'counselor_notes_<?php echo e($assessment->id); ?>';
    const list = JSON.parse(localStorage.getItem(key) || '[]');
    // Optionally render local notes to console for now
    if (list.length) console.log('Loaded', list.length, 'local counselor notes for assessment <?php echo e($assessment->id); ?>');
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
</script><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/assessments/partials/summary.blade.php ENDPATH**/ ?>