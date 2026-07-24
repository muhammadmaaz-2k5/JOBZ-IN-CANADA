<x-app-layout>
    <x-slot name="header">
        Promote Job Listing
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">
        
        <!-- Decorative blurred background elements -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-purple-400/10 blur-[120px]"></div>
            <div class="absolute bottom-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-pink-400/10 blur-[120px]"></div>
        </div>

        <div class="mb-8 text-center">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-500 inline-block mb-3">
                Promote to Featured Listing
            </h1>
            <p class="text-lg text-slate-500 dark:text-slate-400 font-medium max-w-2xl mx-auto">
                Get your job posting highlighted at the top of candidate feeds, search results, and email alerts.
            </p>
        </div>

        <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-2xl rounded-3xl overflow-hidden p-8 sm:p-10">
            
            <div class="flex items-center gap-4 p-5 mb-8 bg-slate-50/80 dark:bg-slate-800/80 rounded-2xl border border-slate-100 dark:border-slate-700">
                <div class="w-12 h-12 bg-white dark:bg-slate-900 rounded-xl shadow-sm flex items-center justify-center shrink-0 border border-slate-200 dark:border-slate-700 text-purple-600 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Target Job Posting</h3>
                    <p class="text-xl font-bold text-slate-800 dark:text-slate-200">{{ $job->title }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('employer.jobs.promote.submit', $job->id) }}" class="space-y-8">
                @csrf
                
                <div>
                    <x-input-label value="Select Promotion Duration" class="text-lg font-bold mb-4" />
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="duration_days" value="7" class="peer sr-only">
                            <div class="p-5 rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-slate-700 dark:text-slate-300 peer-checked:text-purple-700 dark:peer-checked:text-purple-400 text-lg">7 Days</span>
                                    <span class="font-black text-xl text-slate-900 dark:text-white">$10 CAD</span>
                                </div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Quick boost for immediate visibility.</p>
                            </div>
                        </label>
                        
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="duration_days" value="15" class="peer sr-only">
                            <div class="p-5 rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-slate-700 dark:text-slate-300 peer-checked:text-purple-700 dark:peer-checked:text-purple-400 text-lg">15 Days</span>
                                    <span class="font-black text-xl text-slate-900 dark:text-white">$18 CAD</span>
                                </div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Perfect for standard hiring timelines.</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="duration_days" value="30" checked class="peer sr-only">
                            <div class="p-5 rounded-2xl border-2 border-purple-200 dark:border-purple-700 bg-white dark:bg-slate-800 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all relative overflow-hidden">
                                <div class="absolute top-0 right-0 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg uppercase tracking-wider shadow-sm">Most Popular</div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-slate-700 dark:text-slate-300 peer-checked:text-purple-700 dark:peer-checked:text-purple-400 text-lg">30 Days</span>
                                    <span class="font-black text-xl text-slate-900 dark:text-white">$30 CAD</span>
                                </div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Maximum exposure and candidate reach.</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="duration_days" value="60" class="peer sr-only">
                            <div class="p-5 rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-slate-700 dark:text-slate-300 peer-checked:text-purple-700 dark:peer-checked:text-purple-400 text-lg">60 Days</span>
                                    <span class="font-black text-xl text-slate-900 dark:text-white">$50 CAD</span>
                                </div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Long-term hiring for hard-to-fill roles.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-slate-700/50">
                    <x-input-label for="coupon_code" value="Apply Promo Coupon" class="text-lg font-bold mb-3" />
                    <div class="flex gap-3">
                        <x-text-input id="coupon_code" name="coupon_code" type="text" placeholder="ENTER COUPON CODE" class="flex-1 px-5 py-3 rounded-xl bg-white dark:bg-slate-800/50 font-medium uppercase tracking-widest placeholder:normal-case placeholder:tracking-normal" />
                        <button type="button" class="px-6 py-3 bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-bold rounded-xl transition-colors shrink-0">
                            Apply
                        </button>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-black text-lg rounded-xl shadow-xl shadow-purple-500/30 hover:shadow-2xl hover:shadow-purple-500/40 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Purchase Promotion (Mock Checkout)
                    </button>
                    <p class="text-center text-xs text-slate-500 mt-4 font-medium">By proceeding, you agree to our terms of service and billing policies. This is a mock checkout.</p>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
