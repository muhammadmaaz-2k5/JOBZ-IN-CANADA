<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{ 'dark': dark }"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - JOBZ IN CANADA</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-dark-900 text-gray-800 dark:text-gray-100 min-h-screen transition-colors duration-300">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Left Brand Panel (Hidden on mobile) -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-primary-600 to-indigo-900 text-white p-12 flex-col justify-between relative overflow-hidden">
            <!-- Visual Grid Overlay -->
            <div class="absolute inset-0 bg-grid opacity-10 pointer-events-none"></div>
            <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-accent-500/10 blur-3xl pointer-events-none"></div>

            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2 font-extrabold text-xl tracking-tight text-white relative z-10">
                <span class="grid place-items-center w-8 h-8 rounded-lg bg-white/20 text-white font-bold backdrop-blur-sm">J</span>
                <span>JOBZ IN <span class="text-accent-500">CANADA</span></span>
            </a>

            <!-- Graphic / Mock Job Listing Card -->
            <div class="relative z-10 my-auto max-w-md space-y-8">
                <div class="space-y-3">
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Connect with top employers across Canada.</h2>
                    <p class="text-primary-100/90 text-sm leading-relaxed">
                        Access thousands of verified job listings, build your professional profile, and apply to high-paying positions instantly.
                    </p>
                </div>

                <!-- Floating Interactive Card -->
                <div class="glass p-6 rounded-2xl border border-white/10 shadow-2xl bg-white/5 backdrop-blur-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/20 mb-2">
                                Verified Employer
                            </span>
                            <h3 class="font-bold text-base">Senior Full-Stack Architect</h3>
                            <p class="text-xs text-primary-200">TechCorp Canada · Toronto, ON</p>
                        </div>
                        <span class="font-extrabold text-xs text-accent-500">$120k - $145k CAD</span>
                    </div>
                    
                    <div class="mt-4 flex items-center space-x-2 text-[10px] text-primary-200">
                        <span class="px-2 py-1 rounded bg-white/5 border border-white/5">Full-Time</span>
                        <span class="px-2 py-1 rounded bg-white/5 border border-white/5">Hybrid</span>
                        <span class="px-2 py-1 rounded bg-white/5 border border-white/5">Benefits</span>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <span class="w-6 h-6 rounded-full bg-primary-400 border border-indigo-900 grid place-items-center text-[8px] font-bold">JD</span>
                            <span class="w-6 h-6 rounded-full bg-accent-500 border border-indigo-900 grid place-items-center text-[8px] font-bold">MA</span>
                            <span class="w-6 h-6 rounded-full bg-emerald-400 border border-indigo-900 grid place-items-center text-[8px] font-bold">KL</span>
                        </div>
                        <span class="text-[10px] text-primary-300">12 candidates applied recently</span>
                    </div>
                </div>
            </div>

            <!-- Footer info -->
            <p class="text-xs text-primary-200 relative z-10">© {{ date('Y') }} JOBZ IN CANADA. Made with care for the Canadian workforce.</p>
        </div>

        <!-- Right Login Panel -->
        <div class="w-full md:w-1/2 flex flex-col justify-between p-8 sm:p-12 md:p-16 lg:p-24 bg-white dark:bg-dark-900 relative">
            
            <!-- Navbar Action Area -->
            <div class="flex items-center justify-between w-full">
                <!-- Brand for mobile -->
                <a href="/" class="md:hidden flex items-center space-x-2 font-extrabold text-lg tracking-tight text-primary-600 dark:text-white">
                    <span class="grid place-items-center w-7 h-7 rounded-lg bg-primary-500 text-white font-bold">J</span>
                    <span>JOBZ <span class="text-accent-500">CAN</span></span>
                </a>
                
                <!-- Theme toggle -->
                <button @click="dark = !dark" type="button" class="ml-auto p-2 rounded-xl bg-gray-50 dark:bg-dark-800 border border-gray-200/50 dark:border-gray-700/50 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700/50 transition-colors" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark" style="display: none;">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>
            </div>

            <!-- Login Form Area -->
            <div class="my-auto max-w-sm w-full mx-auto py-8">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome Back</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sign in to manage your profile and listing updates</p>
                </div>

                <!-- Session Alert -->
                <x-auth-session-status class="mb-4 text-xs font-semibold" :status="session('status')" />

                <!-- Social Signin Component -->
                <div class="mb-6 grid grid-cols-2 gap-3">
                    <a href="#" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 hover:bg-gray-50 dark:hover:bg-dark-700 text-sm font-semibold text-gray-700 dark:text-gray-200 transition-colors shadow-sm cursor-pointer">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.38C21.68,11.96 21.56,11.5 21.35,11.1z" fill="#4285F4" />
                                <path d="M12,20.68c2.61,0 4.8,-0.87 6.4,-2.34l-3.3,-2.58c-0.92,0.62 -2.1,0.99 -3.1,0.99c-2.39,0 -4.41,-1.61 -5.13,-3.78H3.39v2.66C4.99,18.82 8.26,20.68 12,20.68z" fill="#34A853" />
                                <path d="M6.87,12.97c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7c0,-0.59 0.11,-1.16 0.29,-1.7V6.91H3.39C2.77,8.15 2.42,9.54 2.42,11c0,1.46 0.35,2.85 0.97,4.09l3.48,-2.12z" fill="#FBBC05" />
                                <path d="M12,5.65c1.42,0 2.7,0.49 3.7,1.44l2.77,-2.77C16.8,2.78 14.61,1.91 12,1.91c-3.74,0 -7.01,1.86 -8.61,4.72l3.48,2.66c0.72,-2.17 2.74,-3.78 5.13,-3.78z" fill="#EA4335" />
                            </g>
                        </svg>
                        Google
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 hover:bg-gray-50 dark:hover:bg-dark-700 text-sm font-semibold text-gray-700 dark:text-gray-200 transition-colors shadow-sm cursor-pointer">
                        <svg class="h-5 w-5 mr-2 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                        LinkedIn
                    </a>
                </div>

                <div class="relative flex items-center justify-center my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-150 dark:border-gray-800"></div>
                    </div>
                    <span class="relative bg-white dark:bg-dark-900 px-3 text-xs text-gray-400 font-semibold uppercase">Or signin with email</span>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" :value="__('Password')" />
                            @if (Route::has('password.request'))
                                <a class="text-xs font-semibold text-primary-500 hover:underline" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>
                        <x-text-input id="password" class="block mt-1 w-full text-sm" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center cursor-pointer select-none">
                            <div class="relative flex items-center">
                                <input id="remember_me" type="checkbox" name="remember" class="peer sr-only">
                                <div class="w-5 h-5 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-dark-800 flex items-center justify-center peer-checked:bg-primary-500 peer-checked:border-primary-500 transition-all duration-200 shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-white scale-0 peer-checked:scale-100 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <span class="ml-3 text-xs text-gray-500 dark:text-gray-400">Remember my session</span>
                        </label>
                    </div>

                    <!-- Submit Action Button -->
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent shadow-md text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 transition-colors cursor-pointer mt-2">
                        {{ __('Sign In') }}
                    </button>
                </form>
            </div>

            <!-- Footer / Registration redirect -->
            <div class="mt-auto pt-6 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-150 dark:border-gray-800">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-semibold text-primary-500 hover:underline">Register today</a>
            </div>
        </div>

    </div>

</body>
</html>
