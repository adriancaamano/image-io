<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset(mix('css/app.css'), env('APP_SSL', false)) }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ asset(mix('js/app.js'), env('APP_SSL', false)) }}" defer></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
        
    </head>
    <body class="font-sans antialiased bg-gray-200 dark:bg-gray-900">
        <div class="flex flex-col flex-grow">
            <div class="py-6 px-4 sm:px-6 lg:px-8 z-10 sticky top-0 bg-gray-200 dark:bg-gray-900">
            </div>

            <div>
                <main class="py-6 px-4 sm:px-6 lg:px-8">
                    @livewire('upload-images')
                </main>
            </div>
        </div>
        
        @livewireScripts

        <script>
            (function() {
                window.onpageshow = function(event) {
                    if (event.persisted) {
                        window.location.reload();
                    }
                };
            })();
        </script>
    </body>
</html>
