<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PromptForge AI') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: { 'fade-in': 'fadeIn 0.5s ease-out' }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        body { font-family: 'Inter', sans-serif; }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 via-indigo-50/40 to-violet-50/30 min-h-screen antialiased">

    <!-- Background decoration -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-violet-100 rounded-full blur-3xl opacity-60"></div>
    </div>

    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 mb-8 group">
            <img src="{{ asset('images/logo.png') }}" alt="PromptForge AI" class="h-10 w-auto">
            <span class="text-xl font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                PromptForge AI
            </span>
        </a>

        <!-- Card -->
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/80 border border-slate-100 p-8 animate-fade-in">
            {{ $slot }}
        </div>

        <p class="mt-8 text-xs text-slate-400">© {{ date('Y') }} PromptForge AI · Totok Andrianto · XI PPLG B</p>
    </div>
</body>
</html>
