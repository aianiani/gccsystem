@component('emails.layouts.base', [
    'title' => 'Appointment Declined',
    'heading' => 'Appointment Update',
])
<h2>Hello {{ $student->name }},</h2>

<p>We regret to inform you that your appointment request for {{ $appointment->scheduled_at->format('F d, Y') }} at
    {{ $appointment->scheduled_at->format('g:i A') }} could not be accommodated.</p>

@if($reason)
    <div class="info-box">
        <p><strong>Reason:</strong> {{ $reason }}</p>
    </div>
@endif

<p><strong>Next steps:</strong></p>
<ul>
    <li>You can book another appointment with a different time slot</li>
    <li>Browse other available counselors</li>
    <li>Contact us if you need assistance</li>
</ul>

<div class="button-center">
    <a href="{{ url('/appointments/create') }}" class="button">
        Book Another Appointment
    </a>
</div>

<p style="font-size: 13px; color: #888;">
    We apologize for any inconvenience and look forward to helping you soon.
</p>
@endcomponent