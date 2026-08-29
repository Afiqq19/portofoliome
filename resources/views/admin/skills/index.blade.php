@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Keahlian & Kemampuan Teknis</h1>
    <p class="text-slate-500 text-sm">Kelola daftar skill, kategori, dan persentase penguasaan yang tampil di portofolio.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- List Keahlian (2 Cols) -->
    <div class="lg:col-span-2 space-y-8">
        @foreach($skills as $category => $categorySkills)
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-bold">
                    <i class='bx bx-layer'></i>
                </div>
                <h2 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900">
                    {{ $category }}
                </h2>
                <span class="ml-auto text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600">
                    {{ count($categorySkills) }} Skill
                </span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($categorySkills as $skill)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-indigo-300 hover:bg-indigo-50/20 transition-all group">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold text-sm text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $skill->name }}</span>
                        
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-bold text-xs text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">{{ $skill->proficiency }}%</span>
                            <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus keahlian ini?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600 p-1 transition-colors" title="Hapus Skill">
                                    <i class='bx bx-trash text-sm'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="w-full h-2 rounded-full bg-slate-200 overflow-hidden">
                        <div class="h-full rounded-full bg-indigo-600 transition-all duration-500" style="width: {{ $skill->proficiency }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        
        @if(count($skills) === 0)
            <div class="bg-white p-12 rounded-2xl border border-dashed border-slate-300 text-center">
                <i class='bx bx-code-alt text-5xl text-slate-300 mb-3'></i>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Keahlian</h3>
                <p class="text-sm text-slate-500">Tambahkan skill atau bahasa pemrograman pada formulir di sebelah kanan.</p>
            </div>
        @endif
    </div>

    <!-- Form Tambah Keahlian (1 Col) -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm sticky top-28">
            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2.5">
                <i class='bx bx-plus-circle text-2xl text-indigo-600'></i>
                <span>Tambah Keahlian Baru</span>
            </h2>
            
            <form action="{{ route('admin.skills.store') }}" method="POST">
                @csrf
                <div class="form-group mb-5">
                    <label class="form-label text-xs">Nama Keahlian <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" class="form-control text-sm" required placeholder="Contoh: Laravel, Vue.js, Figma">
                </div>
                
                <div class="form-group mb-5">
                    <label class="form-label text-xs">Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="category" class="form-control text-sm" required placeholder="Contoh: Backend Development" list="category-list">
                    <datalist id="category-list">
                        <option value="Frontend Development">
                        <option value="Backend Development">
                        <option value="Mobile Development">
                        <option value="Database & DevOps">
                        <option value="UI/UX & Tools">
                    </datalist>
                </div>
                
                <div class="form-group mb-6" x-data="{ prof: 85 }">
                    <div class="flex justify-between items-center mb-2">
                        <label class="form-label text-xs mb-0">Tingkat Penguasaan</label>
                        <span class="font-mono font-bold text-sm text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-md border border-indigo-100" x-text="prof + '%'">85%</span>
                    </div>
                    <input type="range" name="proficiency" x-model="prof" min="1" max="100" class="w-full accent-indigo-600 cursor-pointer">
                    <div class="flex justify-between text-[10px] text-slate-400 font-mono mt-1">
                        <span>1% (Pemula)</span>
                        <span>50% (Menengah)</span>
                        <span>100% (Ahli)</span>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-full py-3 text-sm font-bold flex items-center justify-center gap-2 shadow-md">
                    <i class='bx bx-plus-circle text-lg'></i>
                    <span>Simpan Keahlian</span>
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
