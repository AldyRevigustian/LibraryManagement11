<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::whereNotNull('tanggal_pengembalian')->orderBy('tanggal_peminjaman', 'desc')->get();
        return view('admin.pengembalian.index', compact('peminjamans'));
    }
}
