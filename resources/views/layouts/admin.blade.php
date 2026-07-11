<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'PortfolioMe') }}</title>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    backgroundColor: {
                        primary: 'var(--bg-primary)',
                        secondary: 'var(--bg-secondary)',
                        tertiary: 'var(--bg-tertiary)',
                    },
                    textColor: {
                        primary: 'var(--text-primary)',
                        secondary: 'var(--text-secondary)',
                        muted: 'var(--text-muted)',
                        danger: '#ef4444',
                    },
                    colors: {
                        accent: {
                            primary: 'var(--accent-primary)',
                            secondary: 'var(--accent-secondary)',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- ChartJS for stats -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="antialiased text-primary">

    <div class="admin-layout" x-data="{ sidebarOpen: false }">
        <!-- Sidebar Toggle Mobile -->
        <style>
            @media (min-width: 768px) { .mobile-toggle-btn { display: none !important; } }
        </style>
        <button @click="sidebarOpen = !sidebarOpen" class="btn btn-outline mobile-toggle-btn" style="position: fixed; top: 1rem; right: 1rem; z-index: 50; background: var(--bg-primary);">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </button>

        <!-- Sidebar -->
        <aside class="sidebar" :class="{ 'hidden': !sidebarOpen, 'md:flex': true }" style="background: rgba(18, 18, 23, 0.6); backdrop-filter: blur(20px); border-right: 1px solid rgba(255,255,255,0.05); box-shadow: 5px 0 30px rgba(0,0,0,0.5);">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="nav-brand text-gradient text-2xl">
                    Admin Panel
                </a>
                <p class="text-sm text-secondary mt-1">PortfolioMe</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    Dashboard
                </a>
                
                <div class="text-xs text-muted font-bold uppercase tracking-wider mt-6 mb-2 px-4">Konten</div>
                
                <a href="{{ route('admin.profile.edit') }}" class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Profil & Sosmed
                </a>
                
                <a href="{{ route('admin.skills.index') }}" class="sidebar-link {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    Keahlian
                </a>
                
                <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>
                    Projek
                </a>
                
                <div class="text-xs text-muted font-bold uppercase tracking-wider mt-6 mb-2 px-4">Interaksi</div>
                
                <a href="{{ route('admin.donations.index') }}" class="sidebar-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    Donasi
                </a>
                
                <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Pesan Masuk
                </a>
            </nav>
            
            <div class="p-4 border-t" style="border-color: var(--glass-border)">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-danger hover:bg-danger hover:text-white mt-0 mb-0" style="color: var(--danger)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main relative">
            
            <!-- Top Header Navbar -->
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-glass" style="border-bottom-color: var(--glass-border)">
                <div class="hidden md:block">
                    <p class="text-secondary text-sm">{{ date('l, d F Y') }}</p>
                    <h2 class="text-xl font-bold">Halo, {{ $profile->name ?? 'Admin' }}! 👋</h2>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline btn-sm" style="border-color: var(--accent-primary); color: var(--text-primary);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                        Lihat Web
                    </a>
                </div>
            </div>

            <!-- Flash Messages (Floating Toasts) -->
            <div style="position: fixed; top: 1.5rem; right: 1.5rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.5rem; min-width: 300px; max-width: 400px;">
                @if(session('success'))
                    <div class="alert alert-success animate-fade-in shadow-lg" x-data="{ show: true }" x-show="show" style="background: rgba(16, 185, 129, 0.15); backdrop-filter: blur(10px); box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <span class="flex-1 font-medium">{{ session('success') }}</span>
                        <button @click="show = false" class="hover:text-white">&times;</button>
                    </div>
                @endif
            
                @if(session('error') || $errors->any())
                    <div class="alert alert-error animate-fade-in shadow-lg" x-data="{ show: true }" x-show="show" style="background: rgba(239, 68, 68, 0.15); backdrop-filter: blur(10px); box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        <div class="flex-1">
                            @if(session('error'))
                                <p class="font-medium">{{ session('error') }}</p>
                            @endif
                            @if($errors->any())
                                <ul class="text-sm mt-1" style="list-style-type: disc; padding-left: 1rem;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <button @click="show = false" class="hover:text-white">&times;</button>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>

</body>
</html>
