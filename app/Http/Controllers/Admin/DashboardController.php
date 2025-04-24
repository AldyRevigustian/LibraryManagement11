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

        $bukus = number_format(Buku::all()->count(), 0, ',', '.');
        $anggotas = number_format(Anggota::all()->count(), 0, ',', '.');
        $stoks = number_format(Buku::sum('stok'), 0, ',', '.');
        $peminjamans = number_format(Peminjaman::whereNull('tanggal_pengembalian')->count(), 0, ',', '.');

        return view('admin.dashboard', compact('bukus', 'anggotas', 'stoks', 'peminjamans', 'tahun'));
    }

    public function getChartData(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $monthCount = ($tahun < $currentYear) ? 12 : $currentMonth;
        $peminjamanChart = array_fill(0, $monthCount, 0);

        $dataPeminjaman = Peminjaman::selectRaw('MONTH(tanggal_peminjaman) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_peminjaman', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        foreach ($dataPeminjaman as $item) {
            if ($item->bulan <= $monthCount) {
                $peminjamanChart[$item->bulan - 1] = $item->total;
            }
        }
        $peminjamanChart = array_values($peminjamanChart);
        $monthNames = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];
        $displayMonths = array_slice($monthNames, 0, $monthCount);
        array_push($displayMonths, 'All');

        return response()->json([
            'peminjamanChart' => $peminjamanChart,
            'monthLabels' => $displayMonths
        ]);
    }

    public function getPopularData(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);
        if ($request->input('bulan', Carbon::now()->month)) {
            $bulan = $request->input('bulan', Carbon::now()->month);
            $data = Peminjaman::with('buku')
                ->whereYear('tanggal_peminjaman', $tahun)
                ->whereMonth('tanggal_peminjaman', $bulan)
                ->selectRaw('buku_id, COUNT(*) as total')
                ->groupBy('buku_id')
                ->orderByDesc('total')
                ->limit(10)
                ->get();
        } else {
            $data = Peminjaman::with('buku')
                ->whereYear('tanggal_peminjaman', $tahun)
                ->selectRaw('buku_id, COUNT(*) as total')
                ->groupBy('buku_id')
                ->orderByDesc('total')
                ->limit(10)
                ->get();
        }

        $result = $data->map(function ($item) {
            return [
                'judul' => $item->buku->judul ?? 'Tidak diketahui',
                'total' => $item->total,
            ];
        });

        return response()->json($result);
    }

    public function getCategoryData(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);
        $bulan = $request->input('bulan', Carbon::now()->month);

        if ($request->input('bulan', Carbon::now()->month)) {
            $bulan = $request->input('bulan', Carbon::now()->month);

            $data = Peminjaman::with(['buku.kategori'])
                ->whereYear('tanggal_peminjaman', $tahun)
                ->whereMonth('tanggal_peminjaman', $bulan)
                ->get()
                ->groupBy(function ($item) {
                    return $item->buku->kategori->nama;
                })
                ->map(function ($group) {
                    return count($group);
                })
                ->sortDesc()
                ->take(5);
        } else {
            $data = Peminjaman::with(['buku.kategori'])
                ->whereYear('tanggal_peminjaman', $tahun)
                ->get()
                ->groupBy(function ($item) {
                    return $item->buku->kategori->nama;
                })
                ->map(function ($group) {
                    return count($group);
                })
                ->sortDesc()
                ->take(5);
        }

        $result = $data->map(function ($total, $kategori) {
            return [
                'kategori' => $kategori,
                'total' => $total,
            ];
        })->values();

        return response()->json($result);
    }
}
