@extends('layouts.admin')

@section('content')
<!-- Header & Actions -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Dashboard Analitik</h1>
        <p class="text-slate-500 text-sm">Ringkasan performa portofolio, statistik kunjungan, dan interaksi pengunjung.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.dashboard.export-visitors') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-xs font-bold transition-all shadow-sm">
            <i class='bx bx-download text-base text-indigo-400'></i>
            <span>Export Log Pengunjung (CSV)</span>
        </a>
    </div>
</div>

<!-- Stats Overview (Bento Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    
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

    <!-- Total Pengunjung Unik -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Pengunjung Unik</p>
                <h3 class="text-3xl font-black font-['Space_Grotesk'] text-sky-600">{{ $stats['total_visitors'] ?? 0 }}</h3>
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

<!-- Realtime Traffic Highlights Bar -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class='bx bx-calendar-check'></i>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Hari Ini (WIB)</div>
                <div class="text-xl font-bold font-['Space_Grotesk'] text-slate-800">{{ $stats['today_visitors'] ?? 0 }} <span class="text-xs font-normal text-slate-400">IP unik</span></div>
            </div>
        </div>
        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
    </div>

    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                <i class='bx bx-calendar-week'></i>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Minggu Ini</div>
                <div class="text-xl font-bold font-['Space_Grotesk'] text-slate-800">{{ $stats['week_visitors'] ?? 0 }} <span class="text-xs font-normal text-slate-400">IP unik</span></div>
            </div>
        </div>
        <i class='bx bx-trending-up text-indigo-500 text-lg'></i>
    </div>

    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                <i class='bx bx-calendar'></i>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Bulan Ini</div>
                <div class="text-xl font-bold font-['Space_Grotesk'] text-slate-800">{{ $stats['month_visitors'] ?? 0 }} <span class="text-xs font-normal text-slate-400">IP unik</span></div>
            </div>
        </div>
        <i class='bx bx-line-chart text-purple-500 text-lg'></i>
    </div>
</div>

<!-- Interactive Traffic Chart (Bawaan Sendiri) -->
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-bold font-['Space_Grotesk'] text-slate-900 flex items-center gap-2">
                <i class='bx bx-line-chart text-indigo-600'></i>
                <span>Grafik Tren Kunjungan Portofolio</span>
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">Analitik statistik pengunjung unik yang terekam otomatis di database lokal Anda.</p>
        </div>
        <div class="flex items-center p-1 bg-slate-100 rounded-xl">
            <button id="btn-chart-7" onclick="switchChartMode('7')" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-indigo-600 shadow-xs">
                7 Hari Terakhir
            </button>
            <button id="btn-chart-30" onclick="switchChartMode('30')" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900">
                30 Hari Terakhir
            </button>
        </div>
    </div>

    <!-- Canvas Container -->
    <div class="relative w-full h-[280px]">
        <canvas id="trafficChart"></canvas>
    </div>
</div>

<!-- 2 Col: Top Pages & Device Breakdown -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- Top Visited Pages -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold font-['Space_Grotesk'] text-slate-900 flex items-center gap-2">
                    <i class='bx bx-bookmark-alt text-indigo-600'></i>
                    <span>Halaman Paling Populer (Top Pages)</span>
                </h3>
                <span class="text-xs text-slate-400">Total Klik</span>
            </div>
            
            <div class="space-y-3.5">
                @forelse($topPages as $idx => $p)
                <div class="space-y-1">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-semibold text-slate-700 truncate max-w-[240px] sm:max-w-xs flex items-center gap-2">
                            <span class="w-5 h-5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold flex items-center justify-center">{{ $idx + 1 }}</span>
                            <span class="truncate">{{ $p->page_name }}</span>
                        </span>
                        <span class="font-mono font-bold text-indigo-600">{{ $p->views_count }} hits</span>
                    </div>
                    @php
                        $maxViews = $topPages->first()->views_count ?? 1;
                        $pct = round(($p->views_count / max(1, $maxViews)) * 100);
                    @endphp
                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @empty
                <div class="text-xs text-slate-400 text-center py-6">Belum ada data kunjungan halaman.</div>
                @endforelse
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-slate-100 text-xs text-slate-400 flex items-center justify-between">
            <span>Data disinkronkan langsung dari middleware pengunjung</span>
            <span class="text-indigo-600 font-semibold">Live Real-time</span>
        </div>
    </div>

    <!-- Device & Platform Breakdown -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold font-['Space_Grotesk'] text-slate-900 flex items-center gap-2">
                    <i class='bx bx-devices text-purple-600'></i>
                    <span>Statistik Perangkat (HP vs Laptop)</span>
                </h3>
                <span class="text-xs text-slate-400">Rasio Pengunjung</span>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <!-- Mobile Card -->
                <div class="p-4 rounded-xl bg-purple-50/60 border border-purple-100/60">
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-8 h-8 rounded-lg bg-purple-600 text-white flex items-center justify-center text-lg shadow-sm">
                            <i class='bx bx-mobile'></i>
                        </span>
                        <span class="text-xl font-bold font-['Space_Grotesk'] text-purple-700">{{ $deviceStats['mobile_percent'] }}%</span>
                    </div>
                    <div class="text-xs font-bold text-slate-800">Smartphone / HP</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $deviceStats['mobile'] }} kunjungan</div>
                </div>

                <!-- Desktop Card -->
                <div class="p-4 rounded-xl bg-indigo-50/60 border border-indigo-100/60">
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-lg shadow-sm">
                            <i class='bx bx-laptop'></i>
                        </span>
                        <span class="text-xl font-bold font-['Space_Grotesk'] text-indigo-700">{{ $deviceStats['desktop_percent'] }}%</span>
                    </div>
                    <div class="text-xs font-bold text-slate-800">Desktop / Laptop</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $deviceStats['desktop'] }} kunjungan</div>
                </div>
            </div>

            <!-- Combined Progress Bar -->
            <div class="space-y-1.5">
                <div class="flex justify-between text-xs text-slate-500 font-medium">
                    <span>HP ({{ $deviceStats['mobile_percent'] }}%)</span>
                    <span>Laptop / PC ({{ $deviceStats['desktop_percent'] }}%)</span>
                </div>
                <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden flex">
                    <div class="bg-purple-600 h-full transition-all duration-500" style="width: {{ $deviceStats['mobile_percent'] }}%"></div>
                    <div class="bg-indigo-600 h-full transition-all duration-500" style="width: {{ $deviceStats['desktop_percent'] }}%"></div>
                </div>
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-slate-100 text-xs text-slate-400 flex items-center justify-between">
            <span>Dihitung otomatis dari User Agent browser</span>
            <span class="text-purple-600 font-semibold">{{ $deviceStats['total'] }} Total Hit</span>
        </div>
    </div>

