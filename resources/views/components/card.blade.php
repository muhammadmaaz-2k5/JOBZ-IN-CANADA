@props([
    'glass' => false,
    'hover' => false,
])

<div {{ $attributes->merge([
    'class' => 'rounded-2xl border transition-all duration-300 ' . 
        ($glass 
            ? 'glass shadow-glass ' 
            : 'bg-white dark:bg-dark-800 border-gray-100 dark:border-gray-800 shadow-premium ') .
        ($hover 
            ? 'hover:-translate-y-1 hover:shadow-lg hover:border-primary-500/30 ' 
            : '')
]) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60 font-semibold text-gray-800 dark:text-gray-200">
            {{ $header }}
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800/60 bg-gray-50/50 dark:bg-gray-800/20 rounded-b-2xl">
            {{ $footer }}
        </div>
    @endif
</div>
