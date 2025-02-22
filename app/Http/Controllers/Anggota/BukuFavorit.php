<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuFavorit extends Controller
{
    public function index()
    {
        $anggota = Anggota::find(Auth::guard('anggota')->user()->id);
        $perPage = 30;
        $bukus = $anggota->favorite()->paginate($perPage);
        return view('anggota.favorite', compact('bukus'));
    }

    public function create(Request $request)
    {
        // dd($request->id);
        Favorite::create([
            'anggota_id' => Auth::guard('anggota')->user()->id,
            'buku_id' => $request->id
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $anggota = Anggota::find(Auth::guard('anggota')->user()->id);
        $buku = $anggota->isFavorite($request->id);
        $fav = Favorite::where('anggota_id', $anggota->id)->where('buku_id', $buku->id)->first();
        $fav->delete();

        return redirect()->back();
    }
}
