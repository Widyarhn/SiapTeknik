<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            "role" => "Asesor"
        ]);
        Role::create([
            "role" => "Prodi"
        ]);
        Role::create([
            "role" => "UPPS"
        ]);
    }
}
