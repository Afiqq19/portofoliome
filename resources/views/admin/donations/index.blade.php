@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-2">Integrasi Trakteer.id</h1>
        <p class="text-secondary">Kelola donasi Anda dengan mudah melalui platform Trakteer.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Form Trakteer -->
    <div class="glass-panel p-8 relative overflow-hidden group">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
        
        <h3 class="text-2xl font-bold mb-6 text-white flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
            Link Donasi Trakteer
        </h3>
        
        <form action="{{ route('admin.donations.update-trakteer') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-6">
                <label class="form-label text-sm mb-2 block text-secondary">URL Trakteer Anda</label>
                <div class="relative">
                    <input type="url" name="trakteer_url" class="form-control w-full pl-10" value="{{ old('trakteer_url', $profile->trakteer_url ?? '') }}" placeholder="Contoh: https://trakteer.id/mhd-syafiq-syahmi/tip" style="padding-left: 2.75rem !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="absolute left-3 top-1/2 -translate-y-1/2 text-secondary"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                </div>
                @error('trakteer_url')
                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
                <p class="text-xs text-muted mt-2">Tautan ini akan digunakan pada tombol "Donasi" di setiap halaman proyek Anda.</p>
            </div>
            
            <button type="submit" class="btn btn-primary w-full bg-red-500 hover:bg-red-600 border-none">Simpan Pengaturan</button>
        </form>
    </div>

    <!-- Info Trakteer -->
    <div class="glass-panel p-8 border-l-4 border-l-red-500" style="border-left: 4px solid #ef4444">
        <h3 class="text-xl font-bold mb-4 text-white">Mengapa Trakteer?</h3>
        <p class="text-secondary mb-4 leading-relaxed">
            Sistem web kini terintegrasi langsung dengan Trakteer. Ini memberi Anda banyak keuntungan:
        </p>
        <ul class="text-secondary space-y-3 mb-6 list-disc list-inside">
            <li>Mendukung pembayaran instan via QRIS, GoPay, OVO, Dana, dll.</li>
            <li>Tidak perlu repot mengecek mutasi secara manual.</li>
            <li>Notifikasi donasi yang lebih interaktif.</li>
            <li>Lebih terpercaya dan profesional di mata pengunjung.</li>
        </ul>
        
        <div class="p-4 bg-red-500/10 rounded-xl border border-red-500/20">
            <p class="text-sm text-red-200">
                <span class="font-bold block mb-1">Cek Riwayat Donasi:</span>
                Riwayat dan saldo donasi kini tidak lagi tampil di sini. Silakan login ke <a href="https://trakteer.id" target="_blank" class="text-white hover:underline font-bold">Creator Dashboard Trakteer</a> untuk memantau pemasukan Anda.
            </p>
        </div>
    </div>
</div>
@endsection
