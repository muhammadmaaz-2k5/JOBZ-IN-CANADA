@extends('emails.layout', ['subject' => $subjectLine ?? 'Application Notification'])

@section('content')
    <h2>{{ $subjectLine }}</h2>
    
    <p>{{ $line1 }}</p>
    
    @if(isset($line2))
        <p>{{ $line2 }}</p>
    @endif
    
    @if(isset($actionUrl))
        <div class="button-wrap">
            <a href="{{ $actionUrl }}" class="button">{{ $actionText }}</a>
        </div>
    @endif
@endsection
