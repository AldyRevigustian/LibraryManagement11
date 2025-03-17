<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Aturan;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::whereNull('tanggal_pengembalian')->get();
        return view('anggota.peminjaman.index', compact('peminjamans'));
    }

    public function add(Request $request)
    {
        $buku_id = $request->query('buku_id'); 
        $bukus = Buku::where('stok', '>', 0)->get();
        $rule = Aturan::first();

        return view('anggota.peminjaman.create', compact('bukus', 'rule', 'buku_id'));
    }


    public function store() {}
}
