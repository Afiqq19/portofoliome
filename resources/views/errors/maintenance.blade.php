<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Sedang Dalam Pemeliharaan' }} - {{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://img.icons8.com/fluency/48/source-code.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: {
                            base: '#060609',
                            card: '#0c0c14',
                            border: 'rgba(255, 255, 255, 0.08)'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #060609;
            font-family: 'Outfit', sans-serif;
            color: #f1f5f9;
            overflow-x: hidden;
        }

        .ambient-glow-1 {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, transparent 65%);
        }

        .ambient-glow-2 {
            background: radial-gradient(circle, rgba(236, 72, 153, 0.16) 0%, transparent 65%);
        }

        .ambient-glow-3 {
            background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, transparent 65%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 45%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-amber {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #f43f5e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass-card {
            background: rgba(12, 12, 20, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .grid-pattern {
            background-image: linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 36px 36px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between relative selection:bg-indigo-500 selection:text-white">

    <!-- Ambient Lights -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 -left-40 w-[600px] h-[600px] rounded-full ambient-glow-1 blur-3xl animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] rounded-full ambient-glow-2 blur-3xl animate-pulse" style="animation-duration: 10s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] rounded-full ambient-glow-3 blur-3xl opacity-40"></div>
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
    </div>

    @if(!empty($isPreview))
    <!-- Preview Banner for Admin -->
    <div class="sticky top-0 z-50 bg-indigo-600 text-white text-xs font-bold py-2.5 px-4 text-center shadow-lg flex items-center justify-between">
        <div class="flex items-center gap-2 mx-auto">
            <i class='bx bx-info-circle text-base'></i>
            <span>Mode Pratinjau: Ini adalah simulasi tampilan pemeliharaan yang akan dilihat oleh pengunjung umum.</span>
        </div>
        <a href="{{ route('admin.settings.index') }}" class="px-3 py-1 rounded-lg bg-black/30 hover:bg-black/50 text-white text-[11px] font-mono transition-all">
            Kembali ke Admin
        </a>
    </div>
    @endif

    <!-- Top Navigation Simple Header -->
    <header class="relative z-10 w-full max-w-5xl mx-auto px-4 pt-6 sm:pt-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-[1.5px] shadow-[0_0_20px_rgba(99,102,241,0.5)]">
                <div class="w-full h-full bg-[#060609] rounded-[10px] flex items-center justify-center font-black text-xs tracking-wider">
                    <span class="text-gradient font-black">MSS</span>
                </div>
            </div>
            <div>
                <span class="text-sm font-bold font-['Space_Grotesk'] text-slate-100 block leading-tight">
                    {{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}
                </span>
                <span class="text-[10px] text-slate-400 font-mono">
                    {{ !empty($profile->title) ? trim(explode(',', $profile->title)[0]) : 'Software Engineer' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-mono font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/25">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                <span>Pembaruan Sistem</span>
            </span>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="relative z-10 flex-1 flex items-center justify-center p-4 sm:p-6 my-6">
        <div class="w-full max-w-2xl glass-card rounded-3xl p-6 sm:p-10 text-center shadow-[0_25px_70px_rgba(0,0,0,0.8)] border border-white/10 relative overflow-hidden">
            
            <!-- Background Decorative Accent -->
            <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full bg-indigo-500/15 blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 rounded-full bg-amber-500/15 blur-2xl pointer-events-none"></div>

            <!-- Glowing Maintenance Badge -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-amber-500/15 via-orange-500/10 to-indigo-500/15 border border-amber-500/30 text-amber-400 mb-6 shadow-[0_0_35px_rgba(245,158,11,0.2)]">
                <i class='bx bx-wrench text-4xl animate-pulse'></i>
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-4xl font-extrabold font-['Space_Grotesk'] text-gradient tracking-tight mb-4 leading-snug">
                {{ $title ?? 'Sistem Sedang Dalam Pemeliharaan & Pembaruan' }}
            </h1>

            <!-- Message -->
            <p class="text-slate-400 text-sm sm:text-base leading-relaxed max-w-xl mx-auto mb-8 font-light">
                {{ $message ?? 'Website portofolio kami sedang dalam proses perbaruan karya dan peningkatan fitur terbaru untuk menghadirkan pengalaman terbaik. Kami akan segera kembali online!' }}
            </p>

            <!-- Status Indicator Capsule -->
            <div class="inline-flex flex-wrap items-center justify-center gap-4 sm:gap-6 px-5 py-3 rounded-2xl bg-white/[0.03] border border-white/10 mb-8 text-xs text-slate-300 font-mono">
                <div class="flex items-center gap-2">
                    <i class='bx bx-check-shield text-emerald-400 text-base'></i>
                    <span>Status: <b class="text-emerald-400">Upgrade Berjalan</b></span>
                </div>
                <div class="hidden sm:block w-px h-4 bg-white/10"></div>
                <div class="flex items-center gap-2">
                    <i class='bx bx-time-five text-indigo-400 text-base'></i>
                    <span>Estimasi: <b class="text-indigo-300">Segera Kembali</b></span>
                </div>
            </div>

            <!-- Contact Emergency Action Buttons -->
            <div class="border-t border-white/10 pt-6">
                <p class="text-xs text-slate-400 mb-4 font-['Space_Grotesk'] uppercase tracking-wider font-semibold">
                    Perlu Berdiskusi Atau Konsultasi Projek Segera?
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $profile->phone ?? '6282237905639');
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                    @endphp
                    @if(!empty($cleanPhone))
                    <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($profile->name ?? 'Mhd. Syafiq Syahmi') }},%20saya%20mengunjungi%20website%20portofolio%20Anda%20dan%20ingin%20berdiskusi%20mengenai%20projek/kesempatan%20kerja." target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-xs sm:text-sm font-bold shadow-lg shadow-emerald-500/20 transition-all active:scale-95">
                        <i class='bx bxl-whatsapp text-lg'></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                    @endif

                    @if(!empty($profile->email))
                    <a href="mailto:{{ $profile->email }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-slate-200 hover:text-white text-xs sm:text-sm font-bold transition-all active:scale-95">
                        <i class='bx bx-envelope text-lg text-indigo-400'></i>
                        <span>Kirim Email</span>
                    </a>
                    @endif
                </div>

                <!-- Social Links -->
                @if(isset($profile) && $profile->socialLinks && $profile->socialLinks->count() > 0)
                <div class="flex items-center justify-center gap-3 mt-6 pt-4 border-t border-white/5">
                    @foreach($profile->socialLinks as $link)
                    <a href="{{ $link->url }}" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-indigo-500/20 border border-white/10 hover:border-indigo-500/40 text-slate-400 hover:text-indigo-300 flex items-center justify-center text-sm transition-all" title="{{ $link->platform }}">
                        <i class='{{ $link->icon ?? "bx bx-link" }}'></i>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
    </main>

    <!-- Footer Simple & Admin Bypass Link -->
    <footer class="relative z-10 w-full max-w-5xl mx-auto px-4 py-6 text-center text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-white/5">
        <p>&copy; {{ date('Y') }} {{ $profile->name ?? 'Mhd. Syafiq Syahmi' }}. All rights reserved.</p>
        <a href="{{ route('login') }}" class="text-[11px] text-slate-600 hover:text-slate-400 transition-colors flex items-center gap-1 font-mono">
            <i class='bx bx-lock-alt'></i>
            <span>Akses Login Admin</span>
        </a>
    </footer>

</body>
</html>
