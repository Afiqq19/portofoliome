@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-2">Pesan Masuk</h1>
        <p class="text-secondary">Pesan dari form kontak di halaman portofolio.</p>
    </div>
</div>

<div class="glass-panel p-0 table-container">
    @if(count($messages) > 0)
        <table>
            <thead>
                <tr>
                    <th width="50">Status</th>
                    <th>Pengirim</th>
                    <th>Subjek / Pesan Singkat</th>
                    <th>Waktu</th>
                    <th width="100" class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                <tr class="cursor-pointer transition-colors" style="{{ !$msg->is_read ? 'background: rgba(99, 102, 241, 0.05); border-left: 3px solid var(--accent-primary);' : '' }}" onclick="window.location='{{ route('admin.messages.show', $msg) }}'">
                    <td class="text-center" onclick="event.stopPropagation()">
                        @if(!$msg->is_read)
                            <div class="w-3 h-3 rounded-full bg-accent-primary mx-auto"></div>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-secondary mx-auto"><polyline points="20 6 9 17 4 12"/></svg>
                        @endif
                    </td>
                    <td>
                        <div class="font-bold {{ !$msg->is_read ? 'text-primary' : 'text-secondary' }}">{{ $msg->name }}</div>
                        <div class="text-xs text-secondary">{{ $msg->email }}</div>
                    </td>
                    <td>
                        <div class="font-bold text-sm mb-1 {{ !$msg->is_read ? 'text-primary' : 'text-secondary' }}">{{ $msg->subject ?? '(Tanpa Subjek)' }}</div>
                        <div class="text-sm text-secondary truncate max-w-md">{{ Str::limit($msg->message, 60) }}</div>
                    </td>
                    <td class="text-sm text-secondary">
                        {{ $msg->created_at->diffForHumans() }}
                    </td>
                    <td class="text-right" onclick="event.stopPropagation()">
                        <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline btn-sm text-danger border-glass px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-4 border-t" style="border-top-color: var(--glass-border)">
            {{ $messages->links() }}
        </div>
    @else
        <div class="p-12 text-center text-secondary">
            Belum ada pesan masuk.
        </div>
    @endif
</div>
@endsection
