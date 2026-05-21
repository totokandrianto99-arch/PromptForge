<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>PromptForge AI – AI Prompt Generator</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #fff; color: #1e293b; overflow-x: hidden; }
[x-cloak] { display: none !important; }

/* ── Gradient text ── */
.gradient-text {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}

/* ── Hero ambient glow ── */
.hero-bg {
    background:
        radial-gradient(ellipse 70% 40% at 50% 0%, rgba(99,102,241,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 40% 30% at 80% 20%, rgba(139,92,246,0.08) 0%, transparent 60%),
        #fff;
}

/* ── Noise texture overlay ── */
.noise::after {
    content:''; position:absolute; inset:0; pointer-events:none;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
    opacity: 0.4;
}

/* ── Scroll reveal ── */
.reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.65s cubic-bezier(.22,1,.36,1), transform 0.65s cubic-bezier(.22,1,.36,1); }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: 0.1s; }
.reveal-delay-2 { transition-delay: 0.2s; }
.reveal-delay-3 { transition-delay: 0.3s; }
.reveal-delay-4 { transition-delay: 0.4s; }
.reveal-delay-5 { transition-delay: 0.5s; }

/* ── Navbar scroll shrink ── */
.nav-scrolled { box-shadow: 0 1px 24px rgba(99,102,241,0.08); background: rgba(255,255,255,0.95) !important; }

/* ── Magnetic button ── */
.btn-magnetic { transition: transform 0.2s cubic-bezier(.22,1,.36,1), box-shadow 0.2s ease; display: inline-flex; align-items: center; justify-content: center; }
.btn-magnetic:hover { box-shadow: 0 8px 30px rgba(99,102,241,0.35); }

/* ── Spotlight card ── */
.spotlight-card {
    position: relative; overflow: hidden;
    transition: transform 0.3s cubic-bezier(.22,1,.36,1), box-shadow 0.3s ease, border-color 0.3s ease;
}
.spotlight-card::before {
    content: ''; position: absolute; inset: 0; opacity: 0;
    background: radial-gradient(400px circle at var(--mx,50%) var(--my,50%), rgba(99,102,241,0.07), transparent 60%);
    transition: opacity 0.3s ease; pointer-events: none; z-index: 0;
}
.spotlight-card:hover::before { opacity: 1; }
.spotlight-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(99,102,241,0.1); border-color: rgba(99,102,241,0.25) !important; }
.spotlight-card > * { position: relative; z-index: 1; }

/* ── Float animation ── */
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
.animate-float { animation: float 5s ease-in-out infinite; }

