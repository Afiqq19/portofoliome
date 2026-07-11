@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-20 max-w-3xl">
    <div class="mb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">
            <span class="text-gradient">Tiket Dukungan</span>
        </h1>
        <p class="text-secondary text-lg max-w-2xl mx-auto">
            Ini adalah ruang percakapan rahasia Anda dengan pengelola portofolio.
        </p>
    </div>

    @if(session('success'))
    <div class="alert alert-success mb-8">
        {{ session('success') }}
    </div>
    @endif

    <div class="glass-panel p-8 mb-8">
        <div class="border-b pb-6 mb-6" style="border-bottom-color: var(--glass-border)">
            <h2 class="text-2xl font-bold mb-2">{{ $message->subject ?? '(Tanpa Subjek)' }}</h2>
            <div class="text-sm text-secondary">Tiket ID: {{ $message->ticket_id }}</div>
        </div>

        <!-- Chat History -->
        <div class="space-y-6 mb-8">
            <!-- Original Message (Visitor) -->
            <div class="flex justify-end">
                <div class="bg-accent-primary/20 text-white rounded-2xl rounded-tr-none px-6 py-4 max-w-[80%] border border-accent-primary/30">
                    <div class="text-sm font-bold mb-1 text-accent-primary">Anda ({{ $message->name }})</div>
                    <div class="whitespace-pre-wrap">{{ $message->message }}</div>
                    <div class="text-xs text-secondary mt-2 text-right">{{ $message->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>

            <!-- Replies -->
            @foreach($message->replies as $reply)
                @if($reply->sender_type === 'admin')
                    <div class="flex justify-start">
                        <div class="bg-tertiary rounded-2xl rounded-tl-none px-6 py-4 max-w-[80%] border" style="border-color: var(--glass-border)">
                            <div class="text-sm font-bold mb-1 text-success">Admin</div>
                            <div class="whitespace-pre-wrap">{{ $reply->body }}</div>
                            <div class="text-xs text-secondary mt-2">{{ $reply->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-end">
                        <div class="bg-accent-primary/20 text-white rounded-2xl rounded-tr-none px-6 py-4 max-w-[80%] border border-accent-primary/30">
                            <div class="text-sm font-bold mb-1 text-accent-primary">Anda</div>
                            <div class="whitespace-pre-wrap">{{ $reply->body }}</div>
                            <div class="text-xs text-secondary mt-2 text-right">{{ $reply->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Reply Form -->
        <div class="border-t pt-6" style="border-top-color: var(--glass-border)">
            <form action="{{ route('ticket.reply', $message->ticket_id) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <textarea name="reply_body" class="form-control w-full bg-dark/50" rows="4" placeholder="Ketik balasan Anda di sini..." required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary" onclick="this.innerHTML = 'Mengirim...'; this.classList.add('opacity-75');">
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
