<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Discount Coupons Administration') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <!-- Create Coupon Form -->
                <div>
                    <h3>Create Discount Coupon</h3>
                    
                    <form method="POST" action="{{ route('admin.coupons.store') }}">
                        @csrf
                        
                        <div>
                            <x-input-label for="code" :value="__('Coupon Code')" />
                            <x-text-input id="code" name="code" type="text" placeholder="e.g. HALFOFF, 20OFF" required />
                        </div>

                        <div>
                            <div>
                                <x-input-label for="type" :value="__('Discount Type')" />
                                <select id="type" name="type">
                                    <option value="percentage">Percentage (%)</option>
                                    <option value="fixed">Fixed CAD ($)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="value" :value="__('Value')" />
                                <x-text-input id="value" name="value" type="number" required />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="starts_at" :value="__('Starts At')" />
                            <x-text-input id="starts_at" name="starts_at" type="date" value="{{ date('Y-m-d') }}" required />
                        </div>

                        <div>
                            <x-input-label for="expires_at" :value="__('Expires At')" />
                            <x-text-input id="expires_at" name="expires_at" type="date" />
                        </div>

                        <div>
                            <x-input-label for="usage_limit" :value="__('Usage Limit (Optional)')" />
                            <x-text-input id="usage_limit" name="usage_limit" type="number" />
                        </div>

                        <button type="submit">
                            Create Coupon
                        </button>
                    </form>
                </div>

                <!-- Coupons list -->
                <div>
                    <div>
                        <h3>Active & Inactive Coupons</h3>
                    </div>

                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Coupon Code</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th>Duration</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $c)
                                    <tr>
                                        <td>"{{ $c->code }}"</td>
                                        <td>
                                            @if($c->type === 'percentage')
                                                {{ $c->value }}% off
                                            @else
                                                ${{ $c->value }} off
                                            @endif
                                        </td>
                                        <td>
                                            @if($c->isValid())
                                                <span>ACTIVE</span>
                                            @else
                                                <span>EXPIRED/INACTIVE</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $c->starts_at->format('M d') }} - {{ $c->expires_at ? $c->expires_at->format('M d, Y') : 'Never Expires' }}
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.coupons.toggle', $c->id) }}">
                                                @csrf
                                                <button type="submit">
                                                    {{ $c->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.coupons.destroy', $c->id) }}" onsubmit="return confirm('Delete this coupon?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No coupons registered yet.</td>
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
