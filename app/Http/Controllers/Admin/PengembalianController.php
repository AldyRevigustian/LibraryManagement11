<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Aturan;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::whereNotNull('tanggal_pengembalian')->orderBy('updated_at', 'desc')->get();
        return view('admin.pengembalian.index', compact('peminjamans'));
    }


    public function add()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->whereNull('tanggal_pengembalian')
            ->get();

        $anggotas = $peminjamans->pluck('anggota')->unique('id');
        $bukus = collect();
        $peminjamanByAnggota = $peminjamans->groupBy('anggota_id');
        $rule = Aturan::first();
        return view('admin.pengembalian.create', compact('anggotas', 'bukus', 'rule', 'peminjamanByAnggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_pengembalian' => 'required',
        ]);

        $tanggal_pengembalian = convertDateToMysqlFormat($request->tanggal_pengembalian);

        $peminjaman = Peminjaman::find($request->peminjaman_id);

        $batasPengembalian = Carbon::parse($peminjaman->batas_pengembalian);
        $tanggalPengembalian = Carbon::parse($tanggal_pengembalian);

        $formattedTanggalPengembalian = $tanggalPengembalian->format('Y-m-d');
        $isLate = $tanggalPengembalian->gt($batasPengembalian);
        $denda = 0;

        if ($isLate) {
            $hariTerlambat = $batasPengembalian->diffInDays($tanggalPengembalian);
            $denda = $hariTerlambat * Aturan::first()->denda;
        }

        $pem = $peminjaman->update([
            'denda' => $denda,
            'tanggal_pengembalian' => $formattedTanggalPengembalian,
        ]);


        if ($pem) {
            $buku = Buku::find($peminjaman->buku_id);
            $buku->stok += 1;
            $buku->save();

            return redirect()->route('admin.pengembalian')->with('status', 'success')->with('message', 'Suksesi Mengembalikan Buku');
        }
        return redirect()->route('admin.pengembalian')->with('status', 'danger')->with('message', 'Gagal Mengembalikan Buku');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::find($id);

        $anggota = Anggota::find($peminjaman->anggota_id);
        $rule = Aturan::first();

        $tanggal_peminjaman = Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y');
        $batas_pengembalian = Carbon::parse($peminjaman->batas_pengembalian)->format('d/m/Y');

        return view('admin.pengembalian.edit', compact('peminjaman', 'anggota', 'rule', 'tanggal_peminjaman', 'batas_pengembalian'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::find($id);
        $request->validate([
            'tanggal_pengembalian' => 'required',
        ]);

        $tanggal_pengembalian = convertDateToMysqlFormat($request->tanggal_pengembalian);


        $batasPengembalian = Carbon::parse($peminjaman->batas_pengembalian);
        $tanggalPengembalian = Carbon::parse($tanggal_pengembalian);

        $isLate = $tanggalPengembalian->gt($batasPengembalian);
        $denda = 0;

        if ($isLate) {
            $hariTerlambat = $batasPengembalian->diffInDays($tanggalPengembalian);
            $denda = $hariTerlambat * Aturan::first()->denda;
        }

        $pem = $peminjaman->update([
            'denda' => $denda,
            'tanggal_pengembalian' => $tanggal_pengembalian,
        ]);

        if ($pem) {
            return redirect()->route('admin.pengembalian')->with('status', 'success')->with('message', 'Suksesi Edit Pengembalian Buku');
        }
        return redirect()->route('admin.pengembalian')->with('status', 'danger')->with('message', 'Gagal Edit Pengembalian Buku');
    }


    public function restore($id)
    {
        $peminjaman = Peminjaman::find($id);
        $buku = Buku::find($peminjaman->buku_id);

        if ($peminjaman) {
            $peminjaman->update([
                'tanggal_pengembalian' => null,
                'denda' => 0,
            ]);
            $buku->update([
                'stok' => $buku->stok - 1
            ]);
            return redirect()->route('admin.pengembalian')->with('status', 'success')->with('message', 'Sukses Merestore Pengembalian');
        }
        return redirect()->route('admin.pengembalian')->with('status', 'danger')->with('message', 'Gagal Merestore Pengembalian');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);

        if ($peminjaman) {
            $peminjaman->delete();
            return redirect()->route('admin.pengembalian')->with('status', 'success')->with('message', 'Sukses Menghapus Pengembalian');
        }
        return redirect()->route('admin.pengembalian')->with('status', 'danger')->with('message', 'Gagal Menghapus Pengembalian');
    }
}
