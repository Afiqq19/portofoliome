@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Manajemen Projek</h1>
        <p class="text-slate-500 text-sm">Kelola seluruh projek, repository, unduhan, dan status rilis portofolio.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary shadow-md flex items-center gap-2">
        <i class='bx bx-plus-circle text-lg'></i>
        <span>Tambah Projek Baru</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if(count($projects) > 0)
        <div class="table-container border-0 rounded-none shadow-none">
            <table>
                <thead>
                    <tr>
                        <th width="90">Thumbnail</th>
                        <th>Detail Projek</th>
                        <th>Kategori / Tech Stack</th>
                        <th>Status Publikasi</th>
                        <th>Unduhan</th>
                        <th width="140" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($projects as $project)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td>
                            @if($project->thumbnail)
                                <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumb" class="w-16 h-12 object-cover rounded-xl border border-slate-200 shadow-sm">
                            @else
                                <div class="w-16 h-12 rounded-xl bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                                    <i class='bx bx-image text-xl'></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="font-bold text-sm text-slate-900 mb-1 flex items-center gap-2">
                                <span>{{ $project->title }}</span>
                                @if($project->is_featured)
                                    <span class="badge text-[10px] bg-purple-50 text-purple-700 border-purple-200">Featured</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 line-clamp-1 max-w-sm">{{ $project->description }}</p>
                        </td>
                        <td>
                            <div class="flex gap-1 flex-wrap max-w-xs">
                                @foreach(array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                                    <span class="badge text-[10px] bg-slate-100 text-slate-700">{{ $tech }}</span>
                                @endforeach
                                @if(count($project->tech_stack ?? []) > 3)
                                    <span class="text-[10px] text-slate-400 font-bold self-center">+{{ count($project->tech_stack) - 3 }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('admin.projects.toggle-status', $project) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="cursor-pointer flex items-center gap-2 py-1 px-3 rounded-full border text-xs font-bold transition-all {{ $project->status === 'published' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}" title="Klik untuk ubah status">
                                    <span class="w-2 h-2 rounded-full {{ $project->status === 'published' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span>{{ $project->status === 'published' ? 'Publik' : 'Draft' }}</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="font-bold text-sm text-slate-900 flex items-center gap-1">
                                <i class='bx bx-download text-slate-400'></i>
                                <span>{{ $project->download_count }}x</span>
                            </div>
                            <div class="text-[11px] font-medium {{ $project->zip_path ? 'text-emerald-600' : 'text-slate-400' }}">
                                {{ $project->zip_path ? 'ZIP Tersedia' : 'Tanpa ZIP' }}
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end gap-1.5">
                                <a href="{{ route('project.show', $project->slug) }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-center transition-colors" title="Lihat di Web">
                                    <i class='bx bx-link-external'></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-colors" title="Edit Projek">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus projek ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-colors cursor-pointer" title="Hapus Projek">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-16 text-center">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mx-auto mb-4">
                <i class='bx bx-folder-open'></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Projek</h3>
            <p class="text-sm text-slate-500 mb-6">Mulai tambahkan karya atau aplikasi yang telah Anda buat ke dalam portofolio.</p>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary shadow-md">
                <i class='bx bx-plus-circle mr-1'></i> Tambah Projek Pertama
            </a>
        </div>
    @endif
</div>
@endsection
