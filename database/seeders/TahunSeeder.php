<?php

namespace Database\Seeders;

use App\Models\Tahun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tahun::create([
            "tahun" => "2024",
            "is_active" => false,
            "mulai_akreditasi" => "2024-01-01",
        ]);
    }
}
