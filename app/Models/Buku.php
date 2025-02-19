<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'ISBN',
        'judul',
        'kontributor',
        'kategori_id',
        'penerbit_id',
        'stok',
        'tahun_terbit',
        'deskripsi_fisik',
        'deskripsi',
        'foto'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class);
    }
}
