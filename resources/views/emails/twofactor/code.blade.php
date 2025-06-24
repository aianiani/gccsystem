<x-mail::message>
# Hello {{ $userName }},

Your Two-Factor Authentication (2FA) code is:

# **{{ $code }}**

Please enter this code to complete your login. This code will expire in 5 minutes.

If you did not request this code, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
