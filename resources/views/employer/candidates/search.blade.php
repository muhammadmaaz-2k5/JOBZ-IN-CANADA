<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Premium Candidate Search') }}
            </h2>
            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-650 dark:bg-indigo-950 dark:text-indigo-300 font-extrabold text-2xs rounded-lg border border-indigo-150 uppercase">
                ⚡ Premium Recruiter Database Access
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Candidate Search Filters -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50">
                <form method="GET" action="{{ route('employer.candidates.search') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="keyword" :value="__('Skills or Keywords')" />
                        <x-text-input id="keyword" name="keyword" type="text" class="mt-1 block w-full text-sm" placeholder="e.g. Laravel, React, Manager" :value="request('keyword')" />
                    </div>
                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full text-sm" placeholder="e.g. Toronto, Vancouver" :value="request('location')" />
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full py-2.5 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-sm transition shadow-sm">
                            Search Candidates
                        </button>
                    </div>
                </form>
            </div>

            <!-- Candidate Listings -->
            <div class="space-y-4">
                @forelse($candidates as $candidate)
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 hover:shadow-lg transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative">
                        
                        @if($candidate->activeResumeBoost && $candidate->activeResumeBoost->isValid())
                            <span class="absolute top-0 right-0 bg-emerald-500 text-white text-3xs font-extrabold px-3 py-1 rounded-bl-xl rounded-tr-2xl uppercase">⭐ BOOSTED</span>
                        @endif

                        <div class="flex items-start gap-4">
                            <!-- Placeholder avatar -->
                            <div class="w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-950 flex items-center justify-center font-bold text-indigo-650 dark:text-indigo-300">
                                {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                            </div>
                            
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-base text-gray-900 dark:text-white">
                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                </h4>
                                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $candidate->jobSeekerProfile->headline ?? 'Candidate Seeker' }}
                                </p>
                                <p class="text-3xs text-gray-400 font-bold uppercase">
                                    📍 {{ $candidate->jobSeekerProfile->city ?? 'Toronto' }}, {{ $candidate->jobSeekerProfile->country ?? 'Canada' }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('employer.candidates.show', $candidate->id) }}" class="px-4 py-2 bg-indigo-50 dark:bg-indigo-950 text-indigo-650 dark:text-indigo-400 font-bold text-xs rounded-xl hover:bg-indigo-100 transition border border-indigo-200">
                                View Profile Details &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <p class="text-xs text-gray-400 italic">No candidates match your queries.</p>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $candidates->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
