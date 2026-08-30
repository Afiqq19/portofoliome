@extends('layouts.admin')

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.certificates.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-500 flex items-center justify-center shadow-sm transition-colors">
        <i class='bx bx-arrow-back text-lg'></i>
    </a>
    <div>
        <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Edit Sertifikat: {{ $certificate->title }}</h1>
        <p class="text-slate-500 text-sm">Perbarui rincian sertifikasi atau penghargaan.</p>
    </div>
</div>

<form action="{{ route('admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form (2 Cols) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2.5">
                    <i class='bx bx-edit text-2xl text-indigo-600'></i>
                    <span>Informasi Sertifikat</span>
                </h2>
                
                <div class="form-group mb-5">
                    <label class="form-label">Judul Sertifikat / Penghargaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" class="form-control text-sm" value="{{ old('title', $certificate->title) }}" required>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="form-group mb-0">
                        <label class="form-label">Penerbit (Issuer)</label>
                        <input type="text" name="issuer" class="form-control text-sm" value="{{ old('issuer', $certificate->issuer) }}">
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="form-label">Tanggal Terbit</label>
                        <input type="date" name="date" class="form-control text-sm" value="{{ old('date', $certificate->date ? $certificate->date->format('Y-m-d') : '') }}">
                    </div>
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="description" class="form-control text-sm" rows="3">{{ old('description', $certificate->description) }}</textarea>
                </div>
            </div>
            
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4 mb-4 flex items-center gap-2.5">
                    <i class='bx bx-link text-2xl text-purple-600'></i>
                    <span>Tautan Verifikasi Online</span>
                </h2>
                
                <div class="form-group mb-0">
                    <label class="form-label text-xs">URL Kredensial Resmi</label>
                    <input type="url" name="credential_url" class="form-control text-xs py-2 px-3" value="{{ old('credential_url', $certificate->credential_url) }}">
                </div>
            </div>
        </div>

        <!-- Sidebar Form (1 Col) -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                <h2 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 border-b border-slate-100 pb-4">
                    Status & Gambar
                </h2>
                
                <div class="form-group mb-0">
                    <label class="form-label text-xs">Status</label>
                    <select name="status" class="form-select text-sm">
                        <option value="published" {{ $certificate->status === 'published' ? 'selected' : '' }}>Publik (Tampilkan di Web)</option>
                        <option value="draft" {{ $certificate->status === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                    </select>
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label text-xs">Foto / Bukti Sertifikat</label>
                    @if($certificate->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $certificate->image) }}" alt="Thumb" class="w-full h-32 object-cover rounded-xl border border-slate-200 shadow-sm">
                        </div>
                    @endif
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center bg-slate-50">
                        <input type="file" name="image" class="w-full text-xs" accept="image/*">
                        <p class="text-[11px] text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-full py-4 text-base font-bold shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                <i class='bx bx-save text-xl'></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </div>
</form>
@endsection
