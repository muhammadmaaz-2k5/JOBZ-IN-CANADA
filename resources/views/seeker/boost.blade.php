<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Seeker Profile Resume Boost') }}
        </h2>
    </x-slot>

    <div>
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Active Status panel -->
            <div>
                <h3>Resume Boost Status</h3>
                @if($boost && $boost->isValid())
                    <div>
                        <span>
                            ⭐ Resume Profile Boosted
                        </span>
                        <span>Expires: {{ $boost->expires_at->format('M d, Y H:i') }}</span>
                    </div>
                    <p>Your resume is featured at the top of recruiter searches, candidate recommendations, and has priority placement.</p>
                @else
                    <div>
                        <span>
                            Not Boosted
                        </span>
                    </div>
                    <p>Select a profile boost duration below to stand out to verified recruiters hiring in Canada.</p>
                @endif
            </div>

            <!-- Promotion options & checkout -->
            <div>
                <!-- Boost Plan options card -->
                <div>
                    <h3>Choose Boost Duration</h3>
                    
                    <form method="POST" action="{{ route('seeker.boost.submit') }}">
                        @csrf
                        
                        <div>
                            @foreach([7 => 5, 15 => 9, 30 => 15] as $days => $price)
                                <label>
                                    <input type="radio" name="duration_days" value="{{ $days }}" @if($days == 30) checked @endif />
                                    <div>
                                        <span>{{ $days }} Days</span>
                                        <span>${{ $price }} CAD</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div>
                            <x-input-label for="coupon_code" :value="__('Enter Coupon Code')" />
                            <x-text-input id="coupon_code" name="coupon_code" type="text" placeholder="DISCOUNT CODE" />
                        </div>

                        <button type="submit">
                            Boost My Profile Now (Mock Checkout)
                        </button>
                    </form>
                </div>

                <!-- Premium benefits checklist -->
                <div>
                    <h4>Premium Seeker Benefits</h4>
                    <ul>
                        <li>🚀 Rank at the top of candidate recommendations</li>
                        <li>⭐ Premium search highlight badge</li>
                        <li>📈 Early access to verified company listings</li>
                        <li>📅 Unlimited resume upload slots</li>
                        <li>✉️ Custom advanced alerts and keywords matching</li>
                    </ul>
                </div>
            </div>

            <!-- History Transactions -->
            <div>
                <div>
                    <h3>Boost Payment History</h3>
                </div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Amount Paid</th>
                                <th>Status</th>
                                <th>Invoice Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $pay)
                                <tr>
                                    <td>{{ $pay->transaction_id }}</td>
                                    <td>${{ number_format($pay->amount) }} {{ $pay->currency }}</td>
                                    <td>
                                        <span>
                                            {{ strtoupper($pay->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($pay->invoice)
                                            <a href="{{ route('invoices.show', $pay->invoice->invoice_number) }}">
                                                Invoice #{{ $pay->invoice->invoice_number }}
                                            </a>
                                        @else
                                            <span>None</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No boost transactions recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
