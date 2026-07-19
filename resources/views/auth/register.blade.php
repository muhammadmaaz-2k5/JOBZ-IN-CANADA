<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-4">
        <div class="mb-8 text-center">
            <a href="/" class="inline-flex items-center space-x-2 font-extrabold text-2xl tracking-tight text-primary-600 dark:text-white mb-6">
                <span class="grid place-items-center w-8 h-8 rounded-lg bg-primary-500 text-white font-bold text-base">J</span>
                <span>JOBZ IN <span class="text-accent-500">CANADA</span></span>
            </a>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Join the Platform</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-450">Choose your registration pathway below to begin</p>
        </div>

        <div class="space-y-4">
            <!-- Job Seeker Pathway Card -->
            <a href="{{ route('register.seeker') }}" class="group flex items-start p-5 rounded-2xl border border-gray-200 dark:border-gray-850 bg-white dark:bg-dark-800 shadow-sm hover:shadow-premium hover:border-primary-500/50 transition-all duration-300">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-950/20 text-primary-500 group-hover:scale-110 transition-transform duration-300 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-gray-900 dark:text-gray-100 text-base group-hover:text-primary-500 transition-colors">I'm a Job Seeker</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-primary-500 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                        Find and apply to verified jobs, upload resume profiles, and track applications.
                    </p>
                </div>
            </a>

            <!-- Employer Pathway Card -->
            <a href="{{ route('register.employer') }}" class="group flex items-start p-5 rounded-2xl border border-gray-200 dark:border-gray-850 bg-white dark:bg-dark-800 shadow-sm hover:shadow-premium hover:border-accent-500/50 transition-all duration-300">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-accent-500 group-hover:scale-110 transition-transform duration-300 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-gray-900 dark:text-gray-100 text-base group-hover:text-accent-500 transition-colors">I'm an Employer</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-accent-500 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                        Publish opportunities, hire talent, access database search, and build your business.
                    </p>
                </div>
            </a>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-150 dark:border-gray-800 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-450">
                Already registered? 
                <a href="{{ route('login') }}" class="font-semibold text-primary-500 hover:underline">Sign In</a>
            </p>
        </div>
    </div>
</x-guest-layout>
