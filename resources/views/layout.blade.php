<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth antialiased">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>PromptForge AI - @yield('title', 'Dashboard')</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
tailwind.config = {
  darkMode: 'class',
  theme: {
    extend: {
      animation: {
        'glow': 'glow 2s ease-in-out infinite alternate',
        'bounce-slow': 'bounce 2s infinite',
        'particles-float': 'particlesFloat 6s ease-in-out infinite',
      },
      backdropBlur: { xs: '2px' },
    }
  }
}
</script>
<style>
@keyframes glow { 0% { box-shadow: 0 0 20px rgba(99,102,241,0.5); } 100% { box-shadow: 0 0 40px rgba(99,102,241,1); } }
@keyframes particlesFloat { 0%,100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(180deg); } }
</style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900/20 to-black min-h-screen text-gray-100 overflow-x-hidden relative">
<!-- Floating Particles -->
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
  <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-particles-float"></div>
  <div class="absolute top-1/2 left-10 w-60 h-60 bg-indigo-500/5 rounded-full blur-2xl animate-[bounce-slow]"></div>
  <div class="absolute -bottom-20 right-20 w-96 h-96 bg-pink-500/5 rounded-full blur-xl animate-pulse"></div>
</div>

<header class="bg-slate-900/95 backdrop-blur-xl shadow-2xl sticky top-0 z-50 border-b border-slate-700/50 transition-all duration-500 hover:shadow-glow">
    <div class="max-w-6xl mx-auto py-4 px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded-2xl bg-slate-800/50 hover:bg-slate-700/70 transition-all duration-300 group hover:scale-105 hover:shadow-glow">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="PromptForge AI" 
                     class="h-12 w-auto shadow-xl group-hover:shadow-2xl">
                <span class="text-2xl font-black bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400 bg-clip-text text-transparent tracking-tight drop-shadow-lg">
                    PromptForge
                </span>
            </a>
            
            <!-- Dark/Light Toggle (Bonus) -->
            <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-800/50 backdrop-blur-sm border border-slate-600/50">
                <span class="text-sm text-slate-400 font-medium px-3">Dark</span>
                <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 rounded-lg hover:bg-slate-700 transition-all duration-200 hover:scale-110">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="min-h-screen relative z-10">
    @yield('content')
</div>

<footer class="bg-gradient-to-r from-slate-900/95 to-gray-900/95 backdrop-blur-xl border-t border-slate-800/50 mt-24">
    <div class="max-w-6xl mx-auto px-6 py-12 text-center">
        <div class="flex flex-col lg:flex-row gap-8 items-center justify-center mb-8 p-6 rounded-3xl bg-slate-800/50 backdrop-blur-lg border border-slate-700/50 animate-glow">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto shadow-2xl animate-bounce-slow">
            <div>
                <p class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 mb-2">
                    © {{ date('Y') }} PromptForge AI
                </p>
                <p class="text-lg text-slate-400">Totok Andrianto · XI PPLG B</p>
            </div>
        </div>
        <p class="text-sm text-slate-500 animate-pulse tracking-wider">Built with ❤️ using Laravel + AI Magic ✨</p>
    </div>
</footer>

<script>
// Smooth scrolling & enhanced interactions
document.querySelectorAll('a[href^=\"#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
    });
});

// Entrance animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
});
document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
</script>
</body>
</html>
