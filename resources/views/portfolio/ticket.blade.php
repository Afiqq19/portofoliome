@extends('layouts.app')

@section('title', 'Tiket Dukungan - ' . config('app.name'))

@section('content')
<div class="container max-w-4xl mx-auto px-4 pt-32 pb-24 relative">
    
    <!-- Ambient Glow -->
    <div class="absolute top-20 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-indigo-600/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>

    <div class="mb-12 text-center">
        <a href="{{ route('home') }}" class="group text-slate-400 hover:text-white flex items-center justify-center gap-2 mb-6 inline-flex transition-colors font-medium">
            <span class="w-8 h-8 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-all">
                <i class='bx bx-arrow-back'></i>
            </span>
            <span class="text-sm">Kembali ke Beranda</span>
        </a>
        <h1 class="text-3xl md:text-5xl font-black font-['Space_Grotesk'] mb-3">
            <span class="text-gradient">Tiket Percakapan</span>
        </h1>
        <p class="text-slate-400 text-sm md:text-base max-w-xl mx-auto">
            Ruang komunikasi rahasia Anda langsung dengan pengelola portofolio.
        </p>
    </div>

    @if(session('success'))
    <div class="alert alert-success mb-8 rounded-2xl">
        <i class='bx bx-check-circle text-2xl mr-2'></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="glass-panel p-6 md:p-10 rounded-3xl border border-white/10 shadow-2xl">
        <div class="border-b border-white/10 pb-6 mb-8 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold font-['Space_Grotesk'] text-slate-100 mb-1">{{ $message->subject ?? '(Tanpa Subjek)' }}</h2>
                <div class="text-xs font-mono text-slate-400 flex items-center gap-2">
                    <span>ID TIKET:</span>
                    <span class="px-2 py-0.5 rounded-md bg-white/10 text-indigo-300 font-bold">{{ $message->ticket_id }}</span>
                </div>
            </div>
            <div class="text-xs font-medium text-slate-400 bg-white/5 px-3 py-1.5 rounded-full self-start border border-white/5">
                Dibuat {{ $message->created_at->format('d M Y, H:i') }}
            </div>
        </div>

        <!-- Chat History -->
        <div class="space-y-6 mb-10">
            <!-- Original Message (Visitor) -->
            <div class="flex justify-end">
                <div class="bg-gradient-to-br from-indigo-600/30 to-purple-600/30 text-slate-100 rounded-3xl rounded-tr-sm px-6 py-4 max-w-[85%] border border-indigo-500/30 shadow-lg">
                    <div class="text-xs font-bold mb-1 text-accent-cyan flex items-center gap-1.5">
                        <i class='bx bx-user'></i>
                        <span>Anda ({{ $message->name }})</span>
                    </div>
                    <div class="whitespace-pre-wrap text-sm leading-relaxed">{{ $message->message }}</div>
                    <div class="text-[10px] text-slate-400 mt-2 text-right font-mono">{{ $message->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>

            <!-- Replies -->
            @foreach($message->replies as $reply)
                @if($reply->sender_type === 'admin')
                    <div class="flex justify-start">
                        <div class="bg-secondary-dark/80 rounded-3xl rounded-tl-sm px-6 py-4 max-w-[85%] border border-white/10 shadow-lg">
                            <div class="text-xs font-bold mb-1 text-emerald-400 flex items-center gap-1.5">
                                <i class='bx bx-shield-quarter'></i>
                                <span>Admin / Pengelola</span>
                            </div>
                            <div class="whitespace-pre-wrap text-sm leading-relaxed text-slate-200">{{ $reply->body }}</div>
                            <div class="text-[10px] text-slate-500 mt-2 font-mono">{{ $reply->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-end">
                        <div class="bg-gradient-to-br from-indigo-600/30 to-purple-600/30 text-slate-100 rounded-3xl rounded-tr-sm px-6 py-4 max-w-[85%] border border-indigo-500/30 shadow-lg">
                            <div class="text-xs font-bold mb-1 text-accent-cyan flex items-center gap-1.5">
                                <i class='bx bx-user'></i>
                                <span>Anda</span>
                            </div>
                            <div class="whitespace-pre-wrap text-sm leading-relaxed">{{ $reply->body }}</div>
                            <div class="text-[10px] text-slate-400 mt-2 text-right font-mono">{{ $reply->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Reply Form -->
        <div class="border-t border-white/10 pt-8">
            <form action="{{ route('ticket.reply', $message->ticket_id) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label class="form-label text-xs">Balasan Anda</label>
                    <textarea name="reply_body" class="form-control rounded-2xl" rows="4" placeholder="Ketik balasan Anda di sini..." required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary btn-shimmer rounded-xl px-6 py-3 font-bold text-sm flex items-center gap-2">
                        <span>Kirim Balasan</span>
                        <i class='bx bx-send'></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
