<?php

namespace Database\Seeders;

use App\Models\AnotasiLabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnotasiLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AnotasiLabel::insert([
            [
                "jenjang_id" => "1",
                "rumus_label" => "10.A",
                "anotasi" => "RK = ((a x N1) + (b x N2) + (c x N3)) / NDTPS	Faktor: a = 2 , b = 1 , c = 3 
                                N1 = Jumlah kerjasama pendidikan. 
                                N2 = Jumlah kerjasama penelitian. 
                                N3 = Jumlah kerjasama PkM. 
                                NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti 
                                program studi yang diakreditasi.",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "10.B",
                "anotasi" => "NI = Jumlah kerjasama tingkat internasional.	Faktor: a = 1 , b = 4 , c = 6 NN = Jumlah kerjasama tingkat nasional. 
                                NW = Jumlah kerjasama tingkat wilayah/lokal. A=NI/a; B=NN/b; C=NW/c 
                                Jika NI ≥ a dan NN < b, maka NI = a Jika NI < a dan NN ≥ b, maka NN = b Jika NW ≥ c, maka NW = c",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "13.B",
                "anotasi" => "Jika Rasio ≥ 3 , maka B = 4 Jika Rasio < 3 , maka B = (4 x Rasio) / 3",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "15",
                "anotasi" => "NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti 
                                program studi yang diakreditasi. 
                                NDTT = Jumlah dosen tidak tetap yang ditugaskan sebagai pengampu mata kuliah di program studi yang diakreditasi. NDT = Jumlah dosen 
                                tetap yang ditugaskan sebagai pengampu mata kuliah di program studi yang diakreditasi. 
                                PDTT = (NDTT / (NDT + NDTT)) x 100% 
                                A= ((NDTPS-5)/7) 
                                B = (40%-PDTT)/40%, Jika PDTT ≤ 40% 
                                B = (40%-PDTT)/30%, Jika 10% < PDTT ≤ 40% ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "16",
                "anotasi" => "NDS3 = Jumlah DTPS yang berpendidikan tertinggi Doktor/Doktor Terapan/Subspesialis. 
                            NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. 
                            PDS3 = (NDS3 / NDTPS) x 100% ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "17",
                "anotasi" => "NDSK = Jumlah DTPS yang memiliki sertifikat kompetensi/profesi/industri. 
                            NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. 
                            PDSK = (NDSK / NDTPS) x 100% ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "18",
                "anotasi" => "NDGB = Jumlah DTPS yang memiliki jabatan akademik Guru Besar. NDLK = Jumlah DTPS yang memiliki jabatan akademik Lektor Kepala. NDL = Jumlah DTPS yang memiliki jabatan akademik Lektor. 
                            NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. 
                            PGBLKL = ((NDGB + NDLK + NDL) / NDTPS) x 100% ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "19",
                "anotasi" => "NM = Jumlah mahasiswa pada saat TS. 
                        NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. 
                        RMD = NM / NDTPS ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "20",
                "anotasi" => "Jika 6 < RDPU ≤ 10 , 
                    maka Skor = 7 - (RDPU / 2),RDPU = Rata-rata jumlah bimbingan sebagai pembimbing utama di seluruh program/ semester. ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "21",
                "anotasi" => "Jika EWMP=14, maka skor 4 	Jika 12 ≤ EWMP < 14 Maka Skor = ((3 x EWMP)-34)/2 Jika 14 < EWMP ≤ 16 Maka Skor = (50- (3 x EWMP))/2 	Jika EWMP < 12 
                    atau EWMP > 16, maka Skor = 0 ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "22",
                "anotasi" => "NDTT = Jumlah dosen tidak tetap yang ditugaskan sebagai pengampu mata kuliah di program studi yang diakreditasi. 
                    NDT = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah di program studi yang diakreditasi. PDTT = (NDTT / (NDT + NDTT)) x 100% ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "23",
                "anotasi" => "MKKI = Jumlah mata kuliah kompetensi yang diampu oleh dosen industri/praktisi. MKK = Jumlah mata kuliah kompetensi 
                    PMKI = (MKKI / MKK) x 100% ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "24",
                "anotasi" => "Pengakuan/rekognisi atas kepakaran/prestasi/kinerja DTPS dapat berupa: 
                            a)	menjadi visiting lecturer atau visiting scholar di program studi/perguruan tinggi terakreditasi A/Unggul atau program studi/perguruan tinggi internasional bereputasi. 
                            b)	menjadi keynote speaker/invited speaker pada pertemuan ilmiah tingkat nasional/ internasional. 
                            c)	menjadi editor atau mitra bestari pada jurnal nasional terakreditasi/jurnal internasional bereputasi di bidang yang sesuai dengan bidang program studi. 
                            d)	menjadi staf ahli/narasumber di lembaga tingkat wilayah/nasional/internasional pada bidang yang sesuai dengan bidang program studi (untuk pengusul dari program studi pada program Sarjana/Magister/Doktor), atau menjadi tenaga ahli/konsultan di lembaga/industri tingkat wilayah/nasional/ internasional pada bidang yang sesuai dengan bidang program studi (untuk pengusul dari program studi pada program Diploma Tiga/Sarjana Terapan/Magister Terapan/Doktor Terapan). 
                            e)	mendapat penghargaan atas prestasi dan kinerja di tingkat wilayah/nasional/internasional. 
                            
                            RRD = NRD / NDTPS 
                            NRD = Jumlah pengakuan atas prestasi/kinerja DTPS yang relevan dengan bidang keahlian dalam 3 tahun terakhir. 
                            NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "25",
                "anotasi" => "RI = NI / 3 / NDTPS , RN = NN / 3 / NDTPS , RL = NL / 3 / NDTPS	Faktor: a = 0,05 , b = 0,3 , c = 1 NI = Jumlah penelitian dengan sumber pembiayaan luar negeri dalam 3 tahun terakhir. 
                            NN = Jumlah penelitian dengan sumber pembiayaan dalam negeri dalam 3 tahun terakhir. NL = Jumlah penelitian dengan sumber pembiayaan PT/ mandiri dalam 3 tahun terakhir. 
                            NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. 
                            A=RI/a; B=RN/b; C=RL/c 
                            Jika RI ≥ a dan RN < b, maka RI = a Jika RI < a dan RN ≥ b, maka RN = b Jika RL≥ c , maka RL = c ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "26",
                "anotasi" => "RI = NI / 3 / NDTPS , RN = NN / 3 / NDTPS , RL = NL / 3 / NDTPS	Faktor: a = 0,05 , b = 0,3 , c = 1 
                            NI = Jumlah PkM dengan sumber pembiayaan luar negeri dalam 3 tahun terakhir. NN = Jumlah PkM dengan sumber pembiayaan dalam negeri dalam 3 tahun terakhir. NL = Jumlah PkM dengan sumber pembiayaan PT/ mandiri dalam 3 tahun terakhir. 
                            NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. 
                            A=RI/a; B=RN/b; C=RL/c 
                            Jika RI ≥ a dan RN < b, maka RI = a 
                            Jika RI < a dan RN ≥ b, maka RN = b Jika RL ≥ c , maka RL = c ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "27",
                "anotasi" => "RW = (NA1 + NB1 + NC1) / NDTPS , RN = (NA2 + NA3 + NB2 + NC2) / NDTPS , RI = (NA4 + NB3 + NC3) / NDTPS Faktor: a = 0,05,b = 0,5 , c = 1 
                        NA1 = Jumlah publikasi di jurnal nasional tidak terakreditasi. NA2 = Jumlah publikasi di jurnal nasional terakreditasi. NA3 = Jumlah publikasi di jurnal internasional. 
                        NA4 = Jumlah publikasi di jurnal internasional bereputasi. NB1 = Jumlah publikasi di seminar wilayah/lokal/PT. NB2 = Jumlah publikasi di seminar nasional. 
                        NB3 = Jumlah publikasi di seminar internasional. 
                        NC1 = Jumlah pagelaran/pameran/presentasi dalam forum di tingkat wilayah. NC2 = Jumlah pagelaran/pameran/presentasi dalam forum di tingkat nasional. NC3 = Jumlah pagealran/pameran/presentasi dalam forum di tingkat internasional. 
                        NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. 
                        A=RI/a; B=RN/b; C=RW/c 
                        Jika RI ≥ a dan RN < b, maka RI = a 
                        Jika RI < a dan RN ≥ b, maka RN = b Jika RW ≥ c , maka RW = c ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "28",
                "anotasi" => "RS = NAPJ / NDTPS 
                        NAPJ = Jumlah produk/jasa yang diadopsi oleh industri/masyarakat dalam 3 tahun terakhir. 
                        NDTPS = Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi. ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "29",
                "anotasi" => "RLP = (2 x (NA + NB + NC) + ND) / NDTPS 
                        NA = Jumlah luaran penelitian/PkM yang mendapat pengakuan HKI (Paten, Paten Sederhana) 
                        NB = Jumlah luaran penelitian/PkM yang mendapat pengakuan HKI (Hak Cipta, Desain Produk Industri, Desain Tata Letak Sirkuit Terpadu, dll.) NC = Jumlah luaran penelitian/PkM dalam bentuk Teknologi Tepat Guna, Produk (Produk Terstandarisasi, Produk Tersertifikasi) ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "32",
                "anotasi" => "DOP = Rata-rata dana operasional pendidikan/mahasiswa/ tahun dalam 3 tahun terakhir (dalam rupiah penuh). ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "33",
                "anotasi" => "DPD = Rata-rata dana penelitian DTPS/ tahun dalam 3 tahun terakhir (dalam rupiah penuh). ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "34",
                "anotasi" => "DPkMD = Rata-rata dana PkM DTPS/ tahun dalam 3 tahun terakhir (dalam rupiah penuh). ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "42",
                "anotasi" => "JP = Jam pembelajaran praktikum, praktik studio, praktik bengkel, atau praktik lapangan (termasuk KKN) JB = Jam pembelajaran total selama masa pendidikan. 
                        PJP = (JP / JB) x 100% ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "45",
                "anotasi" => "NMKI = Jumlah mata kuliah yang dikembangkan berdasarkan hasil penelitian/PkM DTPS dalam 3 tahun terakhir.",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "47. A",
                "anotasi" => "Tingkat kepuasan pengguna pada aspek: 
                        TKM1: Reliability; TKM2: Responsiveness; TKM3: Assurance; TKM4: Empathy; TKM5: Tangible. 
                        Tingkat kepuasan mahasiswa pada aspek ke-i dihitung dengan rumus sebagai berikut: TKMi = (4 x ai) + (3 x bi) + (2 x ci) + di i = 1, 2,	, 7 
                        dimana : ai = persentase “Sangat Baik”; bi = persentase “Baik”; ci = persentase “Cukup”; di = persentase “Kurang”. 
                        TKM = ƩTKMi / 5 ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "50",
                "anotasi" => "NPkMM = Jumlah judul PkM DTPS yang dalam pelaksanaannya melibatkan mahasiswa program studi dalam 3 tahun terakhir. NPkMD = Jumlah judul PkM DTPS dalam 3 tahun terakhir. 
                        PPkMDM = (NPkMM / NPkMD) x 100% ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "52",
                "anotasi" => "RIPK = Rata-rata IPK lulusan dalam 3 tahun terakhir.",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "53",
                "anotasi" => "Prestasi mahasiswa di bidang AKADEMIK.",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "54",
                "anotasi" => "Prestasi mahasiswa di bidang NONAKADEMIK.",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "55",
                "anotasi" => "MS = Rata-rata masa studi lulusan (tahun).",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "56",
                "anotasi" => "PTW = Persentase kelulusan tepat waktu.",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "57",
                "anotasi" => "Persentase mahasiswa yang DO atau mengundurkan diri (MDO).",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "59",
                "anotasi" => "WT = waktu tunggu lulusan untuk mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 s.d. TS-2. ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "60",
                "anotasi" => "Jika PBS ≥ 80%, maka Skor = 4 ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "61",
                "anotasi" => "RI = (NI / NL) x 100% , RN = (NN / NL) x 100% , RW = (NW / NL) x 100%	Faktor: a = 5% , b = 20% , c = 90% . NI = Jumlah lulusan yang bekerja di badan usaha tingkat multi nasional/internasional. 
                    NN = Jumlah lulusan yang bekerja di badan usaha tingkat nasional atau berwirausaha yang berizin. 
                    NW = Jumlah lulusan yang bekerja di badan usaha tingkat wilayah/lokal atau berwirausaha tidak berizin. NL = Jumlah lulusan. 
                    A=RI/a; B=RN/b; C=RW/c 
                    Jika RI ≥ a dan RN < b, maka RI = a 
                    Jika RI < a dan RN ≥ b, maka RN = b Jika RW ≥ c, maka RW = c ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "62",
                "anotasi" => "Tingkat kepuasan aspek ke-i dihitung dengan rumus sebagai berikut: TKi = (4 x ai) + (3 x bi) + (2 x ci) + di i = 1, 2,	, 7 
                        ai = persentase “sangat baik”. bi = persentase “baik”. 
                        ci = persentase “cukup”. 
                        di = persentase “kurang”. ",
            ],
            [
                "jenjang_id" => "1",
                "rumus_label" => "63",
                "anotasi" => "NAPJ = Jumlah produk/jasa karya mahasiswa yang diadopsi oleh industri/masyarakat dalam 3 tahun terakhir.",
            ],
        ]);

        //d4
        AnotasiLabel::insert([
            [
                "jenjang_id" => "2",
                "rumus_label" => "10.A",
                "anotasi" => "RK = ((a x N1) + (b x N2) + (c x N3)) / NDTPS Faktor: a = 3 , b = 1 , c = 2",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "10.B",
                "anotasi" => "NI = Jumlah kerjasama tingkat internasional.	Faktor: a = 1 , b = 4 , c = 6 NN = Jumlah kerjasama tingkat nasional. 
                                NW = Jumlah kerjasama tingkat wilayah/lokal. A=NI/a; B=NN/b; C=NW/c 
                                Jika NI ≥ a dan NN < b, maka NI = a Jika NI < a dan NN ≥ b, maka NN = b Jika NW ≥ c, maka NW = c",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "13.B",
                "anotasi" => "Jika Rasio ≥ 4 , maka B = 4 Jika Rasio < 4 , maka B = (4 x Rasio) / 4 .",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "14.B",
                "anotasi" => "Jika PMA ≥ 1% , maka B = 4 ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "16",
                "anotasi" => "PDTT = (NDTT / (NDT + NDTT)) x 100% ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "17",
                "anotasi" => "Jika PDS3 ≥ 15% , skor = 4",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "18",
                "anotasi" => "Jika PDSK ≥ 50% , maka Skor = 4",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "19",
                "anotasi" => "Jika PGBLKL ≥ 50% , maka Skor = 4 ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "20",
                "anotasi" => "Jika 15 ≤ RMD ≤ 25 ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "21",
                "anotasi" => "RDPU = Rata-rata jumlah bimbingan sebagai pembimbing utama di seluruh program/ semester. ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "22",
                "anotasi" => "Ekuivalensi Waktu Mengajar Penuh DTPS. ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "23",
                "anotasi" => "PDTT = (NDTT / (NDT + NDTT)) x 100% ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "24",
                "anotasi" => "PMKI = (MKKI / MKK) x 100%",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "25",
                "anotasi" => "Jika RRD ≥ 0,5 , maka Skor = 4 . ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "26",
                "anotasi" => "Jika RI > a dan RN > b maka Skor = 4 ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "27",
                "anotasi" => "Faktor: a = 0,05 , b = 0,3 , c = 1 
                NI = Jumlah PkM dengan sumber pembiayaan luar negeri dalam 3 tahun terakhir. ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "28",
                "anotasi" => " Faktor: a = 0,1 ,b= 1 , c = 2 
                NA1 = Jumlah publikasi di jurnal nasional tidak terakreditasi.",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "29",
                "anotasi" => "RS = NAS / NDTPS",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "30",
                "anotasi" => "RS = NAPJ / NDTPS ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "31",
                "anotasi" => "RLP = (2 x (NA + NB + NC) + ND) / NDTPS",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "34",
                "anotasi" => "DOP = Rata-rata dana operasional pendidikan/mahasiswa/ tahun dalam 3 tahun terakhir (dalam rupiah penuh).",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "35",
                "anotasi" => "DPD = Rata-rata dana penelitian DTPS/ tahun dalam 3 tahun terakhir (dalam rupiah penuh). ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "36",
                "anotasi" => "DPkMD = Rata-rata dana PkM DTPS/ tahun dalam 3 tahun terakhir (dalam rupiah penuh).  ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "44",
                "anotasi" => "PJP = (JP / JB) x 100% ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "50",
                "anotasi" => "NMKI > 3 ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "52",
                "anotasi" => "TKM ≥ 75%",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "54",
                "anotasi" => "PPDM = (NPM / NPD) x 100% ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "56",
                "anotasi" => "PPkMDM = (NPkMM / NPkMD) x 100% ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "58",
                "anotasi" => "Jika RIPK ≥ 3,25",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "59",
                "anotasi" => "Faktor: a = 0,1% , b = 1% , c = 2% NI = Jumlah prestasi akademik internasional.",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "60",
                "anotasi" => "Jika RI > a dan RN > b",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "61",
                "anotasi" => "Jika 3,5 < MS ≤ 4,5 , maka Skor = 4",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "62",
                "anotasi" => "PTW = Persentase kelulusan  tepat waktu. ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "63",
                "anotasi" => "Jika 6% < MDO < 45%, maka skor = [180 – (400 x MDO)] / 39.",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "65",
                "anotasi" => "Jika WT < 3 bulan, ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "66",
                "anotasi" => "Jika PBS ≥ 60% , ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "67",
                "anotasi" => "RI = (NI / NL) x 100% , RN = (NN / NL) x 100% , RW = (NW / NL) x 100% ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "68",
                "anotasi" => "Skor = STKi / 7  ",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "69",
                "anotasi" => "RL = ((NA1 + NB1 + NC1) / NM) x 100% , RN = ((NA2 + NA3 + NB2 + NC2) / NM) x 100% , RI = ((NA4 + NB3 + NC3) / NM) x 100%",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "70",
                "anotasi" => "Jika NAPJ ≥ 2 ,",
            ],
            [
                "jenjang_id" => "2",
                "rumus_label" => "71",
                "anotasi" => "NLP = 2 x (NA + NB + NC) + ND ",
            ],
        ]);
    }
}
