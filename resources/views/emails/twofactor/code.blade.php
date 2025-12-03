@php
    $title = 'Two-Factor Authentication Code';
@endphp

@component('emails.layouts.base', [
    'title' => $title,
    'heading' => 'Two-Factor Authentication',
    'preheader' => 'Complete your secure login to CMU GCC',
    'intro' => 'Use the code below to finish signing in to your account.',
])
    <h2 style="margin-top: 0; margin-bottom: 16px; font-size: 20px; color: #1f2933;">
        Hello {{ $userName }},
    </h2>

    <p style="margin-bottom: 12px;">
        Your Two-Factor Authentication (2FA) code is:
    </p>

    <p style="font-size: 24px; font-weight: 700; letter-spacing: 0.1em; margin: 6px 0 18px 0; color: #111827;">
        {{ $code }}
    </p>

    <p style="margin-bottom: 10px;">
        Please enter this code to complete your login. This code will expire in <strong>5 minutes</strong>.
    </p>

    <p style="margin-bottom: 10px; font-size: 13px;">
        If you did not request this code, you can safely ignore this email.
    </p>

    <p style="margin-top: 18px; margin-bottom: 0;">
        Thanks,<br>
        <strong>{{ config('app.name') }}</strong>
    </p>
@endcomponent

