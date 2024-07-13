<?php

namespace Database\Seeders;

use App\Models\UserProdi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProdi::create([
            "user_id" => 2,
            "tahun_id" => 1,
            "program_studi_id" => 1,
            "jenjang_id" => 1,
        ]);
    }
}
