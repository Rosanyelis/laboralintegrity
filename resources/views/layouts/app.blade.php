<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com" rel="preconnect"/>
        <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <x-toast-container>
            <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </x-toast-container>
        
        <!-- Modal de confirmación global -->
        <x-confirmation-modal />
        
        @if(session('success'))
            <script>
                window.addEventListener('load', function() {
                    if (typeof showSuccess === 'function') {
                        showSuccess('{{ session('success') }}', 'Éxito');
                    }
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                window.addEventListener('load', function() {
                    if (typeof showError === 'function') {
                        showError('{{ session('error') }}', 'Error');
                    }
                });
            </script>
        @endif

        @if($errors->any())
            <script>
                window.addEventListener('load', function() {
                    if (typeof showError === 'function') {
                        showError('{{ $errors->first() }}', 'Error de validación');
                    }
                });
            </script>
        @endif
    </body>
</html>
