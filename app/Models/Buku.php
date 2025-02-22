<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Buku extends Model
{
    use Searchable;

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

    public function toSearchableArray()
    {
        return [
            'ISBN' => (int) $this->ISBN,
            'judul' => $this->judul,
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class);
    }
    public function isFavorite()
    {
        return $this->belongsToMany(Anggota::class, 'favorites', 'buku_id', 'anggota_id')->withTimestamps();
    }
    
}
