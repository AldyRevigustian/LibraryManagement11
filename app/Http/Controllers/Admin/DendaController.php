<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aturan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function calculateDenda(Request $request)
    {
        $request->validate([
            'batas_pengembalian' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $batasPengembalian = Carbon::parse($request->batas_pengembalian);
        $tanggalPengembalian = Carbon::parse($request->tanggal_pengembalian);

        $isLate = $tanggalPengembalian->gt($batasPengembalian);
        $denda = 0;

        if ($isLate) {
            $hariTerlambat = $batasPengembalian->diffInDays($tanggalPengembalian);
            $denda = $hariTerlambat * Aturan::first()->denda;
        }

        return response()->json([
            'isLate' => $isLate,
            'denda' => $denda,
            'hariTerlambat' => $isLate ? $batasPengembalian->diffInDays($tanggalPengembalian) : 0,
            'batas_pengembalian' => $batasPengembalian->format('Y-m-d'),
        ]);
    }
}
