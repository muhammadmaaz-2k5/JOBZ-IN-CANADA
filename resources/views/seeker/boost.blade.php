<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Seeker Profile Resume Boost') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Active Status panel -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                <h3 class="font-extrabold text-lg text-gray-900 dark:text-white mb-2">Resume Boost Status</h3>
                @if($boost && $boost->isValid())
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-450 font-extrabold text-2xs rounded-lg border border-emerald-150 uppercase">
                            ⭐ Resume Profile Boosted
                        </span>
                        <span class="text-xs text-gray-500 font-semibold">Expires: {{ $boost->expires_at->format('M d, Y H:i') }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 font-semibold">Your resume is featured at the top of recruiter searches, candidate recommendations, and has priority placement.</p>
                @else
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-900 text-gray-500 font-extrabold text-2xs rounded-lg border border-gray-200 dark:border-gray-800 uppercase">
                            Not Boosted
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 font-semibold">Select a profile boost duration below to stand out to verified recruiters hiring in Canada.</p>
                @endif
            </div>

            <!-- Promotion options & checkout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Boost Plan options card -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 space-y-6">
                    <h3 class="font-extrabold text-lg text-gray-900 dark:text-white">Choose Boost Duration</h3>
                    
                    <form method="POST" action="{{ route('seeker.boost.submit') }}" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach([7 => 5, 15 => 9, 30 => 15] as $days => $price)
                                <label class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 flex flex-col justify-between items-center text-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-950 transition">
                                    <input type="radio" name="duration_days" value="{{ $days }}" @if($days == 30) checked @endif class="mb-3 text-indigo-600 focus:ring-indigo-500" />
                                    <div>
                                        <span class="block font-black text-lg text-gray-900 dark:text-white">{{ $days }} Days</span>
                                        <span class="text-xs text-indigo-650 font-extrabold mt-1 block">${{ $price }} CAD</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div>
                            <x-input-label for="coupon_code" :value="__('Enter Coupon Code')" />
                            <x-text-input id="coupon_code" name="coupon_code" type="text" class="mt-1 block w-full text-xs" placeholder="DISCOUNT CODE" />
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            Boost My Profile Now (Mock Checkout)
                        </button>
                    </form>
                </div>

                <!-- Premium benefits checklist -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 space-y-4">
                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Premium Seeker Benefits</h4>
                    <ul class="space-y-3 text-xs text-gray-650 dark:text-gray-300 font-semibold">
                        <li>🚀 Rank at the top of candidate recommendations</li>
                        <li>⭐ Premium search highlight badge</li>
                        <li>📈 Early access to verified company listings</li>
                        <li>📅 Unlimited resume upload slots</li>
                        <li>✉️ Custom advanced alerts and keywords matching</li>
                    </ul>
                </div>
            </div>

            <!-- History Transactions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-750">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Boost Payment History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Transaction ID</th>
                                <th class="p-4">Amount Paid</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Invoice Receipt</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($history as $pay)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/10 transition">
                                    <td class="p-4 font-mono font-bold">{{ $pay->transaction_id }}</td>
                                    <td class="p-4">${{ number_format($pay->amount) }} {{ $pay->currency }}</td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-0.5 rounded text-3xs font-extrabold bg-emerald-100 text-emerald-800">
                                            {{ strtoupper($pay->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        @if($pay->invoice)
                                            <a href="{{ route('invoices.show', $pay->invoice->invoice_number) }}" class="text-indigo-650 dark:text-indigo-400 hover:underline">
                                                Invoice #{{ $pay->invoice->invoice_number }}
                                            </a>
                                        @else
                                            <span class="text-gray-450 italic">None</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-gray-400 italic">No boost transactions recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
