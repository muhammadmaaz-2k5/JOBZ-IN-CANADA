<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="p-2 bg-amber-100 dark:bg-amber-900/30 text-amber-500 dark:text-amber-400 rounded-xl">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </span>
                {{ __('Premium Profile Boost') }}
            </h2>
            <a href="{{ route('seeker.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="hidden sm:inline">Dashboard</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 dark:bg-[#0f172a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-green-500/10 border border-green-500/20 text-green-700 dark:text-green-400 rounded-2xl flex items-center gap-3 backdrop-blur-sm shadow-sm">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Active Status panel -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-amber-900/5 border border-gray-100 dark:border-gray-700/60 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-500/5 to-orange-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2">Current Status</h3>
                        @if($boost && $boost->isValid())
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-4 py-1.5 bg-gradient-to-r from-amber-400 to-orange-500 text-white font-black text-sm tracking-wider uppercase rounded-xl shadow-lg shadow-amber-500/30">
                                    ⭐ Boost Active
                                </span>
                                <span class="text-sm font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900/50 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700">Expires: {{ $boost->expires_at->format('M d, Y H:i') }}</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">Your resume is featured at the top of recruiter searches, candidate recommendations, and has priority placement.</p>
                        @else
                            <div class="mb-2">
                                <span class="px-4 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-black text-sm tracking-wider uppercase rounded-xl border border-gray-200 dark:border-gray-600">
                                    Not Boosted
                                </span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">Select a profile boost duration below to stand out to verified recruiters hiring in Canada.</p>
                        @endif
                    </div>
                    @if($boost && $boost->isValid())
                        <div class="shrink-0 hidden md:block">
                            <div class="w-24 h-24 bg-gradient-to-tr from-amber-300 to-orange-500 rounded-full flex items-center justify-center shadow-2xl shadow-amber-500/40 relative">
                                <div class="absolute inset-0 border-4 border-white dark:border-gray-800 rounded-full opacity-50 scale-110"></div>
                                <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Promotion options & checkout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Boost Plan options card -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 relative">
                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white">Choose Boost Duration</h3>
                    </div>
                    
                    <form method="POST" action="{{ route('seeker.boost.submit') }}" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach([7 => 5, 15 => 9, 30 => 15] as $days => $price)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="duration_days" value="{{ $days }}" @if($days == 30) checked @endif class="peer sr-only" />
                                    <div class="h-full flex flex-col p-6 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-100 dark:border-gray-700 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 dark:peer-checked:bg-amber-900/20 hover:border-amber-200 dark:hover:border-amber-800 transition-all shadow-sm hover:shadow peer-checked:shadow-amber-500/10">
                                        
                                        @if($days == 30)
                                            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                                                <span class="bg-gradient-to-r from-orange-500 to-amber-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-sm">Best Value</span>
                                            </div>
                                        @endif
                                        
                                        <div class="text-center mb-4">
                                            <span class="block text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">{{ $days }} Days</span>
                                            <span class="block text-4xl font-black text-gray-900 dark:text-white">${{ $price }}</span>
                                            <span class="block text-xs font-bold text-gray-400 mt-1">CAD</span>
                                        </div>
                                        
                                        <div class="mt-auto hidden peer-checked:flex items-center justify-center">
                                            <div class="w-6 h-6 bg-amber-500 rounded-full flex items-center justify-center text-white shadow-inner">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        </div>
                                        <div class="mt-auto flex peer-checked:hidden items-center justify-center">
                                            <div class="w-6 h-6 border-2 border-gray-200 dark:border-gray-600 rounded-full group-hover:border-amber-300 transition-colors"></div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                            <x-input-label for="coupon_code" :value="__('Have a promo code?')" class="font-bold text-gray-700 dark:text-gray-300" />
                            <div class="mt-2 flex gap-3">
                                <x-text-input id="coupon_code" name="coupon_code" type="text" placeholder="DISCOUNT CODE" class="block w-full uppercase font-mono tracking-widest focus:ring-amber-500 focus:border-amber-500 form-input-premium" />
                                <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-bold rounded-xl transition-colors shrink-0">Apply</button>
                            </div>
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-lg font-black uppercase tracking-widest rounded-xl shadow-xl shadow-amber-500/30 transition-all hover:-translate-y-0.5 focus:ring-4 focus:ring-amber-500/20">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            Boost My Profile Now
                        </button>
                    </form>
                </div>

                <!-- Premium benefits checklist -->
                <div class="bg-gradient-to-br from-gray-900 to-[#0f172a] rounded-3xl p-6 md:p-8 shadow-2xl border border-gray-800 relative overflow-hidden text-white">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-amber-500/20 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-800">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center border border-amber-500/30">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                            <h4 class="text-xl font-black">Premium Benefits</h4>
                        </div>
                        
                        <ul class="space-y-4 font-medium text-gray-300">
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Rank at the top of candidate recommendations
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Premium search highlight badge
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Early access to verified company listings
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Unlimited resume upload slots
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Custom advanced alerts and keyword matching
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- History Transactions -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 mt-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                    <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">Payment History</h3>
                </div>
                
                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Transaction ID</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Amount</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Receipt</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($history as $pay)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white font-mono">{{ $pay->transaction_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">${{ number_format($pay->amount) }} {{ $pay->currency }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(strtolower($pay->status) == 'completed' || strtolower($pay->status) == 'paid')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                {{ strtoupper($pay->status) }}
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                {{ strtoupper($pay->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($pay->invoice)
                                            <a href="{{ route('invoices.show', $pay->invoice->invoice_number) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 hover:underline flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                #{{ $pay->invoice->invoice_number }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">None</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <p class="text-sm text-gray-500 font-medium">No boost transactions recorded.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
