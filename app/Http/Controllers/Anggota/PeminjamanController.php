<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Aturan;
use App\Models\Buku;
use App\Models\Peminjaman;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $anggota = Anggota::find(Auth::guard('anggota')->user()->id);
        $peminjamans = Peminjaman::whereNull('tanggal_pengembalian')->where('anggota_id', $anggota->id)->get();
        $rule = Aturan::first();
        return view('anggota.peminjaman.index', compact('peminjamans', 'rule'));
    }

    public function add(Request $request)
    {
        $anggota = Anggota::find(Auth::guard('anggota')->user()->id);
        $buku_id = $request->query('buku_id');
        $bukus = Buku::where('stok', '>', 0)->get();
        $rule = Aturan::first();

        return view('anggota.peminjaman.create', compact('bukus', 'rule', 'buku_id'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_peminjaman' => 'required',
            'batas_pengembalian' => 'required',
        ]);

        $tanggal_peminjaman = convertDateToMysqlFormat($request->tanggal_peminjaman);
        $batas_pengembalian = convertDateToMysqlFormat($request->batas_pengembalian);

        $anggota = Anggota::find(Auth::guard('anggota')->user()->id);
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

        return redirect()->route('anggota.peminjaman')->with('status', 'success')->with('message', 'Peminjaman berhasil ditambahkan');
    }
}
