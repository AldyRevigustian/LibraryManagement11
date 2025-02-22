<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{

    public function run():   void
    {
        Anggota::create([
            'name' => 'aldy',
            'email' => 'aldy@anggota.com',
            'password' => Hash::make("aldy"),
        ]);
    }
}
