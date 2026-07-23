<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }" 
      :
      x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        
        

        <!-- Scripts -->
        
    </head>
    <body>
        <div>
            <!-- Decorative Ambient Glows -->
            <div></div>
            <div></div>

            <div>
                <!-- Logo -->
                <div>
                    <a href="/">
                        <div>
                            <span>J</span>
                        </div>
                        <span>
                            JOBZ IN <span>CANADA</span>
                        </span>
                    </a>
                </div>

                <!-- Custom Elevated Card container -->
                <x-card variant="elevated" padding="lg">
                    <!-- Absolute Theme Toggle inside Auth layout for user convenience -->
                    <div>
                        <button @click="dark = !dark" type="button" title="Toggle Theme">
                            <span x-show="!dark">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                            <span x-show="dark">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.5 12a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </span>
                        </button>
                    </div>

                    {{ $slot }}
                </x-card>
            </div>
        </div>
    </body>
</html>

