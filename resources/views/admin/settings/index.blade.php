@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Pengaturan Tampilan Web</h1>
    <p class="text-slate-500 text-sm">Atur menu dan bagian apa saja yang ingin ditampilkan atau disembunyikan di portofolio.</p>
</div>

<div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm max-w-3xl">
    <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-4 flex items-center gap-2.5">
        <i class='bx bx-slider text-2xl text-indigo-600'></i>
        <span>Visibilitas Section Portofolio</span>
    </h2>
    <p class="text-xs text-slate-500 mb-6 leading-relaxed">
        Pilih bagian mana saja yang ingin dimunculkan ke pengunjung. Jika toggle dinonaktifkan, section tersebut akan disembunyikan otomatis dari halaman depan dan menu navigasi.
    </p>
    
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Section Status Publikasi Landing Page (Mode Pemeliharaan) -->
        <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-900 to-[#0c0c14] text-white border border-slate-700 shadow-xl mb-8 relative overflow-hidden">
            <!-- Glow background -->
            <div class="absolute -top-12 -right-12 w-36 h-36 rounded-full bg-indigo-500/20 blur-xl pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/10 pb-5 mb-5">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2.5 h-2.5 rounded-full {{ ($profile->enable_landing_page ?? true) ? 'bg-emerald-400 animate-pulse' : 'bg-amber-400 animate-ping' }}"></span>
                        <h2 class="text-lg font-bold font-['Space_Grotesk'] tracking-tight">Status Publikasi Beranda (Landing Page)</h2>
                    </div>
                    <p class="text-xs text-slate-400 max-w-xl">
                        Aktifkan untuk mempublikasikan website portofolio ke semua pengunjung, atau nonaktifkan untuk beralih ke <b>Mode Pemeliharaan (Under Maintenance)</b> saat Anda sedang memperbarui data/projek.
                    </p>
                </div>
                
                <!-- Main Toggle Switch -->
                <div class="flex items-center gap-3 bg-white/5 px-4 py-2.5 rounded-2xl border border-white/10 self-start sm:self-auto flex-shrink-0">
                    <span class="text-xs font-mono font-bold {{ ($profile->enable_landing_page ?? true) ? 'text-emerald-400' : 'text-amber-400' }}">
                        {{ ($profile->enable_landing_page ?? true) ? '🌐 ONLINE (Publik Aktif)' : '⚠️ MODE PEMELIHARAAN' }}
                    </span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_enable_landing_page" name="enable_landing_page" value="1" {{ ($profile->enable_landing_page ?? true) ? 'checked' : '' }} class="sr-only peer" onchange="toggleMaintenanceConfig(this.checked)">
                        <div class="w-12 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                    </label>
                </div>
            </div>

            <!-- Maintenance Options Panel -->
            <div id="maintenance_config_panel" class="space-y-4 pt-1 {{ ($profile->enable_landing_page ?? true) ? 'opacity-75' : '' }}">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-200 uppercase tracking-wider font-mono">
                        ⚙️ Pengaturan Halaman Pemeliharaan (Under Maintenance)
                    </label>
                    <a href="{{ route('admin.settings.maintenance-preview') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-indigo-400 hover:text-indigo-300 font-semibold hover:underline">
                        <i class='bx bx-show text-sm'></i>
                        <span>Pratinjau Tampilan Pemeliharaan ↗</span>
                    </a>
                </div>

                <!-- Preset Template Options -->
                <div>
                    <label class="block text-xs text-slate-400 mb-2">Pilih Preset Kalimat Pemberitahuan:</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                        <label class="flex flex-col p-3 rounded-xl border border-white/10 bg-white/5 cursor-pointer hover:border-indigo-400/50 transition-all text-xs">
                            <div class="flex items-center gap-2 mb-1">
                                <input type="radio" name="maintenance_status" value="maintenance" {{ ($profile->maintenance_status ?? 'maintenance') === 'maintenance' ? 'checked' : '' }} onchange="applyMaintenancePreset('maintenance')" class="text-indigo-600 focus:ring-0">
                                <span class="font-bold text-white">🚀 Pembaruan Sistem</span>
                            </div>
                            <span class="text-[11px] text-slate-400">Sistem Sedang Dalam Pemeliharaan & Pembaruan (Direkomendasikan)</span>
                        </label>

                        <label class="flex flex-col p-3 rounded-xl border border-white/10 bg-white/5 cursor-pointer hover:border-indigo-400/50 transition-all text-xs">
                            <div class="flex items-center gap-2 mb-1">
                                <input type="radio" name="maintenance_status" value="coming_soon" {{ ($profile->maintenance_status ?? '') === 'coming_soon' ? 'checked' : '' }} onchange="applyMaintenancePreset('coming_soon')" class="text-indigo-600 focus:ring-0">
                                <span class="font-bold text-white">✨ Segera Hadir</span>
                            </div>
                            <span class="text-[11px] text-slate-400">Karya & Inovasi Baru Sedang Dipersiapkan (Coming Soon)</span>
                        </label>

                        <label class="flex flex-col p-3 rounded-xl border border-white/10 bg-white/5 cursor-pointer hover:border-indigo-400/50 transition-all text-xs">
                            <div class="flex items-center gap-2 mb-1">
                                <input type="radio" name="maintenance_status" value="custom" {{ ($profile->maintenance_status ?? '') === 'custom' ? 'checked' : '' }} onchange="applyMaintenancePreset('custom')" class="text-indigo-600 focus:ring-0">
                                <span class="font-bold text-white">✏️ Pesan Kustom</span>
                            </div>
                            <span class="text-[11px] text-slate-400">Ketik judul dan kalimat keterangan bebas sesuai selera Anda</span>
                        </label>
                    </div>
                </div>

                <!-- Title Input -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Judul Pemberitahuan di Halaman Offline:</label>
                    <input type="text" id="maintenance_title_input" name="maintenance_title" value="{{ old('maintenance_title', $profile->maintenance_title ?? 'Sistem Sedang Dalam Pemeliharaan & Pembaruan') }}" class="w-full text-xs sm:text-sm py-2.5 px-3.5 bg-black/40 border border-white/15 rounded-xl text-white focus:outline-none focus:border-indigo-500 font-['Space_Grotesk']" placeholder="Contoh: Sistem Sedang Dalam Pemeliharaan & Pembaruan">
                </div>

                <!-- Message Input -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Pesan / Keterangan Penjelasan:</label>
                    <textarea id="maintenance_message_input" name="maintenance_message" rows="3" class="w-full text-xs sm:text-sm py-2 px-3 bg-black/40 border border-white/15 rounded-xl text-white focus:outline-none focus:border-indigo-500 leading-relaxed font-sans" placeholder="Tuliskan pesan penjelasan kepada pengunjung...">{{ old('maintenance_message', $profile->maintenance_message ?? 'Website portofolio kami sedang dalam proses perbaruan karya dan peningkatan fitur terbaru untuk menghadirkan pengalaman terbaik. Kami akan segera kembali online!') }}</textarea>
                </div>

                <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-300 text-xs flex items-start gap-2">
                    <i class='bx bxs-info-circle text-base flex-shrink-0 mt-0.5'></i>
                    <span><b>Catatan Keamanan Admin:</b> Saat mode pemeliharaan aktif, hanya pengunjung publik yang melihat halaman offline ini. Anda sebagai Admin yang sedang login tetap bisa membuka dan melihat beranda website secara normal.</span>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-6 mb-6">
            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-4 flex items-center gap-2.5">
                <i class='bx bx-slider text-2xl text-indigo-600'></i>
                <span>Visibilitas Section Portofolio</span>
            </h2>
            <p class="text-xs text-slate-500 mb-6 leading-relaxed">
                Pilih bagian mana saja yang ingin dimunculkan ke pengunjung. Jika toggle dinonaktifkan, section tersebut akan disembunyikan otomatis dari halaman depan dan menu navigasi.
            </p>
        </div>

        <div class="space-y-4 mb-8">
            
            <!-- Keahlian -->
            <label class="flex items-center justify-between cursor-pointer p-5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/20 transition-all">
                <div class="pr-4">
                    <span class="block font-bold text-sm text-slate-900 mb-0.5">Section Keahlian Teknis (Skills)</span>
                    <span class="text-xs text-slate-500">Menampilkan grafik bar penguasaan teknologi Anda.</span>
                </div>
                <div class="relative inline-flex items-center flex-shrink-0">
                    <input type="checkbox" name="enable_skills" value="1" {{ ($profile->enable_skills ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                </div>
            </label>

            <!-- Projek -->
            <label class="flex items-center justify-between cursor-pointer p-5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/20 transition-all">
                <div class="pr-4">
                    <span class="block font-bold text-sm text-slate-900 mb-0.5">Section Projek Portofolio</span>
                    <span class="text-xs text-slate-500">Menampilkan showcase projek, download ZIP/APK, dan link demo.</span>
                </div>
                <div class="relative inline-flex items-center flex-shrink-0">
                    <input type="checkbox" name="enable_projects" value="1" {{ ($profile->enable_projects ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                </div>
            </label>

            <!-- Sertifikat -->
            <label class="flex items-center justify-between cursor-pointer p-5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/20 transition-all">
                <div class="pr-4">
                    <span class="block font-bold text-sm text-slate-900 mb-0.5">Section Sertifikat & Prestasi</span>
                    <span class="text-xs text-slate-500">Menampilkan lisensi, sertifikasi, dan penghargaan Anda.</span>
                </div>
                <div class="relative inline-flex items-center flex-shrink-0">
                    <input type="checkbox" name="enable_certificates" value="1" {{ ($profile->enable_certificates ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                </div>
            </label>

            <!-- Kalkulator Estimasi -->
            <label class="flex items-center justify-between cursor-pointer p-5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/20 transition-all">
                <div class="pr-4">
                    <span class="block font-bold text-sm text-slate-900 mb-0.5">Layanan Kalkulator Estimasi Biaya & Waktu Projek</span>
                    <span class="text-xs text-slate-500">Menampilkan simulasi budget dan perkiraan durasi pengerjaan projek untuk klien.</span>
                </div>
                <div class="relative inline-flex items-center flex-shrink-0">
                    <input type="checkbox" name="enable_estimator" value="1" {{ ($profile->enable_estimator ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                </div>
            </label>

            <!-- Arsitektur Performa -->
            <label class="flex items-center justify-between cursor-pointer p-5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/20 transition-all">
                <div class="pr-4">
                    <span class="block font-bold text-sm text-slate-900 mb-0.5">Section Arsitektur Performa (Live Code Preview)</span>
                    <span class="text-xs text-slate-500">Menampilkan showcase editor kode interaktif "Arsitektur Performa & Kecepatan" di beranda.</span>
                </div>
                <div class="relative inline-flex items-center flex-shrink-0">
                    <input type="checkbox" name="enable_architecture" value="1" {{ ($profile->enable_architecture ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                </div>
            </label>

            <!-- Asisten Cerdas Syafiq AI -->
            <label class="flex items-center justify-between cursor-pointer p-5 rounded-2xl bg-gradient-to-r from-indigo-50/50 via-purple-50/40 to-slate-50 border border-indigo-200/80 hover:border-indigo-400 hover:shadow-sm transition-all">
                <div class="pr-4">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="font-bold text-sm text-slate-900">Asisten Cerdas Virtual Syafiq AI (Interactive Chatbot)</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700 uppercase tracking-wider">AI Widget</span>
                    </div>
                    <span class="text-xs text-slate-500">Menampilkan widget asisten virtual pintar di pojok layar yang siap menjawab pertanyaan pengunjung tentang CV, magang di Pelindo & Telkom, keahlian, dan estimasi biaya secara otomatis.</span>
                </div>
                <div class="relative inline-flex items-center flex-shrink-0">
                    <input type="checkbox" name="enable_ai_assistant" value="1" {{ ($profile->enable_ai_assistant ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                </div>
            </label>

        </div>

        <div class="border-t border-slate-100 pt-6 mb-8">
            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 mb-4 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                    ☕
                </div>
                <span>Tautan Donasi (Trakteer)</span>
            </h2>
            <div class="form-group mb-0">
                <label class="form-label text-xs">URL Creator / Tip Trakteer Anda</label>
                <div class="relative">
                    <input type="url" name="trakteer_url" class="form-control text-sm py-3 px-4 border border-slate-200 rounded-xl w-full bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none" value="{{ old('trakteer_url', $profile->trakteer_url ?? '') }}" placeholder="https://trakteer.id/username/tip">
                </div>
                @error('trakteer_url')
                    <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Isi dengan link Trakteer Anda untuk menampilkan tombol donasi <strong>"☕ Traktir Kopi"</strong>. Jika dikosongkan, tombol donasi akan disembunyikan otomatis.</p>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-6 mb-8">
            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 mb-4 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class='bx bx-line-chart'></i>
                </div>
                <span>Google Analytics (SEO & Tracking)</span>
            </h2>
            <div class="form-group mb-0">
                <label class="form-label text-xs">Measurement ID (G-XXXXXXXXXX)</label>
                <div class="relative">
                    <input type="text" name="google_analytics_id" class="form-control text-sm py-3 px-4 border border-slate-200 rounded-xl w-full bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all outline-none" value="{{ old('google_analytics_id', $profile->google_analytics_id ?? '') }}" placeholder="G-ABC123XYZ9">
                </div>
                @error('google_analytics_id')
                    <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Isi dengan ID Pengukuran Google Analytics Anda untuk melacak statistik pengunjung. Jika dikosongkan, script tracking tidak akan dimuat.</p>
            </div>
        </div>
        
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="btn btn-primary px-6 py-3 font-bold text-sm shadow-md flex items-center gap-2 cursor-pointer">
                <i class='bx bx-save text-lg'></i>
                <span>Simpan Seluruh Pengaturan Web</span>
            </button>
        </div>
    </form>
</div>

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
        if (panel) {
            if (isOnline) {
                panel.classList.add('opacity-75');
            } else {
                panel.classList.remove('opacity-75');
            }
        }
    }
</script>
@endsection
