<?php

namespace App\Http\Controllers;

use App\Models\LabelImport;
use App\Models\AnotasiLabel;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\AsesmenKecukupan;
use App\Services\FormulaEvaluator;

class PengolahanDataKuantitatifController extends Controller
{
    protected $evaluator;

    public function __construct(FormulaEvaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    public function calculate($id_prodi)
    {
        $programStudi = ProgramStudi::with('jenjang')->find($id_prodi);
        $jenjangName = $programStudi->jenjang->jenjang;
        $jenjangId = $programStudi->jenjang_id;

        if ($jenjangName == "D3") {
            $this->calculate10A($id_prodi, $jenjangId);
            $this->calculate10B($id_prodi, $jenjangId);
            $this->calculate13B($id_prodi, $jenjangId);
            $this->calculate15($id_prodi, $jenjangId);
            $this->calculate16($id_prodi, $jenjangId);
            $this->calculate17($id_prodi, $jenjangId);
            $this->calculate18($id_prodi, $jenjangId);
            $this->calculate19($id_prodi, $jenjangId);
            $this->calculate20($id_prodi, $jenjangId);
            $this->calculate21($id_prodi, $jenjangId);
            $this->calculate22($id_prodi, $jenjangId);
            $this->calculate23($id_prodi, $jenjangId);
            $this->calculate24($id_prodi, $jenjangId);
            $this->calculate25($id_prodi, $jenjangId);
            $this->calculate26($id_prodi, $jenjangId);
            $this->calculate27($id_prodi, $jenjangId);
            $this->calculate28($id_prodi, $jenjangId);
            $this->calculate29($id_prodi, $jenjangId);
            $this->calculate32($id_prodi, $jenjangId);
            $this->calculate33($id_prodi, $jenjangId);
            $this->calculate34($id_prodi, $jenjangId);
            $this->calculate42($id_prodi, $jenjangId);
            $this->calculate45($id_prodi, $jenjangId);
            $this->calculate47A($id_prodi, $jenjangId);
            $this->calculate50($id_prodi, $jenjangId);
            $this->calculate52($id_prodi, $jenjangId);
            $this->calculate53($id_prodi, $jenjangId);
            $this->calculate54($id_prodi, $jenjangId);
            $this->calculate55($id_prodi, $jenjangId);
            $this->calculate56($id_prodi, $jenjangId);
            $this->calculate57($id_prodi, $jenjangId);
            $this->calculate59($id_prodi, $jenjangId);
            $this->calculate60($id_prodi, $jenjangId);
            $this->calculate61($id_prodi, $jenjangId);
            $this->calculate62($id_prodi, $jenjangId);
            $this->calculate63($id_prodi, $jenjangId);
        } else {
            $this->calculateD410A($id_prodi, $jenjangId);
        }
        return redirect()->back()->with('success', 'Perhitungan dan penyimpanan data berhasil.');
    }



    public function calculate10A($id_prodi, $jenjangId)
    {
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        $rkVal = $labelImport->whereIn('label', ['N1', 'N2', 'N3', 'NDTPS'])->pluck('nilai', 'label');
        $rkFaktor = [
            'a' => 2,
            'b' => 1,
            'c' => 3,
        ];

        $rkVar = array_merge($rkFaktor, $rkVal->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $rk = $this->evaluator->evaluate('((a * N1) + (b * N2) + (c * N3)) / NDTPS', $rkVar);

        $rkOriginal = $rk['result']; // Akses langsung nilai result
        $rkConverted = floatval(str_replace(',', '.', $rkOriginal)); // Konversi menjadi float

        // // Debugging
        // dd([
        //     'Original' => $rkOriginal,
        //     'Converted' => $rkConverted,
        // ]);

        $nilai = ($rkConverted >= 4.0) ? 4.0 : $rkConverted;
        // $idMatriks = AnotasiLabel::where('rumus_label', '10.A')->first()->id;
        $anotasiLabel = AnotasiLabel::where('rumus_label', '10.A')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 10",
            ]
        );
    }

