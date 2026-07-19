<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $candidate->first_name }} {{ $candidate->last_name }}
            </h2>
            <a href="{{ route('employer.candidates.search') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Candidate Database
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Profile Overview Panel -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-full bg-indigo-50 dark:bg-indigo-950 flex items-center justify-center font-bold text-indigo-650 dark:text-indigo-300 text-xl">
                        {{ strtoupper(substr($candidate->first_name, 0, 1) . substr($candidate->last_name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-950 dark:text-white">{{ $candidate->first_name }} {{ $candidate->last_name }}</h3>
                        <p class="text-sm text-gray-650 dark:text-gray-300 font-semibold">{{ $candidate->jobSeekerProfile->headline ?? 'Headline not specified' }}</p>
                        <p class="text-xs text-gray-400 font-bold mt-1 uppercase">📍 {{ $candidate->jobSeekerProfile->city ?? 'Toronto' }}, {{ $candidate->jobSeekerProfile->country ?? 'Canada' }}</p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('employer.candidates.download-resume', $candidate->id) }}" class="px-6 py-3 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-md">
                        Download Candidate Resume
                    </a>
                </div>
            </div>

            <!-- About / Bio panel -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 space-y-4">
                <h4 class="font-extrabold text-base text-gray-950 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-750">About Me / Bio</h4>
                <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed leading-6 whitespace-pre-line">
                    {{ $candidate->jobSeekerProfile->about_me ?? 'No profile description provided.' }}
                </p>
            </div>

            <!-- Skills panel -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow border border-gray-100 dark:border-gray-700/50 space-y-4">
                <h4 class="font-extrabold text-base text-gray-950 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-755">Professional Skills</h4>
                <div class="flex flex-wrap gap-2">
                    @forelse(explode(',', $candidate->jobSeekerProfile->skills ?? '') as $skill)
                        @if(trim($skill))
                            <span class="px-3 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-lg text-xs font-bold text-gray-650 dark:text-gray-300">
                                {{ trim($skill) }}
                            </span>
                        @endif
                    @empty
                        <span class="text-xs text-gray-400 italic">No skills listed yet.</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
