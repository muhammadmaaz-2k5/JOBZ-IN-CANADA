<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                    <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
                <span class="truncate max-w-[200px] md:max-w-none">{{ $application->job->title }}</span>
            </h2>
            <a href="{{ route('seeker.applications.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="hidden sm:inline">Back to Applications</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 dark:bg-[#0f172a] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Summary Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-indigo-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">{{ $application->job->title }}</h3>
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400 mb-3">{{ $application->job->company->company_name }}</p>
                        <div class="flex flex-wrap items-center gap-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Applied on {{ \Carbon\Carbon::parse($application->applied_at)->format('M d, Y') }}
                            </span>
                            <span class="hidden sm:inline text-gray-300 dark:text-gray-600">&bull;</span>
                            <span class="flex items-center gap-1 bg-gray-100 dark:bg-gray-900/50 px-2 py-1 rounded-md border border-gray-200 dark:border-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Resume: <a href="{{ route('seeker.applications.download', $application->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $application->resume->title }}</a>
                            </span>
                        </div>
                    </div>

                    @php
                        $statusColors = [
                            'applied' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border-blue-200 dark:border-blue-800',
                            'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                            'shortlisted' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400 border-indigo-200 dark:border-indigo-800',
                            'interview_scheduled' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 border-purple-200 dark:border-purple-800',
                            'interview_completed' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 border-purple-200 dark:border-purple-800',
                            'offered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border-green-200 dark:border-green-800',
                            'hired' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-800',
                            'withdrawn' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600',
                        ];
                        $colorClass = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600';
                    @endphp

                    <div class="shrink-0 flex items-center justify-center md:justify-end w-full md:w-auto">
                        <span class="px-6 py-3 rounded-2xl text-sm font-black uppercase tracking-widest border shadow-sm {{ $colorClass }}">
                            {{ str_replace('_', ' ', $application->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Details -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Cover Letter Panel -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/></svg>
                            </div>
                            <h4 class="text-xl font-black text-gray-900 dark:text-white">Cover Letter</h4>
                        </div>
                        
                        <div class="prose prose-sm md:prose-base dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/40 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50">
                            @if($application->cover_letter)
                                {!! nl2br(e($application->cover_letter)) !!}
                            @else
                                <div class="text-center py-6">
                                    <svg class="w-10 h-10 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                                    <p class="text-gray-500 font-medium">No cover letter was submitted with this application.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Screening Answers Panel -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h4 class="text-xl font-black text-gray-900 dark:text-white">Screening Answers</h4>
                        </div>

                        <div class="space-y-6">
                            @forelse($application->screeningAnswers as $ans)
                                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                    <div class="bg-gray-50 dark:bg-gray-900/50 px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                                        <p class="font-bold text-gray-900 dark:text-white flex gap-3">
                                            <span class="text-amber-500">Q:</span>
                                            {{ $ans->question->question_text }}
                                        </p>
                                    </div>
                                    <div class="px-5 py-4">
                                        <p class="text-gray-600 dark:text-gray-300 flex gap-3">
                                            <span class="text-blue-500 font-bold">A:</span>
                                            {{ $ans->answer }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 bg-gray-50/50 dark:bg-gray-900/20 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-500 font-medium">No screening questions were required for this application.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Status Log Timeline -->
                <div class="space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 md:p-8 shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-gray-700/60 sticky top-8">
                        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100 dark:border-gray-700/50">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h4 class="text-xl font-black text-gray-900 dark:text-white">Status Timeline</h4>
                        </div>
                        
                        <div class="relative pl-4 border-l-2 border-gray-100 dark:border-gray-700 space-y-8">
                            @foreach($application->statusHistory as $hist)
                                <div class="relative group">
                                    <div class="absolute -left-[23px] top-1 w-4 h-4 rounded-full border-4 border-white dark:border-gray-800 bg-blue-500 shadow-sm group-hover:scale-125 transition-transform"></div>
                                    <div class="pl-2">
                                        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                                            {{ $hist->changed_at->format('M d, Y') }} <span class="mx-1 text-gray-300 dark:text-gray-600">|</span> {{ $hist->changed_at->format('h:i A') }}
                                        </p>
                                        <h5 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wide mb-2">
                                            {{ str_replace('_', ' ', $hist->new_status) }}
                                        </h5>
                                        @if($hist->remarks)
                                            <div class="bg-gray-50 dark:bg-gray-900/50 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                                <p class="text-sm text-gray-600 dark:text-gray-300 italic">"{{ $hist->remarks }}"</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
