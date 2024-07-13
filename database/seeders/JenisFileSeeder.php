<?php

namespace Database\Seeders;
use App\Models\JenisFile;
use Illuminate\Database\Seeder;

class JenisFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisFile::create([
            "jenis_file" => "LED"
        ]);
        JenisFile::create([
            "jenis_file" => "LKPS"
        ]);
        JenisFile::create([
            "jenis_file" => "Data dukung"
        ]);
        JenisFile::create([
            "jenis_file" => "Lainnya"
        ]);
    }
}
