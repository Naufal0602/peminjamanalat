<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\LogAktivitasController;  
use App\Http\Controllers\Admin\PeminjamanAdminController;


use App\Http\Controllers\Petugas\DashboardController;
use App\Http\Controllers\Petugas\PeminjamanPetugasController;
use App\Http\Controllers\Petugas\PengembalianController;
use App\Http\Controllers\Petugas\LaporanController;

use App\Http\Controllers\Peminjam\DashboardPeminjamController;
use App\Http\Controllers\Peminjam\PeminjamanController;
use App\Http\Controllers\Peminjam\PengembalianUserController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/alat', [AlatController::class, 'index'])->name('admin.alat.index');
    Route::get('/alat/create', [AlatController::class, 'create'])->name('admin.alat.create');
    Route::post('/alat', [AlatController::class, 'store'])->name('admin.alat.store');
    Route::get('/alat/{id}/edit', [AlatController::class, 'edit'])->name('admin.alat.edit');
    Route::put('/alat/{id}', [AlatController::class, 'update'])->name('admin.alat.update');
    Route::delete('/alat/{id}', [AlatController::class, 'destroy'])->name('admin.alat.destroy');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('admin.pengguna.index');
    Route::get('/pengguna/create', [PenggunaController::class, 'create'])->name('admin.pengguna.create');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('admin.pengguna.store');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');

    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('admin.log_aktivitas.index');

    Route::get('/peminjaman', [PeminjamanAdminController::class, 'index'])->name('admin.peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanAdminController::class, 'create'])->name('admin.peminjaman.create');
    Route::post('/peminjaman', [PeminjamanAdminController::class, 'store'])->name('admin.peminjaman.store');
    Route::get('/peminjaman/{id}/edit', [PeminjamanAdminController::class, 'edit'])->name('admin.peminjaman.edit');
    Route::put('/peminjaman/{id}', [PeminjamanAdminController::class, 'update'])->name('admin.peminjaman.update');
    Route::delete('/peminjaman/{id}', [PeminjamanAdminController::class, 'destroy'])->name('admin.peminjaman.destroy');
    });

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('petugas.dashboard');

    Route::get('/peminjaman', [PeminjamanPetugasController::class, 'index'])->name('petugas.peminjaman.index');
    Route::post('peminjaman/{id}/setujui', [PeminjamanPetugasController::class, 'setujui'])->name('petugas.peminjaman.setujui');
    Route::post('peminjaman/{id}/tolak', [PeminjamanPetugasController::class, 'tolak'])->name('petugas.peminjaman.tolak');

    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('petugas.pengembalian.index');
    Route::get('pengembalian/{id}/create', [PengembalianController::class, 'create'])->name('petugas.pengembalian.create');
    Route::post('pengembalian/{id}', [PengembalianController::class, 'store'])->name('petugas.pengembalian.store');
    Route::post('pengembalian/{id}/peringatan',[PengembalianController::class, 'peringatan'])->name('petugas.pengembalian.peringatan');
    Route::post('peminjaman/{id}/serahkan', [PeminjamanPetugasController::class, 'serahkan'])->name('petugas.peminjaman.serahkan');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('petugas.laporan.index');
    Route::get('/petugas/laporan/print-pdf',[LaporanController::class, 'printPdf'])->name('petugas.laporan.printPdf');
    
});

Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->group(function () {
    Route::get('/dashboard', [DashboardPeminjamController::class, 'index'])->name('peminjam.dashboard');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjam.peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjam.peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjam.peminjaman.store');

    Route::get('/pengembalian', [PengembalianUserController::class, 'index'])->name('peminjam.pengembalian.index');
    Route::put('/peminjam/peminjaman/{id}/batal', [PeminjamanController::class, 'batal'])->name('peminjam.peminjaman.batal');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
