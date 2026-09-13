<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Mhd. Syafiq Syahmi</title>
    
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

        .ambient-glow {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 65%);
        }

        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 50%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white relative bg-[#060609]">

    <div class="fixed top-[-100px] left-1/2 -translate-x-1/2 w-[700px] h-[500px] ambient-glow blur-[100px] pointer-events-none -z-10"></div>

    <!-- Header -->
    <header class="w-full py-6 px-4 sm:px-8 border-b border-white/5 backdrop-blur-md bg-[#060609]/70 relative z-20">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-600 to-pink-500 p-[1.5px] shadow-[0_0_20px_rgba(99,102,241,0.3)]">
                    <div class="w-full h-full bg-[#0c0c14] rounded-[14px] flex items-center justify-center font-bold text-sm">
                        <span class="text-indigo-400 font-mono font-black">MSS</span>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-sm tracking-tight text-white font-['Space_Grotesk']">Mhd. Syafiq Syahmi</span>
                    <span class="text-[10px] text-slate-400 font-mono">Portofolio & Rekayasa Sistem</span>
                </div>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 py-16 relative z-10">
        <div class="max-w-xl w-full text-center space-y-8">
            <div class="relative inline-flex items-center justify-center">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl bg-gradient-to-tr from-indigo-500/20 via-purple-500/15 to-transparent border border-indigo-500/30 backdrop-blur-2xl flex items-center justify-center shadow-[0_0_50px_rgba(99,102,241,0.25)]">
                    <i class='bx bx-compass text-5xl sm:text-6xl text-indigo-400'></i>
                </div>
            </div>

            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300 text-xs font-mono">
                    <span>ERROR STATUS CODE: <b>404 NOT FOUND</b></span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black font-['Space_Grotesk'] tracking-tight text-gradient">
                    Halaman Tidak Ditemukan
                </h1>

                <p class="text-slate-400 text-sm sm:text-base leading-relaxed max-w-md mx-auto font-sans">
                    Halaman yang Anda tuju tidak ditemukan atau telah dipindahkan ke tautan lain. Silakan kembali ke beranda.
                </p>
            </div>

            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3.5">
                <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold text-sm shadow-[0_10px_30px_rgba(99,102,241,0.3)] transition-all duration-300 hover:scale-[1.02] active:scale-95">
                    <i class='bx bx-left-arrow-alt text-xl'></i>
                    <span>Kembali ke Halaman Utama</span>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 px-4 text-center border-t border-white/5 text-xs text-slate-500 relative z-20">
        <p>&copy; {{ date('Y') }} Mhd. Syafiq Syahmi. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
