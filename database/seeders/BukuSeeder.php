<?php

namespace Database\Seeders;

use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BukuSeeder extends Seeder
{

    public function run(): void
    {
        $jsonFile = base_path('scrapper/products.json');
        $jsonData = json_decode(File::get($jsonFile), true);

        $jsonData = array_map(function ($item) {
            $item['created_at'] = Carbon::now();
            $item['updated_at'] = Carbon::now();
            return $item;
        }, $jsonData);

        DB::table('bukus')->insert($jsonData);
    }
}
