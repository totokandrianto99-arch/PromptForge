<x-guest-layout>
    <h2 class="text-2xl font-bold text-slate-800 mb-1">Welcome back</h2>
    <p class="text-sm text-slate-500 mb-6">Sign in to your PromptForge account</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email"
                value="{{ old('email', 'totokandrianto99@gmail.com') }}"
                required autofocus autocomplete="username"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password"
                value="password"
                required autocomplete="current-password"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span class="text-sm text-slate-600">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium transition">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-sm hover:shadow-indigo-200 hover:shadow-md">
            Sign In
        </button>

        <p class="text-center text-sm text-slate-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Sign up</a>
        </p>
    </form>
</x-guest-layout>
