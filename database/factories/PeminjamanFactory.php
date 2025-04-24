<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Aturan;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $userIds = Anggota::pluck('id')->toArray();
        $bukuIds = Buku::pluck('id')->toArray();
        if (empty($userIds) || empty($bukuIds)) {
            throw new \Exception('Tidak ada Anggota atau Buku di database. Jalankan seeder Anggota dan Buku terlebih dahulu.');
        }

        $tanggalPeminjaman = Carbon::parse($faker->dateTimeBetween('2024-01-01', '2025-04-28'));
        $batasPengembalian = (clone $tanggalPeminjaman)->addDays(Aturan::first()->batas_pengembalian);

        // **Logika peminjaman yang belum dikembalikan:**
        // - Jika peminjaman terjadi di bulan 2025-02, ada 50% kemungkinan belum dikembalikan.
        // - Jika di luar bulan 2025-02, selalu dikembalikan.
        if ($tanggalPeminjaman->format('Y-m') === '2025-04' && $faker->boolean(50)) {
            $tanggalPengembalian = null;
        } else {
            $tanggalPengembalian = (clone $tanggalPeminjaman)->addDays(rand(3, 20));
        }

        if ($tanggalPengembalian && $tanggalPengembalian->gt($batasPengembalian)) {
            $hariTerlambat = $batasPengembalian->diffInDays($tanggalPengembalian);
            $denda = $hariTerlambat * Aturan::first()->denda;
        } else {
            $denda = 0;
        }


        return [
            'anggota_id' => $faker->randomElement($userIds),
            'buku_id' => $faker->randomElement($bukuIds),
            'tanggal_peminjaman' => $tanggalPeminjaman->format('Y-m-d'),
            'batas_pengembalian' => $batasPengembalian->format('Y-m-d'),
            'tanggal_pengembalian' => $tanggalPengembalian ? $tanggalPengembalian->format('Y-m-d') : null,
            'denda' => $denda > 0 ? $denda : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
