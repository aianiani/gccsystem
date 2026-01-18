@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-green: #1f7a2d;
            --primary-green-dark: #13601f;
            --accent-yellow: #FFCB05;
            --text-dark: #16321f;
            --text-muted: #6c757d;
            --bg-light: #f6fbf6;
            --card-shadow: 0 4px 20px rgba(0,0,0,0.05);
            --card-hover-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .home-zoom { zoom: 0.75; }
        @supports not (zoom: 1) { .home-zoom { transform: scale(0.75); transform-origin: top center; } }

        body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg-light); }

        .main-content {
            margin-left: 240px;
            padding: 2rem;
            min-height: 100vh;
        }

        /* Header Styles */
        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: #fff;
            padding: 1.5rem 2rem;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
        }
        .header-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .header-meta {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        /* Card Styles */
        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .content-card:hover {
            box-shadow: var(--card-hover-shadow);
        }
        .card-title-styled {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(31, 122, 45, 0.1);
        }
        
        /* Highlighted Notes Card */
        .notes-card {
            background: #fffcf0; /* Light yellow tint */
            border: 1px solid #f0e68c;
        }
        .notes-card .card-title-styled {
            border-bottom-color: #ffd700;
            color: #b78900;
        }

        /* Info Rows */
        .info-group {
            margin-bottom: 1rem;
        }
        .info-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }
        .info-value {
            font-size: 1rem;
            color: var(--text-dark);
            font-weight: 500;
        }
        
        /* Avatar & Profile */
        .student-profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .student-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid var(--primary-green);
            padding: 3px;
            background: #fff;
            object-fit: cover;
            margin-bottom: 0.75rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        /* Status Badges */
        .status-badge-lg {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .badge-pending { background: #fff8e1; color: #b78900; }
        .badge-accepted { background: #e8f5e9; color: #2e7d32; }
        .badge-completed { background: #e3f2fd; color: #1565c0; }
        .badge-cancelled { background: #ffebee; color: #c62828; }
        
        /* Buttons */
        .btn-action {
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }
        .btn-action:hover { transform: translateY(-2px); }

        @media (max-width: 991px) {
            .main-content { margin-left: 200px; }
        }
        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 1rem; }
            .details-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Sidebar -->
            @include('counselor.sidebar')

            <div class="main-content flex-grow-1">
                <a href="{{ route('counselor.appointments.index') }}" class="btn btn-link text-muted mb-3 px-0 text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Back to Appointments
                </a>

                <!-- Header -->
                <div class="details-header">
                    <div class="header-title">
                        <h1>
                            <i class="bi bi-calendar-event-fill text-success"></i>
                            Appointment Details
                        </h1>
                        <div class="header-meta">
                            Reference: <span class="font-monospace text-dark">{{ $appointment->reference_number }}</span> • 
                            Session #{{ $appointment->session_number }}
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                         @php
                            $statusClass = 'badge-pending';
                            if($appointment->status === 'accepted') $statusClass = 'badge-accepted';
                            elseif($appointment->status === 'completed') $statusClass = 'badge-completed';
                            elseif($appointment->status === 'declined' || $appointment->status === 'cancelled') $statusClass = 'badge-cancelled';
                        @endphp
                        <span class="status-badge-lg {{ $statusClass }}">
                            <i class="bi bi-info-circle"></i> {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                        </span>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Left Column (Main Info) -->
                    <div class="col-lg-8">
                        <!-- Actions Card -->
                        <div class="content-card">
                            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                <div class="fw-bold text-dark">Actions</div>
                                <div class="d-flex gap-2">
                                    @if($appointment->status === 'pending')
                                        <form method="POST" action="{{ route('counselor.appointments.accept', $appointment->id) }}" data-confirm="Accept this appointment?">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-success btn-action"><i class="bi bi-check-lg"></i> Accept</button>
                                        </form>
                                        <a href="{{ route('counselor.appointments.reschedule', $appointment->id) }}" class="btn btn-warning btn-action text-dark">
                                            <i class="bi bi-clock-history"></i> Reschedule
                                        </a>
                                        <form method="POST" action="{{ route('counselor.appointments.decline', $appointment->id) }}" data-confirm="Decline this appointment?">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-outline-danger btn-action"><i class="bi bi-x-lg"></i> Decline</button>
                                        </form>
                                    @elseif($appointment->status === 'accepted')
                                        <form method="POST" action="{{ route('counselor.appointments.complete', $appointment->id) }}" data-confirm="Mark as complete?">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-primary btn-action"><i class="bi bi-check2-square"></i> Mark Complete</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('chat.index', $appointment->student->id) }}" class="btn btn-outline-primary btn-action">
                                        <i class="bi bi-chat-dots"></i> Chat
                                    </a>
                                </div>
                            </div>
                        </div>



                        <!-- Appointment Info -->
                        <div class="content-card">
                            <div class="card-title-styled"><i class="bi bi-clock"></i> Schedule Information</div>
                            <div class="row">
                                <div class="col-md-6 info-group">
                                    <div class="info-label">Date & Time</div>
                                    @php
                                        $start = $appointment->scheduled_at;
                                        $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)->where('start', $start)->first();
                                        $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                                    @endphp
                                    <div class="info-value">
                                        {{ $start->format('l, F j, Y') }}<br>
                                        {{ $start->format('h:i A') }} – {{ $end->format('h:i A') }}
                                    </div>
                                </div>
                                <div class="col-md-6 info-group">
                                    <div class="info-label">Appointment Type</div>
                                    <div class="info-value">{{ $appointment->appointment_type ?? 'Not specified' }}</div>
                                </div>
                                <div class="col-md-6 info-group">
                                    <div class="info-label">Nature of Problem</div>
                                    <div class="info-value">
                                        {{ $appointment->nature_of_problem ?? 'Not specified' }}
                                        @if($appointment->nature_of_problem_other)
                                            <div class="small text-muted">({{ $appointment->nature_of_problem_other }})</div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <!-- Assessment Data -->
                        @if(!empty($latestAssessment))
                            <div class="content-card">
                                <div class="card-title-styled"><i class="bi bi-bar-chart-fill"></i> Latest Assessment Data</div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong>{{ $latestAssessment->type }}</strong>
                                        <div class="small text-muted">{{ $latestAssessment->created_at->format('M d, Y h:i A') }}</div>
                                    </div>
                                    <a href="{{ route('counselor.assessments.show', [$latestAssessment->id, 'from_appointment' => $appointment->id]) }}" class="btn btn-sm btn-outline-primary">View Full Report</a>
                                </div>
                                
                                @php
                                    $laScores = is_array($latestAssessment->score) ? $latestAssessment->score : (is_string($latestAssessment->score) ? json_decode($latestAssessment->score, true) : []);
                                @endphp
                                @if($latestAssessment->type === 'DASS-42')
                                     @php
                                        // Simple DASS Logic Reuse
                                        $studentAnswers = [];
                                        if (!empty($laScores) && is_array($laScores)) {
                                            foreach ($laScores as $k => $v) {
                                                if (is_numeric($k)) {
                                                    $ik = (int) $k;
                                                    if ($ik >= 0 && $ik <= 41) $studentAnswers[$ik + 1] = (int) $v;
                                                } else $studentAnswers[$k] = $v;
                                            }
                                        }
                                        $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
                                        $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
                                        $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];
                                        
                                        $dep = 0; $anx = 0; $str = 0;
                                        foreach ($depressionItems as $it) $dep += (int) ($studentAnswers[$it] ?? 0);
                                        foreach ($anxietyItems as $it) $anx += (int) ($studentAnswers[$it] ?? 0);
                                        foreach ($stressItems as $it) $str += (int) ($studentAnswers[$it] ?? 0);
                                    @endphp
                                    <div class="row g-3">
                                        <div class="col-4 text-center">
                                            <div class="h4 mb-0 text-primary">{{ $dep }}</div>
                                            <div class="small text-muted">Depression</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="h4 mb-0 text-info">{{ $anx }}</div>
                                            <div class="small text-muted">Anxiety</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="h4 mb-0 text-secondary">{{ $str }}</div>
                                            <div class="small text-muted">Stress</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-3 bg-light rounded">Score: {{ is_array($laScores) ? ($laScores['score'] ?? json_encode($laScores)) : ($latestAssessment->score ?? 'N/A') }}</div>
                                @endif
                            </div>
                        @endif

                        <!-- Notes Section (Prominent) -->
                        <div class="content-card notes-card">
                            <div class="card-title-styled">
                                <i class="bi bi-sticky-fill"></i> Student Notes / Concerns
                            </div>
                            @if($appointment->notes)
                                <div class="p-3 bg-white rounded border border-warning">
                                    <p class="mb-0 fs-5" style="color: #444;">{{ $appointment->notes }}</p>
                                </div>
                            @else
                                <div class="text-muted fst-italic">No additional notes provided by the student.</div>
                            @endif
                        </div>

                        <!-- Session Notes (If Completed) -->
                        @if($appointment->status === 'completed')
                            <div class="content-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="card-title-styled mb-0"><i class="bi bi-journal-text"></i> Session Notes</div>
                                    <a href="{{ route('counselor.session_notes.create', $appointment->id) }}" class="btn btn-sm btn-success"><i class="bi bi-plus-lg"></i> Add Note</a>
                                </div>
                                @if($appointment->sessionNotes && $appointment->sessionNotes->count())
                                    <div class="d-flex flex-column gap-3">
                                        @foreach($appointment->sessionNotes as $note)
                                            <div class="p-3 border rounded bg-light">
                                                <div class="d-flex justify-content-between text-muted small mb-2">
                                                    <div>{{ $note->created_at->format('M d, Y h:i A') }}</div>
                                                </div>
                                                <div>{{ $note->content }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-muted text-center py-3">No session notes recorded yet.</div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Right Column (Student Profile) -->
                    <div class="col-lg-4">
                        <div class="content-card">
                            <div class="student-profile-header">
                                <img src="{{ $appointment->student->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($appointment->student->name) }}" alt="Student" class="student-avatar">
                                <h4 class="mb-1 text-dark fw-bold">{{ $appointment->student->name }}</h4>
                                <div class="badge bg-light text-dark border">{{ $appointment->student->student_id ?? 'No ID' }}</div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Contact</div>
                                <div class="info-value text-break">
                                    <i class="bi bi-envelope me-1 text-muted"></i> {{ $appointment->student->email }}<br>
                                    <i class="bi bi-phone me-1 text-muted"></i> {{ $appointment->student->contact_number ?? 'N/A' }}
                                </div>
                            </div>
                            
                            <hr class="my-3 text-muted opacity-25">
                            
                            <div class="row">
                                <div class="col-6 info-group">
                                    <div class="info-label">College</div>
                                    <div class="info-value">{{ $appointment->student->college ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 info-group">
                                    <div class="info-label">Year Level</div>
                                    <div class="info-value">{{ $appointment->student->year_level ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 info-group">
                                    <div class="info-label">Course</div>
                                    <div class="info-value">{{ $appointment->student->course ?? 'N/A' }}</div>
                                </div>
                                <div class="col-6 info-group">
                                    <div class="info-label">Sex</div>
                                    <div class="info-value">{{ ucfirst($appointment->student->gender ?? 'N/A') }}</div>
                                </div>
                            </div>
                            
                            @if($appointment->student->address)
                                <hr class="my-3 text-muted opacity-25">
                                <div class="info-group">
                                    <div class="info-label">Full Address</div>
                                    <div>{{ $appointment->student->address }}</div>
                                </div>
                            @endif
                        </div>

                        <!-- Guardian Info -->
                         <div class="content-card">
                            <div class="card-title-styled"><i class="bi bi-shield-check"></i> Guardian</div>
                            <div class="info-group">
                                <div class="info-label">Primary Guardian</div>
                                <div class="info-value">{{ $appointment->guardian1_name ?? 'N/A' }}</div>
                                <div class="small text-muted">{{ $appointment->guardian1_relationship }} • {{ $appointment->guardian1_contact }}</div>
                            </div>
                            @if($appointment->guardian2_name)
                                <hr class="my-3 text-muted opacity-25">
                                <div class="info-group">
                                    <div class="info-label">Secondary Guardian</div>
                                    <div class="info-value">{{ $appointment->guardian2_name }}</div>
                                    <div class="small text-muted">{{ $appointment->guardian2_relationship }} • {{ $appointment->guardian2_contact }}</div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- History -->
                        @if(isset($appointmentHistory) && $appointmentHistory->count() > 0)
                            <div class="content-card p-0 overflow-hidden">
                                <div class="p-3 bg-light border-bottom fw-bold"><i class="bi bi-clock-history"></i> History</div>
                                <div class="list-group list-group-flush">
                                    @foreach($appointmentHistory->take(3) as $hist)
                                        <a href="{{ route('counselor.appointments.show', $hist->id) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <small class="fw-bold text-dark">{{ \Carbon\Carbon::parse($hist->scheduled_at)->format('M d, Y') }}</small>
                                                <small class="badge bg-secondary">{{ ucfirst($hist->status) }}</small>
                                            </div>
                                            <small class="text-muted">{{ $hist->nature_of_problem }}</small>
                                        </a>
                                    @endforeach
                                </div>
                                @if($appointmentHistory->count() > 3)
                                    <div class="p-2 text-center text-muted small bg-light">
                                        +{{ $appointmentHistory->count() - 3 }} more records
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modals & Scripts -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p id="confirmModalMessage" class="mb-0 fs-5 text-center text-dark"></p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4" id="confirmModalOk">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar Toggle (Mobile)
            const sidebar = document.querySelector('nav'); // Assuming sidebar tag is nav or has specific ID in include
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn) {
                 toggleBtn.addEventListener('click', () => {
                     document.querySelector('.counselor-sidebar').classList.toggle('show'); // Adjust class based on sidebar blade
                 });
            }

            // Confirmation Logic
            const confirmModalEl = document.getElementById('confirmModal');
            let bsConfirmModal = new bootstrap.Modal(confirmModalEl);
            let confirmTarget = null;

            document.querySelectorAll('[data-confirm]').forEach(el => {
                el.addEventListener('click', e => {
                    e.preventDefault();
                    // If label clicks trigger check, ensure we have the form
                    let target = el.closest('form') || el; 
                    if(target.tagName === 'BUTTON') target = target.form || target; 
                    
                    document.getElementById('confirmModalMessage').textContent = el.getAttribute('data-confirm');
                    confirmTarget = target;
                    bsConfirmModal.show();
                });
            });

            document.getElementById('confirmModalOk').addEventListener('click', () => {
                if (confirmTarget) {
                    if (confirmTarget.tagName === 'FORM') confirmTarget.submit();
                    else window.location.href = confirmTarget.href;
                }
                bsConfirmModal.hide();
            });
        });
    </script>

@endsection