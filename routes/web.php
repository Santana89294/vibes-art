<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\AdminController;

// ══════════════════════════════════════════════════════════════════
//  RUTAS PÚBLICAS
// ══════════════════════════════════════════════════════════════════

Route::get('/', function () {
    return redirect()->route('login');
});

// Registro (HU001)
Route::get('/registro',  [RegisterController::class, 'showForm'])->name('register');
Route::post('/registro', [RegisterController::class, 'register'])->name('register.post');

// Login (HU002)
Route::get('/login',  [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

// Recuperar contraseña (HU003)
Route::get('/forgot-password',  [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetCode'])->name('password.email');
Route::get('/verify-code',      [PasswordResetController::class, 'showVerifyForm'])->name('password.verify');
Route::post('/verify-code',     [PasswordResetController::class, 'verifyCode'])->name('password.verify.post');
Route::get('/reset-password',   [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',  [PasswordResetController::class, 'resetPassword'])->name('password.update');

// Verificación de correo
Route::get('/verify-email',         [\App\Http\Controllers\Auth\VerifyEmailController::class, 'showForm'])->name('verify.email');
Route::post('/verify-email',        [\App\Http\Controllers\Auth\VerifyEmailController::class, 'verify'])->name('verify.email.post');
Route::post('/verify-email/resend', [\App\Http\Controllers\Auth\VerifyEmailController::class, 'resend'])->name('verify.email.resend');

// ══════════════════════════════════════════════════════════════════
//  RUTAS PROTEGIDAS (usuario autenticado)
// ══════════════════════════════════════════════════════════════════

Route::middleware('auth.vibes')->group(function () {
    Route::get('/home', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('home');
    })->name('home');

    // Sprint 2: Diario emocional
    Route::get('/diario',              [\App\Http\Controllers\EmotionController::class, 'showDiary'])->name('emotions.diary');
    Route::post('/diario',             [\App\Http\Controllers\EmotionController::class, 'store'])->name('emotions.store');
    Route::get('/resultado/{emotion}', [\App\Http\Controllers\EmotionController::class, 'result'])->name('emotions.result');

    // Sprint 4: Galería
    Route::get('/galeria',             [\App\Http\Controllers\GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/galeria/{emotion}',   [\App\Http\Controllers\GalleryController::class, 'show'])->name('gallery.show');
    Route::delete('/cuenta', [\App\Http\Controllers\Auth\ProfileController::class, 'deleteAccount'])->name('account.delete');
    Route::post('/galeria/save-art/{emotion}', [\App\Http\Controllers\GalleryController::class, 'saveArt'])->name('gallery.save-art');
});

// ══════════════════════════════════════════════════════════════════
//  RUTAS ADMIN
// ══════════════════════════════════════════════════════════════════

Route::prefix('admin')->name('admin.')->middleware('admin.vibes')->group(function () {

    // Dashboard (HU016)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Usuarios (HU004, HU015)
    Route::get('/usuarios',               [AdminController::class, 'index'])->name('users.index');
    Route::get('/usuarios/{user}',        [AdminController::class, 'show'])->name('users.show');
    Route::get('/usuarios/{user}/editar', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{user}',        [AdminController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{user}',     [AdminController::class, 'destroy'])->name('users.destroy');
    Route::post('/usuarios/{user}/toggle-block', [AdminController::class, 'toggleBlock'])->name('users.toggle-block');

    // HU017 - Supervisión
    Route::get('/supervision', [\App\Http\Controllers\Admin\AISupervisionController::class, 'index'])->name('supervision');

    // HU018 - Catálogo musical
    Route::get('/musica',                [\App\Http\Controllers\Admin\MusicCatalogController::class, 'index'])->name('music.index');
    Route::get('/musica/crear',          [\App\Http\Controllers\Admin\MusicCatalogController::class, 'create'])->name('music.create');
    Route::post('/musica',               [\App\Http\Controllers\Admin\MusicCatalogController::class, 'store'])->name('music.store');
    Route::get('/musica/{song}/editar',  [\App\Http\Controllers\Admin\MusicCatalogController::class, 'edit'])->name('music.edit');
    Route::put('/musica/{song}',         [\App\Http\Controllers\Admin\MusicCatalogController::class, 'update'])->name('music.update');
    Route::post('/musica/{song}/toggle', [\App\Http\Controllers\Admin\MusicCatalogController::class, 'toggleActive'])->name('music.toggle');
    Route::delete('/musica/{song}',      [\App\Http\Controllers\Admin\MusicCatalogController::class, 'destroy'])->name('music.destroy');

    // HU019 - Reportes
    Route::get('/reportes', [\App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports.index');

    // HU020 - Notificaciones
    Route::get('/notificaciones',                         [\App\Http\Controllers\Admin\ReportsController::class, 'notifications'])->name('notifications');
    Route::post('/notificaciones',                        [\App\Http\Controllers\Admin\ReportsController::class, 'storeNotification'])->name('notifications.store');
    Route::post('/notificaciones/{notification}/toggle',  [\App\Http\Controllers\Admin\ReportsController::class, 'toggleNotification'])->name('notifications.toggle');
    Route::delete('/notificaciones/{notification}',       [\App\Http\Controllers\Admin\ReportsController::class, 'destroyNotification'])->name('notifications.destroy');
});
