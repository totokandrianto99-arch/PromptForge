<x-app-layout>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile - PromptForge AI</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<style> body { font-family: 'Inter', sans-serif; } </style>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen antialiased">

<!-- Header -->
<header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
            <img src="{{ asset('images/logo.png') }}" alt="PromptForge AI" class="h-8 sm:h-9 w-auto">
            <span class="font-bold text-slate-800 text-base sm:text-lg">PromptForge AI</span>
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition">← Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-medium text-slate-500 hover:text-red-500 bg-slate-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Profile Settings</h1>
        <p class="text-sm text-slate-500 mt-1">Manage your account information and security.</p>
    </div>

    <div class="space-y-5">

        <!-- Profile Information -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account -->
        <div class="bg-white border border-red-100 rounded-2xl p-6 shadow-sm">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

<footer class="mt-16 border-t border-slate-200 bg-white py-6 text-center">
    <p class="text-sm text-slate-400">© {{ date('Y') }} PromptForge AI · Totok Andrianto · XI PPLG B</p>
</footer>

</body>
</html>
</x-app-layout>
