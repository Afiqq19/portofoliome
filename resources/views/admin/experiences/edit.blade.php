@extends('layouts.admin')

@section('content')
<div class="mb-8 flex items-center gap-3">
    <a href="{{ route('admin.experiences.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-colors shadow-sm">
        <i class='bx bx-left-arrow-alt text-xl'></i>
    </a>
    <div>
        <h1 class="text-2xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Edit Pengalaman</h1>
        <p class="text-slate-500 text-xs">Perbarui riwayat perjalanan karir atau pencapaian portofolio Anda.</p>
    </div>
</div>

<div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm max-w-4xl">
    <form action="{{ route('admin.experiences.update', $experience->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="form-group mb-0">
                <label class="form-label">Judul Peran / Pengalaman <span class="text-rose-500">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $experience->title) }}" required placeholder="Contoh: Freelance Fullstack Developer">
            </div>
            
            <div class="form-group mb-0">
                <label class="form-label">Nama Perusahaan / Organisasi</label>
                <input type="text" name="company" class="form-control" value="{{ old('company', $experience->company) }}" placeholder="Contoh: PT Teknologi Modern (Boleh dikosongkan)">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="form-group mb-0">
                <label class="form-label">Periode Waktu <span class="text-rose-500">*</span></label>
                <input type="text" name="period" class="form-control" value="{{ old('period', $experience->period) }}" required placeholder="Contoh: 2024 - Sekarang atau Jan 2023 - Des 2023">
            </div>

            <div class="form-group mb-0">
                <label class="form-label">Warna Tema (Aksen)</label>
                <select name="color" class="form-control cursor-pointer">
                    <option value="indigo" {{ old('color', $experience->color) == 'indigo' ? 'selected' : '' }}>Indigo (Biru Keunguan)</option>
                    <option value="cyan" {{ old('color', $experience->color) == 'cyan' ? 'selected' : '' }}>Cyan (Biru Muda)</option>
                    <option value="purple" {{ old('color', $experience->color) == 'purple' ? 'selected' : '' }}>Purple (Ungu)</option>
                    <option value="emerald" {{ old('color', $experience->color) == 'emerald' ? 'selected' : '' }}>Emerald (Hijau)</option>
                    <option value="rose" {{ old('color', $experience->color) == 'rose' ? 'selected' : '' }}>Rose (Merah Muda)</option>
                    <option value="amber" {{ old('color', $experience->color) == 'amber' ? 'selected' : '' }}>Amber (Kuning Keemasan)</option>
                </select>
            </div>
        </div>

        <div class="form-group mb-6">
            <label class="form-label">Deskripsi Pengalaman <span class="text-rose-500">*</span></label>
            <textarea name="description" class="form-control" rows="4" required placeholder="Ceritakan apa saja tanggung jawab, tantangan, atau pencapaian Anda selama periode ini...">{{ old('description', $experience->description) }}</textarea>
            <p class="text-xs text-slate-500 mt-1">Gunakan kalimat yang profesional namun tetap menarik dibaca.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="form-group mb-0">
                <label class="form-label">Keahlian Terkait (Tags)</label>
                <input type="text" name="tags" class="form-control" value="{{ old('tags', $experience->tags) }}" placeholder="Laravel, Vue.js, MySQL, API">
                <p class="text-xs text-slate-500 mt-1">Pisahkan dengan koma (,). Contoh: <code>HTML, CSS, UI/UX</code></p>
            </div>
            
            <div class="form-group mb-0">
                <label class="form-label">Urutan Tampil (Order)</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $experience->order) }}" min="0" required>
                <p class="text-xs text-slate-500 mt-1">Angka yang lebih kecil akan tampil lebih dulu (di atas).</p>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <label class="flex items-center cursor-pointer p-3 pr-4 rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100 transition-colors">
                <div class="relative inline-flex items-center">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $experience->is_published) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 shadow-inner"></div>
                </div>
                <span class="ml-3 text-sm font-bold text-slate-700">Publikasikan</span>
            </label>

            <button type="submit" class="btn btn-primary px-8 py-3 font-bold text-sm shadow-md flex items-center gap-2 w-full sm:w-auto justify-center">
                <i class='bx bx-save text-lg'></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>

    </form>
</div>
@endsection
