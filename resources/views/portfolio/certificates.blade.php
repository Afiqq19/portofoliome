@extends('layouts.app')

@section('title', 'Galeri Sertifikat & Prestasi - ' . ($profile->name ?? 'Portofolio'))

@section('content')
<div class="pt-36 pb-24 relative overflow-hidden" x-data="{ searchQuery: '', selectedIssuer: 'all', previewModal: false, activeCert: null }">
    <div class="container max-w-6xl mx-auto px-4 sm:px-6">
        
        <!-- Breadcrumb / Back Button -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-indigo-400 bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:scale-105 transition-all">
                <i class='bx bx-arrow-back text-base'></i>
                <span>Kembali ke Beranda Portofolio</span>
            </a>
        </div>

        <!-- Page Header -->
        <div class="flex flex-col items-center mb-14 text-center">
            <div class="badge mb-3">Pengakuan & Validasi Kompetensi</div>
            <h1 class="text-3xl sm:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4 leading-tight">
                Galeri <span class="text-gradient">Sertifikat & Lisensi</span>
            </h1>
            <p class="text-slate-400 max-w-xl text-sm sm:text-base leading-relaxed">
                Koleksi sertifikasi resmi, lisensi kompetensi teknis, dan penghargaan yang telah diraih sepanjang perjalanan karir.
            </p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-md mx-auto mb-12">
            <div class="relative">
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Cari sertifikat atau penerbit..." 
                       class="form-control rounded-full pl-12 pr-6 py-3.5 bg-white/5 border-white/10 focus:border-indigo-500 text-sm text-white placeholder-slate-500 w-full shadow-lg">
                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-xl text-slate-400'></i>
                <button x-show="searchQuery.length > 0" @click="searchQuery = ''" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white text-sm" style="display: none;">
                    ✕
                </button>
            </div>
        </div>

        <!-- Certificates Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($certificates as $cert)
                @php
                    $certData = [
                        'title' => $cert->title,
                        'issuer' => $cert->issuer ?? 'Penerbit Mandiri',
                        'date' => $cert->date ? $cert->date->format('M Y') : '-',
                        'image' => $cert->image ? asset('storage/' . $cert->image) : null,
                        'description' => $cert->description,
                        'credential_url' => $cert->credential_url,
                    ];
                @endphp
                <div class="glass-card spotlight-card tilt-card rounded-3xl overflow-hidden border border-white/10 hover:border-purple-500/40 flex flex-col justify-between group"
                     x-show="searchQuery === '' || '{{ addslashes(strtolower($cert->title . ' ' . $cert->issuer)) }}'.includes(searchQuery.toLowerCase())">
                    
                    <div>
                        <!-- Certificate Image Preview Box -->
                        <div class="relative h-56 overflow-hidden bg-[#0c0c14] cursor-pointer" 
                             @click="activeCert = {{ json_encode($certData) }}; previewModal = true;">
                            @if($cert->image)
                                <img src="{{ asset('storage/' . $cert->image) }}" alt="{{ $cert->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 text-white font-bold text-xs backdrop-blur-[2px]">
                                    <i class='bx bx-zoom-in text-2xl'></i>
                                    <span>Klik untuk Perbesar</span>
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-600 group-hover:scale-105 transition-transform duration-700">
                                    <i class='bx bx-award text-5xl mb-2 text-purple-400/50'></i>
                                    <span class="text-xs uppercase tracking-widest font-mono">Dokumen Sertifikat</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#060609] via-transparent to-transparent opacity-80 pointer-events-none"></div>
                        </div>

                        <!-- Details -->
                        <div class="p-6 md:p-8">
                            <div class="flex items-center justify-between text-xs text-purple-400 font-mono mb-2">
                                <span class="flex items-center gap-1.5">
                                    <i class='bx bx-check-shield'></i>
                                    <span>{{ $cert->issuer ?? 'Penerbit Resmi' }}</span>
                                </span>
                                <span>{{ $cert->date ? $cert->date->format('M Y') : '-' }}</span>
                            </div>
                            
                            <h2 class="text-lg font-bold font-['Space_Grotesk'] text-slate-100 group-hover:text-purple-300 transition-colors mb-2">
                                {{ $cert->title }}
                            </h2>

                            @if($cert->description)
                                <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed mb-4">
                                    {{ $cert->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($cert->credential_url)
                        <div class="p-6 pt-0">
                            <a href="{{ $cert->credential_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm w-full rounded-xl flex items-center justify-center gap-2 hover:border-purple-500 hover:text-purple-400 text-xs">
                                <span>Verifikasi Kredensial Resmi</span>
                                <i class='bx bx-link-external'></i>
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-slate-500 border border-dashed border-white/10 rounded-3xl p-8 bg-white/5">
                    <i class='bx bx-award text-6xl text-slate-600 mb-3'></i>
                    <h2 class="text-xl font-bold text-slate-300 mb-1">Belum Ada Sertifikat</h2>
                    <p class="text-sm text-slate-500">Sertifikat dan pencapaian akan segera ditambahkan di sini.</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Image Lightbox Modal -->
    <div x-show="previewModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/85 backdrop-blur-md"
         @click.self="previewModal = false"
         style="display: none;">
        
        <div class="glass-panel p-6 rounded-3xl max-w-3xl w-full border border-white/20 shadow-2xl relative bg-[#0c0c14]/95">
            <button @click="previewModal = false" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/10 hover:bg-rose-500 text-white flex items-center justify-center transition-colors z-10">
                ✕
            </button>

            <template x-if="activeCert">
                <div>
                    <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100 mb-1" x-text="activeCert.title"></h2>
                    <p class="text-xs text-purple-400 font-mono mb-4" x-text="activeCert.issuer + ' • ' + activeCert.date"></p>
                    
                    <div class="rounded-2xl overflow-hidden border border-white/10 mb-4 max-h-[65vh] flex items-center justify-center bg-black/60">
                        <template x-if="activeCert.image">
                            <img :src="activeCert.image" :alt="activeCert.title" class="w-full h-auto max-h-[60vh] object-contain">
                        </template>
                        <template x-if="!activeCert.image">
                            <div class="p-16 text-center text-slate-500">
                                <i class='bx bx-award text-5xl mb-2 text-purple-400'></i>
                                <p class="text-sm">Gambar pratinjau tidak tersedia</p>
                            </div>
                        </template>
                    </div>

                    <p class="text-xs text-slate-300 mb-4 font-light leading-relaxed" x-text="activeCert.description"></p>

                    <div class="flex justify-end gap-3">
                        <template x-if="activeCert.credential_url">
                            <a :href="activeCert.credential_url" target="_blank" class="btn btn-primary btn-sm rounded-xl flex items-center gap-1 text-xs">
                                <span>Buka Halaman Verifikasi</span>
                                <i class='bx bx-link-external'></i>
                            </a>
                        </template>
                        <button @click="previewModal = false" class="btn btn-outline btn-sm rounded-xl text-xs">
                            Tutup
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
