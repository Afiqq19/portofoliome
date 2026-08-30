<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - {{ config('app.name', 'MSyafiq Portofolio') }}</title>
    <link rel="icon" href="{{ asset('iconn.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        heading: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>
<body class="bg-[#060609] text-slate-100 antialiased font-sans flex items-center justify-center min-h-screen relative p-4 overflow-hidden selection:bg-indigo-500/30 selection:text-indigo-200" x-data="{ showPassword: false }">

    <!-- Ambient Glowing Orbs Background -->
    <div class="ambient-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <!-- Cyber Matrix Grid Overlay -->
    <div class="cyber-grid"></div>

    <!-- Back to home -->
    <a href="{{ route('home') }}" class="absolute top-6 left-6 text-slate-400 hover:text-white flex items-center gap-2 font-medium transition-colors text-sm z-20">
        <span class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 shadow-sm flex items-center justify-center hover:bg-indigo-600 hover:border-transparent transition-all">
            <i class='bx bx-arrow-back text-lg'></i>
        </span>
        <span class="hidden sm:inline font-semibold">Kembali ke Portofolio</span>
    </a>

    <div class="w-full max-w-md my-8 relative z-10">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-pink-500 text-white font-black text-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-indigo-500/25 p-[2px]">
                <div class="w-full h-full bg-[#060609] rounded-[14px] flex items-center justify-center">
                    <i class='bx bx-lock-alt text-3xl text-gradient'></i>
                </div>
            </div>
            <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-100 mb-1">Admin Portal</h1>
            <p class="text-slate-400 text-sm">Masuk untuk mengelola seluruh data portofolio</p>
        </div>

        <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-2xl bg-[#0c0c14]/85">
            
            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-950/40 border border-rose-500/30 text-rose-300 text-xs">
                    <div class="font-bold mb-1 flex items-center gap-1.5 text-rose-400">
                        <i class='bx bx-error-circle text-base'></i>
                        <span>Login Gagal:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div class="form-group mb-0">
                    <label class="form-label text-xs">Alamat Email Admin</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control rounded-xl pl-10 text-sm" required autofocus placeholder="admin@example.com">
                        <i class='bx bx-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base'></i>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label text-xs">Kata Sandi (Password)</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" class="form-control rounded-xl pl-10 pr-10 text-sm" required placeholder="••••••••">
                        <i class='bx bx-key absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base'></i>
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-200">
                            <i class="bx text-lg" :class="showPassword ? 'bx-hide' : 'bx-show'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded text-indigo-600 accent-indigo-600">
                        <span class="text-xs font-medium text-slate-400">Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-shimmer w-full py-4 text-sm font-bold shadow-xl shadow-indigo-500/25 flex items-center justify-center gap-2 rounded-xl mt-2">
                    <span>Masuk ke Dashboard</span>
                    <i class='bx bx-log-in text-lg'></i>
                </button>
            </form>
        </div>
        
        <p class="text-center text-xs text-slate-500 mt-6">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>

</body>
</html>
