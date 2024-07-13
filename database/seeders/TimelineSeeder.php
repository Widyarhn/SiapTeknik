<?php

namespace Database\Seeders;

use App\Models\Timeline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Timeline::create([
            'tahun_id' => 1,
            'program_studi_id' => 1,
            'kegiatan' => 'Pengajuan Dokumen',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_akhir' => '2024-01-15',
            'status' => false,
        ]);
    }
}
