@extends('layouts.admin')

@section('title', 'Manajemen Catatan (Workspace)')
@section('header', 'Catatan Pengunjung')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">Workspace Publik</h1>
    <p class="text-secondary">Kelola dan pantau catatan atau pesan yang ditinggalkan oleh pengunjung website Anda.</p>
</div>

<div class="card">
    <div class="card-body border-b flex justify-between items-center" style="border-bottom-color: var(--glass-border)">
        <div>
            <h3 class="text-xl font-bold">Daftar Catatan</h3>
            <p class="text-sm text-secondary">Hapus catatan yang mengandung unsur tidak pantas atau spam.</p>
        </div>
    </div>
    
    <div class="p-0 table-container rounded-none border-0">
        @if($notes->isEmpty())
            <div class="p-12 text-center text-secondary">
                <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-white/5 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <p>Belum ada catatan dari pengunjung saat ini.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Pengirim</th>
                        <th class="w-1/2">Isi Catatan</th>
                        <th>Waktu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                    <tr>
                        <td class="font-bold">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-accent-primary/20 flex items-center justify-center text-accent-primary font-bold text-xs">
                                    {{ strtoupper(substr($note->name, 0, 1)) }}
                                </div>
                                {{ $note->name }}
                            </div>
                        </td>
                        <td>
                            <p class="text-sm text-secondary whitespace-pre-wrap">{{ $note->content }}</p>
                        </td>
                        <td class="text-sm text-muted">
                            {{ $note->created_at->format('d M Y, H:i') }}
                        </td>
                        <td>
                            <div class="flex justify-center">
                                <form action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan dari {{ $note->name }} ini? \n\nTindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
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
