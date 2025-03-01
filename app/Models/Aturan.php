<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    protected $table = 'aturan';
    protected $fillable = [
        'maksimal_buku',
        'batas_pengembalian',
        'denda',
    ];
}
