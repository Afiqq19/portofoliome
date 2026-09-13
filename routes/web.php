<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;

use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\TicketController;
use App\Http\Middleware\TrackVisitor;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════════════
// 1. PUBLIC ROUTES (No Login Required)
// ═══════════════════════════════════════════════════════
Route::middleware(TrackVisitor::class)->group(function () {
    // Halaman Utama & Khusus
    Route::get('/', [PortfolioController::class, 'index'])->name('home');
    Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
    Route::get('/estimator', [PortfolioController::class, 'estimator'])->name('estimator');
    Route::get('/faq', [PortfolioController::class, 'faq'])->name('faq');
    Route::get('/certificates', [PortfolioController::class, 'certificates'])->name('certificates');
    Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.all');
    Route::get('/project/{slug}', [PortfolioController::class, 'project'])->name('project.show');
    
    // Unduhan File Projek & Dokumen
    Route::get('/project/{project}/download', [PortfolioController::class, 'downloadProject'])->name('project.download');
    Route::get('/project/{project}/download-apk', [PortfolioController::class, 'downloadApk'])->name('project.download-apk');
    Route::get('/cv', [PortfolioController::class, 'downloadCv'])->name('cv.download');
    Route::get('/cv/stream', [PortfolioController::class, 'streamCv'])->name('cv.stream');
    Route::get('/resume', [PortfolioController::class, 'downloadCv'])->name('resume.download');
    
    // Interaksi & Formulir Publik
    Route::post('/donate', [PortfolioController::class, 'donate'])->name('donate');
    Route::post('/contact', [PortfolioController::class, 'contact'])->name('contact.send');
    Route::post('/notes', [PortfolioController::class, 'storeNote'])->name('notes.store');
    
    // Tiket Percakapan
    Route::get('/ticket/{ticket_id}', [TicketController::class, 'show'])->name('ticket.show');
    Route::post('/ticket/{ticket_id}/reply', [TicketController::class, 'reply'])->name('ticket.reply');
});

// ═══════════════════════════════════════════════════════
// 2. AUTHENTICATION ROUTES
// ═══════════════════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ═══════════════════════════════════════════════════════
// 3. ADMIN MANAGEMENT ROUTES (Login & Admin Required)
// ═══════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export-visitors', [DashboardController::class, 'exportVisitors'])->name('dashboard.export-visitors');

    // Profil & Media Sosial
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/resume', [ProfileController::class, 'deleteResume'])->name('profile.delete-resume');
    Route::put('/profile/social-links', [ProfileController::class, 'updateSocialLinks'])->name('profile.social-links');
    
    // Pengaturan Tampilan
    Route::get('/settings', [ProfileController::class, 'editSettings'])->name('settings.index');
    Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');

    // Manajemen Projek
    Route::patch('projects/{project}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
    Route::resource('projects', ProjectController::class);

    // Manajemen Sertifikat
    Route::patch('certificates/{certificate}/toggle-status', [CertificateController::class, 'toggleStatus'])->name('certificates.toggle-status');
    Route::resource('certificates', CertificateController::class);

    // Manajemen Keahlian (Skills)
    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

    // Manajemen Pengalaman (Experiences)
    Route::patch('experiences/{experience}/toggle-status', [ExperienceController::class, 'toggleStatus'])->name('experiences.toggle-status');
    Route::resource('experiences', ExperienceController::class);



    // Pesan Masuk & Tiket
    Route::get('/messages/export', [MessageController::class, 'export'])->name('messages.export');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Backup & Restore Database
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');
    Route::post('/backup', [BackupController::class, 'store'])->name('backup.store');
    Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
    Route::delete('/backup/delete', [BackupController::class, 'delete'])->name('backup.delete');

    // Moderasi Catatan Guestbook
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
});

