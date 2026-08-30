@extends('layouts.app')

@section('title', ($profile->name ?? 'Mhd. Syafiq Syahmi') . ' - Tanya Jawab (FAQ)')

@section('content')
<div class="pt-32 pb-24 relative overflow-hidden" x-data="{ 
    activeFaq: 1, 
    searchQuery: '', 
    activeCategory: 'all',
    filterFaq(category, text) {
        const matchesCategory = this.activeCategory === 'all' || this.activeCategory === category;
        const matchesSearch = this.searchQuery === '' || text.toLowerCase().includes(this.searchQuery.toLowerCase());
        return matchesCategory && matchesSearch;
    }
}">

    <!-- Ambient Glowing Orbs Background -->
    <div class="absolute top-20 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none -z-10"></div>
    <div class="absolute top-60 right-10 w-[350px] h-[350px] bg-purple-600/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>

    <div class="container max-w-5xl mx-auto px-4">
        
        <!-- Back Navigation & Breadcrumb -->
        <div class="reveal mb-10 flex items-center justify-between flex-wrap gap-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-bold text-slate-300 hover:text-white transition-all group">
                <i class='bx bx-arrow-back text-base group-hover:-translate-x-1 transition-transform'></i>
                <span x-text="$store.lang?.current === 'en' ? 'Back to Home' : 'Kembali ke Beranda'">Kembali ke Beranda</span>
            </a>

            <div class="flex items-center gap-2 text-xs text-slate-400 font-mono">
                <a href="{{ route('home') }}" class="hover:text-indigo-400">Home</a>
                <span>/</span>
                <span class="text-indigo-400 font-bold">FAQ & Policies</span>
            </div>
        </div>

        <!-- Header Hero -->
        <div class="reveal flex flex-col items-center mb-12 text-center">
            <div class="badge mb-3.5" x-text="$store.lang?.current === 'en' ? 'Help Center & Policies' : 'Pusat Informasi & Tanya Jawab'">Pusat Informasi & Tanya Jawab</div>
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-black font-['Space_Grotesk'] text-slate-100 mb-4 leading-tight">
                <span x-text="$store.lang?.current === 'en' ? 'Frequently' : 'Pertanyaan'">Pertanyaan</span> <span class="text-gradient" x-text="$store.lang?.current === 'en' ? 'Asked Questions' : 'yang Sering Diajukan'">yang Sering Diajukan</span>
            </h1>
            <p class="text-slate-400 max-w-2xl text-sm sm:text-base leading-relaxed" x-text="$store.lang?.current === 'en' ? 'Transparent answers regarding project workflows, deliverables, source code ownership, payments, bug warranties, and server deployments.' : 'Informasi transparan seputar alur kerjasama, serah terima berkas, hak milik source code, skema pembayaran, garansi perbaikan bug, dan deployment server.'">
                Informasi transparan seputar alur kerjasama, serah terima berkas, hak milik source code, skema pembayaran, garansi perbaikan bug, dan deployment server.
            </p>
        </div>

        <!-- Search Bar & Category Filter Tabs -->
        <div class="reveal mb-12 space-y-5">
            
            <!-- Live Search Bar -->
            <div class="relative max-w-2xl mx-auto">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class='bx bx-search text-xl'></i>
                </div>
                <input type="text" 
                       x-model="searchQuery" 
                       :placeholder="$store.lang?.current === 'en' ? 'Search questions (e.g. warranty, payment, source code, hosting)...' : 'Cari pertanyaan (misal: garansi, harga, source code, hosting, revisi)...'"
                       class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-white/5 border border-white/10 focus:border-indigo-500 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 backdrop-blur-xl shadow-lg transition-all">
                <button x-show="searchQuery.length > 0" @click="searchQuery = ''" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-white" style="display: none;">
                    <i class='bx bx-x text-xl'></i>
                </button>
            </div>

            <!-- Category Pills -->
            <div class="flex flex-wrap justify-center gap-2 text-xs">
                <button @click="activeCategory = 'all'" 
                        class="px-4 py-2 rounded-full border transition-all font-bold cursor-pointer"
                        :class="activeCategory === 'all' ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg' : 'bg-white/5 border-white/10 text-slate-400 hover:text-white hover:bg-white/10'">
                    <span x-text="$store.lang?.current === 'en' ? 'All Questions' : 'Semua Pertanyaan'">Semua Pertanyaan</span>
                </button>
                <button @click="activeCategory = 'workflow'" 
                        class="px-4 py-2 rounded-full border transition-all font-bold cursor-pointer"
                        :class="activeCategory === 'workflow' ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg' : 'bg-white/5 border-white/10 text-slate-400 hover:text-white hover:bg-white/10'">
                    <span x-text="$store.lang?.current === 'en' ? 'Workflow & Timeline' : 'Alur & Waktu Pengerjaan'">Alur & Waktu Pengerjaan</span>
                </button>
                <button @click="activeCategory = 'code'" 
                        class="px-4 py-2 rounded-full border transition-all font-bold cursor-pointer"
                        :class="activeCategory === 'code' ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg' : 'bg-white/5 border-white/10 text-slate-400 hover:text-white hover:bg-white/10'">
                    <span x-text="$store.lang?.current === 'en' ? 'Source Code & Ownership' : 'Source Code & Hak Milik'">Source Code & Hak Milik</span>
                </button>
                <button @click="activeCategory = 'payment'" 
                        class="px-4 py-2 rounded-full border transition-all font-bold cursor-pointer"
                        :class="activeCategory === 'payment' ? 'bg-indigo-600 border-indigo-500 text-white shadow-lg' : 'bg-white/5 border-white/10 text-slate-400 hover:text-white hover:bg-white/10'">
                    <span x-text="$store.lang?.current === 'en' ? 'Payment & Warranty' : 'Pembayaran & Garansi'">Pembayaran & Garansi</span>
                </button>
            </div>
        </div>

        <!-- FAQ Accordion List -->
        <div class="space-y-4 max-w-4xl mx-auto">
            
            <!-- FAQ 1: Timeline -->
            <div x-show="filterFaq('workflow', 'estimasi durasi waktu pengerjaan projek timeline delivery how long take website app')" class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xs font-bold font-mono">01</span>
                        <span x-text="$store.lang?.current === 'en' ? 'How long does a website or mobile app project take?' : 'Berapa lama estimasi waktu pengerjaan projek website/aplikasi?'">Berapa lama estimasi waktu pengerjaan projek website/aplikasi?</span>
                    </span>
                    <i class="bx text-2xl text-indigo-400 transition-transform duration-300" :class="activeFaq === 1 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 1" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Durations depend on functional complexity. Simple landing pages take 3-7 workdays, company profiles take 7-14 days, while full-scale custom web applications, SaaS, or e-commerce systems typically take 2-4 weeks with clear milestone updates.' : 'Tergantung pada kompleksitas fitur. Landing page promosi berkisar 3-7 hari kerja, website company profile 7-14 hari, sedangkan custom web application/SaaS/toko online sistem penuh sekitar 2-4 minggu dengan pembagian milestone yang jelas.'">
                        Tergantung pada kompleksitas fitur. Landing page promosi berkisar 3-7 hari kerja, website company profile 7-14 hari, sedangkan custom web application/SaaS/toko online sistem penuh sekitar 2-4 minggu dengan pembagian milestone yang jelas.
                    </p>
                </div>
            </div>

            <!-- FAQ 2: Source Code Ownership -->
            <div x-show="filterFaq('code', 'source code hak milik penuh repositori github zip ownership rights deliverable')" class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xs font-bold font-mono">02</span>
                        <span x-text="$store.lang?.current === 'en' ? 'Do I get the complete source code and 100% full ownership?' : 'Apakah saya mendapatkan source code lengkap & hak milik 100% penuh?'">Apakah saya mendapatkan source code lengkap & hak milik 100% penuh?</span>
                    </span>
                    <i class="bx text-2xl text-cyan-400 transition-transform duration-300" :class="activeFaq === 2 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 2" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Yes, 100%! Upon project handover and final payment, all source code repositories (ZIP/GitHub), database schemas, design assets, and administrative credentials are fully transferred to you without hidden dependencies.' : 'Ya, 100%! Setelah pelunasan dan serah terima projek, seluruh repositori source code (ZIP/GitHub), skema database, aset desain, dan kredensial admin sistem diserahkan penuh kepada Anda tanpa ikatan dependensi tersembunyi.'">
                        Ya, 100%! Setelah pelunasan dan serah terima projek, seluruh repositori source code (ZIP/GitHub), skema database, aset desain, dan kredensial admin sistem diserahkan penuh kepada Anda tanpa ikatan dependensi tersembunyi.
                    </p>
                </div>
            </div>

            <!-- FAQ 3: Payment & Revision -->
            <div x-show="filterFaq('payment', 'pembayaran dp termin cicilan revisi policy payment structure revision policy')" class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center text-xs font-bold font-mono">03</span>
                        <span x-text="$store.lang?.current === 'en' ? 'What is the payment structure and revision policy?' : 'Bagaimana tahapan pembayaran dan kebijakan revisi projek?'">Bagaimana tahapan pembayaran dan kebijakan revisi projek?</span>
                    </span>
                    <i class="bx text-2xl text-purple-400 transition-transform duration-300" :class="activeFaq === 3 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 3" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Payments are milestone-based: 40-50% upfront to begin development, with the remainder due upon demo approval and final testing. Revisions within the agreed scope are free of charge.' : 'Pembayaran dilakukan bertahap (DP 40-50% di awal untuk mulai development, sisa pelunasan setelah live demo lolos uji coba Anda). Kami memberikan revisi gratis hingga hasil sesuai kesepakatan rancangan awal.'">
                        Pembayaran dilakukan bertahap (DP 40-50% di awal untuk mulai development, sisa pelunasan setelah live demo lolos uji coba Anda). Kami memberikan revisi gratis hingga hasil sesuai kesepakatan rancangan awal.
                    </p>
                </div>
            </div>

            <!-- FAQ 4: Warranty & Maintenance -->
            <div x-show="filterFaq('payment', 'garansi perbaikan bug maintenance support warranty after sales')" class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 4 ? null : 4" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold font-mono">04</span>
                        <span x-text="$store.lang?.current === 'en' ? 'Is there a bug-fix warranty and after-sales support?' : 'Apakah ada garansi perbaikan bug dan pendampingan teknis setelah rilis?'">Apakah ada garansi perbaikan bug dan pendampingan teknis setelah rilis?</span>
                    </span>
                    <i class="bx text-2xl text-emerald-400 transition-transform duration-300" :class="activeFaq === 4 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 4" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Absolutely! Every completed project includes a 30-day free bug-fix warranty and technical maintenance assistance to guarantee stability in production.' : 'Tentu saja! Setiap projek yang selesai mendapatkan garansi bebas bug gratis selama 30 hari kalender serta pendampingan teknis agar sistem berjalan stabil di server produksi.'">
                        Tentu saja! Setiap projek yang selesai mendapatkan garansi bebas bug gratis selama 30 hari kalender serta pendampingan teknis agar sistem berjalan stabil di server produksi.
                    </p>
                </div>
            </div>

            <!-- FAQ 5: Server Deployment & Domain Setup -->
            <div x-show="filterFaq('workflow', 'hosting server domain vps cloud deployment cpanel ssl https')" class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 5 ? null : 5" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center text-xs font-bold font-mono">05</span>
                        <span x-text="$store.lang?.current === 'en' ? 'Can you assist with domain, hosting, and VPS server configuration?' : 'Apakah bisa mendampingi proses setup domain, hosting & server VPS?'">Apakah bisa mendampingi proses setup domain, hosting & server VPS?</span>
                    </span>
                    <i class="bx text-2xl text-amber-400 transition-transform duration-300" :class="activeFaq === 5 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 5" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'Yes, we provide end-to-end deployment assistance: setting up custom domains (.com/.id), configuring cPanel/VPS/Cloud hosting, and setting up SSL HTTPS certificates.' : 'Ya, kami siap membantu proses deployment end-to-end: mulai dari konfigurasi domain (.com/.id), setup web server cPanel/VPS/Cloud, hingga sertifikat SSL HTTPS terpasang dan siap diakses publik.'">
                        Ya, kami siap membantu proses deployment end-to-end: mulai dari konfigurasi domain (.com/.id), setup web server cPanel/VPS/Cloud, hingga sertifikat SSL HTTPS terpasang dan siap diakses publik.
                    </p>
                </div>
            </div>

            <!-- FAQ 6: Tech Stack Used -->
            <div x-show="filterFaq('code', 'teknologi bahasa pemrograman tech stack framework laravel vue flutter')" class="reveal glass-card rounded-2xl border border-white/10 overflow-hidden transition-all">
                <button @click="activeFaq = activeFaq === 6 ? null : 6" class="w-full p-6 text-left flex justify-between items-center gap-4 cursor-pointer focus:outline-none">
                    <span class="font-bold text-slate-100 text-base md:text-lg flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-rose-500/20 text-rose-400 flex items-center justify-center text-xs font-bold font-mono">06</span>
                        <span x-text="$store.lang?.current === 'en' ? 'What technologies and tech stacks are commonly used?' : 'Teknologi dan tech stack apa yang biasa digunakan?'">Teknologi dan tech stack apa yang biasa digunakan?</span>
                    </span>
                    <i class="bx text-2xl text-rose-400 transition-transform duration-300" :class="activeFaq === 6 ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="activeFaq === 6" x-collapse class="px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    <p x-text="$store.lang?.current === 'en' ? 'We use proven modern tech stacks: Laravel 11 & PHP 8.x for high-security backends, Vue.js / Tailwind CSS for responsive frontends, MySQL/PostgreSQL for databases, and Flutter for Android APK mobile apps.' : 'Kami menggunakan stack modern teruji: Laravel 11 & PHP 8.x untuk backend berkeamanan tinggi, Vue.js / Tailwind CSS untuk frontend interaktif responsif, MySQL/PostgreSQL untuk basis data, dan Flutter untuk mobile app Android.'">
                        Kami menggunakan stack modern teruji: Laravel 11 & PHP 8.x untuk backend berkeamanan tinggi, Vue.js / Tailwind CSS untuk frontend interaktif responsif, MySQL/PostgreSQL untuk basis data, dan Flutter untuk mobile app Android.
                    </p>
                </div>
            </div>

        </div>

        <!-- Consultation & Contact CTA Card -->
        <div class="reveal mt-16 glass-panel p-8 sm:p-12 rounded-3xl border border-indigo-500/30 bg-gradient-to-r from-indigo-950/40 via-purple-950/30 to-indigo-950/40 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 text-xs font-bold font-mono mb-3">
                    <i class='bx bx-conversation'></i>
                    <span x-text="$store.lang?.current === 'en' ? 'Direct Consultation' : 'Konsultasi Langsung'">Konsultasi Langsung</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-black font-['Space_Grotesk'] text-slate-100 mb-2 leading-tight">
                    <span x-text="$store.lang?.current === 'en' ? 'Still have other questions?' : 'Masih punya pertanyaan lain?'">Masih punya pertanyaan lain?</span>
                </h3>
                <p class="text-slate-400 text-sm leading-relaxed" x-text="$store.lang?.current === 'en' ? 'Feel free to reach out directly via WhatsApp or send a message through the contact form for a personalized consultation.' : 'Jangan ragu untuk berdiskusi langsung melalui WhatsApp atau kirimkan pesan untuk konsultasi spesifikasi kebutuhan projek Anda.'">
                    Jangan ragu untuk berdiskusi langsung melalui WhatsApp atau kirimkan pesan untuk konsultasi spesifikasi kebutuhan projek Anda.
                </p>
            </div>

            <div class="flex flex-wrap gap-3.5 flex-shrink-0">
                @if($profile && $profile->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone) }}" target="_blank" class="btn btn-primary btn-shimmer py-3.5 px-6 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-2 shadow-xl hover:scale-105 transition-transform">
                    <i class='bx bxl-whatsapp text-xl text-emerald-300'></i>
                    <span>Chat WhatsApp</span>
                </a>
                @endif
                <a href="{{ route('home') }}#contact" class="btn btn-outline py-3.5 px-6 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-2 hover:border-indigo-500">
                    <i class='bx bx-envelope text-lg text-indigo-400'></i>
                    <span x-text="$store.lang?.current === 'en' ? 'Contact Form' : 'Form Kontak'">Form Kontak</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
