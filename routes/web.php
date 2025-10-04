<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PermintaanController;

// ==============================
// ROUTE UTAMA / HALAMAN WELCOME
// ==============================
Route::get('/', function () {
    return view('welcome'); // Tampilan awal aplikasi
});

// ==============================
// ROUTE AUTENTIKASI LOGIN/LOGOUT
// ==============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Form login
Route::post('/login', [AuthController::class, 'login']); // Proses login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Proses logout

// ==================================================
// ROUTE UNTUK ROLE "GUDANG" (DENGAN PREFIX /gudang)
// ==================================================
Route::middleware('auth.role:gudang')->prefix('gudang')->group(function () {
    
    // Dashboard gudang
    Route::get('/', function () {
        return view('gudang.dashboard');
    });

    // -------------------------------
    // CRUD BAHAN BAKU UNTUK PETUGAS GUDANG
    // -------------------------------
    Route::get('/bahan', [BahanBakuController::class, 'index'])->name('gudang.bahan.index'); // Daftar bahan
    Route::get('/bahan/create', [BahanBakuController::class, 'create'])->name('gudang.bahan.create'); // Form tambah bahan
    Route::post('/bahan', [BahanBakuController::class, 'store'])->name('gudang.bahan.store'); // Simpan bahan baru
    Route::get('/bahan/{id}/edit', [BahanBakuController::class, 'edit'])->name('gudang.bahan.edit'); // Edit bahan
    Route::put('/bahan/{id}', [BahanBakuController::class, 'update'])->name('gudang.bahan.update'); // Update bahan
    Route::get('/bahan/{id}/delete', [BahanBakuController::class, 'confirmDelete'])->name('gudang.bahan.confirmDelete'); // Konfirmasi hapus
    Route::delete('/bahan/{id}', [BahanBakuController::class, 'destroy'])->name('gudang.bahan.destroy'); // Hapus bahan

    // -------------------------------
    // PERMINTAAN BAHAN DARI DAPUR
    // -------------------------------
    Route::get('/permintaan', [PermintaanController::class, 'indexGudang'])->name('gudang.permintaan.index'); // Lihat daftar permintaan dari dapur
    Route::post('/permintaan/{id}/approve', [PermintaanController::class, 'approve'])->name('gudang.permintaan.approve'); // Setujui permintaan
    Route::post('/permintaan/{id}/reject', [PermintaanController::class, 'reject'])->name('gudang.permintaan.reject'); // Tolak permintaan

});

// =================================================
// ROUTE UNTUK ROLE "DAPUR" (DENGAN PREFIX /dapur)
// =================================================
Route::middleware(['auth.role:dapur'])->prefix('dapur')->group(function () {

    // Dashboard dapur
    Route::get('/', function () {
        return view('dapur.dashboard');
    });

    // -------------------------------
    // FORM & STATUS PERMINTAAN DAPUR
    // -------------------------------
    Route::get('/permintaan', [PermintaanController::class, 'create'])->name('dapur.permintaan.create'); // Form buat permintaan baru
    Route::post('/permintaan', [PermintaanController::class, 'store'])->name('dapur.permintaan.store'); // Simpan permintaan
    Route::get('/status', [PermintaanController::class, 'status'])->name('dapur.permintaan.status'); // Lihat status permintaan dapur
    Route::get('/permintaan/{id}', [PermintaanController::class, 'show'])->name('dapur.permintaan.detail'); // Detail permintaan tertentu
});
