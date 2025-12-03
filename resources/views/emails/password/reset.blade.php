@php
    $title = 'Password Reset Request';
@endphp

@component('emails.layouts.base', [
    'title' => $title,
    'heading' => 'Reset Your Password',
    'preheader' => 'You requested a password reset for your CMU GCC account',
    'intro' => 'Use the secure link below to update your password.',
])
    <h2 style="margin-top: 0; margin-bottom: 16px; font-size: 20px; color: #1f2933;">
        Hello {{ $userName }},
    </h2>

    <p style="margin-bottom: 12px;">
        You’re receiving this email because we received a <strong>password reset request</strong> for your account.
    </p>

    <p style="text-align: center; margin: 18px 0;">
        <a href="{{ $resetLink }}" class="button-primary">
            Reset Password
        </a>
    </p>

    <p style="margin-bottom: 10px;">
        If you did not request a password reset, no further action is required and you can safely ignore this email.
    </p>

    <p style="margin-top: 18px; margin-bottom: 0;">
        Thanks,<br>
        <strong>{{ config('app.name') }}</strong>
    </p>
@endcomponent

