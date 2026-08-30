@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Dashboard</h1>
    <p class="text-slate-500 text-sm">Selamat datang kembali! Berikut adalah ringkasan performa dan aktivitas portofolio Anda.</p>
</div>

<!-- Stats Overview (Bento Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    
    <!-- Total Projek -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Projek</p>
                <h3 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900">{{ $stats['total_projects'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl">
                <i class='bx bx-folder'></i>
            </div>
        </div>
        <div class="text-xs text-slate-500 flex items-center gap-1.5 pt-3 border-t border-slate-100">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">
                {{ $stats['published_projects'] ?? 0 }} Publik
            </span>
            <span>dari total karya</span>
        </div>
    </div>

    <!-- Total Unduhan -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Unduhan</p>
                <h3 class="text-3xl font-black font-['Space_Grotesk'] text-emerald-600">{{ $stats['total_downloads'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                <i class='bx bx-download'></i>
            </div>
        </div>
        <div class="text-xs text-slate-500 flex items-center gap-1.5 pt-3 border-t border-slate-100">
            <span class="text-emerald-600 font-semibold">ZIP & APK</span>
            <span>diunduh pengunjung</span>
        </div>
    </div>

    <!-- Pesan Masuk -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Pesan Masuk</p>
                <h3 class="text-3xl font-black font-['Space_Grotesk'] text-indigo-600">{{ $stats['total_messages'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl">
                <i class='bx bx-envelope'></i>
            </div>
        </div>
        <div class="text-xs text-slate-500 flex items-center gap-1.5 pt-3 border-t border-slate-100">
            @if(($stats['unread_messages'] ?? 0) > 0)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700">
                    {{ $stats['unread_messages'] }} Belum Dibaca
                </span>
            @else
                <span class="text-slate-400">Semua pesan terbaca</span>
            @endif
        </div>
    </div>

    <!-- Total Pengunjung -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Pengunjung</p>
                <h3 class="text-3xl font-black font-['Space_Grotesk'] text-sky-600">{{ \App\Models\Visitor::distinct('ip_address')->count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-2xl">
                <i class='bx bx-user-voice'></i>
            </div>
        </div>
        <div class="text-xs text-slate-500 flex items-center gap-1.5 pt-3 border-t border-slate-100">
            <span class="text-sky-600 font-semibold">IP Unik</span>
            <span>tercatat di database</span>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Trakteer Info Box & Quick Actions (1 Col) -->
    <div class="lg:col-span-1 space-y-6">
        
        <!-- Trakteer Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl shadow-sm">
                    ☕
                </div>
                <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900">Donasi Trakteer</h3>
            </div>
            <p class="text-slate-500 text-xs leading-relaxed mb-5">
                Sistem donasi terhubung dengan <strong>Trakteer.id</strong>. Anda menerima notifikasi email setiap ada dukungan kopi baru dari pengunjung.
            </p>
            <a href="https://trakteer.id" target="_blank" rel="noopener noreferrer" class="btn btn-outline w-full text-xs font-bold flex items-center justify-center gap-2 hover:border-rose-500 hover:text-rose-600">
                <i class='bx bx-link-external'></i>
                <span>Buka Dashboard Trakteer</span>
            </a>
        </div>

        <!-- Quick Navigation -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Aksi Cepat</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.projects.create') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 text-sm font-semibold text-slate-700 hover:text-indigo-600 transition-colors">
                    <span class="flex items-center gap-2.5">
                        <i class='bx bx-plus-circle text-lg text-indigo-600'></i>
                        <span>Tambah Projek Baru</span>
                    </span>
                    <i class='bx bx-chevron-right text-slate-400'></i>
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 text-sm font-semibold text-slate-700 hover:text-indigo-600 transition-colors">
                    <span class="flex items-center gap-2.5">
                        <i class='bx bx-user-circle text-lg text-purple-600'></i>
                        <span>Edit Profil & Sosmed</span>
                    </span>
                    <i class='bx bx-chevron-right text-slate-400'></i>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 text-sm font-semibold text-slate-700 hover:text-indigo-600 transition-colors">
                    <span class="flex items-center gap-2.5">
                        <i class='bx bx-chat text-lg text-emerald-600'></i>
                        <span>Lihat Semua Pesan</span>
                    </span>
                    <i class='bx bx-chevron-right text-slate-400'></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Recent Messages Table (2 Cols) -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full flex flex-col justify-between">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900">Pesan Masuk Terbaru</h3>
                    <p class="text-xs text-slate-400">Pesan dan pertanyaan dari form kontak portofolio</p>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

            <div class="table-container border-0 rounded-none shadow-none flex-1">
                @if(isset($recent_messages) && count($recent_messages) > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Pengirim</th>
                                <th>Subjek & Pesan</th>
                                <th>Waktu</th>
                                <th width="80" class="text-right">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recent_messages as $msg)
                            <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="window.location='{{ route('admin.messages.show', $msg) }}'">
                                <td>
                                    <div class="font-bold text-sm text-slate-900">{{ $msg->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $msg->email }}</div>
                                </td>
                                <td>
                                    <div class="font-semibold text-xs text-slate-800 mb-0.5">{{ $msg->subject ?? '(Tanpa Subjek)' }}</div>
                                    <div class="text-xs text-slate-500 truncate max-w-xs">{{ Str::limit($msg->message, 50) }}</div>
                                </td>
                                <td class="text-xs text-slate-400 whitespace-nowrap">
                                    {{ $msg->created_at->diffForHumans() }}
                                </td>
                                <td class="text-right" onclick="event.stopPropagation()">
                                    <a href="{{ route('admin.messages.show', $msg) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white inline-flex items-center justify-center transition-colors" title="Buka Pesan">
                                        <i class='bx bx-chevron-right text-lg'></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-12 text-center text-slate-400">
                        <i class='bx bx-envelope-open text-4xl text-slate-300 mb-2'></i>
                        <p class="text-xs">Belum ada pesan baru yang masuk.</p>
                    </div>
                @endif
            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-between items-center text-xs text-slate-500">
                <span>Total data tersimpan di sistem</span>
                <span class="font-semibold text-slate-700">{{ $stats['total_messages'] ?? 0 }} Percakapan</span>
            </div>
        </div>
    </div>

</div>
@endsection
