<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    protected $table = 'anggotas';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}
