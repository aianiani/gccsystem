@php
    $studentName = $assessment->user->name ?? 'Student';
    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($studentName) . '&background=0D8ABC&color=fff&rounded=true&size=128';
    $scores = is_array($assessment->score) ? $assessment->score : (is_string($assessment->score) ? json_decode($assessment->score, true) : []);
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

    $severityLabel = function($s) {
        $s = intval($s);
        if ($s <= 9) return 'Normal';
        if ($s <= 13) return 'Mild';
        if ($s <= 20) return 'Moderate';
        if ($s <= 27) return 'Severe';
        return 'Extremely Severe';
    };
    
    $severityColor = function($s) {
        $s = intval($s);
        if ($s <= 9) return '#4caf50';
        if ($s <= 13) return '#8bc34a';
        if ($s <= 20) return '#ff9800';
        if ($s <= 27) return '#ff5722';
        return '#d32f2f';
    };
    
    $createdAt = $assessment->created_at ? $assessment->created_at->format('M d, Y h:i A') : '';
    $course = $assessment->user->course ?? null;
    $year = $assessment->user->year ?? null;
    $gender = $assessment->user->gender ?? null;
    $metaParts = [];
    foreach ([$course, $year, $gender] as $p) {
      if ($p && $p !== '-' && trim((string)$p) !== '') $metaParts[] = $p;
    }
    $metaString = count($metaParts) ? implode(' • ', $metaParts) : null;
@endphp

<style>
  /* Modern Card Styling */
  .assessment-detail-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    background: #ffffff;
    overflow: hidden;
  }

  /* Header Section */
  .student-header {
    background: linear-gradient(135deg, #1f7a2d 0%, #13601f 100%);
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
  }

  .student-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }

  .student-avatar {
    width: 80px;
    height: 80px;
    border: 4px solid rgba(255,255,255,0.3);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .student-info h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: white;
  }

  .student-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
    margin-top: 0.5rem;
  }

  .meta-badge {
    background: rgba(255,255,255,0.2);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    backdrop-filter: blur(10px);
  }

  /* Risk Level Card */
  .risk-level-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    border: 2px solid;
    position: relative;
    overflow: hidden;
  }

  .risk-level-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: currentColor;
  }

  .risk-indicator {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  /* Modern Tabs */
  .modern-tabs {
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 2rem;
  }

  .modern-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 600;
    padding: 1rem 1.5rem;
    position: relative;
    transition: all 0.3s ease;
  }

  .modern-tabs .nav-link:hover {
    color: #1f7a2d;
    background: transparent;
  }

  .modern-tabs .nav-link.active {
    color: #1f7a2d;
    background: transparent;
  }

  .modern-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: #1f7a2d;
    border-radius: 3px 3px 0 0;
  }

  /* Score Cards */
  .score-metric-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
  }

  .score-metric-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  }

  .metric-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
  }

  .metric-value {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.25rem;
  }

  .metric-label {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .severity-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    margin-top: 0.5rem;
  }

  /* Progress Bars */
  .modern-progress {
    height: 12px;
    border-radius: 10px;
    background: #e9ecef;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
  }

  .modern-progress-bar {
    height: 100%;
    border-radius: 10px;
    transition: width 0.6s ease;
    background: linear-gradient(90deg, currentColor 0%, currentColor 100%);
    position: relative;
    overflow: hidden;
  }

  .modern-progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
  }

  @keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
  }

  /* Action Buttons */
  .action-btn {
    border-radius: 8px;
    padding: 0.6rem 1.25rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
  }

  .action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .action-btn-primary {
    background: #1f7a2d;
    color: white;
    border-color: #1f7a2d;
  }

  .action-btn-primary:hover {
    background: #13601f;
    border-color: #13601f;
    color: white;
  }

  /* Notes Section */
  .notes-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
  }

  .notes-card:focus-within {
    border-color: #1f7a2d;
    background: white;
    box-shadow: 0 4px 12px rgba(31,122,45,0.1);
  }

  .notes-textarea {
    border: none;
    background: transparent;
    resize: vertical;
    min-height: 120px;
  }

  .notes-textarea:focus {
    outline: none;
    box-shadow: none;
  }

  /* Insights Card */
  .insight-card {
    background: white;
    border-left: 4px solid #1f7a2d;
    border-radius: 8px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }

  .insight-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #eaf5ea;
    color: #1f7a2d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  /* Comment Alert */
  .student-comment-card {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-left: 4px solid #2196f3;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
  }

  /* Responsive */
  @media (max-width: 767.98px) {
    .student-header {
      padding: 1.5rem;
    }
    
    .student-avatar {
      width: 64px;
      height: 64px;
    }

    .modern-tabs .nav-link {
      padding: 0.75rem 1rem;
      font-size: 0.9rem;
    }

    .metric-value {
      font-size: 1.5rem;
    }

    .score-metric-card {
      margin-bottom: 1rem;
    }
  }
