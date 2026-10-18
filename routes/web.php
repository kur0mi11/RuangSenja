<?php

use App\Http\Controllers\Admin\LansiaController;
use App\Http\Controllers\Admin\KebutuhanPantiController;
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Donatur\DashboardController as DonaturDashboardController;
use App\Http\Controllers\Donatur\DonasiController as DonaturDonasiController;
use App\Http\Controllers\Donatur\ProfilController as DonaturProfilController;
use Illuminate\Support\Facades\Route;

// Halaman publik
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Autentikasi (hanya untuk tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout (harus sudah login)
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    //nampilin dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Foto lansia (private, harus sebelum resource agar tidak tertimpa)
    Route::get('/lansia/{lansia}/foto', [LansiaController::class, 'foto'])
        ->name('lansia.foto');

    // CRUD Data Lansia — paksa parameter tetap {lansia}, bukan {lansium}
    Route::resource('lansia', LansiaController::class)
        ->parameters(['lansia' => 'lansia']);

    // CRUD Kebutuhan Panti
    Route::resource('kebutuhan', KebutuhanPantiController::class)
        ->parameters(['kebutuhan' => 'kebutuhan']);

    //nampilin daftar donasi
    Route::get('/donasi', [DonasiController::class, 'index'])
        ->name('donasi.index');

    //nampilin detail donasi
    Route::get('/donasi/{donasi}', [DonasiController::class, 'show'])
        ->name('donasi.show');

    //nerima atau nolak donasi
    Route::patch('/donasi/{donasi}/proses', [DonasiController::class, 'proses'])
        ->name('donasi.proses');

    //nampilin bukti transfer donasi
    Route::get('/donasi/{donasi}/bukti-transfer', [DonasiController::class, 'buktiTransfer'])
        ->name('donasi.bukti-transfer');
});

// Donatur
Route::middleware(['auth', 'donatur'])->prefix('donatur')->name('donatur.')->group(function () {

    Route::get('/dashboard', DonaturDashboardController::class)
        ->name('dashboard');

    Route::get('/kebutuhan', [DonaturDonasiController::class, 'kebutuhan'])
        ->name('kebutuhan.index');

    Route::get('/donasi', [DonaturDonasiController::class, 'index'])->name('donasi.index');
    Route::get('/donasi/create', [DonaturDonasiController::class, 'create'])->name('donasi.create');
    Route::post('/donasi', [DonaturDonasiController::class, 'store'])->name('donasi.store');
    Route::get('/donasi/{donasi}/edit', [DonaturDonasiController::class, 'edit'])->name('donasi.edit');
    Route::put('/donasi/{donasi}', [DonaturDonasiController::class, 'update'])->name('donasi.update');
    Route::delete('/donasi/{donasi}', [DonaturDonasiController::class, 'destroy'])->name('donasi.destroy');
    Route::get('/donasi/{donasi}', [DonaturDonasiController::class, 'show'])->name('donasi.show');

    // Profil, ganti password, dan FAQ
    Route::get('/profil', [DonaturProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [DonaturProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [DonaturProfilController::class, 'updatePassword'])->name('profil.password');
    Route::get('/faq', [DonaturProfilController::class, 'faq'])->name('faq');
});