<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Deploy Kedaluwarsa | Mhd. Syafiq Syahmi</title>
    
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

    <style>
        body {
            background-color: #060609;
            font-family: 'Outfit', sans-serif;
            color: #f1f5f9;
            overflow-x: hidden;
        }

        .ambient-glow-amber {
            background: radial-gradient(circle, rgba(245, 158, 11, 0.18) 0%, transparent 65%);
        }

        .ambient-glow-rose {
            background: radial-gradient(circle, rgba(244, 63, 94, 0.15) 0%, transparent 65%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #fde68a 50%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-amber-500 selection:text-white relative bg-[#060609]">

    <!-- Ambient Glow Backgrounds -->
    <div class="fixed top-[-100px] left-1/2 -translate-x-1/2 w-[700px] h-[500px] ambient-glow-amber blur-[100px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-[-100px] right-[-100px] w-[500px] h-[500px] ambient-glow-rose blur-[120px] pointer-events-none -z-10"></div>

    <!-- Navigation Brand Header -->
    <header class="w-full py-6 px-4 sm:px-8 border-b border-white/5 backdrop-blur-md bg-[#060609]/70 relative z-20">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-amber-500 via-orange-500 to-rose-600 p-[1.5px] shadow-[0_0_20px_rgba(245,158,11,0.3)]">
                    <div class="w-full h-full bg-[#0c0c14] rounded-[14px] flex items-center justify-center font-bold text-sm">
                        <span class="text-amber-400 font-mono font-black">MSS</span>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-sm tracking-tight text-white font-['Space_Grotesk']">Panel Administrator</span>
                    <span class="text-[10px] text-slate-400 font-mono">Keamanan Deploy Server</span>
                </div>
            </a>

            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-mono bg-amber-500/10 border border-amber-500/30 text-amber-400 font-semibold">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span>Single-Use Token Expired</span>
            </span>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex items-center justify-center px-4 py-16 relative z-10">
        <div class="max-w-xl w-full text-center space-y-8">
            
            <!-- Lock Refresh Shield Illustration -->
            <div class="relative inline-flex items-center justify-center">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl bg-gradient-to-tr from-amber-500/20 via-orange-500/15 to-transparent border border-amber-500/30 backdrop-blur-2xl flex items-center justify-center shadow-[0_0_50px_rgba(245,158,11,0.25)] relative group">
                    <i class='bx bx-sync text-5xl sm:text-6xl text-amber-400 group-hover:rotate-180 transition-transform duration-700'></i>
                    
                    <!-- Alert Badge -->
                    <span class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-rose-600 text-white flex items-center justify-center text-lg font-bold border-2 border-[#060609] shadow-lg">
                        <i class='bx bx-x'></i>
                    </span>
                </div>
            </div>

            <!-- Title & Description -->
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300 text-xs font-mono">
                    <i class='bx bx-shield-quarter text-amber-400 text-sm'></i>
                    <span>PROTEKSI KEAMANAN: <b>TOKEN SEKALI PAKAI HANGUS</b></span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black font-['Space_Grotesk'] tracking-tight text-gradient">
                    Token Sudah Digunakan
                </h1>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-lg mx-auto font-sans">
                    {{ $message ?? 'Token deploy sekali pakai ini sudah digunakan dan otomatis dihanguskan. Jika halaman di-refresh, sistem menolak eksekusi ulang untuk mencegah pemborosan resource dan error ganda.' }}
                </p>
            </div>

            <!-- Information Card -->
            <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-left max-w-md mx-auto space-y-2">
                <div class="text-xs font-bold text-amber-400 font-['Space_Grotesk'] flex items-center gap-2">
                    <i class='bx bxs-info-circle text-base'></i>
                    <span>Bagaimana Cara Deploy Ulang?</span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Buka menu <b>Pengaturan Tampilan</b> di Panel Admin, lalu klik tombol <b>"Jalankan Deploy Sekarang"</b> untuk membuat token baru yang sah.
                </p>
            </div>

            <!-- Single Action Button -->
            <div class="pt-2 flex justify-center">
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-bold text-sm shadow-[0_10px_30px_rgba(245,158,11,0.3)] hover:shadow-[0_15px_40px_rgba(245,158,11,0.5)] transition-all duration-300 hover:scale-[1.02] active:scale-95 cursor-pointer">
                    <i class='bx bx-slider text-lg'></i>
                    <span>Kembali ke Pengaturan Web</span>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 px-4 text-center border-t border-white/5 text-xs text-slate-500 relative z-20">
        <p>&copy; {{ date('Y') }} Mhd. Syafiq Syahmi. Proteksi Keamanan Sistem Aktif.</p>
    </footer>

</body>
</html>
