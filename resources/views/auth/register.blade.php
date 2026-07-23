<x-guest-layout>
    <div>
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-gray-900 mb-2">Join the Platform</h2>
            <p class="text-gray-500 font-medium">Choose your registration pathway below to begin</p>
        </div>

        <div class="space-y-4">
            <!-- Job Seeker Pathway Card -->
            <a href="{{ route('register.seeker') }}" class="group flex items-start gap-4 p-5 rounded-2xl border-2 border-gray-100 hover:border-[#1650e1] bg-white hover:bg-[#1650e1]/5 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 bg-blue-50 text-[#1650e1] rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-lg font-bold text-gray-900 group-hover:text-[#1650e1] transition-colors">I'm a Job Seeker</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-[#1650e1] group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Find and apply to verified jobs, upload resume profiles, and track applications.
                    </p>
                </div>
            </a>

            <!-- Employer Pathway Card -->
            <a href="{{ route('register.employer') }}" class="group flex items-start gap-4 p-5 rounded-2xl border-2 border-gray-100 hover:border-amber-400 bg-white hover:bg-amber-50 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-lg font-bold text-gray-900 group-hover:text-amber-500 transition-colors">I'm an Employer</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Publish opportunities, hire talent, access database search, and build your business.
                    </p>
                </div>
            </a>
        </div>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600 font-medium">
                Already registered? 
                <a href="{{ route('login') }}" class="text-[#1650e1] font-bold hover:underline">Sign In</a>
            </p>
        </div>
    </div>
</x-guest-layout>
