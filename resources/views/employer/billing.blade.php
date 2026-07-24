<x-app-layout>
    <x-slot name="header">
        Employer Billing & Subscription Plan
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8 relative z-10"
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
                document.body.style.overflow = 'hidden';
            },
            
            closeCheckout() {
                this.checkoutOpen = false;
                document.body.style.overflow = 'auto';
            },

            applyCoupon() {
                if (this.couponCode.toUpperCase().trim() === 'CANADA150') {
                    this.discountAmount = this.checkoutPrice * 0.15;
                    this.finalPrice = this.checkoutPrice - this.discountAmount;
                } else {
                    this.discountAmount = 0;
                    this.finalPrice = this.checkoutPrice;
                }
            },

            processPayment() {
                if (!this.cardNumber) {
                    this.checkoutFailed = true;
                    return;
                }
                
                // Simulate payment authorization
                setTimeout(() => {
                    if (this.cardNumber.includes('4111')) {
                        this.checkoutSuccess = true;
                        this.checkoutFailed = false;
                    } else {
                        this.checkoutFailed = true;
                        this.checkoutSuccess = false;
                    }
                }, 1000);
            }
         }"
    >
        
        <!-- Decorative blurred background elements -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-purple-400/10 blur-[120px]"></div>
            <div class="absolute bottom-[10%] -left-[10%] w-[40%] h-[60%] rounded-full bg-pink-400/10 blur-[120px]"></div>
        </div>

        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Billing & Plans</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">Manage your company's subscription and view payment history.</p>
            </div>
            <div class="px-5 py-2.5 bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm inline-flex items-center gap-3">
                <span class="w-2 h-2 rounded-full @if($subscription && $subscription->isValid()) bg-emerald-500 @else bg-amber-500 @endif animate-pulse"></span>
                <span class="font-bold text-slate-700 dark:text-slate-300">
                    @if($subscription && $subscription->isValid()) Active Subscription @else Free Tier @endif
                </span>
            </div>
        </div>

        @if(session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Left Column: Current Active Plan -->
            <div class="xl:col-span-1 space-y-6">
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-900/20">
                    <!-- Decorative background graphic -->
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-5 rounded-full blur-2xl"></div>
                    
                    <h3 class="text-lg font-bold text-slate-300 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                        Current Plan Status
                    </h3>
                    
                    @if($subscription && $subscription->isValid())
                        <div>
                            <div class="mb-8">
                                <span class="inline-block px-4 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-400 font-black text-sm uppercase tracking-wider border border-emerald-500/30 mb-3">
                                    {{ $subscription->plan->name }}
                                </span>
                                <p class="text-slate-400 text-sm">
                                    Renews on <strong class="text-white">{{ $subscription->ends_at->format('M d, Y') }}</strong>
                                </p>
                            </div>
                            
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-700/50 flex items-center justify-center shrink-0">💼</div>
                                    <span class="text-sm font-medium">Job posts: <strong class="text-white">{{ $subscription->plan->job_limit === -1 ? 'Unlimited' : $subscription->plan->job_limit }}</strong></span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-700/50 flex items-center justify-center shrink-0">⭐</div>
                                    <span class="text-sm font-medium">Featured: <strong class="text-white">{{ $subscription->plan->featured_jobs_limit === -1 ? 'Unlimited' : $subscription->plan->featured_jobs_limit }}</strong></span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-700/50 flex items-center justify-center shrink-0">🔍</div>
                                    <span class="text-sm font-medium">Candidate Search: <strong class="text-white">{{ $subscription->plan->candidate_search ? 'Enabled' : 'Disabled' }}</strong></span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('employer.billing.cancel') }}" onsubmit="return confirm('Are you sure you want to cancel subscription?');">
                                @csrf
                                <button type="submit" class="w-full py-3 px-4 rounded-xl border border-slate-700 text-slate-300 font-bold hover:bg-slate-800 hover:text-white transition-colors">
                                    Cancel Subscription
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-20 h-20 rounded-full bg-slate-800 flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner border border-slate-700">
                                🏢
                            </div>
                            <h4 class="text-2xl font-black mb-2">Free Tier</h4>
                            <p class="text-slate-400 text-sm leading-relaxed mb-6">Subscribe to a premium hiring tier below to post more jobs and unlock candidate search.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Subscription Plans Grid -->
            <div class="xl:col-span-2 space-y-8">
                <h3 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 flex items-center justify-center"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></span>
                    Available Plans
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($plans as $plan)
                        <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-8 flex flex-col relative group transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                            <!-- Popular Badge Example (you could make this dynamic) -->
                            @if($plan->monthly_price > 50 && $plan->monthly_price < 150)
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-black uppercase tracking-wider rounded-full shadow-lg">Most Popular</div>
                            @endif

                            <div class="mb-8">
                                <h4 class="text-2xl font-black text-slate-900 dark:text-white mb-2">{{ $plan->name }}</h4>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Unlock premium hiring metrics.</p>
                            </div>

                            <div class="mb-8 pb-8 border-b border-gray-100 dark:border-slate-700/50">
                                <div class="flex items-baseline gap-2 mb-2">
                                    <span class="text-4xl font-black text-slate-900 dark:text-white">${{ $plan->monthly_price }}</span>
                                    <span class="text-gray-500 dark:text-gray-400 font-bold">/ month</span>
                                </div>
                                <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 inline-block px-3 py-1 rounded-full">Or ${{ $plan->yearly_price }} / year (Save 20%)</p>
                            </div>

                            <ul class="space-y-4 mb-8 flex-1">
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ $plan->job_limit === -1 ? 'Unlimited' : $plan->job_limit }} Job Posts</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ $plan->featured_jobs_limit === -1 ? 'Unlimited' : $plan->featured_jobs_limit }} Featured Jobs</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    @if($plan->candidate_search)
                                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                        <span class="font-medium text-slate-700 dark:text-slate-300">Candidate Search Enabled</span>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 dark:text-slate-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        <span class="font-medium text-gray-400 dark:text-slate-500 line-through">Candidate Search Disabled</span>
                                    @endif
                                </li>
                            </ul>

                            <button type="button" 
                                    @click="openCheckout('{{ $plan->name }}', {{ $plan->monthly_price }}, 'monthly')"
                                    class="w-full py-4 rounded-xl font-black transition-all hover:scale-[1.02] 
                                    @if($plan->monthly_price > 50 && $plan->monthly_price < 150) bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white shadow-lg shadow-purple-500/30
                                    @else bg-slate-900 hover:bg-black text-white dark:bg-white dark:hover:bg-gray-100 dark:text-slate-900 shadow-lg @endif">
                                Select Plan
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Billing History -->
        <div class="mt-12 bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
            <div class="p-8 border-b border-gray-100 dark:border-slate-700/50">
                <h3 class="text-xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 flex items-center justify-center"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg></span>
                    Billing History & Invoices
                </h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-800/30">
                            <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Transaction ID</th>
                            <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Payment Type</th>
                            <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Amount Paid</th>
                            <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Status</th>
                            <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Paid At</th>
                            <th class="py-4 px-6 font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50">
                        @forelse($billingHistory as $pay)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-6 font-medium text-slate-900 dark:text-white">{{ $pay->transaction_id }}</td>
                                <td class="py-4 px-6 font-medium text-gray-600 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $pay->payment_type)) }}</td>
                                <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">${{ number_format($pay->amount) }} {{ $pay->currency }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full 
                                        @if(strtolower($pay->status) === 'completed' || strtolower($pay->status) === 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                        @elseif(strtolower($pay->status) === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                        @else bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 @endif">
                                        {{ strtoupper($pay->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-500 dark:text-gray-400">{{ $pay->paid_at ? $pay->paid_at->format('M d, Y H:i') : '-' }}</td>
                                <td class="py-4 px-6">
                                    @if($pay->invoice)
                                        <a href="{{ route('invoices.show', $pay->invoice->invoice_number) }}" class="inline-flex items-center gap-1.5 font-bold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            Receipt #{{ $pay->invoice->invoice_number }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm italic">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-500 font-medium">No billing transactions logged yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAYMENT CHECKOUT MODAL WINDOW (ALPINE OVERLAY) -->
        <div x-show="checkoutOpen" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="min-h-screen px-4 text-center flex items-center justify-center relative">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="closeCheckout()"></div>
                
                <!-- Modal Panel -->
                <div class="inline-block w-full max-w-xl p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl relative border border-gray-100 dark:border-slate-800"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <!-- Success message screen overlay -->
                    <div x-show="checkoutSuccess" class="py-10 flex flex-col items-center justify-center text-center">
                        <div class="w-24 h-24 rounded-full bg-emerald-100 text-emerald-500 flex items-center justify-center mx-auto mb-6 scale-110 shadow-lg shadow-emerald-500/20">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-4">Payment Authorized!</h3>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mb-8 max-w-md mx-auto">Your membership profile has been successfully upgraded. A printable invoice transaction details has been generated.</p>
                        <button type="button" @click="window.location.reload()" class="w-full sm:w-auto px-8 py-3.5 bg-slate-900 hover:bg-black text-white dark:bg-white dark:text-slate-900 font-bold rounded-xl shadow-lg transition-all hover:scale-105">
                            Back to Console
                        </button>
                    </div>

                    <!-- Failed message screen overlay -->
                    <div x-show="checkoutFailed" style="display: none;" class="py-10 flex flex-col items-center justify-center text-center">
                        <div class="w-24 h-24 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-rose-500/20">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900 dark:text-white mb-4">Transaction Failed</h3>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mb-8 max-w-md mx-auto">The banking authorization returned insufficient funds or validation errors. Hint: card must include <strong>4111</strong> to mock authorize successfully.</p>
                        <button type="button" @click="checkoutFailed = false; cardNumber = ''" class="w-full sm:w-auto px-8 py-3.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-lg shadow-rose-600/30 transition-all hover:scale-105">
                            Try Again
                        </button>
                    </div>

                    <!-- Active Checkout Screen -->
                    <div x-show="!checkoutSuccess && !checkoutFailed">
                        <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100 dark:border-slate-800">
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                                <span class="p-2 rounded-lg bg-blue-100 text-blue-600"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg></span>
                                Secure Checkout
                            </h3>
                            <button type="button" @click="closeCheckout()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors p-2 rounded-full hover:bg-gray-100 dark:hover:bg-slate-800">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        
                        <!-- Upgrade summary details -->
                        <div class="bg-gray-50 dark:bg-slate-800/50 rounded-2xl p-6 mb-8 border border-gray-100 dark:border-slate-700/50">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider">Upgrade Tier</span>
                                <span class="font-black text-lg text-slate-900 dark:text-white" x-text="checkoutPlanName"></span>
                            </div>
                            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-slate-700">
                                <span class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider">Billing Cycle</span>
                                <span class="font-bold text-slate-700 dark:text-slate-300 capitalize" x-text="checkoutCycle"></span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600 dark:text-gray-300 font-medium">Regular Cost</span>
                                <span class="font-bold text-slate-700 dark:text-slate-300" x-text="'$' + checkoutPrice + ' CAD'"></span>
                            </div>
                            <div x-show="discountAmount > 0" style="display: none;" class="flex justify-between items-center mb-2 text-emerald-600 dark:text-emerald-400">
                                <span class="font-medium">Discount (Promo)</span>
                                <span class="font-bold" x-text="'-$' + discountAmount.toFixed(2) + ' CAD'"></span>
                            </div>
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                                <span class="text-lg font-black text-slate-900 dark:text-white">Total Due</span>
                                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400" x-text="'$' + finalPrice.toFixed(2) + ' CAD'"></span>
                            </div>
                        </div>

                        <!-- Promo Coupon Apply -->
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Have a Promo Code?</label>
                            <div class="flex gap-2">
                                <input type="text" x-model="couponCode" placeholder="Try CANADA150" @input="applyCoupon()" class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 uppercase transition-all font-bold text-slate-900 dark:text-white shadow-sm" />
                                <button type="button" @click="applyCoupon()" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-white font-bold rounded-xl transition-colors shrink-0 border border-gray-200 dark:border-slate-700">Apply</button>
                            </div>
                            <p x-show="discountAmount > 0" style="display: none;" class="text-emerald-600 font-bold text-sm mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Code applied successfully!
                            </p>
                        </div>

                        <!-- Card inputs -->
                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Credit Card Number</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    </span>
                                    <input type="text" x-model="cardNumber" placeholder="4111 0000 0000 0000" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-mono font-medium text-slate-900 dark:text-white shadow-sm" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Expiration</label>
                                    <input type="text" placeholder="MM/YY" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-mono font-medium text-slate-900 dark:text-white shadow-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">CVC</label>
                                    <input type="text" placeholder="123" maxlength="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all font-mono font-medium text-slate-900 dark:text-white shadow-sm" />
                                </div>
                            </div>
                        </div>

                        <button type="button" @click="processPayment()" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-lg rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Authorize & Upgrade
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
