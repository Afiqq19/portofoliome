@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-2">Manajemen Projek</h1>
        <p class="text-secondary">Kelola projek yang akan ditampilkan di portofolio Anda.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        Tambah Projek
    </a>
</div>

<div class="glass-panel p-0 table-container">
    @if(count($projects) > 0)
        <table>
            <thead>
                <tr>
                    <th width="80">Thumbnail</th>
                    <th>Detail Projek</th>
                    <th>Status</th>
                    <th>Unduhan</th>
                    <th width="150" class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>
                        @if($project->thumbnail)
                            <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumb" style="width: 80px; height: 60px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--glass-border);">
                        @else
                            <div style="width: 80px; height: 60px; border-radius: var(--radius-sm); border: 1px dashed var(--glass-border);" class="bg-tertiary flex items-center justify-center text-xs text-muted">No Img</div>
                        @endif
                    </td>
                    <td>
                        <div class="font-bold text-lg mb-1">{{ $project->title }} {!! $project->is_featured ? '<span class="badge ml-2" style="background: rgba(168, 85, 247, 0.1); color: var(--accent-secondary)">Featured</span>' : '' !!}</div>
                        <div class="flex gap-1 flex-wrap">
                            @foreach(array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                                <span class="badge" style="font-size: 0.65rem; padding: 0.15rem 0.5rem;">{{ $tech }}</span>
                            @endforeach
                            @if(count($project->tech_stack ?? []) > 3)
                                <span class="text-xs text-secondary">+{{ count($project->tech_stack) - 3 }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.projects.toggle-status', $project) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="cursor-pointer flex flex-col items-center" style="background: transparent !important; border: none !important; outline: none !important; padding: 0 !important; box-shadow: none !important; -webkit-appearance: none; appearance: none;" title="Klik untuk ubah status">
                                <div style="width: 44px; height: 24px; border-radius: 999px; position: relative; transition: background-color 0.3s; background-color: {{ $project->status === 'published' ? 'var(--success)' : '#ef4444' }};">
                                    <div style="width: 18px; height: 18px; border-radius: 50%; background-color: white; position: absolute; top: 3px; transition: left 0.3s; left: {{ $project->status === 'published' ? '23px' : '3px' }}; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"></div>
                                </div>
                                <span style="font-size: 0.65rem; margin-top: 4px; font-weight: bold; color: {{ $project->status === 'published' ? 'var(--success)' : '#ef4444' }};">
                                    {{ $project->status === 'published' ? 'Publik' : 'Draft' }}
                                </span>
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="font-bold {{ $project->download_count > 0 ? 'text-success' : 'text-secondary' }}">
                            {{ $project->download_count }}x
                        </div>
                        @if($project->zip_path)
                            <div class="text-xs text-success">File ZIP tersedia</div>
                        @else
                            <div class="text-xs text-danger">File ZIP kosong</div>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-outline btn-sm text-accent-primary border-glass px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus projek ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm text-danger border-glass px-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-tertiary text-muted mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Belum Ada Projek</h3>
            <p class="text-secondary mb-6">Anda belum menambahkan projek ke portofolio Anda.</p>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Tambah Projek Pertama</a>
        </div>
    @endif
</div>
@endsection
