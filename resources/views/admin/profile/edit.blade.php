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
                
                <!-- Upload Cards (Foto Profil & Dokumen CV) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                    <!-- Foto Profil -->
                    <div class="flex flex-col sm:flex-row items-center gap-5 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="relative group cursor-pointer flex-shrink-0" onclick="document.getElementById('avatar-upload').click()">
                            @if($profile && $profile->avatar)
                                <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-2xl object-cover border-2 border-indigo-500 shadow-md group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-20 h-20 rounded-2xl bg-indigo-100 text-indigo-600 font-bold text-2xl flex items-center justify-center border-2 border-dashed border-indigo-300 group-hover:scale-105 transition-transform">
                                    {{ substr($profile->name ?? 'A', 0, 1) }}
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-slate-900/40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class='bx bx-camera text-xl text-white'></i>
                            </div>
                        </div>
                        <div class="text-center sm:text-left flex-1 min-w-0">
                            <label class="block font-bold text-slate-900 text-sm mb-1">Foto Profil</label>
                            <p class="text-[11px] text-slate-500 mb-3">Format JPG/PNG, maks 10MB.</p>
                            <div class="flex items-center justify-center sm:justify-start gap-2">
                                <button type="button" onclick="document.getElementById('avatar-upload').click()" class="btn btn-outline btn-xs shadow-sm hover:border-indigo-500 hover:text-indigo-600">
                                    <i class='bx bx-upload'></i>
                                    <span>Pilih Foto</span>
                                </button>
                                <span class="text-[11px] text-indigo-600 font-semibold truncate avatar-filename"></span>
                            </div>
                            <input type="file" id="avatar-upload" name="avatar" class="hidden" accept="image/*" onchange="this.parentElement.querySelector('.avatar-filename').innerText = this.files[0] ? this.files[0].name : ''">
                        </div>
                    </div>

                    <!-- Dokumen CV / Resume -->
                    <div class="flex flex-col sm:flex-row items-center gap-5 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="relative group cursor-pointer flex-shrink-0" onclick="document.getElementById('resume-upload').click()">
                            <div class="w-20 h-20 rounded-2xl {{ ($profile && $profile->resume_path) ? 'bg-emerald-50 text-emerald-600 border-emerald-300' : 'bg-slate-100 text-slate-400 border-slate-300' }} border-2 border-dashed flex flex-col items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                <i class='bx bxs-file-pdf text-3xl {{ ($profile && $profile->resume_path) ? 'text-emerald-500' : 'text-slate-400' }}'></i>
                                <span class="text-[9px] font-extrabold uppercase mt-0.5">PDF</span>
                            </div>
                            <div class="absolute inset-0 bg-slate-900/40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class='bx bx-upload text-xl text-white'></i>
                            </div>
                        </div>
                        <div class="text-center sm:text-left flex-1 min-w-0">
                            <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                                <label class="block font-bold text-slate-900 text-sm">Dokumen CV (PDF)</label>
                                @if($profile && $profile->resume_path)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                        <i class='bx bx-check-circle'></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-200 text-slate-600">
                                        Belum Ada
                                    </span>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-500 mb-3">Format PDF, maks 10MB.</p>
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                                <button type="button" onclick="document.getElementById('resume-upload').click()" class="btn btn-outline btn-xs shadow-sm hover:border-indigo-500 hover:text-indigo-600">
                                    <i class='bx bx-upload'></i>
                                    <span>{{ ($profile && $profile->resume_path) ? 'Ganti CV' : 'Pilih File CV' }}</span>
                                </button>
                                @if($profile && $profile->resume_path)
                                    <a href="{{ route('cv.download') }}" target="_blank" class="btn btn-outline btn-xs shadow-sm text-indigo-600 hover:bg-indigo-50 flex items-center gap-1" title="Unduh / Cek file CV saat ini">
                                        <i class='bx bx-download'></i>
                                        <span>Unduh</span>
                                    </a>
                                    <button type="button" onclick="if(confirm('Yakin ingin menghapus file CV saat ini?')) document.getElementById('delete-resume-form').submit();" class="text-rose-500 hover:text-rose-700 text-xs font-semibold p-1 hover:bg-rose-50 rounded" title="Hapus file CV">
                                        <i class='bx bx-trash text-base'></i>
                                    </button>
                                @endif
                            </div>
                            <span class="text-[11px] text-indigo-600 font-semibold truncate block mt-1 resume-filename"></span>
                            <input type="file" id="resume-upload" name="resume" class="hidden" accept=".pdf,application/pdf" onchange="this.parentElement.querySelector('.resume-filename').innerText = this.files[0] ? ('File: ' + this.files[0].name) : ''">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="form-group mb-0">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $profile->name ?? '') }}" required placeholder="Nama Anda">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Profesi / Judul Keahlian</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $profile->title ?? '') }}" placeholder="Fullstack Developer, UI/UX Designer">
                        <p class="text-[11px] text-slate-500 mt-1">💡 Pisahkan dengan koma <code>,</code> untuk teks mengetik otomatis</p>
                    </div>
                </div>

                <div class="form-group mb-5">
                    <label class="form-label">Bio / Tentang Saya</label>
                    <textarea name="bio" class="form-control" rows="5" placeholder="Ceritakan latar belakang, fokus teknologi, dan pengalaman Anda...">{{ old('bio', $profile->bio ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="form-group mb-0">
                        <label class="form-label">Email Publik</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $profile->email ?? '') }}" placeholder="email@domain.com">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone ?? '') }}" placeholder="+62 812 3456 7890">
                    </div>
                </div>

                <div class="form-group mb-8">
                    <label class="form-label">Lokasi / Domisili</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $profile->location ?? '') }}" placeholder="Jakarta, Indonesia">
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
                <span>Tautan Media Sosial</span>
            </h2>

            <form action="{{ route('admin.profile.social-links') }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $platforms = [
                        ['name' => 'GitHub', 'icon' => 'bx bxl-github', 'key' => 'github'],
                        ['name' => 'LinkedIn', 'icon' => 'bx bxl-linkedin', 'key' => 'linkedin'],
                        ['name' => 'Instagram', 'icon' => 'bx bxl-instagram', 'key' => 'instagram'],
                        ['name' => 'WhatsApp', 'icon' => 'bx bxl-whatsapp', 'key' => 'whatsapp'],
                        ['name' => 'YouTube', 'icon' => 'bx bxl-youtube', 'key' => 'youtube'],
                    ];
                    $socialLinks = $profile && $profile->socialLinks ? $profile->socialLinks->keyBy('platform') : collect();
                @endphp

                <div class="space-y-4 mb-6">
                    @foreach($platforms as $p)
                        @php
                            $link = $socialLinks->get($p['name']);
                            $val = old('urls.' . $loop->index, $link ? $link->url : '');
                            $placeholder = match($p['key']) {
                                'whatsapp' => 'Contoh: 08123456789 atau wa.me/628123456789',
                                'instagram' => 'Contoh: @username atau instagram.com/username',
                                'github' => 'Contoh: username atau github.com/username',
                                'linkedin' => 'Contoh: in/username atau linkedin.com/in/username',
                                'youtube' => 'Contoh: @channel atau youtube.com/@channel',
                                default => 'https://...',
                            };
                        @endphp
                        <div>
                            <label class="form-label text-xs flex items-center justify-between">
                                <span class="flex items-center gap-1.5 font-semibold text-slate-700">
                                    <i class="{{ $p['icon'] }} text-base text-indigo-600"></i>
                                    <span>{{ $p['name'] }}</span>
                                </span>
                                @if($link && $link->url)
                                    <a href="{{ $link->url }}" target="_blank" class="text-[10px] text-indigo-600 hover:underline flex items-center gap-0.5">
                                        <span>Tes Link</span>
                                        <i class='bx bx-link-external'></i>
                                    </a>
                                @endif
                            </label>
                            <input type="hidden" name="platforms[]" value="{{ $p['name'] }}">
                            <input type="hidden" name="icons[]" value="{{ $p['icon'] }}">
                            <input type="text" name="urls[]" class="form-control text-xs py-2 px-3" value="{{ $val }}" placeholder="{{ $placeholder }}">
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 text-sm font-bold flex items-center justify-center gap-2 shadow-md">
                    <i class='bx bx-save text-lg'></i>
                    <span>Perbarui Tautan Sosmed</span>
                </button>
            </form>
        </div>
    </div>

</div>

<form id="delete-resume-form" action="{{ route('admin.profile.delete-resume') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection
