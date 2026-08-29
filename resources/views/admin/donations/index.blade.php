@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Integrasi Donasi (Trakteer.id)</h1>
    <p class="text-slate-500 text-sm">Kelola tautan dan penerimaan donasi kopi atau apresiasi dari pengunjung.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Form Trakteer -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl">
                ☕
            </div>
            <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900">
                Tautan Profil Trakteer
            </h3>
        </div>
        
        <form action="{{ route('admin.donations.update-trakteer') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-6">
                <label class="form-label text-xs">URL Creator / Tip Trakteer Anda</label>
                <div class="relative">
                    <input type="url" name="trakteer_url" class="form-control text-sm" value="{{ old('trakteer_url', $profile->trakteer_url ?? '') }}" placeholder="https://trakteer.id/username/tip">
                </div>
                @error('trakteer_url')
                    <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">Tautan ini otomatis aktif pada tombol <strong>"☕ Traktir Kopi"</strong> di setiap detail halaman projek.</p>
            </div>
            
            <button type="submit" class="btn btn-primary w-full py-3.5 text-sm font-bold flex items-center justify-center gap-2 shadow-md">
                <i class='bx bx-save text-lg'></i>
                <span>Simpan Pengaturan Donasi</span>
            </button>
        </form>
    </div>

    <!-- Info Trakteer -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-xl font-bold font-['Space_Grotesk'] text-slate-900 mb-4 pb-4 border-b border-slate-100 flex items-center gap-2">
            <i class='bx bx-info-circle text-rose-600'></i>
            <span>Keunggulan Integrasi Trakteer</span>
        </h3>
        
        <ul class="text-slate-600 text-sm space-y-3 mb-6">
            <li class="flex items-start gap-2">
                <i class='bx bx-check-circle text-emerald-600 text-lg mt-0.5'></i>
                <span>Mendukung pembayaran instan otomatis via QRIS, GoPay, OVO, ShopeePay, & Dana.</span>
            </li>
            <li class="flex items-start gap-2">
                <i class='bx bx-check-circle text-emerald-600 text-lg mt-0.5'></i>
                <span>Verifikasi otomatis tanpa perlu konfirmasi bukti transfer manual.</span>
            </li>
            <li class="flex items-start gap-2">
                <i class='bx bx-check-circle text-emerald-600 text-lg mt-0.5'></i>
                <span>Notifikasi langsung masuk ke email dan aplikasi Trakteer Anda.</span>
            </li>
        </ul>
        
        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
            <p class="text-xs text-slate-600 leading-relaxed">
                <strong class="text-slate-900 block mb-1">💡 Pantau Saldo & Pendapatan:</strong>
                Silakan login langsung ke <a href="https://trakteer.id" target="_blank" rel="noopener noreferrer" class="text-indigo-600 font-bold hover:underline">Dashboard Creator Trakteer</a> untuk menarik saldo ke rekening bank/e-wallet Anda.
            </p>
        </div>
    </div>
</div>
@endsection