/* ── Typing cursor ── */
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }
.cursor::after { content:'|'; animation: blink 1s step-end infinite; margin-left:1px; color:#6366f1; }

/* ── Shimmer on CTA ── */
@keyframes shimmer { 0%{background-position:-200% center} 100%{background-position:200% center} }
.btn-shimmer {
    background: linear-gradient(90deg, #6366f1 0%, #818cf8 40%, #6366f1 60%, #4f46e5 100%);
    background-size: 200% auto;
    transition: background-position 0.4s ease, box-shadow 0.3s ease, transform 0.2s ease;
}
.btn-shimmer:hover { background-position: right center; box-shadow: 0 8px 32px rgba(99,102,241,0.4); transform: translateY(-2px); }

/* ── Underline link ── */
.link-underline { position:relative; }
.link-underline::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:#6366f1; transition:width 0.25s ease; border-radius:2px; }
.link-underline:hover::after { width:100%; }

/* ── Badge pulse ── */
@keyframes badgePulse { 0%,100%{box-shadow:0 0 0 0 rgba(99,102,241,0.3)} 50%{box-shadow:0 0 0 6px rgba(99,102,241,0)} }
.badge-pulse { animation: badgePulse 2.5s ease-in-out infinite; }

/* ── Grid line bg ── */
.grid-bg {
    background-image: linear-gradient(rgba(99,102,241,0.04) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(99,102,241,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
}
</style>
</head>

<body x-data="demo()">

<!-- ─── NAVBAR ─── -->
<nav id="navbar" class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 transition-all duration-300">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-3.5 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2.5 group">
            <img src="{{ asset('images/logo.png') }}" alt="PromptForge AI" class="h-8 w-auto transition-transform duration-300 group-hover:scale-110">
            <span class="font-bold text-slate-900 text-base tracking-tight">PromptForge <span class="gradient-text">AI</span></span>
        </a>
        <div class="flex items-center gap-1 sm:gap-2">
            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors duration-200 px-3 py-1.5 rounded-lg hover:bg-indigo-50 link-underline">Login</a>
            <a href="{{ route('register') }}" class="btn-magnetic btn-shimmer text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm gap-2">
                Get Started →
            </a>
        </div>
    </div>
</nav>

<!-- ─── HERO ─── -->
<section class="hero-bg noise relative pt-28 pb-20 sm:pt-40 sm:pb-32 px-5 text-center overflow-hidden">
    <!-- Decorative blobs -->
    <div class="absolute top-20 left-1/4 w-72 h-72 bg-indigo-100/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-32 right-1/4 w-56 h-56 bg-purple-100/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-3xl mx-auto relative">
        <div class="reveal visible">
            <span class="badge-pulse inline-flex items-center gap-2 bg-indigo-50 border border-indigo-200 text-indigo-600 text-xs font-semibold px-3.5 py-1.5 rounded-full mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                AI-Powered Prompt Generator
            </span>
        </div>

        <h1 class="reveal visible reveal-delay-1 text-4xl sm:text-6xl font-black text-slate-900 leading-[1.1] tracking-tight mb-5">
            Craft Perfect<br>
            <span class="gradient-text">AI Prompts</span><br>in Seconds
        </h1>

        <p class="reveal visible reveal-delay-2 text-slate-500 text-base sm:text-lg max-w-xl mx-auto mb-8 leading-relaxed">
            Turn rough ideas into powerful, professional AI prompts. Just describe what you need — PromptForge does the rest.
        </p>

        <div class="reveal visible reveal-delay-3 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('register') }}" class="btn-magnetic btn-shimmer text-white font-semibold px-7 py-3.5 rounded-xl gap-2 text-sm">
                🚀 Start for Free
            </a>
            <a href="#demo" class="btn-magnetic inline-flex items-center gap-2 bg-white border border-slate-200 hover:border-indigo-300 text-slate-700 hover:text-indigo-600 font-semibold px-7 py-3.5 rounded-xl text-sm transition-all duration-200 hover:bg-indigo-50">
                ⚡ Try Demo
            </a>
        </div>


    </div>

    <!-- Floating terminal mockup -->
    <div class="reveal visible reveal-delay-5 mt-16 max-w-2xl mx-auto animate-float">
        <div class="bg-slate-900 rounded-2xl p-5 text-left shadow-2xl border border-slate-700/60 ring-1 ring-white/5">
            <div class="flex items-center gap-1.5 mb-4">
                <span class="w-3 h-3 rounded-full bg-red-400/80"></span>
                <span class="w-3 h-3 rounded-full bg-yellow-400/80"></span>
                <span class="w-3 h-3 rounded-full bg-green-400/80"></span>
                <span class="ml-3 text-xs text-slate-500 font-mono">promptforge.ai — output</span>
            </div>
            <p class="text-[11px] text-slate-500 font-mono mb-2">// ✨ Generated prompt</p>
            <p class="text-sm text-emerald-400 font-mono leading-relaxed">
                "You are a senior UX designer. Create a detailed wireframe for a modern SaaS dashboard that prioritizes data visualization and seamless navigation. Include color palette suggestions and component hierarchy..."
            </p>
            <div class="mt-3 flex items-center gap-2">
                <span class="text-[10px] font-mono text-indigo-400 bg-indigo-950/60 px-2 py-0.5 rounded">style: professional</span>
                <span class="text-[10px] font-mono text-emerald-400 bg-emerald-950/60 px-2 py-0.5 rounded">✓ generated in 1.2s</span>
            </div>
        </div>
    </div>
</section>

<!-- ─── FEATURES ─── -->
<section class="py-24 px-5 grid-bg">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14 reveal">
            <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-3">Features</p>
            <h2 class="text-2xl sm:text-4xl font-bold text-slate-900 mb-3">Everything you need</h2>
            <p class="text-slate-500 text-sm sm:text-base max-w-md mx-auto">Simple, powerful, and built for everyone — from beginners to pros.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach([
                ['⚡', 'Instant Generation', 'Get high-quality prompts in seconds powered by advanced AI.', 'reveal-delay-1'],
                ['🎨', 'Multiple Styles', 'Creative, Professional, Technical, Futuristic, and Marketing.', 'reveal-delay-2'],
                ['📋', 'One-Click Copy', 'Copy your generated prompt to clipboard instantly.', 'reveal-delay-3'],
                ['🕐', 'Prompt History', 'All prompts saved automatically — never lose a great idea.', 'reveal-delay-1'],
                ['🌐', 'Multi-Language', 'AI detects your language and responds accordingly.', 'reveal-delay-2'],
                ['🔒', 'Secure & Private', 'Your prompts are private and tied to your account only.', 'reveal-delay-3'],
            ] as [$icon, $title, $desc, $delay])
            <div class="spotlight-card reveal {{ $delay }} bg-white border border-slate-200 rounded-2xl p-6"
                 onmousemove="this.style.setProperty('--mx', event.offsetX+'px'); this.style.setProperty('--my', event.offsetY+'px')">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-xl mb-4">{{ $icon }}</div>
                <h3 class="font-semibold text-slate-800 mb-1.5 text-sm">{{ $title }}</h3>
                <p class="text-slate-500 text-xs leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ─── HOW IT WORKS ─── -->
<section class="py-24 px-5 bg-slate-50">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-14 reveal">
            <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-3">How it works</p>
            <h2 class="text-2xl sm:text-4xl font-bold text-slate-900">Three steps to a perfect prompt</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach([
                ['01', 'Describe your idea', 'Type a short description of what you want to create or achieve.'],
                ['02', 'Pick a style', 'Choose from 5 prompt styles tailored to your use case.'],
                ['03', 'Generate & copy', 'Get your AI-crafted prompt instantly and copy it with one click.'],
            ] as [$num, $title, $desc])
            <div class="reveal spotlight-card bg-white border border-slate-200 rounded-2xl p-6 text-center"
                 onmousemove="this.style.setProperty('--mx', event.offsetX+'px'); this.style.setProperty('--my', event.offsetY+'px')">
                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white text-sm font-bold flex items-center justify-center mx-auto mb-4">{{ $num }}</div>
                <h3 class="font-semibold text-slate-800 mb-2 text-sm">{{ $title }}</h3>
                <p class="text-slate-500 text-xs leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ─── DEMO ─── -->
<section id="demo" class="py-24 px-5">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-10 reveal">
            <span class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-semibold px-3.5 py-1.5 rounded-full mb-4">
                🧪 Free Trial — 1 prompt without login
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">Try it yourself</h2>
            <p class="text-slate-500 text-sm">No account needed for one free try.</p>
        </div>

        <!-- Login alert -->
        <div x-show="showAlert" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mb-5 bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex-1">
                <p class="font-semibold text-indigo-800 text-sm mb-0.5">🔐 You've used your free trial!</p>
                <p class="text-indigo-600 text-xs">Create a free account for unlimited prompts, history, and more.</p>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('register') }}" class="btn-shimmer text-white text-xs font-semibold px-4 py-2 rounded-xl transition">Sign Up Free</a>
                <a href="{{ route('login') }}" class="text-xs font-semibold bg-white hover:bg-slate-50 text-indigo-600 border border-indigo-200 px-4 py-2 rounded-xl transition">Login</a>
            </div>
        </div>

        <!-- Demo card -->
        <div class="spotlight-card reveal bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8 space-y-5"
             onmousemove="this.style.setProperty('--mx', event.offsetX+'px'); this.style.setProperty('--my', event.offsetY+'px')">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">What do you want to create?</label>
                <input x-model="topic" :disabled="used"
                    placeholder="e.g., a landing page for a coffee shop..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed hover:border-indigo-300">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Prompt Style</label>
                <select x-model="style" :disabled="used"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed hover:border-indigo-300">
                    <option value="creative">✨ Creative</option>
                    <option value="professional">💼 Professional</option>
                    <option value="technical">⚙️ Technical</option>
                    <option value="futuristic">🚀 Futuristic</option>
                    <option value="marketing">📈 Marketing</option>
                </select>
            </div>

            <button @click="generate()" :disabled="loading || used"
                class="btn-shimmer w-full py-3 px-6 disabled:!bg-slate-200 disabled:!shadow-none disabled:text-slate-400 disabled:cursor-not-allowed text-white font-semibold text-sm rounded-xl flex items-center justify-center gap-2">
                <span x-show="!loading">⚡ Generate Prompt</span>
                <span x-show="loading" class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    AI is thinking...
                </span>
            </button>

            <div x-show="error" x-cloak class="bg-red-50 border border-red-200 rounded-xl p-3">
                <p x-text="error" class="text-red-600 text-xs"></p>
            </div>

            <div x-show="result" x-cloak
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Generated Prompt</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 min-h-[90px]">
                    <p x-text="result" :class="typing ? 'cursor' : ''" class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap break-words"></p>
                </div>
                <button @click="copyResult($event)"
                    class="mt-3 w-full py-2.5 border border-slate-200 hover:border-emerald-300 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 font-medium text-sm rounded-xl transition-all duration-200 flex items-center justify-center gap-2 group">
                    <span class="group-hover:scale-110 transition-transform duration-200">📋</span> Copy to Clipboard
                </button>
                <div class="mt-4 bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100 rounded-xl p-4 text-center">
                    <p class="text-sm font-semibold text-slate-800 mb-1">Want unlimited prompts + history?</p>
                    <p class="text-xs text-slate-500 mb-3">Sign up free — no credit card required.</p>
                    <a href="{{ route('register') }}" class="btn-shimmer inline-flex items-center gap-1.5 text-white text-xs font-semibold px-5 py-2.5 rounded-xl">
                        🚀 Create Free Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ─── CTA ─── -->
<section class="py-24 px-5 bg-slate-900 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-indigo-600/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-2xl mx-auto text-center relative reveal">
        <h2 class="text-2xl sm:text-4xl font-black text-white mb-4 leading-tight">
            Ready to forge better prompts?
        </h2>
        <p class="text-slate-400 text-sm sm:text-base mb-8">Join hundreds of users generating professional AI prompts in seconds.</p>
        <a href="{{ route('register') }}" class="btn-magnetic btn-shimmer text-white font-semibold px-8 py-4 rounded-xl text-sm gap-2">
            Get Started — It's Free ✨
        </a>
    </div>
</section>

<!-- ─── FOOTER ─── -->
<footer class="bg-slate-950 py-8 px-5 text-center border-t border-slate-800">
    <div class="flex items-center justify-center gap-2 mb-2">
        <img src="{{ asset('images/logo.png') }}" alt="PromptForge AI" class="h-6 w-auto opacity-60 hover:opacity-100 transition-opacity duration-200">
        <span class="text-slate-400 text-sm font-medium">PromptForge <span class="gradient-text font-semibold">AI</span></span>
    </div>
    <p class="text-slate-600 text-xs">© {{ date('Y') }} PromptForge AI · Totok Andrianto · XI PPLG B</p>
</footer>

<script>
/* ── Scroll reveal ── */
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

/* ── Navbar shrink on scroll ── */
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('nav-scrolled', window.scrollY > 20);
});

