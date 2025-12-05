@extends('layouts.app')

@section('content')
<div class="home-zoom">
    @include('counselor.sidebar')
    <div class="main-dashboard-content">
        <div class="container py-4 session-note-detail-page" style="max-width:1100px;">

            @php
                $student = $note->appointment->student ?? null;
                $appointment = $note->appointment ?? null;
                $counselorName = optional($note->counselor)->name ?? optional($note->appointment->counselor)->name ?? 'Counselor';
                $avatar = $student->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($student->name ?? 'Student') . '&background=1f7a2d&color=fff');
            @endphp

            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-left"></i></a>
                    <h2 class="fw-bold mb-0 d-flex align-items-center gap-2"><i class="bi bi-journal-text"></i> Session Note</h2>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('counselor.session_notes.edit', $note->id) }}" class="btn btn-outline-primary shadow-sm"><i class="bi bi-pencil"></i> Edit</a>
                </div>
            </div>

            <style>
                :root {
                    --primary-green: #1f7a2d;
                    --primary-green-2: #13601f;
                    --forest-green: var(--primary-green);
                    --gray-100: #eef6ee;
                }
                /* Tighter hero layout using grid to utilize horizontal space */
                .page-hero {
                    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
                    color: #fff;
                    border-radius: 12px;
                    padding: 1rem 1.25rem;
                    box-shadow: 0 10px 30px rgba(14,56,20,0.06);
                }
                .page-hero-grid {
                    display: grid;
                    grid-template-columns: 88px 1fr auto;
                    gap: 1rem;
                    align-items: center;
                }
                .hero-avatar { width:88px; height:88px; object-fit:cover; border-radius:50%; border:3px solid rgba(255,255,255,0.18); }
                .hero-meta { display:inline-flex; align-items:center; gap:0.6rem; background: rgba(255,255,255,0.06); padding: 0.45rem 0.65rem; border-radius: 8px; }
                .hero-meta i { font-size:1rem; opacity:0.95; }
                .hero-right { min-width:160px; }
                .hero-right .badge { border-radius: 999px; padding: 0.5rem 0.9rem; }
                .session-card { border-radius: 12px; box-shadow: 0 8px 30px rgba(14,56,20,0.06); overflow: hidden; }
                .meta-label { color: #6c757d; font-weight:600; }
                .note-body { min-height: 180px; font-size: 1rem; }
                @media (max-width: 900px) { .container { padding-left:12px; padding-right:12px; } .page-hero-grid { grid-template-columns: 72px 1fr; } .hero-right { display:none; } }
            </style>

            <div class="page-hero mb-4">
                <div class="page-hero-grid">
                    <img src="{{ $avatar }}" alt="Avatar" class="hero-avatar">
                    <div class="text-white">
                        <div class="fw-bold" style="font-size:1.15rem">{{ $student->name ?? 'N/A' }}</div>
                        <div class="small">{{ $student->email ?? '' }}</div>
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <div class="hero-meta small"><i class="bi bi-telephone"></i><span>{{ $student->contact_number ?? 'N/A' }}</span></div>
                            <div class="hero-meta small"><i class="bi bi-building"></i><span>{{ $student->college ?? 'N/A' }}</span></div>
                            <div class="hero-meta small"><i class="bi bi-mortarboard"></i><span>{{ $student->course ?? 'N/A' }}</span></div>
                        </div>
                    </div>
                    <div class="hero-right text-end text-white small">
                        <div class="d-flex flex-column align-items-end justify-content-center">
                            <div class="mb-1"><i class="bi bi-calendar-event me-1"></i> {{ optional($appointment->scheduled_at)->format('F j, Y') ?? '-' }}</div>
                            <div class="mb-2"><i class="bi bi-clock me-1"></i> {{ optional($appointment->scheduled_at)->format('g:i A') ?? '-' }}</div>
                            <div><span class="badge bg-light text-dark">{{ ucfirst($appointment->status ?? 'N/A') }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card session-card mb-4 p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="meta-label">Session</div>
                                <div class="fw-bold">#{{ $note->session_number ?? '-' }}</div>
                            </div>
                            <div class="text-muted small">Created: {{ $note->created_at ? $note->created_at->format('F j, Y g:i A') : '-' }}</div>
                        </div>

                        <div class="meta-label mb-2">Counselor</div>
                        <div class="mb-3">{{ $counselorName }}</div>

                        <div class="meta-label">Session Note</div>
                        <div class="bg-light p-3 rounded border note-body">
                            {!! nl2br(e($note->note)) !!}
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            @php
                                $hasNextAppointment = \App\Models\Appointment::where('counselor_id', $note->counselor_id)
                                    ->where('student_id', $note->appointment->student_id)
                                    ->where('scheduled_at', $note->next_session)
                                    ->exists();
                            @endphp
                            @if($note->next_session && !$hasNextAppointment)
                                <form action="{{ route('counselor.session_notes.create_next_appointment', $note->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-calendar-plus me-1"></i>Create Next Appointment</button>
                                </form>
                            @endif
                            <form action="{{ route('counselor.session_notes.remind', $note->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info"><i class="bi bi-bell me-1"></i>Send Reminder</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card session-card p-3 mb-4">
                        <div class="meta-label">Appointment Details</div>
                        <div class="mt-2 small text-muted">Scheduled</div>
                        <div class="fw-medium">{{ optional($appointment->scheduled_at)->format('F j, Y \a\t g:i A') ?? '-' }}</div>
                        <hr>
                        <div class="meta-label">Nature of Problem</div>
                        <div class="small text-muted">{{ $appointment->nature_of_problem ?? 'N/A' }}</div>
                        <hr>
                        <div class="meta-label">Next Session</div>
                        <div class="small">{{ $note->next_session ? \Carbon\Carbon::parse($note->next_session)->format('F j, Y g:i A') : 'Not scheduled' }}</div>
                        <hr>
                        <div class="meta-label">Last Updated</div>
                        <div class="small">{{ $note->updated_at ? $note->updated_at->diffForHumans() : '-' }}</div>
                    </div>

                    <div class="card session-card p-3">
                        <div class="meta-label">Quick Actions</div>
                        <div class="d-flex flex-column mt-2 gap-2">
                            <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-outline-primary">View Appointment</a>
                            <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary">All Session Notes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection