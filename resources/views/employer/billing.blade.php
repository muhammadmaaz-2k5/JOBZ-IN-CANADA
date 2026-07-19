<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employer Billing & Subscription Plan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen"
         x-data="{
            checkoutOpen: false,
            checkoutPlanName: '',
            checkoutCycle: 'monthly',
            checkoutPrice: 0,
            couponCode: '',
            discountAmount: 0,
            finalPrice: 0,
            checkoutSuccess: false,
            checkoutFailed: false,
            cardNumber: '',

            openCheckout(name, price, cycle) {
                this.checkoutPlanName = name;
                this.checkoutCycle = cycle;
                this.checkoutPrice = price;
                this.finalPrice = price;
                this.discountAmount = 0;
                this.couponCode = '';
                this.checkoutSuccess = false;
                this.checkoutFailed = false;
                this.checkoutOpen = true;
            },

            applyCoupon() {
                if (this.couponCode.toUpperCase().trim() === 'CANADA150') {
                    this.discountAmount = this.checkoutPrice * 0.15;
                    this.finalPrice = this.checkoutPrice - this.discountAmount;
                    alert('Promo coupon applied successfully: 15% discount!');
                } else {
                    alert('Invalid promo code.');
                }
            },

            processPayment() {
                if (!this.cardNumber) {
                    alert('Please enter your card details.');
                    return;
                }
                
                // Simulate payment authorization
                setTimeout(() => {
                    if (this.cardNumber.includes('4111')) {
                        this.checkoutSuccess = true;
                    } else {
                        this.checkoutFailed = true;
                    }
                }, 1000);
            }
         }"
    >
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
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-150 dark:border-gray-700/50">
                <h3 class="font-extrabold text-lg text-gray-900 dark:text-white mb-4">Current Subscription Status</h3>
                
                @if($subscription && $subscription->isValid())
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <span class="px-2.5 py-1 bg-primary-50 dark:bg-primary-950/30 text-primary-500 font-extrabold text-2xs rounded-lg border border-primary-250/20 uppercase">
                                {{ $subscription->plan->name }} - Active
                            </span>
                            <p class="text-xs text-gray-500 mt-2 font-semibold font-mono">
                                Renews/Expires on: {{ $subscription->ends_at->format('M d, Y') }}
                            </p>
                            <div class="mt-3 flex gap-4 text-[10px] uppercase font-extrabold text-gray-400">
                                <span>💼 Job posts: {{ $subscription->plan->job_limit === -1 ? 'Unlimited' : $subscription->plan->job_limit }}</span>
                                <span>⭐ Featured posts: {{ $subscription->plan->featured_jobs_limit === -1 ? 'Unlimited' : $subscription->plan->featured_jobs_limit }}</span>
                                <span>🔍 Candidate Search: {{ $subscription->plan->candidate_search ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('employer.billing.cancel') }}" onsubmit="return confirm('Are you sure you want to cancel subscription?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-550 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900 font-bold text-xs rounded-xl transition cursor-pointer">
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
                            <p class="text-xs text-gray-550 mt-2 font-semibold">Subscribe to a premium hiring tier below to post more jobs and unlock candidate search.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Subscription Plan Options grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($plans as $plan)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-150 dark:border-gray-700/50 flex flex-col justify-between space-y-6 @if($subscription && $subscription->plan_id === $plan->id && $subscription->isValid()) border-primary-500 border-2 @endif">
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-extrabold text-base text-gray-900 dark:text-white">{{ $plan->name }}</h4>
                                <p class="text-xs text-gray-400 mt-1">Unlock premium hiring metrics.</p>
                            </div>

                            <div class="border-b border-gray-100 dark:border-gray-700 pb-3">
                                <span class="text-2xl font-black text-primary-500">${{ $plan->monthly_price }}</span>
                                <span class="text-xs text-gray-400">/ month</span>
                                <p class="text-[10px] text-gray-405 mt-1 font-semibold">Or ${{ $plan->yearly_price }}/year</p>
                            </div>

                            <ul class="space-y-2 text-xs text-gray-600 dark:text-gray-300 font-bold">
                                <li>&check; {{ $plan->job_limit === -1 ? 'Unlimited' : $plan->job_limit }} Job Posts</li>
                                <li>&check; {{ $plan->featured_jobs_limit === -1 ? 'Unlimited' : $plan->featured_jobs_limit }} Featured Jobs</li>
                                <li>
                                    @if($plan->candidate_search)
                                        &check; Candidate Search Enabled
                                    @else
                                        <span class="text-gray-400">&cross; Candidate Search Disabled</span>
                                    @endif
                                </li>
                            </ul>
                        </div>

                        <!-- Click trigger to open interactive checkout -->
                        <button type="button" 
                                @click="openCheckout('{{ $plan->name }}', {{ $plan->monthly_price }}, 'monthly')"
                                class="w-full py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-extrabold rounded-xl text-xs uppercase tracking-wider transition cursor-pointer">
                            Select Plan
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Billing History Payments -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-750">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Billing History & Invoices</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-[10px] font-extrabold uppercase text-gray-400">
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
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                            {{ strtoupper($pay->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-450">{{ $pay->paid_at ? $pay->paid_at->format('M d, Y H:i') : '-' }}</td>
                                    <td class="p-4 text-right">
                                        @if($pay->invoice)
                                            <a href="{{ route('invoices.show', $pay->invoice->invoice_number) }}" class="text-primary-500 hover:underline">
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

            <!-- PAYMENT CHECKOUT MODAL WINDOW (ALPINE OVERLAY) -->
            <div x-show="checkoutOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
                <div class="flex items-center justify-center min-h-screen px-4 text-center">
                    <div class="fixed inset-0 bg-black/60 transition-opacity" @click="checkoutOpen = false"></div>
                    
                    <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-3xl relative">
                        
                        <!-- Success message screen overlay -->
                        <div x-show="checkoutSuccess" class="absolute inset-0 bg-white dark:bg-gray-800 z-20 p-8 flex flex-col justify-center items-center text-center space-y-4">
                            <div class="w-12 h-12 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center font-bold text-lg">✓</div>
                            <h3 class="font-extrabold text-lg text-gray-950 dark:text-white">Payment Authorized!</h3>
                            <p class="text-xs text-gray-500">Your membership profile has been successfully upgraded. A printable invoice transaction details has been generated.</p>
                            <button type="button" @click="checkoutOpen = false; window.location.reload();" class="px-5 py-2.5 bg-primary-500 text-white rounded-xl text-xs font-bold cursor-pointer">
                                Back to Console
                            </button>
                        </div>

                        <!-- Failed message screen overlay -->
                        <div x-show="checkoutFailed" class="absolute inset-0 bg-white dark:bg-gray-800 z-20 p-8 flex flex-col justify-center items-center text-center space-y-4">
                            <div class="w-12 h-12 bg-red-105 text-red-500 rounded-full flex items-center justify-center font-bold text-lg">×</div>
                            <h3 class="font-extrabold text-lg text-gray-955 dark:text-white">Transaction Failed</h3>
                            <p class="text-xs text-gray-500">The banking authorization returned insufficient funds or validation errors. Hint: card must include 4111 to mock authorize successfully.</p>
                            <button type="button" @click="checkoutFailed = false; cardNumber = ''" class="px-5 py-2.5 bg-gray-500 text-white rounded-xl text-xs font-bold cursor-pointer">
                                Try Again
                            </button>
                        </div>

                        <!-- Active Checkout Screen -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b border-gray-150">
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Secure Plan Upgrade</h3>
                                <button type="button" @click="checkoutOpen = false" class="text-gray-450 hover:text-gray-600 text-xs">Close</button>
                            </div>
                            
                            <!-- Upgrade summary details -->
                            <div class="p-4 bg-gray-50 dark:bg-dark-850 rounded-2xl text-xs space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Upgrade Tier:</span>
                                    <span class="font-bold text-gray-900 dark:text-white" x-text="checkoutPlanName"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Upgrade Cycle:</span>
                                    <span class="font-bold text-gray-900 dark:text-white" x-text="checkoutCycle"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Regular Cost:</span>
                                    <span class="font-bold text-gray-900 dark:text-white" x-text="'$' + checkoutPrice + ' CAD'"></span>
                                </div>
                                <div class="flex justify-between text-red-500" x-show="discountAmount > 0">
                                    <span>Discount (Coupon):</span>
                                    <span x-text="'-$' + discountAmount.toFixed(2) + ' CAD'"></span>
                                </div>
                                <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-2 font-bold text-sm">
                                    <span>Final Invoice:</span>
                                    <span class="text-primary-500" x-text="'$' + finalPrice.toFixed(2) + ' CAD'"></span>
                                </div>
                            </div>

                            <!-- Promo Coupon Apply -->
                            <div class="flex gap-2">
                                <input type="text" x-model="couponCode" placeholder="Promo code (e.g. CANADA150)" class="flex-1 px-3 py-2 rounded-xl border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-850 text-xs focus:outline-none" />
                                <button type="button" @click="applyCoupon()" class="px-4 py-2 bg-gray-150 dark:bg-dark-800 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold cursor-pointer">Apply</button>
                            </div>

                            <!-- Card inputs -->
                            <div class="space-y-3 pt-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-450 uppercase mb-1">Credit Card Number</label>
                                    <input type="text" x-model="cardNumber" placeholder="4111 0000 0000 0000" class="w-full px-3 py-2 rounded-xl border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-850 text-xs focus:outline-none" />
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-455 uppercase mb-1">Expiration</label>
                                        <input type="text" placeholder="MM/YY" class="w-full px-3 py-2 rounded-xl border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-850 text-xs focus:outline-none" />
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-450 uppercase mb-1">CVC Code</label>
                                        <input type="text" placeholder="123" class="w-full px-3 py-2 rounded-xl border border-gray-250 dark:border-gray-700 bg-white dark:bg-dark-850 text-xs focus:outline-none" />
                                    </div>
                                </div>
                            </div>

                            <button type="button" @click="processPayment()" class="w-full mt-4 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-xl text-xs font-black uppercase tracking-wider transition cursor-pointer">
                                Authorize Transaction & Upgrade
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
