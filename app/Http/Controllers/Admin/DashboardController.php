<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);

        $bukus = Buku::all()->count();
        $anggotas = Anggota::all()->count();
        $stoks = Buku::sum('stok');
        $peminjamans = Peminjaman::whereNull('tanggal_pengembalian')->count();

        return view('dashboard', compact('bukus', 'anggotas', 'stoks', 'peminjamans', 'tahun'));
    }

    public function getChartData(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);

        $dataPeminjaman = Peminjaman::selectRaw('MONTH(tanggal_peminjaman) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_peminjaman', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $peminjamanChart = [];

        foreach ($dataPeminjaman as $item) {
            $peminjamanChart[$item->bulan - 1] = $item->total;
        }

        return response()->json([
            'peminjamanChart' => $peminjamanChart
        ]);
    }
}
