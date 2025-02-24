<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    use HasFactory;

    protected $table = 'anggotas';
    protected $fillable = [
        'nim',
        'name',
        'email',
        'password',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function favorite()
    {
        return $this->belongsToMany(Buku::class, 'favorites', 'anggota_id', 'buku_id')->withTimestamps();
    }

    public function isFavorite($bukuId)
    {
        return $this->favorite()->wherePivot('buku_id', $bukuId)->first();
    }
}
