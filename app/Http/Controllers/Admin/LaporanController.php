<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AllExport;
use App\Exports\PeminjamanExport;
use App\Exports\PeminjamanRangeExport;
use App\Exports\PeminjamanTanggalExport;
use App\Exports\PengembalianExport;
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

    public function convertMonthToEnglish($dateString)
    {
        $months = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December'
        ];

        return str_replace(array_keys($months), array_values($months), $dateString);
    }

    public function export_peminjaman(Request $request)
    {
        if (str_contains($request->tanggal, '-')) {
            $tanggal = explode(" - ", $request->tanggal);
            $awal = $this->convertMonthToEnglish($tanggal[0]);
            $akhir = $this->convertMonthToEnglish($tanggal[1]);

            $awal = DateTime::createFromFormat('d F Y', $awal)->format('Y-m-d');
            $akhir = DateTime::createFromFormat('d F Y', $akhir)->format('Y-m-d');

            return Excel::download(new PeminjamanExport($awal, $akhir), "{$awal}_{$akhir}-peminjaman.xlsx");
        } else {
            $tanggal = $this->convertMonthToEnglish($request->tanggal);
            $tanggal = DateTime::createFromFormat('d F Y', $tanggal)->format('Y-m-d');

            return Excel::download(new PeminjamanExport($tanggal, null), "{$tanggal}-peminjaman.xlsx");
        }
    }

    public function export_pengembalian(Request $request)
    {
        if (str_contains($request->tanggal, '-')) {
            $tanggal = explode(" - ", $request->tanggal);
            $awal = $this->convertMonthToEnglish($tanggal[0]);
            $akhir = $this->convertMonthToEnglish($tanggal[1]);

            $awal = DateTime::createFromFormat('d F Y', $awal)->format('Y-m-d');
            $akhir = DateTime::createFromFormat('d F Y', $akhir)->format('Y-m-d');

            return Excel::download(new PengembalianExport($awal, $akhir), "{$awal}_{$akhir}-pengembalian.xlsx");
        } else {
            $tanggal = $this->convertMonthToEnglish($request->tanggal);
            $tanggal = DateTime::createFromFormat('d F Y', $tanggal)->format('Y-m-d');

            return Excel::download(new PengembalianExport($tanggal, null), "{$tanggal}-pengembalian.xlsx");
        }
    }

    public function export_all(Request $request)
    {
        if (str_contains($request->tanggal, '-')) {
            $tanggal = explode(" - ", $request->tanggal);
            $awal = $this->convertMonthToEnglish($tanggal[0]);
            $akhir = $this->convertMonthToEnglish($tanggal[1]);

            $awal = DateTime::createFromFormat('d F Y', $awal)->format('Y-m-d');
            $akhir = DateTime::createFromFormat('d F Y', $akhir)->format('Y-m-d');

            return Excel::download(new AllExport($awal, $akhir), "{$awal}_{$akhir}-all.xlsx");
        } else {
            $tanggal = $this->convertMonthToEnglish($request->tanggal);
            $tanggal = DateTime::createFromFormat('d F Y', $tanggal)->format('Y-m-d');

            return Excel::download(new AllExport($tanggal, null), "{$tanggal}-all.xlsx");
        }
    }
}
