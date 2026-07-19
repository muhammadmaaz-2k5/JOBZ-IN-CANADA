<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notification' }}</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #f3f4f6;
        }
        .header {
            background-color: #4f46e5;
            padding: 32px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 32px;
            color: #374151;
            line-height: 1.6;
        }
        .content h2 {
            font-size: 18px;
            font-weight: 800;
            color: #111827;
            margin-top: 0;
        }
        .content p {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 24px;
        }
        .btn {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 12px;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 24px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 24px 32px;
            text-align: center;
            border-top: 1px solid #f3f4f6;
        }
        .footer p {
            font-size: 11px;
            color: #9ca3af;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>JOBZ IN CANADA</h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            <p>&copy; 2026 JOBZ IN CANADA. All rights reserved.</p>
            <p>You received this email because you registered on our platform.</p>
        </div>
    </div>
</body>
</html>
