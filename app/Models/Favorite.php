<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'anggota_id',
        'buku_id',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
