<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Promote Job Listing') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 space-y-6">
                
                <div>
                    <h3 class="font-extrabold text-lg text-gray-900 dark:text-white">Promote to Featured Listing</h3>
                    <p class="text-xs text-gray-500 mt-1">Get your job posting highlighted at the top of candidate feeds, search results, and email alerts.</p>
                </div>

                <div class="p-4 bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-150 rounded-xl text-xs font-semibold text-indigo-950 dark:text-indigo-300">
                    Job Posting: <span class="font-bold">"{{ $job->title }}"</span>
                </div>

                <form method="POST" action="{{ route('employer.jobs.promote.submit', $job->id) }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <x-input-label for="duration_days" :value="__('Select Promotion Duration')" />
                        <select id="duration_days" name="duration_days" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs shadow-sm">
                            <option value="7">7 Days - $10 CAD</option>
                            <option value="15">15 Days - $18 CAD</option>
                            <option value="30" selected>30 Days - $30 CAD</option>
                            <option value="60">60 Days - $50 CAD</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="coupon_code" :value="__('Apply Promo Coupon')" />
                        <x-text-input id="coupon_code" name="coupon_code" type="text" class="mt-1 block w-full text-xs" placeholder="ENTER COUPON CODE" />
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                        Purchase Promotion (Mock Checkout)
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
