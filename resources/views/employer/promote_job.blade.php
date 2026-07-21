<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Promote Job Listing') }}
        </h2>
    </x-slot>

    <div>
        <div>
            <div>
                
                <div>
                    <h3>Promote to Featured Listing</h3>
                    <p>Get your job posting highlighted at the top of candidate feeds, search results, and email alerts.</p>
                </div>

                <div>
                    Job Posting: <span>"{{ $job->title }}"</span>
                </div>

                <form method="POST" action="{{ route('employer.jobs.promote.submit', $job->id) }}">
                    @csrf
                    
                    <div>
                        <x-input-label for="duration_days" :value="__('Select Promotion Duration')" />
                        <select id="duration_days" name="duration_days">
                            <option value="7">7 Days - $10 CAD</option>
                            <option value="15">15 Days - $18 CAD</option>
                            <option value="30" selected>30 Days - $30 CAD</option>
                            <option value="60">60 Days - $50 CAD</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="coupon_code" :value="__('Apply Promo Coupon')" />
                        <x-text-input id="coupon_code" name="coupon_code" type="text" placeholder="ENTER COUPON CODE" />
                    </div>

                    <button type="submit">
                        Purchase Promotion (Mock Checkout)
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
