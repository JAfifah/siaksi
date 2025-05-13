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
});

# Halaman Beranda
Route::get('/beranda/visi', fn() => view('beranda.visi'))->name('beranda.visi');
Route::get('/beranda/misi', fn() => view('beranda.misi'))->name('beranda.misi');
Route::get('/beranda/tujuan', fn() => view('beranda.tujuan'))->name('beranda.tujuan');
Route::get('/beranda/sasaran', fn() => view('beranda.sasaran'))->name('beranda.sasaran');

# Halaman Denah
Route::get('/denah', fn() => view('denah'))->name('denah');

# Kriteria
Route::get('/kriteria1', [KriteriaController::class, 'index'])->name('kriteria.index');
Route::get('/kriteria2', [KriteriaController::class, 'index'])->name('kriteria2.index'); // disesuaikan agar unik
Route::get('/kriteria1/lihat/{id}', [KriteriaController::class, 'lihat'])->name('kriteria.lihat');
Route::get('/kriteria/upload/{id}', [KriteriaController::class, 'upload'])->name('dokumen.upload');
Route::post('/kriteria/upload', [KriteriaController::class, 'store'])->name('kriteria.store');

# Komentar
Route::post('/komentar', [KomentarController::class, 'store'])->name('komentar.store');

# Dokumen (upload & view)
Route::get('/upload', [DokumenController::class, 'create'])->name('dokumen.create');
Route::post('/upload', [DokumenController::class, 'store'])->name('dokumen.store');
Route::get('/dokumen/create', [DokumenController::class, 'create']); // Sudah ada named route di atas
Route::get('/dokumen/{id}/lihat', [DokumenController::class, 'showDokumen'])->name('dokumen.lihat');
Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
Route::get('/dokumen/{id}/validasi', [DokumenController::class, 'validasi'])->name('dokumen.validasi');

# validasi
Route::get('/dokumen/{id}/validasi', [DokumenController::class, 'validasi'])->name('dokumen.validasi');
Route::post('/dokumen/{id}/kembalikan', [DokumenController::class, 'kembalikan'])->name('dokumen.kembalikan');
Route::post('/dokumen/{id}/setujui', [DokumenController::class, 'setujui'])->name('dokumen.setujui');