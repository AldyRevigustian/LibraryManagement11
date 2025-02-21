<?php

use App\Http\Controllers\Guest\BukuController;
use App\Http\Controllers\Guest\DetailController;
use App\Http\Controllers\Guest\KategoriController;
use App\Http\Controllers\Guest\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WelcomeController::class, 'index']);

Route::get('/buku', [BukuController::class, 'search'])->name('guest.search_buku');
Route::get('/buku/detail/{id}', [BukuController::class, 'detail'])->name('guest.detail_buku');

Route::get('/kategori', [KategoriController::class, 'index'])->name('guest.kategori_buku');
Route::get('/kategori/penerbit/{id}', [KategoriController::class, 'penerbit'])->name('guest.penerbit_buku_id');
Route::get('/kategori/{id}', [KategoriController::class, 'kategori'])->name('guest.kategori_buku_id');

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

});

require __DIR__.'/auth.php';
