@component('emails.layouts.base', [
    'title' => 'Seminar Reminder',
    'heading' => 'Upcoming Seminar Reminder',
])
<h2>Hello {{ $user->name }},</h2>

<p>This is a reminder about the upcoming seminar you registered for.</p>

<div class="info-box">
    <p><strong>Seminar:</strong> {{ $seminar->title }}</p>
    <p><strong>Date:</strong> {{ $seminar->date->format('F d, Y') }}</p>
    <p><strong>Time:</strong> {{ $seminar->start_time }} - {{ $seminar->end_time }}</p>
    <p><strong>Venue:</strong> {{ $seminar->venue }}</p>
    @if($seminar->speaker)
        <p><strong>Speaker:</strong> {{ $seminar->speaker }}</p>
    @endif
</div>

@if($seminar->description)
    <p><strong>About this seminar:</strong></p>
    <p>{{ $seminar->description }}</p>
@endif

<p>We look forward to seeing you there!</p>

<div class="button-center">
    <a href="{{ url('/seminars/' . $seminar->id) }}" class="button">
        View Seminar Details
    </a>
</div>
@endcomponent