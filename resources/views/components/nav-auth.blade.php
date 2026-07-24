@auth
    <div class="hidden sm:flex items-center gap-2 mr-2">
        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#1650e1] to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
            {{ strtoupper(substr(Auth::user()->first_name ?? 'U', 0, 1)) }}
        </div>
        <span class="font-bold text-gray-900 dark:text-white text-sm hidden md:inline-block">{{ Auth::user()->first_name ?? 'User' }}</span>
    </div>
    <a href="{{ route('dashboard') }}" class="nav-cta">Dashboard</a>
    <form method="POST" action="{{ route('logout') }}" class="inline-block ml-2">
        @csrf
        <button type="submit" class="text-sm font-bold text-gray-500 hover:text-red-600 transition-colors">
            Logout
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="nav-post">Sign In</a>
    <a href="{{ route('register') }}" class="nav-cta">Get Started</a>
@endauth
