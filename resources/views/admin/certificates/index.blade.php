@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0 mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-2">Kelola Sertifikat</h1>
        <p class="text-secondary">Pamerkan penghargaan dan sertifikat Anda.</p>
    </div>
    <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        Tambah Sertifikat
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-6 rounded-lg backdrop-blur-md">
        {{ session('success') }}
    </div>
@endif

<div class="glass-panel" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="table" style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--glass-border); background-color: rgba(255,255,255,0.02);">
                    <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-secondary);">Thumbnail</th>
                    <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-secondary);">Judul & Penerbit</th>
                    <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-secondary);">Tanggal</th>
                    <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-secondary);">Status</th>
                    <th style="padding: 1rem 1.5rem; font-weight: 600; color: var(--text-secondary); text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificates as $cert)
                    <tr style="border-bottom: 1px solid var(--glass-border); transition: background-color 0.2s;" class="hover:bg-white/5">
                        <td style="padding: 1rem 1.5rem;">
                            @if($cert->image)
                                <img src="{{ asset('storage/' . $cert->image) }}" alt="Thumb" style="width: 80px; height: 60px; object-fit: cover; border-radius: 0.5rem; border: 1px solid var(--glass-border);">
                            @else
                                <div style="width: 80px; height: 60px; border-radius: 0.5rem; border: 1px dashed var(--glass-border); display: flex; align-items: center; justify-content: center; background: var(--bg-tertiary);" class="text-secondary text-xs">No Image</div>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <div class="font-bold mb-1">{{ $cert->title }}</div>
                            <div class="text-xs text-secondary">{{ $cert->issuer ?? 'Tidak ada penerbit' }}</div>
                        </td>
                        <td style="padding: 1rem 1.5rem; color: var(--text-secondary); font-size: 0.9rem;">
                            {{ $cert->date ? $cert->date->format('M Y') : '-' }}
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <form action="{{ route('admin.certificates.toggle-status', $cert) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1 rounded-full text-xs font-bold transition-all border {{ $cert->status === 'published' ? 'bg-success/10 text-success border-success/30 hover:bg-success hover:text-white' : 'bg-secondary/10 text-secondary border-secondary/30 hover:bg-secondary hover:text-white' }}">
                                    {{ $cert->status === 'published' ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td style="padding: 1rem 1.5rem; text-align: right;">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.certificates.edit', $cert) }}" class="btn btn-sm btn-outline px-2 text-accent-primary border-accent-primary/30 hover:bg-accent-primary hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('admin.certificates.destroy', $cert) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline px-2 text-danger border-danger/30 hover:bg-danger hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem 1.5rem; text-align: center; color: var(--text-secondary);">
                            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📜</div>
                            <p>Belum ada sertifikat/penghargaan yang ditambahkan.</p>
                            <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary mt-4 inline-flex items-center gap-2">
                                Tambah Sertifikat Pertama
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