// ═══════════════════════════════════════════════════════
// 4. AUTO DEPLOY WEBHOOK (Production Server & Local Sync)
// ═══════════════════════════════════════════════════════
Route::get('/update-rahasia-portofolio', function () {
    // 1. Mencegah Timeout & Tingkatkan Batas Memori
    @set_time_limit(600);
    @ini_set('memory_limit', '512M');

    $repoDir = base_path();

    // 2. Auto-patch .env untuk server production (WIB & Domain)
    $envFile = base_path('.env');
    if (file_exists($envFile) && is_writable($envFile)) {
        $env = file_get_contents($envFile);
        $env = preg_replace('/^APP_URL=.*/m', 'APP_URL=https://mhdsyafiqsyahmi.my.id', $env);
        if (!str_contains($env, 'APP_TIMEZONE=')) {
            $env .= "\nAPP_TIMEZONE=Asia/Jakarta\n";
        } else {
            $env = preg_replace('/^APP_TIMEZONE=.*/m', 'APP_TIMEZONE=Asia/Jakarta', $env);
        }
        @file_put_contents($envFile, $env);
    }

    // 3. Konfigurasi Environment & Path
    $gitPath = 'git';
    putenv('GIT_TERMINAL_PROMPT=0');
    putenv('GCM_INTERACTIVE=false');
    putenv('HOME=/tmp');
    putenv('COMPOSER_HOME=/tmp');
    putenv('PATH=' . getenv('PATH') . ':/usr/local/bin:/usr/bin:/bin:/usr/local/games:/usr/games');

    // Coba perbaiki hak akses internal jika memungkinkan
    @chmod($repoDir . '/storage', 0777);
    @chmod($repoDir . '/bootstrap/cache', 0777);
    @chmod($repoDir . '/.git', 0777);

    // 4. Eksekusi Perintah Sinkronisasi Lengkap
    // A. Git Safe Directory & Pull
    $output_git_cfg = shell_exec("cd \"$repoDir\" && \"$gitPath\" config --global --add safe.directory \"*\" 2>&1");
    $output_git_fetch = shell_exec("cd \"$repoDir\" && \"$gitPath\" fetch --all 2>&1");
    $output_git_reset = shell_exec("cd \"$repoDir\" && \"$gitPath\" reset --hard origin/main 2>&1");
    $output_git_commit = shell_exec("cd \"$repoDir\" && \"$gitPath\" log -1 --pretty=format:\"%h - %s (%ci)\" 2>&1");

    // Deteksi jika terjadi Permission Denied pada Git
    $hasPermError = str_contains((string)$output_git_fetch, 'Permission denied') || str_contains((string)$output_git_reset, 'Permission denied');

    // B. Composer Install (Dependencies PHP)
    $output_composer = shell_exec("cd \"$repoDir\" && composer install --no-interaction --prefer-dist --optimize-autoloader 2>&1");

    // C. Database Migration
    $output_migrate = shell_exec("cd \"$repoDir\" && php artisan migrate --force 2>&1");

    // D. NPM / Vite Build (Frontend Assets)
    $npmCheck = trim((string) shell_exec("which npm 2>&1"));
    if ($npmCheck && !str_contains($npmCheck, 'not found') && file_exists($npmCheck)) {
        $output_npm = shell_exec("cd \"$repoDir\" && npm install --no-audit --no-fund 2>&1 && npm run build 2>&1");
    } else {
        $output_npm = "ℹ️ Node.js / NPM belum terpasang di container Docker.\nAset CSS & JS Vite telah otomatis terkompilasi dan disertakan via GitHub di folder 'public/build/'.";
    }

    // E. Optimize Clear & Cache Refresh
    $output_clear = shell_exec("cd \"$repoDir\" && php artisan optimize:clear 2>&1");

    // F. Storage Link
    if (!file_exists($repoDir . '/public/storage')) {
        $output_link = shell_exec("cd \"$repoDir\" && php artisan storage:link 2>&1");
    } else {
        $output_link = "Symlink [public/storage] sudah aktif dan terhubung.";
    }

    $timeWIB = date('d M Y, H:i:s') . ' WIB';

    // 5. Tampilan Visual Dashboard Auto-Deploy
    return "<!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Sistem Auto-Deploy Portofolio</title>
        <link href='https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700;900&family=JetBrains+Mono:wght@400;600&family=Outfit:wght@400;600;700&display=swap' rel='stylesheet'>
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { background-color: #060609; color: #f8fafc; font-family: 'Outfit', sans-serif; padding: 2rem 1rem; line-height: 1.6; }
            .container { max-width: 960px; margin: 0 auto; }
            .card { background: #0c0c14; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.5rem; padding: 2rem; margin-bottom: 1.5rem; box-shadow: 0 20px 50px rgba(0,0,0,0.6); }
            .header { display: flex; align-items: center; justify-content: space-between; flex-wrap: gap-4; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
            h1 { font-family: 'Space Grotesk', sans-serif; font-size: 1.75rem; color: #4ade80; display: flex; align-items: center; gap: 0.5rem; }
            .badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.85rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; font-family: 'JetBrains Mono', monospace; }
            .badge-success { background: rgba(74, 222, 128, 0.15); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); }
            .badge-warning { background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); }
            .alert-box { background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.4); border-radius: 1rem; padding: 1.25rem; margin-bottom: 1.5rem; color: #fde68a; }
            .code-box { background: #020617; border: 1px solid #1e293b; border-radius: 0.75rem; padding: 1rem; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #a3e635; overflow-x: auto; white-space: pre-wrap; margin-top: 0.5rem; }
            .step-title { font-family: 'Space Grotesk', sans-serif; font-size: 1rem; font-weight: 700; color: #94a3b8; margin-top: 1.25rem; margin-bottom: 0.35rem; display: flex; align-items: center; justify-content: space-between; }
            .btn-group { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 2rem; }
            .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 0.75rem; text-decoration: none; font-weight: 700; font-size: 0.9rem; transition: all 0.2s; font-family: 'Space Grotesk', sans-serif; }
            .btn-primary { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; }
            .btn-secondary { background: rgba(255,255,255,0.06); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); }
            .btn:hover { opacity: 0.9; transform: translateY(-1px); }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='card'>
                <div class='header'>
                    <div>
                        <h1>🚀 Auto-Deploy Portofolio</h1>
                        <p style='color: #94a3b8; font-size: 0.85rem; margin-top: 0.25rem;'>Waktu Eksekusi: <b style='color: #e2e8f0;'>{$timeWIB}</b></p>
                    </div>
                    <div>
                        " . ($hasPermError 
                            ? "<span class='badge badge-warning'>⚠️ PERLU IZIN FOLDER</span>" 
                            : "<span class='badge badge-success'>✓ PROSES SELESAI</span>") . "
                    </div>
                </div>

                " . ($hasPermError ? "
                <div class='alert-box'>
                    <strong>⚠️ Perhatian: Terdeteksi 'Permission denied' pada Git!</strong><br>
                    Agar proses `git pull` dapat memperbarui kode otomatis via browser tanpa kendala hak akses, jalankan satu kali perintah ini di Terminal SSH server Linux Anda:
                    <div class='code-box' style='color: #facc15;'>sudo chown -R www-data:www-data /var/www/portofoliome</div>
                    Setelah itu, muat ulang (refresh) halaman ini kembali.
                </div>
                " : "") . "

                <div class='step-title'>
                    <span>1. GIT STATUS & UPDATE TERBARU</span>
                    <span style='font-size: 0.75rem; font-family: monospace; color: #38bdf8;'>origin/main</span>
                </div>
                <div class='code-box'>[GIT CONFIG]\n" . htmlspecialchars((string)$output_git_cfg) . "
[GIT FETCH]\n" . htmlspecialchars((string)$output_git_fetch) . "
[GIT RESET]\n" . htmlspecialchars((string)$output_git_reset) . "
[LATEST COMMIT]\n" . htmlspecialchars((string)$output_git_commit) . "</div>

                <div class='step-title'>2. COMPOSER DEPENDENCIES (PHP)</div>
                <div class='code-box'>" . htmlspecialchars((string)$output_composer) . "</div>

                <div class='step-title'>3. DATABASE MIGRATION</div>
                <div class='code-box'>" . htmlspecialchars((string)$output_migrate) . "</div>

                <div class='step-title'>4. FRONTEND BUILD (VITE / NPM RUN BUILD)</div>
                <div class='code-box'>" . htmlspecialchars((string)$output_npm) . "</div>

                <div class='step-title'>5. OPTIMASI & CACHE CLEAR (LARAVEL)</div>
                <div class='code-box'>" . htmlspecialchars((string)$output_clear) . "</div>

                <div class='step-title'>6. STORAGE LINK</div>
                <div class='code-box'>" . htmlspecialchars((string)$output_link) . "</div>

                <div class='btn-group'>
                    <a href='/' class='btn btn-primary'>🌐 Lihat Halaman Depan</a>
                    <a href='/projects' class='btn btn-secondary'>📁 Katalog Projek</a>
                    <a href='/admin' class='btn btn-secondary'>⚙️ Panel Admin</a>
                </div>
            </div>
        </div>
    </body>
    </html>";
});

// Alias route untuk kemudahan akses
Route::get('/update-rahasia-mss', function () {
    return redirect('/update-rahasia-portofolio');
});

// ═══════════════════════════════════════════════════════
// 5. TOMBOL RAHASIA PEMBUAT AKUN ADMIN
// ═══════════════════════════════════════════════════════
Route::get('/buat-akun-admin-mss', function () {
    User::updateOrCreate(
        ['email' => 'projek.msyafiq19@gmail.com'],
        [
            'name' => 'Admin Portofolio',
            'password' => bcrypt('rahasia123'),
            'role' => 'admin'
        ]
    );
    return "<div style='font-family: sans-serif; text-align: center; padding: 3rem;'>
                <h1 style='color: #4f46e5;'>Akun Admin Berhasil Dibuat!</h1>
                <p>Email: <b>projek.msyafiq19@gmail.com</b></p>
                <p>Password: <b>rahasia123</b></p>
                <a href='/login' style='background: #4f46e5; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: bold;'>Buka Halaman Login</a>
            </div>";
});
