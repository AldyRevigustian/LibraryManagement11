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

    public function edit($id)
    {
        $peminjaman = Peminjaman::find($id);
        $rule = Aturan::first();
        $anggotas = Anggota::all();
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('admin.peminjaman.edit', compact('peminjaman', 'rule', 'anggotas', 'bukus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_peminjaman' => 'required',
            'batas_pengembalian' => 'required',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        $tanggal_peminjaman = convertDateToMysqlFormat($request->tanggal_peminjaman);
        $batas_pengembalian = convertDateToMysqlFormat($request->batas_pengembalian);

        $anggota = Anggota::find($request->anggota_id);
        $buku_lama = Buku::find($peminjaman->buku_id);
        $buku_baru = Buku::find($request->buku_id);

        if ($peminjaman->buku_id != $buku_baru->id && $buku_baru->stok <= 0) {
            return redirect()->back()->with('status', 'danger')->with('message', 'Buku baru tidak tersedia');
        }

        if ($peminjaman->buku_id != $buku_baru->id) {
            $buku_lama->stok += 1;
            $buku_lama->save();

            $buku_baru->stok -= 1;
            $buku_baru->save();
        }

        $peminjaman->anggota_id = $anggota->id;
        $peminjaman->buku_id = $buku_baru->id;
        $peminjaman->tanggal_peminjaman = $tanggal_peminjaman;
        $peminjaman->batas_pengembalian = $batas_pengembalian;
        $peminjaman->save();

        return redirect()->route('admin.peminjaman')->with('status', 'success')->with('message', 'Peminjaman berhasil diupdate');
    }


    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);
        $buku = Buku::find($peminjaman->buku_id);

        if ($peminjaman) {
            $peminjaman->delete();
            $buku->update([
                'stok' => $buku->stok + 1
            ]);
            return redirect()->route('admin.peminjaman')->with('status', 'success')->with('message', 'Sukses Menghapus Peminjaman');
        }
        return redirect()->route('admin.peminjaman')->with('status', 'danger')->with('message', 'Gagal Menghapus Peminjaman');
    }
}