    public function calculate10B($id_prodi, $jenjangId)
    {
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Mengambil nilai untuk variabel NI, NN, NW
        $val = $labelImport->whereIn('label', ['NI1', 'NN1', 'NW1', 'NI2', 'NN2', 'NW2', 'NI3', 'NN3', 'NW3'])
            ->pluck('nilai', 'label');

        // Faktor-faktor
        $faktor = [
            'a' => 1.0,
            'b' => 4.0,
            'c' => 6.0,
        ];

        // Menggabungkan faktor dan nilai variabel
        $var = array_merge($faktor, $val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Menghitung nilai total NI, NN, NW
        $ni1 = $this->evaluator->evaluate('(NI1 + NI2 + NI3)', $var);
        $nn1 = $this->evaluator->evaluate('(NN1 + NN2 + NN3)', $var);
        $nw1 = $this->evaluator->evaluate('(NW1 + NW2 + NW3)', $var);
        $ni2 = $ni1['result'];
        $nn2 = $nn1['result'];
        $nw2 = $nw1['result'];
        $ni = floatval(str_replace(',', '.', $ni2)); // Konversi menjadi float
        $nn = floatval(str_replace(',', '.', $nn2)); // Konversi menjadi float
        $nw = floatval(str_replace(',', '.', $nw2)); // Konversi menjadi float
        // Kondisi untuk skor 4.0
        if ($ni > $faktor['a'] && $nn > $faktor['b']) {
            $nilai = 4.0;
        } else {
            // Koreksi nilai NI, NN, NW berdasarkan syarat
            $ni = min($ni, $faktor['a']);
            $nn = min($nn, $faktor['b']);
            $nw = min($nw, $faktor['c']);

            // Menghitung A, B, C
            $aVar = $ni / $faktor['a'];
            $bVar = $nn / $faktor['b'];
            $cVar = $nw / $faktor['c'];

            // Menghitung skor berdasarkan rumus
            $skor = 3.75 * (($aVar + $bVar + ($cVar / 2)) - ($aVar * $bVar) - (($aVar * $cVar) / 2) - (($bVar * $cVar) / 2) + (($aVar * $bVar * $cVar) / 2));
            // Konversi nilai skor menjadi float
            $nilai = floatval($skor);
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '10.B')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 10.B",
            ]
        );
    }

    public function calculate13B($id_prodi, $jenjangId)
    {
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Mengambil nilai untuk variabel NPendaftar dan NLolos
        $val = $labelImport->whereIn('label', ['NPendaftar', 'NLolos'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Menghitung rasio NPendaftar / NLolos
        $rasio = $this->evaluator->evaluate('(NPendaftar / NLolos)', $var);
        // Mengakses dan mengkonversi nilai rasio
        $original = $rasio['result']; // Akses nilai result
        $converted = floatval(str_replace(',', '.', $original)); // Konversi menjadi float

        // Menghitung nilai akhir berdasarkan rasio
        if ($converted >= 3) {
            $nilai = 4.0;
        } else {
            $nilai = (4 * $converted) / 3;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '13.B')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 13.B",
            ]
        );
    }

    public function calculate15($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NDTPS', 'NDTT', 'NDT'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        // Perhitungan PDTT
        $NDT = $var['NDT'] ?? 0;
        $NDTT = $var['NDTT'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if (($NDT + $NDTT) != 0) {
            $PDTT = ($NDTT / ($NDT + $NDTT)) * 100;
        } else {
            $PDTT = 0; // Atau nilai default yang sesuai
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($NDTPS >= 12 && $PDTT <= 10) {
            $nilai = 4;
        } elseif ($NDTPS >= 5 && $NDTPS < 12) {
            $A = ($NDTPS - 5) / 7;
            if ($PDTT <= 40) {
                $B = (40 - $PDTT) / 40;
            } else {
                $B = (40 - $PDTT) / 30;
            }
            $nilai = 2 + 2 * ($A * $B);
        } elseif ($NDTPS >= 12 && $PDTT > 10 && $PDTT <= 40) {
            if ($PDTT <= 40) {
                $B = (40 - $PDTT) / 40;
            } else {
                $B = (40 - $PDTT) / 30;
            }
            $nilai = 2 + 2 * $B;
        } elseif ($NDTPS >= 5 && $PDTT > 40) {
            $nilai = 1;
        } else {
            $nilai = 0;
        }
        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '15')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 15",
            ]
        );
    }

    public function calculate16($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NDS3', 'NDTPS'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan PDS3
        $NDS3 = $var['NDS3'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if ($NDTPS != 0) {
            $PDS3 = ($NDS3 / $NDTPS) * 100;
        } else {
            $PDS3 = 0; // Atau nilai default yang sesuai
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($PDS3 >= 10) {
            $nilai = 4.0;
        } else {
            $nilai = 2 + (20 * $PDS3);
            // Memastikan nilai tidak kurang dari 2
            if ($nilai < 2) {
                $nilai = 2;
            }
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '16')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 16",
            ]
        );
    }

    public function calculate17($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NDSK', 'NDTPS'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan PDSK
        $NDSK = $var['NDSK'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if ($NDTPS != 0) {
            $PDSK = ($NDSK / $NDTPS) * 100;
        } else {
            $PDSK = 0; // Atur ke nilai default 0 jika NDTPS adalah 0
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($PDSK >= 50) {
            $nilai = 4.0;
        } else {
            $nilai = 1 + (6 * $PDSK);
            // Memastikan nilai tidak kurang dari 1
            if ($nilai < 1) {
                $nilai = 1;
            }
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '17')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 17",
            ]
        );
    }

    public function calculate18($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NDGB', 'NDLK', 'NDL', 'NDTPS'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan PGBLKL
        $NDGB = $var['NDGB'] ?? 0;
        $NDLK = $var['NDLK'] ?? 0;
        $NDL = $var['NDL'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if ($NDTPS != 0) {
            $PGBLKL = (($NDGB + $NDLK + $NDL) / $NDTPS) * 100;
        } else {
            $PGBLKL = 0; // Atur ke nilai default 0 jika NDTPS adalah 0
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($PGBLKL >= 40) {
            $nilai = 4.0;
        } else {
            $nilai = 2 + ((20 * $PGBLKL) / 4);
            // Memastikan nilai tidak kurang dari 2
            if ($nilai < 2) {
                $nilai = 2;
            }
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '18')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 18",
            ]
        );
    }

    public function calculate19($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NM', 'NDTPS'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        // Perhitungan RMD
        $NM = $var['NM'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if ($NDTPS != 0) {
            $RMD = $NM / $NDTPS;
        } else {
            $RMD = 0; // Atur ke nilai default 0 jika NDTPS adalah 0
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($RMD >= 10 && $RMD <= 20) {
            $nilai = 4.0;
        } elseif ($RMD < 10) {
            $nilai = (2 * $RMD) / 5;
        } elseif ($RMD > 20 && $RMD < 30) {
            $nilai = (60 - (2 * $RMD)) / 5;
        } elseif ($RMD >= 30) {
            $nilai = 0;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '19')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 19",
            ]
        );
    }

    public function calculate20($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel RDPU
        $RDPU = $labelImport->where('label', 'RDPU')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $RDPU = floatval(str_replace(',', '.', $RDPU));

        // Menghitung nilai skor berdasarkan kondisi
        if ($RDPU <= 6) {
            $nilai = 4.0;
        } elseif ($RDPU > 6 && $RDPU <= 10) {
            $nilai = 7 - ($RDPU / 2);
            if ($nilai < 2) {
                $nilai = 2; // Pastikan tidak ada skor antara 0 dan 2
            }
        } elseif ($RDPU > 10) {
            $nilai = 0;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '20')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculate21($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel EWMP
        $EWMP = $labelImport->where('label', 'EWMP')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $EWMP = floatval(str_replace(',', '.', $EWMP));

        // Menghitung nilai skor berdasarkan kondisi
        if ($EWMP == 14) {
            $nilai = 4.0;
        } elseif ($EWMP >= 12 && $EWMP < 14) {
            $nilai = ((3 * $EWMP) - 34) / 2;
        } elseif ($EWMP > 14 && $EWMP <= 16) {
            $nilai = (50 - (3 * $EWMP)) / 2;
        } else {
            $nilai = 0;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '21')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif 21",
            ]
        );
    }

    public function calculate22($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel NDTT dan NDT
        $NDTT = $labelImport->where('label', 'NDTT')->pluck('nilai')->first();
        $NDT = $labelImport->where('label', 'NDT')->pluck('nilai')->first();
        $NDTPS = $labelImport->where('label', 'NDTPS')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $NDTT = floatval(str_replace(',', '.', $NDTT));
        $NDT = floatval(str_replace(',', '.', $NDT));
        $NDTPS = intval($NDTPS);

        // Hitung nilai PDTT (dalam persentase)
        $PDTT = ($NDTT / ($NDT + $NDTT)) * 100;

        // Menghitung nilai skor berdasarkan kondisi
        if ($PDTT == 0 && $NDTPS >= 5) {
            $nilai = 4.0;
        } elseif ($PDTT > 0 && $PDTT <= 40 && $NDTPS >= 5) {
            $nilai = 4.0 - (5 * $PDTT / 100); // Pastikan hasil perhitungan PDTT dalam skala 0-1
        } elseif ($PDTT > 40 && $PDTT <= 60 && $NDTPS >= 5) {
            $nilai = 1.0;
        } elseif ($PDTT > 60) {
            $nilai = 0;
        } else {
            $nilai = null; // Kasus jika tidak memenuhi syarat untuk skor
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '22')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        if ($nilai !== null) {
            AsesmenKecukupan::updateOrCreate(
                [
                    'matriks_penilaian_id' => $idMatriks,
                ],
                [
                    'nilai' => $nilai,
                    'deskripsi' => "Hasil Kuantitatif",
                ]
            );
        }
    }

    public function calculate23($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel MKKI dan MKK
        $MKKI = $labelImport->where('label', 'MKKI')->pluck('nilai')->first();
        $MKK = $labelImport->where('label', 'MKK')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $MKKI = floatval(str_replace(',', '.', $MKKI));
        $MKK = floatval(str_replace(',', '.', $MKK));

        // Hitung nilai PMKI (dalam persentase)
        $PMKI = ($MKKI / $MKK) * 100;

        // Menghitung nilai skor berdasarkan kondisi
        if ($PMKI >= 20) {
            $nilai = 4.0;
        } elseif ($PMKI < 20) {
            $nilai = 2.0 + (10 * $PMKI / 100); // Pastikan PMKI dalam skala 0-1 sebelum dikalikan dengan 10
            $nilai = max($nilai, 2.0); // Tidak ada skor kurang dari 2
        } else {
            $nilai = null; // Kasus jika tidak memenuhi syarat untuk skor
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '23')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        if ($nilai !== null) {
            AsesmenKecukupan::updateOrCreate(
                [
                    'matriks_penilaian_id' => $idMatriks,
                ],
                [
                    'nilai' => $nilai,
                    'deskripsi' => "Hasil Kuantitatif",
                ]
            );
        }
    }

    public function calculate24($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel NRD dan NDTPS
        $NRD = $labelImport->where('label', 'NRD')->pluck('nilai')->first();
        $NDTPS = $labelImport->where('label', 'NDTPS')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $NRD = floatval(str_replace(',', '.', $NRD));
        $NDTPS = floatval(str_replace(',', '.', $NDTPS));

        // Hitung nilai RRD
        $RRD = $NRD / $NDTPS;

        // Menghitung nilai skor berdasarkan kondisi
        if ($RRD >= 0.25) {
            $nilai = 4.0;
        } elseif ($RRD < 0.25) {
            $nilai = 2.0 + (8 * $RRD);
            $nilai = max($nilai, 2.0); // Tidak ada skor kurang dari 2
        } else {
            $nilai = null; // Kasus jika tidak memenuhi syarat untuk skor
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '24')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        if ($nilai !== null) {
            AsesmenKecukupan::updateOrCreate(
                [
                    'matriks_penilaian_id' => $idMatriks,
                ],
                [
                    'nilai' => $nilai,
                    'deskripsi' => "Hasil Kuantitatif",
                ]
            );
        }
    }

    public function calculate25($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport berdasarkan id_prodi
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->whereIn('sheet_name', ['3b2', '3a1'])->get();

        // Ambil nilai untuk NI, NN, NL, dan NDTPS
        $nilaiData = $labelImport->whereIn('label', ['NI', 'NN', 'NL', 'NDTPS'])->pluck('nilai', 'label');
        $NDTPS = isset($nilaiData['NDTPS']) ? (int) $nilaiData['NDTPS'] : 1; // Hindari pembagian dengan 0

        // Faktor
        $a = 0.05;
        $b = 0.3;
        $c = 1;

        // Hitung nilai RI, RN, RL
        $RI = isset($nilaiData['NI']) ? (int) $nilaiData['NI'] / 3 / $NDTPS : 0;
        $RN = isset($nilaiData['NN']) ? (int) $nilaiData['NN'] / 3 / $NDTPS : 0;
        $RL = isset($nilaiData['NL']) ? (int) $nilaiData['NL'] / 3 / $NDTPS : 0;

        // Terapkan batasan pada RI, RN, RL
        $RI = ($RI >= $a) ? $a : $RI;
        $RN = ($RN >= $b) ? $b : $RN;
        $RL = ($RL >= $c) ? $c : $RL;

        // Hitung A, B, C
        $A = $RI / $a;
        $B = $RN / $b;
        $C = $RL / $c;
        // Hitung skor berdasarkan kondisi
        if ($RI > $a && $RN > $b) {
            $skor = 4;
        } else {
            $skor = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
        }

        // Pastikan skor tidak kurang dari 0
        $skor = max($skor, 0);

        // Dapatkan ID matriks penilaian dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '25')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Kuantitatif Label 25",
            ]
        );

        return $skor;
    }

    public function calculate26($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport berdasarkan id_prodi dan sheet_name
        $labelImport3b2 = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '3b2')
            ->whereIn('label', ['NI', 'NN', 'NL'])
            ->pluck('nilai', 'label');

        $labelImport3a1 = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '3a1')
            ->where('label', 'NDTPS')
            ->pluck('nilai', 'label');

        // Gabungkan hasil dari kedua query
        $nilaiData = $labelImport3b2->merge($labelImport3a1);

        // Konversi NDTPS menjadi integer dan hindari pembagian dengan 0
        $NDTPS = isset($nilaiData['NDTPS']) ? (int) $nilaiData['NDTPS'] : 1;

        // Faktor
        $a = 0.05;
        $b = 0.3;
        $c = 1;

        // Hitung nilai RI, RN, RL
        $RI = isset($nilaiData['NI']) ? (int) $nilaiData['NI'] / 3 / $NDTPS : 0;
        $RN = isset($nilaiData['NN']) ? (int) $nilaiData['NN'] / 3 / $NDTPS : 0;
        $RL = isset($nilaiData['NL']) ? (int) $nilaiData['NL'] / 3 / $NDTPS : 0;

        // Terapkan batasan pada RI, RN, RL
        if ($RI >= $a && $RN < $b) {
            $RI = $a;
        }
        if ($RI < $a && $RN >= $b) {
            $RN = $b;
        }
        if ($RL >= $c) {
            $RL = $c;
        }

        // Hitung A, B, C
        $A = $RI / $a;
        $B = $RN / $b;
        $C = $RL / $c;

        // Hitung skor berdasarkan kondisi
        if ($RI > $a && $RN > $b) {
            $skor = 4;
        } else {
            $skor = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
        }

        // Pastikan skor tidak kurang dari 0
        $skor = max($skor, 0);

        // Dapatkan ID matriks penilaian dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '26')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Kuantitatif Label 26",
            ]
        );

        return $skor;
    }

    public function calculate27($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport berdasarkan id_prodi dan sheet_name
        $data3b5 = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '3b5')
            ->whereIn('label', ['NA1', 'NA2', 'NA3', 'NA4', 'NB1', 'NB2', 'NB3', 'NC1', 'NC2', 'NC3'])
            ->pluck('nilai', 'label');

        $data3a1 = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '3a1')
            ->where('label', 'NDTPS')
            ->pluck('nilai', 'label');

        // Ambil nilai NDTPS, default ke 1 jika tidak ditemukan untuk menghindari pembagian dengan 0
        $NDTPS = isset($data3a1['NDTPS']) ? (int) $data3a1['NDTPS'] : 1;

        // Ambil nilai untuk NA1, NA2, NA3, NA4, NB1, NB2, NB3, NC1, NC2, NC3
        $NA1 = isset($data3b5['NA1']) ? (int) $data3b5['NA1'] : 0;
        $NA2 = isset($data3b5['NA2']) ? (int) $data3b5['NA2'] : 0;
        $NA3 = isset($data3b5['NA3']) ? (int) $data3b5['NA3'] : 0;
        $NA4 = isset($data3b5['NA4']) ? (int) $data3b5['NA4'] : 0;
        $NB1 = isset($data3b5['NB1']) ? (int) $data3b5['NB1'] : 0;
        $NB2 = isset($data3b5['NB2']) ? (int) $data3b5['NB2'] : 0;
        $NB3 = isset($data3b5['NB3']) ? (int) $data3b5['NB3'] : 0;
        $NC1 = isset($data3b5['NC1']) ? (int) $data3b5['NC1'] : 0;
        $NC2 = isset($data3b5['NC2']) ? (int) $data3b5['NC2'] : 0;
        $NC3 = isset($data3b5['NC3']) ? (int) $data3b5['NC3'] : 0;

        // Hitung RI, RN, dan RW
        $RI = ($NA4 + $NB3 + $NC3) / $NDTPS;
        $RN = ($NA2 + $NA3 + $NB2 + $NC2) / $NDTPS;
        $RW = ($NA1 + $NB1 + $NC1) / $NDTPS;

        // Faktor a, b, c
        $a = 0.05;
        $b = 0.5;
        $c = 1;

        // Hitung A, B, C
        $A = $RI / $a;
        $B = $RN / $b;
        $C = $RW / $c;

        // Penyesuaian nilai RI, RN, RW jika melebihi faktor
        if ($RI >= $a && $RN < $b) {
            $RI = $a;
        } elseif ($RI < $a && $RN >= $b) {
            $RN = $b;
        }

        if ($RW >= $c) {
            $RW = $c;
        }

        // Hitung Skor berdasarkan kondisi yang diberikan
        $skor = 0;
        if ($RI > $a && $RN > $b) {
            $skor = 4;
        } elseif (($RI <= $a && $RI > 0) || ($RN <= $b && $RN > 0) || ($RW <= $c && $RW > 0)) {
            $skor = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
        }

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        $anotasiLabel = AnotasiLabel::where('rumus_label', '27')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor Label 27",
            ]
        );
    }

    public function calculate28($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NAPJ dan NDTPS
        $napj = $labelImport->where('sheet_name', '3b7')->where('label', 'NAPJ')->pluck('nilai')->first();
        $ndtps = $labelImport->where('sheet_name', '3a1')->where('label', 'NDTPS')->pluck('nilai')->first();

        // Pastikan NDTPS tidak nol untuk menghindari pembagian dengan nol
        if ($ndtps == 0) {
            throw new \Exception("Nilai NDTPS tidak boleh nol.");
        }

        // Hitung RS
        $rs = floatval($napj) / floatval($ndtps);

        // Hitung skor berdasarkan kondisi RS
        if ($rs >= 1) {
            $skor = 4;
        } else {
            $skor = max(2 + (2 * $rs), 2); // Skor tidak boleh kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '28')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 28",
            ]
        );
    }

    public function calculate29($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NA, NB, NC, ND, dan NDTPS
        $na = $labelImport->where('sheet_name', '3b8-1')->where('label', 'NA')->pluck('nilai')->first();
        $nb = $labelImport->where('sheet_name', '3b8-2')->where('label', 'NB')->pluck('nilai')->first();
        $nc = $labelImport->where('sheet_name', '3b8-3')->where('label', 'NC')->pluck('nilai')->first();
        $nd = $labelImport->where('sheet_name', '3b8-4')->where('label', 'ND')->pluck('nilai')->first();
        $ndtps = $labelImport->where('sheet_name', '3a1')->where('label', 'NDTPS')->pluck('nilai')->first();

        // Pastikan NDTPS tidak nol untuk menghindari pembagian dengan nol
        if ($ndtps == 0) {
            throw new \Exception("Nilai NDTPS tidak boleh nol.");
        }

        // Hitung RLP
        $rlp = (2 * (floatval($na) + floatval($nb) + floatval($nc)) + floatval($nd)) / floatval($ndtps);

        // Hitung skor berdasarkan kondisi RLP
        if ($rlp >= 1) {
            $skor = 4; // Skor 4 jika RLP ≥ 1
        } else {
            $skor = 2 + (2 * $rlp); // Hitung skor jika RLP < 1
            $skor = max($skor, 2); // Skor tidak boleh kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '29')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 29",
            ]
        );
    }

    public function calculate32($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai DOP
        $dop = $labelImport->where('label', 'DOP')->pluck('nilai')->first();
        // Pastikan nilai DOP valid
        if ($dop === null) {
            throw new \Exception("Nilai DOP tidak ditemukan.");
        }

        $dop = floatval($dop); // Konversi nilai DOP menjadi float

        // Hitung skor berdasarkan kondisi DOP
        if ($dop >= 20000000) {
            $skor = 4; // Skor 4 jika DOP ≥ 20.000.000
        } else {
            $skor = $dop / 5000000; // Hitung skor jika DOP < 20.000.000
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '32')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 32",
            ]
        );
    }

    public function calculate33($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai DPD
        $dpd = $labelImport->where('label', 'DPD')->pluck('nilai')->first();

        // Pastikan nilai DPD valid
        if ($dpd === null) {
            throw new \Exception("Nilai DPD tidak ditemukan.");
        }

        $dpd = floatval($dpd); // Konversi nilai DPD menjadi float

        // Hitung skor berdasarkan kondisi DPD
        if ($dpd >= 10000000) {
            $skor = 4; // Skor 4 jika DPD ≥ 10.000.000
        } else {
            $skor = (2 * $dpd) / 5000000; // Hitung skor jika DPD < 10.000.000
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '33')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 33",
            ]
        );
    }

    public function calculate34($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai DPkMD
        $dpkmd = $labelImport->where('label', 'DPkMD')->pluck('nilai')->first();

        // Pastikan nilai DPkMD valid
        if ($dpkmd === null) {
            throw new \Exception("Nilai DPkMD tidak ditemukan.");
        }

        $dpkmd = floatval($dpkmd); // Konversi nilai DPkMD menjadi float

        // Hitung skor berdasarkan kondisi DPkMD
        if ($dpkmd >= 5000000) {
            $skor = 4; // Skor 4 jika DPkMD ≥ 5.000.000
        } else {
            $skor = (4 * $dpkmd) / 5000000; // Hitung skor jika DPkMD < 5.000.000
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '34')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 34",
            ]
        );
    }

    public function calculate42($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai JP dan JB
        $jp = $labelImport->where('label', 'JP')->pluck('nilai')->first();
        $jb = $labelImport->where('label', 'JB')->pluck('nilai')->first();

        // Pastikan nilai JP dan JB valid
        if ($jp === null || $jb === null) {
            throw new \Exception("Nilai JP atau JB tidak ditemukan.");
        }

        $jp = floatval($jp); // Konversi nilai JP menjadi float
        $jb = floatval($jb); // Konversi nilai JB menjadi float

        // Hitung PJP
        $pjp = ($jp / $jb) * 100;

        // Hitung skor berdasarkan kondisi PJP
        if ($pjp >= 50) {
            $skor = 4; // Skor 4 jika PJP ≥ 50%
        } else {
            $skor = 8 * $pjp; // Hitung skor jika PJP < 50%
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '42')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 42",
            ]
        );
    }

    public function calculate45($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NMKI
        $nmki = $labelImport->where('label', 'NMKI')->pluck('nilai')->first();

        // Pastikan nilai NMKI valid
        if ($nmki === null) {
            throw new \Exception("Nilai NMKI tidak ditemukan.");
        }

        $nmki = floatval($nmki); // Konversi nilai NMKI menjadi float
        if ($nmki > 3) {
            $skor = 4; // Skor 4 jika NMKI > 3
        } elseif ($nmki >= 2 && $nmki <= 3) {
            $skor = 3; // Skor 3 jika NMKI antara 2 dan 3 (inklusif)
        } elseif ($nmki == 1) {
            $skor = 2; // Skor 2 jika NMKI = 1
        } else {
            $skor = 1; // Skor 1 jika NMKI < 1
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '45')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor kriteria label 45",
            ]
        );
    }

    //blm tny cipiti
    public function calculate47A($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->where('sheet_name', '5d')->get();

        // Ambil nilai NMKI
        $ai1 = $labelImport->whereIn('label', ['ai1', 'bi1', 'ci1', 'di1'])->pluck('nilai', 'label');
        $ai2 = $labelImport->whereIn('label', ['ai2', 'bi2', 'ci2', 'di2'])->pluck('nilai', 'label');
        $ai3 = $labelImport->whereIn('label', ['ai3', 'bi3', 'ci3', 'di3'])->pluck('nilai', 'label');
        $ai4 = $labelImport->whereIn('label', ['ai4', 'bi4', 'ci4', 'di4'])->pluck('nilai', 'label');
        $ai5 = $labelImport->whereIn('label', ['ai5', 'bi5', 'ci5', 'di5'])->pluck('nilai', 'label');

        $tkmVar1 = array_merge($ai1->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm1 = $this->evaluator->evaluate('(4 * ai1) + (3 * bi1) + (2 * ci1) + di1', $tkmVar1);
        $tkm1Ori = $tkm1['result'];
        $tkm1Conv = floatval(str_replace(',', '.', $tkm1Ori));

        $tkmVar2 = array_merge($ai2->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm2 = $this->evaluator->evaluate('(4 * ai2) + (3 * bi2) + (2 * ci2) + di2', $tkmVar2);
        $tkm2Ori = $tkm2['result'];
        $tkm2Conv = floatval(str_replace(',', '.', $tkm2Ori));

        $tkmVar3 = array_merge($ai3->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm3 = $this->evaluator->evaluate('(4 * ai3) + (3 * bi3) + (2 * ci3) + di3', $tkmVar3);
        $tkm3Ori = $tkm3['result'];
        $tkm3Conv = floatval(str_replace(',', '.', $tkm3Ori));

        $tkmVar4 = array_merge($ai4->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm4 = $this->evaluator->evaluate('(4 * ai4) + (3 * bi4) + (2 * ci4) + di4', $tkmVar4);
        $tkm4Ori = $tkm4['result'];
        $tkm4Conv = floatval(str_replace(',', '.', $tkm4Ori));

        $tkmVar5 = array_merge($ai5->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm5 = $this->evaluator->evaluate('(4 * ai5) + (3 * bi5) + (2 * ci5) + di5', $tkmVar5);
        $tkm5Ori = $tkm5['result'];
        $tkm5Conv = floatval(str_replace(',', '.', $tkm5Ori));

        $tkm = ($tkm1Conv + $tkm2Conv + $tkm3Conv + $tkm4Conv + $tkm5Conv) / 5;

        if ($tkm >= 75) {
            $skor = 4.0;
        } elseif ($tkm >= 25 && $tkm < 75) {
            $skor = (8 * $tkm) - 2;
        } elseif ($tkm < 25) {
            $skor = 0.0;
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '47')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 45",
            ]
        );
    }

    public function calculate50($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NPkMM dan NPkMD
        $npkmm = $labelImport->where('label', 'NPkMM')->pluck('nilai')->first();
        $npkmd = $labelImport->where('label', 'NPkMD')->pluck('nilai')->first();

        // Pastikan nilai NPkMM dan NPkMD valid
        if ($npkmm === null || $npkmd === null || $npkmd == 0) {
            throw new \Exception("Nilai NPkMM atau NPkMD tidak ditemukan atau NPkMD tidak boleh 0.");
        }

        $npkmm = floatval($npkmm); // Konversi nilai NPkMM menjadi float
        $npkmd = floatval($npkmd); // Konversi nilai NPkMD menjadi float

        // Hitung PPkMDM
        $ppkmdm = ($npkmm / $npkmd) * 100;

        // Hitung skor berdasarkan nilai PPkMDM
        if ($ppkmdm >= 25) {
            $skor = 4; // Skor 4 jika PPkMDM ≥ 25%
        } elseif ($ppkmdm < 25) {
            $skor = 2 + (8 * $ppkmdm); // Skor 2 + (8 × PPkMDM) jika PPkMDM < 25%
        } else {
            $skor = 1; // Skor 1 jika data tidak sesuai
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '50')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 50",
            ]
        );
    }

    public function calculate52($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NPkMM dan NPkMD
        $ipk = $labelImport->where('label', 'IPKs')->pluck('nilai')->first();
        $ipk1 = $labelImport->where('label', 'IPKs-1')->pluck('nilai')->first();
        $ipk2 = $labelImport->where('label', 'IPKs-2')->pluck('nilai')->first();
        // Hitung PPkMDM
        $ripk = ($ipk + $ipk1 + $ipk2) / 3;

        // Hitung skor berdasarkan nilai PPkMDM
        if ($ripk >= 3.25) {
            $skor = 4.0; // Skor 4 jika PPkMDM ≥ 25%
        } elseif ($ripk >= 2.00 && $ripk < 3.25) {
            $skor = ((8 * $ripk) - 6) / 5;
        } else {
            $skor = 2; // Tidak ada skor kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '52')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 52",
            ]
        );
    }

    public function calculate53($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->whereIn('sheet_name', ['8b1', '2a2'])
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NI', 'NN', 'NW', 'NM'])->pluck('nilai', 'label');

        // Definisikan faktor
        $faktor = [
            'a' => 0.05 / 100,
            'b' => 1 / 100,
            'c' => 2 / 100,
        ];

        // Konversi nilai dari LabelImport ke integer
        $val = $val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray();

        // Hitung nilai RI, RN, dan RW
        $ri = $val['NI'] / $val['NM'];
        $rn = $val['NN'] / $val['NM'];
        $rw = $val['NW'] / $val['NM'];

        // Terapkan batasan jika nilai RI, RN, atau RW melebihi batasan
        $ri = min($ri, $faktor['a']);
        $rn = min($rn, $faktor['b']);
        $rw = min($rw, $faktor['c']);

        // Hitung A, B, dan C
        $A = $ri / $faktor['a'];
        $B = $rn / $faktor['b'];
        $C = $rw / $faktor['c'];

        // Hitung skor berdasarkan kriteria
        if ($ri > $faktor['a'] && $rn > $faktor['b']) {
            $skor = 4;
        } else {
            $formula = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
            $skor = max(0, $formula); // Pastikan skor tidak negatif
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '53')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 53",
            ]
        );
    }

    public function calculate54($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->whereIn('sheet_name', ['8b2', '2a2'])
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NI', 'NN', 'NW', 'NM'])->pluck('nilai', 'label');

        // Definisikan faktor
        $faktor = [
            'a' => 0.1 / 100,  // 0.1%
            'b' => 2 / 100,    // 2%
            'c' => 4 / 100,    // 4%
        ];

        // Konversi nilai dari LabelImport ke integer
        $val = $val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray();

        // Hitung nilai RI, RN, dan RW
        $ri = $val['NI'] / $val['NM'];
        $rn = $val['NN'] / $val['NM'];
        $rw = $val['NW'] / $val['NM'];

        // Terapkan batasan
        $ri = min($ri, $faktor['a']);
        $rn = min($rn, $faktor['b']);
        $rw = min($rw, $faktor['c']);

        // Terapkan batasan tambahan berdasarkan kondisi
        if ($ri >= $faktor['a'] && $rn < $faktor['b']) {
            $ri = $faktor['a'];
        }
        if ($ri < $faktor['a'] && $rn >= $faktor['b']) {
            $rn = $faktor['b'];
        }
        if ($rw >= $faktor['c']) {
            $rw = $faktor['c'];
        }

        // Hitung A, B, dan C
        $A = $ri / $faktor['a'];
        $B = $rn / $faktor['b'];
        $C = $rw / $faktor['c'];

        // Hitung skor berdasarkan kriteria
        if ($ri > $faktor['a'] && $rn > $faktor['b']) {
            $skor = 4;
        } else {
            $formula = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
            $skor = max(0, $formula); // Pastikan skor tidak negatif
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '54')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 54",
            ]
        );
    }

    public function calculate55($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8c')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['g', 'c', 'f', 'b', 'i', 'e'])->pluck('nilai', 'label');

        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $ms = $this->evaluator->evaluate('(((g + c + f) * 3) + ((b + i + e) * 4)) / (g+c+f+b+i+e)', $var);
        $msOriginal = $ms['result']; // Akses langsung nilai result
        $msConverted = floatval(str_replace(',', '.', $msOriginal));
        // dd($msConverted);

        // Default skor
        $skor = 0;

        // Menghitung skor berdasarkan nilai $msConverted
        if ($msConverted >= 3 && $msConverted <= 3.5) {
            $skor = 4.0;
        } elseif ($msConverted > 3.5 && $msConverted <= 5) {
            $skor = (40 - (8 * $msConverted)) / 3;
        } elseif ($msConverted < 3) {
            $skor = 0;
        }
        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '55')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 55",
            ]
        );
    }


    public function calculate56($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8c')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['g', 'c', 'f', 'a', 'h', 'd'])->pluck('nilai', 'label');

        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $ptw = $this->evaluator->evaluate('(g + c + f) / (a + h + d)', $var);

        $ptwOriginal = $ptw['result']; // Akses langsung nilai result
        $ptwConverted = floatval(str_replace(',', '.', $ptwOriginal)); // Konversi menjadi float

        // Terapkan batasan tambahan berdasarkan kondisi
        if ($ptwConverted >= 70 / 100) {
            $skor = 4.0;
        } elseif ($ptwConverted < 70 / 100) {
            $skor = 1 + ((30 * $ptwConverted) / 7);
        } else {
            $skor = 1.0;
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '56')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 56",
            ]
        );
    }

    public function calculate57($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8c')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['g', 'c', 'f', 'a', 'h', 'd', 'b', 'i', 'e'])->pluck('nilai', 'label');

        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $mdo = $this->evaluator->evaluate('(((a + h + d) - (g + c + f + b + i + e)) / (a + h + d)) * 100', $var);

        // $mdo = $this->evaluator->evaluate('(((a + h + d) - (g + c + f)) / (a + h + d)) * 100', $var);
        $mdoOriginal = $mdo['result']; // Akses langsung nilai result
        $mdoConverted = floatval(str_replace(',', '.', $mdoOriginal)); // Konversi menjadi float

        $skor = 0.0;

        if ($mdoConverted <= 6) {
            $skor = 4.0;
        } elseif ($mdoConverted > 6 && $mdoConverted < 45) {
            // Menghitung skor sesuai rumus yang diberikan
            $skor = (180 - (400 * ($mdoConverted / 100))) / 39;
            // Pastikan skor tidak negatif
            if ($skor < 0) {
                $skor = 0;
            }
        } elseif ($mdoConverted >= 45) {
            $skor = 0.0;
        }
        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '57')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 57",
            ]
        );
    }

    public function calculate59($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8d1')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NL', 'NJ', 'N-WT3', 'N-WT36', 'N-WT6'])->pluck('nilai', 'label');

        // Konversi nilai menjadi array yang bisa dipakai untuk evaluasi
        $var = $val->mapWithKeys(fn($nilai, $label) => [$label => (float)$nilai])->toArray();

        // Hitung persentase lulusan yang terlacak (PJ)
        $pj = $this->evaluator->evaluate('(NJ/NL) * 100', $var);
        $pjConverted = floatval($pj['result']); // Konversi hasil menjadi float

        // Hitung Prmin berdasarkan jumlah lulusan (NL)
        $nl = $var['NL'] ?? 0;
        $prmin = $nl >= 300 ? 30 : 50 - (($nl / 300) * 20);

        // Hitung rata-rata waktu tunggu (WT)
        $wtLt3 = $var['N-WT3'] ?? 0;
        $wtBetween36 = $var['N-WT36'] ?? 0;
        $wtGt6 = $var['N-WT6'] ?? 0;

        $totalWt = ($wtLt3 * 1) + ($wtBetween36 * 4.5) + ($wtGt6 * 7);
        $totalCount = $wtLt3 + $wtBetween36 + $wtGt6;
        $wtRata2 = $totalCount > 0 ? $totalWt / $totalCount : 0;

        // Skor awal berdasarkan waktu tunggu (WT)
        $skor = 0.0; // Default skor

        if ($wtRata2 < 3) {
            $skor = 4.0;
        } elseif ($wtRata2 >= 3 && $wtRata2 <= 6) {
            $skor = (24 - (4 * $wtRata2)) / 3;
        } else {
            $skor = 0.0;
        }

        // Sesuaikan skor akhir berdasarkan persentase responden (PJ)
        $skorAkhir = $pjConverted < $prmin ? ($pjConverted / $prmin) * $skor : $skor;

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '59')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skorAkhir,
                'deskripsi' => "Hasil Skor berdasarkan label 59",
            ]
        );
    }


    public function calculate60($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8d2')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NL', 'NJ', 'PBS-t'])->pluck('nilai', 'label');

        // Konversi nilai menjadi array yang bisa dipakai untuk evaluasi
        $var = $val->mapWithKeys(fn($nilai, $label) => [$label => (float)$nilai])->toArray();

        // Hitung persentase lulusan yang terlacak (PJ)
        $nl = $var['NL'] ?? 0;
        $nj = $var['NJ'] ?? 0;
        $h = $var['PBS-t'] ?? 0;
        $pj = ($nl > 0) ? ($nj / $nl) * 100 : 0;

        // Hitung Prmin berdasarkan jumlah lulusan (NL)
        $prmin = $nl >= 300 ? 30 : 50 - (($nl / 300) * 20);

        // Hitung PBS
        $pbs = ($h / $nj) * 100;
        // Hitung skor berdasarkan PBS
        $skor = $pbs >= 80 ? 4 : 5 * $pbs;

        // Sesuaikan skor akhir berdasarkan persentase responden (PJ) dan Prmin
        $skorAkhir = $pj >= $prmin ? $skor : ($pj / $prmin) * $skor;

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '60')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skorAkhir,
                'deskripsi' => "Hasil Skor berdasarkan label 60",
            ]
        );
    }

    public function calculate61($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8e1')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NI', 'NN', 'NW', 'NL'])->pluck('nilai', 'label');

        // Konversi nilai menjadi array yang bisa dipakai untuk evaluasi
        $var = $val->mapWithKeys(fn($nilai, $label) => [$label => (float)$nilai])->toArray();

        // Ambil jumlah lulusan dan lulusan yang bekerja
        $ni = $var['NI'] ?? 0;
        $nn = $var['NN'] ?? 0;
        $nw = $var['NW'] ?? 0;
        $nl = $var['NL'] ?? 0;

        // Hitung RI, RN, RW
        $ri = $nl > 0 ? ($ni / $nl) * 100 : 0;
        $rn = $nl > 0 ? ($nn / $nl) * 100 : 0;
        $rw = $nl > 0 ? ($nw / $nl) * 100 : 0;

        // Faktor
        $a = 5.0;
        $b = 20.0;
        $c = 90.0;

        // Hitung A, B, C
        $aFactor = $a > 0 ? $ri / $a : 0;
        $bFactor = $b > 0 ? $rn / $b : 0;
        $cFactor = $c > 0 ? $rw / $c : 0;

        // Hitung Skor
        if ($ri > $a && $rn > $b) {
            $skor = 4.0;
        } else {
            $skor = 3.75 * (($aFactor + $bFactor + ($cFactor / 2)) - ($aFactor * $bFactor) - (($aFactor * $cFactor) / 2) - (($bFactor * $cFactor) / 2) + (($aFactor * $bFactor * $cFactor) / 2));
        }

        // Hitung Prmin berdasarkan jumlah lulusan (NL)
        $prmin = $nl >= 300 ? 30 : 50 - (($nl / 300) * 20);

        // Hitung persentase lulusan yang terlacak (PJ)
        $nj = $ni + $nn + $nw;
        $pj = $nl > 0 ? ($nj / $nl) * 100 : 0;

        // Sesuaikan skor akhir berdasarkan PJ dan Prmin
        $skorAkhir = $pj >= $prmin ? $skor : ($pj / $prmin) * $skor;

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '61')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skorAkhir,
                'deskripsi' => "Hasil Skor berdasarkan label 61",
            ]
        );
    }

    public function calculate62($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->whereIn('sheet_name', ['8e2', '8e1'])
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', [
            'ai1',
            'bi1',
            'ci1',
            'di1',
            'ai2',
            'bi2',
            'ci2',
            'di2',
            'ai3',
            'bi3',
            'ci3',
            'di3',
            'ai4',
            'bi4',
            'ci4',
            'di4',
            'ai5',
            'bi5',
            'ci5',
            'di5',
            'ai6',
            'bi6',
            'ci6',
            'di6',
            'ai7',
            'bi7',
            'ci7',
            'di7',
            'NL',
            'NJ-tanggapan'
        ])
            ->pluck('nilai', 'label');

        // Konversi nilai menjadi array yang bisa dipakai untuk evaluasi
        $var = $val->mapWithKeys(fn($nilai, $label) => [$label => (float)$nilai])->toArray();

        $nl = $var['NL'] ?? 0;
        $nj = $var['NJ-tanggapan'] ?? 0;

        // Hitung persentase responden yang memberi tanggapan (PJ)
        $pj = $nl > 0 ? ($nj / $nl) * 100 : 0;

        // Hitung Prmin berdasarkan jumlah lulusan (NL)
        $prmin = $nl >= 300 ? 30 : 50 - (($nl / 300) * 20);

        // Hitung skor untuk setiap aspek
        $totalTK = 0;
        for ($i = 1; $i <= 7; $i++) {
            $ai = $var["ai$i"] ?? 0;
            $bi = $var["bi$i"] ?? 0;
            $ci = $var["ci$i"] ?? 0;
            $di = $var["di$i"] ?? 0;
            $tk = (4 * $ai) + (3 * $bi) + (2 * $ci) + $di;
            $totalTK += $tk;
        }


        // Hitung skor akhir
        $skor = $nl > 0 ? $totalTK / 7 : 0;
        $skorAkhir = $pj >= $prmin ? $skor : ($pj / $prmin) * $skor;

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '62')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skorAkhir,
                'deskripsi' => "Hasil Skor berdasarkan label 62",
            ]
        );
    }

    public function calculate63($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8f4')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $napjCollection = $labelImport->where('label', 'NAPJ')->pluck('nilai');

        // Ambil nilai tunggal dari koleksi
        $napj = $napjCollection->first(); // Mengambil nilai pertama dari koleksi

        // Konversi ke float jika diperlukan
        $napj = floatval($napj);

        if ($napj >= 2) {
            $skor = 4;
        } elseif ($napj == 1) {
            $skor = 3;
        } else {
            $skor = 0; // Pastikan $skor selalu terdefinisi
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '63')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 63",
            ]
        );
    }


    //jenjangD4
    public function calculateD410A($id_prodi, $jenjangId)
    {
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        $rkVal = $labelImport->whereIn('label', ['N1', 'N2', 'N3', 'NDTPS'])->pluck('nilai', 'label');
        $rkFaktor = [
            'a' => 3,
            'b' => 1,
            'c' => 2,
        ];

        $rkVar = array_merge($rkFaktor, $rkVal->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $rk = $this->evaluator->evaluate('((a * N1) + (b * N2) + (c * N3)) / NDTPS', $rkVar);
        $rkOriginal = $rk['result']; // Akses langsung nilai result
        $rkConverted = floatval(str_replace(',', '.', $rkOriginal)); // Konversi menjadi float

        // // Debugging
        // dd([
        //     'Original' => $rkOriginal,
        //     'Converted' => $rkConverted,
        // ]);

        $nilai = ($rkConverted >= 4.0) ? 4.0 : $rkConverted;
        $anotasiLabel = AnotasiLabel::where('rumus_label', '10.A')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatifff",
            ]
        );
    }

    public function calculateD410B($id_prodi, $jenjangId)
    {
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Mengambil nilai untuk variabel NI, NN, NW
        $val = $labelImport->whereIn('label', ['NI1', 'NN1', 'NW1', 'NI2', 'NN2', 'NW2', 'NI3', 'NN3', 'NW3'])
            ->pluck('nilai', 'label');

        // Faktor-faktor
        $faktor = [
            'a' => 2,
            'b' => 6,
            'c' => 8,
        ];

        // Menggabungkan faktor dan nilai variabel
        $var = array_merge($faktor, $val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Menghitung nilai total NI, NN, NW
        $ni = $this->evaluator->evaluate('(NI1 + NI2 + NI3)', $var);
        $nn = $this->evaluator->evaluate('(NN1 + NN2 + NN3)', $var);
        $nw = $this->evaluator->evaluate('(NW1 + NW2 + NW3)', $var);
        // Kondisi untuk skor 4.0
        if ($ni > $faktor['a'] && $nn > $faktor['b']) {
            $nilai = 4.0;
        } else {
            // Koreksi nilai NI, NN, NW berdasarkan syarat
            $ni = min($ni, $faktor['a']);
            $nn = min($nn, $faktor['b']);
            $nw = min($nw, $faktor['c']);

            // Menghitung A, B, C
            $aVar = $ni / $faktor['a'];
            $bVar = $nn / $faktor['b'];
            $cVar = $nw / $faktor['c'];

            // Menghitung skor berdasarkan rumus
            $skor = 3.75 * (($aVar + $bVar + ($cVar / 2)) - ($aVar * $bVar) - (($aVar * $cVar) / 2) - (($bVar * $cVar) / 2) + (($aVar * $bVar * $cVar) / 2));

            // Konversi nilai skor menjadi float
            $nilai = floatval($skor);
        }
        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '10.B')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD413B($id_prodi, $jenjangId)
    {
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Mengambil nilai untuk variabel NPendaftar dan NLolos
        $val = $labelImport->whereIn('label', ['NPendaftar', 'NLolos'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Menghitung rasio NPendaftar / NLolos
        $rasio = $this->evaluator->evaluate('(NPendaftar / NLolos)', $var);

        // Mengakses dan mengkonversi nilai rasio
        $original = $rasio['result']; // Akses nilai result
        $converted = floatval(str_replace(',', '.', $original)); // Konversi menjadi float

        // Menghitung nilai akhir berdasarkan rasio
        if ($converted >= 4) {
            $nilai = 4.0;
        } else {
            $nilai = (4 * $converted) / 4;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '13.B')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD414B($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->where('sheet_name', '2b')->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['JM_AKTIF', 'JM_ASING_FT', 'JM_ASING_PT'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan PMA
        $JM_AKTIF_TS = $var['JM_AKTIF_TS'] ?? 0;
        $JM_ASING_FT_TS = $var['JM_ASING_FT_TS'] ?? 0;
        $JM_ASING_PT_TS = $var['JM_ASING_PT_TS'] ?? 0;

        // Hitung jumlah mahasiswa asing dan total mahasiswa aktif
        $jumlahMahasiswaAsing = $JM_ASING_FT_TS + $JM_ASING_PT_TS;

        // Hitung PMA
        if ($JM_AKTIF_TS > 0) {
            $PMA = ($jumlahMahasiswaAsing / $JM_AKTIF_TS) * 100;
        } else {
            $PMA = 0;
        }

        // Tentukan nilai B
        if ($PMA >= 1) {
            $skor = 4;
        } else {
            $skor = 2 + (200 * $PMA);
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '14.B')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }



    public function calculateD416($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NDTPS', 'NDTT', 'NDT'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan PDTT
        $NDT = $var['NDT'] ?? 0;
        $NDTT = $var['NDTT'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if (($NDT + $NDTT) != 0) {
            $PDTT = ($NDTT / ($NDT + $NDTT)) * 100;
        } else {
            $PDTT = 0; // Atau nilai default yang sesuai
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($NDTPS >= 12 && $PDTT <= 10) {
            $nilai = 4;
        } elseif ($NDTPS >= 5 && $NDTPS < 12) {
            $A = ($NDTPS - 5) / 7;
            if ($PDTT <= 40) {
                $B = (40 - $PDTT) / 40;
            } else {
                $B = (40 - $PDTT) / 30;
            }
            $nilai = 2 + 2 * ($A * $B);
        } elseif ($NDTPS >= 12 && $PDTT > 10 && $PDTT <= 40) {
            if ($PDTT <= 40) {
                $B = (40 - $PDTT) / 40;
            } else {
                $B = (40 - $PDTT) / 30;
            }
            $nilai = 2 + 2 * $B;
        } elseif ($NDTPS >= 5 && $PDTT > 40) {
            $nilai = 1;
        } else {
            $nilai = 0;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '16')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD417($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NDS3', 'NDTPS'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan PDS3
        $NDS3 = $var['NDS3'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if ($NDTPS != 0) {
            $PDS3 = ($NDS3 / $NDTPS) * 100;
        } else {
            $PDS3 = 0; // Atau nilai default yang sesuai
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($PDS3 >= 15) {
            $nilai = 4.0;
        } else {
            $nilai = 2 + ((2 * $PDS3) / 15);
            // Memastikan nilai tidak kurang dari 2
            if ($nilai < 2) {
                $nilai = 2;
            }
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '17')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD418($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NDSK', 'NDTPS'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan PDSK
        $NDSK = $var['NDSK'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if ($NDTPS != 0) {
            $PDSK = ($NDSK / $NDTPS) * 100;
        } else {
            $PDSK = 0; // Atur ke nilai default 0 jika NDTPS adalah 0
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($PDSK >= 50) {
            $nilai = 4.0;
        } else {
            $nilai = 1 + (6 * $PDSK);
            // Memastikan nilai tidak kurang dari 1
            if ($nilai < 1) {
                $nilai = 1;
            }
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '18')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD419($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NDGB', 'NDLK', 'NDL', 'NDTPS'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan PGBLKL
        $NDGB = $var['NDGB'] ?? 0;
        $NDLK = $var['NDLK'] ?? 0;
        $NDL = $var['NDL'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if ($NDTPS != 0) {
            $PGBLKL = (($NDGB + $NDLK + $NDL) / $NDTPS) * 100;
        } else {
            $PGBLKL = 0; // Atur ke nilai default 0 jika NDTPS adalah 0
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($PGBLKL >= 50) {
            $nilai = 4.0;
        } else {
            $nilai = 2 + ((20 * $PGBLKL) / 5);
            // Memastikan nilai tidak kurang dari 2
            if ($nilai < 2) {
                $nilai = 2;
            }
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '19')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD420($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel yang diperlukan
        $val = $labelImport->whereIn('label', ['NM', 'NDTPS'])->pluck('nilai', 'label');
        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());

        // Perhitungan RMD
        $NM = $var['NM'] ?? 0;
        $NDTPS = $var['NDTPS'] ?? 0;

        if ($NDTPS != 0) {
            $RMD = $NM / $NDTPS;
        } else {
            $RMD = 0; // Atur ke nilai default 0 jika NDTPS adalah 0
        }

        // Menghitung nilai skor berdasarkan kondisi
        if ($RMD >= 15 && $RMD <= 25) {
            $nilai = 4.0;
        } elseif ($RMD < 15) {
            $nilai = (4 * $RMD) / 15;
        } elseif ($RMD > 25 && $RMD <= 35) {
            $nilai = (70 - (2 * $RMD)) / 5;
        } elseif ($RMD > 35) {
            $nilai = 0;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '20')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD421($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel RDPU
        $RDPU = $labelImport->where('label', 'RDPU')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $RDPU = floatval(str_replace(',', '.', $RDPU));

        // Menghitung nilai skor berdasarkan kondisi
        if ($RDPU <= 6) {
            $nilai = 4.0;
        } elseif ($RDPU > 6 && $RDPU <= 10) {
            $nilai = 7 - ($RDPU / 2);
            if ($nilai < 2) {
                $nilai = 2; // Pastikan tidak ada skor antara 0 dan 2
            }
        } elseif ($RDPU > 10) {
            $nilai = 0;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '21')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD422($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel EWMP
        $EWMP = $labelImport->where('label', 'EWMP')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $EWMP = floatval(str_replace(',', '.', $EWMP));

        // Menghitung nilai skor berdasarkan kondisi
        if ($EWMP == 14) {
            $nilai = 4.0;
        } elseif ($EWMP >= 12 && $EWMP < 14) {
            $nilai = ((3 * $EWMP) - 34) / 2;
        } elseif ($EWMP > 14 && $EWMP <= 16) {
            $nilai = (50 - (3 * $EWMP)) / 2;
        } else {
            $nilai = 0;
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '22')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $nilai,
                'deskripsi' => "Hasil Kuantitatif",
            ]
        );
    }

    public function calculateD423($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel NDTT dan NDT
        $NDTT = $labelImport->where('label', 'NDTT')->pluck('nilai')->first();
        $NDT = $labelImport->where('label', 'NDT')->pluck('nilai')->first();
        $NDTPS = $labelImport->where('label', 'NDTPS')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $NDTT = floatval(str_replace(',', '.', $NDTT));
        $NDT = floatval(str_replace(',', '.', $NDT));
        $NDTPS = intval($NDTPS);

        // Hitung nilai PDTT (dalam persentase)
        $PDTT = ($NDTT / ($NDT + $NDTT)) * 100;

        // Menghitung nilai skor berdasarkan kondisi
        if ($PDTT == 0 && $NDTPS >= 5) {
            $nilai = 4.0;
        } elseif ($PDTT > 0 && $PDTT <= 40 && $NDTPS >= 5) {
            $nilai = 4.0 - (5 * $PDTT / 100); // Pastikan hasil perhitungan PDTT dalam skala 0-1
        } elseif ($PDTT > 40 && $PDTT <= 60 && $NDTPS >= 5) {
            $nilai = 1.0;
        } elseif ($PDTT > 60) {
            $nilai = 0;
        } else {
            $nilai = null; // Kasus jika tidak memenuhi syarat untuk skor
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '23')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        if ($nilai !== null) {
            AsesmenKecukupan::updateOrCreate(
                [
                    'matriks_penilaian_id' => $idMatriks,
                ],
                [
                    'nilai' => $nilai,
                    'deskripsi' => "Hasil Kuantitatif",
                ]
            );
        }
    }

    public function calculateD424($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel MKKI dan MKK
        $MKKI = $labelImport->where('label', 'MKKI')->pluck('nilai')->first();
        $MKK = $labelImport->where('label', 'MKK')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $MKKI = floatval(str_replace(',', '.', $MKKI));
        $MKK = floatval(str_replace(',', '.', $MKK));

        // Hitung nilai PMKI (dalam persentase)
        $PMKI = ($MKKI / $MKK) * 100;

        // Menghitung nilai skor berdasarkan kondisi
        if ($PMKI >= 20) {
            $nilai = 4.0;
        } elseif ($PMKI < 20) {
            $nilai = 2.0 + (10 * $PMKI / 100); // Pastikan PMKI dalam skala 0-1 sebelum dikalikan dengan 10
            $nilai = max($nilai, 2.0); // Tidak ada skor kurang dari 2
        } else {
            $nilai = null; // Kasus jika tidak memenuhi syarat untuk skor
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '24')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        if ($nilai !== null) {
            AsesmenKecukupan::updateOrCreate(
                [
                    'matriks_penilaian_id' => $idMatriks,
                ],
                [
                    'nilai' => $nilai,
                    'deskripsi' => "Hasil Kuantitatif",
                ]
            );
        }
    }

    public function calculateD425($id_prodi, $jenjangId)
    {
        // Ambil data dari database
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai untuk variabel NRD dan NDTPS
        $NRD = $labelImport->where('label', 'NRD')->pluck('nilai')->first();
        $NDTPS = $labelImport->where('label', 'NDTPS')->pluck('nilai')->first();

        // Konversi nilai ke tipe data numerik (float)
        $NRD = floatval(str_replace(',', '.', $NRD));
        $NDTPS = floatval(str_replace(',', '.', $NDTPS));

        // Hitung nilai RRD
        $RRD = $NRD / $NDTPS;

        // Menghitung nilai skor berdasarkan kondisi
        if ($RRD >= 0.5) {
            $nilai = 4.0;
        } elseif ($RRD < 0.5) {
            $nilai = 2.0 + (4 * $RRD);
            $nilai = max($nilai, 2.0); // Tidak ada skor kurang dari 2
        } else {
            $nilai = 0; // Kasus jika tidak memenuhi syarat untuk skor
        }

        // Mendapatkan id matriks yang sesuai
        $anotasiLabel = AnotasiLabel::where('rumus_label', '25')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        if ($nilai !== null) {
            AsesmenKecukupan::updateOrCreate(
                [
                    'matriks_penilaian_id' => $idMatriks,
                ],
                [
                    'nilai' => $nilai,
                    'deskripsi' => "Hasil Kuantitatif",
                ]
            );
        }
    }

    public function calculateD426($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport berdasarkan id_prodi
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->whereIn('sheet_name', ['3b2', '3a1'])->get();

        // Ambil nilai untuk NI, NN, NL, dan NDTPS
        $nilaiData = $labelImport->whereIn('label', ['NI', 'NN', 'NL', 'NDTPS'])->pluck('nilai', 'label');
        $NDTPS = isset($nilaiData['NDTPS']) ? (int) $nilaiData['NDTPS'] : 1; // Hindari pembagian dengan 0

        // Faktor
        $a = 0.05;
        $b = 0.3;
        $c = 1;

        // Hitung nilai RI, RN, RL
        $RI = isset($nilaiData['NI']) ? (int) $nilaiData['NI'] / 3 / $NDTPS : 0;
        $RN = isset($nilaiData['NN']) ? (int) $nilaiData['NN'] / 3 / $NDTPS : 0;
        $RL = isset($nilaiData['NL']) ? (int) $nilaiData['NL'] / 3 / $NDTPS : 0;

        // Terapkan batasan pada RI, RN, RL
        $RI = ($RI >= $a) ? $a : $RI;
        $RN = ($RN >= $b) ? $b : $RN;
        $RL = ($RL >= $c) ? $c : $RL;

        // Hitung A, B, C
        $A = $RI / $a;
        $B = $RN / $b;
        $C = $RL / $c;

        // Hitung skor berdasarkan kondisi
        if ($RI > $a && $RN > $b) {
            $skor = 4;
        } else {
            $skor = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
        }

        // Pastikan skor tidak kurang dari 0
        $skor = max($skor, 0);

        // Dapatkan ID matriks penilaian dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '26')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Kuantitatif Label 26",
            ]
        );

        return $skor;
    }

    public function calculateD427($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport berdasarkan id_prodi dan sheet_name
        $labelImport3b2 = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '3b3')
            ->whereIn('label', ['NI', 'NN', 'NL'])
            ->pluck('nilai', 'label');

        $labelImport3a1 = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '3a1')
            ->where('label', 'NDTPS')
            ->pluck('nilai', 'label');

        // Gabungkan hasil dari kedua query
        $nilaiData = $labelImport3b2->merge($labelImport3a1);

        // Konversi NDTPS menjadi integer dan hindari pembagian dengan 0
        $NDTPS = isset($nilaiData['NDTPS']) ? (int) $nilaiData['NDTPS'] : 1;

        // Faktor
        $a = 0.05;
        $b = 0.3;
        $c = 1;

        // Hitung nilai RI, RN, RL
        $RI = isset($nilaiData['NI']) ? (int) $nilaiData['NI'] / 3 / $NDTPS : 0;
        $RN = isset($nilaiData['NN']) ? (int) $nilaiData['NN'] / 3 / $NDTPS : 0;
        $RL = isset($nilaiData['NL']) ? (int) $nilaiData['NL'] / 3 / $NDTPS : 0;

        // Terapkan batasan pada RI, RN, RL
        if ($RI >= $a && $RN < $b) {
            $RI = $a;
        }
        if ($RI < $a && $RN >= $b) {
            $RN = $b;
        }
        if ($RL >= $c) {
            $RL = $c;
        }

        // Hitung A, B, C
        $A = $RI / $a;
        $B = $RN / $b;
        $C = $RL / $c;

        // Hitung skor berdasarkan kondisi
        if ($RI > $a && $RN > $b) {
            $skor = 4;
        } else {
            $skor = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
        }

        // Pastikan skor tidak kurang dari 0
        $skor = max($skor, 0);

        // Dapatkan ID matriks penilaian dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '27')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Kuantitatif Label 26",
            ]
        );

        return $skor;
    }

    public function calculateD428($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport berdasarkan id_prodi dan sheet_name
        $data3b5 = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '3b5')
            ->whereIn('label', ['NA1', 'NA2', 'NA3', 'NA4', 'NB1', 'NB2', 'NB3', 'NC1', 'NC2', 'NC3'])
            ->pluck('nilai', 'label');

        $data3a1 = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '3a1')
            ->where('label', 'NDTPS')
            ->pluck('nilai', 'label');

        // Ambil nilai NDTPS, default ke 1 jika tidak ditemukan untuk menghindari pembagian dengan 0
        $NDTPS = isset($data3a1['NDTPS']) ? (int) $data3a1['NDTPS'] : 1;

        // Ambil nilai untuk NA1, NA2, NA3, NA4, NB1, NB2, NB3, NC1, NC2, NC3
        $NA1 = isset($data3b5['NA1']) ? (int) $data3b5['NA1'] : 0;
        $NA2 = isset($data3b5['NA2']) ? (int) $data3b5['NA2'] : 0;
        $NA3 = isset($data3b5['NA3']) ? (int) $data3b5['NA3'] : 0;
        $NA4 = isset($data3b5['NA4']) ? (int) $data3b5['NA4'] : 0;
        $NB1 = isset($data3b5['NB1']) ? (int) $data3b5['NB1'] : 0;
        $NB2 = isset($data3b5['NB2']) ? (int) $data3b5['NB2'] : 0;
        $NB3 = isset($data3b5['NB3']) ? (int) $data3b5['NB3'] : 0;
        $NC1 = isset($data3b5['NC1']) ? (int) $data3b5['NC1'] : 0;
        $NC2 = isset($data3b5['NC2']) ? (int) $data3b5['NC2'] : 0;
        $NC3 = isset($data3b5['NC3']) ? (int) $data3b5['NC3'] : 0;

        // Hitung RI, RN, dan RW
        $RI = ($NA4 + $NB3 + $NC3) / $NDTPS;
        $RN = ($NA2 + $NA3 + $NB2 + $NC2) / $NDTPS;
        $RW = ($NA1 + $NB1 + $NC1) / $NDTPS;

        // Faktor a, b, c
        $a = 0.1;
        $b = 1;
        $c = 2;

        // Hitung A, B, C
        $A = $RI / $a;
        $B = $RN / $b;
        $C = $RW / $c;

        // Penyesuaian nilai RI, RN, RW jika melebihi faktor
        if ($RI >= $a && $RN < $b) {
            $RI = $a;
        } elseif ($RI < $a && $RN >= $b) {
            $RN = $b;
        }

        if ($RW >= $c) {
            $RW = $c;
        }

        // Hitung Skor berdasarkan kondisi yang diberikan
        $skor = 0;
        if ($RI > $a && $RN > $b) {
            $skor = 4;
        } elseif (($RI <= $a && $RI > 0) || ($RN <= $b && $RN > 0) || ($RW <= $c && $RW > 0)) {
            $skor = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
        }

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        $anotasiLabel = AnotasiLabel::where('rumus_label', '28')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor Label 27",
            ]
        );
    }

    public function calculateD429($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NAS dan NDTPS
        $nas = $labelImport->where('sheet_name', '3b6')->where('label', 'NAS')->pluck('nilai')->first();
        $ndtps = $labelImport->where('sheet_name', '3a1')->where('label', 'NDTPS')->pluck('nilai')->first();

        // Pastikan NDTPS tidak nol untuk menghindari pembagian dengan nol
        if ($ndtps == 0) {
            throw new \Exception("Nilai NDTPS tidak boleh nol.");
        }

        // Hitung RS
        $rs = floatval($nas) / floatval($ndtps);

        // Hitung skor berdasarkan kondisi RS
        if ($rs >= 0.5) {
            $skor = 4; // Skor 4 jika RS ≥ 0.5
        } else {
            $skor = 2 + (4 * $rs); // Hitung skor jika RS < 0.5
            $skor = max($skor, 2); // Skor tidak boleh kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '29')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 29",
            ]
        );
    }

    public function calculateD430($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NAPJ dan NDTPS
        $napj = $labelImport->where('sheet_name', '3b7')->where('label', 'NAPJ')->pluck('nilai')->first();
        $ndtps = $labelImport->where('sheet_name', '3a1')->where('label', 'NDTPS')->pluck('nilai')->first();

        // Pastikan NDTPS tidak nol untuk menghindari pembagian dengan nol
        if ($ndtps == 0) {
            throw new \Exception("Nilai NDTPS tidak boleh nol.");
        }

        // Hitung RS
        $rs = floatval($napj) / floatval($ndtps);

        // Hitung skor berdasarkan kondisi RS
        if ($rs >= 1) {
            $skor = 4;
        } else {
            $skor = max(2 + (2 * $rs), 2); // Skor tidak boleh kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '30')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 30",
            ]
        );
    }

    public function calculateD431($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NA, NB, NC, ND, dan NDTPS
        $na = $labelImport->where('sheet_name', '3b8-1')->where('label', 'NA')->pluck('nilai')->first();
        $nb = $labelImport->where('sheet_name', '3b8-2')->where('label', 'NB')->pluck('nilai')->first();
        $nc = $labelImport->where('sheet_name', '3b8-3')->where('label', 'NC')->pluck('nilai')->first();
        $nd = $labelImport->where('sheet_name', '3b8-4')->where('label', 'ND')->pluck('nilai')->first();
        $ndtps = $labelImport->where('sheet_name', '3a1')->where('label', 'NDTPS')->pluck('nilai')->first();

        // Pastikan NDTPS tidak nol untuk menghindari pembagian dengan nol
        if ($ndtps == 0) {
            throw new \Exception("Nilai NDTPS tidak boleh nol.");
        }

        // Hitung RLP
        $rlp = (2 * (floatval($na) + floatval($nb) + floatval($nc)) + floatval($nd)) / floatval($ndtps);

        // Hitung skor berdasarkan kondisi RLP
        if ($rlp >= 1) {
            $skor = 4; // Skor 4 jika RLP ≥ 1
        } else {
            $skor = 2 + (2 * $rlp); // Hitung skor jika RLP < 1
            $skor = max($skor, 2); // Skor tidak boleh kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '31')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 31",
            ]
        );
    }

    public function calculateD434($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai DOP
        $dop = $labelImport->where('label', 'DOP')->pluck('nilai')->first();

        // Pastikan nilai DOP valid
        if ($dop === null) {
            throw new \Exception("Nilai DOP tidak ditemukan.");
        }

        $dop = floatval($dop); // Konversi nilai DOP menjadi float

        // Hitung skor berdasarkan kondisi DOP
        if ($dop >= 20000000) {
            $skor = 4; // Skor 4 jika DOP ≥ 20.000.000
        } else {
            $skor = $dop / 5000000; // Hitung skor jika DOP < 20.000.000
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '34')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 34",
            ]
        );
    }

    public function calculateD435($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai DPD
        $dpd = $labelImport->where('label', 'DPD')->pluck('nilai')->first();

        // Pastikan nilai DPD valid
        if ($dpd === null) {
            throw new \Exception("Nilai DPD tidak ditemukan.");
        }

        $dpd = floatval($dpd); // Konversi nilai DPD menjadi float

        // Hitung skor berdasarkan kondisi DPD
        if ($dpd >= 10000000) {
            $skor = 4; // Skor 4 jika DPD ≥ 10.000.000
        } else {
            $skor = (2 * $dpd) / 5000000; // Hitung skor jika DPD < 10.000.000
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '35')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 35",
            ]
        );
    }

    public function calculateD436($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai DPkMD
        $dpkmd = $labelImport->where('label', 'DPkMD')->pluck('nilai')->first();

        // Pastikan nilai DPkMD valid
        if ($dpkmd === null) {
            throw new \Exception("Nilai DPkMD tidak ditemukan.");
        }

        $dpkmd = floatval($dpkmd); // Konversi nilai DPkMD menjadi float

        // Hitung skor berdasarkan kondisi DPkMD
        if ($dpkmd >= 5000000) {
            $skor = 4; // Skor 4 jika DPkMD ≥ 5.000.000
        } else {
            $skor = (4 * $dpkmd) / 5000000; // Hitung skor jika DPkMD < 5.000.000
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '36')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 36",
            ]
        );
    }

    public function calculateD444($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai JP dan JB
        $jp = $labelImport->where('label', 'JP')->pluck('nilai')->first();
        $jb = $labelImport->where('label', 'JB')->pluck('nilai')->first();

        // Pastikan nilai JP dan JB valid
        if ($jp === null || $jb === null) {
            throw new \Exception("Nilai JP atau JB tidak ditemukan.");
        }

        $jp = floatval($jp); // Konversi nilai JP menjadi float
        $jb = floatval($jb); // Konversi nilai JB menjadi float

        // Hitung PJP
        $pjp = ($jp / $jb) * 100;

        // Hitung skor berdasarkan kondisi PJP
        if ($pjp >= 30) {
            $skor = 4; // Skor 4 jika PJP ≥ 50%
        } else {
            $skor = (40 * $pjp) / 3; // Hitung skor jika PJP < 50%
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '44')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 44",
            ]
        );
    }

    public function calculateD450($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NMKI
        $nmki = $labelImport->where('label', 'NMKI')->pluck('nilai')->first();

        // Pastikan nilai NMKI valid
        if ($nmki === null) {
            throw new \Exception("Nilai NMKI tidak ditemukan.");
        }

        $nmki = floatval($nmki); // Konversi nilai NMKI menjadi float

        if ($nmki > 3) {
            $skor = 4; // Skor 4 jika NMKI > 3
        } elseif ($nmki >= 2 && $nmki <= 3) {
            $skor = 3; // Skor 3 jika NMKI antara 2 dan 3 (inklusif)
        } elseif ($nmki == 1) {
            $skor = 2; // Skor 2 jika NMKI = 1
        } else {
            $skor = 0; // Skor 1 jika NMKI < 1
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '50')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 45",
            ]
        );
    }

    //blm tny cipiti
    public function calculateD452($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->where('sheet_name', '5d')->get();

        // Ambil nilai NMKI
        $ai1 = $labelImport->whereIn('label', ['ai1', 'bi1', 'ci1', 'di1'])->pluck('nilai', 'label');
        $ai2 = $labelImport->whereIn('label', ['ai2', 'bi2', 'ci2', 'di2'])->pluck('nilai', 'label');
        $ai3 = $labelImport->whereIn('label', ['ai3', 'bi3', 'ci3', 'di3'])->pluck('nilai', 'label');
        $ai4 = $labelImport->whereIn('label', ['ai4', 'bi4', 'ci4', 'di4'])->pluck('nilai', 'label');
        $ai5 = $labelImport->whereIn('label', ['ai5', 'bi5', 'ci5', 'di5'])->pluck('nilai', 'label');

        $tkmVar1 = array_merge($ai1->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm1 = $this->evaluator->evaluate('(4 x ai1) + (3 x bi1) + (2 x ci1) + di1', $tkmVar1);
        $tkm1Ori = $tkm1['result'];
        $tkm1Conv = floatval(str_replace(',', '.', $tkm1Ori));

        $tkmVar2 = array_merge($ai2->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm2 = $this->evaluator->evaluate('(4 x ai2) + (3 x bi2) + (2 x ci2) + di2', $tkmVar2);
        $tkm2Ori = $tkm2['result'];
        $tkm2Conv = floatval(str_replace(',', '.', $tkm2Ori));

        $tkmVar3 = array_merge($ai3->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm3 = $this->evaluator->evaluate('(4 x ai3) + (3 x bi3) + (2 x ci3) + di3', $tkmVar3);
        $tkm3Ori = $tkm3['result'];
        $tkm3Conv = floatval(str_replace(',', '.', $tkm3Ori));

        $tkmVar4 = array_merge($ai4->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm4 = $this->evaluator->evaluate('(4 x ai4) + (3 x bi4) + (2 x ci4) + di4', $tkmVar4);
        $tkm4Ori = $tkm4['result'];
        $tkm4Conv = floatval(str_replace(',', '.', $tkm4Ori));

        $tkmVar5 = array_merge($ai5->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $tkm5 = $this->evaluator->evaluate('(4 x ai5) + (3 x bi5) + (2 x ci5) + di5', $tkmVar5);
        $tkm5Ori = $tkm5['result'];
        $tkm5Conv = floatval(str_replace(',', '.', $tkm5Ori));

        $tkm = ($tkm1Conv + $tkm2Conv + $tkm3Conv + $tkm4Conv + $tkm5Conv) / 5;

        if ($tkm >= 75) {
            $skor = 4.0;
        } elseif ($tkm >= 25 && $tkm < 75) {
            $skor = (8 * $tkm) - 2;
        } elseif ($tkm < 25) {
            $skor = 0.0;
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '47')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 45",
            ]
        );
    }

    public function calculateD454($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NPM dan NPD
        $npm = $labelImport->where('sheet_name', '6a')->where('label', 'NPM')->pluck('nilai')->first();
        $npd = $labelImport->where('sheet_name', '3b2')->where('label', 'NPD')->pluck('nilai')->first();

        // Pastikan NPD tidak nol untuk menghindari pembagian dengan nol
        if ($npd == 0) {
            throw new \Exception("Nilai NPD tidak boleh nol.");
        }

        // Hitung PPDM
        $ppdm = (floatval($npm) / floatval($npd)) * 100;

        // Hitung skor berdasarkan kondisi PPDM
        if ($ppdm >= 25) {
            $skor = 4; // Skor 4 jika PPDM ≥ 25%
        } else {
            $skor = 2 + (8 * $ppdm); // Hitung skor jika PPDM < 25%
            $skor = max($skor, 2); // Skor tidak boleh kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '54')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 54",
            ]
        );
    }

    public function calculateD456($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NPkMM dan NPkMD
        $npkmm = $labelImport->where('label', 'NPkMM')->pluck('nilai')->first();
        $npkmd = $labelImport->where('label', 'NPkMD')->pluck('nilai')->first();

        // Pastikan nilai NPkMM dan NPkMD valid
        if ($npkmm === null || $npkmd === null || $npkmd == 0) {
            throw new \Exception("Nilai NPkMM atau NPkMD tidak ditemukan atau NPkMD tidak boleh 0.");
        }

        $npkmm = floatval($npkmm); // Konversi nilai NPkMM menjadi float
        $npkmd = floatval($npkmd); // Konversi nilai NPkMD menjadi float

        // Hitung PPkMDM
        $ppkmdm = ($npkmm / $npkmd) * 100;

        // Hitung skor berdasarkan nilai PPkMDM
        if ($ppkmdm >= 25) {
            $skor = 4; // Skor 4 jika PPkMDM ≥ 25%
        } elseif ($ppkmdm < 25) {
            $skor = 2 + (8 * $ppkmdm); // Skor 2 + (8 × PPkMDM) jika PPkMDM < 25%
        } else {
            $skor = 1; // Skor 1 jika data tidak sesuai
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '56')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 56",
            ]
        );
    }

    public function calculateD458($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai NPkMM dan NPkMD
        $ipk = $labelImport->where('label', 'IPKs')->pluck('nilai')->first();
        $ipk1 = $labelImport->where('label', 'IPKs-1')->pluck('nilai')->first();
        $ipk2 = $labelImport->where('label', 'IPKs-2')->pluck('nilai')->first();

        // Hitung PPkMDM
        $ripk = ($ipk + $ipk1 + $ipk2) / 3;
        $ori = $ripk['result'];
        $rIpk = floatval(str_replace(',', '.', $ori));

        // Hitung skor berdasarkan nilai PPkMDM
        if ($rIpk >= 3.25) {
            $skor = 4.0; // Skor 4 jika PPkMDM ≥ 25%
        } elseif ($rIpk >= 2.00 && $rIpk < 3.25) {
            $skor = ((8 * $rIpk) - 6) / 5;
        } else {
            $skor = 2; // Tidak ada skor kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '58')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 52",
            ]
        );
    }

    public function calculateD459($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->whereIn('sheet_name', ['8b1', '2a2'])
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NI', 'NN', 'NW', 'NM'])->pluck('nilai', 'label');

        // Definisikan faktor
        $faktor = [
            'a' => 0.1,
            'b' => 1,
            'c' => 2,
        ];

        // Konversi nilai dari LabelImport ke integer
        $val = $val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray();

        // Hitung nilai RI, RN, dan RW
        $ri = $val['NI'] / $val['NM'];
        $rn = $val['NN'] / $val['NM'];
        $rw = $val['NW'] / $val['NM'];

        // Terapkan batasan jika nilai RI, RN, atau RW melebihi batasan
        $ri = min($ri, $faktor['a']);
        $rn = min($rn, $faktor['b']);
        $rw = min($rw, $faktor['c']);

        // Hitung A, B, dan C
        $A = $ri / $faktor['a'];
        $B = $rn / $faktor['b'];
        $C = $rw / $faktor['c'];

        // Hitung skor berdasarkan kriteria
        if ($ri > $faktor['a'] && $rn > $faktor['b']) {
            $skor = 4;
        } else {
            $formula = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
            $skor = max(0, $formula); // Pastikan skor tidak negatif
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '59')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 53",
            ]
        );
    }

    public function calculateD460($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->whereIn('sheet_name', ['8b2', '2a2'])
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NI', 'NN', 'NW', 'NM'])->pluck('nilai', 'label');

        // Definisikan faktor
        $faktor = [
            'a' => 0.2,  // 0.1%
            'b' => 2,    // 2%
            'c' => 4,    // 4%
        ];

        // Konversi nilai dari LabelImport ke integer
        $val = $val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray();

        // Hitung nilai RI, RN, dan RW
        $ri = $val['NI'] / $val['NM'];
        $rn = $val['NN'] / $val['NM'];
        $rw = $val['NW'] / $val['NM'];

        // Terapkan batasan
        $ri = min($ri, $faktor['a']);
        $rn = min($rn, $faktor['b']);
        $rw = min($rw, $faktor['c']);

        // Terapkan batasan tambahan berdasarkan kondisi
        if ($ri >= $faktor['a'] && $rn < $faktor['b']) {
            $ri = $faktor['a'];
        }
        if ($ri < $faktor['a'] && $rn >= $faktor['b']) {
            $rn = $faktor['b'];
        }
        if ($rw >= $faktor['c']) {
            $rw = $faktor['c'];
        }

        // Hitung A, B, dan C
        $A = $ri / $faktor['a'];
        $B = $rn / $faktor['b'];
        $C = $rw / $faktor['c'];

        // Hitung skor berdasarkan kriteria
        if ($ri > $faktor['a'] && $rn > $faktor['b']) {
            $skor = 4;
        } else {
            $formula = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
            $skor = max(0, $formula); // Pastikan skor tidak negatif
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '60')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 54",
            ]
        );
    }

    public function calculateD461($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8c')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['c', 'f', 'b', 'e'])->pluck('nilai', 'label');

        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $ms = $this->evaluator->evaluate('((( c + f) * 4) + ((b + e) * 5)) / c+f+b+e', $var);

        $msOriginal = $ms['result']; // Akses langsung nilai result
        $msConverted = floatval(str_replace(',', '.', $msOriginal));

        if ($msConverted >= 3.5 && $msConverted <= 4.5) {
            $skor = 4.0;
        } elseif ($msConverted > 4.5 && $msConverted <= 7) {
            $skor = (56 - (8 * $msConverted)) / 5;
        } elseif ($msConverted < 3) {
            $skor = 0;
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '61')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 55",
            ]
        );
    }

    public function calculateD462($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8c')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['c', 'f', 'a', 'd'])->pluck('nilai', 'label');

        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $ptw = $this->evaluator->evaluate('( c + f) / (a + d)', $var);

        $ptwOriginal = $ptw['result']; // Akses langsung nilai result
        $ptwConverted = floatval(str_replace(',', '.', $ptwOriginal)); // Konversi menjadi float

        // Terapkan batasan tambahan berdasarkan kondisi
        if ($ptwConverted >= 70) {
            $skor = 4.0;
        } elseif ($ptwConverted < 70) {
            $skor = 1 + ((30 * $ptwConverted) / 7);
        } else {
            $skor = 0;
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '62')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 56",
            ]
        );
    }

    public function calculateD463($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8c')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['c', 'f', 'a', 'd', 'b', 'e'])->pluck('nilai', 'label');

        $var = array_merge($val->mapWithKeys(fn($nilai, $label) => [$label => (int)$nilai])->toArray());
        $mdo = $this->evaluator->evaluate('(((a + d) - (c + f + b + e)) / (a + d)) * 100', $var);

        $mdoOriginal = $mdo['result']; // Akses langsung nilai result
        $mdoConverted = floatval(str_replace(',', '.', $mdoOriginal)); // Konversi menjadi float

        // Terapkan batasan tambahan berdasarkan kondisi
        if ($mdoConverted >= 6) {
            $skor = 4.0;
        } elseif ($mdoConverted > 6  && $mdoConverted < 45) {
            $skor = (180 - (400 * $mdoConverted)) / 39;
        } elseif ($mdoConverted >= 45) {
            $skor = 0.0;
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '63')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 63",
            ]
        );
    }

    public function calculateD465($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8d1')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NL', 'NJ', 'N-WT3', 'N-WT36', 'N-WT6'])->pluck('nilai', 'label');

        // Konversi nilai menjadi array yang bisa dipakai untuk evaluasi
        $var = $val->mapWithKeys(fn($nilai, $label) => [$label => (float)$nilai])->toArray();

        // Hitung persentase lulusan yang terlacak (PJ)
        $pj = $this->evaluator->evaluate('(NJ/NL) * 100', $var);
        $pjConverted = floatval($pj['result']); // Konversi hasil menjadi float

        // Hitung Prmin berdasarkan jumlah lulusan (NL)
        $nl = $var['NL'] ?? 0;
        $prmin = $nl >= 300 ? 30 : 50 - (($nl / 300) * 20);

        // Skor awal berdasarkan waktu tunggu (WT)
        if ($var['N-WT3'] < 3) {
            $skor = 4.0;
        } elseif ($var['N-WT36'] >= 3 && $var['N-WT36'] <= 6) {
            $skor = (24 - (4 * $var['N-WT36'])) / 3;
        } elseif ($var['N-WT6'] > 6) {
            $skor = 0.0;
        } else {
            $skor = 0.0; // Tambahan pengaman jika kondisi di atas tidak terpenuhi
        }

        // Sesuaikan skor akhir berdasarkan persentase responden (PJ)
        if ($pjConverted < $prmin) {
            $skorAkhir = ($pjConverted / $prmin) * $skor;
        } else {
            $skorAkhir = $skor;
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '65')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skorAkhir,
                'deskripsi' => "Hasil Skor berdasarkan label 65",
            ]
        );
    }

    public function calculateD466($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8d2')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NL', 'NJ', 'PBS-t'])->pluck('nilai', 'label');

        // Konversi nilai menjadi array yang bisa dipakai untuk evaluasi
        $var = $val->mapWithKeys(fn($nilai, $label) => [$label => (float)$nilai])->toArray();

        // Hitung persentase lulusan yang terlacak (PJ)
        $nl = $var['NL'] ?? 0;
        $nj = $var['NJ'] ?? 0;
        $h = $var['PBS-t'] ?? 0;
        $pj = ($nl > 0) ? ($nj / $nl) * 100 : 0;

        // Hitung Prmin berdasarkan jumlah lulusan (NL)
        $prmin = $nl >= 300 ? 30 : 50 - (($nl / 300) * 20);

        // Hitung PBS
        $pbs = ($h / $nj) * 100;

        // Hitung skor berdasarkan PBS
        $skor = $pbs >= 80 ? 4 : 5 * $pbs;

        // Sesuaikan skor akhir berdasarkan persentase responden (PJ) dan Prmin
        $skorAkhir = $pj >= $prmin ? $skor : ($pj / $prmin) * $skor;

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '66')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
                'nilai' => $skorAkhir,
                'deskripsi' => "Hasil Skor berdasarkan label 66",
            ]
        );
    }

    public function calculateD4Label67($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8e1')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', ['NI', 'NN', 'NW', 'NL'])->pluck('nilai', 'label');

        // Konversi nilai menjadi array yang bisa dipakai untuk evaluasi
        $var = $val->mapWithKeys(fn($nilai, $label) => [$label => (float)$nilai])->toArray();

        // Ambil jumlah lulusan dan lulusan yang bekerja
        $ni = $var['NI'] ?? 0;
        $nn = $var['NN'] ?? 0;
        $nw = $var['NW'] ?? 0;
        $nl = $var['NL'] ?? 0;

        // Hitung RI, RN, RW
        $ri = $nl > 0 ? ($ni / $nl) * 100 : 0;
        $rn = $nl > 0 ? ($nn / $nl) * 100 : 0;
        $rw = $nl > 0 ? ($nw / $nl) * 100 : 0;

        // Faktor
        $a = 5.0;
        $b = 20.0;
        $c = 90.0;

        // Hitung A, B, C
        $aFactor = $a > 0 ? $ri / $a : 0;
        $bFactor = $b > 0 ? $rn / $b : 0;
        $cFactor = $c > 0 ? $rw / $c : 0;

        // Hitung Skor
        if ($ri > $a && $rn > $b) {
            $skor = 4.0;
        } else {
            $skor = 3.75 * (($aFactor + $bFactor + ($cFactor / 2)) - ($aFactor * $bFactor) - (($aFactor * $cFactor) / 2) - (($bFactor * $cFactor) / 2) + (($aFactor * $bFactor * $cFactor) / 2));
        }

        // Hitung Prmin berdasarkan jumlah lulusan (NL)
        $prmin = $nl >= 300 ? 30 : 50 - (($nl / 300) * 20);

        // Hitung persentase lulusan yang terlacak (PJ)
        $nj = $ni + $nn + $nw;
        $pj = $nl > 0 ? ($nj / $nl) * 100 : 0;

        // Sesuaikan skor akhir berdasarkan PJ dan Prmin
        $skorAkhir = $pj >= $prmin ? $skor : ($pj / $prmin) * $skor;

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '67')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skorAkhir,
                'deskripsi' => "Hasil Skor berdasarkan label 67",
            ]
        );
    }

    public function calculateD4Label68($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->whereIn('sheet_name', ['8e2', '8e1'])
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $val = $labelImport->whereIn('label', [
            'a1',
            'b1',
            'c1',
            'd1',
            'a2',
            'b2',
            'c2',
            'd2',
            'a3',
            'b3',
            'c3',
            'd3',
            'a4',
            'b4',
            'c4',
            'd4',
            'a5',
            'b5',
            'c5',
            'd5',
            'a6',
            'b6',
            'c6',
            'd6',
            'a7',
            'b7',
            'c7',
            'd7',
            'NL',
            'NJ-tanggapan'
        ])
            ->pluck('nilai', 'label');

        // Konversi nilai menjadi array yang bisa dipakai untuk evaluasi
        $var = $val->mapWithKeys(fn($nilai, $label) => [$label => (float)$nilai])->toArray();

        // Ambil nilai yang diperlukan
        $nl = $var['NL'] ?? 0;
        $nj = $var['NJ-tanggapan'] ?? 0;

        // Hitung persentase responden yang memberi tanggapan (PJ)
        $pj = $nl > 0 ? ($nj / $nl) * 100 : 0;

        // Hitung Prmin berdasarkan jumlah lulusan (NL)
        $prmin = $nl >= 300 ? 30 : 50 - (($nl / 300) * 20);

        // Hitung skor untuk setiap aspek
        $totalTK = 0;
        for ($i = 1; $i <= 7; $i++) {
            $ai = $var["a$i"] ?? 0;
            $bi = $var["b$i"] ?? 0;
            $ci = $var["c$i"] ?? 0;
            $di = $var["d$i"] ?? 0;

            $tk = (4 * $ai) + (3 * $bi) + (2 * $ci) + $di;
            $totalTK += $tk;
        }

        // Hitung skor akhir
        $skor = $nl > 0 ? $totalTK / 7 : 0;
        $skorAkhir = $pj >= $prmin ? $skor : ($pj / $prmin) * $skor;

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '68')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skorAkhir,
                'deskripsi' => "Hasil Skor berdasarkan label 68",
            ]
        );
    }

    public function calculateD469($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai dari masing-masing variabel yang dibutuhkan
        $na1 = $labelImport->where('sheet_name', '8f2')->where('label', 'NA1')->pluck('nilai')->first();
        $na2 = $labelImport->where('sheet_name', '8f2')->where('label', 'NA2')->pluck('nilai')->first();
        $na3 = $labelImport->where('sheet_name', '8f2')->where('label', 'NA3')->pluck('nilai')->first();
        $na4 = $labelImport->where('sheet_name', '8f2')->where('label', 'NA4')->pluck('nilai')->first();
        $nb1 = $labelImport->where('sheet_name', '8f2')->where('label', 'NB1')->pluck('nilai')->first();
        $nb2 = $labelImport->where('sheet_name', '8f2')->where('label', 'NB2')->pluck('nilai')->first();
        $nb3 = $labelImport->where('sheet_name', '8f2')->where('label', 'NB3')->pluck('nilai')->first();
        $nc1 = $labelImport->where('sheet_name', '8f2')->where('label', 'NC1')->pluck('nilai')->first();
        $nc2 = $labelImport->where('sheet_name', '8f2')->where('label', 'NC2')->pluck('nilai')->first();
        $nc3 = $labelImport->where('sheet_name', '8f2')->where('label', 'NC3')->pluck('nilai')->first();
        $nm = $labelImport->where('sheet_name', '8f2')->where('label', 'NM')->pluck('nilai')->first();

        // Faktor yang digunakan
        $a = 1; // 1%
        $b = 10; // 10%
        $c = 50; // 50%

        // Pastikan NM tidak nol untuk menghindari pembagian dengan nol
        if ($nm == 0) {
            throw new \Exception("Nilai NM tidak boleh nol.");
        }

        // Hitung RL, RN, RI
        $rl = ((floatval($na1) + floatval($nb1) + floatval($nc1)) / floatval($nm)) * 100;
        $rn = ((floatval($na2) + floatval($na3) + floatval($nb2) + floatval($nc2)) / floatval($nm)) * 100;
        $ri = ((floatval($na4) + floatval($nb3) + floatval($nc3)) / floatval($nm)) * 100;

        // A, B, C
        $A = $ri / $a;
        $B = $rn / $b;
        $C = $rl / $c;

        // Koreksi nilai RI, RN, RL
        if ($ri >= $a && $rn < $b) {
            $ri = $a;
        }
        if ($ri < $a && $rn >= $b) {
            $rn = $b;
        }
        if ($rl >= $c) {
            $rl = $c;
        }

        // Hitung skor berdasarkan kondisi
        if ($ri > $a && $rn > $b) {
            $skor = 4; // Skor 4 jika RI > a dan RN > b
        } else {
            // Hitung skor jika 0 < RI ≤ a, atau 0 < RN ≤ b, atau 0 < RL ≤ c
            $skor = 3.75 * (($A + $B + ($C / 2)) - ($A * $B) - (($A * $C) / 2) - (($B * $C) / 2) + (($A * $B * $C) / 2));
            $skor = max($skor, 2); // Skor tidak boleh kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '69')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 69",
            ]
        );
    }

    public function calculateD4Label63($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)
            ->where('sheet_name', '8f4')
            ->get();

        // Ambil nilai dari LabelImport berdasarkan label yang diperlukan
        $napj = $labelImport->where('label', 'NAPJ')->pluck('nilai');

        if ($napj >= 2) {
            $skor = 4;
        } elseif ($napj == 1) {
            $skor = 3;
        } else {
            $skor = 2;
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '63')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 63",
            ]
        );
    }

    public function calculateD471($id_prodi, $jenjangId)
    {
        // Ambil data dari LabelImport untuk program studi yang ditentukan
        $labelImport = LabelImport::where('program_studi_id', $id_prodi)->get();

        // Ambil nilai dari masing-masing variabel yang dibutuhkan
        $na = $labelImport->where('sheet_name', '8f5')->where('label', 'NA')->pluck('nilai')->first();
        $nb = $labelImport->where('sheet_name', '8f5')->where('label', 'NB')->pluck('nilai')->first();
        $nc = $labelImport->where('sheet_name', '8f5')->where('label', 'NC')->pluck('nilai')->first();
        $nd = $labelImport->where('sheet_name', '8f5')->where('label', 'ND')->pluck('nilai')->first();

        // Hitung NLP
        $nlp = 2 * (floatval($na) + floatval($nb) + floatval($nc)) + floatval($nd);

        // Hitung skor berdasarkan kondisi
        if ($nlp >= 1) {
            $skor = 4; // Skor 4 jika NLP ≥ 1
        } else {
            $skor = 2 + (2 * $nlp); // Skor = 2 + (2 x NLP) jika NLP < 1
            $skor = max($skor, 2); // Skor tidak boleh kurang dari 2
        }

        // Ambil id matriks dari AnotasiLabel
        $anotasiLabel = AnotasiLabel::where('rumus_label', '71')->where('jenjang_id', $jenjangId)->first();
        $idMatriks = $anotasiLabel ? $anotasiLabel->matriks_penilaian_id : null;

        // Simpan nilai ke dalam tabel AsesmenKecukupan
        AsesmenKecukupan::updateOrCreate(
            [
                'matriks_penilaian_id' => $idMatriks,
            ],
            [
                'nilai' => $skor,
                'deskripsi' => "Hasil Skor berdasarkan label 8f5",
            ]
        );
    }
}
