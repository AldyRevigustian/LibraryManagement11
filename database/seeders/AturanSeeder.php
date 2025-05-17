<?php

namespace Database\Seeders;

use App\Models\Aturan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AturanSeeder extends Seeder
{
    public function run(): void
    {
        Aturan::create([
            'maksimal_buku' => 3,
            'batas_pengembalian' => 7,
            'denda' => 5000,
        ]);
    }
}
