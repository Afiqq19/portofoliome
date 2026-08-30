<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'MSyafiq Portofolio') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.svg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

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
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans">

    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile Backdrop -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 md:hidden"
             style="display: none;"></div>

        <!-- Sidebar Toggle Mobile -->
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden fixed top-4 right-4 z-50 p-2.5 rounded-xl bg-white border border-slate-200 shadow-md text-slate-700 hover:text-indigo-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </button>

        <!-- Sidebar -->
        <aside class="w-[260px] flex flex-col fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-200 shadow-sm transition-transform duration-300 transform md:translate-x-0" 
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            
            <!-- Sidebar Header / Brand -->
            <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-black text-xs tracking-wider shadow-md shadow-indigo-500/20">
                    MSS
                </div>
                <div>
                    <h2 class="font-bold text-base font-['Space_Grotesk'] text-slate-900 leading-tight">Admin Panel</h2>
                    <p class="text-xs text-slate-500 font-medium truncate max-w-[140px]">{{ $profile->name ?? 'Portofolio' }}</p>
                </div>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-1">
                
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class='bx bxs-dashboard text-lg'></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-6 mb-2 px-3">Konten</div>
                
                <a href="{{ route('admin.profile.edit') }}" class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class='bx bx-user text-lg'></i>
                    <span>Profil & Sosmed</span>
                </a>
                
                <a href="{{ route('admin.skills.index') }}" class="sidebar-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                    <i class='bx bx-code-alt text-lg'></i>
                    <span>Keahlian</span>
                </a>
                
                <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <i class='bx bx-folder text-lg'></i>
                    <span>Projek</span>
                </a>

                <a href="{{ route('admin.certificates.index') }}" class="sidebar-link {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                    <i class='bx bx-award text-lg'></i>
                    <span>Sertifikat</span>
                </a>
                
                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-6 mb-2 px-3">Interaksi</div>
                
                <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class='bx bx-envelope text-lg'></i>
                    <span>Pesan Masuk</span>
                </a>

                <a href="{{ route('admin.notes.index') }}" class="sidebar-link {{ request()->routeIs('admin.notes.*') ? 'active' : '' }}">
                    <i class='bx bx-notepad text-lg'></i>
                    <span>Catatan Pengunjung</span>
                </a>
                
                <a href="{{ route('admin.donations.index') }}" class="sidebar-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                    <i class='bx bx-coffee text-lg'></i>
                    <span>Donasi (Trakteer)</span>
                </a>

                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-6 mb-2 px-3">Sistem</div>

                <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class='bx bx-slider text-lg'></i>
                    <span>Pengaturan Tampilan</span>
                </a>

                <a href="{{ route('admin.backup.index') }}" class="sidebar-link {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
                    <i class='bx bx-data text-lg'></i>
                    <span>Backup & Restore</span>
                </a>
            </nav>
            
            <!-- Bottom User & Logout Box -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200/60 transition-colors cursor-pointer">
                        <i class='bx bx-log-out text-base'></i>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 relative w-full md:ml-[260px] p-5 sm:p-8 min-h-screen overflow-x-hidden">
            
            <!-- Top Header Navbar -->
            <header class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8 pb-4 border-b border-slate-200">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">{{ date('l, d F Y') }}</p>
                    <h2 class="text-2xl font-bold font-['Space_Grotesk'] text-slate-900">Halo, {{ $profile->name ?? 'Admin' }}! 👋</h2>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline btn-sm flex items-center gap-2 shadow-sm hover:border-indigo-500 hover:text-indigo-600">
                        <i class='bx bx-link-external text-base'></i>
                        <span>Lihat Website</span>
                    </a>
                </div>
            </header>

            <!-- Flash Messages (Floating Toasts) -->
            <div style="position: fixed; top: 1.5rem; right: 1.5rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.5rem; min-width: 320px; max-width: 420px;">
                @if(session('success'))
                    <div class="alert alert-success shadow-lg" x-data="{ show: true }" x-show="show">
                        <i class='bx bx-check-circle text-xl mr-2 text-emerald-600'></i>
                        <span class="flex-1 font-medium text-emerald-900">{{ session('success') }}</span>
                        <button @click="show = false" class="text-emerald-700 hover:text-emerald-900 text-lg leading-none cursor-pointer">&times;</button>
                    </div>
                @endif
            
                @if(session('error') || $errors->any())
                    <div class="alert alert-error shadow-lg" x-data="{ show: true }" x-show="show">
                        <i class='bx bx-error-circle text-xl mr-2 text-rose-600'></i>
                        <div class="flex-1">
                            @if(session('error'))
                                <p class="font-medium text-rose-900">{{ session('error') }}</p>
                            @endif
                            @if($errors->any())
                                <ul class="text-xs mt-1 text-rose-800" style="list-style-type: disc; padding-left: 1rem;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <button @click="show = false" class="text-rose-700 hover:text-rose-900 text-lg leading-none cursor-pointer">&times;</button>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

</body>
</html>
