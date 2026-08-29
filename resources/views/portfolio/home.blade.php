@extends('layouts.app')

@section('content')

<!-- ═══════════════════════════════════════════════════════
     1. HERO SECTION (Ultra-Modern Holographic & Cyber-Glow)
     ═══════════════════════════════════════════════════════ -->
<section id="hero" class="relative min-h-[92vh] flex flex-col items-center justify-center text-center px-4 pt-32 pb-20 overflow-hidden">
    
    <!-- Central Atmospheric Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[650px] h-[650px] bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none -z-10"></div>
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-cyan-500/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <div class="container relative z-10 max-w-5xl mx-auto flex flex-col items-center">
        
        <!-- Live Status Pill Badge -->
        <div class="reveal mb-8">
            <div class="badge badge-pulse-green px-4 py-2 shadow-[0_0_20px_rgba(16,185,129,0.2)] hover:scale-105 transition-transform cursor-default">
                <span class="pulse-dot"></span>
                <span class="font-medium text-xs md:text-sm tracking-wide">Tersedia untuk Projek Baru & Kolaborasi</span>
            </div>
        </div>

        <!-- 3D Hologram Avatar Frame with Floating Orbital Badges -->
        <div class="reveal reveal-delay-1 mb-8 relative inline-block">
            <div class="avatar-hologram-wrapper tilt-card spotlight-card">
                <!-- Rotating Conic Glow Aura -->
                <div class="avatar-conic-ring"></div>
                <div class="avatar-inner-ring"></div>
                
                <!-- Avatar Image Box -->
                <div class="avatar-image-box shadow-2xl">
                    @if($profile && $profile->avatar)
                        <img src="{{ asset('storage/' . $profile->avatar) }}" alt="{{ $profile->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900/60 to-purple-900/60 text-indigo-300 font-black text-6xl">
                            {{ substr($profile->name ?? 'MS', 0, 2) }}
                        </div>
                    @endif
                </div>

                <!-- Floating Orbital Badges -->
                <div class="floating-chip top-right">
                    <span class="text-accent-cyan">⚡</span>
                    <span>Clean Code</span>
                </div>
                <div class="floating-chip bottom-left">
                    <span class="text-accent-secondary">🚀</span>
                    <span>High Performance</span>
                </div>
            </div>
        </div>
        
        <!-- Main Title & Dynamic Role Typewriter -->
        <div class="reveal reveal-delay-2 max-w-4xl mx-auto">
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-black font-['Space_Grotesk'] tracking-tight mb-4 leading-tight">
                <span class="text-slate-200">Halo, Saya</span> <br class="hidden sm:inline"/>
                <span class="text-gradient">{{ $profile->name ?? 'Muhammad Syafiq' }}</span>
            </h1>
            
            <!-- Typewriter Dynamic Role Display -->
            @php
                $rawTitle = $profile->title ?? 'Full Stack Web Developer, Creative UI/UX Enthusiast, Mobile App Engineer, Modern Tech Architect';
                $rolesList = array_values(array_filter(array_map('trim', preg_split('/[,|]/', $rawTitle))));
                if (empty($rolesList)) {
                    $rolesList = ['Full Stack Web Developer', 'Creative UI/UX Enthusiast', 'Mobile App Engineer', 'Modern Tech Architect'];
                }
            @endphp
            <div class="text-xl sm:text-2xl md:text-3xl text-slate-300 font-semibold mb-6 flex items-center justify-center gap-2 flex-wrap min-h-[40px]">
                <span class="text-slate-400 font-normal">Seorang</span>
                <span id="role-typewriter" 
                      class="typewriter-text text-accent-cyan font-bold" 
                      data-roles="{{ json_encode($rolesList) }}">
                    {{ $rolesList[0] ?? 'Full Stack Web Developer' }}
                </span>
            </div>

            <p class="text-base sm:text-lg md:text-xl text-slate-400 max-w-2xl mx-auto font-light leading-relaxed mb-8">
                Menciptakan aplikasi web & mobile interaktif dengan estetika premium, kecepatan optimal, dan arsitektur kode modern.
            </p>
        </div>

        <!-- Sleek Digital Live Clock Widget -->
        <div class="reveal reveal-delay-3 flex justify-center mb-10 w-full" x-data="liveClockWidget()">
            <div class="glass-panel px-5 md:px-8 py-3 rounded-full flex items-center gap-4 border border-white/10 shadow-[0_0_25px_rgba(99,102,241,0.2)] bg-white/5 backdrop-blur-xl hover:border-indigo-500/50 hover:shadow-[0_0_35px_rgba(99,102,241,0.35)] transition-all duration-300">
                <div class="flex items-center gap-2.5 text-accent-cyan">
                    <span class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-ping"></span>
                    <span class="font-mono font-bold tracking-widest text-base md:text-lg" x-text="time">00:00:00</span>
                    <span class="text-[10px] uppercase font-bold text-slate-400 bg-white/10 px-2 py-0.5 rounded-md font-sans">WIB</span>
                </div>
                <div class="w-px h-5 bg-white/15"></div>
                <div class="flex items-center gap-2 text-slate-300 text-xs md:text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-400"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span x-text="date">Senin, 1 Jan 2026</span>
                </div>
            </div>
        </div>

        <script>
            function liveClockWidget() {
                return {
                    time: '',
                    date: '',
                    init() {
                        this.tick();
                        setInterval(() => this.tick(), 1000);
                    },
                    tick() {
                        const now = new Date();
                        this.time = now.toLocaleTimeString('id-ID', { hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
                        this.date = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' });
                    }
                }
            }
        </script>
        
        <!-- High-Impact Action CTAs -->
        <div class="reveal reveal-delay-3 flex flex-wrap justify-center gap-4 sm:gap-6 mb-12">
            <a href="#projects" class="btn btn-primary btn-shimmer btn-lg group shadow-xl">
                <span>Eksplorasi Projek</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            <a href="#contact" class="btn btn-outline btn-lg group">
                <i class='bx bx-paper-plane text-xl group-hover:rotate-12 transition-transform text-accent-cyan'></i>
                <span>Hubungi Saya</span>
            </a>
        </div>
        
        <!-- Social Icons Dock -->
        @if($profile && $profile->socialLinks && $profile->socialLinks->count() > 0)
        <div class="reveal reveal-delay-4 flex flex-wrap justify-center items-center gap-3 md:gap-4 pt-4">
            @foreach($profile->socialLinks as $link)
                <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-2xl flex items-center justify-center bg-white/5 hover:bg-gradient-to-tr hover:from-indigo-600 hover:to-purple-600 border border-white/10 hover:border-transparent text-slate-300 hover:text-white hover:-translate-y-1.5 hover:shadow-[0_0_25px_rgba(99,102,241,0.6)] transition-all duration-300" title="{{ $link->platform }}">
                    @if($link->icon)
                        <i class="{{ $link->icon }} text-xl"></i>
                    @else
                        <span class="font-bold text-sm">{{ substr($link->platform, 0, 2) }}</span>
                    @endif
                </a>
            @endforeach
        </div>
        @endif

    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     2. METRICS & STATS SECTION (Interactive 3D Bento Grid)
     ═══════════════════════════════════════════════════════ -->
<section class="py-12 relative z-10">
    <div class="container max-w-5xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center">
            
            <!-- Stat 1: Total Projects -->
            <div class="glass-card spotlight-card tilt-card p-8 rounded-3xl group border border-white/5 hover:border-indigo-500/40">
                <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                    <i class='bx bx-code-alt text-2xl'></i>
                </div>
                <div class="text-4xl md:text-5xl font-black font-['Space_Grotesk'] text-gradient mb-2 stat-counter" data-target="{{ $stats['projects'] ?? 0 }}">
                    {{ $stats['projects'] ?? 0 }}
                </div>
                <div class="text-slate-400 uppercase tracking-[0.2em] text-xs font-bold">Karya & Projek Selesai</div>
            </div>

            <!-- Stat 2: Downloads -->
            <div class="glass-card spotlight-card tilt-card p-8 rounded-3xl group border border-white/5 hover:border-cyan-500/40">
                <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300 shadow-[0_0_15px_rgba(6,182,212,0.2)]">
                    <i class='bx bx-download text-2xl'></i>
                </div>
                <div class="text-4xl md:text-5xl font-black font-['Space_Grotesk'] text-gradient-cyan mb-2 stat-counter" data-target="{{ $stats['downloads'] ?? 0 }}">
                    {{ $stats['downloads'] ?? 0 }}
                </div>
                <div class="text-slate-400 uppercase tracking-[0.2em] text-xs font-bold">Total Unduhan Source/APK</div>
            </div>

            <!-- Stat 3: Visitors -->
            <div class="glass-card spotlight-card tilt-card p-8 rounded-3xl group border border-white/5 hover:border-purple-500/40 sm:col-span-2 md:col-span-1">
                <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-300 shadow-[0_0_15px_rgba(168,85,247,0.2)]">
                    <i class='bx bx-group text-2xl'></i>
                </div>
                <div class="text-4xl md:text-5xl font-black font-['Space_Grotesk'] text-gradient mb-2 stat-counter" data-target="{{ $stats['visitors'] ?? 0 }}">
                    {{ $stats['visitors'] ?? 0 }}
                </div>
                <div class="text-slate-400 uppercase tracking-[0.2em] text-xs font-bold">Pengunjung Unik</div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     3. INFINITE TECH STACK MARQUEE
     ═══════════════════════════════════════════════════════ -->
<section class="py-10 relative overflow-hidden">
    <div class="marquee-container">
        <div class="marquee-content">
            <div class="tech-pill"><i class='bx bxl-php text-xl text-indigo-400'></i><span>PHP 8.x</span></div>
            <div class="tech-pill"><i class='bx bxl-vuejs text-xl text-emerald-400'></i><span>Vue.js</span></div>
            <div class="tech-pill"><i class='bx bxl-react text-xl text-cyan-400'></i><span>React</span></div>
            <div class="tech-pill"><i class='bx bxl-tailwind-css text-xl text-cyan-400'></i><span>Tailwind CSS</span></div>
            <div class="tech-pill"><i class='bx bxl-javascript text-xl text-amber-400'></i><span>JavaScript</span></div>
            <div class="tech-pill"><i class='bx bxl-flutter text-xl text-blue-400'></i><span>Flutter / Android</span></div>
            <div class="tech-pill"><i class='bx bxs-data text-xl text-blue-400'></i><span>MySQL / PostgreSQL</span></div>
            <div class="tech-pill"><i class='bx bxl-git text-xl text-rose-400'></i><span>Git & GitHub</span></div>
            <div class="tech-pill"><i class='bx bxl-docker text-xl text-cyan-400'></i><span>Docker</span></div>
            <div class="tech-pill"><i class='bx bx-server text-xl text-indigo-400'></i><span>RESTful API</span></div>
        </div>
        <div class="marquee-content" aria-hidden="true">
            <div class="tech-pill"><i class='bx bxl-php text-xl text-indigo-400'></i><span>PHP 8.x</span></div>
            <div class="tech-pill"><i class='bx bxl-vuejs text-xl text-emerald-400'></i><span>Vue.js</span></div>
            <div class="tech-pill"><i class='bx bxl-react text-xl text-cyan-400'></i><span>React</span></div>
            <div class="tech-pill"><i class='bx bxl-tailwind-css text-xl text-cyan-400'></i><span>Tailwind CSS</span></div>
            <div class="tech-pill"><i class='bx bxl-javascript text-xl text-amber-400'></i><span>JavaScript</span></div>
            <div class="tech-pill"><i class='bx bxl-flutter text-xl text-blue-400'></i><span>Flutter / Android</span></div>
            <div class="tech-pill"><i class='bx bxs-data text-xl text-blue-400'></i><span>MySQL / PostgreSQL</span></div>
            <div class="tech-pill"><i class='bx bxl-git text-xl text-rose-400'></i><span>Git & GitHub</span></div>
            <div class="tech-pill"><i class='bx bxl-docker text-xl text-cyan-400'></i><span>Docker</span></div>
            <div class="tech-pill"><i class='bx bx-server text-xl text-indigo-400'></i><span>RESTful API</span></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     4. ABOUT SECTION ("Tentang Saya")
     ═══════════════════════════════════════════════════════ -->
@if($profile && $profile->bio)
<section id="about" class="py-24 relative">
    <div class="container max-w-5xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3">Tentang Saya</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100">
                Dedikasi & <span class="text-gradient">Filosofi Kode</span>
            </h2>
        </div>
        
        <div class="reveal reveal-delay-1 relative group">
            <div class="glass-panel p-8 md:p-14 relative z-10 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-2xl">
                <!-- Verified Dev Badge -->
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs uppercase tracking-widest font-bold text-slate-400">Pengembang Terverifikasi</span>
                </div>
                
                <div class="text-lg md:text-xl text-slate-300 leading-relaxed font-light space-y-4">
                    {!! nl2br(e($profile->bio)) !!}
                </div>

                <!-- Bento Sub-Highlights -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-10 pt-10 border-t border-white/10">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                            <i class='bx bx-check-shield text-xl'></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-200">Arsitektur Bersih</div>
                            <div class="text-xs text-slate-400">Struktur rapi & teruji</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400">
                            <i class='bx bx-tachometer text-xl'></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-200">Kecepatan Tinggi</div>
                            <div class="text-xs text-slate-400">Optimasi performa & SEO</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                            <i class='bx bx-palette text-xl'></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-200">Desain Modern</div>
                            <div class="text-xs text-slate-400">UI/UX Memukau</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════════════
     5. TECHNICAL SKILLS SECTION ("Keahlian Teknis")
     ═══════════════════════════════════════════════════════ -->
@if(($profile->enable_skills ?? true) && count($skills) > 0)
<section id="skills" class="py-24 relative">
    <div class="container max-w-6xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3">Teknologi & Kemampuan</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100">
                Keahlian <span class="text-gradient">Teknis & Stack</span>
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($skills as $category => $categorySkills)
                <div class="reveal glass-card spotlight-card p-8 md:p-10 rounded-3xl border border-white/5 hover:border-indigo-500/30">
                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-white/10">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/15 flex items-center justify-center text-indigo-400 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                            <i class='bx bx-layer text-xl'></i>
                        </div>
                        <h3 class="text-2xl font-bold font-['Space_Grotesk'] text-slate-100">{{ $category }}</h3>
                    </div>

                    <div class="space-y-6">
                        @foreach($categorySkills as $skill)
                            <div class="group">
                                <div class="flex justify-between items-center mb-2 text-sm font-medium">
                                    <span class="text-slate-200 group-hover:text-indigo-400 transition-colors flex items-center gap-2">
                                        @if($skill->icon)
                                            <i class="{{ $skill->icon }} text-base text-indigo-400"></i>
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                                        @endif
                                        {{ $skill->name }}
                                    </span>
                                    <span class="font-mono font-bold text-accent-cyan text-xs md:text-sm">{{ $skill->proficiency }}%</span>
                                </div>
                                <div class="w-full h-2.5 bg-white/5 rounded-full overflow-hidden p-[1px] border border-white/5">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-400 rounded-full skill-progress-bar transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(99,102,241,0.5)]" 
                                         style="width: 0%;" 
                                         data-progress="{{ $skill->proficiency }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════════════
     5.5 JOURNEY & EXPERIENCE TIMELINE ("Perjalanan & Pengalaman")
     ═══════════════════════════════════════════════════════ -->
<section id="timeline" class="py-24 relative">
    <div class="container max-w-5xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3">Jejak & Pencapaian</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                Perjalanan <span class="text-gradient">& Pengalaman</span>
            </h2>
            <p class="text-slate-400 max-w-lg text-sm md:text-base">Garis waktu dedikasi, eksplorasi teknologi, dan peran dalam membangun produk digital berkualitas.</p>
        </div>

        <div class="timeline-container relative">
            <div class="timeline-connector-mobile md:hidden"></div>

            <div class="space-y-12 md:space-y-16">
                <!-- Milestone 1 -->
                <div class="reveal flex flex-col md:flex-row items-center gap-8 relative">
                    <!-- Dot (Desktop Center) -->
                    <div class="hidden md:block timeline-dot left-1/2 -translate-x-1/2 top-8 shadow-[0_0_15px_#6366f1]"></div>
                    <!-- Dot (Mobile Left) -->
                    <div class="md:hidden timeline-dot left-[6px] top-6 shadow-[0_0_15px_#6366f1]"></div>

                    <!-- Left Column (Content) -->
                    <div class="w-full md:w-1/2 md:pr-12 md:text-right">
                        <div class="glass-card spotlight-card tilt-card p-6 md:p-8 rounded-3xl border border-white/10 hover:border-indigo-500/40 group">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 text-xs font-bold font-mono mb-3">
                                <i class='bx bx-calendar'></i>
                                <span>2024 - Sekarang</span>
                            </div>
                            <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-indigo-400 transition-colors mb-2">
                                Freelance Fullstack & Mobile Developer
                            </h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Merancang dan mengembangkan solusi web kustom, sistem kasir inventori, aplikasi mobile Android (APK), integrasi payment gateway QRIS, dan otomatisasi bot WhatsApp untuk berbagai kebutuhan bisnis.
                            </p>
                            <div class="flex flex-wrap gap-1.5 mt-4 md:justify-end">
                                <span class="badge text-[11px] bg-white/5 text-slate-300">Laravel</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">Vue.js</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">Tailwind</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">MySQL</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Empty spacer for zigzag) -->
                    <div class="hidden md:block w-1/2"></div>
                </div>

                <!-- Milestone 2 -->
                <div class="reveal flex flex-col md:flex-row items-center gap-8 relative">
                    <!-- Dot -->
                    <div class="hidden md:block timeline-dot left-1/2 -translate-x-1/2 top-8 bg-cyan-400 shadow-[0_0_15px_#06b6d4]"></div>
                    <div class="md:hidden timeline-dot left-[6px] top-6 bg-cyan-400 shadow-[0_0_15px_#06b6d4]"></div>

                    <!-- Left Column (Spacer) -->
                    <div class="hidden md:block w-1/2"></div>

                    <!-- Right Column (Content) -->
                    <div class="w-full md:w-1/2 md:pl-12">
                        <div class="glass-card spotlight-card tilt-card p-6 md:p-8 rounded-3xl border border-white/10 hover:border-cyan-500/40 group">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-xs font-bold font-mono mb-3">
                                <i class='bx bx-calendar'></i>
                                <span>2023 - 2024</span>
                            </div>
                            <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-cyan-400 transition-colors mb-2">
                                Web App Architect & Modern Tech Explorer
                            </h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Fokus mendalami arsitektur modern web, RESTful API, dynamic UI/UX, optimasi SEO, serta membangun proyek open-source dan sistem manajemen berbasis cloud.
                            </p>
                            <div class="flex flex-wrap gap-1.5 mt-4">
                                <span class="badge text-[11px] bg-white/5 text-slate-300">REST API</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">JavaScript</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">Git Workflow</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Milestone 3 -->
                <div class="reveal flex flex-col md:flex-row items-center gap-8 relative">
                    <!-- Dot -->
                    <div class="hidden md:block timeline-dot left-1/2 -translate-x-1/2 top-8 bg-purple-400 shadow-[0_0_15px_#a855f7]"></div>
                    <div class="md:hidden timeline-dot left-[6px] top-6 bg-purple-400 shadow-[0_0_15px_#a855f7]"></div>

                    <!-- Left Column (Content) -->
                    <div class="w-full md:w-1/2 md:pr-12 md:text-right">
                        <div class="glass-card spotlight-card tilt-card p-6 md:p-8 rounded-3xl border border-white/10 hover:border-purple-500/40 group">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/30 text-purple-400 text-xs font-bold font-mono mb-3">
                                <i class='bx bx-calendar'></i>
                                <span>2022 - 2023</span>
                            </div>
                            <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-purple-400 transition-colors mb-2">
                                Pembelajaran Intensif & Sertifikasi
                            </h3>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Menyelesaikan berbagai pelatihan komprehensif di bidang pemrograman terstruktur, algoritma, database modeling, dan desain antarmuka pengguna (UI/UX).
                            </p>
                            <div class="flex flex-wrap gap-1.5 mt-4 md:justify-end">
                                <span class="badge text-[11px] bg-white/5 text-slate-300">Figma</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">HTML5/CSS3</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">Database Design</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Spacer) -->
                    <div class="hidden md:block w-1/2"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     6. PROJECTS SHOWCASE SECTION ("Projek Unggulan")
     ═══════════════════════════════════════════════════════ -->
