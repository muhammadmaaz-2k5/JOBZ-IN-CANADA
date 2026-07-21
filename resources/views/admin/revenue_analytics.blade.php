<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Revenue & Subscription Analytics') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            <!-- Metrics overview row -->
            <div>
                <!-- Monthly Revenue -->
                <div>
                    <span>Monthly Revenue</span>
                    <h3>${{ number_format($monthlyRevenue) }} CAD</h3>
                    <p>Processed payments past 30 days</p>
                </div>
                
                <!-- Annual Revenue -->
                <div>
                    <span>Annual Revenue</span>
                    <h3>${{ number_format($annualRevenue) }} CAD</h3>
                    <p>Processed payments past 365 days</p>
                </div>

                <!-- Active Subscriptions -->
                <div>
                    <span>Active subscriptions</span>
                    <h3>{{ $activeSubscriptionsCount }}</h3>
                    <p>Subscribed recruiters</p>
                </div>

                <!-- Churn Rate -->
                <div>
                    <span>Churn Rate</span>
                    <h3>{{ $churnRate }}%</h3>
                    <p>Cancelled vs total subscription cycles</p>
                </div>
            </div>

            <!-- Revenue Share Distribution -->
            <div>
                <div>
                    <span>Recruiter Plan Sales</span>
                    <h4>${{ number_format($subscriptionSales) }} CAD</h4>
                </div>
                <div>
                    <span>Featured Jobs Promotions</span>
                    <h4>${{ number_format($featuredJobSales) }} CAD</h4>
                </div>
                <div>
                    <span>Seeker Resume Boosts</span>
                    <h4>${{ number_format($resumeBoostSales) }} CAD</h4>
                </div>
            </div>

            <!-- Transactions streams -->
            <div>
                <div>
                    <h3>Transaction Logs Stream</h3>
                </div>
                
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Customer</th>
                                <th>Payment Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Processed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                                <tr>
                                    <td>{{ $tx->transaction_id }}</td>
                                    <td>
                                        {{ $tx->user->first_name }} {{ $tx->user->last_name }}
                                        <p>{{ $tx->user->email }}</p>
                                    </td>
                                    <td>
                                        <span>
                                            {{ ucfirst(str_replace('_', ' ', $tx->payment_type)) }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($tx->amount) }} {{ $tx->currency }}</td>
                                    <td>
                                        <span>
                                            {{ strtoupper($tx->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $tx->paid_at ? $tx->paid_at->diffForHumans() : $tx->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No revenue transactions recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $transactions->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
