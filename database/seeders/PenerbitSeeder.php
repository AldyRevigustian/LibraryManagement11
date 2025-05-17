<?php

namespace Database\Seeders;

use App\Models\Penerbit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenerbitSeeder extends Seeder
{
    public function run(): void
    {
        Penerbit::create([
            'nama' => 'Gramedia Pustaka Utama',
            'logo' => "/storage/penerbit/1.jpg",
        ]);
        Penerbit::create([
            'nama' => 'Gramedia Widiasarana Indonesia',
            'logo' => "/storage/penerbit/2.jpg",
        ]);
        Penerbit::create([
            'nama' => 'Bhuana Ilmu Populer',
            'logo' => "/storage/penerbit/3.jpg",
        ]);
        Penerbit::create([
            'nama' => 'Elex Media Komputindo',
            'logo' => "/storage/penerbit/4.jpg",
        ]);
        Penerbit::create([
            'nama' => 'm&c!',
            'logo' => "/storage/penerbit/5.jpg",
        ]);
        Penerbit::create([
            'nama' => 'Kepustakaan Populer Gramedia',
            'logo' => "/storage/penerbit/6.jpg",
        ]);
        Penerbit::create([
            'nama' => 'Phoenix Gramedia Indonesia',
            'logo' => "/storage/penerbit/7.jpg",
        ]);
    }
}
