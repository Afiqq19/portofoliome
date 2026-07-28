@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">Backup & Restore Database</h1>
    <p class="text-secondary">Kelola backup database untuk keamanan data website Anda.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <!-- Download Backup -->
    <div class="glass-panel p-8 border-t-4 border-t-accent-primary flex flex-col justify-center items-center text-center h-full" style="border-top: 4px solid var(--accent-primary)">
        <div class="w-16 h-16 rounded-full bg-accent-primary/20 flex items-center justify-center text-accent-primary mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Download Backup</h3>
        <p class="text-secondary mb-6 text-sm">
            Unduh seluruh data database dalam format file SQL.<br>
            Simpan file ini di tempat yang aman sebagai cadangan.
        </p>
        <a href="{{ route('admin.backup.download') }}" class="btn btn-primary px-6 py-3 w-max">
            Download Backup Sekarang
        </a>
    </div>

    <!-- Upload Backup -->
    <div class="glass-panel p-8 border-t-4 border-t-success flex flex-col justify-center items-center text-center h-full" style="border-top: 4px solid var(--success)">
        <div class="w-16 h-16 rounded-full bg-success/20 flex items-center justify-center text-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Upload File Backup</h3>
        <p class="text-secondary mb-6 text-sm">
            Upload file SQL backup untuk disimpan di server.<br>
            Gunakan tombol Restore di bawah untuk mengembalikan data.
        </p>
        <form action="{{ route('admin.backup.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-3 w-full max-w-xs">
            @csrf
            <input type="file" name="backup_file" accept=".sql,.txt" required class="w-full text-sm text-secondary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-success/10 file:text-success hover:file:bg-success/20 cursor-pointer">
            @error('backup_file')
                <span class="text-danger text-xs">{{ $message }}</span>
            @enderror
            <button type="submit" class="btn" style="background: var(--success); color: white; border: none; padding: 0.75rem 1.5rem; width: max-content;">
                Upload File
            </button>
        </form>
    </div>
</div>

<!-- History -->
<div class="card">
    <div class="card-body border-b flex justify-between items-center" style="border-bottom-color: var(--glass-border)">
        <div>
            <h3 class="text-xl font-bold">Riwayat File Backup</h3>
            <p class="text-sm text-secondary">File backup yang tersimpan di server saat ini</p>
        </div>
    </div>
    
    <div class="p-0 table-container rounded-none border-0">
        @if(empty($backups))
            <div class="p-12 text-center text-secondary">
                <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-white/5 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                </div>
                <p>Belum ada file backup. Klik tombol "Download Backup Sekarang" untuk membuat backup pertama.</p>
            </div>
        @else
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="w-1/2 py-4 pl-6 text-xs uppercase tracking-wider text-secondary">Nama File</th>
                        <th class="w-1/6 py-4 text-xs uppercase tracking-wider text-secondary">Ukuran</th>
                        <th class="w-1/6 py-4 text-xs uppercase tracking-wider text-secondary">Tanggal</th>
                        <th class="w-1/6 py-4 pr-6 text-xs uppercase tracking-wider text-secondary text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($backups as $backup)
                    <tr class="hover:bg-white/5 transition-colors border-t border-white/5">
                        <td class="py-4 pl-6 font-bold flex items-center gap-3 break-all text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--text-secondary)" stroke-width="2" class="flex-shrink-0"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            <span class="text-white">{{ $backup['name'] }}</span>
                        </td>
                        <td class="py-4 text-sm text-secondary whitespace-nowrap">{{ $backup['size'] }} KB</td>
                        <td class="py-4 text-sm text-secondary whitespace-nowrap">{{ $backup['date'] }}</td>
                        <td class="py-4 pr-6">
                            <div class="flex gap-2 justify-center">
                                <form action="{{ route('admin.backup.restore') }}" method="POST" onsubmit="return confirm('⚠️ PERINGATAN: Restore akan menimpa SELURUH data saat ini dengan data dari file backup ini. Pastikan Anda sudah membuat backup terbaru sebelum melanjutkan!\n\nLanjutkan restore?')">
                                    @csrf
                                    <input type="hidden" name="filename" value="{{ $backup['name'] }}">
                                    <button type="submit" class="btn btn-sm hover:scale-105 transition-transform" style="background: var(--warning); color: white; border: none; padding: 0.5rem 1rem;">
                                        Restore
                                    </button>
                                </form>
                                <form action="{{ route('admin.backup.delete') }}" method="POST" onsubmit="return confirm('Hapus file backup ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="filename" value="{{ $backup['name'] }}">
                                    <button type="submit" class="btn btn-sm btn-danger hover:scale-105 transition-transform" style="padding: 0.5rem 1rem;">
                                        Hapus
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
