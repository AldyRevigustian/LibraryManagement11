<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'password' => Hash::make("Admin123"),
        ]);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => Hash::make("Aldey"),
        // ]);
    }
}
