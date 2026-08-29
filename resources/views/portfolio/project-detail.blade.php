@extends('layouts.app')

@section('title', $project->title . ' - ' . config('app.name'))

@section('content')
<div class="pt-32 pb-24 relative">
    
    <!-- Ambient Glow -->
    <div class="absolute top-20 left-1/2 -translate-x-1/2 w-[900px] h-[450px] bg-indigo-600/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>

    <div class="container max-w-6xl mx-auto px-4">
        
        <!-- Back Navigation Button -->
        <a href="{{ route('home') }}#projects" class="group text-slate-400 hover:text-white flex items-center gap-2 mb-10 inline-flex transition-colors font-medium">
            <span class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-indigo-500 group-hover:border-transparent group-hover:text-white transition-all">
                <i class='bx bx-arrow-back text-lg'></i>
            </span>
            <span class="text-sm font-semibold">Kembali ke Daftar Projek</span>
        </a>

        @if(session('error'))
            <div class="alert alert-error mb-8 rounded-2xl backdrop-blur-md">
                <i class='bx bx-error-circle text-2xl mr-2'></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success mb-8 rounded-2xl backdrop-blur-md">
                <i class='bx bx-check-circle text-2xl mr-2'></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-14">
            
            <!-- Main Content Area (2 Cols) -->
            <div class="lg:col-span-2 space-y-10">
                
                <!-- Cinematic Thumbnail Card -->
                <div class="rounded-3xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.6)] border border-white/10 relative group max-h-[500px] flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-dark via-transparent to-transparent opacity-70 z-10 pointer-events-none"></div>
                    
                    @if($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="w-full max-h-[500px] object-contain transform group-hover:scale-105 transition-transform duration-1000 relative z-0">
                    @else
                        <div class="flex flex-col items-center justify-center text-slate-600 w-full h-[380px]">
                            <i class='bx bx-laptop text-7xl text-indigo-400/40 mb-3'></i>
                            <span class="text-sm font-mono tracking-wider uppercase text-slate-400">Pratinjau Projek</span>
                        </div>
                    @endif
                    
                    <div class="absolute bottom-6 left-6 right-6 z-20 flex justify-between items-end">
                        <div class="flex gap-2 flex-wrap">
                            @foreach($project->tech_stack ?? [] as $tech)
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-black/60 text-indigo-300 backdrop-blur-md border border-white/20">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Title & Meta -->
                <div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black font-['Space_Grotesk'] text-slate-100 tracking-tight leading-tight mb-6">
                        {{ $project->title }}
                    </h1>
                    
                    <!-- Long Description Glass Panel -->
                    <div class="glass-panel p-8 md:p-10 text-slate-300 leading-loose text-base md:text-lg font-light rounded-3xl border border-white/10 shadow-xl space-y-4">
                        {!! nl2br(e($project->long_description ?? $project->description)) !!}
                    </div>
                </div>

                <!-- Credentials Info Section (If applicable) -->
                @if($project->credentials && count($project->credentials) > 0)
                <div class="glass-panel p-8 md:p-10 rounded-3xl relative overflow-hidden shadow-2xl border border-white/10">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/15 flex items-center justify-center text-indigo-400 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                            <i class='bx bx-key text-2xl'></i>
                        </div>
                        <h3 class="text-2xl font-bold font-['Space_Grotesk'] text-slate-100">Panduan Login Aplikasi</h3>
                    </div>
                    <p class="text-slate-400 mb-6 font-light text-sm">Gunakan akun berikut untuk menguji fitur aplikasi secara langsung setelah diunduh.</p>
                    
                    <div class="overflow-x-auto rounded-2xl border border-white/5 bg-black/30">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/10 text-xs uppercase tracking-wider text-slate-400 bg-white/5">
                                    <th class="p-4 font-bold">Role</th>
                                    <th class="p-4 font-bold">Username / Email</th>
                                    <th class="p-4 font-bold">Password</th>
                                    <th class="p-4 font-bold">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @foreach($project->credentials as $cred)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-4"><span class="px-2.5 py-1 rounded-md text-xs font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">{{ $cred['role'] ?? 'User' }}</span></td>
                                    <td class="p-4 font-bold text-slate-100">{{ $cred['username'] }}</td>
                                    <td class="p-4 font-mono font-bold text-accent-cyan">{{ $cred['password'] }}</td>
                                    <td class="p-4 text-slate-400 text-xs">{{ $cred['note'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar Actions (1 Col) -->
            <div class="lg:col-span-1">
                <div class="glass-panel p-8 rounded-3xl sticky top-28 border border-white/10 shadow-2xl space-y-6">
                    <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 border-b border-white/10 pb-4 flex items-center gap-2">
                        <i class='bx bx-rocket text-indigo-400'></i>
                        <span>Aksi Projek</span>
                    </h3>
                    
                    @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline w-full rounded-2xl py-4 flex justify-between group hover:border-indigo-500">
                            <span class="flex items-center gap-2 text-sm font-bold">
                                <i class='bx bx-link-external text-lg text-indigo-400'></i>
                                <span>Live Demo</span>
                            </span>
                            <i class='bx bx-chevron-right text-lg group-hover:translate-x-1 transition-transform'></i>
                        </a>
                    @endif
                    
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline w-full rounded-2xl py-4 flex justify-between group hover:border-white">
                            <span class="flex items-center gap-2 text-sm font-bold">
                                <i class='bx bxl-github text-xl text-slate-300'></i>
                                <span>Source Code</span>
                            </span>
                            <i class='bx bx-chevron-right text-lg group-hover:translate-x-1 transition-transform'></i>
                        </a>
                    @endif

                    @if($project->zip_path || $project->apk_path)
                        <div class="text-center bg-black/30 rounded-2xl py-6 border border-white/5">
                            <div class="text-xs uppercase tracking-widest text-slate-400 font-bold mb-1">Total Diunduh</div>
                            <div class="text-4xl font-black text-emerald-400 drop-shadow-[0_0_15px_rgba(16,185,129,0.5)]">
                                {{ $project->download_count }}<span class="text-sm text-slate-400 font-medium ml-1">kali</span>
                            </div>
                        </div>

                        <!-- Direct ZIP Download Button -->
                        @if($project->zip_path)
                        <a href="{{ route('project.download', $project->id) }}" class="btn btn-primary btn-shimmer w-full rounded-2xl py-4 font-bold flex justify-center items-center gap-2 group shadow-xl">
                            <i class='bx bx-download text-xl group-hover:-translate-y-1 transition-transform'></i>
                            <span>Download Source (ZIP)</span>
                        </a>
                        @endif

                        <!-- Direct APK Download Button -->
                        @if($project->apk_path)
                        <a href="{{ route('project.download-apk', $project->id) }}" class="btn w-full rounded-2xl py-4 font-bold flex justify-center items-center gap-3 border border-cyan-500/40 bg-cyan-950/30 text-cyan-300 hover:bg-cyan-500 hover:text-white transition-all duration-300">
                            <i class='bx bxl-android text-2xl'></i>
                            <div class="flex flex-col items-start leading-none text-left">
                                <span class="text-sm">Download Aplikasi</span>
                                <span class="text-[10px] uppercase tracking-wider opacity-75 mt-1">.APK (Android)</span>
                            </div>
                        </a>
                        @endif

                        <!-- Trakteer Button -->
                        @if(!empty($profile->trakteer_url))
                        <a href="{{ $profile->trakteer_url }}" target="_blank" rel="noopener noreferrer" class="w-full rounded-2xl py-3.5 font-bold flex justify-center items-center gap-2 group border border-rose-500/30 bg-rose-500/10 text-rose-300 hover:bg-rose-600 hover:text-white transition-all duration-300 text-sm">
                            <span class="text-lg group-hover:scale-125 transition-transform">☕</span>
                            <span>Dukung / Traktir Kopi</span>
                        </a>
                        @endif
                    @else
                        <div class="alert alert-error text-xs rounded-2xl">File unduhan belum tersedia untuk projek ini.</div>
                    @endif

                </div>
            </div>

        </div>
        
        <!-- Related Projects Section -->
        @if(count($relatedProjects) > 0)
        <div class="mt-28 pt-16 border-t border-white/10 relative">
            <h3 class="text-2xl md:text-3xl mb-10 font-bold font-['Space_Grotesk'] text-center">
                Projek <span class="text-gradient">Lainnya</span>
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedProjects as $rel)
                    <a href="{{ route('project.show', $rel->slug) }}" class="glass-card spotlight-card tilt-card rounded-3xl overflow-hidden border border-white/5 hover:border-indigo-500/40 transition-all group flex flex-col">
                        <div class="relative h-48 overflow-hidden bg-primary-dark/80">
                            @if($rel->thumbnail)
                                <img src="{{ asset('storage/' . $rel->thumbnail) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover transform group-hover:scale-108 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-600">
                                    <i class='bx bx-laptop text-4xl text-indigo-400/40'></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 bg-secondary-dark/60">
                            <h4 class="text-lg font-bold text-slate-100 group-hover:text-indigo-400 transition-colors">{{ $rel->title }}</h4>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
