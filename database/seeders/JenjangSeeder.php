<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use Illuminate\Database\Seeder;

class JenjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jenjang::create([
            "jenjang" => "D3"
        ]);
        Jenjang::create([
            "jenjang" => "D4"
        ]);
    }
}
