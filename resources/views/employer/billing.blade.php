<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employer Billing & Subscription Plan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-950/30 border border-red-500/30 text-red-800 dark:text-red-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Active Plan Panel -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                <h3 class="font-extrabold text-lg text-gray-900 dark:text-white mb-4">Current Subscription Status</h3>
                
                @if($subscription && $subscription->isValid())
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <span class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-950 text-indigo-650 dark:text-indigo-300 font-extrabold text-2xs rounded-lg border border-indigo-150 uppercase">
                                {{ $subscription->plan->name }} - Active
                            </span>
                            <p class="text-xs text-gray-500 mt-2 font-semibold">
                                Renews/Expires on: {{ $subscription->ends_at->format('M d, Y') }}
                            </p>
                            <div class="mt-3 flex gap-4 text-3xs uppercase font-extrabold text-gray-400">
                                <span>💼 Active Job Limit: {{ $subscription->plan->job_limit === -1 ? 'Unlimited' : $subscription->plan->job_limit }}</span>
                                <span>⭐ Featured Jobs Limit: {{ $subscription->plan->featured_jobs_limit === -1 ? 'Unlimited' : $subscription->plan->featured_jobs_limit }}</span>
                                <span>🔍 Candidate Search: {{ $subscription->plan->candidate_search ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('employer.billing.cancel') }}" onsubmit="return confirm('Are you sure you want to cancel your active subscription immediately?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-550 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900 font-bold text-xs rounded-xl transition">
                                Cancel Subscription
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-900 text-gray-500 font-extrabold text-2xs rounded-lg border border-gray-200 dark:border-gray-800 uppercase">
                                No Active Paid Plan (Free Tier)
                            </span>
                            <p class="text-xs text-gray-500 mt-2 font-semibold">Subscribe to a premium hiring tier below to post more jobs and unlock candidate search.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Subscription Plan Options grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 flex flex-col justify-between space-y-6 @if($subscription && $subscription->plan_id === $plan->id && $subscription->isValid()) border-indigo-500 border-2 @endif">
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-extrabold text-base text-gray-900 dark:text-white">{{ $plan->name }}</h4>
                                <p class="text-xs text-gray-400 mt-1">Unlock next-level recruitment metrics.</p>
                            </div>

                            <div class="border-b border-gray-100 dark:border-gray-700 pb-3">
                                <span class="text-2xl font-black text-indigo-650">${{ $plan->monthly_price }}</span>
                                <span class="text-xs text-gray-400">/ month</span>
                                <p class="text-3xs text-gray-400 mt-1">Or ${{ $plan->yearly_price }}/year</p>
                            </div>

                            <ul class="space-y-2 text-xs text-gray-650 dark:text-gray-300 font-semibold">
                                <li>&check; {{ $plan->job_limit === -1 ? 'Unlimited' : $plan->job_limit }} Job Posts</li>
                                <li>&check; {{ $plan->featured_jobs_limit === -1 ? 'Unlimited' : $plan->featured_jobs_limit }} Featured Jobs</li>
                                <li>
                                    @if($plan->candidate_search)
                                        &check; Candidate Search Enabled
                                    @else
                                        <span class="text-gray-400">&cross; Candidate Search Disabled</span>
                                    @endif
                                </li>
                                <li>
                                    @if($plan->analytics_access)
                                        &check; Advanced Analytics Access
                                    @else
                                        <span class="text-gray-400">&cross; Basic Reports Only</span>
                                    @endif
                                </li>
                            </ul>
                        </div>

                        <form method="POST" action="{{ route('employer.billing.subscribe') }}" class="space-y-3 pt-2">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}" />
                            
                            <div>
                                <label class="block text-3xs font-extrabold text-gray-400 uppercase mb-1">Billing Cycle</label>
                                <select name="billing_cycle" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300">
                                    <option value="monthly">Monthly (${{ $plan->monthly_price }}/mo)</option>
                                    <option value="yearly">Yearly (${{ $plan->yearly_price }}/yr)</option>
                                </select>
                            </div>

                            <div>
                                <input type="text" name="coupon_code" placeholder="Coupon (optional)" class="w-full text-xs rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300" />
                            </div>

                            <button type="submit" class="w-full py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                                Subscribe / Change Plan
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Billing History Payments -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-750">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Billing History & Invoices</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Transaction ID</th>
                                <th class="p-4">Payment Type</th>
                                <th class="p-4">Amount Paid</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Paid At</th>
                                <th class="p-4 text-right">Invoice</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($billingHistory as $pay)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/10 transition">
                                    <td class="p-4 font-mono font-bold">{{ $pay->transaction_id }}</td>
                                    <td class="p-4">{{ ucfirst(str_replace('_', ' ', $pay->payment_type)) }}</td>
                                    <td class="p-4">${{ number_format($pay->amount) }} {{ $pay->currency }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-0.5 rounded text-3xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                            {{ strtoupper($pay->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-450">{{ $pay->paid_at ? $pay->paid_at->format('M d, Y H:i') : '-' }}</td>
                                    <td class="p-4 text-right">
                                        @if($pay->invoice)
                                            <a href="{{ route('invoices.show', $pay->invoice->invoice_number) }}" class="text-indigo-650 dark:text-indigo-400 hover:underline">
                                                Receipt #{{ $pay->invoice->invoice_number }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">No invoice generated</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 italic">No billing transactions logged.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
