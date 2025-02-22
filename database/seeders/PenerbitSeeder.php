<?php

namespace Database\Seeders;

use App\Models\Penerbit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenerbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penerbit::create([
            'nama' => 'Gramedia Pustaka Utama',
        ]);
        Penerbit::create([
            'nama' => 'Gramedia Widiasarana Indonesia',
        ]);
        Penerbit::create([
            'nama' => 'Bhuana Ilmu Populer',
        ]);
        Penerbit::create([
            'nama' => 'Elex Media Komputindo',
        ]);
        Penerbit::create([
            'nama' => 'm&c!',
        ]);
        Penerbit::create([
            'nama' => 'Kepustakaan Populer Gramedia',
        ]);
        Penerbit::create([
            'nama' => 'Phoenix Gramedia Indonesia',
        ]);
    }
}
