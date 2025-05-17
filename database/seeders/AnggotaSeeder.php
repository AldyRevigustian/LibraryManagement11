<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        Anggota::create([
            'nim' => 2702303715,
            'nama' => 'Aldy Revigustian',
            'email' => 'aldy@binus.ac.id',
            'password' => Hash::make("Akunbaru123*"),
            'foto' => "/assets/images/faces/2.jpg",
        ]);
        Anggota::factory()->count(499)->create();
    }
}
