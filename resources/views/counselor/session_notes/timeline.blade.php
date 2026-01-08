@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables */
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply page zoom for better readability */
        .home-zoom {
            zoom: 0.90;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.90);
                transform-origin: top center;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1.5rem 2rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .timeline-hero {
            background: var(--hero-gradient);
            color: #fff;
            padding: 1.5rem 1.75rem;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            margin-bottom: 1.5rem;
        }

        .timeline-hero-grid {
            display: grid;
            grid-template-columns: 72px 1fr auto;
            gap: 1.25rem;
            align-items: center;
        }

        .timeline-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.25);
        }

        .timeline-card {
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            background: white;
            border: 1px solid rgba(31, 122, 45, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .timeline-card:hover {
            box-shadow: var(--shadow-lg);
        }

        .timeline-entry {
            border-left: 3px solid rgba(31, 122, 45, 0.15);
            padding-left: 1.25rem;
            margin-left: 0.75rem;
        }

        .timeline-item {
            padding: 1.25rem;
            background: var(--gray-50);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
        }

        .timeline-item:hover {
            background: white;
            transform: translateX(3px);
        }

        .timeline-meta {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem;
            }

            .timeline-hero-grid {
                grid-template-columns: 60px 1fr;
            }

            .timeline-hero-grid>div:last-child {
                display: none;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            @include('counselor.sidebar')
            <div class="main-dashboard-content flex-grow-1">
                <div style="max-width:1200px; margin: 0 auto;">

                    <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
                    <h2 class="mb-0 fw-bold d-flex align-items-center gap-2" style="color: var(--forest-green);"><i class="bi bi-clock-history"></i> Session History Timeline</h2>
                </div>
            </div>

                    @if($student)
                        <div class="timeline-hero mb-4">
                            <div class="timeline-hero-grid">
                                <img src="{{ $student->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=1f7a2d&color=fff') }}"
                                    alt="Avatar" class="timeline-avatar">
                                <div>
                                    <div class="fw-bold" style="font-size:1.05rem">{{ $student->name }}</div>
                                    <div class="small">{{ $student->email }}</div>
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        <div class="badge bg-light text-dark"><i class="bi bi-telephone me-1"></i>
                                            {{ $student->contact_number ?? 'N/A' }}</div>
                                        <div class="badge bg-light text-dark"><i class="bi bi-building me-1"></i>
                                            {{ $student->college ?? 'N/A' }}</div>
                                        <div class="badge bg-light text-dark"><i class="bi bi-mortarboard me-1"></i>
                                            {{ $student->course ?? 'N/A' }}</div>
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
                                            <a href="{{ route('counselor.session_notes.create', $createAppointmentId) }}?student_id={{ $student->id }}"
                                                class="btn btn-outline-light btn-sm">Add Note</a>
                                        @else
                                            <button class="btn btn-outline-light btn-sm" disabled
                                                title="No appointment selected">Add Note</button>
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
                                                <div class="small text-muted">{{ $note->appointment->scheduled_at->format('M j') }}
                                                </div>
                                                <div class="fw-bold">{{ $note->appointment->scheduled_at->format('g:i A') }}</div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="fw-semibold">Session {{ $note->session_number }}</div>
                                                    <div>
                                                        @if(isset($statusMap[$status]))
                                                            <span
                                                                class="badge {{ $statusMap[$status]['class'] }} d-inline-flex align-items-center gap-1 px-3 py-2" style="font-size: 0.85rem;">
                                                                <i class="bi bi-{{ $statusMap[$status]['icon'] }}"></i>
                                                                {{ $statusMap[$status]['label'] }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">N/A</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="mb-2 timeline-meta"><strong>Counselor:</strong>
                                                        {{ optional($note->counselor)->name ?? 'N/A' }}</div>
                                                    <div class="mb-2">{!! nl2br(e($note->note)) !!}</div>
                                                    @if($note->attendance === 'missed' && $note->absence_reason)
                                                        <div class="text-danger small mt-2"><strong>Absence Reason:</strong>
                                                            {{ $note->absence_reason }}</div>
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

                    <div class="mt-4">
                        <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back to Session Notes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection