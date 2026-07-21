<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Company Verifications') }}
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

            <!-- Search and Filter -->
            <div>
                <form method="GET" action="{{ route('admin.companies.index') }}">
                    <div>
                        <x-input-label for="status" :value="__('Filter By Verification Status')" />
                        <select name="status" id="status">
                            <option value="">All Statuses</option>
                            <option value="verified" @selected(request('status') == 'verified')>Verified</option>
                            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                            <option value="rejected" @selected(request('status') == 'rejected')>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="search" :value="__('Search Company Name')" />
                        <input type="text" name="search" id="search" placeholder="e.g. Indeed" value="{{ request('search') }}" />
                    </div>

                    <div>
                        <button type="submit">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Companies List Table -->
            <div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Industry</th>
                                <th>Website</th>
                                <th>Size</th>
                                <th>Verification</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                                <tr>
                                    <td>
                                        <div>{{ $company->company_name }}</div>
                                    </td>
                                    <td>{{ $company->industry }}</td>
                                    <td>
                                        <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                    </td>
                                    <td>{{ $company->company_size }}</td>
                                    <td>
                                        <span>
                                            {{ $company->verification_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <!-- Verify Action -->
                                            <form method="POST" action="{{ route('admin.companies.verify', $company->id) }}">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()">
                                                    <option value="pending" @selected($company->verification_status === 'pending')>Pending</option>
                                                    <option value="verified" @selected($company->verification_status === 'verified')>Verify</option>
                                                    <option value="rejected" @selected($company->verification_status === 'rejected')>Reject</option>
                                                </select>
                                            </form>

                                            <!-- Suspend toggle -->
                                            <form method="POST" action="{{ route('admin.companies.status', $company->id) }}">
                                                @csrf
                                                <button type="submit">
                                                    {{ $company->verification_status === 'suspended' ? 'Activate' : 'Suspend' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No companies found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $companies->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
