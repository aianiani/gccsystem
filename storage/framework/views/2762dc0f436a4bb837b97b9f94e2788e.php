<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? config('app.name', 'GCC System')); ?></title>
    <style>
        /* Basic reset */
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #333333;
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
        }

        a {
            color: #228B22;
            text-decoration: none;
        }

        .wrapper {
            width: 100%;
            background-color: #f4f4f4;
            padding: 20px 0;
        }

        .main {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            padding: 30px 40px;
            text-align: center;
            border-bottom: 1px solid #e5e5e5;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .body {
            padding: 40px;
        }

        .body h2 {
            margin: 0 0 20px 0;
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .body p {
            margin: 0 0 15px 0;
            color: #555555;
            font-size: 15px;
            line-height: 1.6;
        }

        .body ul,
        .body ol {
            margin: 0 0 15px 0;
            padding-left: 20px;
        }

        .body li {
            margin-bottom: 8px;
            color: #555555;
            font-size: 15px;
            line-height: 1.6;
        }

        .info-box {
            background-color: #f9f9f9;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-box p {
            margin: 5px 0;
            font-size: 14px;
        }

        .info-box strong {
            color: #1a1a1a;
        }

        .code-box {
            background-color: #f9f9f9;
            border: 2px solid #228B22;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .code-box .code {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 8px;
            color: #1a1a1a;
            font-family: "Courier New", monospace;
        }

        .button {
            display: inline-block;
            padding: 14px 32px;
            background-color: #228B22;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            margin: 10px 0;
            text-align: center;
        }

        .button:hover {
            background-color: #1a6b1a;
        }

        .button-center {
            text-align: center;
            margin: 25px 0;
        }

        .footer {
            padding: 30px 40px;
            text-align: center;
            background-color: #f9f9f9;
            border-top: 1px solid #e5e5e5;
        }

        .footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #888888;
        }

        .divider {
            height: 1px;
            background-color: #e5e5e5;
            margin: 20px 0;
        }

        @media (max-width: 640px) {
            .main {
                border-radius: 0;
            }

            .header,
            .body,
            .footer {
                padding: 25px 20px !important;
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
                            <?php
                                $logoPath = public_path('images/logo.jpg');
                            ?>
                            <?php if(file_exists($logoPath)): ?>
                                <?php if(isset($message)): ?>
                                    <img src="<?php echo e($message->embed($logoPath)); ?>" alt="GCC Logo"
                                        style="max-height: 80px; margin-bottom: 15px;">
                                <?php else: ?>
                                    <img src="<?php echo e(url('images/logo.jpg')); ?>" alt="GCC Logo"
                                        style="max-height: 80px; margin-bottom: 15px;">
                                <?php endif; ?>
                            <?php endif; ?>
                            <h1><?php echo e($heading ?? ($title ?? config('app.name', 'GCC System'))); ?></h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="body">
                            <?php echo e($slot); ?>

                        </td>
                    </tr>
                    <tr>
                        <td class="footer">
                            <p>This is an automated message from the CMU Guidance & Counseling Center.</p>
                            <p>&copy; <?php echo e(date('Y')); ?> CMU Guidance & Counseling Center. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/layouts/base.blade.php ENDPATH**/ ?>