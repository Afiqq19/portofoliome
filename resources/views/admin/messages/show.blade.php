@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline btn-sm px-2 text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold mb-1">Detail Pesan</h1>
        </div>
    </div>
    
    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
            Hapus Pesan
        </button>
    </form>
</div>

<div class="glass-panel p-8 max-w-4xl">
    <div class="flex justify-between items-start border-b pb-6 mb-6" style="border-bottom-color: var(--glass-border)">
        <div>
            <h2 class="text-2xl font-bold mb-2">{{ $message->subject ?? '(Tanpa Subjek)' }}</h2>
            <div class="flex items-center gap-2">
                <span class="font-bold text-accent-primary">{{ $message->name }}</span>
                <span class="text-secondary">&lt;{{ $message->email }}&gt;</span>
            </div>
        </div>
        <div class="text-right">
            <div class="text-sm text-secondary mb-1">{{ $message->created_at->format('d M Y') }}</div>
            <div class="text-xs text-muted">{{ $message->created_at->format('H:i') }}</div>
        </div>
    </div>
    
    <div class="space-y-6 mb-8 mt-6">
        <!-- Original Message (Visitor) -->
        <div class="flex justify-start">
            <div class="bg-tertiary rounded-2xl rounded-tl-none px-6 py-4 max-w-[80%] border" style="border-color: var(--glass-border)">
                <div class="text-sm font-bold mb-1 text-accent-primary">{{ $message->name }} (Visitor)</div>
                <div class="whitespace-pre-wrap">{{ $message->message }}</div>
                <div class="text-xs text-secondary mt-2">{{ $message->created_at->format('d M Y, H:i') }}</div>
            </div>
        </div>

        <!-- Replies -->
        @foreach($message->replies as $reply)
            @if($reply->sender_type === 'visitor')
                <div class="flex justify-start">
                    <div class="bg-tertiary rounded-2xl rounded-tl-none px-6 py-4 max-w-[80%] border border-accent-primary/30">
                        <div class="text-sm font-bold mb-1 text-accent-primary">{{ $message->name }} (Visitor)</div>
                        <div class="whitespace-pre-wrap">{{ $reply->body }}</div>
                        <div class="text-xs text-secondary mt-2">{{ $reply->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            @else
                <div class="flex justify-end">
                    <div class="bg-success/10 text-white rounded-2xl rounded-tr-none px-6 py-4 max-w-[80%] border border-success/30">
                        <div class="text-sm font-bold mb-1 text-success">Anda (Admin)</div>
                        <div class="whitespace-pre-wrap">{{ $reply->body }}</div>
                        <div class="text-xs text-secondary mt-2 text-right">{{ $reply->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    <div class="mt-8 pt-8 border-t" style="border-top-color: var(--glass-border)">
        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
            Balas Pesan Ini
        </h3>
        
        <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
            @csrf
            <div class="form-group mb-4">
                <textarea name="reply_body" class="form-control w-full" rows="6" placeholder="Ketik balasan Anda di sini... Akan langsung dikirim ke {{ $message->email }}" required></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary flex items-center gap-2" onclick="this.innerHTML = 'Mengirim...'; this.classList.add('opacity-75');">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Kirim Balasan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
