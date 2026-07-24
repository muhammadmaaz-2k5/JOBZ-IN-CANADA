<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :class="{'dark': dark}"
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      class="antialiased"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - JOBZ IN CANADA</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/js/app.js'])

    <!-- Firebase Init -->
    <x-firebase-init />
</head>
<body class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 transition-colors duration-300 font-sans">

    <div class="flex min-h-screen">
        
        <!-- Left Brand Panel (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-12 flex-col justify-between">
            <!-- Visual Grid Overlay -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
            <div class="absolute -top-[30%] -right-[20%] w-[80%] h-[80%] rounded-full bg-[#1650e1]/20 blur-[120px] pointer-events-none"></div>

            <!-- Logo -->
            <a href="/" class="relative z-10 inline-flex items-center gap-3 group">
                <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center text-white font-bold text-xl border border-white/20 group-hover:bg-white/20 transition-all">
                    <span>J</span>
                </div>
                <span class="text-xl font-black tracking-tight text-white">
                    JOBZ IN <span class="text-[#1650e1]">CANADA</span>
                </span>
            </a>

            <!-- Graphic / Mock Job Listing Card -->
            <div class="relative z-10 w-full max-w-lg mx-auto">
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-4xl font-bold text-white mb-4 leading-tight">Connect with top employers across Canada.</h2>
                    <p class="text-indigo-200/80 text-lg leading-relaxed">
                        Access thousands of verified job listings, build your professional profile, and apply to high-paying positions instantly.
                    </p>
                </div>

                <!-- Floating Interactive Card -->
                <div class="bg-white/10 backdrop-blur-2xl border border-white/20 rounded-3xl p-6 shadow-2xl transform -rotate-2 hover:rotate-0 transition-all duration-500 hover:scale-105">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold mb-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Verified Employer
                            </span>
                            <h3 class="text-xl font-bold text-white">Senior Full-Stack Architect</h3>
                            <p class="text-indigo-200 text-sm mt-1">TechCorp Canada · Toronto, ON</p>
                        </div>
                        <span class="text-emerald-400 font-semibold">$120k - $145k CAD</span>
                    </div>
                    
                    <div class="flex gap-2 mb-6">
                        <span class="px-3 py-1 rounded-lg bg-white/5 text-indigo-100 text-xs border border-white/10">Full-Time</span>
                        <span class="px-3 py-1 rounded-lg bg-white/5 text-indigo-100 text-xs border border-white/10">Hybrid</span>
                        <span class="px-3 py-1 rounded-lg bg-white/5 text-indigo-100 text-xs border border-white/10">Benefits</span>
                    </div>

                    <div class="flex items-center justify-between border-t border-white/10 pt-4">
                        <div class="flex -space-x-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-xs font-bold text-white border-2 border-[#1a1c2c]">JD</div>
                            <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-xs font-bold text-white border-2 border-[#1a1c2c]">MA</div>
                            <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-xs font-bold text-white border-2 border-[#1a1c2c]">KL</div>
                        </div>
                        <span class="text-indigo-200 text-xs font-medium">12 candidates applied recently</span>
                    </div>
                </div>
            </div>

            <!-- Footer info -->
            <p class="relative z-10 text-indigo-300/50 text-sm">© {{ date('Y') }} JOBZ IN CANADA. Made with care for the Canadian workforce.</p>
        </div>

        <!-- Right Login Panel -->
        <div class="w-full lg:w-1/2 flex flex-col relative">
            
            <!-- Navbar Action Area -->
            <div class="absolute top-0 right-0 p-6 flex justify-between w-full lg:justify-end items-center z-20">
                <!-- Brand for mobile -->
                <a href="/" class="lg:hidden inline-flex items-center gap-2">
                    <div class="w-8 h-8 bg-[#1650e1] rounded-lg flex items-center justify-center text-white font-bold">J</div>
                    <span class="font-black text-gray-900 dark:text-white">JOBZ <span class="text-[#1650e1]">CAN</span></span>
                </a>
                
                <!-- Theme toggle -->
                <button @click="dark = !dark" type="button" title="Toggle Theme" class="p-2 rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors">
                    <span x-show="!dark">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>
            </div>

            <!-- Login Form Area -->
            <div class="flex-1 flex items-center justify-center p-6 sm:p-12 mt-12 lg:mt-0">
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center sm:text-left">
                        <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">Welcome Back</h1>
                        <p class="text-gray-500 dark:text-gray-400">Sign in to manage your profile and listing updates</p>
                    </div>

                    <!-- Session Alert -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Social Signin Component -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button type="button" id="google-login-seeker-btn" onclick="handleGoogleLogin('job_seeker')" class="flex w-full items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 font-semibold text-gray-700 dark:text-gray-200 transition-colors shadow-sm text-sm">
                            <svg viewBox="0 0 24 24" width="18" height="18" xmlns="http://www.w3.org/2000/svg">
                                <g transform="matrix(1, 0, 0, 1, 0, 0)">
                                    <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.38C21.68,11.96 21.56,11.5 21.35,11.1z" fill="#4285F4" />
                                    <path d="M12,20.68c2.61,0 4.8,-0.87 6.4,-2.34l-3.3,-2.58c-0.92,0.62 -2.1,0.99 -3.1,0.99c-2.39,0 -4.41,-1.61 -5.13,-3.78H3.39v2.66C4.99,18.82 8.26,20.68 12,20.68z" fill="#34A853" />
                                    <path d="M6.87,12.97c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7c0,-0.59 0.11,-1.16 0.29,-1.7V6.91H3.39C2.77,8.15 2.42,9.54 2.42,11c0,1.46 0.35,2.85 0.97,4.09l3.48,-2.12z" fill="#FBBC05" />
                                    <path d="M12,5.65c1.42,0 2.7,0.49 3.7,1.44l2.77,-2.77C16.8,2.78 14.61,1.91 12,1.91c-3.74,0 -7.01,1.86 -8.61,4.72l3.48,2.66c0.72,-2.17 2.74,-3.78 5.13,-3.78z" fill="#EA4335" />
                                </g>
                            </svg>
                            Seeker
                        </button>
                        <button type="button" id="google-login-employer-btn" onclick="handleGoogleLogin('employer')" class="flex w-full items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 font-semibold text-gray-700 dark:text-gray-200 transition-colors shadow-sm text-sm">
                            <svg viewBox="0 0 24 24" width="18" height="18" xmlns="http://www.w3.org/2000/svg">
                                <g transform="matrix(1, 0, 0, 1, 0, 0)">
                                    <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.38C21.68,11.96 21.56,11.5 21.35,11.1z" fill="#4285F4" />
                                    <path d="M12,20.68c2.61,0 4.8,-0.87 6.4,-2.34l-3.3,-2.58c-0.92,0.62 -2.1,0.99 -3.1,0.99c-2.39,0 -4.41,-1.61 -5.13,-3.78H3.39v2.66C4.99,18.82 8.26,20.68 12,20.68z" fill="#34A853" />
                                    <path d="M6.87,12.97c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7c0,-0.59 0.11,-1.16 0.29,-1.7V6.91H3.39C2.77,8.15 2.42,9.54 2.42,11c0,1.46 0.35,2.85 0.97,4.09l3.48,-2.12z" fill="#FBBC05" />
                                    <path d="M12,5.65c1.42,0 2.7,0.49 3.7,1.44l2.77,-2.77C16.8,2.78 14.61,1.91 12,1.91c-3.74,0 -7.01,1.86 -8.61,4.72l3.48,2.66c0.72,-2.17 2.74,-3.78 5.13,-3.78z" fill="#EA4335" />
                                </g>
                            </svg>
                            Employer
                        </button>
                    </div>

                    <div class="relative flex items-center py-2 mb-6">
                        <div class="flex-grow border-t border-gray-200 dark:border-slate-700"></div>
                        <span class="flex-shrink-0 mx-4 text-xs font-medium text-gray-400 uppercase tracking-widest">Or signin with email</span>
                        <div class="flex-grow border-t border-gray-200 dark:border-slate-700"></div>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full border px-4 py-2.5 text-sm focus:ring-1 outline-none form-input-premium" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-[#1650e1] hover:underline">
                                        {{ __('Forgot password?') }}
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full border px-4 py-2.5 text-sm focus:ring-1 outline-none form-input-premium" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="pt-1">
                            <label for="remember_me" class="flex items-start gap-3 cursor-pointer group">
                                <div class="relative flex items-center justify-center mt-0.5">
                                    <input id="remember_me" type="checkbox" name="remember" class="peer appearance-none w-5 h-5 rounded border-2 border-gray-300 dark:border-slate-600 dark:bg-slate-800 checked:bg-[#1650e1] checked:border-[#1650e1] focus:ring-2 focus:ring-[#1650e1]/20 transition-all cursor-pointer">
                                    <div class="absolute text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Remember my session</span>
                            </label>
                        </div>

                        <!-- Submit Action Button -->
                        <button type="submit" class="w-full bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-[#1650e1]/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                            {{ __('Sign In') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer / Registration redirect -->
            <div class="p-6 text-center border-t border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-[#1650e1] font-bold hover:underline">Register today</a>
                </p>
            </div>
        </div>

    </div>

    <script>
        async function handleGoogleLogin(role = 'job_seeker') {
            const btnId = role === 'employer' ? 'google-login-employer-btn' : 'google-login-seeker-btn';
            const btn = document.getElementById(btnId);
            const originalText = btn ? btn.innerHTML : 'Google';

            try {
                if (!window.firebaseAuth) {
                    console.error("Firebase auth not initialized");
                    return;
                }
                
                const { auth, signInWithPopup, googleProvider } = window.firebaseAuth;
                
                // Show a loading state (optional)
                if (btn) btn.innerHTML = 'Logging in...';

                const result = await signInWithPopup(auth, googleProvider);
                const idToken = await result.user.getIdToken();

                // Send the ID token to the backend
                const response = await fetch('{{ route('firebase.callback') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ idToken, role })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.location.href = data.redirect;
                } else {
                    console.error("Backend auth failed:", data.error);
                    alert("Authentication failed: " + (data.error || "Unknown error"));
                    if (btn) btn.innerHTML = originalText;
                }

            } catch (error) {
                console.error("Firebase Login Error:", error);
                alert("Login was cancelled or failed.");
                if (btn) btn.innerHTML = originalText;
            }
        }
    </script>
</body>
</html>
