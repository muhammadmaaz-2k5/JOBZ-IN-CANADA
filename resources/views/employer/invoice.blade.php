<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Invoice Receipt') }}
            </h2>
            <button onclick="window.print()" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition-colors font-semibold text-sm">
                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Receipt
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 p-8 sm:p-12 print:shadow-none print:border-none print:p-0">
                
                <!-- Invoice Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-200 pb-8 mb-8 gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#1650e1] to-indigo-600 text-white flex items-center justify-center font-bold text-3xl shadow-lg">
                            J
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight">JOBZ IN <span class="text-[#1650e1]">CANADA</span></h3>
                            <p class="text-gray-500 text-sm font-medium mt-1">Ontario, Canada</p>
                        </div>
                    </div>
                    <div class="text-left md:text-right">
                        <h4 class="text-xl font-bold text-gray-900">Receipt #: <span class="text-[#1650e1]">{{ $invoice->invoice_number }}</span></h4>
                        <p class="text-gray-500 font-medium mt-1">Date: {{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : $payment->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 shadow-sm">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Billed To</p>
                        <p class="text-xl font-bold text-gray-900 mb-1">{{ $payment->user->first_name }} {{ $payment->user->last_name }}</p>
                        <p class="text-gray-600 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $payment->user->email }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 shadow-sm">
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Payment Details</p>
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-[#1650e1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <p class="font-bold text-gray-900">Mock Card Gateway</p>
                        </div>
                        <p class="text-gray-600 text-sm font-medium">Txn ID: <span class="font-mono bg-gray-200 px-1 py-0.5 rounded">{{ $payment->transaction_id }}</span></p>
                        <div class="mt-3">
                            <span class="inline-block bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200">
                                ✓ PAID IN FULL
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Line Item Details -->
                <div class="mb-10 overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-left border-collapse bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">Description</th>
                                <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider text-center border-b border-gray-200">Quantity</th>
                                <th class="py-4 px-6 font-bold text-gray-700 uppercase text-xs tracking-wider text-right border-b border-gray-200">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr>
                                <td class="py-6 px-6 font-bold text-gray-900 border-b border-gray-100">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }} Activation
                                    <p class="text-sm text-gray-500 font-normal mt-1">Single job posting or feature promotion</p>
                                </td>
                                <td class="py-6 px-6 text-center border-b border-gray-100 font-medium">1</td>
                                <td class="py-6 px-6 text-right font-bold border-b border-gray-100">${{ number_format($invoice->subtotal, 2) }} CAD</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totals section -->
                <div class="flex justify-end mb-12">
                    <div class="w-full md:w-1/2 lg:w-2/5 space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <div class="flex justify-between items-center text-gray-600 font-medium">
                            <span>Subtotal</span>
                            <span>${{ number_format($invoice->subtotal, 2) }} CAD</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600 font-medium pb-4 border-b-2 border-gray-200">
                            <span>Tax (13% HST)</span>
                            <span>${{ number_format($invoice->tax, 2) }} CAD</span>
                        </div>
                        <div class="flex justify-between items-center text-2xl font-black text-gray-900 pt-2">
                            <span>Total Paid</span>
                            <span class="text-[#1650e1]">${{ number_format($invoice->total, 2) }} CAD</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center pt-8 border-t border-gray-200">
                    <p class="text-gray-500 font-medium text-lg">Thank you for recruiting with <span class="font-bold text-gray-900">JOBZ IN CANADA!</span></p>
                    <p class="text-sm text-gray-400 mt-2">If you have any questions about this receipt, please contact support@jobzincanada.com</p>
                </div>

            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                background: white;
            }
            .min-h-screen {
                background: white;
            }
            /* Hide the main layout elements like nav bar */
            nav, header {
                display: none !important;
            }
            /* Reset padding/margins for print */
            main, .py-12 {
                padding: 0 !important;
                margin: 0 !important;
            }
            .max-w-4xl {
                max-width: 100% !important;
                margin: 0 !important;
            }
            /* Hide print button when printing */
            button[onclick="window.print()"] {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
