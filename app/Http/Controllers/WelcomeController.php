<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $komputers = Buku::whereHas('kategori', function ($query) {
            $query->where('nama', 'Komputer');
        })->inRandomOrder()->limit(12)->get();

        $bisnises = Buku::whereHas('kategori', function ($query) {
            $query->where('nama', 'Bisnis & Ekonomi');
        })->inRandomOrder()->limit(12)->get();

        return view('welcome', compact('bukus', 'fiksis', 'pengembangans', 'komiks', 'bisnises', 'komputers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
