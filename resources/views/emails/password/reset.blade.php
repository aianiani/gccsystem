@component('emails.layouts.base', [
    'title' => 'Password Reset Request',
    'heading' => 'Reset Your Password',
])
    <h2>Hello {{ $userName }},</h2>

    <p>You're receiving this email because we received a password reset request for your account.</p>

    <div class="button-center">
        <a href="{{ $resetLink }}" class="button">
            Reset Password
        </a>
    </div>

    <p style="font-size: 13px; color: #888;">
        If the button doesn't work, copy and paste this link into your browser:
    </p>
    <p style="word-break: break-all; font-size: 13px; color: #228B22;">
        {{ $resetLink }}
    </p>

    <div class="info-box" style="background-color: #fff9e6; border-color: #ffd700;">
        <p style="margin: 0; font-size: 14px; color: #856404;">
            <strong>Security Notice:</strong> This password reset link will expire in 60 minutes.
        </p>
    </div>

    <p style="font-size: 13px; color: #888;">
        If you did not request a password reset, no further action is required and you can safely ignore this email.
    </p>
@endcomponent
