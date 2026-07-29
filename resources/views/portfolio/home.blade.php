@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero text-center animate-fade-in relative overflow-hidden flex flex-col items-center justify-center min-h-[90vh]">
    <!-- Background Glow -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-accent-primary/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="container relative z-10 pt-20">
        @if($profile && $profile->avatar)
            <div class="relative inline-block mb-8 animate-float">
                <div class="absolute inset-0 bg-gradient-to-r from-accent-primary to-accent-secondary rounded-full blur-[20px] opacity-60 animate-pulse-glow"></div>
                <img src="{{ asset('storage/' . $profile->avatar) }}" alt="{{ $profile->name }}" class="hero-avatar relative z-10 m-0 border-[6px] border-bg-primary/50">
            </div>
        @else
            <div class="relative inline-block mb-8 animate-float">
                <div class="absolute inset-0 bg-gradient-to-r from-accent-primary to-accent-secondary rounded-full blur-[20px] opacity-60 animate-pulse-glow"></div>
                <div class="hero-avatar relative z-10 m-0 border-[6px] border-bg-primary/50 flex items-center justify-center bg-gradient-to-br from-bg-secondary to-bg-tertiary" style="font-size: 5rem; color: var(--text-primary)">
                    {{ substr($profile->name ?? 'P', 0, 1) }}
                </div>
            </div>
        @endif
        
        <h1 class="text-4xl sm:text-5xl md:text-7xl mb-4 md:mb-6 delay-200 tracking-tight font-black px-2">
            <span class="text-primary">Hello, I'm</span><br/>
            <span class="text-gradient">{{ $profile->name ?? 'Welcome to My Portfolio' }}</span>
        </h1>
        <p class="text-lg md:text-2xl text-secondary mb-6 md:mb-8 delay-300 max-w-2xl mx-auto font-light leading-relaxed px-4">
            {{ $profile->title ?? 'Web Developer & Designer' }}
        </p>
        
        <!-- Live Clock & Date Widget -->
        <div class="flex justify-center mb-10 delay-300 animate-fade-in px-4" x-data="liveClock()">
            <div class="glass-panel px-4 md:px-6 py-3 rounded-3xl md:rounded-full flex flex-col md:flex-row items-center gap-2 md:gap-4 border border-white/10 shadow-[0_0_15px_rgba(99,102,241,0.2)] bg-white/5 backdrop-blur-md hover:border-accent-primary/50 transition-colors duration-300 text-center">
                <div class="flex items-center justify-center gap-2 text-accent-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span class="font-mono font-bold tracking-wider text-base md:text-lg" x-text="time">00:00:00</span>
                </div>
                <div class="hidden md:block w-px h-5 bg-white/20"></div>
                <div class="w-12 h-px md:hidden bg-white/20"></div>
                <div class="flex items-center justify-center gap-2 text-secondary text-xs md:text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span x-text="date">Senin, 1 Jan 2024</span>
                </div>
            </div>
        </div>

        <script>
            function liveClock() {
                return {
                    time: '',
                    date: '',
                    init() {
                        this.updateClock();
                        setInterval(() => this.updateClock(), 1000);
                    },
                    updateClock() {
                        const now = new Date();
                        // Format Waktu
                        this.time = now.toLocaleTimeString('id-ID', { hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
                        // Format Tanggal
                        this.date = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    }
                }
            }
        </script>
        
        <div class="flex flex-wrap justify-center gap-6 delay-300">
            <a href="#projects" class="btn btn-primary px-8 py-4 text-lg rounded-full group">
                Lihat Projek Saya
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            <a href="#contact" class="btn btn-outline px-8 py-4 text-lg rounded-full backdrop-blur-md bg-white/5 hover:bg-white/10 border-white/10">
                Hubungi Saya
            </a>
        </div>
        
        @if($profile && $profile->socialLinks->count() > 0)
        <div class="social-icons justify-center mt-16 delay-300 gap-4">
            @foreach($profile->socialLinks as $link)
                <a href="{{ $link->url }}" target="_blank" class="w-12 h-12 rounded-full flex items-center justify-center bg-white/5 hover:bg-accent-primary hover:-translate-y-2 transition-all duration-300 border border-white/10 hover:border-transparent hover:shadow-[0_0_20px_var(--accent-glow)]" title="{{ $link->platform }}">
                    @if($link->icon)
                        <i class="{{ $link->icon }} text-xl"></i>
                    @else
                        <span class="font-bold">{{ substr($link->platform, 0, 1) }}</span>
                    @endif
                </a>
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 relative">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-accent-primary/5 to-transparent pointer-events-none"></div>
    <div class="container relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8 text-center max-w-5xl mx-auto px-4">
            <div class="glass-panel p-6 md:p-8 group hover:-translate-y-2 hover:shadow-[0_10px_40px_rgba(99,102,241,0.2)] transition-all duration-300 border border-white/5 hover:border-accent-primary/30 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-accent-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="text-4xl md:text-5xl font-black text-gradient mb-2">{{ $stats['projects'] ?? 0 }}</div>
                    <div class="text-secondary uppercase tracking-[0.2em] text-[10px] md:text-xs font-bold">Total Projek</div>
                </div>
            </div>
            <div class="glass-panel p-6 md:p-8 group hover:-translate-y-2 hover:shadow-[0_10px_40px_rgba(99,102,241,0.2)] transition-all duration-300 border border-white/5 hover:border-accent-primary/30 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-accent-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="text-4xl md:text-5xl font-black text-gradient mb-2">{{ $stats['downloads'] ?? 0 }}</div>
                    <div class="text-secondary uppercase tracking-[0.2em] text-[10px] md:text-xs font-bold">Total Unduhan</div>
                </div>
            </div>
            <div class="glass-panel p-6 md:p-8 group hover:-translate-y-2 hover:shadow-[0_10px_40px_rgba(99,102,241,0.2)] transition-all duration-300 border border-white/5 hover:border-accent-primary/30 relative overflow-hidden sm:col-span-2 md:col-span-1">
                <div class="absolute inset-0 bg-gradient-to-br from-accent-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="text-4xl md:text-5xl font-black text-gradient mb-2">{{ $stats['visitors'] ?? 0 }}</div>
                    <div class="text-secondary uppercase tracking-[0.2em] text-[10px] md:text-xs font-bold">Total Pengunjung</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
@if($profile && $profile->bio)
<section id="about" class="py-24">
    <div class="container">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-4 mb-10 justify-center">
                <div class="h-px bg-gradient-to-r from-transparent to-accent-primary w-12 md:w-24"></div>
                <h2 class="text-3xl md:text-4xl font-bold font-['Space_Grotesk']">Tentang <span class="text-gradient">Saya</span></h2>
                <div class="h-px bg-gradient-to-l from-transparent to-accent-primary w-12 md:w-24"></div>
            </div>
            
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-accent-primary to-accent-secondary rounded-3xl blur-[10px] opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                <div class="glass-panel p-8 md:p-12 relative z-10 text-lg md:text-xl text-secondary leading-relaxed font-light rounded-3xl border border-white/10 shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="absolute top-8 left-8 text-white/5"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1.5.5 1.5 1.5L5 21z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.5c0 1-.5 1.5-1.5 1.5L17 21z"/></svg>
                    <div class="relative z-10">
                        {!! nl2br(e($profile->bio)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Skills Section -->
@if(($profile->enable_skills ?? true) && count($skills) > 0)
<section id="skills" class="py-24 bg-gradient-to-b from-transparent via-bg-secondary/50 to-transparent relative">
    <div class="container relative z-10">
        <div class="flex items-center gap-4 mb-16 justify-center">
            <div class="h-px bg-gradient-to-r from-transparent to-accent-secondary w-12 md:w-24"></div>
            <h2 class="text-3xl md:text-4xl font-bold font-['Space_Grotesk']">Keahlian <span class="text-gradient">Teknis</span></h2>
            <div class="h-px bg-gradient-to-l from-transparent to-accent-secondary w-12 md:w-24"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 max-w-5xl mx-auto">
            @foreach($skills as $category => $categorySkills)
                <div class="glass-panel p-8 md:p-10 rounded-3xl border border-white/5 hover:border-accent-primary/20 transition-colors duration-300">
                    <h3 class="text-2xl mb-8 font-['Space_Grotesk'] text-white flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-accent-primary/20 flex items-center justify-center text-accent-primary text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                        </span>
                        {{ $category }}
                    </h3>
                    <div class="flex-col gap-6">
                        @foreach($categorySkills as $skill)
                            <div class="mb-6 group">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-gray-200 group-hover:text-accent-primary transition-colors">{{ $skill->name }}</span>
                                    <span class="text-sm font-bold text-accent-secondary">{{ $skill->proficiency }}%</span>
                                </div>
                                <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-accent-primary to-accent-secondary rounded-full relative group-hover:shadow-[0_0_10px_var(--accent-glow)] transition-shadow" style="width: {{ $skill->proficiency }}%">
                                        <div class="absolute inset-0 bg-white/20 w-full animate-[pulse_2s_ease-in-out_infinite]"></div>
                                    </div>
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

<!-- Projects Section -->
@if($profile->enable_projects ?? true)
<section id="projects" class="py-24 relative">
    <div class="container">
        <div class="flex items-center gap-4 mb-16 justify-center">
            <div class="h-px bg-gradient-to-r from-transparent to-accent-primary w-12 md:w-24"></div>
            <h2 class="text-3xl md:text-4xl font-bold font-['Space_Grotesk']">Projek <span class="text-gradient">Terbaru</span></h2>
            <div class="h-px bg-gradient-to-l from-transparent to-accent-primary w-12 md:w-24"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <a href="{{ route('project.show', $project->slug) }}" class="group block relative rounded-3xl overflow-hidden bg-bg-tertiary border border-white/5 hover:border-accent-primary/30 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(0,0,0,0.5)]">
                    <div class="relative h-56 md:h-64 overflow-hidden">
                        <div class="absolute inset-0 bg-accent-primary/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10 mix-blend-overlay"></div>
                        @if($project->thumbnail)
                            <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-bg-secondary text-white/10 group-hover:scale-110 transition-transform duration-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            </div>
                        @endif
                        
                        @if($project->zip_path)
                        <div class="absolute top-4 right-4 z-20 backdrop-blur-md bg-black/50 border border-white/10 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            {{ $project->download_count }}
                        </div>
                        @endif
                    </div>
                    <div class="p-6 md:p-8 relative z-20 bg-bg-tertiary">
                        <div class="flex gap-2 flex-wrap mb-4">
                            @foreach($project->tech_stack ?? [] as $tech)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-accent-primary/10 text-accent-primary border border-accent-primary/20">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <h3 class="text-2xl font-bold mb-3 font-['Space_Grotesk'] text-white group-hover:text-accent-primary transition-colors">{{ $project->title }}</h3>
                        <p class="text-secondary text-sm line-clamp-2 leading-relaxed">
                            {{ $project->description }}
                        </p>
                        
                        <div class="mt-6 pt-6 border-t border-white/5 flex justify-between items-center group-hover:border-accent-primary/20 transition-colors">
                            <span class="text-sm font-bold text-white flex items-center gap-2 group-hover:text-accent-primary transition-colors">
                                Detail Projek 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="transform group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Certificates Section -->
@if(($profile->enable_certificates ?? true) && count($certificates) > 0)
<section id="certificates" class="py-24 relative bg-gradient-to-t from-bg-secondary/30 to-transparent">
    <div class="container">
        <div class="flex items-center gap-4 mb-16 justify-center">
            <div class="h-px bg-gradient-to-r from-transparent to-accent-secondary w-12 md:w-24"></div>
            <h2 class="text-3xl md:text-4xl font-bold font-['Space_Grotesk']">Sertifikat & <span class="text-gradient text-accent-secondary">Penghargaan</span></h2>
            <div class="h-px bg-gradient-to-l from-transparent to-accent-secondary w-12 md:w-24"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($certificates as $cert)
                <div class="group relative rounded-3xl overflow-hidden glass-panel border border-white/5 hover:border-accent-secondary/40 transition-all duration-500 hover:-translate-y-2 shadow-lg hover:shadow-[0_20px_40px_rgba(0,0,0,0.3)]">
                    <div class="absolute inset-0 bg-gradient-to-br from-accent-secondary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0"></div>
                    
                    @if($cert->image)
                        <div class="h-48 overflow-hidden relative z-10">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                            <img src="{{ asset('storage/' . $cert->image) }}" alt="{{ $cert->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        </div>
                    @endif
                    
                    <div class="p-6 md:p-8 relative z-20">
                        <div class="text-xs font-bold tracking-wider text-accent-secondary uppercase mb-2">
                            {{ $cert->date ? $cert->date->format('M Y') : 'Penghargaan' }}
                        </div>
                        <h3 class="text-xl font-bold mb-2 font-['Space_Grotesk'] text-white group-hover:text-accent-secondary transition-colors">{{ $cert->title }}</h3>
                        @if($cert->issuer)
                            <p class="text-sm font-semibold text-gray-300 mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                {{ $cert->issuer }}
                            </p>
                        @endif
                        @if($cert->description)
                            <p class="text-secondary text-sm line-clamp-3 leading-relaxed mb-6">
                                {{ $cert->description }}
                            </p>
                        @endif
                        
                        @if($cert->credential_url)
                            <div class="mt-4 pt-4 border-t border-white/5 group-hover:border-accent-secondary/20 transition-colors">
                                <a href="{{ $cert->credential_url }}" target="_blank" class="text-sm font-bold text-accent-secondary flex items-center gap-2 hover:text-white transition-colors">
                                    Lihat Kredensial
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Workspace / Catatan Pengunjung -->
<section id="workspace" class="py-24 bg-bg-secondary/20 relative">
    <div class="container relative z-10">
        <div class="flex items-center gap-4 mb-16 justify-center">
            <div class="h-px bg-gradient-to-r from-transparent to-accent-primary w-12 md:w-24"></div>
            <h2 class="text-3xl md:text-4xl font-bold font-['Space_Grotesk']">Workspace <span class="text-gradient">Publik</span></h2>
            <div class="h-px bg-gradient-to-l from-transparent to-accent-primary w-12 md:w-24"></div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Catatan -->
            <div class="lg:col-span-1">
                <div class="glass-panel p-8 rounded-3xl border border-white/10 sticky top-24">
                    <h3 class="text-xl font-bold mb-4 font-['Space_Grotesk'] text-white">Tinggalkan Jejak! 🚀</h3>
                    <p class="text-sm text-secondary mb-6">Tulis pesan, kesan, atau sekadar menyapa pengunjung lain di workspace publik ini.</p>
                    
                    @if(session('success_note'))
                        <div class="alert alert-success rounded-xl mb-6 text-sm py-3 px-4 flex items-center bg-success/20 text-success border border-success/30">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            {{ session('success_note') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('notes.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <input type="text" name="name" class="form-control bg-bg-primary/50 border-white/10 focus:border-accent-primary rounded-xl px-4 py-3 text-sm" required placeholder="Nama Anda (Boleh Samaran)">
                        </div>
                        <div class="form-group mb-6">
                            <textarea name="content" class="form-control bg-bg-primary/50 border-white/10 focus:border-accent-primary rounded-xl px-4 py-3 text-sm min-h-[120px]" required placeholder="Tulis catatan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full rounded-xl py-3 text-sm font-bold flex items-center justify-center gap-2 group">
                            Kirim Catatan
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Daftar Catatan -->
            <div class="lg:col-span-2">
                @if($notes->count() > 0)
                    <!-- Tambahan max-h dan overflow agar bisa discroll -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[550px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(99, 102, 241, 0.5) transparent;">
                        @foreach($notes as $note)
                            <div class="glass-panel p-6 rounded-2xl border border-white/5 hover:border-accent-primary/30 transition-all hover:-translate-y-1">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-primary to-accent-secondary flex items-center justify-center font-bold text-white shadow-lg">
                                            {{ strtoupper(substr($note->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-white text-sm">{{ $note->name }}</h4>
                                            <p class="text-xs text-muted">{{ $note->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-secondary text-sm leading-relaxed whitespace-pre-wrap">{{ $note->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-full min-h-[300px] text-center border-2 border-dashed border-white/10 rounded-3xl p-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="text-muted mb-4"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <h4 class="text-lg font-bold text-white mb-2">Belum Ada Catatan</h4>
                        <p class="text-sm text-secondary">Jadilah yang pertama meninggalkan jejak di workspace ini!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-24 relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-accent-secondary/5 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="container relative z-10">
        <div class="max-w-3xl mx-auto">
            <div class="flex items-center gap-4 mb-12 justify-center">
                <div class="h-px bg-gradient-to-r from-transparent to-accent-secondary w-12 md:w-24"></div>
                <h2 class="text-3xl md:text-4xl font-bold font-['Space_Grotesk']">Mari <span class="text-gradient">Berdiskusi</span></h2>
                <div class="h-px bg-gradient-to-l from-transparent to-accent-secondary w-12 md:w-24"></div>
            </div>
            
            @if($profile && ($profile->email || $profile->phone || $profile->location))
            <div class="flex flex-wrap justify-center gap-6 mb-12">
                @if($profile->email)
                <a href="mailto:{{ $profile->email }}" class="flex items-center gap-3 bg-white/5 border border-white/10 px-6 py-3 rounded-full hover:bg-accent-primary/20 hover:border-accent-primary/50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent-primary"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <span class="text-sm font-semibold text-gray-300">{{ $profile->email }}</span>
                </a>
                @endif
                
                @if($profile->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone) }}" target="_blank" class="flex items-center gap-3 bg-white/5 border border-white/10 px-6 py-3 rounded-full hover:bg-accent-secondary/20 hover:border-accent-secondary/50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent-secondary"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <span class="text-sm font-semibold text-gray-300">{{ $profile->phone }}</span>
                </a>
                @endif
                
                @if($profile->location)
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 px-6 py-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <span class="text-sm font-semibold text-gray-300">{{ $profile->location }}</span>
                </div>
                @endif
            </div>
            @endif
            
            <div class="glass-panel p-8 md:p-12 rounded-3xl border border-white/10 shadow-2xl relative">
                <div class="absolute inset-0 bg-gradient-to-br from-accent-primary/5 to-transparent rounded-3xl pointer-events-none"></div>
                
                @if(session('success'))
                    <div class="alert alert-success rounded-xl mb-8 backdrop-blur-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                
                <form action="{{ route('contact.send') }}" method="POST" class="relative z-10">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="form-group mb-0">
                            <label class="form-label text-sm font-bold uppercase tracking-wider text-gray-400">Nama Anda</label>
                            <input type="text" name="name" class="form-control bg-bg-primary/50 border-white/10 focus:border-accent-primary rounded-xl px-5 py-4" required placeholder="John Doe">
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label text-sm font-bold uppercase tracking-wider text-gray-400">Email Anda</label>
                            <input type="email" name="email" class="form-control bg-bg-primary/50 border-white/10 focus:border-accent-primary rounded-xl px-5 py-4" required placeholder="john@example.com">
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <label class="form-label text-sm font-bold uppercase tracking-wider text-gray-400">Subjek</label>
                        <input type="text" name="subject" class="form-control bg-bg-primary/50 border-white/10 focus:border-accent-primary rounded-xl px-5 py-4" placeholder="Tawaran Kerjasama">
                    </div>
                    <div class="form-group mb-8">
                        <label class="form-label text-sm font-bold uppercase tracking-wider text-gray-400">Pesan</label>
                        <textarea name="message" class="form-control bg-bg-primary/50 border-white/10 focus:border-accent-primary rounded-xl px-5 py-4 min-h-[150px]" required placeholder="Ceritakan ide luar biasa Anda di sini..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full rounded-xl py-4 text-lg font-bold flex items-center justify-center gap-2 group">
                        Kirim Pesan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
