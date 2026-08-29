<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - {{ config('app.name', 'MSyafiq Portofolio') }}</title>
    <link rel="icon" href="{{ asset('iconn.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Vite Assets -->
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        heading: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans flex items-center justify-center min-h-screen relative p-4">

    <!-- Back to home -->
    <a href="{{ route('home') }}" class="absolute top-6 left-6 text-slate-500 hover:text-indigo-600 flex items-center gap-2 font-medium transition-colors text-sm">
        <span class="w-9 h-9 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center">
            <i class='bx bx-arrow-back text-lg'></i>
        </span>
        <span>Kembali ke Portofolio</span>
    </a>

    <div class="w-full max-w-md my-8">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-black text-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-500/25">
                <i class='bx bx-lock-alt text-3xl'></i>
            </div>
            <h1 class="text-3xl font-black font-['Space_Grotesk'] text-slate-900 mb-1">Admin Portal</h1>
            <p class="text-slate-500 text-sm">Masuk untuk mengelola seluruh data portofolio</p>
        </div>

        <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50">
            
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                    <div class="font-bold mb-1 flex items-center gap-1.5">
                        <i class='bx bx-error-circle text-base'></i>
                        <span>Login Gagal:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label class="form-label text-xs">Alamat Email</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control text-sm" required autofocus placeholder="admin@example.com">
                    </div>
                </div>

                <div>
                    <label class="form-label text-xs">Password</label>
                    <div class="relative">
                        <input type="password" name="password" class="form-control text-sm" required placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded text-indigo-600 accent-indigo-600">
                        <span class="text-xs font-medium text-slate-600">Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full py-3.5 text-sm font-bold shadow-lg shadow-indigo-500/25 flex items-center justify-center gap-2 mt-2">
                    <span>Masuk ke Dashboard</span>
                    <i class='bx bx-log-in text-lg'></i>
                </button>
            </form>
        </div>
        
        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>

</body>
</html>
