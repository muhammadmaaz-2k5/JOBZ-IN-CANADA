@extends('emails.layout', ['subject' => 'Welcome to JOBZ IN CANADA'])

@section('content')
    <h2>Welcome, {{ $user->first_name }}!</h2>
    <p>We are absolutely thrilled to welcome you to JOBZ IN CANADA—your gateway to finding outstanding employment and building your dream career in Canada.</p>
    <p>To start exploring, configure your profile details, upload your default professional resume, and browse thousands of verified listings.</p>
    <div style="text-align: center;">
        <a href="{{ url('/login') }}" class="btn">Explore Job Listings &rarr;</a>
    </div>
    <p>If you have any questions or require support, reply to this email to contact our candidate assistance team.</p>
@endsection
