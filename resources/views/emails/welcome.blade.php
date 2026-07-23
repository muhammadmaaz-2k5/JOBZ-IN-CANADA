@extends('emails.layout', ['subject' => 'Welcome to JOBZ IN CANADA'])

@section('content')
    <h2>Welcome, {{ $user->first_name }}!</h2>
    <p>We are absolutely thrilled to welcome you to <strong>JOBZ IN CANADA</strong> &mdash; your premium gateway to finding outstanding employment and building your dream career in Canada.</p>
    
    <p>To start exploring, we recommend configuring your profile details and uploading your professional resume to stand out to employers.</p>
    
    <div class="button-wrap">
        <a href="{{ url('/login') }}" class="button">Explore Job Listings &rarr;</a>
    </div>
    
    <p>If you have any questions, require support, or want to share feedback, simply reply to this email to contact our candidate assistance team. We're here to help you succeed.</p>
@endsection
