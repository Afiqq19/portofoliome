@extends('layouts.app')

@section('title', 'Katalog Semua Projek - ' . ($profile->name ?? 'Portofolio'))

@section('content')
<div class="pt-36 pb-24 relative overflow-hidden" x-data="{ searchQuery: '', activeFilter: 'all' }">
    <div class="container max-w-6xl mx-auto px-4 sm:px-6">
        
        <!-- Breadcrumb / Back Button -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-indigo-400 bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:scale-105 transition-all">
                <i class='bx bx-arrow-back text-base'></i>
                <span>Kembali ke Beranda Portofolio</span>
            </a>
        </div>

        <!-- Page Header -->
        <div class="flex flex-col items-center mb-12 text-center">
            <div class="badge mb-3">Arsip Karya Digital</div>
            <h1 class="text-3xl sm:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4 leading-tight">
                Katalog <span class="text-gradient">Seluruh Projek</span>
            </h1>
            <p class="text-slate-400 max-w-xl text-sm sm:text-base leading-relaxed">
                Jelajahi seluruh karya, aplikasi web, sistem manajemen, dan aplikasi mobile Android yang telah dipublikasikan.
            </p>
        </div>

        <!-- Search Bar & Filters -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12">
            
            <!-- Category Filter Pills -->
            <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                <button @click="activeFilter = 'all'" 
                        class="px-4 py-2 rounded-full text-xs font-bold border transition-all cursor-pointer"
                        :class="activeFilter === 'all' ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'bg-white/5 border-white/10 text-slate-400 hover:border-white/20 hover:text-white'">
                    Semua ({{ $projects->count() }})
                </button>
                <button @click="activeFilter = 'web'" 
                        class="px-4 py-2 rounded-full text-xs font-bold border transition-all cursor-pointer"
                        :class="activeFilter === 'web' ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'bg-white/5 border-white/10 text-slate-400 hover:border-white/20 hover:text-white'">
                    Web App
                </button>
                <button @click="activeFilter = 'mobile'" 
                        class="px-4 py-2 rounded-full text-xs font-bold border transition-all cursor-pointer"
                        :class="activeFilter === 'mobile' ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'bg-white/5 border-white/10 text-slate-400 hover:border-white/20 hover:text-white'">
                    Mobile (APK)
                </button>
            </div>

            <!-- Search Input -->
            <div class="relative w-full md:w-80">
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Cari nama projek atau teknologi..." 
                       class="form-control rounded-full pl-11 pr-4 py-3 bg-white/5 border-white/10 focus:border-indigo-500 text-xs text-white placeholder-slate-500 w-full shadow-lg">
                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400'></i>
            </div>

        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($projects as $project)
                @php
                    $isMobile = (bool) $project->apk_path;
                    $techArray = is_array($project->tech_stack) ? $project->tech_stack : (array) $project->tech_stack;
                    $techString = strtolower(implode(' ', $techArray) . ' ' . $project->title . ' ' . $project->description);
                @endphp
                <div class="glass-card spotlight-card tilt-card rounded-3xl overflow-hidden border border-white/10 hover:border-indigo-500/40 flex flex-col justify-between group"
                     x-show="(activeFilter === 'all' || (activeFilter === 'mobile' && {{ $isMobile ? 'true' : 'false' }}) || (activeFilter === 'web' && {{ !$isMobile ? 'true' : 'false' }})) && (searchQuery === '' || '{{ addslashes($techString) }}'.includes(searchQuery.toLowerCase()))">
                    
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
                            <div class="absolute inset-0 bg-gradient-to-t from-[#060609] via-transparent to-transparent opacity-80 pointer-events-none"></div>
                            
                            <!-- Download count badge -->
                            <div class="absolute top-4 right-4 z-20">
                                @if($project->zip_path || $project->apk_path)
                                    <div class="backdrop-blur-md bg-black/60 border border-white/10 text-emerald-400 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
                                        <i class='bx bx-download'></i>
                                        <span>{{ $project->download_count }}x Unduhan</span>
                                    </div>
                                @endif
                            </div>

                            @if($project->apk_path)
                                <div class="absolute top-4 left-4 z-20">
                                    <div class="backdrop-blur-md bg-cyan-950/80 border border-cyan-500/40 text-cyan-300 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 shadow-lg">
                                        <i class='bx bxl-android'></i>
                                        <span>APK Android</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Content Details -->
                        <div class="p-6 md:p-7">
                            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-indigo-400 transition-colors mb-2 line-clamp-1">
                                {{ $project->title }}
                            </h2>

                            <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed mb-4">
                                {{ $project->description }}
                            </p>

                            <!-- Tech Stack Pills -->
                            <div class="flex flex-wrap gap-1.5 mb-2">
                                @foreach(array_slice($techArray, 0, 4) as $tech)
                                    <span class="badge text-[10px] bg-white/5 border-white/5 text-slate-300">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div class="p-6 pt-0 flex gap-2">
                        <a href="{{ route('project.show', $project->slug) }}" class="btn btn-primary btn-sm flex-1 text-center text-xs font-bold rounded-xl shadow-md">
                            <span>Buka Detail Projek</span>
                        </a>
                        @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 hover:border-indigo-500 text-slate-300 hover:text-white flex items-center justify-center transition-colors" title="Live Demo">
                                <i class='bx bx-link-external text-base'></i>
                            </a>
                        @endif
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-20 text-slate-500 border border-dashed border-white/10 rounded-3xl p-8 bg-white/5">
                    <i class='bx bx-folder-open text-6xl text-slate-600 mb-3'></i>
                    <h2 class="text-xl font-bold text-slate-300 mb-1">Belum Ada Projek</h2>
                    <p class="text-sm text-slate-500">Projek portofolio akan segera ditambahkan di sini.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
