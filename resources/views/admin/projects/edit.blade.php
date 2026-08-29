@extends('layouts.admin')

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.projects.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-500 flex items-center justify-center shadow-sm transition-colors">
        <i class='bx bx-arrow-back text-lg'></i>
    </a>
    <div>
        <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Edit Projek: {{ $project->title }}</h1>
        <p class="text-slate-500 text-sm">Perbarui data, deskripsi, tautan, dan file unduhan projek.</p>
    </div>
</div>

<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Form (Kiri - 2 Cols) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Basic Info Card -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2.5">
                    <i class='bx bx-edit text-2xl text-indigo-600'></i>
                    <span>Informasi Utama Projek</span>
                </h2>
                
                <div class="form-group mb-5">
                    <label class="form-label">Judul Projek <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" class="form-control text-sm" value="{{ old('title', $project->title) }}" required>
                </div>
                
                <div class="form-group mb-5">
                    <label class="form-label">Deskripsi Singkat (Ringkasan)</label>
                    <textarea name="description" class="form-control text-sm" rows="2">{{ old('description', $project->description) }}</textarea>
                </div>
                
                <div class="form-group mb-5">
                    <label class="form-label">Deskripsi Lengkap (Detail Fitur & Solusi)</label>
                    <textarea name="long_description" class="form-control text-sm" rows="7">{{ old('long_description', $project->long_description) }}</textarea>
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label">Tech Stack</label>
                    <input type="text" name="tech_stack" class="form-control text-sm" value="{{ old('tech_stack', implode(', ', $project->tech_stack ?? [])) }}" placeholder="Laravel, Vue.js, Tailwind CSS (pisahkan dengan koma)">
                </div>
            </div>
            
            <!-- Credentials Card -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-2 flex items-center gap-2.5">
                    <i class='bx bx-key text-2xl text-purple-600'></i>
                    <span>Panduan Akun Login Demo</span>
                </h2>
                <p class="text-xs text-slate-500 mb-6">Akun demo testing untuk pengunjung yang mengunduh aplikasi.</p>
                
                <div x-data="credentialsForm()">
                    <div class="space-y-4 mb-4">
                        <template x-for="(cred, index) in credentials" :key="index">
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 relative group">
                                <button type="button" @click="removeCred(index)" class="absolute top-3 right-3 text-slate-400 hover:text-rose-600 transition-colors">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <label class="form-label text-xs">Username / Email</label>
                                        <input type="text" :name="`credentials_username[]`" x-model="cred.username" class="form-control text-xs py-2 px-3">
                                    </div>
                                    <div>
                                        <label class="form-label text-xs">Password</label>
                                        <input type="text" :name="`credentials_password[]`" x-model="cred.password" class="form-control text-xs py-2 px-3 font-mono">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="form-label text-xs">Role / Peran</label>
                                        <input type="text" :name="`credentials_role[]`" x-model="cred.role" class="form-control text-xs py-2 px-3">
                                    </div>
                                    <div>
                                        <label class="form-label text-xs">Catatan Tambahan</label>
                                        <input type="text" :name="`credentials_note[]`" x-model="cred.note" class="form-control text-xs py-2 px-3">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <button type="button" @click="addCred()" class="btn btn-outline btn-sm w-full border-dashed py-2.5 text-xs font-bold flex items-center justify-center gap-1.5 hover:border-indigo-500 hover:text-indigo-600">
                        <i class='bx bx-plus'></i>
                        <span>Tambah Akun Demo Baru</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Form (Kanan - 1 Col) -->
        <div class="lg:col-span-1 space-y-8">
            
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4">
                    Publikasi & File
                </h2>
                
                <div class="form-group mb-0">
                    <label class="form-label text-xs">Status Publikasi</label>
                    <select name="status" class="form-select text-sm">
                        <option value="published" {{ $project->status === 'published' ? 'selected' : '' }}>Publik (Tampilkan di Web)</option>
                        <option value="draft" {{ $project->status === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                    </select>
                </div>
                
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ $project->is_featured ? 'checked' : '' }} class="w-4 h-4 rounded text-indigo-600 accent-indigo-600">
                        <div>
                            <span class="block text-xs font-bold text-slate-900">Projek Unggulan (Featured)</span>
                            <span class="block text-[11px] text-slate-500">Tampil dengan badge sorotan</span>
                        </div>
                    </label>
                </div>
                
                <!-- Thumbnail -->
                <div class="form-group mb-0">
                    <label class="form-label text-xs">Thumbnail Gambar</label>
                    @if($project->thumbnail)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumb" class="w-full h-32 object-cover rounded-xl border border-slate-200 shadow-sm">
                        </div>
                    @endif
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center bg-slate-50">
                        <input type="file" name="thumbnail" class="w-full text-xs" accept="image/*">
                        <p class="text-[11px] text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah thumbnail.</p>
                    </div>
                </div>
                
                <!-- ZIP Source -->
                <div class="form-group mb-0">
                    <label class="form-label text-xs text-emerald-700 font-bold flex items-center gap-1.5">
                        <i class='bx bx-file-blank text-base'></i>
                        <span>Source Code (ZIP/RAR)</span>
                    </label>
                    @if($project->zip_path)
                        <div class="mb-2 p-2.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs font-semibold text-emerald-800 flex items-center gap-2">
                            <i class='bx bx-check-circle text-base text-emerald-600'></i>
                            <span>File ZIP aktif sudah tersimpan</span>
                        </div>
                    @endif
                    <div class="border-2 border-dashed border-emerald-300 rounded-xl p-4 text-center bg-emerald-50/50">
                        <input type="file" name="zip_file" class="w-full text-xs" accept=".zip,.rar,.7z">
                        <p class="text-[11px] text-slate-500 mt-1.5">Biarkan kosong jika tidak ingin mengganti file ZIP.</p>
                    </div>
                </div>

                <!-- APK Android -->
                <div class="form-group mb-0">
                    <label class="form-label text-xs text-cyan-700 font-bold flex items-center gap-1.5">
                        <i class='bx bxl-android text-base'></i>
                        <span>Aplikasi Android (.APK)</span>
                    </label>
                    @if($project->apk_path)
                        <div class="mb-2 p-2.5 bg-cyan-50 border border-cyan-200 rounded-xl text-xs font-semibold text-cyan-800 flex items-center gap-2">
                            <i class='bx bx-check-circle text-base text-cyan-600'></i>
                            <span>File APK aktif sudah tersimpan</span>
                        </div>
                    @endif
                    <div class="border-2 border-dashed border-cyan-300 rounded-xl p-4 text-center bg-cyan-50/50">
                        <input type="file" name="apk_file" class="w-full text-xs" accept=".apk">
                        <p class="text-[11px] text-slate-500 mt-1.5">Biarkan kosong jika tidak ingin mengganti APK.</p>
                    </div>
                </div>
            </div>
            
            <!-- External Links -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4">
                    Tautan Luar
                </h2>
                
                <div class="form-group mb-0">
                    <label class="form-label text-xs flex items-center gap-1.5">
                        <i class='bx bx-link-external text-indigo-600'></i>
                        <span>URL Live Demo</span>
                    </label>
                    <input type="url" name="demo_url" class="form-control text-xs py-2 px-3" value="{{ old('demo_url', $project->demo_url) }}">
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label text-xs flex items-center gap-1.5">
                        <i class='bx bxl-github text-slate-700'></i>
                        <span>URL GitHub Repository</span>
                    </label>
                    <input type="url" name="github_url" class="form-control text-xs py-2 px-3" value="{{ old('github_url', $project->github_url) }}">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-full py-4 text-base font-bold shadow-lg flex items-center justify-center gap-2">
                <i class='bx bx-save text-xl'></i>
                <span>Simpan Perubahan Projek</span>
            </button>
        </div>
    </div>
</form>

<script>
function credentialsForm() {
    return {
        credentials: @json(old('credentials_username') ? [] : ($project->credentials ?? [])),
        init() {
            let oldUsernames = @json(old('credentials_username', []));
            let oldPasswords = @json(old('credentials_password', []));
            let oldRoles = @json(old('credentials_role', []));
            let oldNotes = @json(old('credentials_note', []));
            
            if (oldUsernames && oldUsernames.length > 0) {
                this.credentials = [];
                for(let i=0; i<oldUsernames.length; i++) {
                    this.credentials.push({
                        username: oldUsernames[i],
                        password: oldPasswords[i] || '',
                        role: oldRoles[i] || '',
                        note: oldNotes[i] || ''
                    });
                }
            }
        },
        addCred() {
            this.credentials.push({ username: '', password: '', role: 'Admin', note: '' });
        },
        removeCred(index) {
            this.credentials.splice(index, 1);
        }
    }
}
</script>
@endsection
