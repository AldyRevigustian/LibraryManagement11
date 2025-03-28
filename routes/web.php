<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Anggota\BukuFavorit;
use App\Http\Controllers\Anggota\ProfileController;
use App\Http\Controllers\Guest\BukuController;
use App\Http\Controllers\Guest\KategoriController;
use App\Http\Controllers\Guest\WelcomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AnggotaAuthController;
use App\Http\Middleware\RedirectIfNotSuperAdmin;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::prefix('buku')->group(function () {
    Route::get('/', [BukuController::class, 'search'])->name('guest.search_buku');
    Route::get('/detail/{id}', [BukuController::class, 'detail'])->name('guest.detail_buku');
});

Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('guest.kategori_buku');
    Route::get('/penerbit/{id}', [KategoriController::class, 'penerbit'])->name('guest.penerbit_buku_id');
    Route::get('/{id}', [KategoriController::class, 'kategori'])->name('guest.kategori_buku_id');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('anggota/login', [AnggotaAuthController::class, 'showLoginForm'])->name('anggota.login');
    Route::post('anggota/login', [AnggotaAuthController::class, 'login'])->name('anggota.login.auth');

    Route::get('anggota/register', [AnggotaAuthController::class, 'showRegisterForm'])->name('anggota.register');
    Route::post('anggota/register', [AnggotaAuthController::class, 'register'])->name('anggota.register.auth');

    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.auth');
});

// Anggota Routes
Route::prefix('anggota')->middleware('auth:anggota')->group(function () {
    Route::get('/', function () {
        return redirect()->route('welcome');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('anggota.profile');
        Route::put('/update/{id}', [ProfileController::class, 'update'])->name('anggota.profile_update');
    });

    Route::prefix('favorit')->group(function () {
        Route::get('/', [BukuFavorit::class, 'index'])->name('anggota.favorite');
        Route::post('/add/{id}', [BukuFavorit::class, 'create'])->name('anggota.favorite_add');
        Route::delete('/delete/{id}', [BukuFavorit::class, 'destroy'])->name('anggota.favorite_delete');
    });


    Route::prefix('transaksi')->group(function () {
        Route::prefix('peminjaman')->controller(App\Http\Controllers\Anggota\PeminjamanController::class)->group(function () {
            Route::get('/', 'index')->name('anggota.peminjaman');
            Route::get('/add', 'add')->name('anggota.peminjaman_add');
            Route::post('/add/store', 'store')->name('anggota.peminjaman_store');
        });

        Route::prefix('pengembalian')->controller(App\Http\Controllers\Anggota\PengembalianController::class)->group(function () {
            Route::get('/', 'index')->name('anggota.pengembalian');
        });
    });
    Route::post('/logout', [AnggotaAuthController::class, 'logout'])->name('anggota.logout');
});

