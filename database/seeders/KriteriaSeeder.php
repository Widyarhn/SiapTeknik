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
        ]);

        Kriteria::create([
            "kriteria" => "Profil Unit Pengelola
            Program Studi",
            "butir" => "B"
        ]);

        Kriteria::create([
            "kriteria" => "Visi, Misi, Tujuan dan Strategi",
            "butir" => "C 1."
        ]);

        Kriteria::create([
            "kriteria" => "Tata Pamong, Tata Kelola, dan Kerjasama",
            "butir" => "C 2."
        ]);

        Kriteria::create([
            "kriteria" => "Mahasiswa",
            "butir" => "C 3."
        ]);

        Kriteria::create([
            "kriteria" => "Sumber Daya Manusia",
            "butir" => "C 4."
        ]);

        Kriteria::create([
            "kriteria" => "Keuangan, Sarana dan Prasarana",
            "butir" => "C 5."
        ]);

        Kriteria::create([
            "kriteria" => "Pendidikan",
            "butir" => "C 6."
        ]);

        Kriteria::create([
            "kriteria" => "Penelitian",
            "butir" => "C 7."
        ]);

        Kriteria::create([
            "kriteria" => "Pengabdian kepada Masyarakat",
            "butir" => "C 8."
        ]);

        Kriteria::create([
            "kriteria" => "Luaran dan Capaian Tridharma",
            "butir" => "C 9."
        ]);

        Kriteria::create([
            "kriteria" => "Penjaminan Mutu",
            "butir" => "D"
        ]);

        Kriteria::create([
            "kriteria" => "Program Pengembangan Berkelanjutan",
            "butir" => "E"
        ]);
    }
}
