@extends('emails.layout', ['subject' => 'Verify Your Email Address'])

@section('content')
    <h2>Confirm Your Email Address</h2>
    <p>Hi there,</p>
    <p>Please enter the secure 6-digit confirmation code below to verify your email address and activate your account on JOBZ IN CANADA. Once verified, you'll have full access to our platform features.</p>
    
    <div class="button-wrap" style="margin: 30px 0; text-align: center;">
        <div style="display: inline-block; padding: 15px 30px; background-color: #f1f5f9; border: 2px dashed #1650e1; border-radius: 12px; font-size: 32px; font-weight: 800; letter-spacing: 4px; color: #1650e1;">
            {{ $code }}
        </div>
    </div>
    
    <p style="font-size: 14px; color: #64748b;">This verification code is active for 15 minutes. If you did not register for an account, no further action is required.</p>
@endsection