// Admin Routes
Route::prefix('admin')->middleware('auth:web')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/chart', [DashboardController::class, 'getChartData'])->name('dashboard.chart');
    });

    Route::prefix('master')->group(function () {
        Route::prefix('anggota')->controller(App\Http\Controllers\Admin\AnggotaController::class)->group(function () {
            Route::get('/', 'index')->name('admin.anggota');
            Route::get('/add', 'add')->name('admin.anggota_add');
            Route::post('/add/store', 'store')->name('admin.anggota_store');

            Route::get('/edit/{id}', 'edit')->name('admin.anggota_edit');
            Route::post('/update/{id}', 'update')->name('admin.anggota_update');

            Route::delete('/{id}', 'destroy')->name('admin.anggota_destroy');
        });

        Route::prefix('administrator')->middleware(RedirectIfNotSuperAdmin::class)->controller(App\Http\Controllers\Admin\AdminController::class)->group(function () {
            Route::get('/', 'index')->name('admin.administrator');
            Route::get('/add', 'add')->name('admin.administrator_add');
            Route::post('/add/store', 'store')->name('admin.administrator_store');

            Route::get('/edit/{id}', 'edit')->name('admin.administrator_edit');
            Route::post('/update/{id}', 'update')->name('admin.administrator_update');

            Route::delete('/{id}', 'destroy')->name('admin.administrator_destroy');
        });
    });

    Route::prefix('katalog')->group(function () {
        Route::prefix('kategori')->controller(App\Http\Controllers\Admin\KategoriController::class)->group(function () {
            Route::get('/', 'index')->name('admin.kategori');
            Route::get('/add', 'add')->name('admin.kategori_add');
            Route::post('/add/store', 'store')->name('admin.kategori_store');

            Route::get('/edit/{id}', 'edit')->name('admin.kategori_edit');
            Route::post('/update/{id}', 'update')->name('admin.kategori_update');

            Route::delete('/{id}', 'destroy')->name('admin.kategori_destroy');
        });

        Route::prefix('penerbit')->controller(App\Http\Controllers\Admin\PenerbitController::class)->group(function () {
            Route::get('/', 'index')->name('admin.penerbit');
            Route::get('/add', 'add')->name('admin.penerbit_add');
            Route::post('/add/store', 'store')->name('admin.penerbit_store');

            Route::get('/edit/{id}', 'edit')->name('admin.penerbit_edit');
            Route::post('/update/{id}', 'update')->name('admin.penerbit_update');

            Route::delete('/{id}', 'destroy')->name('admin.penerbit_destroy');
        });

        Route::prefix('buku')->controller(App\Http\Controllers\Admin\BukuController::class)->group(function () {
            Route::get('/', 'index')->name('admin.buku');
            Route::get('/add', 'add')->name('admin.buku_add');
            Route::post('/add/store', 'store')->name('admin.buku_store');

            Route::get('/edit/{id}', 'edit')->name('admin.buku_edit');
            Route::post('/update/{id}', 'update')->name('admin.buku_update');

            Route::delete('/{id}', 'destroy')->name('admin.buku_destroy');
        });
    });

    Route::prefix('transaksi')->group(function () {
        Route::prefix('peminjaman')->controller(App\Http\Controllers\Admin\PeminjamanController::class)->group(function () {
            Route::get('/', 'index')->name('admin.peminjaman');
            Route::get('/add', 'add')->name('admin.peminjaman_add');
            Route::post('/add/store', 'store')->name('admin.peminjaman_store');

            Route::get('/edit/{id}', 'edit')->name('admin.peminjaman_edit');
            Route::post('/update/{id}', 'update')->name('admin.peminjaman_update');

            Route::delete('/{id}', 'destroy')->name('admin.peminjaman_destroy');
        });

        Route::prefix('pengembalian')->controller(App\Http\Controllers\Admin\PengembalianController::class)->group(function () {
            Route::get('/', 'index')->name('admin.pengembalian');
            Route::get('/add', 'add')->name('admin.pengembalian_add');
            Route::post('/add/store', 'store')->name('admin.pengembalian_store');

            Route::get('/edit/{id}', 'edit')->name('admin.pengembalian_edit');
            Route::post('/update/{id}', 'update')->name('admin.pengembalian_update');

            Route::post('/{id}', 'restore')->name('admin.pengembalian_restore');
            Route::delete('/{id}', 'destroy')->name('admin.pengembalian_destroy');
        });
    });

    Route::prefix('laporan')->controller(App\Http\Controllers\Admin\LaporanController::class)->group(function () {
        Route::get('/', 'index')->name('admin.laporan');
        Route::post('/export/peminjaman', [LaporanController::class, 'export_peminjaman'])->name('admin.export_peminjaman');
        Route::post('/export/pengembalian', [LaporanController::class, 'export_pengembalian'])->name('admin.export_pengembalian');
        Route::post('/export/all', [LaporanController::class, 'export_all'])->name('admin.export_all');
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


Route::post('/calculate-denda', [DendaController::class, 'calculateDenda']);
