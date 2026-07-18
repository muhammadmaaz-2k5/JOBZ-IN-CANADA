<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Application Details: ') }} {{ $application->job->title }}
            </h2>
            <a href="{{ route('seeker.applications.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Summary Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $application->job->title }}</h3>
                    <p class="text-sm text-gray-500 font-semibold mt-0.5">{{ $application->job->company->company_name }}</p>
                    <div class="flex items-center gap-3 text-xs text-gray-400 mt-2">
                        <span>Applied on: {{ \Carbon\Carbon::parse($application->applied_at)->format('M d, Y') }}</span>
                        <span>&bull;</span>
                        <span>Resume used: <a href="{{ route('seeker.applications.download', $application->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">{{ $application->resume->title }}</a></span>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-2">
                    <span class="px-3.5 py-1 rounded-full text-xs font-extrabold uppercase 
                        @if($application->status === 'applied') bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300
                        @elseif($application->status === 'pending_review') bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300
                        @elseif($application->status === 'shortlisted') bg-indigo-100 text-indigo-850 dark:bg-indigo-950 dark:text-indigo-300
                        @elseif(str_contains($application->status, 'interview')) bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300
                        @elseif($application->status === 'offered') bg-pink-100 text-pink-850 dark:bg-pink-950 dark:text-pink-300
                        @elseif($application->status === 'hired') bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300
                        @elseif($application->status === 'withdrawn') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                        @else bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300
                        @endif">
                        {{ str_replace('_', ' ', $application->status) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Details -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Cover Letter Panel -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Cover Letter</h4>
                        @if($application->cover_letter)
                            <p class="text-sm text-gray-650 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $application->cover_letter }}</p>
                        @else
                            <p class="text-xs text-gray-400 italic">No cover letter was submitted with this application.</p>
                        @endif
                    </div>

                    <!-- Screening Answers Panel -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Screening Answers</h4>
                        <div class="space-y-4">
                            @forelse($application->screeningAnswers as $ans)
                                <div class="space-y-1">
                                    <p class="text-xs font-extrabold text-gray-500">{{ $ans->question->question_text }}</p>
                                    <p class="text-sm text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-900 p-3 rounded-xl border border-gray-150 dark:border-gray-800">{{ $ans->answer }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No screening questions were defined for this opening.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Status Log Timeline -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 p-6 space-y-6">
                        <h4 class="font-extrabold text-base text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Status Timeline</h4>
                        
                        <div class="relative border-s border-gray-200 dark:border-gray-700 ms-3 space-y-6 pt-2 pb-2">
                            @foreach($application->statusHistory as $hist)
                                <div class="mb-6 ms-4 relative">
                                    <div class="absolute -left-6 top-1.5 w-3 h-3 bg-indigo-600 rounded-full border border-white dark:border-gray-850"></div>
                                    <p class="text-2xs text-gray-455">{{ $hist->changed_at->format('M d, Y - h:i A') }}</p>
                                    <h5 class="text-sm font-bold text-gray-900 dark:text-white uppercase mt-0.5">{{ str_replace('_', ' ', $hist->new_status) }}</h5>
                                    @if($hist->remarks)
                                        <p class="text-xs text-gray-500 italic mt-0.5">"{{ $hist->remarks }}"</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
