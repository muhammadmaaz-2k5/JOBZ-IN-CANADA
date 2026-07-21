<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Invoice Receipt') }}
            </h2>
            <button onclick="window.print()">
                &#128424; Print Receipt
            </button>
        </div>
    </x-slot>

    <div>
        <div>
            <div>
                
                <!-- Invoice Header -->
                <div>
                    <div>
                        <h3>JOBZ IN CANADA</h3>
                        <p>Ontario, Canada</p>
                    </div>
                    <div>
                        <h4>Receipt #: {{ $invoice->invoice_number }}</h4>
                        <p>Date: {{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : $payment->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Customer Details -->
                <div>
                    <div>
                        <p>Bill To:</p>
                        <p>{{ $payment->user->first_name }} {{ $payment->user->last_name }}</p>
                        <p>{{ $payment->user->email }}</p>
                    </div>
                    <div>
                        <p>Payment Details:</p>
                        <p>Mock Card Gateway</p>
                        <p>{{ $payment->transaction_id }}</p>
                    </div>
                </div>

                <!-- Line Item Details -->
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }} Activation
                                </td>
                                <td>1</td>
                                <td>${{ number_format($invoice->subtotal) }} CAD</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totals section -->
                <div>
                    <div>
                        <div>
                            <span>Subtotal:</span>
                            <span>${{ number_format($invoice->subtotal) }} CAD</span>
                        </div>
                        <div>
                            <span>Tax (13% HST):</span>
                            <span>${{ number_format($invoice->tax) }} CAD</span>
                        </div>
                        <div>
                            <span>Total Paid:</span>
                            <span>${{ number_format($invoice->total) }} CAD</span>
                        </div>
                    </div>
                </div>

                <div>
                    <p>Thank you for recruiting with JOBZ IN CANADA!</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
