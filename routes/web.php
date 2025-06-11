<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\DocumentInController;
use App\Http\Controllers\DocumentOutController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\FinalisasiController; // ✅ Tambahan: Controller untuk finalisasi

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect()->route('login'));

# ============================
# Guest (Belum login)
# ============================
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store']);
});

# ============================
# Authenticated User
# ============================
Route::middleware('auth')->group(function () {

    # Logout
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    # Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    # ========================
    # Super Admin Routes
    # ========================
    Route::middleware('is_super_admin')->group(function () {
        Route::prefix('manajemen-akun')->name('users-management.')->group(function () {
            Route::get('/', [ManageUserController::class, 'index'])->name('index');
            Route::get('/tambah', [ManageUserController::class, 'create'])->name('create');
            Route::post('/', [ManageUserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ManageUserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ManageUserController::class, 'update'])->name('update');
            Route::delete('/{id}', [ManageUserController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/disable', [ManageUserController::class, 'disable'])->name('disable');
        });
    });

    # ========================
    # Profile
    # ========================
    Route::get('/profil-akun', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil-akun', [ProfileController::class, 'update'])->name('profile.update');

    # ========================
    # Notifications
    # ========================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::get('/count', [NotificationController::class, 'getCount'])->name('count');
    });

    # ========================
    # Halaman Beranda
    # ========================
    Route::prefix('beranda')->name('beranda.')->group(function () {
        Route::get('/visi', fn () => view('beranda.visi'))->name('visi');
        Route::get('/misi', fn () => view('beranda.misi'))->name('misi');
        Route::get('/tujuan', fn () => view('beranda.tujuan'))->name('tujuan');
        Route::get('/sasaran', fn () => view('beranda.sasaran'))->name('sasaran');
    });

    # ========================
    # Halaman Denah
    # ========================
    Route::get('/denah', fn () => view('denah'))->name('denah');

    # ========================
    # Kriteria
    # ========================
    Route::get('/kriteria/create', [KriteriaController::class, 'create'])->name('kriteria.create');
    Route::get('/kriteria/{nomor}', [KriteriaController::class, 'show'])->name('kriteria.show');
    Route::get('/kriteria/upload/{id}', [KriteriaController::class, 'upload'])->name('dokumen.upload');
    Route::post('/kriteria/store-with-dokumen', [KriteriaController::class, 'storeWithDokumen'])->name('kriteria.storeWithDokumen');
    Route::post('/kriteria/store', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::resource('kriteria', KriteriaController::class)->except(['create', 'show', 'edit', 'update', 'store']);

    # ========================
    # Komentar
    # ========================
    Route::post('/komentar', [KomentarController::class, 'store'])->name('komentar.store');

    # ========================
    # Dokumen
    # ========================
    Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('/upload', [DokumenController::class, 'store'])->name('dokumen.store'); // atau ganti ke /dokumen jika perlu
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/dokumen/{id}/lihat', [DokumenController::class, 'showDokumen'])->name('dokumen.lihat');
    Route::get('/dokumen/{id}/validasi', [DokumenController::class, 'validasi'])->name('dokumen.validasi');
    Route::post('/dokumen/{id}/kembalikan', [DokumenController::class, 'kembalikan'])->name('dokumen.kembalikan');
    Route::post('/dokumen/{id}/setujui', [DokumenController::class, 'setujui'])->name('dokumen.setujui');
    Route::get('/dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('/dokumen/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');

    # ========================
    # Template Dokumen
    # ========================
    Route::get('/template/{tahap}/{nomor}', [KriteriaController::class, 'template'])->name('template.detail');
    Route::get('/template', [KriteriaController::class, 'template'])->name('dokumen.template');

    Route::post('/dokumen/store-from-template', [KriteriaController::class, 'storeFromTemplate'])->name('kriteria.storeFromTemplate');
    Route::post('/dokumen/store-template', [DokumenController::class, 'storeFromTemplate'])->name('dokumen.storeFromTemplate');

    # ========================
    # Finalisasi
    # ========================
    Route::prefix('finalisasi')->name('finalisasi.')->group(function () {
        Route::get('/', [FinalisasiController::class, 'index'])->name('index');
        Route::get('/{nomor}', [FinalisasiController::class, 'show'])->name('show');
        Route::post('/{nomor}/kirim', [FinalisasiController::class, 'kirim'])->name('kirim');
        Route::post('/{nomor}/validasi', [FinalisasiController::class, 'validasi'])->name('validasi');
        Route::post('/{id}/setujui', [FinalisasiController::class, 'setujui'])->name('setujui');
        Route::post('/{id}/kembalikan', [FinalisasiController::class, 'kembalikan'])->name('kembalikan');
    });
});

Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
Route::get('/kriteria/{nomor}/dokumen/{id}', [KriteriaController::class, 'lihat'])->name('kriteria.lihat');
