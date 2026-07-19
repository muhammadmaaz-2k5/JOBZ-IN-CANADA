@props([
    'type' => 'card',
    'rows' => 3,
])

<div {{ $attributes->merge(['class' => 'animate-pulse w-full']) }}>
    @if($type === 'card')
        <div class="bg-gray-100 dark:bg-gray-700/40 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-lg w-1/3 mb-4"></div>
            <div class="h-8 bg-gray-200 dark:bg-gray-700 rounded-lg w-2/3 mb-6"></div>
            <div class="space-y-3">
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-lg w-full"></div>
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-lg w-5/6"></div>
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-lg w-4/5"></div>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-200/60 dark:border-gray-800/40 flex justify-between">
                <div class="h-8 bg-gray-200 dark:bg-gray-700 rounded-lg w-24"></div>
                <div class="h-8 bg-gray-200 dark:bg-gray-700 rounded-lg w-16"></div>
            </div>
        </div>
    @elseif($type === 'list')
        <div class="space-y-4">
            @for($i = 0; $i < $rows; $i++)
                <div class="flex items-center space-x-4 p-4 border border-gray-100 dark:border-gray-800/80 rounded-xl">
                    <div class="h-10 w-10 bg-gray-200 dark:bg-gray-700 rounded-full flex-shrink-0"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-lg w-1/4"></div>
                        <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-lg w-3/4"></div>
                    </div>
                    <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded-lg w-16"></div>
                </div>
            @endfor
        </div>
    @else
        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-lg w-full"></div>
    @endif
</div>
