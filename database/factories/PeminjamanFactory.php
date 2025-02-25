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
    protected $model = Peminjaman::class;
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $userIds = Anggota::pluck('id')->toArray();
        $bukuIds = Buku::pluck('id')->toArray();
        if (empty($userIds) || empty($bukuIds)) {
            throw new \Exception('Tidak ada Anggota atau Buku di database. Jalankan seeder Anggota dan Buku terlebih dahulu.');
        }
        $tanggalPeminjaman = $faker->dateTimeBetween('2024-01-01', '2025-02-28');
        if ($tanggalPeminjaman->format('Y-m') === '2025-02') {
            $tanggalPengembalian = null;
        } else {
            $tanggalPengembalian = (clone $tanggalPeminjaman)->modify('+' . rand(3, 14) . ' days');
            if ($tanggalPengembalian->format('Y-m') > '2025-02') {
                $tanggalPengembalian = null;
            }
        }
        return [
            'anggota_id' => $faker->randomElement($userIds),
            'buku_id' => $faker->randomElement($bukuIds),
            'tanggal_peminjaman' => $tanggalPeminjaman->format('Y-m-d H:i:s'),
            'tanggal_pengembalian' => $tanggalPengembalian ? $tanggalPengembalian->format('Y-m-d H:i:s') : null,
            'denda' => $tanggalPengembalian ? $faker->randomElement([0, 50000]) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
