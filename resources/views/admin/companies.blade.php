<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Company Verifications') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50">
                <form method="GET" action="{{ route('admin.companies.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="status" :value="__('Filter By Verification Status')" />
                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                            <option value="">All Statuses</option>
                            <option value="verified" @selected(request('status') == 'verified')>Verified</option>
                            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                            <option value="rejected" @selected(request('status') == 'rejected')>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="search" :value="__('Search Company Name')" />
                        <input type="text" name="search" id="search" placeholder="e.g. Indeed" value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs" />
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Companies List Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                <th class="p-4">Company Name</th>
                                <th class="p-4">Industry</th>
                                <th class="p-4">Website</th>
                                <th class="p-4">Size</th>
                                <th class="p-4">Verification</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                            @forelse($companies as $company)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $company->company_name }}</div>
                                    </td>
                                    <td class="p-4">{{ $company->industry }}</td>
                                    <td class="p-4">
                                        <a href="{{ $company->website }}" target="_blank" class="text-indigo-650 hover:underline">{{ $company->website }}</a>
                                    </td>
                                    <td class="p-4">{{ $company->company_size }}</td>
                                    <td class="p-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-4xs font-black uppercase 
                                            @if($company->verification_status === 'verified') bg-emerald-100 text-emerald-850
                                            @elseif($company->verification_status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $company->verification_status }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Verify Action -->
                                            <form method="POST" action="{{ route('admin.companies.verify', $company->id) }}" class="inline-flex gap-1">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" class="border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 text-4xs rounded-xl py-0.5 px-2">
                                                    <option value="pending" @selected($company->verification_status === 'pending')>Pending</option>
                                                    <option value="verified" @selected($company->verification_status === 'verified')>Verify</option>
                                                    <option value="rejected" @selected($company->verification_status === 'rejected')>Reject</option>
                                                </select>
                                            </form>

                                            <!-- Suspend toggle -->
                                            <form method="POST" action="{{ route('admin.companies.status', $company->id) }}">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-650 font-bold rounded-xl text-3xs transition">
                                                    {{ $company->verification_status === 'suspended' ? 'Activate' : 'Suspend' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400 italic">No companies found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-900/30">
                    {{ $companies->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