</div>

<!-- Recent Messages & Actions Grid -->
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
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.messages.export') }}" class="text-xs font-bold text-slate-600 hover:text-indigo-600 flex items-center gap-1.5 py-1 px-2.5 rounded-lg border border-slate-200 hover:border-indigo-400 transition-all">
                        <i class='bx bx-download'></i>
                        <span>Export CSV</span>
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
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

<!-- Chart.js CDN & Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data7 = {
        labels: {!! json_encode($dates7) !!},
        data: {!! json_encode($counts7) !!}
    };
    const data30 = {
        labels: {!! json_encode($dates30) !!},
        data: {!! json_encode($counts30) !!}
    };

    let currentMode = '7';
    let chartInstance = null;

    function initChart() {
        const ctx = document.getElementById('trafficChart').getContext('2d');
        
        // Gradient fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.35)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data7.labels,
                datasets: [{
                    label: 'Pengunjung Unik',
                    data: data7.data,
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Space Grotesk', size: 12 },
                        bodyFont: { family: 'Outfit', size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Pengunjung Unik (IP)';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#94a3b8',
                            font: { family: 'Outfit', size: 11 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(226, 232, 240, 0.6)' },
                        ticks: {
                            color: '#94a3b8',
                            stepSize: 1,
                            font: { family: 'Outfit', size: 11 }
                        }
                    }
                }
            }
        });
    }

    function switchChartMode(mode) {
        if (!chartInstance) return;
        currentMode = mode;
        const btn7 = document.getElementById('btn-chart-7');
        const btn30 = document.getElementById('btn-chart-30');

        if (mode === '7') {
            chartInstance.data.labels = data7.labels;
            chartInstance.data.datasets[0].data = data7.data;
            btn7.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-indigo-600 shadow-xs';
            btn30.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900';
        } else {
            chartInstance.data.labels = data30.labels;
            chartInstance.data.datasets[0].data = data30.data;
            btn30.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all bg-white text-indigo-600 shadow-xs';
            btn7.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all text-slate-500 hover:text-slate-900';
        }
        chartInstance.update();
    }

    document.addEventListener('DOMContentLoaded', initChart);
</script>
@endsection
