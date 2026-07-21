@extends('emails.layout', ['subject' => 'Verify Your Email Address'])

@section('content')
    <h2>Confirm Your Email Address</h2>
    <p>Please click the secure confirmation button below to verify your email address and activate your account on JOBZ IN CANADA.</p>
    <div>
        <a href="{{ $url }}">Verify Email Address</a>
    </div>
    <p>This verification link is active for 60 minutes. If you did not register for an account, no further action is required.</p>
@endsection
