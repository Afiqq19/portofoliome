<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $profile->bio ?? 'Portofolio Profesional & Modern - Web & Mobile Developer' }}">
    <title>@yield('title', ($profile->name ?? 'Mhd. Syafiq Syahmi') . ' - Portofolio')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}">
    
    <!-- Google Search Console Verification -->
    <meta name="google-site-verification" content="RKZ6qgPEUEpVfljmxyis7hAxPPHd589Vhe0A25k0PyI" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS (CDN Config for Utility Acceleration) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        heading: ['Space Grotesk', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        'primary-dark': '#060609',
                        'secondary-dark': '#0c0c14',
                        'tertiary-dark': '#131320',
                        accent: {
                            primary: '#6366f1',
                            secondary: '#a855f7',
                            cyan: '#06b6d4',
                            emerald: '#10b981',
                            pink: '#ec4899',
                            amber: '#f59e0b',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- AlpineJS for reactive interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>
<body class="bg-[#060609] text-slate-100 antialiased relative selection:bg-indigo-500/30 selection:text-indigo-200">

    <!-- Interactive Background Canvas (Constellation Particles) -->
    <canvas id="bg-canvas" class="fixed inset-0 pointer-events-none z-0 w-full h-full"></canvas>

    <!-- Ambient Glowing Orbs Background -->
    <div class="ambient-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
    </div>

    <!-- Cyber Matrix Grid Overlay -->
    <div class="cyber-grid"></div>

    <!-- Scroll Progress Bar -->
    <div class="fixed top-0 left-0 h-[3px] bg-gradient-to-r from-accent-primary via-accent-cyan to-accent-secondary z-[9999] transition-all duration-100 shadow-[0_0_15px_rgba(99,102,241,0.8)]" 
         x-data="{ scrollProgress: 0 }" 
         @scroll.window="scrollProgress = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100"
         :style="`width: ${scrollProgress}%`"></div>

    <!-- Navigation Header -->
    <nav class="navbar" x-data="{ mobileMenuOpen: false }">
        <div class="container max-w-7xl flex justify-between items-center relative gap-4">
            <a href="{{ route('home') }}" class="nav-brand group flex items-center gap-2.5 flex-shrink-0">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-[1.5px] shadow-[0_0_15px_rgba(99,102,241,0.5)] group-hover:shadow-[0_0_25px_rgba(99,102,241,0.8)] transition-all duration-300">
                    <div class="w-full h-full bg-[#060609] rounded-[10px] flex items-center justify-center font-black text-xs sm:text-sm tracking-wider">
                        <span class="text-gradient font-black">MSS</span>
                    </div>
                </div>
                <span class="text-base sm:text-lg font-bold font-['Space_Grotesk'] text-gradient tracking-tight group-hover:scale-[1.02] transition-transform whitespace-nowrap">
                    {{ $profile->name ?? 'MSyafiq' }}
                </span>
            </a>
            
            <!-- Desktop Navigation Links -->
            <div class="nav-links hidden lg:flex items-center gap-2.5 xl:gap-4 text-xs xl:text-sm whitespace-nowrap">
                <a href="{{ route('home') }}#hero" class="nav-link">Beranda</a>
                @if($profile->bio ?? true)
                    <a href="{{ route('home') }}#about" class="nav-link">Tentang</a>
                @endif
                @if($profile->enable_skills ?? true)
                    <a href="{{ route('home') }}#skills" class="nav-link">Keahlian</a>
                @endif
                <a href="{{ route('home') }}#timeline" class="nav-link">Pengalaman</a>
                @if($profile->enable_projects ?? true)
                    <a href="{{ route('projects.all') }}" class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">Projek</a>
                @endif
                @if($profile->enable_certificates ?? true)
                    <a href="{{ route('certificates') }}" class="nav-link {{ request()->routeIs('certificates') ? 'active' : '' }}">Sertifikat</a>
                @endif
                <a href="{{ route('estimator') }}" class="nav-link {{ request()->routeIs('estimator') ? 'active' : '' }}">Estimasi</a>
                <a href="{{ route('home') }}#workspace" class="nav-link">Workspace</a>
                <a href="{{ route('home') }}#contact" class="nav-link">Kontak</a>
            </div>

            <!-- Action Button / Admin Link -->
            <div class="hidden lg:flex items-center gap-3 flex-shrink-0">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary btn-shimmer flex items-center gap-1.5 shadow-md px-4 py-2 text-xs">
                        <i class='bx bxs-dashboard text-base'></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline flex items-center gap-1.5 hover:border-indigo-500 px-4 py-2 text-xs">
                        <i class='bx bx-log-in text-base'></i>
                        <span>Admin</span>
                    </a>
                @endauth
            </div>
            
            <!-- Mobile Menu Toggle Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-white/10 hover:border-indigo-500 transition-all">
                <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <!-- Mobile Menu Drawer Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden absolute top-full left-0 right-0 bg-[#0c0c14]/95 backdrop-blur-2xl border-b border-white/10 p-6 flex flex-col gap-2 shadow-2xl z-50" 
             style="display: none;">
            <a href="{{ route('home') }}#hero" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Beranda</a>
            @if($profile->bio ?? true)
                <a href="{{ route('home') }}#about" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Tentang Saya</a>
            @endif
            @if($profile->enable_skills ?? true)
                <a href="{{ route('home') }}#skills" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Keahlian Teknis</a>
            @endif
            <a href="{{ route('home') }}#timeline" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Pengalaman & Karir</a>
            @if($profile->enable_projects ?? true)
                <a href="{{ route('projects.all') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Semua Projek</a>
            @endif
            @if($profile->enable_certificates ?? true)
                <a href="{{ route('certificates') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Galeri Sertifikat</a>
            @endif
            <a href="{{ route('estimator') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Kalkulator Estimasi Projek</a>
            <a href="{{ route('home') }}#workspace" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Workspace Publik</a>
            <a href="{{ route('home') }}#contact" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">Hubungi Saya</a>
            
            <div class="pt-4 border-t border-white/10 mt-2">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary w-full text-center" @click="mobileMenuOpen = false">
                        <i class='bx bxs-dashboard mr-1'></i> Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline w-full text-center" @click="mobileMenuOpen = false">
                        <i class='bx bx-log-in mr-1'></i> Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Dynamic Content -->
    <main class="relative z-10 min-h-screen">
        @yield('content')
    </main>

    <!-- Modern Futuristic Footer -->
    <footer class="py-16 mt-28 relative overflow-hidden border-t border-white/5 bg-[#0c0c14]/80 backdrop-blur-md">
        <!-- Glowing Ambient Top Line -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-60"></div>
        
        <div class="container relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-12">
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 p-[1.5px]">
                            <div class="w-full h-full bg-[#060609] rounded-[9px] flex items-center justify-center font-bold text-xs text-gradient tracking-wider">
                                MSS
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold font-['Space_Grotesk'] text-gradient">{{ $profile->name ?? 'MSyafiq Portofolio' }}</h3>
                    </div>
                    <p class="text-slate-400 text-sm max-w-md">Membangun pengalaman digital masa depan dengan performa tinggi, desain elegan, dan arsitektur kode yang bersih.</p>
                </div>
                
                <!-- Quick Navigation Links in Footer -->
                <div class="flex flex-wrap justify-center gap-6 text-sm text-slate-400 font-medium">
                    <a href="{{ route('home') }}#hero" class="hover:text-indigo-400 transition-colors">Beranda</a>
                    @if($profile->enable_skills ?? true)
                        <a href="{{ route('home') }}#skills" class="hover:text-indigo-400 transition-colors">Keahlian</a>
                    @endif
                    <a href="{{ route('home') }}#timeline" class="hover:text-indigo-400 transition-colors">Pengalaman</a>
                    <a href="{{ route('projects.all') }}" class="hover:text-indigo-400 transition-colors">Katalog Projek</a>
                    <a href="{{ route('certificates') }}" class="hover:text-indigo-400 transition-colors">Galeri Sertifikat</a>
                    <a href="{{ route('estimator') }}" class="hover:text-indigo-400 transition-colors">Kalkulator Estimasi</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-indigo-400 transition-colors">Kontak</a>
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px bg-white/5 w-full mb-8"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} <span class="text-slate-300 font-semibold">{{ $profile->name ?? 'MSyafiq Portofolio' }}</span>. Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Portofolio</span>
                </div>
            </div>
        </div>
        
        <!-- Subtle Glow at Bottom -->
        <div class="absolute bottom-[-100px] left-1/2 -translate-x-1/2 w-[600px] h-40 bg-indigo-500/10 blur-[120px] rounded-full pointer-events-none"></div>
    </footer>

    <!-- Floating Lo-Fi Coding Beats Audio Player Widget -->
    <div id="lofi-widget" class="lofi-widget">
        <audio id="lofi-audio" preload="auto" autoplay loop>
            <source src="https://stream.zeno.fm/f3wvbbqmdg8uv" type="audio/mpeg">
        </audio>
        
        <button id="lofi-toggle" class="w-8 h-8 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white flex items-center justify-center shadow-md transition-all hover:scale-105 active:scale-95" title="Putar / Jeda Musik Santai (Lo-Fi)">
            <i class='bx bx-pause text-xl'></i>
        </button>
        
        <div class="flex flex-col">
            <span class="text-[11px] font-bold text-slate-200 tracking-tight flex items-center gap-1.5">
                <span>Lo-Fi Chill Beats</span>
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
            </span>
            <span class="text-[9px] text-slate-400 font-mono">Coding Ambient</span>
        </div>
        
        <div class="flex items-end gap-1 h-5 px-1">
            <div class="equalizer-bar"></div>
            <div class="equalizer-bar"></div>
            <div class="equalizer-bar"></div>
            <div class="equalizer-bar"></div>
        </div>
    </div>

    <!-- Floating Back to Top Button with Circular Scroll Progress -->
    <button id="back-to-top" class="back-to-top group" title="Kembali ke atas" aria-label="Kembali ke atas">
        <svg class="progress-ring" width="48" height="48">
            <circle
                id="progress-ring-circle"
                class="progress-ring__circle"
                stroke-width="3"
                fill="transparent"
                r="22"
                cx="24"
                cy="24"
            />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-y-1 transition-transform relative z-10"><path d="m18 15-6-6-6 6"/></svg>
    </button>

</body>
</html>
