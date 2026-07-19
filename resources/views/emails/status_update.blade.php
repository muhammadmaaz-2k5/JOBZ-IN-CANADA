@extends('emails.layout', ['subject' => 'Application Status Update'])

@section('content')
    <h2>Update on Your Job Application</h2>
    <p>Hello {{ $application->user->first_name }},</p>
    <p>There has been an update to your job application for the position of <strong>{{ $application->job->title }}</strong> at <strong>{{ $application->job->company->company_name }}</strong>.</p>
    <p>Your application status is now updated to: <strong>{{ ucfirst($application->status) }}</strong>.</p>
    
    @if ($application->status === 'shortlisted')
        <p>Congratulations! The recruitment team has shortlisted your profile. They will reach out to you shortly to schedule an interview.</p>
    @elseif ($application->status === 'rejected')
        <p>Thank you for taking the time to apply. Unfortunately, they have decided to move forward with other candidates at this stage.</p>
    @endif

    <div style="text-align: center;">
        <a href="{{ route('seeker.applications.index') }}" class="btn">View Application Status</a>
    </div>
@endsection
