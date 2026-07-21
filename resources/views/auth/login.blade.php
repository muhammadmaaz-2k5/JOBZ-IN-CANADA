<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - JOBZ IN CANADA</title>
    <!-- Fonts -->
    
    
    
    <!-- Scripts & Styles -->
    
</head>
<body>

    <div>
        
        <!-- Left Brand Panel (Hidden on mobile) -->
        <div>
            <!-- Visual Grid Overlay -->
            <div></div>
            <div></div>

            <!-- Logo -->
            <a href="/">
                <span>J</span>
                <span>JOBZ IN <span>CANADA</span></span>
            </a>

            <!-- Graphic / Mock Job Listing Card -->
            <div>
                <div>
                    <h2>Connect with top employers across Canada.</h2>
                    <p>
                        Access thousands of verified job listings, build your professional profile, and apply to high-paying positions instantly.
                    </p>
                </div>

                <!-- Floating Interactive Card -->
                <div>
                    <div>
                        <div>
                            <span>
                                Verified Employer
                            </span>
                            <h3>Senior Full-Stack Architect</h3>
                            <p>TechCorp Canada · Toronto, ON</p>
                        </div>
                        <span>$120k - $145k CAD</span>
                    </div>
                    
                    <div>
                        <span>Full-Time</span>
                        <span>Hybrid</span>
                        <span>Benefits</span>
                    </div>

                    <div>
                        <div>
                            <span>JD</span>
                            <span>MA</span>
                            <span>KL</span>
                        </div>
                        <span>12 candidates applied recently</span>
                    </div>
                </div>
            </div>

            <!-- Footer info -->
            <p>© {{ date('Y') }} JOBZ IN CANADA. Made with care for the Canadian workforce.</p>
        </div>

        <!-- Right Login Panel -->
        <div>
            
            <!-- Navbar Action Area -->
            <div>
                <!-- Brand for mobile -->
                <a href="/">
                    <span>J</span>
                    <span>JOBZ <span>CAN</span></span>
                </a>
                
                <!-- Theme toggle -->
                <button @click="dark = !dark" type="button" title="Toggle Theme">
                    <span x-show="!dark">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </span>
                </button>
            </div>

            <!-- Login Form Area -->
            <div>
                <div>
                    <h1>Welcome Back</h1>
                    <p>Sign in to manage your profile and listing updates</p>
                </div>

                <!-- Session Alert -->
                <x-auth-session-status :status="session('status')" />

                <!-- Social Signin Component -->
                <div>
                    <a href="#">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.38C21.68,11.96 21.56,11.5 21.35,11.1z" fill="#4285F4" />
                                <path d="M12,20.68c2.61,0 4.8,-0.87 6.4,-2.34l-3.3,-2.58c-0.92,0.62 -2.1,0.99 -3.1,0.99c-2.39,0 -4.41,-1.61 -5.13,-3.78H3.39v2.66C4.99,18.82 8.26,20.68 12,20.68z" fill="#34A853" />
                                <path d="M6.87,12.97c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7c0,-0.59 0.11,-1.16 0.29,-1.7V6.91H3.39C2.77,8.15 2.42,9.54 2.42,11c0,1.46 0.35,2.85 0.97,4.09l3.48,-2.12z" fill="#FBBC05" />
                                <path d="M12,5.65c1.42,0 2.7,0.49 3.7,1.44l2.77,-2.77C16.8,2.78 14.61,1.91 12,1.91c-3.74,0 -7.01,1.86 -8.61,4.72l3.48,2.66c0.72,-2.17 2.74,-3.78 5.13,-3.78z" fill="#EA4335" />
                            </g>
                        </svg>
                        Google
                    </a>
                    <a href="#">
                        <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                        LinkedIn
                    </a>
                </div>

                <div>
                    <div>
                        <div></div>
                    </div>
                    <span>Or signin with email</span>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>
                        <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div>
                        <label for="remember_me">
                            <div>
                                <input id="remember_me" type="checkbox" name="remember">
                                <div>
                                    <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <span>Remember my session</span>
                        </label>
                    </div>

                    <!-- Submit Action Button -->
                    <button type="submit">
                        {{ __('Sign In') }}
                    </button>
                </form>
            </div>

            <!-- Footer / Registration redirect -->
            <div>
                Don't have an account? 
                <a href="{{ route('register') }}">Register today</a>
            </div>
        </div>

    </div>

</body>
</html>
