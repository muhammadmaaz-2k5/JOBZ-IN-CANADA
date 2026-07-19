<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Revenue & Subscription Analytics') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Metrics overview row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Monthly Revenue -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-3xs font-extrabold uppercase text-gray-450">Monthly Revenue</span>
                    <h3 class="text-2xl font-black text-indigo-650 mt-1">${{ number_format($monthlyRevenue) }} CAD</h3>
                    <p class="text-4xs text-gray-400 mt-2 font-semibold">Processed payments past 30 days</p>
                </div>
                
                <!-- Annual Revenue -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-3xs font-extrabold uppercase text-gray-450">Annual Revenue</span>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">${{ number_format($annualRevenue) }} CAD</h3>
                    <p class="text-4xs text-gray-400 mt-2 font-semibold">Processed payments past 365 days</p>
                </div>

                <!-- Active Subscriptions -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-3xs font-extrabold uppercase text-gray-450">Active subscriptions</span>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $activeSubscriptionsCount }}</h3>
                    <p class="text-4xs text-gray-400 mt-2 font-semibold">Subscribed recruiters</p>
                </div>

                <!-- Churn Rate -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-3xs font-extrabold uppercase text-gray-450">Churn Rate</span>
                    <h3 class="text-2xl font-black text-red-500 mt-1">{{ $churnRate }}%</h3>
                    <p class="text-4xs text-gray-400 mt-2 font-semibold">Cancelled vs total subscription cycles</p>
                </div>
            </div>

            <!-- Revenue Share Distribution -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-3xs font-extrabold uppercase text-gray-450">Recruiter Plan Sales</span>
                    <h4 class="text-lg font-black text-indigo-650 mt-1">${{ number_format($subscriptionSales) }} CAD</h4>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-3xs font-extrabold uppercase text-gray-450">Featured Jobs Promotions</span>
                    <h4 class="text-lg font-black text-indigo-650 mt-1">${{ number_format($featuredJobSales) }} CAD</h4>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                    <span class="text-3xs font-extrabold uppercase text-gray-450">Seeker Resume Boosts</span>
                    <h4 class="text-lg font-black text-indigo-650 mt-1">${{ number_format($resumeBoostSales) }} CAD</h4>
                </div>
            </div>

            <!-- Transactions streams -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-750">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Transaction Logs Stream</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Transaction ID</th>
                                <th class="p-4">Customer</th>
                                <th class="p-4">Payment Type</th>
                                <th class="p-4">Amount</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Processed At</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/10 transition">
                                    <td class="p-4 font-mono font-bold">{{ $tx->transaction_id }}</td>
                                    <td class="p-4">
                                        {{ $tx->user->first_name }} {{ $tx->user->last_name }}
                                        <p class="text-4xs text-gray-400 font-normal mt-0.5">{{ $tx->user->email }}</p>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-900 rounded text-3xs font-extrabold text-gray-500 uppercase">
                                            {{ ucfirst(str_replace('_', ' ', $tx->payment_type)) }}
                                        </span>
                                    </td>
                                    <td class="p-4 font-black">${{ number_format($tx->amount) }} {{ $tx->currency }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-0.5 rounded text-3xs font-bold bg-emerald-100 text-emerald-800">
                                            {{ strtoupper($tx->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right text-gray-400">
                                        {{ $tx->paid_at ? $tx->paid_at->diffForHumans() : $tx->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 italic">No revenue transactions recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-900/30">
                    {{ $transactions->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