</style>

<div class="assessment-detail-card">
  <!-- Student Header -->
  <div class="student-header">
    <div class="row align-items-center position-relative">
      <div class="col-auto">
        <img src="{{ $avatarUrl }}" class="rounded-circle student-avatar" alt="Avatar">
      </div>
      <div class="col">
        <div class="student-info">
          <h4 class="mb-1">{{ $assessment->user->name ?? 'N/A' }}</h4>
          <div class="student-meta">
            <span class="meta-badge">
              <i class="bi bi-envelope me-1"></i>{{ $assessment->user->email ?? 'N/A' }}
            </span>
            @if($metaString)
              <span class="meta-badge">{{ $metaString }}</span>
            @endif
            <span class="meta-badge">
              <i class="bi bi-calendar3 me-1"></i>{{ $createdAt }}
            </span>
          </div>
        </div>
      </div>
      <div class="col-auto">
        <div class="d-flex gap-2 flex-wrap">
          <a href="{{ auth()->check() ? route('appointments.create', ['student_id' => $assessment->user->id ?? null]) : route('login') }}" class="btn btn-light action-btn">
            <i class="bi bi-calendar-plus me-1"></i> Schedule
          </a>
          <button class="btn btn-outline-light action-btn">
            <i class="bi bi-download me-1"></i> Export
          </button>
          <button class="btn btn-warning action-btn" id="flagBtn-{{ $assessment->id }}">
            <i class="bi bi-flag-fill me-1"></i> Flag
          </button>
        </div>
      </div>
    </div>
    
    @if($assessment->student_comment)
      <div class="student-comment-card mt-3">
        <div class="d-flex gap-2">
          <i class="bi bi-chat-square-text-fill" style="color: #2196f3;"></i>
          <div>
            <strong>Student Comment:</strong>
            <p class="mb-0 mt-1">{{ $assessment->student_comment }}</p>
          </div>
        </div>
      </div>
    @endif
  </div>

  <!-- Tab Navigation -->
  <div class="p-4">
    <ul class="nav modern-tabs" id="assessmentTabs-{{ $assessment->id }}" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="details-tab-{{ $assessment->id }}" data-bs-toggle="tab" data-bs-target="#details-{{ $assessment->id }}" type="button" role="tab">
          <i class="bi bi-clipboard-data me-2"></i>Assessment Details
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="score-tab-{{ $assessment->id }}" data-bs-toggle="tab" data-bs-target="#score-{{ $assessment->id }}" type="button" role="tab">
          <i class="bi bi-grid-1x2 me-2"></i>Score Sheet
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="insights-tab-{{ $assessment->id }}" data-bs-toggle="tab" data-bs-target="#insights-{{ $assessment->id }}" type="button" role="tab">
          <i class="bi bi-lightbulb me-2"></i>Insights
        </button>
      </li>
    </ul>

    <div class="tab-content" id="assessmentTabsContent-{{ $assessment->id }}">
      <!-- Assessment Details Tab -->
      <div class="tab-pane fade show active" id="details-{{ $assessment->id }}" role="tabpanel">
        <div class="row g-4">
          <!-- Left Column: Scores -->
          <div class="col-lg-8">
            @if($assessment->type === 'DASS-42')
              @php
                $dep = $scores['depression'] ?? 0;
                $anx = $scores['anxiety'] ?? 0;
                $str = $scores['stress'] ?? 0;
              @endphp
              
              <!-- Score Metric Cards -->
              <div class="row g-3 mb-4">
                <div class="col-md-4">
                  <div class="score-metric-card">
                    <div class="metric-icon" style="background: rgba(31,122,45,0.1); color: #1f7a2d;">
                      <i class="bi bi-emoji-frown"></i>
                    </div>
                    <div class="metric-value" style="color: {{ $severityColor($dep) }}">{{ $dep }}</div>
                    <div class="metric-label">Depression</div>
                    <div class="severity-badge" style="background: {{ $severityColor($dep) }}; color: white;">
                      {{ $severityLabel($dep) }}
                    </div>
                    <div class="modern-progress mt-3">
                      <div class="modern-progress-bar" style="width: {{ min($dep/42*100,100) }}%; background: {{ $severityColor($dep) }};"></div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="score-metric-card">
                    <div class="metric-icon" style="background: rgba(0,153,255,0.1); color: #0099ff;">
                      <i class="bi bi-heart-pulse"></i>
                    </div>
                    <div class="metric-value" style="color: {{ $severityColor($anx) }}">{{ $anx }}</div>
                    <div class="metric-label">Anxiety</div>
                    <div class="severity-badge" style="background: {{ $severityColor($anx) }}; color: white;">
                      {{ $severityLabel($anx) }}
                    </div>
                    <div class="modern-progress mt-3">
                      <div class="modern-progress-bar" style="width: {{ min($anx/42*100,100) }}%; background: {{ $severityColor($anx) }};"></div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="score-metric-card">
                    <div class="metric-icon" style="background: rgba(102,102,102,0.1); color: #666;">
                      <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="metric-value" style="color: {{ $severityColor($str) }}">{{ $str }}</div>
                    <div class="metric-label">Stress</div>
                    <div class="severity-badge" style="background: {{ $severityColor($str) }}; color: white;">
                      {{ $severityLabel($str) }}
                    </div>
                    <div class="modern-progress mt-3">
                      <div class="modern-progress-bar" style="width: {{ min($str/42*100,100) }}%; background: {{ $severityColor($str) }};"></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Questionnaire -->
              <div class="mb-4">
                @includeIf('counselor.assessments.partials.dass42_questionnaire')
              </div>
            @endif

            <!-- Case Notes -->
            <div class="notes-card">
              <form method="POST" action="{{ route('counselor.assessments.saveNotes', $assessment->id) }}">
                @csrf
                <label class="form-label fw-bold mb-3">
                  <i class="bi bi-journal-text me-2"></i>Case Management Notes
                </label>
                <textarea name="case_notes" class="form-control notes-textarea" placeholder="Add your case notes here...">{{ old('case_notes', $assessment->case_notes ?? '') }}</textarea>
                <div class="d-flex justify-content-end mt-3">
                  <button type="submit" class="btn action-btn action-btn-primary">
                    <i class="bi bi-save me-1"></i> Save Notes
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Right Column: Risk & Actions -->
          <div class="col-lg-4">
            <!-- Risk Level Card -->
            <div class="risk-level-card mb-4" style="border-color: {{ $riskColor }}; color: {{ $riskColor }};">
              <div class="risk-indicator" style="background: {{ $riskColor }}; color: white;">
                <i class="bi bi-shield-exclamation"></i>
              </div>
              <div class="small text-muted mb-1">RISK LEVEL</div>
              <h4 class="fw-bold mb-0">{{ $riskLabel }}</h4>
            </div>

            <!-- Quick Actions -->
            <div class="insight-card">
              <div class="d-flex align-items-start gap-3">
                <div class="insight-icon">
                  <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="flex-grow-1">
                  <h6 class="fw-bold mb-2">Quick Actions</h6>
                  <div class="d-grid gap-2">
                    <button class="btn btn-success btn-sm">
                      <i class="bi bi-hand-thumbs-up me-1"></i> Mark Reviewed
                    </button>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="tab" data-bs-target="#insights-{{ $assessment->id }}">
                      <i class="bi bi-lightbulb me-1"></i> View Insights
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                      <i class="bi bi-printer me-1"></i> Print Report
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recommendations -->
            <div class="insight-card mt-3">
              <div class="d-flex align-items-start gap-3">
                <div class="insight-icon">
                  <i class="bi bi-clipboard-check"></i>
                </div>
                <div class="flex-grow-1">
                  <h6 class="fw-bold mb-2">Recommendations</h6>
                  <ul class="small mb-0 ps-3">
                    <li class="mb-2">Schedule follow-up session</li>
                    <li class="mb-2">Share self-care resources</li>
                    <li>Monitor progress weekly</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Score Sheet Tab -->
      <div class="tab-pane fade" id="score-{{ $assessment->id }}" role="tabpanel">
        <div class="score-metric-card">
          @includeIf('counselor.assessments.partials.score_sheet')
        </div>
      </div>

      <!-- Insights Tab -->
      <div class="tab-pane fade" id="insights-{{ $assessment->id }}" role="tabpanel">
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="insight-card">
              <h5 class="fw-bold mb-3">
                <i class="bi bi-lightbulb-fill me-2" style="color: #ffc107;"></i>AI-Powered Insights
              </h5>
              <div class="mb-3">
                <h6 class="fw-semibold text-muted small mb-2">KEY FINDINGS</h6>
                <ul class="mb-3">
                  <li class="mb-2">High severity detected in {{ $dep > $anx && $dep > $str ? 'Depression' : ($anx > $str ? 'Anxiety' : 'Stress') }} subscale</li>
                  <li class="mb-2">Consider scheduling immediate follow-up</li>
                  <li>Recommend crisis resources if needed</li>
                </ul>
              </div>
            </div>

            <!-- Notes Section -->
            <div class="notes-card mt-4">
              <form method="POST" action="{{ route('counselor.assessments.saveNotes', $assessment->id) }}">
                @csrf
                <label class="form-label fw-bold mb-3">
                  <i class="bi bi-journal-medical me-2"></i>Clinical Notes
                </label>
                <textarea name="case_notes" class="form-control notes-textarea" placeholder="Add clinical observations and treatment plans...">{{ old('case_notes', $assessment->case_notes ?? '') }}</textarea>
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#counselorNotes-{{ $assessment->id }}">
                    <i class="bi bi-lock me-1"></i> Private Notes
                  </button>
                  <button type="submit" class="btn action-btn action-btn-primary">
                    <i class="bi bi-save me-1"></i> Save Notes
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="insight-card">
              <h6 class="fw-bold mb-3">Resource Links</h6>
              <div class="d-grid gap-2">
                <a href="#" class="btn btn-outline-primary btn-sm">Crisis Hotline Info</a>
                <a href="#" class="btn btn-outline-primary btn-sm">Self-Care Resources</a>
                <a href="#" class="btn btn-outline-primary btn-sm">Therapy Referrals</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Private Notes Collapse -->
