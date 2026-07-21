<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Job Matches For You</title>
</head>
<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- Header -->
        <tr>
            <td>
                <h1>JOBZ IN CANADA</h1>
                <p>Your Personalized Job Matches Alert</p>
            </td>
        </tr>
        
        <!-- Intro -->
        <tr>
            <td>
                <h2>Hello, {{ $user->first_name }}!</h2>
                <p>We found new job listings matching your alert subscription for <strong>"{{ $keyword }}"</strong>:</p>
            </td>
        </tr>

        <!-- Matches list -->
        <tr>
            <td>
                @foreach($jobs as $job)
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <h3>{{ $job->title }}</h3>
                                <p>{{ $job->company->company_name }} &bull; {{ $job->city }}, {{ $job->country }}</p>
                                <div>
                                    💼 {{ ucfirst($job->workplace_type) }} &bull; ⏰ {{ ucfirst($job->employment_type) }}
                                </div>
                                <a href="{{ route('jobs.show', $job->slug) }}">
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
            <td>
                <p>
                    You are receiving this email because you subscribed to keyword alerts on JOBZ IN CANADA.<br>
                    To unsubscribe or manage your alert preferences, please log in to your seeker dashboard.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
