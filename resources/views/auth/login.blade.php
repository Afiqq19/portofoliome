<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'PortfolioMe') }}</title>

    <!-- Vite -->
    @vite(['resources/css/app.css'])
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bg: {
                            primary: 'var(--bg-primary)',
                            secondary: 'var(--bg-secondary)',
                            tertiary: 'var(--bg-tertiary)',
                        },
                        accent: {
                            primary: 'var(--accent-primary)',
                            secondary: 'var(--accent-secondary)',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased text-white flex items-center justify-center min-h-screen relative overflow-hidden bg-bg-primary">

    <!-- Cinematic Background Glow -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-accent-primary/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Back to home -->
    <a href="{{ route('home') }}" class="absolute top-8 left-8 text-gray-400 hover:text-white flex items-center gap-2 group transition-colors z-20 font-medium">
        <span class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-accent-primary transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
        </span>
        Kembali ke Beranda
    </a>

    <div class="w-full max-w-lg px-6 animate-fade-in relative z-10">
        <div class="text-center mb-10">
            <div class="inline-block p-4 rounded-full bg-accent-primary/10 mb-6 border border-accent-primary/20">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-accent-primary"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h1 class="text-4xl font-black font-['Space_Grotesk'] text-gradient mb-3">Admin Portal</h1>
            <p class="text-gray-400 font-light text-lg">Silakan masuk untuk mengelola portofolio Anda</p>
        </div>

        <div class="glass-panel p-8 md:p-12 rounded-3xl border border-white/10 shadow-2xl relative">
            <div class="absolute inset-0 bg-gradient-to-br from-accent-primary/5 to-transparent rounded-3xl pointer-events-none"></div>
            
            @if($errors->any())
                <div class="alert alert-error mb-8 p-4 text-sm rounded-xl backdrop-blur-md flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-red-400"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <p class="text-red-400 font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="relative z-10">
                @csrf
                <div class="form-group mb-6">
                    <label class="form-label text-sm font-bold uppercase tracking-wider text-gray-400 mb-2 block">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control bg-bg-primary/50 border-white/10 focus:border-accent-primary rounded-xl px-5 py-4 w-full text-white" required autofocus placeholder="admin@example.com">
                </div>

                <div class="form-group mb-8">
                    <label class="form-label text-sm font-bold uppercase tracking-wider text-gray-400 mb-2 block">Password</label>
                    <input type="password" name="password" class="form-control bg-bg-primary/50 border-white/10 focus:border-accent-primary rounded-xl px-5 py-4 w-full text-white" required placeholder="••••••••">
                </div>

                <div class="flex items-center mb-8">
                    <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded bg-bg-tertiary border-white/10 text-accent-primary focus:ring-accent-primary focus:ring-offset-bg-primary">
                    <label for="remember" class="ml-3 text-sm text-gray-400 font-medium cursor-pointer">Ingat sesi saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-full rounded-xl py-4 text-lg font-bold flex items-center justify-center gap-2 group">
                    Masuk Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
