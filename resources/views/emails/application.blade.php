<x-mail::message>
# {{ $subjectLine }}

{{ $line1 }}

@if(isset($line2))
{{ $line2 }}
@endif

@if(isset($actionUrl))
<x-mail::button :url="$actionUrl">
{{ $actionText }}
</x-mail::button>
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
