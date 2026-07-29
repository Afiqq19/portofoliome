@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0 mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline btn-sm px-2 text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold mb-1">Edit Sertifikat</h1>
            <p class="text-secondary">Perbarui informasi sertifikat atau penghargaan Anda.</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form (Kiri) -->
        <div class="lg:col-span-2">
            <div class="glass-panel p-6 mb-8">
                <h2 class="text-xl font-bold mb-6 border-b pb-4" style="border-bottom-color: var(--glass-border)">Informasi Dasar</h2>
                
                <div class="form-group">
                    <label class="form-label">Judul Sertifikat / Penghargaan <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $certificate->title) }}" required>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Penerbit (Issuer)</label>
                        <input type="text" name="issuer" class="form-control" value="{{ old('issuer', $certificate->issuer) }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tanggal / Tahun</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $certificate->date ? $certificate->date->format('Y-m-d') : '') }}">
                    </div>
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $certificate->description) }}</textarea>
                </div>
            </div>
            
            <div class="glass-panel p-6">
                <h2 class="text-xl font-bold mb-6 border-b pb-4" style="border-bottom-color: var(--glass-border)">Tautan Verifikasi (Opsional)</h2>
                
                <div class="form-group mb-0">
                    <label class="form-label flex items-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        URL Kredensial / Bukti Sertifikat
                    </label>
                    <input type="url" name="credential_url" class="form-control py-2" value="{{ old('credential_url', $certificate->credential_url) }}">
                </div>
            </div>
        </div>

        <!-- Sidebar Form (Kanan) -->
        <div class="lg:col-span-1">
            <div class="glass-panel p-6 mb-8">
                <h2 class="text-xl font-bold mb-6 border-b pb-4" style="border-bottom-color: var(--glass-border)">Pengaturan Visual</h2>
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" style="background-color: var(--bg-tertiary)">
                        <option value="published" {{ $certificate->status === 'published' ? 'selected' : '' }}>Publish (Tampil)</option>
                        <option value="draft" {{ $certificate->status === 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                    </select>
                </div>
                
                <div class="form-group mb-0">
                    <label class="form-label">Gambar Sertifikat / Bukti</label>
                    @if($certificate->image)
                        <div class="mb-3 flex justify-start">
                            <img src="{{ asset('storage/' . $certificate->image) }}" alt="Thumb" style="width: 150px; height: 100px; object-fit: cover; border-radius: 0.5rem; border: 2px solid var(--accent-primary);">
                        </div>
                    @endif
                    <div class="border-2 border-dashed rounded-lg p-4 text-center" style="border-color: var(--glass-border)">
                        <input type="file" name="image" class="w-full text-sm" accept="image/*">
                        <div class="mt-3 text-xs leading-relaxed text-secondary bg-bg-tertiary p-3 rounded-lg text-left">
                            <strong>⚠️ Panduan Gambar:</strong><br>
                            - Biarkan kosong jika tidak ingin mengubah.<br>
                            - Disarankan rasio lanskap agar rapi.
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-full py-4 text-lg font-bold">Simpan Perubahan</button>
        </div>
    </div>
</form>
@endsection
