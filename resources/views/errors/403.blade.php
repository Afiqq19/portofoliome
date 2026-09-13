<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Tidak Tersedia | Mhd. Syafiq Syahmi</title>
    
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

        .ambient-glow {
            background: radial-gradient(circle, rgba(239, 68, 68, 0.18) 0%, transparent 65%);
        }

        .ambient-glow-purple {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 65%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #fca5a5 50%, #f43f5e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-rose-500 selection:text-white relative bg-[#060609]">

    <!-- Background Ambient Light Circles -->
    <div class="fixed top-[-100px] left-1/2 -translate-x-1/2 w-[700px] h-[500px] ambient-glow blur-[100px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-[-100px] right-[-100px] w-[500px] h-[500px] ambient-glow-purple blur-[120px] pointer-events-none -z-10"></div>

    <!-- Navigation Brand Header -->
    <header class="w-full py-6 px-4 sm:px-8 border-b border-white/5 backdrop-blur-md bg-[#060609]/70 relative z-20">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-rose-500 via-purple-600 to-indigo-600 p-[1.5px] shadow-[0_0_20px_rgba(244,63,94,0.3)]">
                    <div class="w-full h-full bg-[#0c0c14] rounded-[14px] flex items-center justify-center font-bold text-sm">
                        <span class="text-rose-400 font-mono font-black">MSS</span>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-sm tracking-tight text-white font-['Space_Grotesk']">Mhd. Syafiq Syahmi</span>
                    <span class="text-[10px] text-slate-400 font-mono">Portofolio & Rekayasa Sistem</span>
                </div>
            </a>

            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-mono bg-rose-500/10 border border-rose-500/30 text-rose-400 font-semibold">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                <span>Restricted Access</span>
            </span>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex items-center justify-center px-4 py-16 relative z-10">
        <div class="max-w-xl w-full text-center space-y-8">
            
            <!-- Shield Lock Illustration -->
            <div class="relative inline-flex items-center justify-center">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl bg-gradient-to-tr from-rose-500/20 via-purple-500/15 to-transparent border border-rose-500/30 backdrop-blur-2xl flex items-center justify-center shadow-[0_0_50px_rgba(244,63,94,0.25)] relative group">
                    <i class='bx bxs-shield-x text-5xl sm:text-6xl text-rose-400 group-hover:scale-110 transition-transform duration-300'></i>
                    
                    <!-- Decorative Orbit Dot -->
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 border-2 border-[#060609] animate-ping"></span>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 border-2 border-[#060609]"></span>
                </div>
            </div>

            <!-- Error Code & Title -->
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300 text-xs font-mono">
                    <i class='bx bx-lock-alt text-rose-400 text-sm'></i>
                    <span>ERROR STATUS CODE: <b>403 FORBIDDEN</b></span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black font-['Space_Grotesk'] tracking-tight text-gradient">
                    Akses Tidak Tersedia
                </h1>

                <p class="text-slate-400 text-sm sm:text-base leading-relaxed max-w-md mx-auto font-sans">
                    {{ $exception->getMessage() ?: 'Halaman atau direktori ini bersifat terbatas dan tidak tersedia untuk publik. Seluruh akses telah diamankan oleh protokol keamanan sistem.' }}
                </p>
            </div>

            <!-- Action Button -->
            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3.5">
                <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-2xl bg-gradient-to-r from-rose-600 via-purple-600 to-indigo-600 hover:from-rose-500 hover:to-indigo-500 text-white font-bold text-sm shadow-[0_10px_30px_rgba(244,63,94,0.3)] hover:shadow-[0_15px_40px_rgba(244,63,94,0.5)] transition-all duration-300 hover:scale-[1.02] active:scale-95">
                    <i class='bx bx-left-arrow-alt text-xl'></i>
                    <span>Kembali ke Halaman Utama</span>
                </a>
                <a href="{{ route('home') }}#contact" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white border border-white/10 text-sm font-semibold transition-all">
                    <i class='bx bx-envelope text-lg text-rose-400'></i>
                    <span>Hubungi Pengembang</span>
                </a>
            </div>

            <!-- Subtle Security Note -->
            <div class="pt-6 border-t border-white/5">
                <p class="text-[11px] font-mono text-slate-500">
                    Security Policy ID: <span class="text-slate-400 font-bold">SEC-AUTH-PROTECTED</span> • Portofolio Mhd. Syafiq Syahmi
                </p>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 px-4 text-center border-t border-white/5 text-xs text-slate-500 relative z-20">
        <p>&copy; {{ date('Y') }} Mhd. Syafiq Syahmi. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
