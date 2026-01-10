@extends('layouts.app')

@section('content')
    <div class="home-zoom">
        <div class="d-flex">
            @include('counselor.sidebar')
            <div class="main-dashboard-content flex-grow-1">
                <div class="container py-4" style="max-width:100%;">

                    @php
                        $student = $note->appointment->student ?? null;
                        $appointment = $note->appointment ?? null;
                        $avatar = $student->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($student->name ?? 'Student') . '&background=1f7a2d&color=fff');
                    @endphp

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('counselor.session_notes.show', $note->id) }}"
                                class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-left"></i></a>
                            <h2 class="fw-bold mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-pencil"></i> Edit Session Note
                                <span class="badge bg-primary" style="font-size: 0.9rem;">Session
                                    #{{ $note->session_number ?? '-' }}</span>
                            </h2>
                        </div>
                    </div>

                    <style>
                        /* Apply 75% zoom consistent with other counselor pages */
                        .home-zoom {
                            zoom: 0.75;
                        }

                        @supports not (zoom: 1) {
                            .home-zoom {
                                transform: scale(0.75);
                                transform-origin: top center;
                            }
                        }

                        /* Sidebar and content layout */
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

                        :root {
                            --primary-green: #1f7a2d;
                            --primary-green-2: #13601f;
                            --forest-green: var(--primary-green);
                        }

                        .session-card {
                            border-radius: 12px;
                            box-shadow: 0 8px 30px rgba(14, 56, 20, 0.06);
                        }

                        .edit-hero {
                            display: grid;
                            grid-template-columns: 80px 1fr auto;
                            gap: 1rem;
                            align-items: center;
                            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
                            color: #fff;
                            padding: 0.9rem 1rem;
                            border-radius: 12px;
                        }

                        .edit-hero .hero-avatar {
                            width: 80px;
                            height: 80px;
                            border-radius: 50%;
                            object-fit: cover;
                            border: 3px solid rgba(255, 255, 255, 0.12);
                        }

                        .hero-meta {
                            display: inline-flex;
                            align-items: center;
                            gap: 0.6rem;
                            background: rgba(255, 255, 255, 0.06);
                            padding: 0.4rem 0.6rem;
                            border-radius: 8px;
                        }

                        .meta-label {
                            color: #6c757d;
                            font-weight: 600;
                        }

                        .note-textarea {
                            min-height: 220px;
                            resize: vertical;
                        }

                        .char-counter {
                            font-size: 0.9rem;
                            color: #6c757d;
                        }

                        @media (max-width:900px) {
                            .edit-hero {
                                grid-template-columns: 64px 1fr;
                            }

                            .edit-hero .hero-right {
                                display: none;
                            }
                        }
                    </style>

                    <div class="edit-hero mb-4">
                        <img src="{{ $avatar }}" class="hero-avatar" alt="Avatar">
                        <div>
                            <div class="fw-bold" style="font-size:1.05rem">{{ $student->name ?? 'N/A' }}</div>
                            <div class="small">{{ $student->email ?? '' }}</div>
                            <div class="mt-2 d-flex gap-2 flex-wrap">
                                <div class="hero-meta small"><i
                                        class="bi bi-telephone"></i><span>{{ $student->contact_number ?? 'N/A' }}</span>
                                </div>
                                <div class="hero-meta small"><i
                                        class="bi bi-building"></i><span>{{ $student->college ?? 'N/A' }}</span></div>
                                <div class="hero-meta small"><i
                                        class="bi bi-mortarboard"></i><span>{{ $student->course ?? 'N/A' }}</span></div>
                            </div>
                        </div>
                        <div class="hero-right text-end small">
                            <div class="mb-1"><i class="bi bi-calendar-event me-1"></i>
                                {{ optional($appointment->scheduled_at)->format('F j, Y') ?? '-' }}</div>
                            <div class="mb-2"><i class="bi bi-clock me-1"></i>
                                {{ optional($appointment->scheduled_at)->format('g:i A') ?? '-' }}</div>
                            <div><span class="badge bg-light text-dark">{{ ucfirst($appointment->status ?? 'N/A') }}</span>
                            </div>
                        </div>
                    </div>

                    @if(trim($note->note) === '')
                        <div class="alert alert-warning mb-3">This session note is empty. Please fill it out and save to
                            complete
                            the session.</div>
                    @endif

                    <form action="{{ route('counselor.session_notes.update', $note->id) }}" method="POST"
                        id="editSessionNoteForm">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card session-card p-4 mb-4">
                                    <label for="note" class="form-label fw-semibold">Session Note</label>
                                    <textarea name="note" id="note" class="form-control note-textarea"
                                        maxlength="4000">{{ old('note', $note->note) }}</textarea>
                                    @error('note')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    <div class="d-flex justify-content-between mt-2 align-items-center">
                                        <div class="text-muted small">Be objective and concise. Sensitive details should be
                                            minimal.</div>
                                        <div class="char-counter" id="charCounter">
                                            {{ strlen(old('note', $note->note) ?? '') }}
                                            / 4000
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card session-card p-3 mb-3">
                                    <div class="meta-label">Attendance</div>
                                    <select name="attendance" id="attendance" class="form-select mb-3">
                                        <option value="unknown" {{ $note->attendance === 'unknown' ? 'selected' : '' }}>
                                            Unknown
                                        </option>
                                        <option value="attended" {{ $note->attendance === 'attended' ? 'selected' : '' }}>
                                            Attended
                                        </option>
                                        <option value="missed" {{ $note->attendance === 'missed' ? 'selected' : '' }}>Missed
                                        </option>
                                    </select>

                                    <div class="meta-label">Next Session (optional)</div>
                                    <input type="datetime-local" name="next_session" id="next_session"
                                        class="form-control mb-3"
                                        value="{{ old('next_session', $note->next_session ? $note->next_session->format('Y-m-d\\TH:i') : '') }}">

                                    <hr>
                                    <div class="meta-label">Created</div>
                                    <div class="small text-muted mb-2">
                                        {{ $note->created_at ? $note->created_at->format('F j, Y g:i A') : '-' }}
                                    </div>
                                    <div class="meta-label">Last Updated</div>
                                    <div class="small text-muted mb-2">
                                        {{ $note->updated_at ? $note->updated_at->diffForHumans() : '-' }}
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg"><i
                                            class="bi bi-check-circle me-1"></i>
                                        Save Changes</button>
                                    <a href="{{ route('counselor.session_notes.show', $note->id) }}"
                                        class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
@endsection