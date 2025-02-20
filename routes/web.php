<?php

use App\Http\Controllers\Guest\DetailController;
use App\Http\Controllers\Guest\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WelcomeController::class, 'index']);
Route::get('/buku/detail/{id}', [DetailController::class, 'index'])->name('guest.detail_buku');

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

});

require __DIR__.'/auth.php';
