@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-pencil-square me-2"></i>
                    <span>Edit Appointment</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('counselor.appointments.update', $appointment->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Student</label>
                            <input type="text" class="form-control" value="{{ $appointment->student->name ?? 'N/A' }}" readonly>
                        </div>
                        @php
                            $start = $appointment->scheduled_at;
                            $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                                ->where('start', $start)
                                ->first();
                            $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                        @endphp
                        <div class="mb-3">
                            <label for="scheduled_at" class="form-label fw-bold">Date & Time</label>
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control" value="{{ old('scheduled_at', $appointment->scheduled_at ? $appointment->scheduled_at->format('Y-m-d\TH:i') : '') }}" required>
                            <div class="form-text text-muted">Slot: {{ $start->format('M d, Y - g:i A') }} – {{ $end->format('g:i A') }}</div>
                            @error('scheduled_at')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-bold">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                            @error('notes')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('counselor.appointments.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 