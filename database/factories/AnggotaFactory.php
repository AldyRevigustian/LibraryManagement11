<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AnggotaFactory extends Factory
{
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID'); 
        return [
            'nim' => mt_rand(2500000000, 2899999999),
            'nama' => $faker->name,
            'email' => strtolower($faker->unique()->userName . rand(1000, 9999) . '@binus.ac.id'),
            'password' => Hash::make('password123'),
            'foto' => "/assets/images/faces/" .  mt_rand(1, 8) . ".jpg",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
