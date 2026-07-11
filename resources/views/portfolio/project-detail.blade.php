@extends('layouts.app')

@section('title', $project->title . ' - ' . config('app.name'))

@section('content')
<div class="pt-24 pb-20 relative">
    <!-- Cinematic Background Glow -->
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-[1000px] h-[500px] bg-accent-primary/5 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="container relative z-10">
        <a href="{{ route('home') }}#projects" class="group text-secondary hover:text-white flex items-center gap-2 mb-10 inline-flex transition-colors font-medium">
            <span class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-accent-primary transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            </span>
            Kembali ke Daftar Projek
        </a>

        @if(session('error'))
            <div class="alert alert-error mb-8 rounded-xl backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success mb-8 rounded-xl backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Cinematic Thumbnail -->
                <div class="rounded-3xl overflow-hidden mb-10 shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/10 relative group max-h-[500px] flex items-center justify-center bg-black/40 backdrop-blur-sm">
                    <div class="absolute inset-0 bg-gradient-to-t from-bg-primary via-transparent to-transparent opacity-60 z-10 pointer-events-none"></div>
                    @if($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="w-full max-h-[500px] object-contain transform group-hover:scale-105 transition-transform duration-1000 relative z-0">
                    @else
                        <div class="flex items-center justify-center bg-bg-secondary text-white/5 w-full h-[400px]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        </div>
                    @endif
                    
                    <div class="absolute bottom-8 left-8 z-20">
                        <div class="flex gap-2 flex-wrap mb-4">
                            @foreach($project->tech_stack ?? [] as $tech)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-black/50 text-white backdrop-blur-md border border-white/20">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl mb-8 font-black font-['Space_Grotesk'] text-white tracking-tight leading-tight">
                    {{ $project->title }}
                </h1>
                
                <div class="glass-panel p-8 md:p-10 mb-12 text-gray-300 leading-loose text-lg font-light rounded-3xl border border-white/5 shadow-xl">
                    {!! nl2br(e($project->long_description ?? $project->description)) !!}
                </div>

                <!-- Credentials Info -->
                @if($project->credentials && count($project->credentials) > 0)
                <div class="glass-panel p-8 md:p-10 mb-12 rounded-3xl relative overflow-hidden shadow-2xl border border-white/10">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-accent-primary to-accent-secondary"></div>
                    
                    <h3 class="text-2xl mb-4 font-bold font-['Space_Grotesk'] text-white flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full bg-accent-primary/20 flex items-center justify-center text-accent-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        Panduan Login Aplikasi
                    </h3>
                    <p class="text-secondary mb-8 font-light">Gunakan kredensial berikut untuk masuk dan menguji aplikasi secara lokal setelah diunduh.</p>
                    
                    <div class="overflow-x-auto rounded-xl border border-white/5 bg-black/20">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 text-sm uppercase tracking-wider text-gray-400 bg-white/5">
                                    <th class="p-4 font-semibold">Role</th>
                                    <th class="p-4 font-semibold">Username / Email</th>
                                    <th class="p-4 font-semibold">Password</th>
                                    <th class="p-4 font-semibold">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @foreach($project->credentials as $cred)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-4"><span class="px-2 py-1 rounded-md text-xs font-bold bg-white/10 text-white">{{ $cred['role'] ?? 'User' }}</span></td>
                                    <td class="p-4 font-bold text-white">{{ $cred['username'] }}</td>
                                    <td class="p-4 font-mono text-accent-primary">{{ $cred['password'] }}</td>
                                    <td class="p-4 text-gray-400">{{ $cred['note'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="glass-panel p-8 rounded-3xl sticky top-32 border border-white/10 shadow-2xl">
                    <h3 class="text-xl mb-6 font-bold font-['Space_Grotesk'] text-white">Aksi Projek</h3>
                    
                    @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank" class="btn btn-outline w-full mb-4 rounded-xl py-4 flex justify-between group hover:border-accent-primary">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-accent-primary"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                Live Demo
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all text-accent-primary"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    @endif
                    
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline w-full mb-4 rounded-xl py-4 flex justify-between group hover:border-white">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
                                Source Code
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    @endif

                    @if($project->zip_path || $project->apk_path)
                        <div class="h-px w-full bg-gradient-to-r from-transparent via-white/20 to-transparent my-8"></div>
                        
                        <div class="text-center mb-8 bg-black/20 rounded-2xl py-6 border border-white/5">
                            <div class="text-xs uppercase tracking-widest text-secondary font-bold mb-2">Telah diunduh</div>
                            <div class="text-4xl font-black text-success drop-shadow-[0_0_15px_rgba(16,185,129,0.5)]">{{ $project->download_count }}<span class="text-lg text-secondary font-medium ml-1">x</span></div>
                        </div>

                        <!-- Tombol Download Langsung -->
                        @if($project->zip_path)
                        <a href="{{ route('project.download', $project->id) }}" class="btn btn-primary w-full mb-3 rounded-xl py-4 font-bold flex justify-center items-center gap-2 group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="group-hover:-translate-y-1 transition-transform"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Download Source (ZIP)
                        </a>
                        @endif

                        <!-- Tombol Download APK -->
                        @if($project->apk_path)
                        <a href="{{ route('project.download-apk', $project->id) }}" class="btn w-full mb-4 rounded-xl py-4 font-bold flex justify-center items-center gap-2 group border border-accent-primary/50 bg-accent-primary/10 text-accent-primary hover:bg-accent-primary hover:text-white transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="group-hover:-translate-y-1 transition-transform"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                            <div class="flex flex-col items-start leading-none text-left">
                                <span class="text-sm">Download Aplikasi</span>
                                <span class="text-[10px] uppercase tracking-wider opacity-80 mt-1">.APK (Khusus Android)</span>
                            </div>
                        </a>
                        @endif

                        <!-- Tombol Trakteer (Hanya tampil jika diatur) -->
                        @if(!empty($profile->trakteer_url))
                        <a href="{{ $profile->trakteer_url }}" target="_blank" class="w-full rounded-xl py-4 mt-2 font-bold flex justify-center items-center gap-2 group border border-[#ef4444]/30 bg-[#ef4444]/10 text-[#ef4444] hover:bg-[#ef4444] hover:text-white transition-all duration-300">
                            <span class="text-xl group-hover:animate-bounce">☕</span>
                            Traktir Kopi
                        </a>
                        @endif
                    @else
                        <div class="alert alert-error text-sm rounded-xl mt-4">File unduhan belum tersedia.</div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Related Projects -->
        @if(count($relatedProjects) > 0)
        <div class="mt-32 pt-16 border-t border-white/10 relative">
            <h3 class="text-3xl mb-12 font-bold font-['Space_Grotesk'] text-center">Projek <span class="text-gradient">Lainnya</span></h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedProjects as $rel)
                    <a href="{{ route('project.show', $rel->slug) }}" class="group block relative rounded-2xl overflow-hidden border border-white/5 hover:border-accent-primary/30 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_15px_30px_rgba(0,0,0,0.4)]">
                        <div class="relative h-48 overflow-hidden">
                            <div class="absolute inset-0 bg-accent-primary/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10 mix-blend-overlay"></div>
                            @if($rel->thumbnail)
                                <img src="{{ asset('storage/' . $rel->thumbnail) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-bg-tertiary text-white/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 bg-bg-secondary relative z-20">
                            <h4 class="text-xl font-bold text-white group-hover:text-accent-primary transition-colors">{{ $rel->title }}</h4>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
