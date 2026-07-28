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
use Illuminate\Support\Facades\Route;

// ── Public Routes (No Login Required) ─────────────────
Route::middleware(\App\Http\Middleware\TrackVisitor::class)->group(function () {
    Route::get('/', [PortfolioController::class, 'index'])->name('home');
    Route::get('/project/{slug}', [PortfolioController::class, 'project'])->name('project.show');
    Route::get('/project/{project}/download', [PortfolioController::class, 'downloadProject'])->name('project.download');
    Route::get('/project/{project}/download-apk', [PortfolioController::class, 'downloadApk'])->name('project.download-apk');
    Route::post('/donate', [PortfolioController::class, 'donate'])->name('donate');
    Route::post('/contact', [PortfolioController::class, 'contact'])->name('contact.send');
    
    // Ticket System Routes
    Route::get('/ticket/{ticket_id}', [\App\Http\Controllers\TicketController::class, 'show'])->name('ticket.show');
    Route::post('/ticket/{ticket_id}/reply', [\App\Http\Controllers\TicketController::class, 'reply'])->name('ticket.reply');
    
    // Notes Route
    Route::post('/notes', [PortfolioController::class, 'storeNote'])->name('notes.store');
});

// ── Auth Routes ───────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Admin Routes (Login Required) ─────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/social-links', [ProfileController::class, 'updateSocialLinks'])->name('profile.social-links');
    
    // Quick Settings
    Route::get('/settings', [ProfileController::class, 'editSettings'])->name('settings.index');
    Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');

    // Projects
    Route::patch('projects/{project}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
    Route::resource('projects', ProjectController::class);

    // Certificates
    Route::patch('certificates/{certificate}/toggle-status', [\App\Http\Controllers\Admin\CertificateController::class, 'toggleStatus'])->name('certificates.toggle-status');
    Route::resource('certificates', \App\Http\Controllers\Admin\CertificateController::class);

    // Skills
    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

    // Donations
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::put('/donations/trakteer', [DonationController::class, 'updateTrakteer'])->name('donations.update-trakteer');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Backup & Restore
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');
    Route::post('/backup', [BackupController::class, 'store'])->name('backup.store');
    Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
    Route::delete('/backup/delete', [BackupController::class, 'delete'])->name('backup.delete');

    // Notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
});

// ============================================================
// AUTO DEPLOY WEBHOOK (Tombol Ajaib Portofolio)
// CREATED BY: MSS (MASTER CREATOR)
// ============================================================
Route::get('/update-rahasia-mss', function () {
    $gitPath = 'git';
    if (file_exists('D:\laragon\bin\git\cmd\git.exe')) {
        $gitPath = 'D:\laragon\bin\git\cmd\git.exe';
    } elseif (file_exists('C:\laragon\bin\git\cmd\git.exe')) {
        $gitPath = 'C:\laragon\bin\git\cmd\git.exe';
    }
    
    putenv('GIT_TERMINAL_PROMPT=0');
    putenv('GCM_INTERACTIVE=false');
    
    // Perbaikan: Repo directory adalah folder utama laravel, BUKAN parent foldernya
    $repoDir = base_path();
    
    // Perbaikan: Bypass Git dubious ownership error
    $output0 = shell_exec("cd \"$repoDir\" && \"$gitPath\" config --global --add safe.directory \"*\" 2>&1");
    $output1 = shell_exec("cd \"$repoDir\" && \"$gitPath\" fetch --all 2>&1");
    $output2 = shell_exec("cd \"$repoDir\" && \"$gitPath\" reset --hard origin/main 2>&1");
    
    // Tambahan perintah agar mesin kompresor dan database ikut diperbarui
    $output3 = shell_exec("cd \"$repoDir\" && composer install --no-interaction 2>&1");
    $output4 = shell_exec("cd \"$repoDir\" && php artisan migrate --force 2>&1");
    
    return "<h1 style='color:green;'>Berhasil Menarik Kodingan Baru & Update Sistem oleh MSS!</h1>
            <h3>Laporan Log:</h3>
            <pre style='background:#333;color:#0f0;padding:20px;border-radius:10px;'>
<b>[GIT CONFIG]</b>
$output0
<b>[GIT FETCH & PULL]</b>
$output1
$output2
<b>[COMPOSER INSTALL]</b>
$output3
<b>[DATABASE MIGRATE]</b>
$output4
            </pre>";
});

// ============================================================
// TOMBOL RAHASIA PEMBUAT AKUN ADMIN
// ============================================================
Route::get('/buat-akun-admin-mss', function () {
    \App\Models\User::updateOrCreate(
        ['email' => 'projek.msyafiq19@gmail.com'],
        [
            'name' => 'Admin Portofolio',
            'password' => bcrypt('rahasia123'),
            'role' => 'admin'
        ]
    );
    return "<h1 style='color:blue;'>Akun Admin Berhasil Dibuat!</h1>
            <h3>Email: projek.msyafiq19@gmail.com</h3>
            <h3>Password: rahasia123</h3>
            <a href='/login'>Klik di sini untuk Login</a>";
});
