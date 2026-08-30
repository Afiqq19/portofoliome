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
<body class="bg-[#060609] text-slate-100 antialiased relative selection:bg-indigo-500/30 selection:text-indigo-200" x-data>

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

    <!-- Navigation Header (Executive Glass Capsule Layout) -->
    <nav class="navbar" x-data="{ mobileMenuOpen: false }">
        <div class="container max-w-7xl flex justify-between items-center relative gap-4">
            
            <!-- Brand Mark (Left) -->
            <a href="{{ route('home') }}" class="nav-brand group flex items-center gap-3 flex-shrink-0" @click="if (window.location.pathname === '/') { $event.preventDefault(); window.scrollTo({top: 0, behavior: 'smooth'}); history.replaceState(null, '', '/'); }">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-[1.5px] shadow-[0_0_15px_rgba(99,102,241,0.5)] group-hover:shadow-[0_0_25px_rgba(99,102,241,0.8)] transition-all duration-300">
                    <div class="w-full h-full bg-[#060609] rounded-[10px] flex items-center justify-center font-black text-xs sm:text-sm tracking-wider">
                        <span class="text-gradient font-black">MSS</span>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="text-base sm:text-lg font-bold font-['Space_Grotesk'] text-gradient tracking-tight group-hover:scale-[1.01] transition-transform whitespace-nowrap leading-tight">
                        {{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-mono flex items-center gap-1.5 leading-none mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-slate-400">Software Engineer</span>
                    </span>
                </div>
            </a>
            
            <!-- Desktop Unified Nav Capsule + Language Toggle (Right Aligned) -->
            <div class="hidden md:flex items-center gap-3">
                
                <!-- Floating Glass Nav Capsule -->
                <div class="glass-panel py-1.5 px-3 rounded-full border border-white/10 flex items-center gap-1 bg-[#0c0c14]/70 backdrop-blur-2xl shadow-[0_8px_25px_rgba(0,0,0,0.4)]">
                    
                    <!-- Beranda -->
                    <a href="{{ route('home') }}" class="nav-link text-xs lg:text-sm px-3.5 py-1.5 rounded-full" @click="if (window.location.pathname === '/') { $event.preventDefault(); window.scrollTo({top: 0, behavior: 'smooth'}); history.replaceState(null, '', '/'); }">
                        <span x-text="$store.lang?.current === 'en' ? 'Home' : 'Beranda'">Beranda</span>
                    </a>

                    <!-- Profil Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" 
                                class="nav-link text-xs lg:text-sm px-3.5 py-1.5 rounded-full flex items-center gap-1 cursor-pointer focus:outline-none"
                                :class="{ 'text-white bg-white/5': open }">
                            <span x-text="$store.lang?.current === 'en' ? 'Profile' : 'Profil'">Profil</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-200" :class="{ 'rotate-180 text-indigo-400': open }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             @click.outside="open = false"
                             class="absolute top-full left-0 mt-3 w-64 p-2 rounded-2xl bg-[#0c0c14]/95 backdrop-blur-2xl border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.8)] z-50 flex flex-col gap-1"
                             style="display: none;">
                            @if($profile->bio ?? true)
                            <a href="{{ route('home') }}#about" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                                    <i class='bx bx-user text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-indigo-300" x-text="$store.lang?.current === 'en' ? 'About Me' : 'Tentang Saya'">Tentang Saya</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Bio, vision & code philosophy' : 'Bio, visi & dedikasi kode'">Bio, visi & dedikasi kode</div>
                                </div>
                            </a>
                            @endif
                            @if($profile->enable_skills ?? true)
                            <a href="{{ route('home') }}#skills" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-cyan-500/15 border border-cyan-500/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all">
                                    <i class='bx bx-layer text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-cyan-300" x-text="$store.lang?.current === 'en' ? 'Skills & Stack' : 'Keahlian & Stack'">Keahlian & Stack</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Technologies & mastery' : 'Teknologi & penguasaan'">Teknologi & penguasaan</div>
                                </div>
                            </a>
                            @endif
                            <a href="{{ route('home') }}#timeline" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-purple-500/15 border border-purple-500/30 flex items-center justify-center text-purple-400 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all">
                                    <i class='bx bx-time-five text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-purple-300" x-text="$store.lang?.current === 'en' ? 'Experience & Career' : 'Pengalaman & Karir'">Pengalaman & Karir</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Journey & milestones' : 'Garis waktu pencapaian'">Garis waktu pencapaian</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Karya Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" 
                                class="nav-link text-xs lg:text-sm px-3.5 py-1.5 rounded-full flex items-center gap-1 cursor-pointer focus:outline-none"
                                :class="{ 'text-white bg-white/5': open, 'active': {{ request()->routeIs('projects.*') || request()->routeIs('certificates') ? 'true' : 'false' }} }">
                            <span x-text="$store.lang?.current === 'en' ? 'Works' : 'Karya'">Karya</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-200" :class="{ 'rotate-180 text-indigo-400': open }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             @click.outside="open = false"
                             class="absolute top-full left-0 mt-3 w-64 p-2 rounded-2xl bg-[#0c0c14]/95 backdrop-blur-2xl border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.8)] z-50 flex flex-col gap-1"
                             style="display: none;">
                            @if($profile->enable_projects ?? true)
                            <a href="{{ route('projects.all') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                                    <i class='bx bx-laptop text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-indigo-300" x-text="$store.lang?.current === 'en' ? 'Project Catalog' : 'Katalog Projek'">Katalog Projek</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Web App, Systems & APK' : 'Web App, Sistem & APK'">Web App, Sistem & APK</div>
                                </div>
                            </a>
                            @endif
                            @if($profile->enable_certificates ?? true)
                            <a href="{{ route('certificates') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-purple-500/15 border border-purple-500/30 flex items-center justify-center text-purple-400 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all">
                                    <i class='bx bx-award text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-purple-300" x-text="$store.lang?.current === 'en' ? 'Certificates Gallery' : 'Galeri Sertifikat'">Galeri Sertifikat</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Official awards & licenses' : 'Lisensi & penghargaan resmi'">Lisensi & penghargaan resmi</div>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Layanan Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" 
                                class="nav-link text-xs lg:text-sm px-3.5 py-1.5 rounded-full flex items-center gap-1 cursor-pointer focus:outline-none"
                                :class="{ 'text-white bg-white/5': open, 'active': {{ request()->routeIs('estimator') ? 'true' : 'false' }} }">
                            <span x-text="$store.lang?.current === 'en' ? 'Services' : 'Layanan'">Layanan</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-200" :class="{ 'rotate-180 text-indigo-400': open }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             @click.outside="open = false"
                             class="absolute top-full left-0 mt-3 w-64 p-2 rounded-2xl bg-[#0c0c14]/95 backdrop-blur-2xl border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.8)] z-50 flex flex-col gap-1"
                             style="display: none;">
                            <a href="{{ route('estimator') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-cyan-500/15 border border-cyan-500/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all">
                                    <i class='bx bx-calculator text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-cyan-300" x-text="$store.lang?.current === 'en' ? 'Cost & Time Estimator' : 'Kalkulator Estimasi'">Kalkulator Estimasi</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Estimate duration & investment' : 'Simulasi biaya & waktu projek'">Simulasi biaya & waktu projek</div>
                                </div>
                            </a>
                            <a href="{{ route('home') }}#faq" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-400 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                                    <i class='bx bx-help-circle text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-indigo-300" x-text="$store.lang?.current === 'en' ? 'FAQ & Policies' : 'Tanya Jawab (FAQ)'">Tanya Jawab (FAQ)</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Warranty, revisions & flow' : 'Garansi, revisi & proses kerja'">Garansi, revisi & proses kerja</div>
                                </div>
                            </a>
                            <a href="{{ route('home') }}#workspace" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                                    <i class='bx bx-message-square-dots text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-emerald-300" x-text="$store.lang?.current === 'en' ? 'Public Workspace' : 'Workspace Publik'">Workspace Publik</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Digital notes & guestbook' : 'Buku tamu & catatan digital'">Buku tamu & catatan digital</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <a href="{{ route('home') }}#contact" class="nav-link text-xs lg:text-sm px-3.5 py-1.5 rounded-full">
                        <span x-text="$store.lang?.current === 'en' ? 'Contact' : 'Kontak'">Kontak</span>
                    </a>
                </div>

                <!-- Subtle Vertical Separator -->
                <div class="w-px h-6 bg-white/10"></div>

                <!-- Sleek Segmented Language Switcher (Crisp ID | EN Pill) -->
                <div class="glass-panel p-1 rounded-full border border-white/10 flex items-center bg-[#0c0c14]/70 backdrop-blur-2xl shadow-md">
                    <button @click="$store.lang.set('id')" 
                            class="px-2.5 py-1 rounded-full text-xs font-bold font-mono transition-all cursor-pointer select-none"
                            :class="$store.lang?.current === 'id' ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md' : 'text-slate-400 hover:text-white'">
                        ID
                    </button>
                    <button @click="$store.lang.set('en')" 
                            class="px-2.5 py-1 rounded-full text-xs font-bold font-mono transition-all cursor-pointer select-none"
                            :class="$store.lang?.current === 'en' ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md' : 'text-slate-400 hover:text-white'">
                        EN
                    </button>
                </div>
            </div>

            <!-- Mobile Controls (Right) -->
            <div class="flex items-center gap-2 md:hidden">
                <!-- Mobile Segmented Language Pill -->
                <div class="glass-panel p-0.5 rounded-full border border-white/10 flex items-center bg-white/5">
                    <button @click="$store.lang.set('id')" 
                            class="px-2 py-0.5 rounded-full text-[10px] font-bold font-mono transition-all cursor-pointer"
                            :class="$store.lang?.current === 'id' ? 'bg-indigo-600 text-white' : 'text-slate-400'">
                        ID
                    </button>
                    <button @click="$store.lang.set('en')" 
                            class="px-2 py-0.5 rounded-full text-[10px] font-bold font-mono transition-all cursor-pointer"
                            :class="$store.lang?.current === 'en' ? 'bg-indigo-600 text-white' : 'text-slate-400'">
                        EN
                    </button>
                </div>

                <!-- Mobile Menu Toggle Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-white/10 hover:border-indigo-500 transition-all">
                    <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden absolute top-full left-0 right-0 bg-[#0c0c14]/95 backdrop-blur-2xl border-b border-white/10 p-6 flex flex-col gap-2 shadow-2xl z-50 max-h-[80vh] overflow-y-auto" 
             style="display: none;">
            
            <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider px-3" x-text="$store.lang?.current === 'en' ? 'Main' : 'Utama'">Utama</div>
            <a href="{{ route('home') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false; if (window.location.pathname === '/') { $event.preventDefault(); window.scrollTo({top: 0, behavior: 'smooth'}); history.replaceState(null, '', '/'); }">
                <span x-text="$store.lang?.current === 'en' ? 'Home' : 'Beranda'">Beranda</span>
            </a>
            
            <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider px-3 mt-2" x-text="$store.lang?.current === 'en' ? 'Profile' : 'Profil'">Profil</div>
            @if($profile->bio ?? true)
                <a href="{{ route('home') }}#about" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                    <span x-text="$store.lang?.current === 'en' ? 'About Me' : 'Tentang Saya'">Tentang Saya</span>
                </a>
            @endif
            @if($profile->enable_skills ?? true)
                <a href="{{ route('home') }}#skills" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                    <span x-text="$store.lang?.current === 'en' ? 'Skills & Stack' : 'Keahlian Teknis'">Keahlian Teknis</span>
                </a>
            @endif
            <a href="{{ route('home') }}#timeline" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                <span x-text="$store.lang?.current === 'en' ? 'Experience & Career' : 'Pengalaman & Karir'">Pengalaman & Karir</span>
            </a>
            
            <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider px-3 mt-2" x-text="$store.lang?.current === 'en' ? 'Works' : 'Karya'">Karya</div>
            @if($profile->enable_projects ?? true)
                <a href="{{ route('projects.all') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                    <span x-text="$store.lang?.current === 'en' ? 'Project Catalog' : 'Katalog Projek'">Katalog Projek</span>
                </a>
            @endif
            @if($profile->enable_certificates ?? true)
                <a href="{{ route('certificates') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                    <span x-text="$store.lang?.current === 'en' ? 'Certificates Gallery' : 'Galeri Sertifikat'">Galeri Sertifikat</span>
                </a>
            @endif

            <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider px-3 mt-2" x-text="$store.lang?.current === 'en' ? 'Services & Interaction' : 'Layanan & Interaksi'">Layanan & Interaksi</div>
            <a href="{{ route('estimator') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                <span x-text="$store.lang?.current === 'en' ? 'Cost & Time Estimator' : 'Kalkulator Estimasi Projek'">Kalkulator Estimasi Projek</span>
            </a>
            <a href="{{ route('home') }}#faq" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                <span x-text="$store.lang?.current === 'en' ? 'FAQ (Frequently Asked Questions)' : 'Tanya Jawab (FAQ)'">Tanya Jawab (FAQ)</span>
            </a>
            <a href="{{ route('home') }}#workspace" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                <span x-text="$store.lang?.current === 'en' ? 'Public Workspace' : 'Workspace Publik'">Workspace Publik</span>
            </a>
            <a href="{{ route('home') }}#contact" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                <span x-text="$store.lang?.current === 'en' ? 'Contact Me' : 'Hubungi Saya'">Hubungi Saya</span>
            </a>
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
                        <h3 class="text-2xl font-bold font-['Space_Grotesk'] text-gradient">{{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}</h3>
                    </div>
                    <p class="text-slate-400 text-sm max-w-md" x-text="$store.lang?.current === 'en' ? 'Building next-generation digital experiences with peak performance, sleek aesthetics, and robust code architecture.' : 'Membangun pengalaman digital masa depan dengan performa tinggi, desain elegan, dan arsitektur kode yang bersih.'">Membangun pengalaman digital masa depan dengan performa tinggi, desain elegan, dan arsitektur kode yang bersih.</p>
                </div>
                
                <!-- Quick Navigation Links in Footer -->
                <div class="flex flex-wrap justify-center gap-6 text-sm text-slate-400 font-medium">
                    <a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Home' : 'Beranda'">Beranda</a>
                    @if($profile->enable_skills ?? true)
                        <a href="{{ route('home') }}#skills" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Skills' : 'Keahlian'">Keahlian</a>
                    @endif
                    <a href="{{ route('home') }}#timeline" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Timeline' : 'Pengalaman'">Pengalaman</a>
                    <a href="{{ route('projects.all') }}" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Projects' : 'Katalog Projek'">Katalog Projek</a>
                    <a href="{{ route('certificates') }}" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Certificates' : 'Galeri Sertifikat'">Galeri Sertifikat</a>
                    <a href="{{ route('estimator') }}" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Estimator' : 'Kalkulator Estimasi'">Kalkulator Estimasi</a>
                    <a href="{{ route('home') }}#faq" class="hover:text-indigo-400 transition-colors">FAQ</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Contact' : 'Kontak'">Kontak</a>
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px bg-white/5 w-full mb-8"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} <span class="text-slate-300 font-semibold">{{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}</span>. <span x-text="$store.lang?.current === 'en' ? 'All Rights Reserved.' : 'Hak Cipta Dilindungi.'">Hak Cipta Dilindungi.</span></p>
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span x-text="$store.lang?.current === 'en' ? 'System Active & Open for Opportunities' : 'Sistem Portofolio Aktif & Siap Kolaborasi'">Sistem Portofolio Aktif & Siap Kolaborasi</span>
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
