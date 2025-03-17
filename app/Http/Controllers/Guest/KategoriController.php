<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        $penerbits = Penerbit::all();
        return view('guest.kategori', compact('kategoris', 'penerbits'));
    }

    public function penerbit(Request $request)
    {
        $perPage = 25;
        $penerbit = Penerbit::find($request->id);
        $bukus = Buku::where('penerbit_id', $penerbit->id)->paginate($perPage);
        $tipe = 'penerbit';
        return view('guest.kategori_detail', compact('penerbit', 'bukus', 'tipe'));
    }

    public function kategori(Request $request)
    {
        $perPage = 25;
        $kategori = Kategori::find($request->id);
        $bukus = Buku::where('kategori_id', $kategori->id)->paginate($perPage);
        $tipe = 'kategori';
        return view('guest.kategori_detail', compact('kategori', 'bukus', 'tipe'));
    }
}
