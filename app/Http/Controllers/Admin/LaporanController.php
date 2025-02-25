<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PeminjamanExport;
use App\Exports\PeminjamanRangeExport;
use App\Exports\PeminjamanTanggalExport;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function export_range(Request $request)
    {
        $tanggal = explode(" to ", $request->tanggal);

        $awal = DateTime::createFromFormat('d/m/Y', $tanggal[0])->format('Y-m-d');
        $akhir = DateTime::createFromFormat('d/m/Y', $tanggal[1])->format('Y-m-d');
        return Excel::download(new PeminjamanRangeExport($awal, $akhir), $awal . "sampai" . $akhir . "-peminjaman.xlsx");
    }

    public function export_tanggal(Request $request)
    {
        $tanggal =  DateTime::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        return Excel::download(new PeminjamanTanggalExport($tanggal),  $tanggal . "-peminjaman.xlsx");
    }
}
