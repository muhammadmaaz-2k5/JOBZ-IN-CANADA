@extends('emails.layout', ['subject' => 'New Job Matches For You'])

@section('content')
    <h2>Hello, {{ $user->first_name }}!</h2>
    <p>We found exciting new job listings matching your alert subscription for <strong>"{{ $keyword }}"</strong>:</p>
    
    <div style="margin-top: 30px; margin-bottom: 30px;">
        @foreach($jobs as $job)
            <div style="padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 15px;">
                <h3 style="margin-top: 0; margin-bottom: 5px; color: #0f172a; font-size: 18px;">{{ $job->title }}</h3>
                <p style="margin-top: 0; margin-bottom: 10px; color: #64748b; font-size: 14px;">
                    <strong>{{ $job->company->company_name }}</strong> &bull; {{ $job->city }}, {{ $job->country }}
                </p>
                
                <div style="margin-bottom: 15px;">
                    <span style="background-color: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-right: 5px;">
                        💼 {{ ucfirst($job->workplace_type) }}
                    </span>
                    <span style="background-color: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                        ⏱️ {{ ucfirst($job->employment_type) }}
                    </span>
                </div>
                
                <a href="{{ route('jobs.show', $job->slug) }}" style="color: #1650e1; text-decoration: none; font-weight: bold; font-size: 14px;">
                    View Posting &rarr;
                </a>
            </div>
        @endforeach
    </div>

    <p style="font-size: 13px; color: #64748b; margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
        You are receiving this email because you subscribed to keyword alerts on JOBZ IN CANADA.<br>
        To unsubscribe or manage your alert preferences, please log in to your seeker dashboard.
    </p>
@endsection
