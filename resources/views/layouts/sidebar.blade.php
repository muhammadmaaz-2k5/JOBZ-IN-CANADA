<aside :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-0 -translate-x-full lg:translate-x-0 lg:w-0'" class="fixed inset-y-0 left-0 z-40 glass border-r border-gray-100 dark:border-gray-800 transition-all duration-300 ease-in-out lg:static lg:h-screen lg:flex-shrink-0 overflow-hidden">
    <div class="flex flex-col h-full w-64">
        <!-- Logo Header -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-100 dark:border-gray-800/80">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <x-application-logo class="w-8 h-8 text-primary-500" />
                <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">JOBZ <span class="text-primary-500">CA</span></span>
            </a>
            <button @click="sidebarOpen = false" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            @auth
                <a href="{{ route('messages.index') }}" class="flex items-center justify-between px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                    <span class="flex items-center gap-2">
                        💬 Messages
                    </span>
                    <span class="px-2 py-0.5 bg-red-500 text-white text-3xs font-extrabold rounded-full">2</span>
                </a>
                
                <a href="{{ route('notifications.index') }}" class="flex items-center justify-between px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                    <span class="flex items-center gap-2">
                        🔔 Notifications
                    </span>
                </a>

                <a href="{{ route('settings.edit') }}" class="flex items-center justify-between px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                    <span class="flex items-center gap-2">
                        ⚙️ Settings
                    </span>
                </a>

                <div class="px-3 my-2 border-t border-gray-100 dark:border-gray-800"></div>

                @role('job_seeker')
                    <div class="px-3 mb-2 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Seeker Menu</div>
                    <a href="{{ route('seeker.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Dashboard
                    </a>
                    <a href="{{ route('seeker.profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        My Profile
                    </a>
                    <a href="{{ route('seeker.resume-builder') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Resume Builder
                    </a>
                @endrole

                @role('employer')
                    <div class="px-3 mb-2 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Employer Menu</div>
                    <a href="{{ route('employer.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Dashboard
                    </a>
                    <a href="{{ route('employer.profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Company Profile
                    </a>
                    <a href="{{ route('employer.jobs.index') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Job Postings
                    </a>
                    <a href="{{ route('employer.applicants.index') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Applicants
                    </a>
                    <a href="{{ route('employer.billing.index') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Subscription & Billing
                    </a>
                @endrole

                @role('admin')
                    <div class="px-3 mb-2 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Admin Panel</div>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Users
                    </a>
                    <a href="{{ route('admin.companies.index') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Companies
                    </a>
                    <a href="{{ route('admin.jobs.index') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-dark-800 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        Jobs
                    </a>
                @endrole
            @endauth
        </nav>

        <!-- User Profile Footer -->
        @auth
            <div class="p-4 border-t border-gray-100 dark:border-gray-800/80">
                <div class="flex items-center space-x-3">
                    <div class="h-9 w-9 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center font-bold text-primary-600">
                        {{ substr(Auth::user()->first_name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</aside>
