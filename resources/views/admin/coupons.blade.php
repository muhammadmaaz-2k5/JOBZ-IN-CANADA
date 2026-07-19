<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Discount Coupons Administration') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Create Coupon Form -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 space-y-4">
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-755">Create Discount Coupon</h3>
                    
                    <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-4">
                        @csrf
                        
                        <div>
                            <x-input-label for="code" :value="__('Coupon Code')" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full text-xs" placeholder="e.g. HALFOFF, 20OFF" required />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="type" :value="__('Discount Type')" />
                                <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs shadow-sm">
                                    <option value="percentage">Percentage (%)</option>
                                    <option value="fixed">Fixed CAD ($)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="value" :value="__('Value')" />
                                <x-text-input id="value" name="value" type="number" class="mt-1 block w-full text-xs" required />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="starts_at" :value="__('Starts At')" />
                            <x-text-input id="starts_at" name="starts_at" type="date" class="mt-1 block w-full text-xs" value="{{ date('Y-m-d') }}" required />
                        </div>

                        <div>
                            <x-input-label for="expires_at" :value="__('Expires At')" />
                            <x-text-input id="expires_at" name="expires_at" type="date" class="mt-1 block w-full text-xs" />
                        </div>

                        <div>
                            <x-input-label for="usage_limit" :value="__('Usage Limit (Optional)')" />
                            <x-text-input id="usage_limit" name="usage_limit" type="number" class="mt-1 block w-full text-xs" />
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            Create Coupon
                        </button>
                    </form>
                </div>

                <!-- Coupons list -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 overflow-hidden h-fit">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-750">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Active & Inactive Coupons</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                    <th class="p-4">Coupon Code</th>
                                    <th class="p-4">Discount</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4">Duration</th>
                                    <th class="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                                @forelse($coupons as $c)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/10 transition">
                                        <td class="p-4 font-bold text-gray-900 dark:text-white">"{{ $c->code }}"</td>
                                        <td class="p-4">
                                            @if($c->type === 'percentage')
                                                {{ $c->value }}% off
                                            @else
                                                ${{ $c->value }} off
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            @if($c->isValid())
                                                <span class="px-2 py-0.5 rounded text-3xs font-bold bg-emerald-100 text-emerald-800">ACTIVE</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded text-3xs font-bold bg-red-100 text-red-800">EXPIRED/INACTIVE</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-gray-450">
                                            {{ $c->starts_at->format('M d') }} - {{ $c->expires_at ? $c->expires_at->format('M d, Y') : 'Never Expires' }}
                                        </td>
                                        <td class="p-4 text-right flex justify-end gap-2">
                                            <form method="POST" action="{{ route('admin.coupons.toggle', $c->id) }}">
                                                @csrf
                                                <button type="submit" class="text-xs text-indigo-650 hover:underline">
                                                    {{ $c->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.coupons.destroy', $c->id) }}" onsubmit="return confirm('Delete this coupon?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-gray-400 italic">No coupons registered yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
