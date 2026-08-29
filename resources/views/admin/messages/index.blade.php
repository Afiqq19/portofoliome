@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Pesan Masuk (Inbox)</h1>
    <p class="text-slate-500 text-sm">Kelola seluruh pesan, pertanyaan, dan tawaran kerjasama dari formulir kontak.</p>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if(count($messages) > 0)
        <div class="table-container border-0 rounded-none shadow-none">
            <table>
                <thead>
                    <tr>
                        <th width="40"></th>
                        <th>Pengirim</th>
                        <th>Subjek & Cuplikan Pesan</th>
                        <th>Waktu</th>
                        <th width="100" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($messages as $msg)
                    <tr class="cursor-pointer transition-colors hover:bg-slate-50 {{ !$msg->is_read ? 'bg-indigo-50/40' : '' }}" onclick="window.location='{{ route('admin.messages.show', $msg) }}'">
                        <td class="text-center" onclick="event.stopPropagation()">
                            @if(!$msg->is_read)
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 inline-block shadow-sm"></span>
                            @else
                                <i class='bx bx-check text-slate-400 text-base'></i>
                            @endif
                        </td>
                        <td>
                            <div class="font-bold text-sm text-slate-900">{{ $msg->name }}</div>
                            <div class="text-xs text-slate-400">{{ $msg->email }}</div>
                        </td>
                        <td>
                            <div class="font-bold text-sm text-slate-900 mb-0.5">{{ $msg->subject ?? '(Tanpa Subjek)' }}</div>
                            <div class="text-xs text-slate-500 truncate max-w-md">{{ Str::limit($msg->message, 80) }}</div>
                        </td>
                        <td class="text-xs text-slate-500 whitespace-nowrap">
                            {{ $msg->created_at->diffForHumans() }}
                        </td>
                        <td class="text-right" onclick="event.stopPropagation()">
                            <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white inline-flex items-center justify-center transition-colors" title="Hapus Pesan">
                                    <i class='bx bx-trash text-base'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-100 bg-slate-50">
            {{ $messages->links() }}
        </div>
    @else
        <div class="p-16 text-center text-slate-500">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mx-auto mb-4">
                <i class='bx bx-envelope-open'></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Pesan Masuk</h3>
            <p class="text-sm text-slate-400">Pesan dari form kontak portofolio akan masuk dan tersimpan di sini.</p>
        </div>
    @endif
</div>
@endsection
