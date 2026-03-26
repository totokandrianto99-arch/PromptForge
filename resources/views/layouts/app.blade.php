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

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
        <img src="{{ asset('assets/logo.png') }}" 
            alt="PromptForge AI Logo"
            class="h-10 w-auto">

        <span class="text-lg font-bold text-gray-800">
            PromptForge AI
        </span>
    </a>
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="max-w-6xl mx-auto px-4 py-6 text-center">

        <p class="text-sm">
            © {{ date('Y') }} PromptForge AI. All rights reserved.<br>
            Totok Andrianto. XI PPLG B
        </p>

        <p class="text-xs text-gray-500 mt-2">
            Built with Laravel & AI
        </p>
    </div>
    </footer>
    </body>
</html>
