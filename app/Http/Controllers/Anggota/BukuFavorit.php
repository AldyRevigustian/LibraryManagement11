<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuFavorit extends Controller
{
    public function index()
    {
        $perPage = 30;
        $bukus = Buku::paginate($perPage);
        return view('anggota.favorit', compact('bukus'));
    }
}
