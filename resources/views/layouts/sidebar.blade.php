<aside
    class="fixed inset-y-0 left-0 z-40 w-72 bg-white dark:bg-[#0f172a] border-r border-gray-200 dark:border-gray-800 shadow-sm transition-transform duration-300 flex flex-col"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="flex flex-col h-full overflow-y-auto">

        {{-- ── Logo ─────────────────────────────────────────── --}}
        <div class="h-20 flex items-center justify-between px-6 shrink-0 border-b border-gray-100 dark:border-gray-800/60 sticky top-0 bg-white/95 dark:bg-[#0f172a]/95 backdrop-blur-sm z-10">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-xl font-black text-gray-900 dark:text-white no-underline tracking-tight group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-blue-500/30 group-hover:scale-105 transition-transform">
                    <span>J</span>
                </div>
                <span>
                    JOBZ IN <span class="text-blue-600 dark:text-blue-400">CANADA</span>
                </span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- ── Navigation ───────────────────────────────────── --}}
        <nav class="flex-1 px-4 py-6 space-y-8">
            @auth

                {{-- Global Links --}}
                <div class="space-y-1.5">
                    <a href="{{ route('notifications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('notifications.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                        <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="flex-1">Notifications</span>
                    </a>

                    <a href="{{ route('settings.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('settings.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                        <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="flex-1">Settings</span>
                    </a>
                </div>

                <div class="h-px w-full bg-gray-100 dark:bg-gray-800"></div>

                {{-- ── Job Seeker Menu ───────────────────────── --}}
                @role('job_seeker')
                    <div class="space-y-1.5">
                        <p class="px-4 text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Job Seeker</p>

                        <a href="{{ route('seeker.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('seeker.dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="flex-1">Dashboard</span>
                        </a>

                        <a href="{{ route('seeker.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('seeker.profile.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="flex-1">My Profile</span>
                        </a>

                        <a href="{{ route('seeker.applications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('seeker.applications.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span class="flex-1">My Applications</span>
                        </a>

                        

                        <a href="{{ route('jobs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('jobs.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span class="flex-1">Browse Jobs</span>
                        </a>
                    </div>
                @endrole

                {{-- ── Employer Menu ─────────────────────────── --}}
                @role('employer')
                    <div class="space-y-1.5">
                        <p class="px-4 text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Employer</p>

                        <a href="{{ route('employer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('employer.dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="flex-1">Dashboard</span>
                        </a>

                        <a href="{{ route('employer.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('employer.profile.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="flex-1">Company Profile</span>
                        </a>

                        <a href="{{ route('employer.jobs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('employer.jobs.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                            <span class="flex-1">Job Postings</span>
                        </a>

                        <a href="{{ route('employer.applicants.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('employer.applicants.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="flex-1">Applicants</span>
                        </a>

                        <a href="{{ route('employer.billing.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('employer.billing.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span class="flex-1">Billing & Plans</span>
                        </a>
                    </div>
                @endrole

                {{-- ── Admin Menu ────────────────────────────── --}}
                @role('admin')
                    <div class="space-y-1.5">
                        <p class="px-4 text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Admin</p>

                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="flex-1">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="flex-1">Users</span>
                        </a>

                        <a href="{{ route('admin.companies.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.companies.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="flex-1">Companies</span>
                        </a>

                        <a href="{{ route('admin.jobs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.jobs.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                            <span class="flex-1">Jobs</span>
                        </a>

                        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all group {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                            <svg class="w-6 h-6 opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span class="flex-1">Categories</span>
                        </a>
                    </div>
                @endrole

            @endauth
        </nav>

        {{-- ── User Footer ──────────────────────────────────── --}}
        @auth
            <div class="p-4 border-t border-gray-100 dark:border-gray-800/60 bg-gray-50 dark:bg-[#0f172a] shrink-0">
                <a href="{{ request()->user()->hasRole('job_seeker') ? route('seeker.profile.edit') : (request()->user()->hasRole('employer') ? route('employer.profile.edit') : '#') }}" class="flex items-center gap-3 w-full p-2 rounded-xl hover:bg-white dark:hover:bg-gray-800 hover:shadow-sm transition-all group">
                    {{-- Avatar --}}
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-sm group-hover:scale-105 transition-transform">
                            {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? '', 0, 1)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                    </div>
                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                            @role('admin') Admin @endrole
                            @role('employer') Employer @endrole
                            @role('job_seeker') Job Seeker @endrole
                        </p>
                    </div>
                    {{-- Chevron --}}
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endauth

    </div>
</aside>
