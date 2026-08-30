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

        <!-- 3D Hologram Avatar Frame with Floating Orbital Badges -->
        <div class="reveal mb-8 relative inline-block">
            <div class="avatar-hologram-wrapper tilt-card spotlight-card">
                <!-- Rotating Conic Glow Aura -->
                <div class="avatar-conic-ring"></div>
                <div class="avatar-inner-ring"></div>
                
                <!-- Avatar Image Box -->
                <div class="avatar-image-box shadow-2xl">
                    @if($profile && $profile->avatar)
                        <img src="{{ asset('storage/' . $profile->avatar) }}" alt="{{ $profile->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900/60 to-purple-900/60 text-indigo-300 font-black text-5xl tracking-wider">
                            MSS
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
        <div class="reveal reveal-delay-1 max-w-4xl mx-auto">
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-black font-['Space_Grotesk'] tracking-tight mb-4 leading-tight">
                <span class="text-slate-200" x-text="$store.lang?.current === 'en' ? 'Hi, I am' : 'Halo, Saya'">Halo, Saya</span> <br class="hidden sm:inline"/>
                <span class="text-gradient">{{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}</span>
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
                <span class="text-slate-400 font-normal" x-text="$store.lang?.current === 'en' ? 'A passionate' : 'Seorang'">Seorang</span>
                <span id="role-typewriter" 
                      class="typewriter-text text-accent-cyan font-bold" 
                      data-roles="{{ json_encode($rolesList) }}">
                    {{ $rolesList[0] ?? 'Full Stack Web Developer' }}
                </span>
            </div>

            <p class="text-base sm:text-lg md:text-xl text-slate-400 max-w-2xl mx-auto font-light leading-relaxed mb-8"
               x-text="$store.lang?.current === 'en' ? 'Crafting interactive web & mobile applications with premium aesthetics, optimal speed, and clean code architecture.' : 'Menciptakan aplikasi web & mobile interaktif dengan estetika premium, kecepatan optimal, dan arsitektur kode modern.'">
                Menciptakan aplikasi web & mobile interaktif dengan estetika premium, kecepatan optimal, dan arsitektur kode modern.
            </p>
        </div>

        <!-- Sleek Digital Live Clock Widget -->
        <div class="reveal reveal-delay-2 flex justify-center mb-10 w-full" x-data="liveClockWidget()">
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
                <span x-text="$store.lang?.current === 'en' ? 'Explore Projects' : 'Eksplorasi Projek'">Eksplorasi Projek</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            <a href="#contact" class="btn btn-outline btn-lg group">
                <i class='bx bx-paper-plane text-xl group-hover:rotate-12 transition-transform text-accent-cyan'></i>
                <span x-text="$store.lang?.current === 'en' ? 'Get in Touch' : 'Hubungi Saya'">Hubungi Saya</span>
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
                <div class="text-slate-400 uppercase tracking-[0.2em] text-xs font-bold" x-text="$store.lang?.current === 'en' ? 'Completed Works & Projects' : 'Karya & Projek Selesai'">Karya & Projek Selesai</div>
            </div>

            <!-- Stat 2: Downloads -->
            <div class="glass-card spotlight-card tilt-card p-8 rounded-3xl group border border-white/5 hover:border-cyan-500/40">
                <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300 shadow-[0_0_15px_rgba(6,182,212,0.2)]">
                    <i class='bx bx-download text-2xl'></i>
                </div>
                <div class="text-4xl md:text-5xl font-black font-['Space_Grotesk'] text-gradient-cyan mb-2 stat-counter" data-target="{{ $stats['downloads'] ?? 0 }}">
                    {{ $stats['downloads'] ?? 0 }}
                </div>
                <div class="text-slate-400 uppercase tracking-[0.2em] text-xs font-bold" x-text="$store.lang?.current === 'en' ? 'Total Source & APK Downloads' : 'Total Unduhan Source/APK'">Total Unduhan Source/APK</div>
            </div>

            <!-- Stat 3: Visitors -->
            <div class="glass-card spotlight-card tilt-card p-8 rounded-3xl group border border-white/5 hover:border-purple-500/40 sm:col-span-2 md:col-span-1">
                <div class="w-12 h-12 mx-auto mb-4 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 group-hover:bg-purple-500 group-hover:text-white transition-all duration-300 shadow-[0_0_15px_rgba(168,85,247,0.2)]">
                    <i class='bx bx-group text-2xl'></i>
                </div>
                <div class="text-4xl md:text-5xl font-black font-['Space_Grotesk'] text-gradient mb-2 stat-counter" data-target="{{ $stats['visitors'] ?? 0 }}">
                    {{ $stats['visitors'] ?? 0 }}
                </div>
                <div class="text-slate-400 uppercase tracking-[0.2em] text-xs font-bold" x-text="$store.lang?.current === 'en' ? 'Unique Visitors' : 'Pengunjung Unik'">Pengunjung Unik</div>
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
            <div class="badge mb-3" x-text="$store.lang?.current === 'en' ? 'About Me' : 'Tentang Saya'">Tentang Saya</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100">
                <span x-text="$store.lang?.current === 'en' ? 'Dedication &' : 'Dedikasi &'">Dedikasi &</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Code Philosophy' : 'Filosofi Kode'">Filosofi Kode</span>
            </h2>
        </div>
        
        <div class="reveal reveal-delay-1 relative group">
            <div class="glass-panel p-8 md:p-14 relative z-10 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-2xl">
                <!-- Verified Dev Badge -->
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs uppercase tracking-widest font-bold text-slate-400" x-text="$store.lang?.current === 'en' ? 'Verified Software Engineer' : 'Pengembang Terverifikasi'">Pengembang Terverifikasi</span>
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
                            <div class="text-sm font-bold text-slate-200" x-text="$store.lang?.current === 'en' ? 'Clean Architecture' : 'Arsitektur Bersih'">Arsitektur Bersih</div>
                            <div class="text-xs text-slate-400" x-text="$store.lang?.current === 'en' ? 'Robust & maintainable' : 'Struktur rapi & teruji'">Struktur rapi & teruji</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400">
                            <i class='bx bx-tachometer text-xl'></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-200" x-text="$store.lang?.current === 'en' ? 'High Speed' : 'Kecepatan Tinggi'">Kecepatan Tinggi</div>
                            <div class="text-xs text-slate-400" x-text="$store.lang?.current === 'en' ? 'Optimized performance & SEO' : 'Optimasi performa & SEO'">Optimasi performa & SEO</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                            <i class='bx bx-palette text-xl'></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-200" x-text="$store.lang?.current === 'en' ? 'Modern Design' : 'Desain Modern'">Desain Modern</div>
                            <div class="text-xs text-slate-400" x-text="$store.lang?.current === 'en' ? 'Stunning UI/UX' : 'UI/UX Memukau'">UI/UX Memukau</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════════════
     5. CLEAN CODE SNIPPET / MOCKUP EDITOR SHOWCASE (Nomor 5)
     ═══════════════════════════════════════════════════════ -->
<section class="py-16 relative">
    <div class="container max-w-5xl mx-auto px-4" x-data="{ activeTab: 'php' }">
        <div class="reveal flex flex-col items-center mb-12 text-center">
            <div class="badge mb-3">Live Code Preview</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-2">
                <span x-text="$store.lang?.current === 'en' ? 'Engineered for' : 'Arsitektur'">Arsitektur</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Performance & Scalability' : 'Performa & Kecepatan'">Performa & Kecepatan</span>
            </h2>
            <p class="text-slate-400 text-sm md:text-base max-w-lg" x-text="$store.lang?.current === 'en' ? 'A glimpse into the clean, modern structure powering my digital solutions.' : 'Cuplikan struktur kode bersih, teruji, dan modular yang digunakan dalam membangun solusi aplikasi.'">
                Cuplikan struktur kode bersih, teruji, dan modular yang digunakan dalam membangun solusi aplikasi.
            </p>
        </div>

        <div class="reveal glass-panel rounded-3xl border border-white/10 overflow-hidden shadow-2xl bg-[#0a0a12]/95 backdrop-blur-2xl">
            <!-- Mockup Editor Title Bar -->
            <div class="flex items-center justify-between px-6 py-4 bg-black/40 border-b border-white/10">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500/80 inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500/80 inline-block"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
                    <span class="text-xs font-mono text-slate-400 ml-3 font-semibold">VS Code Studio • MSS Developer</span>
                </div>

                <!-- Tabs -->
                <div class="flex items-center gap-2">
                    <button @click="activeTab = 'php'" 
                            class="px-3 py-1 rounded-lg text-xs font-mono font-bold transition-all cursor-pointer flex items-center gap-1.5"
                            :class="activeTab === 'php' ? 'bg-indigo-600/30 text-indigo-300 border border-indigo-500/40' : 'text-slate-400 hover:text-white'">
                        <i class='bx bxl-php text-base'></i>
                        <span>ProjectController.php</span>
                    </button>
                    <button @click="activeTab = 'vue'" 
                            class="px-3 py-1 rounded-lg text-xs font-mono font-bold transition-all cursor-pointer flex items-center gap-1.5"
                            :class="activeTab === 'vue' ? 'bg-emerald-600/30 text-emerald-300 border border-emerald-500/40' : 'text-slate-400 hover:text-white'">
                        <i class='bx bxl-vuejs text-base'></i>
                        <span>AppExperience.vue</span>
                    </button>
                </div>
            </div>

            <!-- Code Content Area -->
            <div class="p-6 md:p-8 font-mono text-xs sm:text-sm leading-relaxed overflow-x-auto text-slate-300">
                <div x-show="activeTab === 'php'">
                    <p class="text-slate-500">// Modern Laravel 11 Clean Controller Architecture</p>
                    <p><span class="text-purple-400 font-bold">namespace</span> <span class="text-cyan-300">App\Http\Controllers</span>;</p>
                    <br>
                    <p><span class="text-purple-400 font-bold">class</span> <span class="text-amber-300 font-bold">PortfolioEngine</span> <span class="text-purple-400 font-bold">extends</span> <span class="text-cyan-300">Controller</span> {</p>
                    <p class="pl-4"><span class="text-purple-400 font-bold">public function</span> <span class="text-blue-400 font-bold">deployHighPerformanceApp</span>(<span class="text-cyan-300">ProjectRequest</span> <span class="text-indigo-300">$request</span>): <span class="text-emerald-400">JsonResponse</span> {</p>
                    <p class="pl-8"><span class="text-indigo-300">$app</span> = <span class="text-cyan-300">Application</span>::<span class="text-blue-400">createWithStrictSecurity</span>([</p>
                    <p class="pl-12"><span class="text-amber-200">'architect'</span> => <span class="text-emerald-300">'Mhd. Syafiq Syahmi'</span>,</p>
                    <p class="pl-12"><span class="text-amber-200">'performance'</span> => <span class="text-emerald-300">'100/100 Google PageSpeed'</span>,</p>
                    <p class="pl-12"><span class="text-amber-200">'stack'</span> => [<span class="text-amber-200">'Laravel 11'</span>, <span class="text-amber-200">'Vue.js'</span>, <span class="text-amber-200">'Tailwind'</span>, <span class="text-amber-200">'MySQL'</span>],</p>
                    <p class="pl-12"><span class="text-amber-200">'status'</span> => <span class="text-amber-200">'Production Ready 🚀'</span></p>
                    <p class="pl-8">]);</p>
                    <br>
                    <p class="pl-8"><span class="text-purple-400 font-bold">return</span> <span class="text-cyan-300">response</span>()-><span class="text-blue-400">json</span>([<span class="text-amber-200">'success'</span> => <span class="text-purple-400">true</span>, <span class="text-amber-200">'data'</span> => <span class="text-indigo-300">$app</span>]);</p>
                    <p class="pl-4">}</p>
                    <p>}</p>
                </div>

                <div x-show="activeTab === 'vue'" style="display: none;">
                    <p class="text-slate-500">&lt;!-- Reactive State & Cyber Glassmorphism UI Engine --&gt;</p>
                    <p>&lt;<span class="text-purple-400 font-bold">script setup</span>&gt;</p>
                    <p><span class="text-purple-400 font-bold">import</span> { <span class="text-cyan-300">ref</span>, <span class="text-cyan-300">onMounted</span> } <span class="text-purple-400 font-bold">from</span> <span class="text-amber-300">'vue'</span>;</p>
                    <br>
                    <p><span class="text-purple-400 font-bold">const</span> <span class="text-indigo-300">developer</span> = <span class="text-cyan-300">ref</span>({</p>
                    <p class="pl-4">name: <span class="text-emerald-300">'Mhd. Syafiq Syahmi'</span>,</p>
                    <p class="pl-4">mission: <span class="text-emerald-300">'Deliver ultra-responsive, state-of-the-art web products.'</span>,</p>
                    <p class="pl-4">availability: <span class="text-purple-400 font-bold">true</span></p>
                    <p>});</p>
                    <br>
                    <p><span class="text-cyan-300">onMounted</span>(() =&gt; {</p>
                    <p class="pl-4"><span class="text-blue-400">console</span>.<span class="text-blue-400">log</span>(<span class="text-emerald-300">'✨ Welcome to MSyafiq Portfolio Studio!'</span>);</p>
                    <p>});</p>
                    <p>&lt;/<span class="text-purple-400 font-bold">script</span>&gt;</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     5.5 TECHNICAL SKILLS SECTION ("Keahlian Teknis")
     ═══════════════════════════════════════════════════════ -->
@if(($profile->enable_skills ?? true) && count($skills) > 0)
<section id="skills" class="py-24 relative">
    <div class="container max-w-6xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3" x-text="$store.lang?.current === 'en' ? 'Tech Stack & Capabilities' : 'Teknologi & Kemampuan'">Teknologi & Kemampuan</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100">
                <span x-text="$store.lang?.current === 'en' ? 'Technical' : 'Keahlian'">Keahlian</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Skills & Stack' : 'Teknis & Stack'">Teknis & Stack</span>
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
     5.6 JOURNEY & EXPERIENCE TIMELINE ("Perjalanan & Pengalaman")
     ═══════════════════════════════════════════════════════ -->
<section id="timeline" class="py-24 relative">
    <div class="container max-w-5xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3" x-text="$store.lang?.current === 'en' ? 'Milestones & Career' : 'Jejak & Pencapaian'">Jejak & Pencapaian</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                <span x-text="$store.lang?.current === 'en' ? 'Journey &' : 'Perjalanan'">Perjalanan</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Experience' : '& Pengalaman'">& Pengalaman</span>
            </h2>
            <p class="text-slate-400 max-w-lg text-sm md:text-base" x-text="$store.lang?.current === 'en' ? 'Timeline of dedication, technological exploration, and building digital products.' : 'Garis waktu dedikasi, eksplorasi teknologi, dan peran dalam membangun produk digital berkualitas.'">Garis waktu dedikasi, eksplorasi teknologi, dan peran dalam membangun produk digital berkualitas.</p>
        </div>

        <div class="timeline-container relative">
            <div class="timeline-connector-mobile md:hidden"></div>

            <div class="space-y-12 md:space-y-16">
                <!-- Milestone 1 -->
                <div class="reveal flex flex-col md:flex-row items-center gap-8 relative">
                    <div class="hidden md:block timeline-dot left-1/2 -translate-x-1/2 top-8 shadow-[0_0_15px_#6366f1]"></div>
                    <div class="md:hidden timeline-dot left-[6px] top-6 shadow-[0_0_15px_#6366f1]"></div>

                    <div class="w-full md:w-1/2 md:pr-12 md:text-right">
                        <div class="glass-card spotlight-card tilt-card p-6 md:p-8 rounded-3xl border border-white/10 hover:border-indigo-500/40 group">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 text-xs font-bold font-mono mb-3">
                                <i class='bx bx-calendar'></i>
                                <span x-text="$store.lang?.current === 'en' ? '2024 - Present' : '2024 - Sekarang'">2024 - Sekarang</span>
                            </div>
                            <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-indigo-400 transition-colors mb-2">
                                Freelance Fullstack & Mobile Developer
                            </h3>
                            <p class="text-sm text-slate-400 leading-relaxed" x-text="$store.lang?.current === 'en' ? 'Designing and delivering custom web solutions, POS inventory systems, Android APK mobile apps, QRIS payment gateway integration, and automated WhatsApp bots.' : 'Merancang dan mengembangkan solusi web kustom, sistem kasir inventori, aplikasi mobile Android (APK), integrasi payment gateway QRIS, dan otomatisasi bot WhatsApp untuk berbagai kebutuhan bisnis.'">
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

                    <div class="hidden md:block w-1/2"></div>
                </div>

                <!-- Milestone 2 -->
                <div class="reveal flex flex-col md:flex-row items-center gap-8 relative">
                    <div class="hidden md:block timeline-dot left-1/2 -translate-x-1/2 top-8 bg-cyan-400 shadow-[0_0_15px_#06b6d4]"></div>
                    <div class="md:hidden timeline-dot left-[6px] top-6 bg-cyan-400 shadow-[0_0_15px_#06b6d4]"></div>

                    <div class="hidden md:block w-1/2"></div>

                    <div class="w-full md:w-1/2 md:pl-12">
                        <div class="glass-card spotlight-card tilt-card p-6 md:p-8 rounded-3xl border border-white/10 hover:border-cyan-500/40 group">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-xs font-bold font-mono mb-3">
                                <i class='bx bx-calendar'></i>
                                <span>2023 - 2024</span>
                            </div>
                            <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-cyan-400 transition-colors mb-2">
                                Web App Architect & Modern Tech Explorer
                            </h3>
                            <p class="text-sm text-slate-400 leading-relaxed" x-text="$store.lang?.current === 'en' ? 'Focusing on modern web architecture, RESTful API design, interactive UI/UX, SEO optimizations, and building production-grade cloud systems.' : 'Fokus mendalami arsitektur modern web, RESTful API, dynamic UI/UX, optimasi SEO, serta membangun proyek open-source dan sistem manajemen berbasis cloud.'">
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
                    <div class="hidden md:block timeline-dot left-1/2 -translate-x-1/2 top-8 bg-purple-400 shadow-[0_0_15px_#a855f7]"></div>
                    <div class="md:hidden timeline-dot left-[6px] top-6 bg-purple-400 shadow-[0_0_15px_#a855f7]"></div>

                    <div class="w-full md:w-1/2 md:pr-12 md:text-right">
                        <div class="glass-card spotlight-card tilt-card p-6 md:p-8 rounded-3xl border border-white/10 hover:border-purple-500/40 group">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/30 text-purple-400 text-xs font-bold font-mono mb-3">
                                <i class='bx bx-calendar'></i>
                                <span>2022 - 2023</span>
                            </div>
                            <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-purple-400 transition-colors mb-2" x-text="$store.lang?.current === 'en' ? 'Intensive Tech Training & Certifications' : 'Pembelajaran Intensif & Sertifikasi'">
                                Pembelajaran Intensif & Sertifikasi
                            </h3>
                            <p class="text-sm text-slate-400 leading-relaxed" x-text="$store.lang?.current === 'en' ? 'Completing comprehensive courses in structured programming, algorithms, database architecture, and user interface design (UI/UX).' : 'Menyelesaikan berbagai pelatihan komprehensif di bidang pemrograman terstruktur, algoritma, database modeling, dan desain antarmuka pengguna (UI/UX).'">
                                Menyelesaikan berbagai pelatihan komprehensif di bidang pemrograman terstruktur, algoritma, database modeling, dan desain antarmuka pengguna (UI/UX).
                            </p>
                            <div class="flex flex-wrap gap-1.5 mt-4 md:justify-end">
                                <span class="badge text-[11px] bg-white/5 text-slate-300">Figma</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">HTML5/CSS3</span>
                                <span class="badge text-[11px] bg-white/5 text-slate-300">Database Design</span>
                            </div>
                        </div>
                    </div>

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
            <div class="badge mb-3" x-text="$store.lang?.current === 'en' ? 'Featured Portfolio' : 'Portofolio Karya'">Portofolio Karya</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                <span x-text="$store.lang?.current === 'en' ? 'Featured' : 'Projek'">Projek</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Projects & Releases' : 'Unggulan & Rilis'">Unggulan & Rilis</span>
            </h2>
            <p class="text-slate-400 max-w-xl text-sm md:text-base" x-text="$store.lang?.current === 'en' ? 'Curated selection of production-grade web apps, APKs, and open-source systems.' : 'Pilihan aplikasi siap pakai, open-source, dan sistem skala produksi terbaik yang telah dibangun.'">Pilihan aplikasi siap pakai, open-source, dan sistem skala produksi terbaik yang telah dibangun.</p>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($featuredProjects as $project)
                <div class="reveal">
                    <div class="glass-card spotlight-card tilt-card rounded-3xl overflow-hidden border border-white/10 hover:border-indigo-500/40 flex flex-col h-full group justify-between">
                        
                        <div>
                            <!-- Thumbnail Box -->
                            <div class="relative h-52 overflow-hidden bg-[#0c0c14]">
                                @if($project->thumbnail)
                                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-600 group-hover:scale-105 transition-transform duration-700">
                                        <i class='bx bx-laptop text-5xl mb-2 text-indigo-400/50'></i>
                                        <span class="text-xs uppercase tracking-widest font-mono">Pratinjau Projek</span>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-[#060609] via-transparent to-transparent opacity-80 z-10 pointer-events-none"></div>
                                
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
                                            <span>APK Ready</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Box -->
                            <div class="p-6 md:p-7">
                                <div class="flex gap-1.5 flex-wrap mb-3">
                                    @foreach(array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-white/5 text-slate-300 border border-white/5">{{ $tech }}</span>
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
                                <span x-text="$store.lang?.current === 'en' ? 'View Details' : 'Lihat Detail'">Lihat Detail</span>
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
                <span x-text="$store.lang?.current === 'en' ? 'Browse All Projects ({{ $stats[\'projects\'] ?? 0 }})' : 'Jelajahi Seluruh Projek ({{ $stats[\'projects\'] ?? 0 }})'">Jelajahi Seluruh Projek ({{ $stats['projects'] ?? 0 }})</span>
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
            <div class="badge mb-3" x-text="$store.lang?.current === 'en' ? 'Credentials & Awards' : 'Pencapaian & Lisensi'">Pencapaian & Lisensi</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                <span x-text="$store.lang?.current === 'en' ? 'Certificates &' : 'Sertifikat &'">Sertifikat &</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Honors' : 'Penghargaan'">Penghargaan</span>
            </h2>
            <p class="text-slate-400 max-w-xl text-sm md:text-base" x-text="$store.lang?.current === 'en' ? 'Official recognition of expertise and competence in tech development.' : 'Pengakuan resmi atas keahlian dan kompetensi dalam pengembangan teknologi.'">Pengakuan resmi atas keahlian dan kompetensi dalam pengembangan teknologi.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($certificates as $cert)
                <div class="reveal glass-card spotlight-card tilt-card rounded-3xl overflow-hidden border border-white/5 hover:border-purple-500/40 transition-all group flex flex-col justify-between">
                    <div>
                        @if($cert->image)
                            <div class="h-48 overflow-hidden relative bg-[#0c0c14]">
                                <img src="{{ asset('storage/' . $cert->image) }}" alt="{{ $cert->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#060609] via-transparent to-transparent opacity-70"></div>
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
                                <span x-text="$store.lang?.current === 'en' ? 'Verify Credential' : 'Verifikasi Kredensial'">Verifikasi Kredensial</span>
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
                <span x-text="$store.lang?.current === 'en' ? 'Open Certificates Gallery ({{ $totalCertificates ?? count($certificates) }})' : 'Buka Galeri Seluruh Sertifikat ({{ $totalCertificates ?? count($certificates) }})'">Buka Galeri Seluruh Sertifikat ({{ $totalCertificates ?? count($certificates) }})</span>
                <i class='bx bx-right-arrow-alt text-lg'></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ═══════════════════════════════════════════════════════
     8. INTERACTIVE FAQ ACCORDION SECTION (Nomor 4)
     ═══════════════════════════════════════════════════════ -->
<section id="faq" class="py-24 relative" x-data="{ activeFaq: 1 }">
    <div class="container max-w-4xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3" x-text="$store.lang?.current === 'en' ? 'FAQ & Inquiries' : 'Tanya Jawab Umum'">Tanya Jawab Umum</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                <span x-text="$store.lang?.current === 'en' ? 'Frequently' : 'Pertanyaan'">Pertanyaan</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Asked Questions' : 'yang Sering Diajukan'">yang Sering Diajukan</span>
            </h2>
            <p class="text-slate-400 max-w-xl text-sm md:text-base" x-text="$store.lang?.current === 'en' ? 'Everything you need to know about project workflows, revisions, warranties, and deployment.' : 'Semua hal penting seputar alur kerjasama, revisi, garansi, dan proses pengerjaan projek.'">
                Semua hal penting seputar alur kerjasama, revisi, garansi, dan proses pengerjaan projek.
            </p>
        </div>

        <div class="space-y-4">
            <!-- FAQ 1 -->
            <div class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xs font-bold font-mono">01</span>
                        <span x-text="$store.lang?.current === 'en' ? 'How long does a website or mobile app project take?' : 'Berapa lama estimasi waktu pengerjaan projek website/aplikasi?'">Berapa lama estimasi waktu pengerjaan projek website/aplikasi?</span>
                    </span>
                    <i class="bx text-2xl text-indigo-400 transition-transform duration-300" :class="activeFaq === 1 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 1" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'It depends on the complexity of features. Simple landing pages take 3-7 workdays, company profiles take 7-14 days, while full-scale custom web applications, SaaS, or e-commerce systems typically take 2-4 weeks.' : 'Tergantung pada kompleksitas fitur. Landing page promosi berkisar 3-7 hari kerja, website company profile 7-14 hari, sedangkan custom web application/SaaS/toko online sistem penuh sekitar 2-4 minggu dengan milestone terstruktur.'">
                        Tergantung pada kompleksitas fitur. Landing page promosi berkisar 3-7 hari kerja, website company profile 7-14 hari, sedangkan custom web application/SaaS/toko online sistem penuh sekitar 2-4 minggu dengan milestone terstruktur.
                    </p>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xs font-bold font-mono">02</span>
                        <span x-text="$store.lang?.current === 'en' ? 'Do I get the complete source code and full ownership?' : 'Apakah saya mendapatkan source code lengkap & hak milik penuh?'">Apakah saya mendapatkan source code lengkap & hak milik penuh?</span>
                    </span>
                    <i class="bx text-2xl text-cyan-400 transition-transform duration-300" :class="activeFaq === 2 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 2" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Yes, 100%! Upon project handover and final payment, all source code repositories (ZIP/GitHub), database schemas, design assets, and administrative credentials are fully transferred to you without hidden dependencies.' : 'Ya, 100%! Setelah pelunasan dan serah terima projek, seluruh repositori source code (ZIP/GitHub), skema database, aset desain, dan kredensial admin sistem diserahkan penuh kepada Anda tanpa ikatan dependensi tersembunyi.'">
                        Ya, 100%! Setelah pelunasan dan serah terima projek, seluruh repositori source code (ZIP/GitHub), skema database, aset desain, dan kredensial admin sistem diserahkan penuh kepada Anda tanpa ikatan dependensi tersembunyi.
                    </p>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center text-xs font-bold font-mono">03</span>
                        <span x-text="$store.lang?.current === 'en' ? 'What is the payment structure and revision policy?' : 'Bagaimana tahapan pembayaran dan kebijakan revisi projek?'">Bagaimana tahapan pembayaran dan kebijakan revisi projek?</span>
                    </span>
                    <i class="bx text-2xl text-purple-400 transition-transform duration-300" :class="activeFaq === 3 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 3" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Payments are milestone-based (typically 40-50% upfront to initiate development, remainder upon demo approval). We provide free revisions during development to guarantee output matches your initial scope agreement.' : 'Pembayaran dilakukan bertahap (DP 40-50% di awal untuk mulai development, sisa pelunasan setelah live demo lolos uji coba Anda). Kami memberikan revisi gratis hingga hasil sesuai kesepakatan rancangan awal.'">
                        Pembayaran dilakukan bertahap (DP 40-50% di awal untuk mulai development, sisa pelunasan setelah live demo lolos uji coba Anda). Kami memberikan revisi gratis hingga hasil sesuai kesepakatan rancangan awal.
                    </p>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 4 ? null : 4" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold font-mono">04</span>
                        <span x-text="$store.lang?.current === 'en' ? 'Is there a bug-fix warranty and after-sales support?' : 'Apakah ada garansi perbaikan bug dan pendampingan setelah rilis?'">Apakah ada garansi perbaikan bug dan pendampingan setelah rilis?</span>
                    </span>
                    <i class="bx text-2xl text-emerald-400 transition-transform duration-300" :class="activeFaq === 4 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 4" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Absolutely! Every completed project includes a 30-day free bug-fix warranty and technical maintenance assistance to ensure everything runs smoothly in production.' : 'Tentu saja! Setiap projek yang selesai mendapatkan garansi bebas bug gratis selama 30 hari kalender serta pendampingan teknis agar sistem berjalan stabil di server produksi.'">
                        Tentu saja! Setiap projek yang selesai mendapatkan garansi bebas bug gratis selama 30 hari kalender serta pendampingan teknis agar sistem berjalan stabil di server produksi.
                    </p>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 5 ? null : 5" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center text-xs font-bold font-mono">05</span>
                        <span x-text="$store.lang?.current === 'en' ? 'Can you assist with server deployment and domain configuration?' : 'Apakah bisa mendampingi setup hosting, VPS & domain kustom?'">Apakah bisa mendampingi setup hosting, VPS & domain kustom?</span>
                    </span>
                    <i class="bx text-2xl text-amber-400 transition-transform duration-300" :class="activeFaq === 5 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 5" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Yes, we provide end-to-end deployment assistance: setting up your custom domain (.com/.id), configuring cPanel/VPS/Cloud hosting, and installing SSL HTTPS until the website is live.' : 'Ya, kami siap membantu proses deployment end-to-end: mulai dari konfigurasi domain (.com/.id), setup web server cPanel/VPS/Cloud, hingga sertifikat SSL HTTPS terpasang dan siap digunakan publik.'">
                        Ya, kami siap membantu proses deployment end-to-end: mulai dari konfigurasi domain (.com/.id), setup web server cPanel/VPS/Cloud, hingga sertifikat SSL HTTPS terpasang dan siap digunakan publik.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     9. PUBLIC WORKSPACE / GUESTBOOK ("Workspace Publik")
     ═══════════════════════════════════════════════════════ -->
<section id="workspace" class="py-24 relative">
    <div class="container max-w-6xl mx-auto">
        <div class="reveal flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3" x-text="$store.lang?.current === 'en' ? 'Digital Guestbook' : 'Buku Tamu Digital'">Buku Tamu Digital</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                <span x-text="$store.lang?.current === 'en' ? 'Public' : 'Workspace'">Workspace</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Workspace' : 'Publik'">Publik</span>
            </h2>
            <p class="text-slate-400 max-w-xl text-sm md:text-base" x-text="$store.lang?.current === 'en' ? 'Leave a note, feedback, or quick greeting directly for the developer and visitors.' : 'Tinggalkan jejak, sapaan, atau masukan untuk pengembang dan pengunjung lainnya secara langsung.'">Tinggalkan jejak, sapaan, atau masukan untuk pengembang dan pengunjung lainnya secara langsung.</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Catatan -->
            <div class="reveal lg:col-span-1">
                <div class="glass-panel p-6 md:p-8 rounded-3xl border border-white/10 sticky top-28 backdrop-blur-2xl shadow-2xl">
                    <div class="flex items-center gap-2.5 mb-3">
                        <span class="w-3 h-3 rounded-full bg-cyan-400 animate-ping"></span>
                        <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100" x-text="$store.lang?.current === 'en' ? 'Leave a Note! 🚀' : 'Kirim Catatan! 🚀'">Kirim Catatan! 🚀</h3>
                    </div>
                    <p class="text-xs text-slate-400 mb-6" x-text="$store.lang?.current === 'en' ? 'Your message will appear live on the public feed.' : 'Pesan Anda akan tampil di feed publik portofolio ini.'">Pesan Anda akan tampil di feed publik portofolio ini.</p>
                    
                    @if(session('success_note'))
                        <div class="alert alert-success rounded-xl mb-6 text-sm py-3 px-4 flex items-center">
                            <i class='bx bx-check-circle text-lg mr-2'></i>
                            <span>{{ session('success_note') }}</span>
                        </div>
                    @endif
                    
                    <form action="{{ route('notes.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="form-label text-xs" x-text="$store.lang?.current === 'en' ? 'Your Name' : 'Nama Anda'">Nama Anda</label>
                            <input type="text" name="name" class="form-control rounded-xl" required placeholder="Nama Anda / Samaran">
                        </div>
                        <div class="form-group mb-6">
                            <label class="form-label text-xs" x-text="$store.lang?.current === 'en' ? 'Your Message' : 'Pesan Anda'">Pesan Anda</label>
                            <textarea name="content" class="form-control rounded-xl min-h-[110px]" required placeholder="Tuliskan catatan atau sapaan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-shimmer w-full rounded-xl py-3.5 text-sm font-bold flex items-center justify-center gap-2 group cursor-pointer">
                            <span x-text="$store.lang?.current === 'en' ? 'Post to Board' : 'Kirim ke Papan Catatan'">Kirim ke Papan Catatan</span>
                            <i class='bx bx-send text-base group-hover:translate-x-1 transition-transform'></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Daftar Catatan -->
            <div class="reveal reveal-delay-1 lg:col-span-2">
                @if(isset($notes) && $notes->count() > 0)
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
                        <h4 class="text-lg font-bold text-slate-200 mb-1" x-text="$store.lang?.current === 'en' ? 'No Notes Yet' : 'Belum Ada Catatan'">Belum Ada Catatan</h4>
                        <p class="text-sm text-slate-400" x-text="$store.lang?.current === 'en' ? 'Be the first to leave a note on this workspace!' : 'Jadilah orang pertama yang menulis catatan di workspace ini!'">Jadilah orang pertama yang menulis catatan di workspace ini!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     10. CONTACT SECTION ("Mari Berdiskusi")
     ═══════════════════════════════════════════════════════ -->
<section id="contact" class="py-24 relative overflow-hidden">
    <div class="container max-w-4xl mx-auto">
        <div class="reveal flex flex-col items-center mb-14 text-center">
            <div class="badge mb-3" x-text="$store.lang?.current === 'en' ? 'Get in Touch' : 'Hubungi Langsung'">Hubungi Langsung</div>
            <h2 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4">
                <span x-text="$store.lang?.current === 'en' ? 'Let\'s Start a' : 'Mari Mulai'">Mari Mulai</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Collaboration' : 'Kolaborasi'">Kolaborasi</span>
            </h2>
            <p class="text-slate-400 max-w-lg text-sm md:text-base" x-text="$store.lang?.current === 'en' ? 'Have an exciting project idea, partnership inquiry, or just want to chat? Feel free to reach out.' : 'Punya ide projek menarik, tawaran kerjasama, atau sekadar ingin berdiskusi? Jangan ragu untuk menghubungi saya.'">Punya ide projek menarik, tawaran kerjasama, atau sekadar ingin berdiskusi? Jangan ragu untuk menghubungi saya.</p>
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
                        <label class="form-label" x-text="$store.lang?.current === 'en' ? 'Full Name' : 'Nama Lengkap'">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-xl" required placeholder="Contoh: Xie Syahmi">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label" x-text="$store.lang?.current === 'en' ? 'Email Address' : 'Alamat Email'">Alamat Email</label>
                        <input type="email" name="email" class="form-control rounded-xl" required placeholder="xie@example.com">
                    </div>
                </div>
                
                <div class="form-group mb-6">
                    <label class="form-label" x-text="$store.lang?.current === 'en' ? 'Subject / Inquiry Topic' : 'Subjek / Topik'">Subjek / Topik</label>
                    <input type="text" name="subject" class="form-control rounded-xl" placeholder="Tawaran Kerjasama / Projek Web">
                </div>

                <div class="form-group mb-8">
                    <label class="form-label" x-text="$store.lang?.current === 'en' ? 'Your Message' : 'Pesan Anda'">Pesan Anda</label>
                    <textarea name="message" class="form-control rounded-xl min-h-[140px]" required placeholder="Jelaskan kebutuhan, ide, atau pertanyaan Anda..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-shimmer w-full rounded-2xl py-4 text-base font-bold flex items-center justify-center gap-2 group shadow-xl cursor-pointer">
                    <span x-text="$store.lang?.current === 'en' ? 'Send Message Now' : 'Kirim Pesan Sekarang'">Kirim Pesan Sekarang</span>
                    <i class='bx bx-send text-xl group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform'></i>
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
