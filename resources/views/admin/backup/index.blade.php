@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Backup & Restore Database</h1>
    <p class="text-slate-500 text-sm">Kelola pencadangan dan pemulihan database untuk keamanan data portofolio.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Download Backup -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between items-center text-center">
        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mb-4">
            <i class='bx bx-download'></i>
        </div>
        <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900 mb-2">Download File Backup</h3>
        <p class="text-slate-500 text-xs leading-relaxed mb-6 max-w-sm">
            Unduh seluruh struktur dan data database dalam format file SQL (.sql) sebagai cadangan lokal.
        </p>
        <a href="{{ route('admin.backup.download') }}" class="btn btn-primary w-full py-3 text-sm font-bold shadow-md flex items-center justify-center gap-2">
            <i class='bx bx-cloud-download text-lg'></i>
            <span>Download Backup Sekarang</span>
        </a>
    </div>

    <!-- Upload Backup -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between items-center text-center">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-4">
            <i class='bx bx-upload'></i>
        </div>
        <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900 mb-2">Upload File Cadangan</h3>
        <p class="text-slate-500 text-xs leading-relaxed mb-6 max-w-sm">
            Unggah file SQL cadangan untuk disimpan atau dipulihkan kembali ke dalam database.
        </p>
        <form action="{{ route('admin.backup.store') }}" method="POST" enctype="multipart/form-data" class="w-full space-y-3">
            @csrf
            <input type="file" name="backup_file" accept=".sql,.txt" required class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border file:border-slate-200 file:text-xs file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100 cursor-pointer">
            @error('backup_file')
                <span class="text-rose-600 text-xs block">{{ $message }}</span>
            @enderror
            <button type="submit" class="btn btn-outline w-full py-3 text-sm font-bold flex items-center justify-center gap-2 hover:border-emerald-500 hover:text-emerald-600 cursor-pointer">
                <i class='bx bx-cloud-upload text-lg'></i>
                <span>Upload File SQL</span>
            </button>
        </form>
    </div>
</div>

<!-- History -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900">Riwayat File Backup</h3>
            <p class="text-xs text-slate-500">Daftar file cadangan database yang tersimpan di server</p>
        </div>
    </div>
    
    <div class="table-container border-0 rounded-none shadow-none">
        @if(empty($backups))
            <div class="p-16 text-center text-slate-500">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class='bx bx-data'></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada File Cadangan</h3>
                <p class="text-sm text-slate-400">Klik tombol "Download Backup Sekarang" untuk membuat cadangan data pertama.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nama File</th>
                        <th width="120">Ukuran</th>
                        <th width="180">Tanggal Buat</th>
                        <th width="160" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($backups as $backup)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td>
                            <div class="flex items-center gap-2.5 font-mono text-xs font-bold text-slate-800 break-all">
                                <i class='bx bx-file text-indigo-500 text-base'></i>
                                <span>{{ $backup['name'] }}</span>
                            </div>
                        </td>
                        <td class="text-xs text-slate-500 whitespace-nowrap">{{ $backup['size'] }} KB</td>
                        <td class="text-xs text-slate-500 whitespace-nowrap">{{ $backup['date'] }}</td>
                        <td class="text-right">
                            <div class="flex gap-2 justify-end">
                                <form action="{{ route('admin.backup.restore') }}" method="POST" onsubmit="return confirm('⚠️ PERINGATAN: Tindakan ini akan menimpa data database saat ini dengan data dari file backup ini!\n\nLanjutkan restore?')">
                                    @csrf
                                    <input type="hidden" name="filename" value="{{ $backup['name'] }}">
                                    <button type="submit" class="btn btn-sm btn-outline text-amber-600 border-amber-200 hover:bg-amber-500 hover:text-white cursor-pointer" title="Restore Data">
                                        <i class='bx bx-refresh'></i>
                                        <span>Restore</span>
                                    </button>
                                </form>
                                <form action="{{ route('admin.backup.delete') }}" method="POST" onsubmit="return confirm('Hapus file backup ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="filename" value="{{ $backup['name'] }}">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white inline-flex items-center justify-center transition-colors cursor-pointer" title="Hapus File">
                                        <i class='bx bx-trash text-base'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
