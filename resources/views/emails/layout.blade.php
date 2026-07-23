<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notification' }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f8fafc; padding-bottom: 40px; }
        .main { margin: 0 auto; width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; margin-top: 40px; border: 1px solid #e2e8f0; }
        .header { background-color: #1650e1; padding: 30px 40px; text-align: center; }
        .header h1 { margin: 0; color: #ffffff; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }
        .header h1 span { color: #93c5fd; }
        .content { padding: 40px; color: #334155; line-height: 1.6; font-size: 16px; }
        .content h2 { color: #0f172a; font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 20px; }
        .content p { margin-top: 0; margin-bottom: 20px; }
        .button-wrap { text-align: center; margin: 30px 0; }
        .button { display: inline-block; padding: 14px 28px; background-color: #1650e1; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; text-align: center; font-size: 16px; }
        .footer { padding: 30px 40px; text-align: center; color: #94a3b8; font-size: 13px; line-height: 1.5; border-top: 1px solid #e2e8f0; }
        .footer p { margin: 0 0 10px 0; }
        .footer a { color: #1650e1; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="header">
                    <h1>JOBZ IN <span>CANADA</span></h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    @yield('content')
                </td>
            </tr>
            <tr>
                <td class="footer">
                    <p>&copy; {{ date('Y') }} JOBZ IN CANADA. All rights reserved.</p>
                    <p>You received this email because you are registered on our platform.</p>
                    <p>250 Yonge St, Toronto, ON</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
