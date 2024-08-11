<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kriteria::create([
            "kriteria" => "Kondisi Eksternal",
            "butir" => "A",
            "kuantitatif" => false
        ]);

        Kriteria::create([
            "kriteria" => "Profil Unit Pengelola Program Studi",
            "butir" => "B",
            "kuantitatif" => false
        ]);

        Kriteria::create([
            "kriteria" => "Visi, Misi, Tujuan dan Strategi",
            "butir" => "C 1.",
            "kuantitatif" => false
        ]);

        Kriteria::create([
            "kriteria" => "Tata Pamong, Tata Kelola, dan Kerjasama",
            "butir" => "C 2.",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Mahasiswa",
            "butir" => "C 3.",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Sumber Daya Manusia",
            "butir" => "C 4.",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Keuangan, Sarana dan Prasarana",
            "butir" => "C 5.",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Pendidikan",
            "butir" => "C 6.",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Penelitian",
            "butir" => "C 7.",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Pengabdian kepada Masyarakat",
            "butir" => "C 8.",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Luaran dan Capaian Tridharma",
            "butir" => "C 9.",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Penjaminan Mutu",
            "butir" => "D",
            "kuantitatif" => true
        ]);

        Kriteria::create([
            "kriteria" => "Program Pengembangan Berkelanjutan",
            "butir" => "E"
        ]);
    }
}
