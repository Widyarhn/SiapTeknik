<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "nama" => "Joe",
            "email" => "upps@gmail.com",
            "password" => bcrypt("password"),
            "role_id" => "3"
        ]);
        User::create([
            "nama" => "Yupi",
            "email" => "prodi@gmail.com",
            "password" => bcrypt("password"),
            "role_id" => "2"
        ]);
        User::create([
            "nama" => "Georgious",
            "email" => "asesor@gmail.com",
            "password" => bcrypt("password"),
            "role_id" => "1"
        ]);
    }
}
