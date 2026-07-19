<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Job Matches For You</title>
</head>
<body style="font-family: 'Segoe UI', Helvetica, Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 40px 20px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <!-- Header -->
        <tr>
            <td style="background-color: #4f46e5; padding: 40px 30px; text-align: center;">
                <h1 style="color: #ffffff; font-size: 24px; font-weight: 800; margin: 0; tracking-tight: -0.025em;">JOBZ IN CANADA</h1>
                <p style="color: #c7d2fe; font-size: 14px; margin: 5px 0 0 0; font-weight: 500;">Your Personalized Job Matches Alert</p>
            </td>
        </tr>
        
        <!-- Intro -->
        <tr>
            <td style="padding: 30px;">
                <h2 style="color: #111827; font-size: 18px; font-weight: 700; margin-top: 0;">Hello, {{ $user->first_name }}!</h2>
                <p style="color: #4b5563; font-size: 14px; line-height: 1.6; margin: 0;">We found new job listings matching your alert subscription for <strong>"{{ $keyword }}"</strong>:</p>
            </td>
        </tr>

        <!-- Matches list -->
        <tr>
            <td style="padding: 0 30px 20px 30px;">
                @foreach($jobs as $job)
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f9fafb; border-radius: 12px; border: 1px solid #f3f4f6; margin-bottom: 15px; overflow: hidden;">
                        <tr>
                            <td style="padding: 20px;">
                                <h3 style="color: #111827; font-size: 15px; font-weight: 700; margin: 0 0 5px 0;">{{ $job->title }}</h3>
                                <p style="color: #6b7280; font-size: 12px; font-weight: 600; margin: 0 0 10px 0;">{{ $job->company->company_name }} &bull; {{ $job->city }}, {{ $job->country }}</p>
                                <div style="color: #374151; font-size: 12px; line-height: 1.5; margin-bottom: 15px;">
                                    💼 {{ ucfirst($job->workplace_type) }} &bull; ⏰ {{ ucfirst($job->employment_type) }}
                                </div>
                                <a href="{{ route('jobs.show', $job->slug) }}" style="display: inline-block; background-color: #4f46e5; color: #ffffff; text-decoration: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 700; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    View Posting &rarr;
                                </a>
                            </td>
                        </tr>
                    </table>
                @endforeach
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 24px 30px; text-align: center;">
                <p style="color: #9ca3af; font-size: 11px; line-height: 1.5; margin: 0;">
                    You are receiving this email because you subscribed to keyword alerts on JOBZ IN CANADA.<br>
                    To unsubscribe or manage your alert preferences, please log in to your seeker dashboard.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
