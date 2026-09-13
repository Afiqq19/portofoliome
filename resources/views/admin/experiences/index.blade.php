@extends('layouts.admin')

@section('content')
<div class="flex flex-col sm:flex-row justify-between sm:items-end gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Jejak & Pengalaman</h1>
        <p class="text-slate-500 text-sm">Kelola riwayat perjalanan karir, pengalaman kerja, dan pencapaian Anda.</p>
    </div>
    <a href="{{ route('admin.experiences.create') }}" class="btn btn-primary px-5 py-2.5 font-bold text-sm shadow-md flex items-center gap-2">
        <i class='bx bx-plus-circle text-lg'></i>
        <span>Tambah Pengalaman Baru</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($experiences->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <th class="p-4 pl-6 w-16 text-center">Urutan</th>
                        <th class="p-4">Pengalaman & Peran</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Periode</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @foreach($experiences as $exp)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-4 pl-6 text-center font-mono font-bold text-slate-400">
                            {{ $exp->order }}
                        </td>
                        <td class="p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-{{ $exp->color }}-50 text-{{ $exp->color }}-600 flex items-center justify-center flex-shrink-0 shadow-sm border border-{{ $exp->color }}-100 mt-0.5">
                                    <i class='{{ $exp->category_icon }} text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base mb-0.5 group-hover:text-indigo-600 transition-colors">{{ $exp->title }}</h3>
                                    @if($exp->company)
                                        <p class="text-slate-500 text-xs flex items-center gap-1 mb-1">
                                            <i class='bx bx-building'></i> {{ $exp->company }}
                                        </p>
                                    @endif
                                    @if(!empty($exp->tags))
                                        <div class="flex flex-wrap gap-1 mt-1.5">
                                            @foreach($exp->tags_array as $tag)
                                                <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wider">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            @if($exp->category === 'education')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-cyan-50 text-cyan-700 text-xs font-bold border border-cyan-200">
                                    <i class='bx bxs-graduation'></i> Pendidikan
                                </span>
                            @elseif($exp->category === 'organization')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
                                    <i class='bx bx-group'></i> Organisasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-200">
                                    <i class='bx bx-briefcase'></i> Karir & Magang
                                </span>
                            @endif
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-medium border border-slate-200">
                                <i class='bx bx-calendar text-slate-400'></i> {{ $exp->period }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.experiences.toggle-status', $exp->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold transition-all {{ $exp->is_published ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}" title="Klik untuk mengubah status">
                                    @if($exp->is_published)
                                        <i class='bx bx-check-circle'></i> Publik
                                    @else
                                        <i class='bx bx-hide'></i> Sembunyi
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="p-4 pr-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.experiences.edit', $exp->id) }}" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-colors" title="Edit">
                                    <i class='bx bx-edit-alt text-lg'></i>
                                </a>
                                <form action="{{ route('admin.experiences.destroy', $exp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pengalaman ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-colors" title="Hapus">
                                        <i class='bx bx-trash text-lg'></i>
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
        <div class="p-12 text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                <i class='bx bx-history text-4xl text-slate-300'></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-1">Belum Ada Pengalaman</h3>
            <p class="text-sm text-slate-500 mb-6 max-w-sm">Anda belum menambahkan riwayat perjalanan karir. Tambahkan pengalaman pertama Anda sekarang.</p>
            <a href="{{ route('admin.experiences.create') }}" class="btn btn-primary px-5 py-2 font-bold text-sm shadow-sm">
                Mulai Tambahkan
            </a>
        </div>
    @endif
</div>
@endsection
