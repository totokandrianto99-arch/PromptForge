<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>PromptForge AI</title>

<script src="https://cdn.tailwindcss.com"></script>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="bg-gray-950 text-gray-200">
<a href="{{ route('dashboard') }}" class="flex items-center gap-2">
    <img src="{{ asset('assets/logo.png') }}" 
         alt="PromptForge AI Logo"
         class="h-10 w-auto">

    <span class="text-lg font-bold text-gray-800">
        PromptForge AI
    </span>
</a>
<div class="min-h-screen p-6">

@yield('content')

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