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
        Pilih bagian mana saja yang ingin dimunculkan ke pengunjung. Jika toggle dinonaktifkan, section tersebut akan disembunyikan otomatis dari halaman depan.
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
                    <input type="checkbox" name="enable_skills" value="1" {{ $profile->enable_skills ?? true ? 'checked' : '' }} class="sr-only peer">
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
                    <input type="checkbox" name="enable_projects" value="1" {{ $profile->enable_projects ?? true ? 'checked' : '' }} class="sr-only peer">
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
                    <input type="checkbox" name="enable_certificates" value="1" {{ $profile->enable_certificates ?? true ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                </div>
            </label>

        </div>
        
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="btn btn-primary px-6 py-3 font-bold text-sm shadow-md flex items-center gap-2">
                <i class='bx bx-save text-lg'></i>
                <span>Simpan Pengaturan Visibilitas</span>
            </button>
        </div>
    </form>
</div>
@endsection
