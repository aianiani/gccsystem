<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'GCC System') }}</title>
    <style>
        /* Basic reset */
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Inter", Arial, sans-serif;
            color: #1f2933;
            -webkit-font-smoothing: antialiased;
        }
        table {
            border-collapse: collapse;
        }
        img {
            border: 0;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            display: block;
        }
        a {
            color: #2d5016;
            text-decoration: none;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8f9fa; /* homepage bg-light */
            padding: 0;
        }
        .main {
            width: 100%;
            max-width: 720px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
        }
        .header {
            background-color: #228B22; /* primary-green */
            padding: 14px 28px 14px 28px;
            color: #ffffff;
        }
        .header-inner {
            max-width: 640px;
            margin: 0 auto;
            display: table;
            width: 100%;
        }
        .header-logo {
            display: table-cell;
            vertical-align: middle;
            width: 64px;
        }
        .header-logo img {
            display: block;
            width: 56px;
            height: auto;
            border-radius: 50%;
        }
        .header-text {
            display: table-cell;
            vertical-align: middle;
            padding-left: 12px;
            text-align: left;
        }
        .header-title {
            font-size: 17px;
            font-weight: 600;
            margin: 0 0 2px 0;
        }
        .header-subtitle {
            font-size: 12px;
            margin: 0;
            opacity: 0.9;
        }
        .body {
            padding: 24px 28px 26px 28px;
            background-color: #ffffff;
        }
        .content-inner {
            max-width: 520px;
            margin: 0 auto;
            text-align: left;
        }
        .body h1,
        .body h2,
        .body h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #1f2933;
            font-weight: 600;
        }
        .body p,
        .body li {
            margin-top: 0;
            margin-bottom: 10px;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
        }
        .footer {
            padding: 18px 32px 24px 32px;
            font-size: 12px;
            color: #6b7280;
            background-color: #f9fafb;
            text-align: center;
        }
        .badge-label {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background-color: #fef9e7;
            color: #2d5016;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }
        .button-primary {
            display: inline-block;
            padding: 12px 28px;
            border-radius: 999px;
            background-color: #2d5016;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            margin: 12px 0;
        }
        .button-primary:hover {
            background-color: #4a7c59;
        }
        .muted {
            color: #6b7280;
            font-size: 13px;
        }
        @media (max-width: 640px) {
            .main {
                border-radius: 0;
            }
            .header,
            .body,
            .footer {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="main" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="header">
                            <div class="header-inner">
                                <div class="header-logo">
                                    <img src="{{ asset('images/logo.jpg') }}" alt="CMU GCC Logo">
                                </div>
                                <div class="header-text">
                                    <span class="badge-label">{{ $preheader ?? 'CMU Guidance & Counseling Center' }}</span>
                                    <h1 class="header-title">
                                        {{ $heading ?? ($title ?? config('app.name', 'GCC System')) }}
                                    </h1>
                                    @isset($intro)
                                        <p class="header-subtitle">{{ $intro }}</p>
                                    @endisset
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="body">
                            <div class="content-inner">
                                {{ $slot }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="footer">
                            <p class="muted" style="margin: 0 0 4px 0;">
                                This is an automated message from the CMU Guidance & Counseling Center system.
                            </p>
                            <p class="muted" style="margin: 0;">
                                &copy; {{ date('Y') }} {{ config('app.name', 'GCC System') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>