@if($profile->enable_projects ?? true)
<section id="projects" class="py-24 relative">
    <div class="container max-w-6xl mx-auto">
        <div class="reveal flex flex-col items-center mb-12 text-center">
            <div class="badge mb-3">Portofolio Karya</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                Projek <span class="text-gradient">Unggulan & Rilis</span>
            </h2>
            <p class="text-slate-400 max-w-xl text-sm md:text-base">Pilihan aplikasi siap pakai, open-source, dan sistem skala produksi terbaik yang telah dibangun.</p>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($featuredProjects as $project)
                @php
                    $categoryTag = strtolower($project->category ?? 'web');
                    $tagsString = is_array($project->tech_stack) ? implode(' ', $project->tech_stack) : ($project->tech_stack ?? '');
                    if ($project->apk_path) {
                        $tagsString .= ' mobile apk android';
                    }
                @endphp
                <div class="reveal">
                    <div class="glass-card spotlight-card tilt-card rounded-3xl overflow-hidden border border-white/10 hover:border-indigo-500/40 flex flex-col h-full group justify-between">
                        
                        <div>
                            <!-- Thumbnail Box -->
                            <div class="relative h-52 overflow-hidden bg-primary-dark/80">
                                @if($project->thumbnail)
                                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transform group-hover:scale-108 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-600 group-hover:scale-105 transition-transform duration-700">
                                        <i class='bx bx-laptop text-5xl mb-2 text-indigo-400/50'></i>
                                        <span class="text-xs uppercase tracking-widest font-mono">Pratinjau Projek</span>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-primary-dark via-transparent to-transparent opacity-80 z-10"></div>
                                
                                <div class="absolute top-4 right-4 z-20">
                                    @if($project->zip_path || $project->apk_path)
                                        <div class="backdrop-blur-md bg-black/60 border border-white/10 text-emerald-400 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                                            <i class='bx bx-download'></i>
                                            <span>{{ $project->download_count }}x</span>
                                        </div>
                                    @endif
                                </div>

                                @if($project->apk_path)
                                    <div class="absolute top-4 left-4 z-20">
                                        <div class="backdrop-blur-md bg-cyan-950/80 border border-cyan-500/40 text-cyan-300 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 shadow-lg">
                                            <i class='bx bxl-android'></i>
                                            <span>APK Tersedia</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Box -->
                            <div class="p-6 md:p-7">
                                <div class="flex gap-1.5 flex-wrap mb-3">
                                    @foreach(array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                                        <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-white/5 text-slate-300 border border-white/5">{{ $tech }}</span>
                                    @endforeach
                                </div>

                                <h3 class="text-xl font-bold mb-2 font-['Space_Grotesk'] text-slate-100 group-hover:text-indigo-400 transition-colors line-clamp-1">
                                    {{ $project->title }}
                                </h3>

                                <p class="text-slate-400 text-xs line-clamp-2 leading-relaxed mb-4">
                                    {{ $project->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions Footer -->
                        <div class="p-6 pt-0 border-t border-white/5 flex items-center justify-between mt-auto">
                            <a href="{{ route('project.show', $project->slug) }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 flex items-center gap-1">
                                <span>Lihat Detail</span>
                                <i class='bx bx-right-arrow-alt text-base'></i>
                            </a>

                            <div class="flex items-center gap-2">
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500 hover:text-white flex items-center justify-center text-slate-300 transition-colors" title="Live Demo">
                                        <i class='bx bx-link-external text-sm'></i>
                                    </a>
                                @endif
                                @if($project->zip_path)
                                    <a href="{{ route('project.download', $project->id) }}" class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white flex items-center justify-center text-emerald-400 transition-colors" title="Download ZIP">
                                        <i class='bx bx-download text-sm'></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- View All Projects CTA Button -->
        <div class="reveal flex justify-center">
            <a href="{{ route('projects.all') }}" class="btn btn-outline py-3.5 px-8 rounded-full text-sm font-bold flex items-center gap-2 hover:border-indigo-500 hover:text-indigo-400 shadow-lg">
                <i class='bx bx-grid-alt text-lg'></i>
                <span>Jelajahi Seluruh Projek ({{ $stats['projects'] }})</span>
                <i class='bx bx-right-arrow-alt text-lg'></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════════════
     7. CERTIFICATES & AWARDS SECTION ("Sertifikat")
     ═══════════════════════════════════════════════════════ -->
@if(($profile->enable_certificates ?? true) && count($certificates) > 0)
<section id="certificates" class="py-24 relative">
    <div class="container max-w-6xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3">Pencapaian & Lisensi</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                Sertifikat & <span class="text-gradient">Penghargaan</span>
            </h2>
            <p class="text-slate-400 max-w-xl text-sm md:text-base">Pengakuan resmi atas keahlian dan kompetensi dalam pengembangan teknologi.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($certificates as $cert)
                <div class="reveal glass-card spotlight-card tilt-card rounded-3xl overflow-hidden border border-white/5 hover:border-purple-500/40 transition-all group flex flex-col justify-between">
                    <div>
                        @if($cert->image)
                            <div class="h-48 overflow-hidden relative bg-primary-dark/60">
                                <img src="{{ asset('storage/' . $cert->image) }}" alt="{{ $cert->title }}" class="w-full h-full object-cover transform group-hover:scale-108 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-primary-dark via-transparent to-transparent opacity-70"></div>
                            </div>
                        @endif
                        
                        <div class="p-6 md:p-7">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-bold text-accent-cyan uppercase tracking-wider">
                                    {{ $cert->date ? $cert->date->format('M Y') : 'Sertifikat' }}
                                </span>
                                @if($cert->issuer)
                                    <span class="text-xs font-semibold text-slate-400 flex items-center gap-1">
                                        <i class='bx bx-badge-check text-indigo-400'></i> {{ $cert->issuer }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-purple-400 transition-colors mb-3">
                                {{ $cert->title }}
                            </h3>

                            @if($cert->description)
                                <p class="text-slate-400 text-sm line-clamp-3 leading-relaxed mb-4">
                                    {{ $cert->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($cert->credential_url)
                        <div class="p-6 pt-0">
                            <a href="{{ $cert->credential_url }}" target="_blank" class="btn btn-outline btn-sm w-full rounded-xl flex items-center justify-center gap-2 hover:border-purple-500 text-xs">
                                <span>Verifikasi Kredensial</span>
                                <i class='bx bx-link-external'></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- View All Certificates CTA Button -->
        <div class="reveal flex justify-center">
            <a href="{{ route('certificates') }}" class="btn btn-outline py-3.5 px-8 rounded-full text-sm font-bold flex items-center gap-2 hover:border-purple-500 hover:text-purple-400 shadow-lg">
                <i class='bx bx-award text-lg'></i>
                <span>Buka Galeri Seluruh Sertifikat ({{ $totalCertificates }})</span>
                <i class='bx bx-right-arrow-alt text-lg'></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════════════
     7.5 PROJECT ESTIMATOR TEASER CTA BANNER
     ═══════════════════════════════════════════════════════ -->
<section class="py-16 relative">
    <div class="container max-w-5xl mx-auto px-4">
        <div class="reveal glass-panel p-8 sm:p-12 rounded-3xl border border-indigo-500/30 bg-gradient-to-r from-indigo-950/40 via-purple-950/30 to-indigo-950/40 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 text-xs font-bold font-mono mb-3">
                    <i class='bx bx-calculator'></i>
                    <span>Kalkulator Estimasi Biaya</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black font-['Space_Grotesk'] text-slate-100 mb-3 leading-tight">
                    Punya Ide Projek? <span class="text-gradient">Hitung Estimasi</span> Biayanya!
                </h2>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Pilih kategori aplikasi dan fitur yang Anda butuhkan untuk melihat perkiraan durasi pengerjaan dan estimasi investasi secara instan.
                </p>
            </div>

            <div class="flex-shrink-0">
                <a href="{{ route('estimator') }}" class="btn btn-primary btn-shimmer py-4 px-8 rounded-2xl text-sm font-bold flex items-center gap-2.5 shadow-xl hover:scale-105 transition-transform">
                    <i class='bx bx-calculator text-xl'></i>
                    <span>Buka Kalkulator Estimasi</span>
                    <i class='bx bx-right-arrow-alt text-xl'></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     8. PUBLIC WORKSPACE / GUESTBOOK ("Workspace Publik")
     ═══════════════════════════════════════════════════════ -->
<section id="workspace" class="py-24 relative">
    <div class="container max-w-6xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3">Buku Tamu Digital</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                Workspace <span class="text-gradient">Publik</span>
            </h2>
            <p class="text-slate-400 max-w-xl text-sm md:text-base">Tinggalkan jejak, sapaan, atau masukan untuk pengembang dan pengunjung lainnya secara langsung.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Catatan -->
            <div class="reveal lg:col-span-1">
                <div class="glass-panel p-6 md:p-8 rounded-3xl border border-white/10 sticky top-28 backdrop-blur-2xl shadow-2xl">
                    <div class="flex items-center gap-2.5 mb-3">
                        <span class="w-3 h-3 rounded-full bg-cyan-400 animate-ping"></span>
                        <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100">Kirim Catatan! 🚀</h3>
                    </div>
                    <p class="text-xs text-slate-400 mb-6">Pesan Anda akan tampil di feed publik portofolio ini.</p>
                    
                    @if(session('success_note'))
                        <div class="alert alert-success rounded-xl mb-6 text-sm py-3 px-4 flex items-center">
                            <i class='bx bx-check-circle text-lg mr-2'></i>
                            <span>{{ session('success_note') }}</span>
                        </div>
                    @endif
                    
                    <form action="{{ route('notes.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="form-label text-xs">Nama Anda</label>
                            <input type="text" name="name" class="form-control rounded-xl" required placeholder="Nama Anda / Samaran">
                        </div>
                        <div class="form-group mb-6">
                            <label class="form-label text-xs">Pesan Anda</label>
                            <textarea name="content" class="form-control rounded-xl min-h-[110px]" required placeholder="Tuliskan catatan atau sapaan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-shimmer w-full rounded-xl py-3.5 text-sm font-bold flex items-center justify-center gap-2 group">
                            <span>Kirim ke Papan Catatan</span>
                            <i class='bx bx-send text-base group-hover:translate-x-1 transition-transform'></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Daftar Catatan -->
            <div class="reveal reveal-delay-1 lg:col-span-2">
                @if($notes->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-h-[580px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(99, 102, 241, 0.5) transparent;">
                        @foreach($notes as $note)
                            <div class="glass-card p-6 rounded-2xl border border-white/5 hover:border-indigo-500/30 transition-all hover:-translate-y-1 group">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-white shadow-lg text-sm">
                                        {{ strtoupper(substr($note->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-100 text-sm group-hover:text-indigo-400 transition-colors">{{ $note->name }}</h4>
                                        <p class="text-[11px] text-slate-500 font-mono">{{ $note->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <p class="text-slate-300 text-sm leading-relaxed whitespace-pre-wrap font-light bg-black/20 p-3.5 rounded-xl border border-white/5">
                                    {{ $note->content }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-full min-h-[300px] text-center border border-dashed border-white/10 rounded-3xl p-8 bg-white/5">
                        <i class='bx bx-message-square-dots text-5xl text-slate-600 mb-3'></i>
                        <h4 class="text-lg font-bold text-slate-200 mb-1">Belum Ada Catatan</h4>
                        <p class="text-sm text-slate-400">Jadilah orang pertama yang menulis catatan di workspace ini!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     9. CONTACT SECTION ("Mari Berdiskusi")
     ═══════════════════════════════════════════════════════ -->
<section id="contact" class="py-24 relative overflow-hidden">
    <div class="container max-w-4xl mx-auto">
        <div class="reveal flex flex-col items-center mb-14 text-center">
            <div class="badge mb-3">Hubungi Langsung</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                Mari Mulai <span class="text-gradient">Kolaborasi</span>
            </h2>
            <p class="text-slate-400 max-w-lg text-sm md:text-base">Punya ide projek menarik, tawaran kerjasama, atau sekadar ingin berdiskusi? Jangan ragu untuk menghubungi saya.</p>
        </div>
        
        <!-- Direct Contact Pills -->
        @if($profile && ($profile->email || $profile->phone || $profile->location))
        <div class="reveal reveal-delay-1 flex flex-wrap justify-center gap-4 mb-12">
            @if($profile->email)
            <a href="mailto:{{ $profile->email }}" class="flex items-center gap-3 bg-white/5 border border-white/10 px-5 py-3 rounded-full hover:bg-indigo-500/20 hover:border-indigo-500/50 hover:scale-105 transition-all text-slate-300 hover:text-white">
                <i class='bx bx-envelope text-xl text-indigo-400'></i>
                <span class="text-sm font-semibold">{{ $profile->email }}</span>
            </a>
            @endif
            
            @if($profile->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone) }}" target="_blank" class="flex items-center gap-3 bg-white/5 border border-white/10 px-5 py-3 rounded-full hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:scale-105 transition-all text-slate-300 hover:text-white">
                <i class='bx bxl-whatsapp text-xl text-emerald-400'></i>
                <span class="text-sm font-semibold">{{ $profile->phone }}</span>
            </a>
            @endif
            
            @if($profile->location)
            <div class="flex items-center gap-3 bg-white/5 border border-white/10 px-5 py-3 rounded-full text-slate-400">
                <i class='bx bx-map-pin text-xl text-slate-400'></i>
                <span class="text-sm font-semibold">{{ $profile->location }}</span>
            </div>
            @endif
        </div>
        @endif
        
        <!-- Main Contact Form Box -->
        <div class="reveal reveal-delay-2 glass-panel p-8 md:p-12 rounded-3xl border border-white/10 shadow-2xl relative">
            
            @if(session('success'))
                <div class="alert alert-success rounded-2xl mb-8">
                    <i class='bx bx-check-circle text-2xl mr-2'></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            <form action="{{ route('contact.send') }}" method="POST" class="relative z-10">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="form-group mb-0">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-xl" required placeholder="Contoh: Alex Pratama">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control rounded-xl" required placeholder="alex@example.com">
                    </div>
                </div>
                
                <div class="form-group mb-6">
                    <label class="form-label">Subjek / Topik</label>
                    <input type="text" name="subject" class="form-control rounded-xl" placeholder="Tawaran Kerjasama / Projek Web">
                </div>

                <div class="form-group mb-8">
                    <label class="form-label">Pesan Anda</label>
                    <textarea name="message" class="form-control rounded-xl min-h-[140px]" required placeholder="Jelaskan kebutuhan, ide, atau pertanyaan Anda..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-shimmer w-full rounded-2xl py-4 text-base font-bold flex items-center justify-center gap-2 group shadow-xl">
                    <span>Kirim Pesan Sekarang</span>
                    <i class='bx bx-send text-xl group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform'></i>
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
