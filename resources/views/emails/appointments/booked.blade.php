@component('emails.layouts.base', [
    'title' => 'New Appointment Booked',
    'heading' => 'New Appointment Booked',
])
<h2>Hello {{ $counselor->name }},</h2>

<p>A new appointment has been booked with you.</p>

<div class="info-box">
    <p><strong>Student:</strong> {{ $student->name }}</p>
    <p><strong>Date:</strong> {{ $appointment->scheduled_at->format('F d, Y') }}</p>
    <p><strong>Time:</strong> {{ $appointment->scheduled_at->format('g:i A') }}</p>
    <p><strong>Type:</strong> {{ ucfirst($appointment->type) }}</p>
    @if($appointment->reason)
        <p><strong>Reason:</strong> {{ $appointment->reason }}</p>
    @endif
    <p><strong>Reference Number:</strong> {{ $appointment->reference_number }}</p>
</div>

<p>Please review and respond to this appointment request.</p>

<div class="button-center">
    <a href="{{ url('/counselor/appointments/' . $appointment->id) }}" class="button">
        View Appointment Details
    </a>
</div>

<p style="font-size: 13px; color: #888;">
    You can accept or decline this appointment from your dashboard.
</p>
@endcomponent