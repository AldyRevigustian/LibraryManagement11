<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Aturan;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(){
        $peminjamans = Peminjaman::whereNull('tanggal_pengembalian')->orderBy('tanggal_peminjaman', 'desc')->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function add()
    {
        $anggotas = Anggota::all();
        $bukus = Buku::all();
        $rule = Aturan::first();
        return view('admin.peminjaman.create', compact('anggotas', 'bukus', 'rule'));
    }

    public function store(){

    }
}
