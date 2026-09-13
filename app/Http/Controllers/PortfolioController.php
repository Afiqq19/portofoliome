<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Visitor;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Landing page - Public portfolio
     */
    public function index()
    {
        $profile = Profile::with('socialLinks')->first();
        $skills = Skill::orderBy('order')->get();
        
        $featuredProjects = Project::published()->where('is_featured', true)->orderBy('order')->take(6)->get();
        // Fallback jika tidak ada featured project
        if ($featuredProjects->isEmpty()) {
            $featuredProjects = Project::published()->orderBy('order')->take(6)->get();
        }
        
        $certificates = Certificate::published()->orderBy('order')->take(3)->get();
        $totalCertificates = Certificate::published()->count();

        $stats = [
            'projects' => Project::published()->count(),
            'downloads' => Project::sum('download_count'),
            'visitors' => Visitor::distinct('ip_address')->count(),
        ];

        $notes = Note::latest()->get();
        
        $experiences = \App\Models\Experience::published()->orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('portfolio.home', compact('profile', 'skills', 'featuredProjects', 'certificates', 'totalCertificates', 'stats', 'notes', 'experiences'));
    }

    /**
     * Dedicated Project Estimator Page
     */
    public function estimator()
    {
        $profile = Profile::with('socialLinks')->first();
        if (!($profile->enable_estimator ?? true)) {
            return redirect()->route('home')->with('info', 'Layanan Kalkulator Estimasi sedang dinonaktifkan.');
        }
        return view('portfolio.estimator', compact('profile'));
    }

    /**
     * Dedicated Frequently Asked Questions (FAQ) Page
     */
    public function faq()
    {
        $profile = Profile::with('socialLinks')->first();
        return view('portfolio.faq', compact('profile'));
    }

    /**
     * Dedicated All Certificates Gallery Page
     */
    public function certificates()
    {
        $profile = Profile::with('socialLinks')->first();
        $certificates = Certificate::published()->orderBy('order')->get();
        return view('portfolio.certificates', compact('profile', 'certificates'));
    }

    /**
     * Dedicated All Projects Catalog Page
     */
    public function projects()
    {
        $profile = Profile::with('socialLinks')->first();
        $projects = Project::published()->orderBy('order')->get();
        return view('portfolio.projects', compact('profile', 'projects'));
    }

    /**
     * Project detail page - Public
     */
    public function project(string $slug)
    {
        $project = Project::published()->where('slug', $slug)->firstOrFail();
        $profile = Profile::with('socialLinks')->first();
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();

        return view('portfolio.project-detail', compact('project', 'profile', 'relatedProjects'));
    }

    public function downloadProject(Project $project)
    {
        if (!$project->zip_path || !Storage::disk('public')->exists($project->zip_path)) {
            return back()->with('error', 'File ZIP tidak tersedia.');
        }

        $project->increment('download_count');

        return Storage::disk('public')->download(
            $project->zip_path,
            $project->slug . '.zip'
        );
    }

    /**
     * Download project APK
     */
    public function downloadApk(Project $project)
    {
        if (!$project->apk_path || !Storage::disk('public')->exists($project->apk_path)) {
            return back()->with('error', 'File APK tidak tersedia.');
        }

        $project->increment('download_count');

        return Storage::disk('public')->download(
            $project->apk_path,
            $project->slug . '.apk'
        );
    }

    /**
     * Download profile CV / Resume
     */
    public function downloadCv(Request $request)
    {
        if ($request->boolean('preview') || $request->query('view') === 'inline') {
            return $this->streamCv();
        }

        $profile = Profile::first();

        if (!$profile || !$profile->resume_path || !Storage::disk('public')->exists($profile->resume_path)) {
            return back()->with('error', 'File CV / Resume belum diunggah atau tidak ditemukan.');
        }

        $extension = pathinfo($profile->resume_path, PATHINFO_EXTENSION) ?: 'pdf';
        $safeName = Str::slug($profile->name ?? 'Portofolio');
        $filename = 'CV_' . $safeName . '.' . $extension;

        return Storage::disk('public')->download(
            $profile->resume_path,
            $filename
        );
    }

    /**
     * Stream profile CV / Resume inline for browser preview
     */
    public function streamCv()
    {
        $profile = Profile::first();

        if (!$profile || !$profile->resume_path || !Storage::disk('public')->exists($profile->resume_path)) {
            return response(
                '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen CV Belum Tersedia</title>
    <style>
        body {
            margin: 0;
            padding: 24px;
            background-color: #0c0c14;
            color: #cbd5e1;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            max-width: 440px;
            text-align: center;
            padding: 40px 24px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        .icon-box {
            width: 64px;
            height: 64px;
            margin: 0 auto 18px;
            background: rgba(244, 63, 94, 0.12);
            border: 1px solid rgba(244, 63, 94, 0.25);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }
        h2 {
            margin: 0 0 10px;
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
        }
        p {
            margin: 0 0 24px;
            color: #94a3b8;
            font-size: 13px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 10px 24px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-box">📄</div>
        <h2>Dokumen CV Belum Tersedia</h2>
        <p>File CV / Resume belum diunggah atau sedang dalam pembaruan oleh pemilik portofolio. Silakan unggah dokumen di Dashboard Admin > Edit Profil.</p>
        <a href="/" target="_top" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>',
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        $extension = pathinfo($profile->resume_path, PATHINFO_EXTENSION) ?: 'pdf';
        $safeName = Str::slug($profile->name ?? 'Portofolio');
        $filename = 'CV_' . $safeName . '.' . $extension;

        return Storage::disk('public')->response(
            $profile->resume_path,
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'public, max-age=3600',
            ]
        );
    }

    /**
     * Store donation
     */
    public function donate(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:1000',
            'message' => 'nullable|string|max:1000',
            'payment_method' => 'required|string|in:transfer,dana,gopay,ovo',
        ]);

        $validated['status'] = 'pending';

        Donation::create($validated);

        if ($request->project_id) {
            $project = Project::find($request->project_id);
            if ($project) {
                $project->increment('download_count');
            }
        }

        return back()->with('success', 'Terima kasih atas donasinya! 🎉');
    }

    /**
     * Store contact message
     */
    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim! Terima kasih. 📬');
    }

    /**
     * Store visitor note (Workspace)
     */
    public function storeNote(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        Note::create($validated);

        return back()->with('success_note', 'Catatan Anda berhasil dipublikasikan! 🎉');
    }

    /**
     * Syafiq AI Assistant - Intelligent NLP Response Engine
     */
    public function aiChat(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $msg = mb_strtolower(trim($validated['message']));
        $profile = Profile::first();

        // 1. Pendidikan / Kampus / Polmed
        if (preg_match('/pendidikan|sekolah|kuliah|kampus|polmed|politeknik|manajemen informatika|d3|jurusan|ipk|lulusan|almamater|fresh graduate/i', $msg)) {
            return response()->json([
                'status' => 'success',
                'reply' => "Mhd. Syafiq Syahmi adalah lulusan Program Studi D3 Manajemen Informatika dari Politeknik Negeri Medan (Polmed) periode 2023 - 2026.\n\nFokus kompetensi akademiknya meliputi Rekayasa Perangkat Lunak, Arsitektur Basis Data Relasional, Pemrograman Web & Mobile, serta Analisis Sistem Informasi. Syafiq juga aktif dalam organisasi kemahasiswaan BEM Polmed!",
                'suggestions' => ['💼 Pengalaman Magang', '🚀 Projek Unggulan', '📄 Lihat CV Syafiq'],
                'action' => [
                    'type' => 'link',
                    'label' => 'Lihat Bagian Pendidikan',
                    'url' => '#timeline',
                ]
            ]);
        }

        // 2. Pengalaman Kerja / Magang / Pelindo / Telkom Akses
        if (preg_match('/kerja|magang|pelindo|telkom|karir|pekerjaan|pengalaman|pkl|intern|internship|riwayat karir/i', $msg)) {
            return response()->json([
                'status' => 'success',
                'reply' => "Syafiq memiliki rekam jejak pengalaman industri yang terverifikasi:\n\n1. 🏢 **PT Pelindo Multi Terminal (Kuala Tanjung)** (Januari 2026 – Maret 2026)\n   • IT Support & Pemeliharaan Infrastruktur Jaringan di area operasional pelabuhan maritim.\n\n2. 🏢 **PT Telkom Akses (Siantar)** (Oktober 2024 – November 2024)\n   • Admin Administrasi Umum & pengawasan teknis lapangan jaringan fiber optic.\n\n3. 💻 **Freelance Fullstack & Mobile Developer** (2024 – Sekarang)\n   • Mengembangkan aplikasi web dinamis (Laravel, Vue.js), sistem kasir/POS, dan aplikasi Android APK.",
                'suggestions' => ['🚀 Projek Unggulan', '📄 Unduh Dokumen CV', '💬 Chat WhatsApp'],
                'action' => [
                    'type' => 'link',
                    'label' => 'Buka Timeline Pengalaman',
                    'url' => '#timeline',
                ]
            ]);
        }

        // 3. Organisasi / BEM / FKMPI
        if (preg_match('/organisasi|bem|fkmpi|kepemimpinan|organisasi mahasiswa|purna tugas/i', $msg)) {
            return response()->json([
                'status' => 'success',
                'reply' => "Syafiq aktif memegang posisi strategis kepemimpinan kemahasiswaan:\n\n🏛️ **BEM Politeknik Negeri Medan (2024–2025)**:\n• Pengurus Departemen, bertanggung jawab atas manajemen program kemahasiswaan, advokasi kesejahteraan mahasiswa, dan event kampus berskala besar.\n\n🏛️ **FKMPI Nasional (2024–2025)**:\n• Forum Komunikasi Mahasiswa Politeknik se-Indonesia tingkat nasional, aktif dalam konsolidasi jejaring kemitraan politeknik se-Indonesia.",
                'suggestions' => ['🎓 Riwayat Pendidikan', '💼 Pengalaman Magang', '📄 Unduh CV'],
                'action' => [
                    'type' => 'link',
                    'label' => 'Lihat Timeline Organisasi',
                    'url' => '#timeline',
                ]
            ]);
        }

        // 4. Keahlian / Tech Stack / Skills
        if (preg_match('/keahlian|skill|tech stack|teknologi|bahasa|pemrograman|coding|koding|framework|laravel|vue|php|flutter|android|mysql/i', $msg)) {
            return response()->json([
                'status' => 'success',
                'reply' => "Stack teknologi dan keahlian utama Syafiq meliputi:\n\n⚡ **Backend & Framework**: PHP, Laravel 11 (Clean Architecture, RESTful API, MVC, Security Hardening)\n🎨 **Frontend**: JavaScript (ES6+), Alpine.js, Tailwind CSS, HTML5/CSS3, Blade\n📱 **Mobile Development**: Flutter, Android APK Development\n🗄️ **Database & Cloud**: MySQL, Database Modeling, Nginx, Docker, Linux VPS\n🛠️ **Tools & Workflow**: Git, GitHub, REST API, Payment Gateway QRIS, WhatsApp Bot",
                'suggestions' => ['🚀 Projek Unggulan', '💰 Estimasi Biaya Projek', '💬 Hubungi Syafiq'],
                'action' => [
                    'type' => 'link',
                    'label' => 'Lihat Grafik Keahlian',
                    'url' => '#skills',
                ]
            ]);
        }

        // 5. Projek Portofolio / Karya
        if (preg_match('/projek|project|aplikasi|karya|portofolio|fitur|source code|download apk|sistem kasir|pos|arsip/i', $msg)) {
            return response()->json([
                'status' => 'success',
                'reply' => "Syafiq telah merancang dan membangun beragam aplikasi skala produksi siap pakai:\n\n• **Sistem Kasir POS & Inventori Modern**: Multi-cabang, barcode, dan laporan kasir otomatis.\n• **Platform Portofolio & Interactive CLI**: Sistem web berkecepatan tinggi dengan analitik mandiri dan dark-space UI.\n• **Aplikasi Mobile Android (APK)**: Aplikasi mobile interaktif berkinerja tinggi.\n\nAnda dapat mencoba live demo atau mengunduh source code ZIP & file APK langsung di menu Projek!",
                'suggestions' => ['📁 Buka Katalog Projek', '💰 Kalkulator Estimasi', '📄 Lihat CV'],
                'action' => [
                    'type' => 'link',
                    'label' => 'Jelajahi Semua Projek',
                    'url' => '/projects',
                ]
            ]);
        }

        // 6. Layanan / Jasa / Estimasi Biaya / Freelance
        if (preg_match('/biaya|harga|estimasi|jasa|layanan|freelance|buat web|bikin aplikasi|pesan website|tarif|order|hire|sewa/i', $msg)) {
            return response()->json([
                'status' => 'success',
                'reply' => "Syafiq membuka layanan konsultasi dan pembuatan aplikasi:\n\n✓ **Website Kustom**: Portofolio, Company Profile, Landing Page Interaktif\n✓ **Sistem Manajemen & Kasir (POS)**: Bisnis, inventori, laporan penjualan\n✓ **Aplikasi Mobile Android (APK)**: Kustom fitur sesuai kebutuhan Anda\n✓ **Integrasi Sistem**: Payment Gateway QRIS & Bot Notifikasi WhatsApp\n\nAnda dapat menghitung perkiraan budget & durasi kerja di menu **Kalkulator Estimasi**, atau diskusi langsung via WhatsApp!",
                'suggestions' => ['📊 Kalkulator Estimasi', '💬 Chat WhatsApp Syafiq', '📧 Kirim Pesan'],
                'action' => [
                    'type' => 'link',
                    'label' => 'Buka Kalkulator Estimasi',
                    'url' => '/estimator',
                ]
            ]);
        }

        // 7. CV / Resume / Dokumen
        if (preg_match('/cv|resume|riwayat hidup|curriculum vitae|biodata|dokumen|pdf/i', $msg)) {
            return response()->json([
                'status' => 'success',
                'reply' => "Dokumen Curriculum Vitae resmi Mhd. Syafiq Syahmi (2 Halaman Terverifikasi) siap diunduh atau dilihat secara interaktif di layar Anda tanpa perlu keluar dari halaman web!",
                'suggestions' => ['📄 Buka Pratinjau CV', '⬇ Unduh PDF CV', '💬 Hubungi WhatsApp'],
                'action' => [
                    'type' => 'cv_modal',
                    'label' => 'Buka Dokumen CV Interaktif',
                    'url' => '/cv/stream',
                ]
            ]);
        }

        // 8. Kontak / WhatsApp / Email / Nomor HP
        if (preg_match('/kontak|hubungi|whatsapp|wa|nomor|telepon|hp|email|lokasi|alamat|rekrut/i', $msg)) {
            $phone = $profile->phone ?? '+62 822-3790-5639';
            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
            return response()->json([
                'status' => 'success',
                'reply' => "Anda dapat langsung menghubungi Mhd. Syafiq Syahmi melalui saluran resmi berikut:\n\n📱 **WhatsApp**: {$phone}\n📧 **Email**: " . ($profile->email ?? 'mhdsyafiqsyahmi19@gmail.com') . "\n📍 **Lokasi**: " . ($profile->location ?? 'Kab. Batu Bara / Medan, Sumatera Utara') . "\n💼 **Status**: Tersedia untuk Full-time, Magang Industri, maupun Project Freelance!",
                'suggestions' => ['💬 Hubungi via WhatsApp', '📄 Unduh Dokumen CV', '📊 Kalkulator Estimasi'],
                'action' => [
                    'type' => 'whatsapp',
                    'label' => 'Buka WhatsApp Syafiq',
                    'url' => "https://wa.me/{$cleanPhone}?text=Halo%20Syafiq,%20saya%20melihat%20portofolio%20Anda%20dan%20tertarik%20untuk%20diskusi%20lebih%20lanjut.",
                ]
            ]);
        }

        // 9. Sapaan / Salam
        if (preg_match('/halo|hai|hi|pagi|siang|sore|malam|assalamualaikum|hey|hello|tes|test|ping/i', $msg)) {
            return response()->json([
                'status' => 'success',
                'reply' => "Halo! Selamat datang di portofolio Mhd. Syafiq Syahmi. Senang sekali bisa menyapa Anda! 👋\n\nSaya adalah **Syafiq AI**, asisten virtual cerdas yang siap menjawab pertanyaan Anda seputar keahlian koding, riwayat pendidikan Polmed, pengalaman magang di PT Pelindo & PT Telkom Akses, hingga estimasi projek. Ada yang bisa saya bantu?",
                'suggestions' => ['💼 Pengalaman Kerja', '🎓 Riwayat Pendidikan', '🚀 Projek Unggulan', '📄 Lihat CV Syafiq']
            ]);
        }

        // 10. Fallback Respons
        $phone = $profile->phone ?? '+62 822-3790-5639';
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        return response()->json([
            'status' => 'success',
            'reply' => "Pertanyaan yang menarik! Sebagai asisten virtual, fokus utama saya adalah memberikan informasi seputar portofolio, riwayat pendidikan, magang di industri, dan keahlian koding Mhd. Syafiq Syahmi.\n\nJika Anda ingin berdiskusi lebih spesifik atau membicarakan kerjasama projek, Anda bisa langsung ngobrol dengan Syafiq via WhatsApp ya!",
            'suggestions' => ['💬 Chat WhatsApp Syafiq', '📄 Buka Dokumen CV', '💼 Pengalaman Magang', '🚀 Projek Unggulan'],
            'action' => [
                'type' => 'whatsapp',
                'label' => 'Tanya Langsung ke Syafiq',
                'url' => "https://wa.me/{$cleanPhone}?text=Halo%20Syafiq,%20saya%20ingin%20bertanya%20langsung%20kepada%20Anda.",
            ]
        ]);
    }
}
