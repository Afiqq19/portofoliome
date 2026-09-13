@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 pb-12">
    
    <!-- Header Section (Executive Glass Dashboard Banner) -->
    <div class="relative overflow-hidden p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-slate-900 via-[#0c0c16] to-slate-950 text-white border border-slate-800 shadow-2xl">
        <!-- Ambient Glow Elements -->
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-indigo-600/20 blur-[90px] pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-cyan-600/15 blur-[90px] pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full text-[11px] font-mono font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                        Pusat Kontrol Sistem
                    </span>
                    <span class="w-2 h-2 rounded-full {{ ($profile->enable_landing_page ?? true) ? 'bg-emerald-400 animate-pulse' : 'bg-amber-400 animate-ping' }}"></span>
                    <span class="text-xs font-mono font-semibold {{ ($profile->enable_landing_page ?? true) ? 'text-emerald-400' : 'text-amber-400' }}">
                        {{ ($profile->enable_landing_page ?? true) ? 'Website Online' : 'Mode Pemeliharaan' }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black font-['Space_Grotesk'] tracking-tight text-white mb-2">
                    Pengaturan Tampilan & Fitur Web
                </h1>
                <p class="text-slate-400 text-xs sm:text-sm max-w-2xl leading-relaxed">
                    Kelola visibilitas section portofolio, aktifkan atau matikan asisten virtual AI, atur halaman pemeliharaan, serta tautkan integrasi pihak ketiga secara instan.
                </p>
            </div>

            <!-- Quick Action Links -->
            <div class="flex flex-wrap items-center gap-2.5 flex-shrink-0">
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-slate-200 hover:text-white border border-white/15 text-xs font-semibold transition-all backdrop-blur-md shadow-sm hover:scale-105 active:scale-95">
                    <i class='bx bx-globe text-base text-cyan-400'></i>
                    <span>Lihat Website</span>
                    <i class='bx bx-right-top-arrow-circle text-sm text-slate-400'></i>
                </a>
                <a href="{{ url('/update-rahasia-portofolio') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 hover:text-emerald-200 border border-emerald-500/30 text-xs font-bold transition-all backdrop-blur-md shadow-sm hover:scale-105 active:scale-95">
                    <i class='bx bx-cloud-upload text-base text-emerald-400'></i>
                    <span>Deploy Server 🚀</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" id="main-settings-form" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- ═══════════════════════════════════════════════════════
             KATEGORI 1: STATUS OPERASIONAL & PEMELIHARAAN (MAINTENANCE)
             ═══════════════════════════════════════════════════════ -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden transition-all hover:shadow-md">
            
            <!-- Section Title Header -->
            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                        <i class='bx bx-power-off text-2xl'></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold font-['Space_Grotesk'] text-slate-900">
                            Status Publikasi & Mode Pemeliharaan
                        </h2>
                        <p class="text-xs text-slate-500">
                            Kendali status akses publik ke halaman beranda portofolio Anda.
                        </p>
                    </div>
                </div>

                <a href="{{ route('admin.settings.maintenance-preview') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 text-xs font-semibold transition-colors border border-slate-200/60" title="Pratinjau tampilan saat mode offline aktif">
                    <i class='bx bx-show text-sm'></i>
                    <span>Pratinjau Halaman Offline ↗</span>
                </a>
            </div>

            <div class="p-6 sm:p-8 space-y-6">
                <!-- Master Toggle Card -->
                <div class="p-5 sm:p-6 rounded-2xl {{ ($profile->enable_landing_page ?? true) ? 'bg-gradient-to-r from-emerald-500/10 via-emerald-500/5 to-transparent border border-emerald-300/60' : 'bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border border-amber-300/60' }} flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ ($profile->enable_landing_page ?? true) ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500 animate-ping' }}"></span>
                            <span class="font-bold text-sm sm:text-base text-slate-900 font-['Space_Grotesk']">
                                Publikasi Beranda Portofolio (Landing Page)
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase {{ ($profile->enable_landing_page ?? true) ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ ($profile->enable_landing_page ?? true) ? 'ONLINE' : 'MAINTENANCE' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 max-w-xl leading-relaxed">
                            Jika <b>Aktif</b>, portofolio dapat diakses oleh semua pengunjung publik. Jika <b>Nonaktif</b>, publik akan diarahkan ke halaman pemeliharaan sementara Anda tetap dapat mengakses beranda secara penuh.
                        </p>
                    </div>

                    <!-- Custom iOS-style Switch -->
                    <div class="flex items-center gap-3 self-start sm:self-auto flex-shrink-0">
                        <span class="text-xs font-mono font-bold {{ ($profile->enable_landing_page ?? true) ? 'text-emerald-700' : 'text-amber-700' }}" id="status_label_text">
                            {{ ($profile->enable_landing_page ?? true) ? 'Aktif (Publik)' : 'Mode Pemeliharaan' }}
                        </span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_enable_landing_page" name="enable_landing_page" value="1" {{ ($profile->enable_landing_page ?? true) ? 'checked' : '' }} class="sr-only peer" onchange="toggleMaintenanceConfig(this.checked)">
                            <div class="w-14 h-7 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-600 shadow-inner"></div>
                        </label>
                    </div>
                </div>

                <!-- Collapsible Maintenance Configuration Panel -->
                <div id="maintenance_config_panel" class="rounded-2xl border border-slate-200 bg-slate-50/70 p-5 sm:p-6 space-y-5 transition-all {{ ($profile->enable_landing_page ?? true) ? 'opacity-70' : 'opacity-100 ring-2 ring-amber-400/30' }}">
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-3">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider font-mono flex items-center gap-2">
                            <i class='bx bx-edit text-base text-amber-500'></i>
                            <span>Kustomisasi Teks Halaman Pemeliharaan</span>
                        </span>
                        <span class="text-[11px] text-slate-500 font-sans">
                            Hanya muncul ke pengunjung saat beranda dinonaktifkan
                        </span>
                    </div>

                    <!-- Preset Options -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Pilih Template Kalimat Cepat:</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="relative flex flex-col p-3.5 rounded-xl border bg-white cursor-pointer hover:border-indigo-400 transition-all shadow-sm group">
                                <div class="flex items-center gap-2 mb-1">
                                    <input type="radio" name="maintenance_status" value="maintenance" {{ ($profile->maintenance_status ?? 'maintenance') === 'maintenance' ? 'checked' : '' }} onchange="applyMaintenancePreset('maintenance')" class="text-indigo-600 focus:ring-0">
                                    <span class="font-bold text-xs text-slate-900 group-hover:text-indigo-600">🚀 Pembaruan Sistem</span>
                                </div>
                                <span class="text-[11px] text-slate-500 leading-snug">Proses pembaruan fitur & penyempurnaan sistem (Standar).</span>
                            </label>

                            <label class="relative flex flex-col p-3.5 rounded-xl border bg-white cursor-pointer hover:border-indigo-400 transition-all shadow-sm group">
                                <div class="flex items-center gap-2 mb-1">
                                    <input type="radio" name="maintenance_status" value="coming_soon" {{ ($profile->maintenance_status ?? '') === 'coming_soon' ? 'checked' : '' }} onchange="applyMaintenancePreset('coming_soon')" class="text-indigo-600 focus:ring-0">
                                    <span class="font-bold text-xs text-slate-900 group-hover:text-indigo-600">✨ Segera Hadir</span>
                                </div>
                                <span class="text-[11px] text-slate-500 leading-snug">Karya & inovasi baru sedang dalam tahap penyelesaian (Coming Soon).</span>
                            </label>

                            <label class="relative flex flex-col p-3.5 rounded-xl border bg-white cursor-pointer hover:border-indigo-400 transition-all shadow-sm group">
                                <div class="flex items-center gap-2 mb-1">
                                    <input type="radio" name="maintenance_status" value="custom" {{ ($profile->maintenance_status ?? '') === 'custom' ? 'checked' : '' }} onchange="applyMaintenancePreset('custom')" class="text-indigo-600 focus:ring-0">
                                    <span class="font-bold text-xs text-slate-900 group-hover:text-indigo-600">✏️ Kustom Bebas</span>
                                </div>
                                <span class="text-[11px] text-slate-500 leading-snug">Ketik judul dan pesan keterangan sendiri di bawah.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Input Judul & Pesan -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Pemberitahuan:</label>
                            <input type="text" id="maintenance_title_input" name="maintenance_title" value="{{ old('maintenance_title', $profile->maintenance_title ?? 'Sistem Sedang Dalam Pemeliharaan & Pembaruan') }}" class="w-full text-xs sm:text-sm py-2.5 px-3.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all font-['Space_Grotesk'] font-bold" placeholder="Contoh: Sistem Sedang Dalam Pemeliharaan & Pembaruan">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan / Penjelasan ke Pengunjung:</label>
                            <textarea id="maintenance_message_input" name="maintenance_message" rows="2" class="w-full text-xs sm:text-sm py-2.5 px-3.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all leading-relaxed font-sans" placeholder="Tulis pesan ramah kepada pengunjung...">{{ old('maintenance_message', $profile->maintenance_message ?? 'Website portofolio kami sedang dalam proses perbaruan karya dan peningkatan fitur terbaru untuk menghadirkan pengalaman terbaik. Kami akan segera kembali online!') }}</textarea>
                        </div>
                    </div>

                    <!-- Safety Note -->
                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-start gap-2.5 leading-relaxed">
                        <i class='bx bxs-shield-alt-2 text-lg text-amber-600 flex-shrink-0 mt-0.5'></i>
                        <div>
                            <span class="font-bold">Akses Khusus Admin Terjamin:</span> Walaupun mode pemeliharaan aktif, Anda sebagai Administrator yang sedang login tetap dapat membuka beranda website secara normal untuk memeriksa hasil edit.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             KATEGORI 2: VISIBILITAS KOMPONEN & SECTION PORTOFOLIO
             ═══════════════════════════════════════════════════════ -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden transition-all hover:shadow-md">
            
            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                        <i class='bx bx-grid-alt text-2xl'></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold font-['Space_Grotesk'] text-slate-900">
                            Visibilitas Komponen & Section Portofolio
                        </h2>
                        <p class="text-xs text-slate-500">
                            Pilih fitur atau bagian mana saja yang ingin dimunculkan atau disembunyikan dari halaman depan.
                        </p>
                    </div>
                </div>

                <span class="text-xs font-mono font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full">
                    6 Komponen
                </span>
            </div>

            <div class="p-6 sm:p-8">
                <!-- 2-Column Responsive Card Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- 1. Keahlian Teknis (Skills) -->
                    <label class="relative flex items-start justify-between p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 bg-white hover:bg-indigo-50/20 transition-all cursor-pointer shadow-sm group">
                        <div class="flex items-start gap-3.5 pr-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                                <i class='bx bx-code-alt text-xl'></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-sm text-slate-900 font-['Space_Grotesk']">Keahlian Teknis (Skills)</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">Beranda</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Menampilkan progress bar dan badge penguasaan teknologi pemrograman (Laravel, Vue, Flutter, dll).
                                </p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center flex-shrink-0 mt-1">
                            <input type="checkbox" name="enable_skills" value="1" {{ ($profile->enable_skills ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                        </div>
                    </label>

                    <!-- 2. Projek Portofolio -->
                    <label class="relative flex items-start justify-between p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 bg-white hover:bg-indigo-50/20 transition-all cursor-pointer shadow-sm group">
                        <div class="flex items-start gap-3.5 pr-3">
                            <div class="w-10 h-10 rounded-xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                                <i class='bx bx-folder-open text-xl'></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-sm text-slate-900 font-['Space_Grotesk']">Projek Unggulan</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">Beranda</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Menampilkan showcase projek portofolio, live preview, link GitHub, dan tombol download APK/ZIP.
                                </p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center flex-shrink-0 mt-1">
                            <input type="checkbox" name="enable_projects" value="1" {{ ($profile->enable_projects ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600 shadow-inner"></div>
                        </div>
                    </label>

                    <!-- 3. Sertifikat & Lisensi -->
                    <label class="relative flex items-start justify-between p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 bg-white hover:bg-indigo-50/20 transition-all cursor-pointer shadow-sm group">
                        <div class="flex items-start gap-3.5 pr-3">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                                <i class='bx bx-award text-xl'></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-sm text-slate-900 font-['Space_Grotesk']">Sertifikat & Prestasi</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">Beranda</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Menampilkan lisensi kompetensi profesional, kredensial BNSP, dan sertifikat kelulusan kursus Anda.
                                </p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center flex-shrink-0 mt-1">
                            <input type="checkbox" name="enable_certificates" value="1" {{ ($profile->enable_certificates ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-600 shadow-inner"></div>
                        </div>
                    </label>

                    <!-- 4. Kalkulator Estimasi Biaya -->
                    <label class="relative flex items-start justify-between p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 bg-white hover:bg-indigo-50/20 transition-all cursor-pointer shadow-sm group">
                        <div class="flex items-start gap-3.5 pr-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                                <i class='bx bx-calculator text-xl'></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-sm text-slate-900 font-['Space_Grotesk']">Kalkulator Estimasi Biaya</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-100 text-amber-800">Layanan</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Halaman interaktif kalkulasi budget dan durasi pengerjaan aplikasi web/mobile bagi calon klien (/estimator).
                                </p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center flex-shrink-0 mt-1">
                            <input type="checkbox" name="enable_estimator" value="1" {{ ($profile->enable_estimator ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600 shadow-inner"></div>
                        </div>
                    </label>

                    <!-- 5. Arsitektur Performa (Live Code Editor) -->
                    <label class="relative flex items-start justify-between p-5 rounded-2xl border border-slate-200 hover:border-indigo-300 bg-white hover:bg-indigo-50/20 transition-all cursor-pointer shadow-sm group">
                        <div class="flex items-start gap-3.5 pr-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0 group-hover:scale-105 transition-transform">
                                <i class='bx bx-terminal text-xl'></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-sm text-slate-900 font-['Space_Grotesk']">Arsitektur Performa (Code Preview)</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">Beranda</span>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Menampilkan showcase editor kode interaktif & pengujian kecepatan sistem di bagian tengah halaman beranda.
                                </p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center flex-shrink-0 mt-1">
                            <input type="checkbox" name="enable_architecture" value="1" {{ ($profile->enable_architecture ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600 shadow-inner"></div>
                        </div>
                    </label>

                    <!-- 6. Virtual Syafiq AI Assistant (Highlight Premium) -->
                    <label class="relative flex items-start justify-between p-5 rounded-2xl border-2 border-indigo-200 bg-gradient-to-br from-indigo-50/70 via-purple-50/50 to-cyan-50/30 hover:border-indigo-400 hover:shadow-md transition-all cursor-pointer shadow-sm group">
                        <div class="flex items-start gap-3.5 pr-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-cyan-500 p-[1.5px] flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                                <div class="w-full h-full rounded-[10px] bg-white flex items-center justify-center text-indigo-600">
                                    <i class='bx bx-bot text-xl'></i>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <span class="font-bold text-sm text-slate-900 font-['Space_Grotesk']">Asisten Virtual: Syafiq AI</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-xs">
                                        ✨ AI Chatbot
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Widget cerdas di pojok layar yang menjawab pertanyaan seputar CV, magang (Pelindo & Telkom), keahlian, dan audio TTS gratis.
                                </p>
                            </div>
                        </div>
                        <div class="relative inline-flex items-center flex-shrink-0 mt-1">
                            <input type="checkbox" name="enable_ai_assistant" value="1" {{ ($profile->enable_ai_assistant ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                        </div>
                    </label>

                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             KATEGORI 3: INTEGRASI EKSTERNAL & PIHAK KETIGA
             ═══════════════════════════════════════════════════════ -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden transition-all hover:shadow-md">
            
            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                        <i class='bx bx-link-alt text-2xl'></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold font-['Space_Grotesk'] text-slate-900">
                            Integrasi Eksternal & Pihak Ketiga
                        </h2>
                        <p class="text-xs text-slate-500">
                            Hubungkan portofolio dengan platform donasi kreator dan sistem analitik statistik.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- 1. Trakteer (Donasi Tip Kopi) -->
                <div class="p-5 sm:p-6 rounded-2xl border border-slate-200 bg-slate-50/50 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-base font-bold shadow-xs">
                                    ☕
                                </div>
                                <span class="font-bold text-sm text-slate-900 font-['Space_Grotesk']">Tautan Donasi: Trakteer.id</span>
                            </div>
                            @if(!empty($profile->trakteer_url))
                                <span class="text-[10px] font-mono font-bold text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-full">Tersambung</span>
                            @else
                                <span class="text-[10px] font-mono font-semibold text-slate-400 bg-slate-200 px-2 py-0.5 rounded-full">Belum Diisi</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Menampilkan tombol <b>"☕ Traktir Kopi"</b> di navigasi beranda untuk apresiasi karya dari pengunjung.
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">URL Profil / Tip Trakteer Anda:</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400 text-base">
                                <i class='bx bx-link'></i>
                            </span>
                            <input type="url" name="trakteer_url" class="w-full text-xs sm:text-sm pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl bg-white text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all font-mono" value="{{ old('trakteer_url', $profile->trakteer_url ?? '') }}" placeholder="https://trakteer.id/username/tip">
                        </div>
                        @error('trakteer_url')
                            <p class="text-rose-600 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                        <p class="text-[11px] text-slate-400 mt-1.5 leading-normal">
                            Kosongkan jika Anda tidak ingin memunculkan tombol donasi.
                        </p>
                    </div>
                </div>

                <!-- 2. Google Analytics (SEO & Visitor Analytics) -->
                <div class="p-5 sm:p-6 rounded-2xl border border-slate-200 bg-slate-50/50 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-base font-bold shadow-xs">
                                    <i class='bx bx-line-chart'></i>
                                </div>
                                <span class="font-bold text-sm text-slate-900 font-['Space_Grotesk']">Google Analytics 4 (GA4)</span>
                            </div>
                            @if(!empty($profile->google_analytics_id))
                                <span class="text-[10px] font-mono font-bold text-blue-700 bg-blue-100 px-2.5 py-0.5 rounded-full">Tracking Aktif</span>
                            @else
                                <span class="text-[10px] font-mono font-semibold text-slate-400 bg-slate-200 px-2 py-0.5 rounded-full">Nonaktif</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Melacak statistik jumlah pengunjung, lokasi asal negara/kota, durasi baca, dan interaksi tombol secara real-time.
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Measurement ID (Google Tag):</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400 text-base">
                                <i class='bx bx-barcode'></i>
                            </span>
                            <input type="text" name="google_analytics_id" class="w-full text-xs sm:text-sm pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl bg-white text-slate-900 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all font-mono uppercase tracking-wider" value="{{ old('google_analytics_id', $profile->google_analytics_id ?? '') }}" placeholder="G-ABC123XYZ9">
                        </div>
                        @error('google_analytics_id')
                            <p class="text-rose-600 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                        <p class="text-[11px] text-slate-400 mt-1.5 leading-normal">
                            Dapatkan kode ID dari konsol Google Analytics properti web Anda.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             KATEGORI 4: SINKRONISASI & PEMBARUAN SERVER (DEPLOY)
             ═══════════════════════════════════════════════════════ -->
        <div class="p-6 rounded-3xl bg-gradient-to-r from-emerald-500/10 via-teal-500/5 to-transparent border border-emerald-300/80 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-2xl shadow-md flex-shrink-0">
                    <i class='bx bx-cloud-upload'></i>
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <h3 class="font-bold text-sm sm:text-base text-slate-900 font-['Space_Grotesk']">
                            Pembaruan Kode & Sinkronisasi Server (Auto-Deploy)
                        </h3>
                    </div>
                    <p class="text-xs text-slate-600 max-w-xl leading-relaxed">
                        Tarik pembaruan kode terbaru dari GitHub langsung ke server hosting dalam 1 klik. Sistem otomatis mengeksekusi git pull, migrasi database, dan pembersihan cache aplikasi.
                    </p>
                </div>
            </div>

            <a href="{{ url('/update-rahasia-portofolio') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm transition-all shadow-md hover:shadow-lg active:scale-95 flex-shrink-0 cursor-pointer">
                <i class='bx bx-refresh text-lg animate-spin-slow'></i>
                <span>Jalankan Deploy Sekarang</span>
                <i class='bx bx-right-top-arrow-circle text-base'></i>
            </a>
        </div>

        <!-- ═══════════════════════════════════════════════════════
             FLOATING STICKY ACTION BAR (SIMPAN PERUBAHAN)
             ═══════════════════════════════════════════════════════ -->
        <div class="sticky bottom-6 z-30 p-4 sm:p-5 rounded-2xl bg-white/90 backdrop-blur-xl border border-slate-200/90 shadow-[0_15px_35px_rgba(0,0,0,0.1)] flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5 text-xs text-slate-500">
                <i class='bx bx-info-circle text-base text-indigo-600'></i>
                <span class="hidden sm:inline">Perubahan visibilitas section dan mode pemeliharaan langsung berlaku seketika setelah disimpan.</span>
                <span class="sm:hidden font-medium text-slate-700">Pastikan data sudah benar.</span>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-sm shadow-md hover:shadow-indigo-500/25 transition-all cursor-pointer active:scale-95">
                    <i class='bx bx-save text-lg'></i>
                    <span>Simpan Pengaturan Web</span>
                </button>
            </div>
        </div>

    </form>
</div>

<!-- Interactive Client-side Script -->
<script>
    const maintenancePresets = {
        maintenance: {
            title: 'Sistem Sedang Dalam Pemeliharaan & Pembaruan',
            message: 'Website portofolio kami sedang dalam proses perbaruan karya dan peningkatan fitur terbaru untuk menghadirkan pengalaman terbaik. Kami akan segera kembali online!'
        },
        coming_soon: {
            title: 'Karya & Inovasi Baru Segera Hadir',
            message: 'Portofolio versi terbaru sedang dipersiapkan dengan beragam karya baru. Nantikan peluncurannya segera!'
        }
    };

    function applyMaintenancePreset(type) {
        const titleInput = document.getElementById('maintenance_title_input');
        const messageInput = document.getElementById('maintenance_message_input');
        if (type in maintenancePresets && type !== 'custom') {
            if (titleInput) titleInput.value = maintenancePresets[type].title;
            if (messageInput) messageInput.value = maintenancePresets[type].message;
        }
    }

    function toggleMaintenanceConfig(isOnline) {
        const panel = document.getElementById('maintenance_config_panel');
        const statusLabel = document.getElementById('status_label_text');
        
        if (statusLabel) {
            statusLabel.textContent = isOnline ? 'Aktif (Publik)' : 'Mode Pemeliharaan';
            if (isOnline) {
                statusLabel.classList.remove('text-amber-700');
                statusLabel.classList.add('text-emerald-700');
            } else {
                statusLabel.classList.remove('text-emerald-700');
                statusLabel.classList.add('text-amber-700');
            }
        }

        if (panel) {
            if (isOnline) {
                panel.classList.add('opacity-70');
                panel.classList.remove('opacity-100', 'ring-2', 'ring-amber-400/30');
            } else {
                panel.classList.remove('opacity-70');
                panel.classList.add('opacity-100', 'ring-2', 'ring-amber-400/30');
            }
        }
    }
</script>
@endsection
