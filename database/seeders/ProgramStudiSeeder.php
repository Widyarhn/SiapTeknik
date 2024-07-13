<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProgramStudi::create([
            "nama" => "Teknik Mesin",
            "jenjang_id" => "1"
        ]);

        ProgramStudi::create([
            "nama" => "Teknik Pendingin dan Tata Udara",
            "jenjang_id" => "1"
        ]);

        ProgramStudi::create([
            "nama" => "Perancangan Manufaktur",
            "jenjang_id" => "2"
        ]);

        ProgramStudi::create([
            "nama" => "Teknologi Rekayasa Instrumentasi dan Kontrol",
            "jenjang_id" => "2"
        ]);
    }
}
