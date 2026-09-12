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
                <span>Simpan Pengaturan Visibilitas</span>
            </button>
        </div>
    </form>
</div>
@endsection
