<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

class BukuController extends Controller
{
    use Searchable;

    public function detail(Request $request)
    {
        $buku = Buku::find($request->id);
        $rekomendasi = Buku::where('kategori_id', $buku->kategori_id)->inRandomOrder()->limit(12)->get();
        return view('guest.detail', compact('buku', 'rekomendasi'));
    }

    public function search(Request $request)
    {
        $perPage = 30; // Jumlah buku per halaman

        if ($request->query('search')) {
            $query = $request->query('search');
            $bukus = Buku::search($query)->paginate($perPage);
        } else {
            $query = 'ALL';
            $bukus = Buku::inRandomOrder()->paginate($perPage);
        }

        return view('guest.search', compact('bukus', 'query'));
    }

}
