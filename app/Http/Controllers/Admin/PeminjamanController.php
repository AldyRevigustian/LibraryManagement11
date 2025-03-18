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
    public function index()
    {
        $peminjamans = Peminjaman::whereNull('tanggal_pengembalian')->orderBy('tanggal_peminjaman', 'desc')->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function add()
    {
        $anggotas = Anggota::all();
        $bukus = Buku::where('stok', '>', 0)->get();
        $rule = Aturan::first();
        return view('admin.peminjaman.create', compact('anggotas', 'bukus', 'rule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_peminjaman' => 'required',
            'batas_pengembalian' => 'required',
        ]);

        $tanggal_peminjaman = convertDateToMysqlFormat($request->tanggal_peminjaman);
        $batas_pengembalian = convertDateToMysqlFormat($request->batas_pengembalian);

        $anggota = Anggota::find($request->anggota_id);
        $buku = Buku::find($request->buku_id);
        $rule = Aturan::first();

        if ($buku->stok <= 0) {
            return redirect()->back()->with('status', 'danger')->with('message', 'Buku tidak tersedia');
        } elseif ($anggota->peminjamans_active->count() >= $rule->maksimal_buku) {
            return redirect()->back()->with('status', 'danger')->with('message', 'Maksimal peminjaman buku telah dicapai');
        }

        $peminjaman = new Peminjaman();
        $peminjaman->anggota_id = $anggota->id;
        $peminjaman->buku_id = $buku->id;
        $peminjaman->tanggal_peminjaman = $tanggal_peminjaman;
        $peminjaman->batas_pengembalian = $batas_pengembalian;
        $peminjaman->save();

        $buku->stok -= 1;
        $buku->save();

        return redirect()->route('admin.peminjaman')->with('status', 'success')->with('message', 'Peminjaman berhasil ditambahkan');
    }
}
