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
    <div class="absolute -right-4 -top-4 h-20 w-20 rounded-full {{ $sc['bg'] }} opacity-60 blur-xl pointer-events-none"></div>

    <div class="flex items-start justify-between relative z-10">
        <div class="flex-1">
            <p class="text-xs font-semibold tracking-widest uppercase text-gray-500 dark:text-gray-400 mb-1">{{ $label }}</p>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $value }}</p>
            @if($change)
                <p class="flex items-center gap-1 mt-2 text-xs font-semibold {{ $changeUp ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                    @if($changeUp)
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    @else
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    @endif
                    {{ $change }}
                </p>
            @endif
        </div>
        @if($icon)
            <div class="flex-shrink-0 h-12 w-12 rounded-2xl {{ $sc['bg'] }} {{ $sc['icon'] }} ring-1 {{ $sc['ring'] }} flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                {!! $icon !!}
            </div>
        @endif
    </div>
    {{ $slot }}
</div>

{{-- ── GRADIENT CARD ─────────────────────────────────────────── --}}
@elseif($variant === 'gradient')
<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-2xl bg-gradient-to-br ' . $grad . ' text-white shadow-xl ' . $pad]) }}>
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_top_right,_white_0%,_transparent_60%)] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-32 h-32 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
    <div class="relative z-10">
        @if(isset($header))
            <div class="font-bold text-lg text-white/90 mb-4 pb-3 border-b border-white/20">{{ $header }}</div>
        @endif
        {{ $slot }}
        @if(isset($footer))
            <div class="mt-4 pt-3 border-t border-white/20 text-sm text-white/70">{{ $footer }}</div>
        @endif
    </div>
</div>

{{-- ── GLASS CARD ────────────────────────────────────────────── --}}
@elseif($variant === 'glass')
<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-2xl border border-white/20 dark:border-white/5 shadow-glass transition-all duration-300 ' . ($hover ? 'hover:-translate-y-1 hover:shadow-xl hover:border-white/30' : '') . ' ' . $pad]) }}
     style="background: rgba(255,255,255,0.65); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);">
    <div class="dark:hidden absolute inset-0 rounded-2xl" style="background: rgba(255,255,255,0.65)"></div>
    <div class="hidden dark:block absolute inset-0 rounded-2xl" style="background: rgba(15,23,42,0.65)"></div>
    <div class="relative z-10">
        @if(isset($header))
            <div class="font-semibold text-gray-800 dark:text-gray-100 mb-4 pb-3 border-b border-gray-200/60 dark:border-gray-700/40">{{ $header }}</div>
        @endif
        {{ $slot }}
        @if(isset($footer))
            <div class="mt-4 pt-3 border-t border-gray-200/60 dark:border-gray-700/40 text-sm text-gray-500 dark:text-gray-400">{{ $footer }}</div>
        @endif
    </div>
</div>

{{-- ── ELEVATED CARD ─────────────────────────────────────────── --}}
@elseif($variant === 'elevated')
<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white dark:bg-dark-900 border border-gray-100 dark:border-gray-800/80 shadow-lg hover:shadow-xl transition-all duration-300 ' . ($hover ? 'hover:-translate-y-1' : '') . ' overflow-hidden']) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-dark-800/40">
            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $header }}</p>
        </div>
    @endif
    <div class="{{ $pad }}">{{ $slot }}</div>
    @if(isset($footer))
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-dark-800/40">
            {{ $footer }}
        </div>
    @endif
</div>

{{-- ── OUTLINED CARD ─────────────────────────────────────────── --}}
@elseif($variant === 'outlined')
<div {{ $attributes->merge(['class' => 'rounded-2xl bg-transparent border-2 border-gray-200 dark:border-gray-750 hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-300 overflow-hidden']) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b-2 border-gray-200 dark:border-gray-700 font-semibold text-gray-800 dark:text-gray-200">{{ $header }}</div>
    @endif
    <div class="{{ $pad }}">{{ $slot }}</div>
    @if(isset($footer))
        <div class="px-6 py-4 border-t-2 border-gray-200 dark:border-gray-750">{{ $footer }}</div>
    @endif
</div>

{{-- ── FLAT CARD ─────────────────────────────────────────────── --}}
@elseif($variant === 'flat')
<div {{ $attributes->merge(['class' => 'rounded-2xl bg-gray-50 dark:bg-dark-800/50 border-0 overflow-hidden']) }}>
    @if(isset($header))
        <div class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300 border-b border-gray-200/60 dark:border-gray-700/40">{{ $header }}</div>
    @endif
    <div class="{{ $pad }}">{{ $slot }}</div>
    @if(isset($footer))
        <div class="px-6 py-4 border-t border-gray-200/60 dark:border-gray-700/40">{{ $footer }}</div>
    @endif
</div>

{{-- ── DEFAULT CARD ──────────────────────────────────────────── --}}
@else
<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white dark:bg-dark-900 border border-gray-150 dark:border-gray-800/80 shadow-sm transition-all duration-300 overflow-hidden ' . ($hover ? 'hover:-translate-y-1 hover:shadow-md hover:border-primary-500/30' : '')]) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60 font-semibold text-gray-800 dark:text-gray-200">{{ $header }}</div>
    @endif
    <div class="{{ $pad }}">{{ $slot }}</div>
    @if(isset($footer))
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800/60 bg-gray-50/50 dark:bg-dark-800/20 rounded-b-2xl">{{ $footer }}</div>
    @endif
</div>
@endif
