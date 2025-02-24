<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $bukus = Buku::all()->count();
        $anggotas = Anggota::all()->count();
        $stoks = Buku::sum('stok');
        $peminjamans = Peminjaman::whereNull('tanggal_pengembalian')->count();
        return view('dashboard', compact('bukus', 'anggotas', 'stoks', 'peminjamans'));
    }
}
