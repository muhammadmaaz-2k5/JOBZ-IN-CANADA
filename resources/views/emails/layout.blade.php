<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notification' }}</title>
</head>
<body>
    <div>
        <div>
            <h1>JOBZ IN CANADA</h1>
        </div>
        <div>
            @yield('content')
        </div>
        <div>
            <p>&copy; 2026 JOBZ IN CANADA. All rights reserved.</p>
            <p>You received this email because you registered on our platform.</p>
        </div>
    </div>
</body>
</html>
