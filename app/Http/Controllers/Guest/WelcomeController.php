<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $bukus = Buku::inRandomOrder()->limit(12)->get();

        $fiksis = Buku::whereHas('kategori', function ($query) {
            $query->where('nama', 'Fiksi');
        })->inRandomOrder()->limit(12)->get();

        $pengembangans = Buku::whereHas('kategori', function ($query) {
            $query->where('nama', 'Pengembangan Diri');
        })->inRandomOrder()->limit(12)->get();

        $komiks = Buku::whereHas('kategori', function ($query) {
            $query->where('nama', 'Komik & Novel Grafis');
        })->inRandomOrder()->limit(12)->get();

        $bisnises = Buku::whereHas('kategori', function ($query) {
            $query->where('nama', 'Bisnis & Ekonomi');
        })->inRandomOrder()->limit(12)->get();

        $penerbits = Penerbit::all();
        return view('guest.welcome', compact('bukus', 'fiksis', 'pengembangans', 'komiks', 'bisnises', 'penerbits'));
    }
}
