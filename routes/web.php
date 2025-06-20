<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
=======
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AbsensiController; 
use App\Http\Controllers\User\IzinController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) { // Jika user sudah login
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard'); // Redirect admin ke dashboard admin
        } else {
            return redirect()->route('pegawai.dashboard'); // Redirect pegawai ke dashboard pegawai
        }
    }
    return view('auth.login'); // Jika belum login, tampilkan halaman login
})->name('welcome'); // Nama rute ini tetap 'welcome'

// Rute Autentikasi dari Breeze
require __DIR__.'/auth.php';

// Rute Umum untuk Pengguna Terautentikasi (Admin & Pegawai)
Route::middleware(['auth', 'verified'])->group(function () {
    // Ini adalah rute default setelah login. Fungsinya hanya sebagai "router" berdasarkan role.
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        // Jika bukan admin (berarti pegawai), redirect ke dashboard spesifik pegawai
        return redirect()->route('pegawai.dashboard');
    })->name('dashboard'); // Nama rute ini tetap 'dashboard' karena itu defaultnya Breeze

    // Rute Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute Dashboard SPESIFIK untuk PEGAWAI
Route::get('/pegawai/dashboard', function () {
    return view('dashboard'); // Menampilkan resources/views/dashboard.blade.php
})->middleware(['auth', 'verified'])->name('pegawai.dashboard');


// Rute Khusus untuk Pegawai (fitur absensi, izin)
Route::middleware(['auth', 'verified'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'absenPulang'])->name('absensi.pulang');
    Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayatBulanan'])->name('absensi.riwayat');

    Route::resource('izin', IzinController::class)->except(['show', 'edit', 'update', 'destroy']);
});

// Rute Khusus untuk Admin (Dashboard Admin Saja, CRUD via Filament)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
