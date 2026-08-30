<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\CertificateController;
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
    Route::get('/estimator', [PortfolioController::class, 'estimator'])->name('estimator');
    Route::get('/faq', [PortfolioController::class, 'faq'])->name('faq');
    Route::get('/certificates', [PortfolioController::class, 'certificates'])->name('certificates');
    Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects.all');
    Route::get('/project/{slug}', [PortfolioController::class, 'project'])->name('project.show');
    
    // Unduhan File Projek
    Route::get('/project/{project}/download', [PortfolioController::class, 'downloadProject'])->name('project.download');
    Route::get('/project/{project}/download-apk', [PortfolioController::class, 'downloadApk'])->name('project.download-apk');
    
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

    // Profil & Media Sosial
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
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

    // Integrasi Donasi Trakteer
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::put('/donations/trakteer', [DonationController::class, 'updateTrakteer'])->name('donations.update-trakteer');

    // Pesan Masuk & Tiket
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
    $repoDir = base_path();

    // Auto-patch .env untuk server production jika perlu
    $envFile = base_path('.env');
    if (file_exists($envFile)) {
        $env = file_get_contents($envFile);
        $env = preg_replace('/^APP_URL=.*/m', 'APP_URL=https://mhdsyafiqsyahmi.my.id', $env);
        if (!str_contains($env, 'APP_TIMEZONE=')) {
            $env .= "\nAPP_TIMEZONE=Asia/Jakarta\n";
        } else {
            $env = preg_replace('/^APP_TIMEZONE=.*/m', 'APP_TIMEZONE=Asia/Jakarta', $env);
        }
        file_put_contents($envFile, $env);
    }

    // Mendukung eksekusi di Windows (Laragon) maupun Linux Server
    $gitPath = 'git';
    if (file_exists('D:\laragon\bin\git\cmd\git.exe')) {
        $gitPath = 'D:\laragon\bin\git\cmd\git.exe';
    } elseif (file_exists('C:\laragon\bin\git\cmd\git.exe')) {
        $gitPath = 'C:\laragon\bin\git\cmd\git.exe';
    }

    putenv('GIT_TERMINAL_PROMPT=0');
    putenv('GCM_INTERACTIVE=false');

    // 1. Bypass Dubious Ownership
    $output0 = shell_exec("cd \"$repoDir\" && \"$gitPath\" config --global --add safe.directory \"*\" 2>&1");
    
    // 2. Tarik update terbaru dari GitHub
    $output1 = shell_exec("cd \"$repoDir\" && \"$gitPath\" fetch --all 2>&1");
    $output2 = shell_exec("cd \"$repoDir\" && \"$gitPath\" reset --hard origin/main 2>&1");
    
    // 3. Update dependensi Composer & Database
    $output3 = shell_exec("cd \"$repoDir\" && composer install --no-interaction --prefer-dist --optimize-autoloader 2>&1");
    $output4 = shell_exec("cd \"$repoDir\" && php artisan migrate --force 2>&1");
    
    // 4. Bersihkan Cache & Link Storage
    $output_clear = shell_exec("cd \"$repoDir\" && php artisan optimize:clear 2>&1");
    $output_link = shell_exec("cd \"$repoDir\" && php artisan storage:link --force 2>&1");
    
    // 5. Build Asset Frontend (Vite)
    $output5 = shell_exec("cd \"$repoDir\" && npm install 2>&1");
    $output6 = shell_exec("cd \"$repoDir\" && npm run build 2>&1");
    
    return "<div style='font-family: monospace; background: #0f172a; color: #38bdf8; padding: 2rem; border-radius: 1rem; max-width: 900px; margin: 2rem auto; box-shadow: 0 10px 25px rgba(0,0,0,0.5);'>
                <h1 style='color: #4ade80; margin-bottom: 0.5rem;'>🚀 Auto-Deploy Portofolio Berhasil!</h1>
                <p style='color: #94a3b8; font-size: 0.9rem; margin-bottom: 1.5rem;'>Sistem portofolio telah disinkronkan dengan repositori GitHub terbaru.</p>
                <pre style='background: #020617; color: #a3e635; padding: 1.5rem; border-radius: 0.75rem; overflow-x: auto; border: 1px solid #1e293b; font-size: 0.85rem; line-height: 1.5;'>
[GIT CONFIG]
" . htmlspecialchars((string) $output0) . "

[GIT FETCH & PULL]
" . htmlspecialchars((string) $output1) . "
" . htmlspecialchars((string) $output2) . "

[COMPOSER INSTALL]
" . htmlspecialchars((string) $output3) . "

[DATABASE MIGRATE]
" . htmlspecialchars((string) $output4) . "

[OPTIMIZE CLEAR & STORAGE LINK]
" . htmlspecialchars((string) $output_clear) . "
" . htmlspecialchars((string) $output_link) . "

[NPM BUILD]
" . htmlspecialchars((string) $output5) . "
" . htmlspecialchars((string) $output6) . "
                </pre>
                <div style='margin-top: 1.5rem;'>
                    <a href='/' style='background: #6366f1; color: white; text-decoration: none; padding: 0.6rem 1.2rem; border-radius: 0.5rem; font-weight: bold; font-size: 0.85rem;'>Lihat Website</a>
                </div>
            </div>";
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
