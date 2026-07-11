@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">Dashboard</h1>
    <p class="text-secondary">Selamat datang kembali! Berikut adalah ringkasan portofolio Anda.</p>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel p-6 border-l-4 border-l-accent-primary" style="border-left: 4px solid var(--accent-primary)">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-secondary text-sm font-bold uppercase tracking-wider mb-1">Total Projek</p>
                <h3 class="text-3xl font-bold">{{ $stats['total_projects'] }}</h3>
            </div>
            <div class="p-3 bg-tertiary rounded-lg text-accent-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>
            </div>
        </div>
        <div class="mt-4 text-sm text-secondary">
            <span class="text-success">{{ $stats['published_projects'] }}</span> dipublikasikan
        </div>
    </div>

    <div class="glass-panel p-6 border-l-4 border-l-success" style="border-left: 4px solid var(--success)">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-secondary text-sm font-bold uppercase tracking-wider mb-1">Total Unduhan</p>
                <h3 class="text-3xl font-bold">{{ $stats['total_downloads'] }}</h3>
            </div>
            <div class="p-3 bg-tertiary rounded-lg text-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            </div>
        </div>
    </div>

    <div class="glass-panel p-6 border-l-4 border-l-accent-secondary" style="border-left: 4px solid var(--accent-secondary)">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-secondary text-sm font-bold uppercase tracking-wider mb-1">Pesan Masuk</p>
                <h3 class="text-3xl font-bold">{{ $stats['total_messages'] }}</h3>
            </div>
            <div class="p-3 bg-tertiary rounded-lg text-accent-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </div>
        </div>
        <div class="mt-4 text-sm text-secondary">
            <span class="text-danger">{{ $stats['unread_messages'] }}</span> belum dibaca
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Trakteer Info Box -->
    <div class="glass-panel p-8 border-l-4 border-l-red-500 relative overflow-hidden group h-full flex flex-col justify-center" style="border-left: 4px solid #ef4444">
        <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
        <h3 class="text-2xl font-bold mb-4 text-white flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
            Donasi Terintegrasi
        </h3>
        <p class="text-secondary mb-6 leading-relaxed">
            Sistem donasi kini ditangani sepenuhnya oleh <strong>Trakteer.id</strong>. Anda akan menerima notifikasi email setiap ada donatur baru.
        </p>
        <div class="flex gap-4">
            <a href="https://trakteer.id" target="_blank" class="btn btn-outline hover:bg-red-500 hover:border-red-500 hover:text-white transition-all w-max" style="border-color: #ef4444; color: #ef4444;">Buka Dashboard Trakteer</a>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="card">
        <div class="card-body border-b" style="border-bottom-color: var(--glass-border)">
            <h3 class="text-xl font-bold flex items-center justify-between">
                Pesan Terbaru
                <a href="{{ route('admin.messages.index') }}" class="text-sm text-accent-primary font-normal">Lihat Semua</a>
            </h3>
        </div>
        <div class="p-0 table-container rounded-none border-0">
            @if(count($recentMessages) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Pengirim</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentMessages as $msg)
                        <tr style="{{ !$msg->is_read ? 'background: rgba(99, 102, 241, 0.05)' : '' }}">
                            <td>
                                <div class="font-bold">{{ $msg->name }} {!! !$msg->is_read ? '<span class="w-2 h-2 rounded-full bg-accent-primary inline-block"></span>' : '' !!}</div>
                                <div class="text-xs text-secondary">{{ $msg->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="text-sm text-secondary truncate max-w-xs">{{ Str::limit($msg->message, 50) }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-6 text-center text-secondary">Belum ada pesan.</div>
            @endif
        </div>
    </div>
</div>
@endsection
