<?php

use App\Http\Controllers\Admin\LansiaController;
use App\Http\Controllers\Admin\KebutuhanPantiController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\DashboardController;

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
    Route::get('/dashboard', function () {
        return view('donatur.dashboard');
    })->name('dashboard');
});