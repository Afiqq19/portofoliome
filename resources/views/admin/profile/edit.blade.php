@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-2">Profil & Sosmed</h1>
        <p class="text-secondary">Kelola data diri dan tautan sosial media yang tampil di halaman portofolio.</p>
    </div>
</div>

<div class="profile-layout">
    <!-- Form Profil -->
    <div class="profile-main">
        <div class="glass-panel" style="padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <h2 class="text-xl font-bold border-b flex items-center gap-2" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom-color: var(--glass-border);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Data Profil
            </h2>
            
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="flex items-center gap-5 bg-tertiary border border-glass w-full" style="padding: 1.5rem; margin-bottom: 2rem; border-radius: var(--radius-lg);">
                    <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-upload').click()">
                        @if($profile->avatar)
                            <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent-primary); box-shadow: 0 5px 15px var(--accent-glow);" class="transition-transform group-hover:scale-105">
                        @else
                            <div style="width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: bold; border: 2px dashed var(--glass-border);" class="bg-secondary text-muted transition-transform group-hover:scale-105">
                                ?
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-lg" style="margin-bottom: 0.25rem;">Foto Profil</label>
                        <p class="text-sm text-secondary" style="margin-bottom: 0.75rem;">Upload foto terbaik Anda untuk ditampilkan di halaman depan. Max 10MB (JPG/PNG).</p>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="document.getElementById('avatar-upload').click()" class="btn btn-outline btn-sm py-1 px-3 border-glass">
                                Ganti Foto
                            </button>
                            <span class="text-xs text-accent-primary font-bold upload-filename"></span>
                        </div>
                        <input type="file" id="avatar-upload" name="avatar" style="display: none;" accept="image/*" onchange="this.parentElement.querySelector('.upload-filename').innerText = 'File terpilih: ' + this.files[0].name">
                    </div>
                </div>

                <div class="profile-grid">
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Nama Lengkap</label>
                        <div style="position: relative;">
                            <input type="text" name="name" class="form-control" style="padding-left: 2.75rem !important; width: 100%; box-sizing: border-box;" value="{{ old('name', $profile->name) }}" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Profesi / Title</label>
                        <div style="position: relative;">
                            <input type="text" name="title" class="form-control" style="padding-left: 2.75rem !important; width: 100%; box-sizing: border-box;" value="{{ old('title', $profile->title) }}" placeholder="e.g. Fullstack Developer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 7h10"/><path d="M7 12h10"/><path d="M7 17h10"/></svg>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Bio / Tentang Saya</label>
                    <textarea name="bio" class="form-control" rows="5" style="width: 100%; box-sizing: border-box; padding: 1rem;">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div class="profile-grid">
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Email Publik</label>
                        <div style="position: relative;">
                            <input type="email" name="email" class="form-control" style="padding-left: 2.75rem !important; width: 100%; box-sizing: border-box;" value="{{ old('email', $profile->email) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m2 22 5-5"/><path d="m22 22-5-5"/><path d="m2 4 10 8 10-8"/></svg>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Nomor Telepon</label>
                        <div style="position: relative;">
                            <input type="text" name="phone" class="form-control" style="padding-left: 2.75rem !important; width: 100%; box-sizing: border-box;" value="{{ old('phone', $profile->phone) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Lokasi</label>
                    <div style="position: relative;">
                        <input type="text" name="location" class="form-control" style="padding-left: 2.75rem !important; width: 100%; box-sizing: border-box;" value="{{ old('location', $profile->location) }}" placeholder="e.g. Jakarta, Indonesia">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn btn-primary flex items-center gap-2" style="padding: 1rem 2rem;">
                        Simpan Profil
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Form Sosmed -->
    <div class="profile-sidebar">
        <div class="glass-panel sticky" style="top: 100px; padding: 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
            <h2 class="text-xl font-bold border-b flex items-center gap-2" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom-color: var(--glass-border);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                Sosial Media
            </h2>
            
            <form action="{{ route('admin.profile.social-links') }}" method="POST" x-data="socialLinksForm()">
                @csrf
                @method('PUT')
                
                <template x-for="(link, index) in links" :key="index">
                    <div class="glass-panel relative bg-tertiary group" style="padding: 1rem; margin-bottom: 1rem; border-radius: var(--radius-md); border-left: 3px solid var(--accent-primary);">
                        <button type="button" @click="removeLink(index)" class="absolute border-0 bg-transparent cursor-pointer text-danger hover:scale-110 transition-transform opacity-50 hover:opacity-100" style="top: 0.5rem; right: 0.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                        </button>
                        
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.25rem;">Platform</label>
                            <input type="text" :name="`links[${index}][platform]`" x-model="link.platform" @input="autoFillIcon(index)" class="form-control" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; width: 100%; box-sizing: border-box;" placeholder="Github" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0.75rem;">
                            <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.25rem;">URL Tautan</label>
                            <input type="url" :name="`links[${index}][url]`" x-model="link.url" class="form-control" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; width: 100%; box-sizing: border-box;" placeholder="https://..." required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.25rem;">Icon Class (Opsional)</label>
                            <input type="text" :name="`links[${index}][icon]`" x-model="link.icon" class="form-control text-secondary" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; width: 100%; box-sizing: border-box;" placeholder="bx bxl-github">
                        </div>
                    </div>
                </template>
                
                <button type="button" @click="addLink()" class="btn btn-outline w-full border-dashed flex justify-center items-center gap-2" style="margin-bottom: 1.5rem; padding: 0.75rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                    Tambah Tautan
                </button>
                
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary w-full flex justify-center items-center gap-2" style="padding: 1rem;">
                        Simpan Sosial Media
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Custom Layout for Profile Page */
.profile-layout { display: flex; flex-direction: column; gap: 2rem; }
.profile-main { width: 100%; }
.profile-sidebar { width: 100%; }
.profile-grid { display: grid; grid-template-columns: 1fr; gap: 1rem; }

@media (min-width: 1024px) {
    .profile-layout { flex-direction: row; }
    .profile-main { width: 66.666%; }
    .profile-sidebar { width: 33.333%; }
    .profile-grid { grid-template-columns: 1fr 1fr; }
}

.form-control:focus {
    box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
    border-color: var(--accent-primary);
}
</style>

<script>
function socialLinksForm() {
    return {
        links: {!! json_encode($profile->socialLinks->count() > 0 ? $profile->socialLinks->map(fn($l) => ['platform' => $l->platform, 'url' => $l->url, 'icon' => $l->icon]) : [['platform' => 'Github', 'url' => '', 'icon' => '']]) !!},
        addLink() {
            this.links.push({ platform: '', url: '', icon: '' });
        },
        removeLink(index) {
            this.links.splice(index, 1);
        },
        autoFillIcon(index) {
            const platform = this.links[index].platform.toLowerCase().trim();
            const iconMap = {
                'github': 'bx bxl-github',
                'instagram': 'bx bxl-instagram',
                'linkedin': 'bx bxl-linkedin',
                'facebook': 'bx bxl-facebook',
                'twitter': 'bx bxl-twitter',
                'x': 'bx bxl-twitter',
                'youtube': 'bx bxl-youtube',
                'whatsapp': 'bx bxl-whatsapp',
                'tiktok': 'bx bxl-tiktok',
                'discord': 'bx bxl-discord',
                'telegram': 'bx bxl-telegram'
            };
            
            if (iconMap[platform]) {
                this.links[index].icon = iconMap[platform];
            }
        }
    }
}
</script>
@endsection
