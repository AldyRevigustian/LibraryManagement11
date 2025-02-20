<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::find($request->id);
        $rekomendasi = Buku::where('kategori_id', $buku->kategori_id)->inRandomOrder()->limit(12)->get();
        return view('guest.detail', compact('buku', 'rekomendasi'));
    }
}
