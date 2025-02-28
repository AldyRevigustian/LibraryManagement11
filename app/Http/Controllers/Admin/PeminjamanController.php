<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(){
        $peminjamans = Peminjaman::whereNull('tanggal_pengembalian')->get();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }
}
