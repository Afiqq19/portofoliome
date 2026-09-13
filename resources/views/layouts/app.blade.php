<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden w-full max-w-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ !empty($profile->bio) ? Str::limit(strip_tags($profile->bio), 160) : 'Portofolio resmi Mhd. Syafiq Syahmi - Web & Mobile Developer. Membangun aplikasi modern berkinerja tinggi, arsitektur bersih, dan desain interaktif.' }}">
    <title>@yield('title', ($profile->name ?? 'Mhd. Syafiq Syahmi') . ' - Portofolio')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}">
    
    <!-- Google Search Console Verification -->
    <meta name="google-site-verification" content="RKZ6qgPEUEpVfljmxyis7hAxPPHd589Vhe0A25k0PyI" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', ($profile->name ?? 'Mhd. Syafiq Syahmi') . ' - Portofolio')">
    <meta property="og:description" content="{{ !empty($profile->bio) ? Str::limit(strip_tags($profile->bio), 160) : 'Portofolio resmi Mhd. Syafiq Syahmi - Web & Mobile Developer dengan karya aplikasi berkinerja tinggi.' }}">
    <meta property="og:image" content="{{ (isset($profile) && $profile->avatar) ? asset('storage/' . $profile->avatar) : asset('favicon.svg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', ($profile->name ?? 'Mhd. Syafiq Syahmi') . ' - Portofolio')">
    <meta property="twitter:description" content="{{ !empty($profile->bio) ? Str::limit(strip_tags($profile->bio), 160) : 'Portofolio resmi Mhd. Syafiq Syahmi - Web & Mobile Developer dengan karya aplikasi berkinerja tinggi.' }}">
    <meta property="twitter:image" content="{{ (isset($profile) && $profile->avatar) ? asset('storage/' . $profile->avatar) : asset('favicon.svg') }}">

    <!-- JSON-LD Structured Data for Google Search Engine (Person & WebSite) -->
    @php
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $profile->name ?? 'Mhd. Syafiq Syahmi',
            'url' => url('/'),
            'jobTitle' => !empty($profile->title) ? trim(explode(',', $profile->title)[0]) : 'Software Engineer',
            'description' => !empty($profile->bio) ? Str::limit(strip_tags($profile->bio), 160) : 'Web & Mobile Developer',
        ];
        if (isset($profile) && $profile->avatar) {
            $schemaData['image'] = asset('storage/' . $profile->avatar);
        }
        if (isset($profile) && $profile->socialLinks && $profile->socialLinks->count() > 0) {
            $schemaData['sameAs'] = $profile->socialLinks->pluck('url')->toArray();
        }
    @endphp
    <script type="application/ld+json">
    {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Google Analytics -->
    @if(isset($profile) && !empty($profile->google_analytics_id))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $profile->google_analytics_id }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $profile->google_analytics_id }}');
    </script>
    @endif

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
<body class="bg-[#060609] text-slate-100 antialiased relative selection:bg-indigo-500/30 selection:text-indigo-200 overflow-x-hidden w-full max-w-full" x-data>
    
    <!-- Preloader / Splash Screen -->
    <div id="page-loader" class="fixed inset-0 z-[9999] bg-[#020617] flex flex-col items-center justify-center transition-all duration-700">
        <div class="relative flex items-center justify-center">
            <!-- Outer Glow -->
            <div class="absolute w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl animate-pulse"></div>
            <div class="absolute w-24 h-24 bg-cyan-500/20 rounded-full blur-xl animate-ping" style="animation-duration: 3s;"></div>
            
            <!-- Logo Box -->
            <div class="relative z-10 w-20 h-20 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm flex items-center justify-center shadow-[0_0_40px_rgba(99,102,241,0.2)]">
                <span class="text-3xl font-black font-['Space_Grotesk'] text-transparent bg-clip-text bg-gradient-to-tr from-indigo-400 to-cyan-400">MSS</span>
            </div>
            
            <!-- Orbiting Dot -->
            <div class="absolute w-28 h-28 border border-white/5 rounded-full animate-[spin_4s_linear_infinite]">
                <div class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-cyan-400 rounded-full shadow-[0_0_10px_#06b6d4]"></div>
            </div>
        </div>
        
        <!-- Loading Bar -->
        <div class="mt-8 w-48 h-1 bg-white/5 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-indigo-500 via-cyan-400 to-indigo-500 w-1/2 rounded-full animate-[loading_1.5s_ease-in-out_infinite_alternate]"></div>
        </div>
        <div class="mt-3 text-xs font-mono text-slate-500 tracking-widest uppercase animate-pulse">Inisialisasi Sistem...</div>
    </div>
    
    <script>
        // Sembunyikan loader saat halaman siap
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loader = document.getElementById('page-loader');
                if(loader) {
                    loader.style.opacity = '0';
                    loader.style.visibility = 'hidden';
                    setTimeout(() => loader.remove(), 700); // Hapus elemen dari DOM setelah fade out
                }
            }, 500); // Sedikit delay agar animasi terlihat utuh
        });
    </script>
    <style>
        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
    </style>

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
    <nav class="navbar w-full max-w-full" x-data="{ mobileMenuOpen: false }">
        <div class="container max-w-7xl flex justify-between items-center relative gap-2 sm:gap-4 px-3 sm:px-6">
            
            <!-- Brand Mark (Left) -->
            <a href="{{ route('home') }}" class="nav-brand group flex items-center gap-2 sm:gap-3 flex-shrink min-w-0" @click="if (window.location.pathname === '/') { $event.preventDefault(); window.scrollTo({top: 0, behavior: 'smooth'}); history.replaceState(null, '', '/'); }">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-[1.5px] shadow-[0_0_15px_rgba(99,102,241,0.5)] group-hover:shadow-[0_0_25px_rgba(99,102,241,0.8)] transition-all duration-300 flex-shrink-0">
                    <div class="w-full h-full bg-[#060609] rounded-[9px] sm:rounded-[10px] flex items-center justify-center font-black text-xs sm:text-sm tracking-wider">
                        <span class="text-gradient font-black">MSS</span>
                    </div>
                </div>
                <div class="flex flex-col min-w-0 overflow-hidden">
                    <span class="text-xs sm:text-lg font-bold font-['Space_Grotesk'] text-gradient tracking-tight truncate max-w-[120px] xs:max-w-[150px] sm:max-w-none leading-tight">
                        {{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}
                    </span>
                    @php
                        $headerRole = !empty($profile->title) ? trim(explode(',', $profile->title)[0]) : 'Software Engineer';
                    @endphp
                    <span class="text-[9px] sm:text-[10px] text-slate-400 font-mono flex items-center gap-1 sm:gap-1.5 leading-none mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse flex-shrink-0"></span>
                        <span class="text-slate-400 truncate">{{ $headerRole }}</span>
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
                            @if($profile && $profile->resume_path)
                            <div class="h-px bg-white/10 my-1"></div>
                            <a href="{{ route('cv.download') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors cursor-pointer" @click="open = false; $event.preventDefault(); openPdfModal('{{ route('cv.download') }}', 'Curriculum Vitae - {{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}')">
                                <div class="w-8 h-8 rounded-lg bg-rose-500/15 border border-rose-500/30 flex items-center justify-center text-rose-400 group-hover:scale-110 group-hover:bg-rose-500 group-hover:text-white transition-all">
                                    <i class='bx bxs-file-pdf text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-rose-300" x-text="$store.lang?.current === 'en' ? 'Preview / Download CV' : 'Lihat & Unduh CV'">Lihat & Unduh CV</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Verified PDF Document' : 'Pratinjau Dokumen PDF'">Pratinjau Dokumen PDF</div>
                                </div>
                            </a>
                            @endif
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
                                :class="{ 'text-white bg-white/5': open, 'active': {{ request()->routeIs('estimator') || request()->routeIs('faq') ? 'true' : 'false' }} }">
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
                            @if($profile->enable_estimator ?? true)
                            <a href="{{ route('estimator') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
                                <div class="w-8 h-8 rounded-lg bg-cyan-500/15 border border-cyan-500/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all">
                                    <i class='bx bx-calculator text-base'></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-200 group-hover:text-cyan-300" x-text="$store.lang?.current === 'en' ? 'Cost & Time Estimator' : 'Kalkulator Estimasi'">Kalkulator Estimasi</div>
                                    <div class="text-[10px] text-slate-400" x-text="$store.lang?.current === 'en' ? 'Estimate duration & investment' : 'Simulasi biaya & waktu projek'">Simulasi biaya & waktu projek</div>
                                </div>
                            </a>
                            @endif
                            <a href="{{ route('faq') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 group transition-colors" @click="open = false">
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
            <div class="flex items-center gap-1.5 sm:gap-2 md:hidden flex-shrink-0">
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
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-white/10 hover:border-indigo-500 transition-all flex-shrink-0">
                    <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
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
            @if($profile && $profile->resume_path)
                <a href="{{ route('cv.download') }}" class="text-rose-400 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all flex items-center gap-2 cursor-pointer" @click="mobileMenuOpen = false; $event.preventDefault(); openPdfModal('{{ route('cv.download') }}', 'Curriculum Vitae - {{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}')">
                    <i class='bx bxs-file-pdf text-lg text-rose-400'></i>
                    <span x-text="$store.lang?.current === 'en' ? 'Preview & Download CV (PDF)' : 'Lihat & Unduh CV / Resume (PDF)'">Lihat & Unduh CV / Resume (PDF)</span>
                </a>
            @endif
            
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
            @if($profile->enable_estimator ?? true)
            <a href="{{ route('estimator') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
                <span x-text="$store.lang?.current === 'en' ? 'Cost & Time Estimator' : 'Kalkulator Estimasi Projek'">Kalkulator Estimasi Projek</span>
            </a>
            @endif
            <a href="{{ route('faq') }}" class="text-slate-300 hover:text-white font-medium py-2 px-3 rounded-xl hover:bg-white/5 transition-all" @click="mobileMenuOpen = false">
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
    <main class="relative z-10 min-h-screen overflow-x-hidden w-full max-w-full">
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
                    @if($profile->enable_estimator ?? true)
                    <a href="{{ route('estimator') }}" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Estimator' : 'Kalkulator Estimasi'">Kalkulator Estimasi</a>
                    @endif
                    <a href="{{ route('faq') }}" class="hover:text-indigo-400 transition-colors {{ request()->routeIs('faq') ? 'text-indigo-400 font-bold' : '' }}">FAQ</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-indigo-400 transition-colors" x-text="$store.lang?.current === 'en' ? 'Contact' : 'Kontak'">Kontak</a>
                    @if($profile && $profile->resume_path)
                        <a href="{{ route('cv.download') }}" onclick="event.preventDefault(); openPdfModal('{{ route('cv.download') }}', 'Curriculum Vitae - {{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}')" class="hover:text-rose-400 transition-colors flex items-center gap-1 font-semibold text-slate-300 cursor-pointer">
                            <i class='bx bxs-file-pdf text-rose-400'></i>
                            <span x-text="$store.lang?.current === 'en' ? 'Preview CV (PDF)' : 'Lihat CV (PDF)'">Lihat CV (PDF)</span>
                        </a>
                    @endif
                </div>

                <!-- Footer Social Media Icons -->
                @if(isset($profile) && $profile->socialLinks && $profile->socialLinks->count() > 0)
                <div class="flex flex-wrap justify-center items-center gap-3 pt-2">
                    @foreach($profile->socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/5 border border-white/10 hover:border-indigo-500/50 hover:bg-gradient-to-tr hover:from-indigo-600 hover:to-purple-600 text-slate-300 hover:text-white transition-all duration-300 hover:-translate-y-1 shadow-sm" title="{{ $link->platform }}">
                            @if($link->icon)
                                <i class="{{ $link->icon }} text-lg"></i>
                            @else
                                <span class="text-xs font-bold">{{ substr($link->platform, 0, 2) }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
                @endif
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

    <!-- Developer CLI Floating Trigger Button -->
    <button id="terminal-trigger" onclick="toggleTerminalModal()" class="fixed bottom-24 left-6 z-40 px-3.5 py-2 rounded-full bg-[#0c0c14]/90 hover:bg-indigo-600 border border-white/15 hover:border-indigo-400 text-slate-300 hover:text-white backdrop-blur-xl shadow-lg transition-all duration-300 flex items-center gap-2 group hover:scale-105 active:scale-95 cursor-pointer" title="Buka Interactive Developer Terminal">
        <span class="font-mono font-bold text-xs text-accent-cyan group-hover:text-white">&gt;_</span>
        <span class="text-xs font-mono font-semibold hidden sm:inline">Dev Console</span>
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
    </button>

    <!-- Developer CLI Terminal Modal -->
    <div id="terminal-modal" class="fixed bottom-24 left-4 sm:left-6 z-50 w-[calc(100vw-2rem)] sm:w-[520px] max-h-[480px] bg-[#0c0c14]/98 border border-indigo-500/30 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.9)] backdrop-blur-2xl flex flex-col overflow-hidden transition-all duration-300 scale-95 opacity-0 pointer-events-none font-mono" style="display: none;">
        <!-- Terminal Header Bar -->
        <div class="flex items-center justify-between px-4 py-2.5 bg-[#060609] border-b border-white/10 select-none">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-rose-500 cursor-pointer hover:opacity-80" onclick="toggleTerminalModal()"></span>
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                <span class="text-[11px] text-slate-300 font-bold ml-2">syafiq@terminal:~ (zsh)</span>
            </div>
            <button onclick="toggleTerminalModal()" class="text-slate-400 hover:text-white text-xs cursor-pointer">
                <i class='bx bx-x text-base'></i>
            </button>
        </div>

        <!-- Terminal Output Area -->
        <div id="terminal-output" class="p-4 overflow-y-auto max-h-[300px] text-xs space-y-2 text-slate-300 leading-relaxed scrollbar-thin">
            <div class="text-emerald-400 font-bold">💻 Mhd. Syafiq Syahmi Interactive CLI [Version 2.4]</div>
            <div class="text-slate-400 text-[11px]">Ketik <span class="text-cyan-400 font-bold">help</span> untuk daftar perintah, atau klik chip di bawah.</div>
            <div class="h-px bg-white/10 my-1"></div>
        </div>

        <!-- Quick Action Command Chips -->
        <div class="px-3 py-1.5 bg-[#08080d] border-t border-white/10 flex items-center gap-1.5 overflow-x-auto no-scrollbar text-[10px]">
            <span class="text-slate-500 font-semibold uppercase tracking-wider text-[9px] mr-1">Quick:</span>
            <button onclick="executeTerminalCommand('bio')" class="px-2 py-0.5 rounded bg-white/5 hover:bg-white/15 text-cyan-300 transition-colors cursor-pointer">bio</button>
            <button onclick="executeTerminalCommand('skills')" class="px-2 py-0.5 rounded bg-white/5 hover:bg-white/15 text-cyan-300 transition-colors cursor-pointer">skills</button>
            <button onclick="executeTerminalCommand('projects')" class="px-2 py-0.5 rounded bg-white/5 hover:bg-white/15 text-cyan-300 transition-colors cursor-pointer">projects</button>
            <button onclick="executeTerminalCommand('contact')" class="px-2 py-0.5 rounded bg-white/5 hover:bg-white/15 text-cyan-300 transition-colors cursor-pointer">contact</button>
            <button onclick="executeTerminalCommand('socials')" class="px-2 py-0.5 rounded bg-white/5 hover:bg-white/15 text-cyan-300 transition-colors cursor-pointer">socials</button>
            <button onclick="executeTerminalCommand('clear')" class="px-2 py-0.5 rounded bg-white/5 hover:bg-white/15 text-rose-400 transition-colors cursor-pointer">clear</button>
        </div>

        <!-- Terminal Input Line -->
        <form id="terminal-form" onsubmit="handleTerminalSubmit(event)" class="flex items-center px-4 py-2.5 bg-[#060609] border-t border-white/10">
            <span class="text-emerald-400 font-bold mr-2 text-xs">❯</span>
            <input type="text" id="terminal-input" autocomplete="off" spellcheck="false" placeholder="Ketik perintah..." class="flex-1 bg-transparent text-xs text-white placeholder-slate-500 focus:outline-none font-mono">
            <button type="submit" class="text-indigo-400 hover:text-indigo-300 text-sm ml-2 cursor-pointer">
                <i class='bx bx-send'></i>
            </button>
        </form>
    </div>

    <!-- Interactive In-Page PDF Modal Viewer -->
    <div id="pdf-modal" class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-6 bg-black/85 backdrop-blur-xl transition-all duration-300 opacity-0 pointer-events-none" style="display: none;">
        <div class="relative w-full max-w-5xl h-[88vh] bg-[#0c0c14] border border-white/15 rounded-3xl shadow-[0_25px_60px_rgba(0,0,0,0.9)] flex flex-col overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-4 sm:px-6 py-3.5 border-b border-white/10 bg-[#060609]/90 backdrop-blur-md select-none">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-rose-500/15 border border-rose-500/30 flex items-center justify-center text-rose-400 flex-shrink-0">
                        <i class='bx bxs-file-pdf text-xl'></i>
                    </div>
                    <div class="min-w-0">
                        <h4 id="pdf-modal-title" class="text-xs sm:text-sm font-bold font-['Space_Grotesk'] text-slate-100 truncate">Pratinjau Dokumen PDF</h4>
                        <p class="text-[10px] text-slate-400 font-mono">Dokumen Resmi & Terverifikasi • Mhd. Syafiq Syahmi</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a id="pdf-modal-download" href="#" download class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-xs font-bold transition-all shadow-md active:scale-95">
                        <i class='bx bx-download text-sm'></i>
                        <span class="hidden sm:inline">Unduh Dokumen</span>
                    </a>
                    <button onclick="closePdfModal()" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-rose-500/20 text-slate-400 hover:text-rose-400 border border-white/10 flex items-center justify-center transition-all cursor-pointer">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
            </div>
            <!-- Modal Body (Embed / iFrame) -->
            <div class="flex-1 w-full h-full bg-[#131320] relative">
                <iframe id="pdf-modal-frame" src="" class="w-full h-full border-0" title="PDF Preview"></iframe>
            </div>
        </div>
    </div>

    <!-- Global Interactive PDF Viewer & Developer Terminal JS -->
    <script>
        // PDF Modal Functions
        function openPdfModal(url, title = 'Dokumen PDF') {
            const modal = document.getElementById('pdf-modal');
            const frame = document.getElementById('pdf-modal-frame');
            const titleElem = document.getElementById('pdf-modal-title');
            const downloadBtn = document.getElementById('pdf-modal-download');
            
            if (!modal || !frame) return;
            
            titleElem.innerText = title;
            downloadBtn.href = url;
            frame.src = url;
            
            modal.style.display = 'flex';
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100');
            });
        }

        function closePdfModal() {
            const modal = document.getElementById('pdf-modal');
            const frame = document.getElementById('pdf-modal-frame');
            if (!modal) return;
            
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                modal.style.display = 'none';
                if (frame) frame.src = '';
            }, 250);
        }

        // Developer CLI Terminal Controller
        const devTerminalData = {
            name: "{{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}",
            title: "{{ !empty($profile->title) ? trim(explode(',', $profile->title)[0]) : 'Software Engineer' }}",
            bio: "{{ addslashes(strip_tags($profile->bio ?? 'Full Stack & Mobile Engineer.')) }}",
            email: "{{ $profile->email ?? 'mhdsyafiqsyahmi@gmail.com' }}",
            phone: "{{ $profile->phone ?? '+62 812-3456-7890' }}",
            projectsUrl: "{{ route('projects.all') }}",
            cvUrl: "{{ route('cv.download') }}",
            socials: [
                @if(isset($profile) && $profile->socialLinks)
                    @foreach($profile->socialLinks as $link)
                        { platform: "{{ $link->platform }}", url: "{{ $link->url }}" },
                    @endforeach
                @endif
            ]
        };

        function toggleTerminalModal() {
            const modal = document.getElementById('terminal-modal');
            if (!modal) return;

            const isHidden = modal.style.display === 'none' || modal.classList.contains('pointer-events-none');
            if (isHidden) {
                modal.style.display = 'flex';
                requestAnimationFrame(() => {
                    modal.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                    modal.classList.add('opacity-100', 'scale-100');
                    document.getElementById('terminal-input')?.focus();
                });
            } else {
                modal.classList.remove('opacity-100', 'scale-100');
                modal.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                setTimeout(() => { modal.style.display = 'none'; }, 200);
            }
        }

        function executeTerminalCommand(cmd) {
            const output = document.getElementById('terminal-output');
            if (!output) return;

            const trimmed = cmd.trim().toLowerCase();
            const promptLine = document.createElement('div');
            promptLine.className = 'text-slate-400 font-bold';
            promptLine.innerHTML = `<span class="text-emerald-400">❯</span> <span class="text-white">${cmd}</span>`;
            output.appendChild(promptLine);

            const resLine = document.createElement('div');
            resLine.className = 'pl-3';

            switch (trimmed) {
                case 'help':
                    resLine.innerHTML = `
                        <div class="text-indigo-400 font-semibold mb-1">Perintah Tersedia:</div>
                        <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-[11px]">
                            <div><span class="text-cyan-300 font-bold">bio</span> - Info pengembang</div>
                            <div><span class="text-cyan-300 font-bold">skills</span> - Stack teknologi</div>
                            <div><span class="text-cyan-300 font-bold">projects</span> - Katalog karya</div>
                            <div><span class="text-cyan-300 font-bold">contact</span> - Kontak & WhatsApp</div>
                            <div><span class="text-cyan-300 font-bold">socials</span> - Akun media sosial</div>
                            <div><span class="text-cyan-300 font-bold">cv</span> - Pratinjau PDF CV</div>
                            <div><span class="text-rose-400 font-bold">clear</span> - Bersihkan konsol</div>
                            <div><span class="text-slate-400 font-bold">exit</span> - Tutup terminal</div>
                        </div>
                    `;
                    break;
                case 'bio':
                    resLine.innerHTML = `
                        <div class="p-2 rounded-lg bg-white/5 border border-white/10">
                            <div class="font-bold text-white">${devTerminalData.name}</div>
                            <div class="text-xs text-indigo-400">${devTerminalData.title}</div>
                            <div class="text-[11px] text-slate-400 mt-1">${devTerminalData.bio}</div>
                        </div>
                    `;
                    break;
                case 'skills':
                    resLine.innerHTML = `
                        <div class="text-slate-300 text-[11px] space-y-1">
                            <div>⚡ <b class="text-white">Core:</b> Laravel, PHP 8+, JavaScript (ES6+), Alpine.js</div>
                            <div>🎨 <b class="text-white">Frontend:</b> Tailwind CSS, HTML5/CSS3, Blade Templates</div>
                            <div>📱 <b class="text-white">Mobile:</b> Flutter, Android APK Development</div>
                            <div>🛠️ <b class="text-white">Tools & Ops:</b> Docker, Nginx, Git, MySQL, Linux VPS</div>
                        </div>
                    `;
                    break;
                case 'projects':
                    resLine.innerHTML = `
                        <div class="text-[11px]">
                            <div class="text-slate-300 mb-1">Menampilkan ringkasan katalog karya:</div>
                            <a href="${devTerminalData.projectsUrl}" class="inline-flex items-center gap-1 text-cyan-400 hover:underline font-bold">
                                <span>Buka Semua Projek Portofolio</span>
                                <i class='bx bx-right-arrow-alt'></i>
                            </a>
                        </div>
                    `;
                    break;
                case 'contact':
                    resLine.innerHTML = `
                        <div class="text-[11px] space-y-0.5">
                            <div>📧 Email: <a href="mailto:${devTerminalData.email}" class="text-cyan-400 hover:underline">${devTerminalData.email}</a></div>
                            <div>💬 WhatsApp: <a href="https://wa.me/${devTerminalData.phone.replace(/[^0-9]/g, '')}" target="_blank" class="text-emerald-400 hover:underline">${devTerminalData.phone}</a></div>
                        </div>
                    `;
                    break;
                case 'socials':
                    let linksHtml = devTerminalData.socials.map(s => `<div>🔗 <a href="${s.url}" target="_blank" class="text-cyan-400 hover:underline capitalize">${s.platform}</a></div>`).join('');
                    resLine.innerHTML = `<div class="text-[11px] space-y-0.5">${linksHtml || 'Belum ada sosial media.'}</div>`;
                    break;
                case 'cv':
                    resLine.innerHTML = `<div class="text-rose-400 text-[11px]">Membuka pratinjau dokumen CV...</div>`;
                    openPdfModal(devTerminalData.cvUrl, 'Curriculum Vitae - ' + devTerminalData.name);
                    break;
                case 'clear':
                    output.innerHTML = `
                        <div class="text-emerald-400 font-bold">💻 Mhd. Syafiq Syahmi Interactive CLI [Version 2.4]</div>
                        <div class="text-slate-400 text-[11px]">Ketik <span class="text-cyan-400 font-bold">help</span> untuk daftar perintah.</div>
                        <div class="h-px bg-white/10 my-1"></div>
                    `;
                    return;
                case 'exit':
                case 'quit':
                    toggleTerminalModal();
                    return;
                default:
                    resLine.innerHTML = `<div class="text-rose-400 text-[11px]">Perintah tidak dikenali: <b>${cmd}</b>. Ketik <span class="text-cyan-400">help</span> untuk melihat daftar perintah.</div>`;
                    break;
            }

            output.appendChild(resLine);
            output.scrollTop = output.scrollHeight;
        }

        function handleTerminalSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('terminal-input');
            if (!input || !input.value.trim()) return;
            const cmd = input.value;
            input.value = '';
            executeTerminalCommand(cmd);
        }
    </script>

</body>
</html>
