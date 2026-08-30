@extends('layouts.admin')

@section('title', 'Manajemen Catatan (Workspace)')
@section('header', 'Catatan Pengunjung')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Catatan Pengunjung (Workspace)</h1>
    <p class="text-slate-500 text-sm">Kelola dan pantau pesan atau catatan yang ditinggalkan pengunjung di workspace publik.</p>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900">Daftar Catatan Masuk</h3>
            <p class="text-xs text-slate-500">Moderasi catatan yang tidak pantas atau bersifat spam.</p>
        </div>
        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-700">
            Total: {{ $notes->count() }} Catatan
        </span>
    </div>
    
    <div class="table-container border-0 rounded-none shadow-none">
        @if($notes->isEmpty())
            <div class="p-16 text-center text-slate-500">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class='bx bx-notepad'></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Catatan</h3>
                <p class="text-sm text-slate-400">Catatan yang ditulis pengunjung di beranda workspace akan tampil di sini.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th width="200">Pengirim</th>
                        <th>Isi Catatan</th>
                        <th width="150">Waktu</th>
                        <th width="100" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($notes as $note)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                    {{ strtoupper(substr($note->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-sm text-slate-900">{{ $note->name }}</span>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs text-slate-700 whitespace-pre-wrap leading-relaxed">{{ $note->content }}</p>
                        </td>
                        <td class="text-xs text-slate-400 whitespace-nowrap">
                            {{ $note->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="text-right">
                            <form action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Hapus catatan dari {{ $note->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white inline-flex items-center justify-center transition-colors cursor-pointer" title="Hapus Catatan">
                                    <i class='bx bx-trash text-base'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
