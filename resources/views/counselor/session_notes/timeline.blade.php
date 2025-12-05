@extends('layouts.app')

@section('content')
<div class="home-zoom">
    <div class="d-flex">
    @include('counselor.sidebar')
    <div class="main-dashboard-content">
        <div class="container py-4" style="max-width:1100px;">
            <style>
                :root { --primary-green: #1f7a2d; --primary-green-2: #13601f; --forest-green: var(--primary-green); }
                .timeline-hero { background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%); color:#fff; padding:1rem 1.25rem; border-radius:12px; box-shadow:0 10px 30px rgba(14,56,20,0.06); }
                .timeline-hero-grid { display:grid; grid-template-columns:64px 1fr auto; gap:1rem; align-items:center; }
                .timeline-avatar { width:64px; height:64px; border-radius:50%; object-fit:cover; border:3px solid rgba(255,255,255,0.12); }
                .timeline-card { border-radius:12px; box-shadow:0 8px 30px rgba(14,56,20,0.06); }
                .timeline-entry { border-left:3px solid rgba(31,122,45,0.08); padding-left:1rem; margin-left:0.5rem; }
                .timeline-item { padding:1rem; background: #fff; border-radius:10px; box-shadow: 0 4px 14px rgba(18,52,22,0.04); }
                .timeline-meta { font-size:0.95rem; color:#6c757d; }
                @media (max-width:900px) { .timeline-hero-grid { grid-template-columns:56px 1fr; } }
            </style>

            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-left"></i></a>
                    <h2 class="mb-0 fw-bold d-flex align-items-center gap-2"><i class="bi bi-clock-history"></i> Session History Timeline</h2>
                </div>
            </div>

            @if($student)
                <div class="timeline-hero mb-4">
                    <div class="timeline-hero-grid">
                        <img src="{{ $student->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=1f7a2d&color=fff') }}" alt="Avatar" class="timeline-avatar">
                        <div>
                            <div class="fw-bold" style="font-size:1.05rem">{{ $student->name }}</div>
                            <div class="small">{{ $student->email }}</div>
                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                <div class="badge bg-light text-dark"><i class="bi bi-telephone me-1"></i> {{ $student->contact_number ?? 'N/A' }}</div>
                                <div class="badge bg-light text-dark"><i class="bi bi-building me-1"></i> {{ $student->college ?? 'N/A' }}</div>
                                <div class="badge bg-light text-dark"><i class="bi bi-mortarboard me-1"></i> {{ $student->course ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="text-end timeline-meta">
                            <div>Sessions: <strong>{{ $sessionNotes->count() }}</strong></div>
                            @php
                                // Determine appointment id to use for creating a new session note
                                $createAppointmentId = request('appointment_id') ?? ($sessionNotes->first()->appointment_id ?? null);
                            @endphp
                            <div class="mt-1">
                                @if($createAppointmentId)
                                    <a href="{{ route('counselor.session_notes.create', $createAppointmentId) }}?student_id={{ $student->id }}" class="btn btn-outline-light btn-sm">Add Note</a>
                                @else
                                    <button class="btn btn-outline-light btn-sm" disabled title="No appointment selected">Add Note</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="timeline-card p-3">
            @if($sessionNotes->count())
                <div class="d-flex flex-column gap-3">
                    @foreach($sessionNotes as $note)
                        @php
                            $status = $note->session_status;
                            $statusMap = [
                                'scheduled' => ['label' => 'Scheduled', 'class' => 'bg-info text-dark', 'icon' => 'calendar-event'],
                                'completed' => ['label' => 'Completed', 'class' => 'bg-success', 'icon' => 'check-circle'],
                                'missed' => ['label' => 'Missed', 'class' => 'bg-warning text-dark', 'icon' => 'clock'],
                                'expired' => ['label' => 'Expired', 'class' => 'bg-danger', 'icon' => 'exclamation-triangle'],
                            ];
                        @endphp
                        <div class="timeline-entry">
                            <div class="d-flex align-items-start gap-3">
                                <div class="flex-shrink-0 text-center" style="width:72px;">
                                    <div class="small text-muted">{{ $note->appointment->scheduled_at->format('M j') }}</div>
                                    <div class="fw-bold">{{ $note->appointment->scheduled_at->format('g:i A') }}</div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="fw-semibold">Session {{ $note->session_number }}</div>
                                        <div>
                                            @if(isset($statusMap[$status]))
                                                <span class="badge {{ $statusMap[$status]['class'] }} d-inline-flex align-items-center gap-1 px-2 py-2">
                                                    <i class="bi bi-{{ $statusMap[$status]['icon'] }}"></i> {{ $statusMap[$status]['label'] }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="mb-2 timeline-meta"><strong>Counselor:</strong> {{ optional($note->counselor)->name ?? 'N/A' }}</div>
                                        <div class="mb-2">{!! nl2br(e($note->note)) !!}</div>
                                        @if($note->attendance === 'missed' && $note->absence_reason)
                                            <div class="text-danger small mt-2"><strong>Absence Reason:</strong> {{ $note->absence_reason }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-3">No session notes found for this student.</div>
            @endif
            </div>

            <div class="mt-3">
                <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to Session Notes</a>
            </div>
        </div>
        </div>
    </div>
    @endsection