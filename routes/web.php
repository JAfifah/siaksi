<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\DocumentInController;
use App\Http\Controllers\DocumentOutController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\DokumenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

# Auth routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    # Dashboard Page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    # Super Admin only
    Route::middleware('is_super_admin')->group(function () {
        # Manage User Page
        Route::get('/manajemen-akun', [ManageUserController::class, 'index'])->name('users-management.index');
        Route::get('/manajemen-akun/tambah', [ManageUserController::class, 'create'])->name('users-management.create');
        Route::post('/manajemen-akun', [ManageUserController::class, 'store'])->name('users-management.store');
        Route::get('/manajemen-akun/{id}/edit', [ManageUserController::class, 'edit'])->name('users-management.edit');
        Route::put('/manajemen-akun/{id}', [ManageUserController::class, 'update'])->name('users-management.update');
        Route::delete('/manajemen-akun/{id}', [ManageUserController::class, 'destroy'])->name('users-management.destroy');
        Route::post('/manajemen-akun/{id}/disable', [ManageUserController::class, 'disable'])->name('users-management.disable');
    });

    # Manage Jenis Surat
    Route::get('/jenis-surat', [DocumentTypeController::class, 'index'])->name('doc-types-management.index');
    Route::post('/jenis-surat', [DocumentTypeController::class, 'store'])->name('doc-types-management.store');
    Route::put('/jenis-surat/{id}', [DocumentTypeController::class, 'update'])->name('doc-types-management.update');
    Route::delete('/jenis-surat/{id}', [DocumentTypeController::class, 'destroy'])->name('doc-types-management.destroy');

    # Profile Page
    Route::get('/profil-akun', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil-akun', [ProfileController::class, 'update'])->name('profile.update');

    # Halaman Beranda
    Route::get('/beranda/visi', fn() => view('beranda.visi'))->name('beranda.visi');
    Route::get('/beranda/misi', fn() => view('beranda.misi'))->name('beranda.misi');
    Route::get('/beranda/tujuan', fn() => view('beranda.tujuan'))->name('beranda.tujuan');
    Route::get('/beranda/sasaran', fn() => view('beranda.sasaran'))->name('beranda.sasaran');

    # Halaman Denah
    Route::get('/denah', fn() => view('denah'))->name('denah');

    # Kriteria
    Route::get('/kriteria/create', [KriteriaController::class, 'create'])->name('kriteria.create');
    Route::get('/kriteria/{nomor}', [KriteriaController::class, 'show'])->name('kriteria.show');
    Route::get('/kriteria/{nomor}/{id}/lihat', [KriteriaController::class, 'lihat'])->name('kriteria.lihat');
    Route::get('/kriteria/upload/{id}', [KriteriaController::class, 'upload'])->name('dokumen.upload');
    Route::post('/kriteria/store-with-dokumen', [KriteriaController::class, 'storeWithDokumen'])->name('kriteria.storeWithDokumen');
    Route::post('/kriteria/store', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::resource('kriteria', KriteriaController::class)->except(['create', 'show', 'edit', 'update', 'store']);

    # Komentar
    Route::post('/komentar', [KomentarController::class, 'store'])->name('komentar.store');

    # Dokumen (upload & view)
    // Hapus route /upload GET (upload.blade.php), hanya pakai route /dokumen/create GET (create.blade.php)
    // Route::get('/upload', [DokumenController::class, 'create'])->name('dokumen.create'); <-- DIHAPUS

    // Tetap gunakan route ini untuk akses form upload dokumen menggunakan create.blade.php
    Route::get('/dokumen/create', [DokumenController::class, 'create'])->name('dokumen.create');

    // Tetap gunakan POST /upload untuk proses upload dokumen (bisa juga diganti /dokumen jika mau)
    Route::post('/upload', [DokumenController::class, 'store'])->name('dokumen.store');

    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/dokumen/{id}/lihat', [DokumenController::class, 'showDokumen'])->name('dokumen.lihat');
    Route::get('/dokumen/{id}/validasi', [DokumenController::class, 'validasi'])->name('dokumen.validasi');
    Route::post('/dokumen/{id}/kembalikan', [DokumenController::class, 'kembalikan'])->name('dokumen.kembalikan');
    Route::post('/dokumen/{id}/setujui', [DokumenController::class, 'setujui'])->name('dokumen.setujui');
    Route::get('/dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('/dokumen/{id}', [DokumenController::class, 'update'])->name('dokumen.update');

    # Halaman Template Dokumen
    Route::get('/template', [DokumenController::class, 'create'])->name('beranda.template');



});
