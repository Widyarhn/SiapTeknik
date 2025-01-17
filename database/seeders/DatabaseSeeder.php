<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        // $this->call(UserProgramStudiSeeder::class);
        // $this->call(TahunSeeder::class);
        // $this->call(TimelineSeeder::class);
        $this->call(JenjangSeeder::class);
        $this->call(KriteriaSeeder::class);
        $this->call(ProgramStudiSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(LabelD3Seeder::class);
        $this->call(LabelD4Seeder::class);
        $this->call(AnotasiLabelSeeder::class);
    }
}
