<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Employer Billing & Subscription Plan') }}
        </h2>
    </x-slot>

    <div
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
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Active Plan Panel -->
            <div>
                <h3>Current Subscription Status</h3>
                
                @if($subscription && $subscription->isValid())
                    <div>
                        <div>
                            <span>
                                {{ $subscription->plan->name }} - Active
                            </span>
                            <p>
                                Renews/Expires on: {{ $subscription->ends_at->format('M d, Y') }}
                            </p>
                            <div>
                                <span>💼 Job posts: {{ $subscription->plan->job_limit === -1 ? 'Unlimited' : $subscription->plan->job_limit }}</span>
                                <span>⭐ Featured posts: {{ $subscription->plan->featured_jobs_limit === -1 ? 'Unlimited' : $subscription->plan->featured_jobs_limit }}</span>
                                <span>🔍 Candidate Search: {{ $subscription->plan->candidate_search ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('employer.billing.cancel') }}" onsubmit="return confirm('Are you sure you want to cancel subscription?');">
                            @csrf
                            <button type="submit">
                                Cancel Subscription
                            </button>
                        </form>
                    </div>
                @else
                    <div>
                        <div>
                            <span>
                                No Active Paid Plan (Free Tier)
                            </span>
                            <p>Subscribe to a premium hiring tier below to post more jobs and unlock candidate search.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Subscription Plan Options grid -->
            <div>
                @foreach($plans as $plan)
                    <div>
                        <div>
                            <div>
                                <h4>{{ $plan->name }}</h4>
                                <p>Unlock premium hiring metrics.</p>
                            </div>

                            <div>
                                <span>${{ $plan->monthly_price }}</span>
                                <span>/ month</span>
                                <p>Or ${{ $plan->yearly_price }}/year</p>
                            </div>

                            <ul>
                                <li>&check; {{ $plan->job_limit === -1 ? 'Unlimited' : $plan->job_limit }} Job Posts</li>
                                <li>&check; {{ $plan->featured_jobs_limit === -1 ? 'Unlimited' : $plan->featured_jobs_limit }} Featured Jobs</li>
                                <li>
                                    @if($plan->candidate_search)
                                        &check; Candidate Search Enabled
                                    @else
                                        <span>&cross; Candidate Search Disabled</span>
                                    @endif
                                </li>
                            </ul>
                        </div>

                        <!-- Click trigger to open interactive checkout -->
                        <button type="button" 
                                @click="openCheckout('{{ $plan->name }}', {{ $plan->monthly_price }}, 'monthly')">
                            Select Plan
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Billing History Payments -->
            <div>
                <div>
                    <h3>Billing History & Invoices</h3>
                </div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Payment Type</th>
                                <th>Amount Paid</th>
                                <th>Status</th>
                                <th>Paid At</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($billingHistory as $pay)
                                <tr>
                                    <td>{{ $pay->transaction_id }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $pay->payment_type)) }}</td>
                                    <td>${{ number_format($pay->amount) }} {{ $pay->currency }}</td>
                                    <td>
                                        <span>
                                            {{ strtoupper($pay->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $pay->paid_at ? $pay->paid_at->format('M d, Y H:i') : '-' }}</td>
                                    <td>
                                        @if($pay->invoice)
                                            <a href="{{ route('invoices.show', $pay->invoice->invoice_number) }}">
                                                Receipt #{{ $pay->invoice->invoice_number }}
                                            </a>
                                        @else
                                            <span>No invoice generated</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No billing transactions logged.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PAYMENT CHECKOUT MODAL WINDOW (ALPINE OVERLAY) -->
            <div x-show="checkoutOpen" x-transition>
                <div>
                    <div @click="checkoutOpen = false"></div>
                    
                    <div>
                        
                        <!-- Success message screen overlay -->
                        <div x-show="checkoutSuccess">
                            <div>✓</div>
                            <h3>Payment Authorized!</h3>
                            <p>Your membership profile has been successfully upgraded. A printable invoice transaction details has been generated.</p>
                            <button type="button" @click="checkoutOpen = false; window.location.reload();">
                                Back to Console
                            </button>
                        </div>

                        <!-- Failed message screen overlay -->
                        <div x-show="checkoutFailed">
                            <div>×</div>
                            <h3>Transaction Failed</h3>
                            <p>The banking authorization returned insufficient funds or validation errors. Hint: card must include 4111 to mock authorize successfully.</p>
                            <button type="button" @click="checkoutFailed = false; cardNumber = ''">
                                Try Again
                            </button>
                        </div>

                        <!-- Active Checkout Screen -->
                        <div>
                            <div>
                                <h3>Secure Plan Upgrade</h3>
                                <button type="button" @click="checkoutOpen = false">Close</button>
                            </div>
                            
                            <!-- Upgrade summary details -->
                            <div>
                                <div>
                                    <span>Upgrade Tier:</span>
                                    <span x-text="checkoutPlanName"></span>
                                </div>
                                <div>
                                    <span>Upgrade Cycle:</span>
                                    <span x-text="checkoutCycle"></span>
                                </div>
                                <div>
                                    <span>Regular Cost:</span>
                                    <span x-text="'$' + checkoutPrice + ' CAD'"></span>
                                </div>
                                <div x-show="discountAmount > 0">
                                    <span>Discount (Coupon):</span>
                                    <span x-text="'-$' + discountAmount.toFixed(2) + ' CAD'"></span>
                                </div>
                                <div>
                                    <span>Final Invoice:</span>
                                    <span x-text="'$' + finalPrice.toFixed(2) + ' CAD'"></span>
                                </div>
                            </div>

                            <!-- Promo Coupon Apply -->
                            <div>
                                <input type="text" x-model="couponCode" placeholder="Promo code (e.g. CANADA150)" />
                                <button type="button" @click="applyCoupon()">Apply</button>
                            </div>

                            <!-- Card inputs -->
                            <div>
                                <div>
                                    <label>Credit Card Number</label>
                                    <input type="text" x-model="cardNumber" placeholder="4111 0000 0000 0000" />
                                </div>
                                <div>
                                    <div>
                                        <label>Expiration</label>
                                        <input type="text" placeholder="MM/YY" />
                                    </div>
                                    <div>
                                        <label>CVC Code</label>
                                        <input type="text" placeholder="123" />
                                    </div>
                                </div>
                            </div>

                            <button type="button" @click="processPayment()">
                                Authorize Transaction & Upgrade
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