<div class="collapse mt-3" id="counselorNotes-{{ $assessment->id }}">
  <div class="notes-card">
    <form id="counselor-note-form-{{ $assessment->id }}" method="POST" action="#">
      <label class="form-label fw-bold mb-3">
        <i class="bi bi-lock-fill me-2"></i>Private Counselor Notes
        <small class="text-muted d-block mt-1">Only visible to counselors</small>
      </label>
      <textarea id="counselor_note_{{ $assessment->id }}" class="form-control notes-textarea" placeholder="Add confidential notes..."></textarea>
      <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#counselorNotes-{{ $assessment->id }}">Cancel</button>
        <button type="button" class="btn action-btn action-btn-primary" onclick="saveNote{{ $assessment->id }}()">
          <i class="bi bi-save me-1"></i> Save Private Note
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function saveNote{{ $assessment->id }}() {
  const txtEl = document.getElementById('counselor_note_{{ $assessment->id }}');
  const txt = txtEl ? txtEl.value.trim() : '';
  if(!txt) { 
    alert('Note is empty'); 
    return; 
  }
  const key = 'counselor_notes_{{ $assessment->id }}';
  const existing = JSON.parse(localStorage.getItem(key) || '[]');
  existing.push({text: txt, created_at: new Date().toISOString()});
  localStorage.setItem(key, JSON.stringify(existing));
  alert('Note saved locally');
  if(txtEl) txtEl.value = '';
  // Close the collapse
  const collapseEl = document.getElementById('counselorNotes-{{ $assessment->id }}');
  if(collapseEl) {
    const bsCollapse = bootstrap.Collapse.getInstance(collapseEl) || new bootstrap.Collapse(collapseEl, {toggle: false});
    bsCollapse.hide();
  }
}

document.addEventListener('DOMContentLoaded', function(){
  const key = 'counselor_notes_{{ $assessment->id }}';
  const list = JSON.parse(localStorage.getItem(key) || '[]');
  if(list.length) console.log('Loaded', list.length, 'local counselor notes for assessment {{ $assessment->id }}');
});
</script>