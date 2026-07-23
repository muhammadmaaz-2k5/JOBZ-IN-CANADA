<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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


                    {{ $slot }}
                </x-card>
            </div>
        </div>
    </body>
</html>

