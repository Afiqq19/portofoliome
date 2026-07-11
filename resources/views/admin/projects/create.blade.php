@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline btn-sm px-2 text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold mb-1">Tambah Projek</h1>
            <p class="text-secondary">Unggah projek baru ke portofolio Anda.</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form (Kiri) -->
        <div class="lg:col-span-2">
            <div class="glass-panel p-6 mb-8">
                <h2 class="text-xl font-bold mb-6 border-b pb-4" style="border-bottom-color: var(--glass-border)">Informasi Dasar</h2>
                
                <div class="form-group">
                    <label class="form-label">Judul Projek <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="e.g. Sistem Informasi Manajemen (SIM) Sekolah">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Tampil di kartu projek...">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Deskripsi Lengkap (Markdown/Text)</label>
                    <textarea name="long_description" class="form-control" rows="8" placeholder="Ceritakan fitur, tantangan, dan solusi dari projek ini...">{{ old('long_description') }}</textarea>
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label">Tech Stack</label>
                    <input type="text" name="tech_stack" class="form-control" value="{{ old('tech_stack') }}" placeholder="Laravel, Vue.js, MySQL (pisahkan dengan koma)">
                </div>
            </div>
            
            <div class="glass-panel p-6">
                <h2 class="text-xl font-bold mb-6 border-b pb-4" style="border-bottom-color: var(--glass-border)">
                    Panduan Login (Kredensial)
                </h2>
                <p class="text-sm text-secondary mb-6">Jika projek ini adalah aplikasi web yang membutuhkan login, berikan akun testing agar user bisa mencoba aplikasi secara lokal.</p>
                
                <div x-data="credentialsForm()">
                    <template x-for="(cred, index) in credentials" :key="index">
                        <div class="bg-tertiary p-4 rounded-lg mb-4 relative border" style="border-color: var(--glass-border)">
                            <button type="button" @click="removeCred(index)" class="absolute top-2 right-2 text-danger hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                            </button>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div class="form-group mb-0">
                                    <label class="form-label text-xs">Username / Email</label>
                                    <input type="text" :name="`credentials_username[]`" x-model="cred.username" class="form-control py-1 px-2 text-sm" placeholder="admin@example.com">
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form-label text-xs">Password</label>
                                    <input type="text" :name="`credentials_password[]`" x-model="cred.password" class="form-control py-1 px-2 text-sm" placeholder="password123">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group mb-0">
                                    <label class="form-label text-xs">Role</label>
                                    <input type="text" :name="`credentials_role[]`" x-model="cred.role" class="form-control py-1 px-2 text-sm" placeholder="Admin">
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form-label text-xs">Catatan Tambahan</label>
                                    <input type="text" :name="`credentials_note[]`" x-model="cred.note" class="form-control py-1 px-2 text-sm" placeholder="Akses penuh">
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <button type="button" @click="addCred()" class="btn btn-outline btn-sm w-full border-dashed">
                        + Tambah Akun Demo
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Form (Kanan) -->
        <div class="lg:col-span-1">
            <div class="glass-panel p-6 mb-8">
                <h2 class="text-xl font-bold mb-6 border-b pb-4" style="border-bottom-color: var(--glass-border)">Pengaturan & File</h2>
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" style="background-color: var(--bg-tertiary)">
                        <option value="published">Publish (Tampil)</option>
                        <option value="draft">Draft (Sembunyikan)</option>
                    </select>
                </div>
                
                <div class="form-group mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 rounded" style="background-color: var(--bg-tertiary); border: 1px solid var(--glass-border)">
                        <div>
                            <span class="block font-medium">Jadikan Unggulan (Featured)</span>
                            <span class="block text-xs text-secondary">Tampil di halaman depan</span>
                        </div>
                    </label>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Thumbnail Projek</label>
                    <div class="border-2 border-dashed rounded-lg p-4 text-center" style="border-color: var(--glass-border)">
                        <input type="file" name="thumbnail" class="w-full text-sm" accept="image/*">
                        <div class="mt-3 text-xs leading-relaxed text-secondary bg-bg-tertiary p-3 rounded-lg text-left">
                            <strong>⚠️ Panduan Gambar:</strong><br>
                            - Gunakan format <strong>Lanskap/Horizontal (Rasio 16:9)</strong>.<br>
                            - Resolusi yang disarankan: <strong>1280x720</strong> atau <strong>1920x1080</strong> pixel.<br>
                            - <i>Hindari foto vertikal (berdiri) karena akan meninggalkan ruang kosong hitam di sisinya.</i>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label text-success flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                        Upload Source Code (ZIP/RAR)
                    </label>
                    <div class="border-2 border-dashed border-success/30 bg-success/5 rounded-lg p-4 text-center">
                        <input type="file" name="zip_file" class="w-full text-sm" accept=".zip,.rar,.7z">
                        <p class="text-xs text-secondary mt-2">File ZIP/RAR projek. User bisa mengunduh file ini.</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label text-accent-primary flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                        Upload Aplikasi Android (APK)
                    </label>
                    <div class="border-2 border-dashed border-accent-primary/30 bg-accent-primary/5 rounded-lg p-4 text-center">
                        <input type="file" name="apk_file" class="w-full text-sm" accept=".apk">
                        <p class="text-xs text-secondary mt-2">Opsional. File <strong>.apk</strong> khusus untuk perangkat <strong>Android</strong>.</p>
                    </div>
                </div>
            </div>
            
            <div class="glass-panel p-6 mb-8">
                <h2 class="text-xl font-bold mb-6 border-b pb-4" style="border-bottom-color: var(--glass-border)">Tautan Eksternal</h2>
                
                <div class="form-group">
                    <label class="form-label flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                        URL Live Demo
                    </label>
                    <input type="url" name="demo_url" class="form-control py-2" value="{{ old('demo_url') }}" placeholder="https://demo.example.com">
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
                        URL Github Repository
                    </label>
                    <input type="url" name="github_url" class="form-control py-2" value="{{ old('github_url') }}" placeholder="https://github.com/user/repo">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-full py-4 text-lg">Simpan & Publikasi Projek</button>
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
