@props([
    'type' => 'card',
    'rows' => 3,
])

<div {{ $attributes->merge(['class' => 'animate-pulse w-full']) }}>
    @if($type === 'card')
        <div>
            <div></div>
            <div></div>
            <div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div>
                <div></div>
                <div></div>
            </div>
        </div>
    @elseif($type === 'list')
        <div>
            @for($i = 0; $i < $rows; $i++)
                <div>
                    <div></div>
                    <div>
                        <div></div>
                        <div></div>
                    </div>
                    <div></div>
                </div>
            @endfor
        </div>
    @else
        <div></div>
    @endif
</div>
