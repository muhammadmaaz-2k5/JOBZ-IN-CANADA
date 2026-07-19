@props([
    'title' => 'No items found',
    'description' => 'Try expanding your search criteria or add new items.',
    'actionText' => '',
    'actionUrl' => '',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center p-8 border-2 border-dashed border-gray-200 dark:border-gray-800/80 rounded-2xl bg-gray-50/30 dark:bg-dark-900/10']) }}>
    <div class="h-16 w-16 bg-primary-50 dark:bg-primary-950/20 text-primary-500 rounded-full flex items-center justify-center mb-4">
        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0120.25 21H3.75A2.25 2.25 0 011.5 18.75v-4.5A2.25 2.25 0 012.25 13.5zm2.25-10.5h15a2.25 2.25 0 012.25 2.25v6.75a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V5.25A2.25 2.25 0 014.5 3z" />
        </svg>
    </div>
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
        {{ $title }}
    </h3>
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-sm">
        {{ $description }}
    </p>
    @if($actionText && $actionUrl)
        <div class="mt-6">
            <a href="{{ $actionUrl }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 focus:outline-none transition-colors duration-150">
                {{ $actionText }}
            </a>
        </div>
    @endif
</div>
