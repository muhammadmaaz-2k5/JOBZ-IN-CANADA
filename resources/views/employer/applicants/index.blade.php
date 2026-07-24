<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                {{ __('Manage Applicants') }}
            </h2>
            <a href="{{ route('employer.applicants.pipeline.all') }}" class="px-5 py-2.5 rounded-xl font-bold bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-md hover:border-emerald-500/50 text-slate-700 dark:text-slate-300 transition-all flex items-center gap-2 group">
                <svg class="w-5 h-5 text-emerald-500 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" /></svg>
                ATS Kanban Board →
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">
        
        <!-- Decorative blurred background elements -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-blue-400/10 blur-[120px]"></div>
            <div class="absolute bottom-[10%] -left-[10%] w-[40%] h-[60%] rounded-full bg-emerald-400/10 blur-[120px]"></div>
        </div>

        <div class="space-y-8">

            <!-- Filter Controls -->
            <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-6">
                <form method="GET" action="{{ route('employer.applicants.index') }}" class="flex flex-wrap items-end gap-5">
                    
                    <!-- Job select filter -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="job_select" :value="__('Filter By Job Posting')" class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5" />
                        <select id="job_select" name="job_id" onchange="window.location.href=this.value" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm font-medium text-slate-700 dark:text-slate-200">
                            <option value="{{ route('employer.applicants.index') }}">All Job Listings</option>
                            @foreach($jobsList as $j)
                                <option value="{{ route('employer.applicants.job', $j->id) }}" @selected($jobId == $j->id)>{{ Str::limit($j->title, 40) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="search" :value="__('Search Candidate')" class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </span>
                            <x-text-input id="search" name="search" type="text" placeholder="e.g. John Doe or email" :value="request('search')" class="w-full pl-10 rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm font-medium" />
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="w-[180px] shrink-0">
                        <x-input-label for="status" :value="__('Hiring Stage')" class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5" />
                        <select id="status" name="status" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm font-medium text-slate-700 dark:text-slate-200">
                            <option value="">All Stages</option>
                            @foreach([
                                'applied' => 'Applied',
                                'pending_review' => 'Pending Review',
                                'shortlisted' => 'Shortlisted',
                                'offered' => 'Offered',
                                'hired' => 'Hired',
                                'rejected' => 'Rejected',
                                'withdrawn' => 'Withdrawn'
                            ] as $key => $lbl)
                                <option value="{{ $key }}" @selected(request('status') == $key)>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-3 shrink-0">
                        <div class="w-[140px]">
                            <x-input-label for="sort" :value="__('Sort')" class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5" />
                            <select id="sort" name="sort" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm font-medium text-slate-700 dark:text-slate-200">
                                <option value="newest" @selected(request('sort') == 'newest')>Newest First</option>
                                <option value="oldest" @selected(request('sort') == 'oldest')>Oldest First</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-black text-white dark:bg-white dark:hover:bg-gray-100 dark:text-slate-900 font-bold rounded-xl shadow-lg transition-transform hover:scale-105">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Applicants list -->
            <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-slate-800/30">
                                <th class="py-4 px-6 font-black text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Candidate Name</th>
                                <th class="py-4 px-6 font-black text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Job Applied</th>
                                <th class="py-4 px-6 font-black text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Submission Date</th>
                                <th class="py-4 px-6 font-black text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Hiring Stage Status</th>
                                <th class="py-4 px-6 font-black text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-slate-700/50">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50">
                            @forelse($applications as $app)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-700 border-2 border-white dark:border-slate-600 shadow-sm shrink-0 flex items-center justify-center font-bold text-slate-500">
                                                @if($app->applicant->jobSeekerProfile && $app->applicant->jobSeekerProfile->profile_photo)
                                                    <img src="{{ Str::startsWith($app->applicant->jobSeekerProfile->profile_photo, ['http://', 'https://']) ? $app->applicant->jobSeekerProfile->profile_photo : asset('storage/' . $app->applicant->jobSeekerProfile->profile_photo) }}" alt="Photo" class="w-full h-full object-cover" />
                                                @else
                                                    {{ strtoupper(substr($app->applicant->first_name, 0, 1)) }}{{ strtoupper(substr($app->applicant->last_name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-900 dark:text-white truncate">{{ $app->applicant->first_name }} {{ $app->applicant->last_name }}</p>
                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $app->applicant->jobSeekerProfile->headline ?? 'No Headline' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-slate-700 dark:text-slate-300 mb-0.5">{{ Str::limit($app->job->title, 35) }}</p>
                                        <p class="text-xs text-gray-500 flex items-center gap-1"><svg class="w-3 h-3 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>{{ $app->job->location }}</p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($app->applied_at)->format('M d, Y') }}</span>
                                        </div>
                                        <p class="text-xs text-gray-400 ml-6">{{ \Carbon\Carbon::parse($app->applied_at)->diffForHumans() }}</p>
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $statusColors = [
                                                'applied' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border-blue-200 dark:border-blue-800/50',
                                                'pending_review' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border-amber-200 dark:border-amber-800/50',
                                                'shortlisted' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 border-purple-200 dark:border-purple-800/50',
                                                'interview_scheduled' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 border-indigo-200 dark:border-indigo-800/50',
                                                'interview_completed' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 border-cyan-200 dark:border-cyan-800/50',
                                                'offered' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50',
                                                'hired' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border-green-200 dark:border-green-800/50',
                                                'rejected' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 border-rose-200 dark:border-rose-800/50',
                                                'withdrawn' => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700',
                                            ];
                                            $badgeClass = $statusColors[$app->status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-3 py-1.5 text-xs font-black uppercase tracking-wider rounded-lg border {{ $badgeClass }}">
                                            {{ str_replace('_', ' ', $app->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('employer.applicants.show', $app->id) }}" class="p-2 rounded-xl bg-gray-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors shadow-sm group-hover:shadow" title="Review Profile">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            </a>
                                            <a href="{{ route('employer.applicants.download', $app->id) }}" class="p-2 rounded-xl bg-gray-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors shadow-sm group-hover:shadow" title="Download Resume">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-16 px-6 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 rounded-full bg-gray-50 dark:bg-slate-800 flex items-center justify-center mb-4 text-gray-400 border border-gray-100 dark:border-slate-700">
                                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">No applicants found</h3>
                                            <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Try adjusting your filters or wait for new applications to arrive for your job postings.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($applications->hasPages())
                    <div class="p-6 border-t border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-800/30">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
