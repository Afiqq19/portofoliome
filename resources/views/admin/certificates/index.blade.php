@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Kelola Sertifikat & Prestasi</h1>
        <p class="text-slate-500 text-sm">Pamerkan penghargaan, sertifikasi resmi, dan lisensi Anda.</p>
    </div>
    <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary shadow-md flex items-center gap-2">
        <i class='bx bx-plus-circle text-lg'></i>
        <span>Tambah Sertifikat</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="table-container border-0 rounded-none shadow-none">
        <table>
            <thead>
                <tr>
                    <th width="90">Thumbnail</th>
                    <th>Judul & Penerbit</th>
                    <th>Tanggal Terbit</th>
                    <th>Status Publikasi</th>
                    <th width="120" class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($certificates as $cert)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td>
                            @if($cert->image)
                                <img src="{{ asset('storage/' . $cert->image) }}" alt="Thumb" class="w-16 h-12 object-cover rounded-xl border border-slate-200 shadow-sm">
                            @else
                                <div class="w-16 h-12 rounded-xl bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                                    <i class='bx bx-award text-xl'></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="font-bold text-sm text-slate-900 mb-0.5">{{ $cert->title }}</div>
                            <div class="text-xs text-slate-500 flex items-center gap-1">
                                <i class='bx bx-check-shield text-indigo-500'></i>
                                <span>{{ $cert->issuer ?? 'Penerbit Mandiri' }}</span>
                            </div>
                        </td>
                        <td class="text-xs font-medium text-slate-600">
                            {{ $cert->date ? $cert->date->format('M Y') : '-' }}
                        </td>
                        <td>
                            <form action="{{ route('admin.certificates.toggle-status', $cert) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="cursor-pointer flex items-center gap-2 py-1 px-3 rounded-full border text-xs font-bold transition-all {{ $cert->status === 'published' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}">
                                    <span class="w-2 h-2 rounded-full {{ $cert->status === 'published' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span>{{ $cert->status === 'published' ? 'Publik' : 'Draft' }}</span>
                                </button>
                            </form>
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end gap-1.5">
                                <a href="{{ route('admin.certificates.edit', $cert) }}" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-colors" title="Edit">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('admin.certificates.destroy', $cert) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-colors cursor-pointer" title="Hapus">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-16 text-center text-slate-500">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mx-auto mb-4">
                                <i class='bx bx-award'></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Sertifikat</h3>
                            <p class="text-sm text-slate-500 mb-6">Tambahkan bukti sertifikasi atau penghargaan yang pernah Anda raih.</p>
                            <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary shadow-md">
                                <i class='bx bx-plus-circle mr-1'></i> Tambah Sertifikat Pertama
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
