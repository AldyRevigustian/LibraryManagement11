<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID'); // Gunakan Faker Indonesia
        return [
            'nim' => mt_rand(2500000000, 2899999999),
            'nama' => $faker->name, // Nama dalam bahasa Indonesia
            'email' => strtolower($faker->unique()->userName . rand(1000, 9999) . '@binus.ac.id'),
            'password' => Hash::make('password123'), // Hash satu kali untuk efisiensi
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
