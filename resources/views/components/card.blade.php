@props([
    'variant'  => 'default',   // default | glass | gradient | elevated | outlined | flat | stat | job
    'hover'    => false,
    'padding'  => 'md',        // sm | md | lg | none
    'color'    => 'blue',      // blue | green | purple | amber | rose | indigo — used by stat/gradient
    // Stat card props
    'label'    => '',
    'value'    => '',
    'change'   => '',
    'changeUp' => true,
    'icon'     => '',
])

@php
    $paddings = [
        'none' => '',
        'sm'   => 'p-4',
        'md'   => 'p-6',
        'lg'   => 'p-8',
    ];
    $pad = $paddings[$padding] ?? 'p-6';

    $gradients = [
        'blue'   => 'from-blue-600 to-indigo-700',
        'green'  => 'from-emerald-500 to-teal-600',
        'purple' => 'from-violet-600 to-purple-700',
        'amber'  => 'from-amber-500 to-orange-600',
        'rose'   => 'from-rose-500 to-pink-600',
        'indigo' => 'from-indigo-600 to-violet-700',
    ];
    $grad = $gradients[$color] ?? $gradients['blue'];

    $statColors = [
        'blue'   => ['bg' => 'bg-blue-50 dark:bg-blue-950/30',   'icon' => 'text-blue-600 dark:text-blue-400',   'ring' => 'ring-blue-100 dark:ring-blue-900/40'],
        'green'  => ['bg' => 'bg-emerald-50 dark:bg-emerald-950/30', 'icon' => 'text-emerald-600 dark:text-emerald-400', 'ring' => 'ring-emerald-100 dark:ring-emerald-900/40'],
        'purple' => ['bg' => 'bg-violet-50 dark:bg-violet-950/30',  'icon' => 'text-violet-600 dark:text-violet-400',   'ring' => 'ring-violet-100 dark:ring-violet-900/40'],
        'amber'  => ['bg' => 'bg-amber-50 dark:bg-amber-950/30',   'icon' => 'text-amber-600 dark:text-amber-400',   'ring' => 'ring-amber-100 dark:ring-amber-900/40'],
        'rose'   => ['bg' => 'bg-rose-50 dark:bg-rose-950/30',    'icon' => 'text-rose-600 dark:text-rose-400',    'ring' => 'ring-rose-100 dark:ring-rose-900/40'],
        'indigo' => ['bg' => 'bg-indigo-50 dark:bg-indigo-950/30',  'icon' => 'text-indigo-600 dark:text-indigo-400',  'ring' => 'ring-indigo-100 dark:ring-indigo-900/40'],
    ];
    $sc = $statColors[$color] ?? $statColors['blue'];
@endphp

{{-- ── STAT CARD ─────────────────────────────────────────────── --}}
@if($variant === 'stat')
<div {{ $attributes->merge(['class' => 'card-base group relative overflow-hidden rounded-2xl bg-white dark:bg-dark-900 border border-gray-100 dark:border-gray-800/80 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 ' . $pad]) }}>
    {{-- Decorative circle --}}
    <div></div>

    <div>
        <div>
            <p>{{ $label }}</p>
            <p>{{ $value }}</p>
            @if($change)
                <p>
                    @if($changeUp)
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    @else
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    @endif
                    {{ $change }}
                </p>
            @endif
        </div>
        @if($icon)
            <div>
                {!! $icon !!}
            </div>
        @endif
    </div>
    {{ $slot }}
</div>

{{-- ── GRADIENT CARD ─────────────────────────────────────────── --}}
@elseif($variant === 'gradient')
<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-2xl bg-gradient-to-br ' . $grad . ' text-white shadow-xl ' . $pad]) }}>
    <div></div>
    <div></div>
    <div>
        @if(isset($header))
            <div>{{ $header }}</div>
        @endif
        {{ $slot }}
        @if(isset($footer))
            <div>{{ $footer }}</div>
        @endif
    </div>
</div>

{{-- ── GLASS CARD ────────────────────────────────────────────── --}}
@elseif($variant === 'glass')
<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-2xl border border-white/20 dark:border-white/5 shadow-glass transition-all duration-300 ' . ($hover ? 'hover:-translate-y-1 hover:shadow-xl hover:border-white/30' : '') . ' ' . $pad]) }}>
    <div></div>
    <div></div>
    <div>
        @if(isset($header))
            <div>{{ $header }}</div>
        @endif
        {{ $slot }}
        @if(isset($footer))
            <div>{{ $footer }}</div>
        @endif
    </div>
</div>

{{-- ── ELEVATED CARD ─────────────────────────────────────────── --}}
@elseif($variant === 'elevated')
<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white dark:bg-dark-900 border border-gray-100 dark:border-gray-800/80 shadow-lg hover:shadow-xl transition-all duration-300 ' . ($hover ? 'hover:-translate-y-1' : '') . ' overflow-hidden']) }}>
    @if(isset($header))
        <div>
            <p>{{ $header }}</p>
        </div>
    @endif
    <div>{{ $slot }}</div>
    @if(isset($footer))
        <div>
            {{ $footer }}
        </div>
    @endif
</div>

{{-- ── OUTLINED CARD ─────────────────────────────────────────── --}}
@elseif($variant === 'outlined')
<div {{ $attributes->merge(['class' => 'rounded-2xl bg-transparent border-2 border-gray-200 dark:border-gray-750 hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-300 overflow-hidden']) }}>
    @if(isset($header))
        <div>{{ $header }}</div>
    @endif
    <div>{{ $slot }}</div>
    @if(isset($footer))
        <div>{{ $footer }}</div>
    @endif
</div>

{{-- ── FLAT CARD ─────────────────────────────────────────────── --}}
@elseif($variant === 'flat')
<div {{ $attributes->merge(['class' => 'rounded-2xl bg-gray-50 dark:bg-dark-800/50 border-0 overflow-hidden']) }}>
    @if(isset($header))
        <div>{{ $header }}</div>
    @endif
    <div>{{ $slot }}</div>
    @if(isset($footer))
        <div>{{ $footer }}</div>
    @endif
</div>

{{-- ── DEFAULT CARD ──────────────────────────────────────────── --}}
@else
<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800/80 shadow-sm transition-all duration-300 overflow-hidden ' . ($hover ? 'hover:-translate-y-1 hover:shadow-md hover:border-primary-500/30' : '')]) }}>
    @if(isset($header))
        <div>{{ $header }}</div>
    @endif
    <div>{{ $slot }}</div>
    @if(isset($footer))
        <div>{{ $footer }}</div>
    @endif
</div>
@endif
