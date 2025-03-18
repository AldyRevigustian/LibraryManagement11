<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function index()
    {
        $anggota = Anggota::find(Auth::guard('anggota')->user()->id);
        $peminjamans = Peminjaman::whereNotNull('tanggal_pengembalian')->where('anggota_id', $anggota->id)->orderBy('tanggal_peminjaman', 'desc')->get();
        return view('anggota.pengembalian.index', compact('peminjamans'));
    }
}
