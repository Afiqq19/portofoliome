@extends('layouts.admin')

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.projects.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-500 flex items-center justify-center shadow-sm transition-colors">
        <i class='bx bx-arrow-back text-lg'></i>
    </a>
    <div>
        <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Tambah Projek Baru</h1>
        <p class="text-slate-500 text-sm">Unggah karya, repository, dan file aplikasi ke portofolio Anda.</p>
    </div>
</div>

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Form (Kiri - 2 Cols) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Basic Info Card -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2.5">
                    <i class='bx bx-info-circle text-2xl text-indigo-600'></i>
                    <span>Informasi Utama Projek</span>
                </h2>
                
                <div class="form-group mb-5">
                    <label class="form-label">Judul Projek <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" class="form-control text-sm" value="{{ old('title') }}" required placeholder="Contoh: Sistem Informasi Kasir & Inventori Toko">
                </div>
                
                <div class="form-group mb-5">
                    <label class="form-label">Deskripsi Singkat (Ringkasan)</label>
                    <textarea name="description" class="form-control text-sm" rows="2" placeholder="Tampil di kartu list projek halaman depan...">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group mb-5">
                    <label class="form-label">Deskripsi Lengkap (Detail Fitur & Solusi)</label>
                    <textarea name="long_description" class="form-control text-sm" rows="7" placeholder="Jelaskan fitur utama, teknologi yang digunakan, serta panduan instalasi...">{{ old('long_description') }}</textarea>
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label">Tech Stack</label>
                    <input type="text" name="tech_stack" class="form-control text-sm" value="{{ old('tech_stack') }}" placeholder="Laravel, Vue.js, Tailwind CSS, MySQL (pisahkan dengan koma)">
                </div>
            </div>
            
            <!-- Credentials Card -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-2 flex items-center gap-2.5">
                    <i class='bx bx-key text-2xl text-purple-600'></i>
                    <span>Panduan Akun Login Demo</span>
                </h2>
                <p class="text-xs text-slate-500 mb-6">Jika aplikasi membutuhkan akun login untuk pengujian, cantumkan akun demo di bawah ini.</p>
                
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
                                        <input type="text" :name="`credentials_username[]`" x-model="cred.username" class="form-control text-xs py-2 px-3" placeholder="admin@example.com">
                                    </div>
                                    <div>
                                        <label class="form-label text-xs">Password</label>
                                        <input type="text" :name="`credentials_password[]`" x-model="cred.password" class="form-control text-xs py-2 px-3 font-mono" placeholder="password123">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="form-label text-xs">Role / Peran</label>
                                        <input type="text" :name="`credentials_role[]`" x-model="cred.role" class="form-control text-xs py-2 px-3" placeholder="Admin">
                                    </div>
                                    <div>
                                        <label class="form-label text-xs">Catatan Tambahan</label>
                                        <input type="text" :name="`credentials_note[]`" x-model="cred.note" class="form-control text-xs py-2 px-3" placeholder="Akses penuh sistem">
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
                        <option value="published">Publik (Tampilkan di Web)</option>
                        <option value="draft">Draft (Sembunyikan)</option>
                    </select>
                </div>
                
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded text-indigo-600 accent-indigo-600">
                        <div>
                            <span class="block text-xs font-bold text-slate-900">Projek Unggulan (Featured)</span>
                            <span class="block text-[11px] text-slate-500">Tampil dengan badge sorotan</span>
                        </div>
                    </label>
                </div>
                
                <!-- Thumbnail -->
                <div class="form-group mb-0">
                    <label class="form-label text-xs">Thumbnail Gambar</label>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center bg-slate-50">
                        <input type="file" name="thumbnail" class="w-full text-xs" accept="image/*">
                        <p class="text-[11px] text-slate-500 mt-2">Disarankan format lanskap (16:9 / 1280x720).</p>
                    </div>
                </div>
                
                <!-- ZIP Source -->
                <div class="form-group mb-0">
                    <label class="form-label text-xs text-emerald-700 font-bold flex items-center gap-1.5">
                        <i class='bx bx-file-blank text-base'></i>
                        <span>Source Code (ZIP/RAR)</span>
                    </label>
                    <div class="border-2 border-dashed border-emerald-300 rounded-xl p-4 text-center bg-emerald-50/50">
                        <input type="file" name="zip_file" class="w-full text-xs" accept=".zip,.rar,.7z">
                        <p class="text-[11px] text-slate-500 mt-1.5">Pengunjung dapat mengunduh source code ini.</p>
                    </div>
                </div>

                <!-- APK Android -->
                <div class="form-group mb-0">
                    <label class="form-label text-xs text-cyan-700 font-bold flex items-center gap-1.5">
                        <i class='bx bxl-android text-base'></i>
                        <span>Aplikasi Android (.APK)</span>
                    </label>
                    <div class="border-2 border-dashed border-cyan-300 rounded-xl p-4 text-center bg-cyan-50/50">
                        <input type="file" name="apk_file" class="w-full text-xs" accept=".apk">
                        <p class="text-[11px] text-slate-500 mt-1.5">Khusus rilis aplikasi Android.</p>
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
                    <input type="url" name="demo_url" class="form-control text-xs py-2 px-3" value="{{ old('demo_url') }}" placeholder="https://demo.example.com">
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label text-xs flex items-center gap-1.5">
                        <i class='bx bxl-github text-slate-700'></i>
                        <span>URL GitHub Repository</span>
                    </label>
                    <input type="url" name="github_url" class="form-control text-xs py-2 px-3" value="{{ old('github_url') }}" placeholder="https://github.com/user/repo">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-full py-4 text-base font-bold shadow-lg flex items-center justify-center gap-2">
                <i class='bx bx-check-circle text-xl'></i>
                <span>Simpan & Rilis Projek</span>
            </button>
        </div>
    </div>
</form>

<script>
function credentialsForm() {
    return {
        credentials: [],
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
