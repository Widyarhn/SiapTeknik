<?php

namespace Database\Seeders;

use App\Models\ListLkps;
use Illuminate\Database\Seeder;

class ListLkpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ListLkps::insert([
            [
                "kriteria_id" => 4,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 1 Kerjasama Tridharma Perguruan Tinggi - Pendidikan",
            ],
            [
                "kriteria_id" => 4,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 1 Kerjasama Tridharma Perguruan Tinggi - Penelitian",
            ],
            [
                "kriteria_id" => 4,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 1 Kerjasama Tridharma Perguruan Tinggi - Pengabdian",
            ],
            [
                "kriteria_id" => 5,
                "d3" => true,
                "d4" => false,
                "nama" => "Tabel 2.a.2) Seleksi Mahasiswa (D3)",
            ],
            [
                "kriteria_id" => 5,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 2.a.1) Seleksi Mahasiswa (S1/ S.Tr/ S2/ M.Tr/ S3/ D.Tr)",
            ],
            [
                "kriteria_id" => 5,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 2.b Mahasiswa Asing",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.a.1) Dosen Tetap Perguruan Tinggi",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.a.2) Dosen Pembimbing Utama Tugas Akhir",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.a.3) Ekuivalen Waktu Mengajar Penuh (EWMP) Dosen Tetap Perguruan Tinggi",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.a.4) Dosen Tidak Tetap",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => false,
                "nama" => "Tabel 3.a.5) Dosen Industri/Praktisi",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.b.1) Pengakuan/Rekognisi Dosen",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.b.2) Penelitian DTPS",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.b.3) Pengabdian kepada Masyarakat DTPS",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => false,
                "nama" => "Tabel 3.b.5) Pagelaran/Pameran/Presentasi/Publikasi Ilmiah DTPS",
            ],
            [
                "kriteria_id" => 6,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 3.b.6) Karya Ilmiah DTPS yang Disitasi",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => false,
                "nama" => "Tabel 3.b.7) Produk/Jasa DTPS yang Diadopsi oleh Industri/Masyarakat",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.b.8) Luaran Penelitian/PkM Lainnya - HKI (Paten, Paten Sederhana)",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.b.8) Luaran Penelitian/PkM Lainnya - HKI (Hak Cipta, Desain Produk Industri, dll.)",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.b.8) Luaran Penelitian/PkM Lainnya - Teknologi Tepat Guna, Produk, Karya Seni, Rekayasa Sosial",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.b.8) Luaran Penelitian/PkM Lainnya - Buku ber-ISBN, Book Chapter",
            ],
            [
                "kriteria_id" => 6,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 3.c Data Tenaga Kependidikan",
            ],
            [
                "kriteria_id" => 7,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 4.a Penggunaan Dana",
            ],
            [
                "kriteria_id" => 7,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 4.b Prasarana dan Peralatan Utama Lab di UPPS",
            ],
            [
                "kriteria_id" => 7,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 4.c Data Prasarana di UPPS",
            ],
            [
                "kriteria_id" => 8,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 5.a.1) Kurikulum, Capaian Pembelajaran, dan Rencana Pembelajaran",
            ],
            [
                "kriteria_id" => 8,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 5.a.3) Mata Kuliah Basic Science dan Matematika dalam Proses Pembelajaran",
            ],
            [
                "kriteria_id" => 8,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 5.a.4) Capstone Design dalam Proses Pembelajaran",
            ],
            [
                "kriteria_id" => 8,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 5.b.1) Beban Total Paket Perkuliahan untuk Belajar di Luar Program Studi < 20 SKS",
            ],
            [
                "kriteria_id" => 8,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 5.b.2) Beban Total Paket Perkuliahan untuk Belajar di Luar Program Studi antara 20 hingga 40 SKS",
            ],
            [
                "kriteria_id" => 8,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 5.b.3) Data Pelaksanaan Kegiatan Belajar dalam Kegiatan MBKM",
            ],
            [
                "kriteria_id" => 8,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 5.c Integrasi Kegiatan Penelitian/PkM dalam Pembelajaran",
            ],
            [
                "kriteria_id" => 8,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 5.d Kepuasan Mahasiswa",
            ],
            [
                "kriteria_id" => 9,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 6.a Penelitian DTPS yang Melibatkan Mahasiswa",
            ],
            [
                "kriteria_id" => 10,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 7 PkM DTPS yang Melibatkan Mahasiswa",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 8.a IPK Lulusan",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 8.b.1) Prestasi Akademik Mahasiswa",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 8.b.2) Prestasi Non-akademik Mahasiswa",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 8.c Masa Studi Lulusan Program Studi",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 8.d.1) Waktu Tunggu Lulusan",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 8.d.2) Kesesuaian Bidang Kerja Lulusan",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 8.e.1) Tempat Kerja Lulusan",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 8.e.2) Kepuasan Pengguna Lulusan",
            ],
            [
                "kriteria_id" => 11,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 8.f.2) Pagelaran/Pameran/Presentasi/Publikasi Ilmiah Mahasiswa",
            ],
            [
                "kriteria_id" => 11,
                "d3" => true,
                "d4" => false,
                "nama" => "Tabel 8.f.4) Produk/Jasa yang Dihasilkan Mahasiswa yang Diadopsi oleh Industri/Masyarakat",
            ],
            [
                "kriteria_id" => 11,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 8.f.5) Luaran Penelitian yang Dihasilkan Mahasiswa - HKI (Paten, Paten Sederhana)",
            ],
            [
                "kriteria_id" => 11,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 8.f.5) Luaran Penelitian yang Dihasilkan Mahasiswa - HKI (Hak Cipta, Desain Produk Industri, dll.)",
            ],
            [
                "kriteria_id" => 11,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 8.f.5) Luaran Penelitian yang Dihasilkan Mahasiswa -Teknologi Tepat Guna, Produk, Karya Seni, Rekayasa Sosial",
            ],
            [
                "kriteria_id" => 11,
                "d3" => false,
                "d4" => true,
                "nama" => "Tabel 8.f.5) Luaran Penelitian yang Dihasilkan Mahasiswa - Buku ber-ISBN, Book Chapter",
            ],
            [
                "kriteria_id" => 12,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 9.a) Evaluasi dan Pengendalian Sistem Mutu Internal",
            ],[
                "kriteria_id" => 12,
                "d3" => true,
                "d4" => true,
                "nama" => "Tabel 9.b) Ketersediaan Dokumen/Buku Sistem Penjaminan Mutu Internal",
            ],
        ]);
    }
}
