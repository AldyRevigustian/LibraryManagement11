<?php

namespace Database\Seeders;

use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Superadmin',
            'email' => 'super.admin@admin.com',
            'password' => Hash::make("superadmin"),
            'role' => 'superadmin'
        ]);

        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make("admin"),
            'role' => 'admin'
        ]);
    }
}
