@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Profil & Media Sosial</h1>
    <p class="text-slate-500 text-sm">Kelola data diri, bio, kontak publik, dan tautan sosial media yang tampil di halaman portofolio.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Form Data Diri (2 Cols) -->
    <div class="lg:col-span-2">
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2.5">
                <i class='bx bx-user-circle text-2xl text-indigo-600'></i>
                <span>Data Profil Utama</span>
            </h2>
            
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Avatar Upload Card -->
                <div class="flex flex-col sm:flex-row items-center gap-6 p-6 mb-8 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="relative group cursor-pointer flex-shrink-0" onclick="document.getElementById('avatar-upload').click()">
                        @if($profile->avatar)
                            <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-2xl object-cover border-2 border-indigo-500 shadow-md group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-24 h-24 rounded-2xl bg-indigo-100 text-indigo-600 font-bold text-3xl flex items-center justify-center border-2 border-dashed border-indigo-300 group-hover:scale-105 transition-transform">
                                {{ substr($profile->name ?? 'A', 0, 1) }}
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-slate-900/40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class='bx bx-camera text-2xl text-white'></i>
                        </div>
                    </div>
                    <div class="text-center sm:text-left">
                        <label class="block font-bold text-slate-900 text-base mb-1">Foto Profil</label>
                        <p class="text-xs text-slate-500 mb-3">Format JPG/PNG, ukuran maksimal 10MB. Foto akan ditampilkan di hero portofolio.</p>
                        <div class="flex items-center justify-center sm:justify-start gap-3">
                            <button type="button" onclick="document.getElementById('avatar-upload').click()" class="btn btn-outline btn-sm shadow-sm hover:border-indigo-500 hover:text-indigo-600">
                                <i class='bx bx-upload'></i>
                                <span>Pilih Foto</span>
                            </button>
                            <span class="text-xs text-indigo-600 font-semibold upload-filename"></span>
                        </div>
                        <input type="file" id="avatar-upload" name="avatar" class="hidden" accept="image/*" onchange="this.parentElement.querySelector('.upload-filename').innerText = 'File: ' + this.files[0].name">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="form-group mb-0">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $profile->name) }}" required placeholder="Nama Anda">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">
                            Profesi / Judul Keahlian
                        </label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $profile->title) }}" placeholder="Fullstack Developer, UI/UX Designer">
                        <p class="text-[11px] text-slate-500 mt-1">💡 Pisahkan dengan koma <code>,</code> untuk teks mengetik otomatis</p>
                    </div>
                </div>

                <div class="form-group mb-5">
                    <label class="form-label">Bio / Tentang Saya</label>
                    <textarea name="bio" class="form-control" rows="5" placeholder="Ceritakan latar belakang, fokus teknologi, dan pengalaman Anda...">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="form-group mb-0">
                        <label class="form-label">Email Publik</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $profile->email) }}" placeholder="email@domain.com">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}" placeholder="+62 812 3456 7890">
                    </div>
                </div>

                <div class="form-group mb-8">
                    <label class="form-label">Lokasi / Domisili</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $profile->location) }}" placeholder="Jakarta, Indonesia">
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="btn btn-primary px-6 py-3 font-bold text-sm flex items-center gap-2 shadow-md">
                        <i class='bx bx-save text-lg'></i>
                        <span>Simpan Perubahan Profil</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Form Media Sosial (1 Col) -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm sticky top-28">
            <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2.5">
                <i class='bx bx-share-alt text-2xl text-purple-600'></i>
                <span>Tautan Sosial Media</span>
            </h2>
            
            <form action="{{ route('admin.profile.social-links') }}" method="POST" x-data="socialLinksForm()">
                @csrf
                @method('PUT')
                
                <div class="space-y-4 mb-6">
                    <template x-for="(link, index) in links" :key="index">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 relative group">
                            <button type="button" @click="removeLink(index)" class="absolute top-3 right-3 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus Tautan">
                                <i class='bx bx-trash text-lg'></i>
                            </button>
                            
                            <div class="form-group mb-3">
                                <label class="form-label text-xs">Platform / Nama</label>
                                <input type="text" :name="`links[${index}][platform]`" x-model="link.platform" @input="autoFillIcon(index)" class="form-control text-xs py-2 px-3" placeholder="Contoh: GitHub, Instagram, LinkedIn" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label text-xs">URL Tautan</label>
                                <input type="url" :name="`links[${index}][url]`" x-model="link.url" class="form-control text-xs py-2 px-3" placeholder="https://github.com/..." required>
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label text-xs">Class Icon BoxIcons (Opsional)</label>
                                <input type="text" :name="`links[${index}][icon]`" x-model="link.icon" class="form-control text-xs py-2 px-3 font-mono text-slate-500" placeholder="bx bxl-github">
                            </div>
                        </div>
                    </template>
                </div>
                
                <button type="button" @click="addLink()" class="btn btn-outline w-full py-2.5 text-xs font-bold border-dashed mb-6 flex items-center justify-center gap-2 hover:border-indigo-500 hover:text-indigo-600">
                    <i class='bx bx-plus'></i>
                    <span>Tambah Tautan Baru</span>
                </button>
                
                <button type="submit" class="btn btn-primary w-full py-3 text-sm font-bold flex items-center justify-center gap-2 shadow-md">
                    <i class='bx bx-check-circle text-lg'></i>
                    <span>Simpan Media Sosial</span>
                </button>
            </form>
        </div>
    </div>

</div>

<script>
function socialLinksForm() {
    return {
        links: {!! json_encode($profile->socialLinks->count() > 0 ? $profile->socialLinks->map(fn($l) => ['platform' => $l->platform, 'url' => $l->url, 'icon' => $l->icon]) : [['platform' => 'GitHub', 'url' => '', 'icon' => 'bx bxl-github']]) !!},
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
