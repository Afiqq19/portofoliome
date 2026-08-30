@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.messages.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-500 flex items-center justify-center shadow-sm transition-colors">
            <i class='bx bx-arrow-back text-lg'></i>
        </a>
        <div>
            <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Percakapan Tiket #{{ $message->ticket_id }}</h1>
            <p class="text-slate-500 text-sm">Pesan masuk dari <span class="font-semibold text-slate-800">{{ $message->name }}</span></p>
        </div>
    </div>
    
    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm shadow-sm flex items-center gap-1.5 cursor-pointer">
            <i class='bx bx-trash text-base'></i>
            <span>Hapus Tiket</span>
        </button>
    </form>
</div>

<div class="bg-white p-6 sm:p-10 rounded-2xl border border-slate-200 shadow-sm max-w-4xl">
    <div class="flex justify-between items-start border-b border-slate-100 pb-6 mb-8">
        <div>
            <h2 class="text-2xl font-bold font-['Space_Grotesk'] text-slate-900 mb-1">{{ $message->subject ?? '(Tanpa Subjek)' }}</h2>
            <div class="flex items-center gap-2 text-sm">
                <span class="font-bold text-indigo-600">{{ $message->name }}</span>
                <span class="text-slate-400">&lt;{{ $message->email }}&gt;</span>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xs font-bold text-slate-700 mb-0.5">{{ $message->created_at->format('d M Y') }}</div>
            <div class="text-[11px] text-slate-400 font-mono">{{ $message->created_at->format('H:i') }} WIB</div>
        </div>
    </div>
    
    <!-- Conversation Thread -->
    <div class="space-y-6 mb-10">
        <!-- Original Message (Visitor) -->
        <div class="flex justify-start">
            <div class="bg-slate-100 rounded-2xl rounded-tl-sm px-6 py-4 max-w-[85%] border border-slate-200">
                <div class="text-xs font-bold mb-1 text-indigo-600 flex items-center gap-1">
                    <i class='bx bx-user'></i>
                    <span>{{ $message->name }} (Pengunjung)</span>
                </div>
                <div class="whitespace-pre-wrap text-sm text-slate-800 leading-relaxed">{{ $message->message }}</div>
                <div class="text-[10px] text-slate-400 mt-2 font-mono">{{ $message->created_at->format('d M Y, H:i') }}</div>
            </div>
        </div>

        <!-- Replies -->
        @foreach($message->replies as $reply)
            @if($reply->sender_type === 'visitor')
                <div class="flex justify-start">
                    <div class="bg-slate-100 rounded-2xl rounded-tl-sm px-6 py-4 max-w-[85%] border border-slate-200">
                        <div class="text-xs font-bold mb-1 text-indigo-600 flex items-center gap-1">
                            <i class='bx bx-user'></i>
                            <span>{{ $message->name }}</span>
                        </div>
                        <div class="whitespace-pre-wrap text-sm text-slate-800 leading-relaxed">{{ $reply->body }}</div>
                        <div class="text-[10px] text-slate-400 mt-2 font-mono">{{ $reply->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            @else
                <div class="flex justify-end">
                    <div class="bg-indigo-600 text-white rounded-2xl rounded-tr-sm px-6 py-4 max-w-[85%] shadow-md">
                        <div class="text-xs font-bold mb-1 text-indigo-200 flex items-center gap-1">
                            <i class='bx bx-shield-quarter'></i>
                            <span>Anda (Admin)</span>
                        </div>
                        <div class="whitespace-pre-wrap text-sm leading-relaxed">{{ $reply->body }}</div>
                        <div class="text-[10px] text-indigo-200 mt-2 text-right font-mono">{{ $reply->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    <!-- Reply Box -->
    <div class="pt-8 border-t border-slate-100">
        <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900 mb-4 flex items-center gap-2">
            <i class='bx bx-reply text-indigo-600 text-xl'></i>
            <span>Tulis Balasan untuk {{ $message->name }}</span>
        </h3>
        
        <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
            @csrf
            <div class="form-group mb-4">
                <textarea name="reply_body" class="form-control" rows="5" placeholder="Ketik balasan Anda di sini... Pesan akan terkirim dan tersimpan di tiket percakapan." required></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary px-6 py-3 font-bold text-sm shadow-md flex items-center gap-2 cursor-pointer">
                    <i class='bx bx-send text-base'></i>
                    <span>Kirim Balasan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
