@extends('layouts.app')

@section('title', 'Kalkulator Estimasi Biaya & Waktu Projek - ' . ($profile->name ?? 'Portofolio'))

@section('content')
<div class="pt-36 pb-24 relative overflow-hidden" x-data="projectEstimator('{{ $profile->phone ?? '' }}')">
    <div class="container max-w-5xl mx-auto px-4 sm:px-6">
        
        <!-- Breadcrumb / Back Button -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-indigo-400 bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:scale-105 transition-all">
                <i class='bx bx-arrow-back text-base'></i>
                <span>Kembali ke Beranda Portofolio</span>
            </a>
        </div>

        <!-- Page Header -->
        <div class="flex flex-col items-center mb-16 text-center">
            <div class="badge mb-3">Transparansi Biaya & Estimasi</div>
            <h1 class="text-3xl sm:text-5xl font-black font-['Space_Grotesk'] text-slate-100 mb-4 leading-tight">
                Kalkulator <span class="text-gradient">Estimasi Projek</span>
            </h1>
            <p class="text-slate-400 max-w-xl text-sm sm:text-base leading-relaxed">
                Rencanakan kebutuhan aplikasi atau website Anda secara transparan. Dapatkan estimasi durasi pengerjaan dan perkiraan biaya investasi secara instan.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Customizer Options (2 Cols) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Step 1: Kategori Projek -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-2xl">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10">
                        <span class="w-8 h-8 rounded-xl bg-indigo-500/20 text-indigo-400 font-bold text-sm flex items-center justify-center border border-indigo-500/30">1</span>
                        <div>
                            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100">Pilih Kategori Projek</h2>
                            <p class="text-xs text-slate-400">Pilih jenis produk digital yang ingin Anda bangun</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="(data, key) in types" :key="key">
                            <div @click="projectType = key; calculate();" 
                                 class="estimator-option p-5 rounded-2xl border border-white/10 bg-white/5 flex flex-col justify-between"
                                 :class="{ 'active': projectType === key }">
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                                        <i class="bx text-2xl" :class="data.icon"></i>
                                    </div>
                                    <span class="w-6 h-6 rounded-full border border-white/20 flex items-center justify-center text-xs" :class="projectType === key ? 'bg-indigo-600 border-indigo-500 text-white shadow-[0_0_10px_#6366f1]' : 'text-transparent'">
                                        ✓
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-sm text-slate-100 mb-1" x-text="data.name"></h3>
                                    <p class="text-xs text-indigo-400 font-mono font-semibold" x-text="'Mulai ' + formatRupiah(data.baseCost)"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Step 2: Fitur Tambahan -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-2xl">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-white/10">
                        <span class="w-8 h-8 rounded-xl bg-purple-500/20 text-purple-400 font-bold text-sm flex items-center justify-center border border-purple-500/30">2</span>
                        <div>
                            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-100">Pilih Fitur Kebutuhan (Opsional)</h2>
                            <p class="text-xs text-slate-400">Sesuaikan dengan fitur yang dibutuhkan bisnis Anda</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="(fData, fKey) in featureList" :key="fKey">
                            <div @click="toggleFeature(fKey)" 
                                 class="estimator-option p-4 rounded-2xl border border-white/10 bg-white/5 flex items-center justify-between gap-3"
                                 :class="{ 'active': features.includes(fKey) }">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-cyan-500/10 flex items-center justify-center text-cyan-400 flex-shrink-0">
                                        <i class="bx text-lg" :class="fData.icon"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-xs text-slate-100" x-text="fData.name"></h3>
                                        <p class="text-[11px] text-cyan-400 font-mono font-semibold" x-text="'+' + formatRupiah(fData.cost)"></p>
                                    </div>
                                </div>
                                <span class="w-5 h-5 rounded-full border border-white/20 flex items-center justify-center text-xs flex-shrink-0" :class="features.includes(fKey) ? 'bg-indigo-600 border-indigo-500 text-white' : 'text-transparent'">
                                    ✓
                                </span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-2xl">
                    <h2 class="text-lg font-bold font-['Space_Grotesk'] text-slate-100 mb-6 flex items-center gap-2">
                        <i class='bx bx-help-circle text-indigo-400 text-xl'></i>
                        <span>Pertanyaan Umum (FAQ)</span>
                    </h2>

                    <div class="space-y-4 text-xs sm:text-sm text-slate-300">
                        <div class="p-4 rounded-2xl bg-white/5 border border-white/5">
                            <h3 class="font-bold text-slate-100 mb-1">Apakah biaya di atas sudah bersifat final?</h3>
                            <p class="text-slate-400 leading-relaxed">Estimasi di atas adalah perkiraan awal. Biaya final dapat disesuaikan dengan kompleksitas spesifik dan timeline yang Anda inginkan setelah kita berdiskusi.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-white/5 border border-white/5">
                            <h3 class="font-bold text-slate-100 mb-1">Bagaimana dengan revisi dan garansi?</h3>
                            <p class="text-slate-400 leading-relaxed">Setiap projek mencakup garansi perbaikan bug gratis selama 30 hari setelah rilis serta pendampingan deploy hingga aplikasi live di hosting/server.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Calculation Sticky Summary Card (1 Col) -->
            <div class="lg:col-span-1">
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 sticky top-28 shadow-2xl space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-white/10">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xl shadow-lg">
                            <i class='bx bx-calculator'></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-100">Ringkasan Estimasi</h3>
                            <p class="text-xs text-slate-400">Hasil kalkulasi otomatis</p>
                        </div>
                    </div>

                    <!-- Live Cost -->
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center">
                        <span class="text-xs uppercase tracking-wider font-bold text-slate-400 block mb-1">Perkiraan Investasi</span>
                        <div class="text-2xl sm:text-3xl font-black font-['Space_Grotesk'] text-gradient-cyan" x-text="formatRupiah(cost)"></div>
                    </div>

                    <!-- Live Timeline -->
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <i class='bx bx-time-five text-xl text-amber-400'></i>
                            <span class="text-xs font-semibold text-slate-300">Estimasi Waktu</span>
                        </div>
                        <span class="font-mono font-bold text-sm text-amber-400" x-text="'± ' + timeline + ' Hari Kerja'"></span>
                    </div>

                    <div class="text-xs text-slate-400 leading-relaxed bg-black/20 p-4 rounded-2xl border border-white/5 space-y-1.5">
                        <p class="text-slate-300 font-semibold flex items-center gap-1.5">
                            <i class='bx bx-check-circle text-emerald-400'></i>
                            <span>Keuntungan Bekerjasama:</span>
                        </p>
                        <p>• Source code bersih, modern & terstruktur</p>
                        <p>• Desain responsive mobile & desktop</p>
                        <p>• Pendampingan deployment ke server cloud</p>
                        <p>• Garansi maintenance & perbaikan bug</p>
                    </div>

                    <!-- Direct WhatsApp Consultation CTA -->
                    <a :href="getWhatsAppLink()" target="_blank" class="btn btn-primary btn-shimmer w-full py-4 rounded-2xl text-sm font-bold flex items-center justify-center gap-2 shadow-xl hover:scale-[1.02] transition-transform">
                        <i class='bx bxl-whatsapp text-2xl text-emerald-400'></i>
                        <span>Konsultasikan via WhatsApp</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
