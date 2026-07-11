<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\MessageController;
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
});
