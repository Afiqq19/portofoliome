<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $profile->bio ?? 'PortfolioMe - Premium Personal Portfolio' }}">
    <title>@yield('title', config('app.name', 'PortfolioMe'))</title>

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
                        danger: 'var(--danger, #ef4444)',
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
    
    <!-- AlpineJS for interactions -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="antialiased text-primary">

    <!-- Navigation -->
    <nav class="navbar animate-fade-in" x-data="{ mobileMenuOpen: false }">
        <div class="container flex justify-between items-center relative">
            <a href="{{ route('home') }}" class="nav-brand text-gradient">
                {{ $profile->name ?? 'PortfolioMe' }}
            </a>
            
            <div class="nav-links hidden md:flex">
                <a href="{{ route('home') }}#skills" class="nav-link">Keahlian</a>
                <a href="{{ route('home') }}#projects" class="nav-link">Projek</a>
                <a href="{{ route('home') }}#contact" class="nav-link">Kontak</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline">Login</a>
                @endauth
            </div>
            
            <!-- Mobile menu button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden btn btn-outline btn-sm p-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden absolute top-full left-0 right-0 bg-secondary border-b border-glass p-4 flex flex-col gap-4 shadow-xl" style="display: none; border-bottom-color: var(--glass-border)">
            <a href="{{ route('home') }}#skills" class="text-secondary hover:text-white font-medium py-2" @click="mobileMenuOpen = false">Keahlian</a>
            <a href="{{ route('home') }}#projects" class="text-secondary hover:text-white font-medium py-2" @click="mobileMenuOpen = false">Projek</a>
            <a href="{{ route('home') }}#contact" class="text-secondary hover:text-white font-medium py-2" @click="mobileMenuOpen = false">Kontak</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary w-full mt-2 text-center" @click="mobileMenuOpen = false">Dashboard Admin</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline w-full mt-2 text-center" @click="mobileMenuOpen = false">Login Admin</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-12 mt-20 relative overflow-hidden">
        <!-- Glowing Divider -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-accent-primary to-transparent opacity-50"></div>
        
        <div class="container text-center relative z-10">
            <h3 class="text-2xl font-bold mb-4 font-['Space_Grotesk'] text-gradient">{{ $profile->name ?? 'PortfolioMe' }}</h3>
            <p class="text-secondary mb-6 max-w-md mx-auto">Membangun pengalaman digital masa depan, satu baris kode pada satu waktu.</p>
            <div class="flex justify-center gap-6 mb-8 text-sm text-secondary font-medium">
                <a href="{{ route('home') }}#skills" class="hover:text-accent-primary transition-colors">Keahlian</a>
                <a href="{{ route('home') }}#projects" class="hover:text-accent-primary transition-colors">Projek</a>
                <a href="{{ route('home') }}#contact" class="hover:text-accent-primary transition-colors">Kontak</a>
            </div>
            <div class="text-sm text-muted">
                <p>&copy; {{ date('Y') }} {{ $profile->name ?? 'PortfolioMe' }}. All rights reserved.</p>
            </div>
        </div>
        
        <!-- Background Glow -->
        <div class="absolute bottom-[-50px] left-1/2 transform -translate-x-1/2 w-96 h-32 bg-accent-primary/20 blur-[100px] rounded-full pointer-events-none"></div>
    </footer>

</body>
</html>