/* ── Alpine demo component ── */
function demo() {
    return {
        topic: '',
        style: 'creative',
        result: '',
        loading: false,
        error: '',
        typing: false,
        used: {{ session('guest_used') ? 'true' : 'false' }},
        showAlert: {{ session('guest_used') ? 'true' : 'false' }},

        generate() {
            if (!this.topic.trim() || this.used) return;
            this.loading = true;
            this.result = '';
            this.error = '';

            fetch('/generate-guest', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ topic: this.topic, style: this.style })
            })
            .then(r => r.json())
            .then(data => {
                this.loading = false;
                if (data.error) { this.error = data.error; return; }
                this.used = true;
                this.showAlert = true;
                this.typeText(data.prompt);
            })
            .catch(() => {
                this.loading = false;
                this.error = 'Something went wrong. Please try again.';
            });
        },

        typeText(text) {
            let i = 0;
            this.result = '';
            this.typing = true;
            const iv = setInterval(() => {
                if (i < text.length) { this.result += text.charAt(i++); }
                else { clearInterval(iv); this.typing = false; }
            }, 14);
        },

        copyResult(e) {
            const btn = e.currentTarget;
            const orig = btn.innerHTML;
            const text = this.result;
            const done = () => {
                btn.innerHTML = '✅ Copied!';
                setTimeout(() => btn.innerHTML = orig, 2000);
            };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(done).catch(() => this.fallbackCopy(text, done));
            } else {
                this.fallbackCopy(text, done);
            }
        },

        fallbackCopy(text, done) {
            const el = document.createElement('textarea');
            el.value = text;
            el.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0';
            document.body.appendChild(el);
            el.focus();
            el.select();
            try { document.execCommand('copy'); done(); } catch(e) {}
            document.body.removeChild(el);
        }
    }
}
</script>
</body>
</html>
