<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GCC System') }}</title>
    <style>
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
        .body {
            padding: 26px 28px 20px 28px;
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
        .body h1 {
            font-size: 22px;
        }
        .body p,
        .body li {
            margin-top: 0;
            margin-bottom: 10px;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
        }
        .subcopy {
            margin-top: 18px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            font-size: 13px;
            color: #6b7280;
        }
        .footer {
            padding: 16px 32px 22px 32px;
            font-size: 12px;
            color: #6b7280;
            background-color: #f9fafb;
            text-align: center;
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
                                <div style="display: inline-block; padding: 4px 14px; border-radius: 999px; background-color: #fef9e7; color: #2d5016; font-size: 12px; font-weight: 600; letter-spacing: 0.03em; text-transform: uppercase;">
                                    CMU Guidance &amp; Counseling Center
                                </div>
                                <p style="margin: 4px 0 0 0; font-size: 12px; opacity: 0.95;">
                                    Supporting your well‑being through secure and guided services.
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="body">
                        <div class="content-inner">
                            {!! Illuminate\Mail\Markdown::parse($slot) !!}

                            @isset($subcopy)
                                <div class="subcopy">
                                    {!! Illuminate\Mail\Markdown::parse($subcopy) !!}
                                </div>
                            @endisset
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="footer">
                        <p style="margin: 0 0 4px 0;">
                            This is an automated message from the CMU Guidance &amp; Counseling Center system.
                        </p>
                        <p style="margin: 0;">
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
