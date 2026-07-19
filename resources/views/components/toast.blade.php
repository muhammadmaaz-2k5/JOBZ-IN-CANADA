@props([
    'type' => 'success',
    'message' => '',
    'duration' => 4000,
])

@php
    $bgColor = match($type) {
        'success' => 'bg-emerald-500 text-white',
        'warning' => 'bg-amber-500 text-white',
        'danger' => 'bg-rose-500 text-white',
        default => 'bg-blue-600 text-white',
    };
@endphp

<div x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, {{ $duration }})"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="max-w-md w-full glass shadow-premium rounded-2xl pointer-events-auto flex ring-1 ring-black/5 overflow-hidden border border-gray-100 dark:border-gray-800"
>
    <div class="flex-1 w-0 p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0 pt-0.5">
                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full {{ $bgColor }}">
                    @if($type === 'success')
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    @elseif($type === 'warning')
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    @elseif($type === 'danger')
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @else
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                </span>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    {{ ucfirst($type) }}
                </p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $message ?: $slot }}
                </p>
            </div>
        </div>
    </div>
    <div class="flex border-l border-gray-100 dark:border-gray-800">
        <button @click="show = false" class="w-full border border-transparent rounded-none rounded-r-2xl p-4 flex items-center justify-center text-sm font-semibold text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
            Close
        </button>
    </div>
</div>
