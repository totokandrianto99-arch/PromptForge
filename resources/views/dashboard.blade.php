@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>PromptForge AI - Dashboard</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
        extend: {
            fontFamily: { sans: ['Inter', 'sans-serif'] },
            animation: { 'fade-in': 'fadeIn 0.4s ease-out', 'slide-up': 'slideUp 0.4s ease-out' }
        }
    }
}
</script>
<style>
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; }
</style>
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
            <a href="{{ route('profile.edit') }}" class="hidden sm:flex items-center gap-2 text-sm text-slate-600 hover:text-indigo-600 transition font-medium">
                <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                {{ Auth::user()->name }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-medium text-slate-500 hover:text-red-500 bg-slate-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10 sm:py-14" x-data="app()">

    <!-- Hero -->
    <div class="text-center mb-10 animate-fade-in">
        <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-600 text-xs font-semibold px-3 py-1.5 rounded-full mb-4 border border-indigo-100">
            ✨ AI-Powered Prompt Generator
        </div>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mb-3 leading-tight tracking-tight">
            Generate Perfect<br class="hidden sm:block">
            <span class="text-indigo-600">AI Prompts</span> Instantly
        </h1>
        <p class="text-slate-500 text-base sm:text-lg max-w-lg mx-auto">
            Describe your idea, pick a style, and let AI craft the perfect prompt for you.
        </p>
    </div>

    <!-- Generator Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm shadow-slate-100 p-6 sm:p-8 max-w-3xl mx-auto animate-slide-up">
        <div class="space-y-5">

            <!-- Input -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">What do you want to create?</label>
                <input
                    x-model="topic"
                    @keydown.enter="generate()"
                    placeholder="e.g., build a responsive e-commerce website for a fashion brand..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            </div>

            <!-- Style Select -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Prompt Style</label>
                <select x-model="style"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <option value="creative">✨ Creative</option>
                    <option value="professional">💼 Professional</option>
                    <option value="technical">⚙️ Technical</option>
                    <option value="futuristic">🚀 Futuristic</option>
                    <option value="marketing">📈 Marketing</option>
                </select>
            </div>

            <!-- Generate Button -->
            <button
                @click="generate()"
                :disabled="loading"
                class="w-full py-3 px-6 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-300 text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-sm hover:shadow-indigo-200 hover:shadow-md flex items-center justify-center gap-2">
                <span x-show="!loading">⚡ Generate AI Prompt</span>
                <span x-show="loading" class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    AI is thinking...
                </span>
            </button>

            <!-- Result -->
            <div x-show="result" x-transition class="pt-1">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Generated Prompt</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5 min-h-[100px]">
                    <p x-text="result" class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap break-words"></p>
                </div>
                <button
                    @click="copyPrompt($event)"
                    class="mt-3 w-full py-2.5 px-4 border border-slate-200 hover:border-emerald-300 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 font-medium text-sm rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                    <span x-text="copied ? '✅ Copied to clipboard!' : '📋 Copy to Clipboard'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- History Section -->
    <div class="mt-14 sm:mt-16" x-show="history.length > 0">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-800">Recent Prompts</h2>
            <span class="text-xs text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">{{ count($history ?? []) }} prompts</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($history as $index => $item)
            <div class="bg-white border border-slate-200 rounded-xl p-4 hover:border-indigo-200 hover:shadow-sm transition-all duration-200 group">
                <p class="text-sm text-slate-600 leading-relaxed line-clamp-4 mb-3">{{ Str::limit($item->content, 150) }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-400 font-mono">#{{ $loop->iteration }}</span>
                    <button
                        @click="copyText($event, {{ json_encode($item->content) }})"
                        class="text-xs font-medium text-slate-500 hover:text-indigo-600 bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 px-2.5 py-1 rounded-lg transition-all duration-200">
                        📋 Copy
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16 text-slate-400">
                <p class="text-4xl mb-3">✨</p>
                <p class="font-medium">No prompts yet. Generate your first one!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="mt-16 border-t border-slate-200 bg-white py-6 text-center">
    <p class="text-sm text-slate-400">© {{ date('Y') }} PromptForge AI</p>
    <p class="text-xs text-slate-300 mt-1">Totok Andrianto · XI PPLG B · Powered by Laravel + AI</p>
</footer>

<script>
function app() {
    return {
        topic: '',
        style: 'creative',
        result: '',
        loading: false,
        copied: false,
        history: @json($history ?? []),

        generate() {
            if (!this.topic.trim()) return;
            this.loading = true;
            this.result = '';
            this.copied = false;

            fetch('/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ topic: this.topic, style: this.style })
            })
            .then(res => res.json())
            .then(data => {
                this.loading = false;
                this.typeText(data.prompt);
            })
            .catch(() => {
                this.loading = false;
                this.result = 'Error generating prompt. Please try again.';
            });
        },

        typeText(text) {
            let i = 0;
            this.result = '';
            const interval = setInterval(() => {
                if (i < text.length) this.result += text.charAt(i++);
                else clearInterval(interval);
            }, 18);
        },

        copyToClipboard(text, onSuccess) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(onSuccess).catch(() => this.fallbackCopy(text, onSuccess));
            } else {
                this.fallbackCopy(text, onSuccess);
            }
        },

        fallbackCopy(text, onSuccess) {
            const el = document.createElement('textarea');
            el.value = text;
            el.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0';
            document.body.appendChild(el);
            el.focus(); el.select();
            try { document.execCommand('copy'); onSuccess(); } catch(e) {}
            document.body.removeChild(el);
        },

        copyPrompt() {
            this.copyToClipboard(this.result, () => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            });
        },

        copyText(event, text) {
            const btn = event.currentTarget;
            const orig = btn.textContent;
            this.copyToClipboard(text, () => {
                btn.textContent = '✅ Copied!';
                setTimeout(() => btn.textContent = orig, 2000);
            });
        }
    }
}
</script>
</body>
</html>
