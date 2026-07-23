@extends('emails.layout', ['subject' => 'Application Status Update'])

@section('content')
    <h2>Update on Your Job Application</h2>
    <p>Hello {{ $application->user->first_name }},</p>
    <p>There has been an update to your job application for the position of <strong>{{ $application->job->title }}</strong> at <strong>{{ $application->job->company->company_name }}</strong>.</p>
    
    <div style="background-color: #f1f5f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #1650e1;">
        <p style="margin: 0;"><strong>Current Status:</strong> <span style="color: #1650e1; font-weight: bold; text-transform: uppercase;">{{ ucfirst($application->status) }}</span></p>
    </div>
    
    @if ($application->status === 'shortlisted')
        <p style="color: #059669; font-weight: bold;">🎉 Congratulations! The recruitment team has shortlisted your profile.</p>
        <p>They will reach out to you shortly to schedule an interview. Make sure to keep an eye on your inbox.</p>
    @elseif ($application->status === 'rejected')
        <p>Thank you for taking the time to apply. Unfortunately, they have decided to move forward with other candidates at this stage. Keep exploring other amazing opportunities on our platform!</p>
    @endif

    <div class="button-wrap">
        <a href="{{ route('seeker.applications.index') }}" class="button">View Application Status</a>
    </div>
@endsection
