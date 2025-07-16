@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Book Appointment</h1>
    <form action="{{ route('appointments.store') }}" method="POST" id="appointment-form">
        @csrf
        <div class="mb-3">
            <label for="counselor_id" class="form-label">Counselor</label>
            <select name="counselor_id" id="counselor_id" class="form-control" required>
                <option value="">Select a counselor</option>
                @foreach($counselors as $counselor)
                    <option value="{{ $counselor->id }}" {{ old('counselor_id') == $counselor->id ? 'selected' : '' }}>{{ $counselor->name }}</option>
                @endforeach
            </select>
            @error('counselor_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3" id="slots-section" style="display:none;">
            <label class="form-label">Available Slots</label>
            <div id="slots-list" class="d-flex flex-wrap gap-2"></div>
            <div id="slots-loading" class="text-muted" style="display:none;">Loading slots...</div>
            <div id="slots-empty" class="text-danger" style="display:none;">No available slots.</div>
            @error('scheduled_at')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <input type="hidden" name="scheduled_at" id="scheduled_at">
        <div class="mb-3">
            <label for="notes" class="form-label">Notes (optional)</label>
            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            @error('notes')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Book</button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const counselorSelect = document.getElementById('counselor_id');
    const slotsSection = document.getElementById('slots-section');
    const slotsList = document.getElementById('slots-list');
    const slotsLoading = document.getElementById('slots-loading');
    const slotsEmpty = document.getElementById('slots-empty');
    const scheduledAtInput = document.getElementById('scheduled_at');

    function clearSlots() {
        slotsList.innerHTML = '';
        slotsEmpty.style.display = 'none';
        scheduledAtInput.value = '';
    }

    counselorSelect.addEventListener('change', function() {
        clearSlots();
        if (!this.value) {
            slotsSection.style.display = 'none';
            return;
        }
        slotsSection.style.display = '';
        slotsLoading.style.display = '';
        fetch(`/appointments/available-slots/${this.value}`)
            .then(res => res.json())
            .then(slots => {
                slotsLoading.style.display = 'none';
                if (slots.length === 0) {
                    slotsEmpty.style.display = '';
                    return;
                }
                slotsList.innerHTML = '';
                slots.forEach(slot => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'btn btn-outline-primary slot-btn';
                    btn.textContent = new Date(slot.replace('T', ' ')).toLocaleString();
                    btn.dataset.value = slot;
                    btn.onclick = function() {
                        document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        scheduledAtInput.value = slot;
                    };
                    slotsList.appendChild(btn);
                });
            })
            .catch(() => {
                slotsLoading.style.display = 'none';
                slotsEmpty.style.display = '';
            });
    });

    // If old value exists (validation error), trigger change
    @if(old('counselor_id'))
        counselorSelect.dispatchEvent(new Event('change'));
    @endif
});
</script>
@endpush
@endsection 