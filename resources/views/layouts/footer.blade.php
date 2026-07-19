<footer class="bg-white dark:bg-dark-900 border-t border-gray-100 dark:border-gray-850 transition-colors duration-300">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand Section -->
            <div class="space-y-4 md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <x-application-logo class="w-8 h-8 text-primary-500" />
                    <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">JOBZ <span class="text-primary-500">CA</span></span>
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Connecting premium talent with top-tier Canadian employers. Build your future today.
                </p>
            </div>

            <!-- Categories Section -->
            <div>
                <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">For Job Seekers</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Browse Jobs</a></li>
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Resume Builder</a></li>
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Premium Account</a></li>
                </ul>
            </div>

            <!-- Employers Section -->
            <div>
                <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">For Employers</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Post a Job</a></li>
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Talent Search</a></li>
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Pricing Plans</a></li>
                </ul>
            </div>

            <!-- Legal Section -->
            <div>
                <h3 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Legal</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="text-sm text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">Cookie Policy</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <p class="text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ date('Y') }} JOBZ IN CANADA. All rights reserved.
            </p>
            <div class="flex space-x-6">
                <!-- Social media links here -->
            </div>
        </div>
    </div>
</footer>
