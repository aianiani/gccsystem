@extends('layouts.app')

@section('content')
<div class="home-zoom">
    <div class="d-flex">
    @include('counselor.sidebar')
    <div class="main-dashboard-content">
        <div class="container py-4 session-note-page" style="max-width: 1100px;">
            <style>
                :root {
                    --primary-green: #1f7a2d;
                    --primary-green-2: #13601f;
                    --accent-green: #2e7d32;
                    --light-green: #eaf5ea;
                    --accent-orange: #FFCB05;
                    --text-dark: #16321f;
                    --text-light: #6c757d;
                    --bg-light: #f6fbf6;
                    --shadow: 0 10px 30px rgba(0,0,0,0.08);
                    --forest-green: var(--primary-green);
                    --forest-green-dark: var(--primary-green-2);
                    --forest-green-light: var(--accent-green);
                    --forest-green-lighter: var(--light-green);
                    --yellow-maize: var(--accent-orange);
                    --white: #ffffff;
                    --gray-50: var(--bg-light);
                    --gray-100: #eef6ee;
                    --gray-600: var(--text-light);
                    --danger: #dc3545;
                    --warning: #ffc107;
                    --success: #28a745;
                    --info: #17a2b8;
                    --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
                    --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
                    --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
                    --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
                }
                .home-zoom { zoom: 0.85; }
                @supports not (zoom: 1) { .home-zoom { transform: scale(0.85); transform-origin: top center; } }
                .main-dashboard-content { background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%); min-height: 100vh; padding: 1rem 1.5rem; margin-left: 240px; transition: margin-left 0.2s; }
                .session-note-page { padding: 1.5rem 0; }
                .session-note-card { border-radius: 12px; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06); overflow: hidden; }
                .session-note-header { padding: 1.25rem 1.5rem; background: linear-gradient(90deg, rgba(31,122,45,0.06), rgba(46,125,50,0.03)); border-bottom: 1px solid rgba(15,23,42,0.03); }
                .session-note-body { padding: 1.25rem; }
                .student-info { min-width: 230px; }
                .student-avatar { width: 84px; height: 84px; object-fit: cover; border-radius: 50%; border: 3px solid var(--forest-green); }
                .note-textarea { min-height: 200px; resize:vertical; }
                .char-counter { font-size: 0.85rem; color: #6c757d; }
                @media (max-width: 767.98px) { .student-info { min-width: auto; margin-bottom: 1rem; } }
            </style>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div>
            <h4 class="mb-0 fw-bold"><i class="bi bi-journal-plus me-2 text-success"></i>Add Session Note</h4>
        </div>
        <div></div>
    </div>

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card session-note-card">
        <div class="session-note-header d-flex align-items-center gap-3">
            <div class="student-info d-flex align-items-center gap-3">
                <img src="{{ $appointment->student->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($appointment->student->name) . '&background=1f7a2d&color=fff') }}" alt="Avatar" class="student-avatar">
                <div>
                    <div class="fw-bold" style="color:var(--forest-green);">{{ $appointment->student->name }}</div>
                    <div class="text-muted small">{{ $appointment->student->email }}</div>
                    <div class="mt-1"><span class="badge bg-primary">Student</span></div>
                </div>
            </div>
            <div class="ms-auto text-end small text-muted">
                <div><i class="bi bi-calendar me-1"></i>{{ $appointment->scheduled_at->format('F j, Y') }}</div>
                <div><i class="bi bi-clock me-1"></i>{{ $appointment->scheduled_at->format('g:i A') }} – {{ $appointment->scheduled_at->copy()->addMinutes(30)->format('g:i A') }}</div>
                <div class="mt-1"><span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'pending' ? 'warning text-dark' : 'primary') }}">{{ ucfirst($appointment->status) }}</span></div>
            </div>
        </div>
        <div class="session-note-body">
            @php
                $studentId = $appointment->student_id;
                $appointments = \App\Models\Appointment::where('student_id', $studentId)
                    ->orderBy('scheduled_at')
                    ->pluck('id')
                    ->toArray();
                $nextSessionNumber = array_search($appointment->id, $appointments) !== false ? array_search($appointment->id, $appointments) + 1 : 1;
            @endphp

            <form action="{{ route('counselor.session_notes.store', $appointment->id) }}" method="POST" id="sessionNoteForm">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <label class="form-label mb-0 fw-semibold">Session # <span class="badge bg-primary ms-2">{{ $nextSessionNumber }}</span></label>
                            <div class="text-muted small">Optional: schedule next session below</div>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label fw-semibold">Session Note</label>
                            <textarea name="note" id="note" class="form-control note-textarea" rows="8" maxlength="4000" placeholder="Write the session note here...">{{ old('note') }}</textarea>
                            @error('note')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            <div class="d-flex justify-content-between mt-1">
                                <div class="text-muted small">Be objective and concise. This note is visible to authorized staff.</div>
                                <div class="char-counter" id="charCounter">{{ strlen(old('note') ?? '') }} / 4000</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="next_session" class="form-label fw-semibold">Next Session (optional)</label>
                            <input type="datetime-local" name="next_session" id="next_session" class="form-control" value="{{ old('next_session') }}">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" id="saveNoteBtn"><i class="bi bi-check-circle me-1"></i> Save Note</button>
                            <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <h6 class="fw-semibold">Quick Info</h6>
                            <p class="small text-muted">Session notes help track progress and inform care. Keep sensitive details minimal and follow confidentiality guidelines.</p>
                            <hr>
                            <div>
                                <div class="small text-muted">Student Contact</div>
                                <div class="fw-medium">{{ $appointment->student->contact_number ?? 'N/A' }}</div>
                            </div>
                            <div class="mt-2">
                                <div class="small text-muted">College / Course</div>
                                <div class="fw-medium">{{ $appointment->student->college ?? 'N/A' }} • {{ $appointment->student->course ?? 'N/A' }}</div>
                            </div>
                            <div class="mt-3">
                                <div class="small text-muted">Nature of Problem</div>
                                <div class="fw-medium">{{ $appointment->nature_of_problem ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</div>

<script>
    (function(){
        const textarea = document.getElementById('note');
        const counter = document.getElementById('charCounter');
        const form = document.getElementById('sessionNoteForm');
        const max = parseInt(textarea.getAttribute('maxlength') || '4000', 10);

        function updateCounter(){
            const len = textarea.value.length;
            counter.textContent = len + ' / ' + max;
        }
        if(textarea){
            textarea.addEventListener('input', updateCounter);
            updateCounter();
            textarea.focus();
        }

        if(form){
            form.addEventListener('submit', function(e){
                const msg = 'Save session note? This action cannot be undone.';
                if(!confirm(msg)){
                    e.preventDefault();
                }
            });
        }
    })();
</script>

@endsection