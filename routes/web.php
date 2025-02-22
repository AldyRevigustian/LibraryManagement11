<?php

use App\Http\Controllers\Anggota\BukuFavorit;
use App\Http\Controllers\Guest\BukuController;
use App\Http\Controllers\Guest\DetailController;
use App\Http\Controllers\Guest\KategoriController;
use App\Http\Controllers\Guest\WelcomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AnggotaAuthController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/buku', [BukuController::class, 'search'])->name('guest.search_buku');
Route::get('/buku/detail/{id}', [BukuController::class, 'detail'])->name('guest.detail_buku');

Route::get('/kategori', [KategoriController::class, 'index'])->name('guest.kategori_buku');
Route::get('/kategori/penerbit/{id}', [KategoriController::class, 'penerbit'])->name('guest.penerbit_buku_id');
Route::get('/kategori/{id}', [KategoriController::class, 'kategori'])->name('guest.kategori_buku_id');


Route::middleware('guest')->group(function () {
    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.auth');
});

Route::prefix('admin')->middleware('auth:web')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

    Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


Route::prefix('anggota')->middleware('guest')->group(function () {
    Route::get('login', [AnggotaAuthController::class, 'showLoginForm'])->name('anggota.login');
    Route::post('login', [AnggotaAuthController::class, 'login'])->name('anggota.login.auth');

    Route::get('register', [AnggotaAuthController::class, 'showRegisterForm'])->name('anggota.register');
    Route::post('register', [AnggotaAuthController::class, 'register'])->name('anggota.register.auth');
});

Route::prefix('anggota')->middleware('auth:anggota')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('anggota.dashboard');
    // })->name('anggota.dashboard');
    Route::get('/favorit', [BukuFavorit::class, 'index'])->name('anggota.favorite');
    Route::post('/favorit/add/{id}', [BukuFavorit::class, 'create'])->name('anggota.favorite_add');
    Route::delete('/favorit/delete/{id}', [BukuFavorit::class, 'destroy'])->name('anggota.favorite_delete');

    Route::post('/logout', [AnggotaAuthController::class, 'logout'])->name('anggota.logout');
});
