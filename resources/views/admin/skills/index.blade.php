@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0 mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-2">Keahlian (Skills)</h1>
        <p class="text-secondary">Kelola daftar keahlian dan persentase penguasaannya.</p>
    </div>
</div>

<div class="skills-layout">
    <!-- List Skills -->
    <div class="skills-list">
        @foreach($skills as $category => $categorySkills)
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <span class="w-2 h-6 rounded-full bg-gradient-to-b from-accent-primary to-accent-secondary" style="background: linear-gradient(180deg, var(--accent-primary), var(--accent-secondary));"></span>
                {{ $category }}
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                @foreach($categorySkills as $skill)
                <div class="glass-panel relative group" style="padding: 1.5rem; border-radius: var(--radius-md); transition: transform 0.3s, box-shadow 0.3s; overflow: hidden;">
                    
                    <!-- Decorative background glow -->
                    <div style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: var(--accent-primary); filter: blur(50px); opacity: 0.1; z-index: 0;"></div>

                    <div style="position: relative; z-index: 1; margin-bottom: 1rem;" class="flex justify-between items-start">
                        <h3 class="font-bold text-lg m-0 p-0 leading-tight">{{ $skill->name }}</h3>
                        
                        <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus keahlian ini?')" class="opacity-30 group-hover:opacity-100 transition-opacity">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border-0 bg-transparent text-danger cursor-pointer p-1 hover:scale-110 transition-transform" title="Hapus Skill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </form>
                    </div>

                    <div style="position: relative; z-index: 1;">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0" style="margin-bottom: 0.5rem;">
                            <span class="text-xs text-secondary uppercase tracking-wider font-semibold">Profisiensi</span>
                            <span class="text-sm font-bold text-accent-primary">{{ $skill->proficiency }}%</span>
                        </div>
                        <div class="w-full h-2 rounded-full overflow-hidden" style="background: rgba(255,255,255,0.05); box-shadow: inset 0 1px 2px rgba(0,0,0,0.2);">
                            <div class="h-full rounded-full relative" style="width: {{ $skill->proficiency }}%; background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary)); box-shadow: 0 0 10px var(--accent-glow);">
                                <!-- Shine effect -->
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); animation: shine 2s infinite;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        
        @if(count($skills) === 0)
            <div class="glass-panel text-center flex flex-col items-center justify-center border-dashed" style="padding: 3rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="text-secondary mb-4" style="opacity: 0.5;"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                <h3 class="text-lg font-bold mb-1">Belum Ada Keahlian</h3>
                <p class="text-sm text-secondary">Tambahkan bahasa pemrograman atau alat yang Anda kuasai di form sebelah kanan.</p>
            </div>
        @endif
    </div>

    <!-- Form Tambah -->
    <div class="skills-form">
        <div class="glass-panel sticky" style="top: 100px; padding: 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
            <h2 class="text-xl font-bold mb-6 border-b pb-4 flex items-center gap-2" style="border-bottom-color: var(--glass-border)">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                Tambah Baru
            </h2>
            
            <form action="{{ route('admin.skills.store') }}" method="POST">
                @csrf
                <div class="form-group mb-6">
                    <label class="form-label text-sm" style="display: block; margin-bottom: 0.5rem;">Nama Keahlian <span class="text-danger">*</span></label>
                    <div style="position: relative;">
                        <input type="text" name="name" class="form-control" style="padding-left: 3rem !important; width: 100%; box-sizing: border-box;" required placeholder="Contoh: Laravel / Figma">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                </div>
                
                <div class="form-group mb-6">
                    <label class="form-label text-sm" style="display: block; margin-bottom: 0.5rem;">Kategori <span class="text-danger">*</span></label>
                    <div style="position: relative;">
                        <input type="text" name="category" class="form-control" style="padding-left: 3rem !important; width: 100%; box-sizing: border-box;" required placeholder="Contoh: Backend Development" list="category-list">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    </div>
                    <datalist id="category-list">
                        <option value="Frontend Development">
                        <option value="Backend Development">
                        <option value="Database & DevOps">
                        <option value="Tools & Design">
                    </datalist>
                </div>
                
                <div class="form-group mt-6" x-data="{ prof: 80 }">
                    <label class="form-label flex justify-between items-end mb-4">
                        <span class="text-sm">Tingkat Penguasaan</span>
                        <span class="font-bold text-lg text-accent-primary" style="text-shadow: 0 0 10px var(--accent-glow);" x-text="prof + '%'"></span>
                    </label>
                    <div style="position: relative; padding: 10px 0;">
                        <input type="range" name="proficiency" x-model="prof" min="1" max="100" style="width: 100%; cursor: pointer; accent-color: var(--accent-primary);">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-full mt-6 flex items-center justify-center gap-2" style="padding: 1rem;">
                    Simpan Keahlian
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
.glass-panel:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}
.mb-1 { margin-bottom: 0.25rem !important; }
.mb-3 { margin-bottom: 0.75rem !important; }
.mb-6 { margin-bottom: 1.5rem !important; }
.mt-6 { margin-top: 1.5rem !important; }

/* Custom Grid for Skills Page */
.skills-layout { display: flex; flex-direction: column; gap: 2rem; }
.skills-list { width: 100%; }
.skills-form { width: 100%; }
@media (min-width: 1024px) {
    .skills-layout { flex-direction: row; }
    .skills-list { width: 66.666%; }
    .skills-form { width: 33.333%; }
}
</style>
@endsection
