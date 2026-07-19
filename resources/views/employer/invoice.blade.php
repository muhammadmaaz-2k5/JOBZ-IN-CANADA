<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Invoice Receipt') }}
            </h2>
            <button onclick="window.print()" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &#128424; Print Receipt
            </button>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 space-y-8">
                
                <!-- Invoice Header -->
                <div class="flex justify-between items-start flex-wrap gap-4 border-b border-gray-100 dark:border-gray-750 pb-6">
                    <div>
                        <h3 class="text-2xl font-black text-indigo-650">JOBZ IN CANADA</h3>
                        <p class="text-xs text-gray-500 font-bold uppercase mt-1">Ontario, Canada</p>
                    </div>
                    <div class="text-right">
                        <h4 class="font-black text-base text-gray-900 dark:text-white">Receipt #: {{ $invoice->invoice_number }}</h4>
                        <p class="text-xs text-gray-400 font-semibold mt-1">Date: {{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : $payment->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-gray-650 dark:text-gray-300">
                    <div>
                        <p class="text-gray-400 text-3xs font-extrabold uppercase">Bill To:</p>
                        <p class="text-gray-900 dark:text-white font-bold mt-1">{{ $payment->user->first_name }} {{ $payment->user->last_name }}</p>
                        <p class="mt-0.5">{{ $payment->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400 text-3xs font-extrabold uppercase">Payment Details:</p>
                        <p class="text-gray-900 dark:text-white font-bold mt-1">Mock Card Gateway</p>
                        <p class="mt-0.5 font-mono text-3xs">{{ $payment->transaction_id }}</p>
                    </div>
                </div>

                <!-- Line Item Details -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-3">Description</th>
                                <th class="p-3">Quantity</th>
                                <th class="p-3 text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            <tr>
                                <td class="p-3 font-bold text-gray-900 dark:text-white">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }} Activation
                                </td>
                                <td class="p-3">1</td>
                                <td class="p-3 text-right">${{ number_format($invoice->subtotal) }} CAD</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totals section -->
                <div class="flex justify-end pt-4">
                    <div class="w-64 space-y-2 text-xs font-semibold text-gray-650 dark:text-gray-300">
                        <div class="flex justify-between border-b border-gray-50 dark:border-gray-750 pb-2">
                            <span>Subtotal:</span>
                            <span class="font-bold text-gray-900 dark:text-white">${{ number_format($invoice->subtotal) }} CAD</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-50 dark:border-gray-750 pb-2">
                            <span>Tax (13% HST):</span>
                            <span class="font-bold text-gray-900 dark:text-white">${{ number_format($invoice->tax) }} CAD</span>
                        </div>
                        <div class="flex justify-between text-base font-black text-indigo-650 pt-1">
                            <span>Total Paid:</span>
                            <span>${{ number_format($invoice->total) }} CAD</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-gray-750 text-center">
                    <p class="text-3xs text-gray-400 font-bold uppercase">Thank you for recruiting with JOBZ IN CANADA!</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
