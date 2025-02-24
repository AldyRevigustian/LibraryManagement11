<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Peminjaman::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $userIds = Anggota::pluck('id')->toArray();
        $bukuIds = Buku::pluck('id')->toArray();

        if (empty($userIds) || empty($bukuIds)) {
            throw new \Exception('Tidak ada Anggota atau Buku di database. Jalankan seeder Anggota dan Buku terlebih dahulu.');
        }

        $tanggalPeminjaman = $faker->dateTimeBetween('-1 year', 'now');
        $tanggalPengembalian = $faker->boolean(70)
            ? (clone $tanggalPeminjaman)->modify('+' . rand(3, 14) . ' days')->format('Y-m-d')
            : null;


        return [
            'anggota_id' => $faker->randomElement($userIds),
            'buku_id' => $faker->randomElement($bukuIds),
            'tanggal_peminjaman' => $tanggalPeminjaman->format('Y-m-d'),
            'tanggal_pengembalian' => $tanggalPengembalian,
            'denda' => $tanggalPengembalian === null ? null : rand(0, 50000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
