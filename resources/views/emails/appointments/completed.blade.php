@component('emails.layouts.base', [
    'title' => 'Appointment Completed',
    'heading' => 'Thank You',
])
<h2>Hello {{ $student->name }},</h2>

<p>Thank you for attending your counseling session with {{ $counselor->name }}.</p>

<div class="info-box">
    <p><strong>Session Date:</strong> {{ $appointment->scheduled_at->format('F d, Y') }}</p>
    <p><strong>Counselor:</strong> {{ $counselor->name }}</p>
    <p><strong>Reference Number:</strong> {{ $appointment->reference_number }}</p>
</div>

<p>We hope the session was helpful. Your mental health and well-being are important to us.</p>

<p><strong>What's next?</strong></p>
<ul>
    <li>Review your session notes in your dashboard</li>
    <li>Book a follow-up appointment if recommended</li>
    <li>Reach out if you have any questions</li>
</ul>

<div class="button-center">
    <a href="{{ url('/appointments/create') }}" class="button">
        Book Follow-up Appointment
    </a>
</div>
@endcomponent