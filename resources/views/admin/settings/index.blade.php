@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-2">Pengaturan Web</h1>
        <p class="text-secondary">Atur menu dan bagian apa saja yang ingin ditampilkan ke publik.</p>
    </div>
</div>

<div class="glass-panel" style="padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2); max-width: 800px;">
    <h2 class="text-xl font-bold border-b flex items-center gap-2" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom-color: var(--glass-border);">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
        Visibilitas Menu
    </h2>
    
    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-tertiary rounded-lg p-5 mb-6 border border-glass">
            <p class="text-sm text-secondary mb-5">Pilih menu / bagian mana saja yang ingin ditampilkan di halaman utama portofolio Anda. Jika centang dihilangkan, menu tersebut akan otomatis disembunyikan (draft) dari publik.</p>
            
            <div class="form-group mb-5">
                <label class="flex items-center gap-4 cursor-pointer p-3 rounded-lg hover:bg-white/5 transition-colors" style="border: 1px solid var(--glass-border)">
                    <input type="checkbox" name="enable_skills" value="1" {{ $profile->enable_skills ?? true ? 'checked' : '' }} class="w-6 h-6 rounded" style="accent-color: var(--accent-primary);">
                    <div>
                        <span class="block font-bold text-lg">Tampilkan Keahlian</span>
                        <span class="text-sm text-secondary">Menampilkan daftar kemampuan dan keahlian teknis Anda.</span>
                    </div>
                </label>
            </div>
            
            <div class="form-group mb-5">
                <label class="flex items-center gap-4 cursor-pointer p-3 rounded-lg hover:bg-white/5 transition-colors" style="border: 1px solid var(--glass-border)">
                    <input type="checkbox" name="enable_projects" value="1" {{ $profile->enable_projects ?? true ? 'checked' : '' }} class="w-6 h-6 rounded" style="accent-color: var(--accent-primary);">
                    <div>
                        <span class="block font-bold text-lg">Tampilkan Projek</span>
                        <span class="text-sm text-secondary">Menampilkan daftar portofolio / hasil kerja Anda.</span>
                    </div>
                </label>
            </div>
            
            <div class="form-group mb-2">
                <label class="flex items-center gap-4 cursor-pointer p-3 rounded-lg hover:bg-white/5 transition-colors" style="border: 1px solid var(--glass-border)">
                    <input type="checkbox" name="enable_certificates" value="1" {{ $profile->enable_certificates ?? true ? 'checked' : '' }} class="w-6 h-6 rounded" style="accent-color: var(--accent-primary);">
                    <div>
                        <span class="block font-bold text-lg">Tampilkan Sertifikat</span>
                        <span class="text-sm text-secondary">Menampilkan penghargaan dan sertifikat yang Anda peroleh.</span>
                    </div>
                </label>
            </div>
        </div>
        
        <div class="flex justify-end mt-6">
            <button type="submit" class="btn btn-primary flex justify-center items-center gap-2" style="padding: 1rem 2rem;">
                Simpan Pengaturan
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            </button>
        </div>
    </form>
</div>
@endsection
