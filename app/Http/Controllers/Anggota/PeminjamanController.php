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

    public function add()
    {
        $anggotas = Anggota::all();
        $bukus = Buku::where('stok','>', 0)->get();
        $rule = Aturan::first();
        return view('anggota.peminjaman.create', compact('anggotas', 'bukus', 'rule'));
    }

    public function store() {}
}
