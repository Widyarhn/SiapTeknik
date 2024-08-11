<?php

namespace App\Http\Controllers;

use App\Models\AsesmenKecukupan;
use App\Models\Kriteria;
use App\Models\Suplemen;
use App\Models\Indikator;
use App\Models\UserAsesor;
use App\Models\DeskEvaluasi;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\AsesmenLapangan;
use App\Models\MatriksPenilaian;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class RekapPenilaianController extends Controller
{

    public function prodi($id_prodi)
    {
        $matrixId = AsesmenKecukupan::where('user_asesor_id', Auth::user()->user_asesor->id)->pluck('matriks_penilaian_id');
        $matrixs = MatriksPenilaian::whereIn('id', $matrixId)->get();
        $indicatorsId = $matrixs->pluck('indikator_id');
        $indicators = Indikator::with(['matriks.kriteria', 'matriks.asesmen_kecukupan', 'sub_kriteria.kriteria'])->whereIn('id', $indicatorsId)->get();

        $data = []; // Inisialisasi array untuk menyimpan data yang akan ditampilkan

        // Mengelompokkan data indikator berdasarkan kriteria dan sub kriteria
        try {
            foreach ($indicators as $ind) {
                $kriteriaId = $matrixs->where('indikator_id', $ind->id)->first()->kriteria_id;
                if ($ind->sub_kriteria) {
                    $data[$kriteriaId][$ind->sub_kriteria->id][$ind->id] = $ind;
                } else {
                    $data[$kriteriaId]['x'][$ind->id] = $ind;
                }
            }
        } catch (\Exception $e) {
            // Debugging jika terjadi error
            dd($e->getMessage(), $matrixs);
        }

        // Menggabungkan data yang akan dikirim ke view
        $d = [
            'data' => $data,
        ];


        // try {
        //     foreach ($indicators as $ind) {
        //         if ($ind->sub_kriteria)
        //             $data[$matrixs->where('indikator_id', $ind->id)->first()->kriteria_id][$ind->sub_kriteria->id][$ind->id] = $ind;
        //         else
        //             $data[$matrixs->where('indikator_id', $ind->id)->first()->kriteria_id]['x'][$ind->id] = $ind;
        //     }
        // } catch (\Exception $e) {
        //     dd($e->getMessage(), $ind, $matrixs);
        // }
        $program_studi = ProgramStudi::findOrFail($id_prodi);

        // dd($data);
        $total = 0.0;
        // $user_asesor = UserAsesor::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        // $kriteria = Kriteria::first();
        // $matriks_penilaian = MatriksPenilaian::get();

        // $matriks = DeskEvaluasi::where("matriks_penilaian_id", "!=", null)->where("program_studi_id", $user_asesor->program_studi->id)->where("tahun_id", $user_asesor->tahun_id)
        //     ->get();

        // $data = DeskEvaluasi::where('program_studi_id', $user_asesor->program_studi_id)
        //     ->where("tahun_id", $user_asesor->tahun_id)
        //     ->with(["matriks_penilaian.indikator", "matriks_penilaian.sub_kriteria", "matriks_penilaian.kriteria"])
        //     ->get()
        //     ->groupBy('matriks_penilaian.sub_kriteria_id');

        // $data = MatriksPenilaian::where()

        // dd($data);

        // foreach ($data as $kriterias) {
        //     foreach ($kriterias as $subKriterias) {
        //         foreach ($subKriterias as $indicator) {
        //             $total += ($indicator->bobot* $indicator->matriks->desk_evaluasi->nilai);

        //         }
        //     }
        //     // $total += $item->nilai * $item->matriks_penilaian->indikator->bobot;
        // }

        // dd($total);

        return view('asesor.rekap-penilaian.d3.awal', $d, [ 'program_studi' => $program_studi, 'user_asesor' => Auth::user()->user_asesor]);
    }

    public function prodiasesmen($id_prodi)
    {
        $matrixId = AsesmenLapangan::where('user_asesor_id', Auth::user()->user_asesor->id)->pluck('matriks_penilaian_id');
        $matrixs = MatriksPenilaian::whereIn('id', $matrixId)->get();
        $indicatorsId = $matrixs->pluck('indikator_id');
        $indicators = Indikator::with(['matriks.kriteria', 'matriks.asesmen_lapangan', 'sub_kriteria.kriteria'])->whereIn('id', $indicatorsId)->get();

        try {
            foreach ($indicators as $ind) {
                if ($ind->sub_kriteria)
                    $data[$matrixs->where('indikator_id', $ind->id)->first()->kriteria_id][$ind->sub_kriteria->id][$ind->id] = $ind;
                else
                    $data[$matrixs->where('indikator_id', $ind->id)->first()->kriteria_id]['x'][$ind->id] = $ind;
            }
        } catch (\Exception $e) {
            dd($e->getMessage(), $matrixs);
        }
        $program_studi = ProgramStudi::findOrFail($id_prodi);

        // $user_asesor = UserAsesor::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        // $kriteria = Kriteria::first();
        // $matriks_penilaian = MatriksPenilaian::get();
        // $program_studi = ProgramStudi::findOrFail($id_prodi);
        // $matriks = AsesmenLapangan::where("matriks_penilaian_id", "!=", null)->where("program_studi_id", $user_asesor->program_studi->id)->where("tahun_id", $user_asesor->tahun_id)->get();

        //     return view('asesor.rekap-penilaian.d3.akhir', ['program_studi' => $program_studi, 'matriks_penilaian' => $matriks_penilaian, "matriks" => $matriks, 'user_asesor' => $user_asesor]);
        // }
        return view('asesor.rekap-penilaian.d3.akhir', ['data' => $data, 'program_studi' => $program_studi, 'user_asesor' => Auth::user()->user_asesor]);
    }

    public function json(Request $request, $id_prodi)
    {
        $kriteria = Kriteria::first();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();

        $data = AsesmenKecukupan::where('user_asesor.program_studi_id', $user_asesor->program_studi_id)
            ->where("user_asesor.tahun_id", $user_asesor->tahun_id)
            ->with(["matriks_penilaian.indikator", "matriks_penilaian.sub_kriteria", "matriks_penilaian.kriteria"])
            ->get()
            ->groupBy('matriks_penilaian.sub_kriteria_id');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sub_kriteria', function ($group) {
                $firstRow = $group->first();
                if ($firstRow->matriks_penilaian->sub_kriteria != null) {
                    return $firstRow->matriks_penilaian->sub_kriteria->sub_kriteria;
                } else {
                    return $firstRow->matriks_penilaian->kriteria->kriteria;
                }
            })
            ->addColumn('no_butir', function ($group) {
                $noButirs = $group->pluck('matriks_penilaian.indikator.no_butir')->unique()->filter();
                // return $noButirs->isNotEmpty() ? $noButirs->implode(', ') : ' ';
                // dd(count($noButirs));
                // if(count($noButirs) > 0){
                //     dd($noButirs);
                // }
                // $butirs = count($noButirs) > 0? '<table>
                //     <tr>
                //         <td>
                //             ' . ($noButirs ? $noButirs : '').'
                //         </td>
                //     </tr>
                // </table>': '-';
                $butirs = '';
                if (count($noButirs) > 0) {
                    foreach ($noButirs as $item) {
                        $butirs .=    '<table>
                    <tr>
                        <td>
                            ' . $item . '
                        </td>
                    </tr>
                </table>';
                    }
                } else {
                    $butirs = '-';
                }
                return $butirs;
            })
            ->addColumn('deskripsi', function ($group) {
                $desk = $group->pluck('deskripsi')->unique()->filter();
                $deskriptor = '';
                if (count($desk) > 0) {
                    foreach ($desk as $item) {
                        $deskriptor .=  '<table>
                    <tr>
                        <td>
                            ' . $item . '
                        </td>
                    </tr>
                </table>';
                    }
                } else {
                    $deskriptor = '-';
                }
                return $deskriptor;
                // return $group->first()->deskripsi ?? ' ';
            })
            ->addColumn('nilai', function ($group) {
                $nilai = $group->pluck('nilai')->unique()->filter();
                $skor = '';
                if (count($nilai) > 0) {
                    foreach ($nilai as $item) {
                        $skor .=  '<table>
                    <tr>
                        <td>
                            ' . $item . '
                        </td>
                    </tr>
                </table>';
                    }
                } else {
                    $skor = '-';
                }
                return $skor;
            })
            ->addColumn('bobot', function ($group) {
                $bobotss = $group->pluck('matriks_penilaian.indikator.bobot')->filter();
                $bobots = '';
                if (count($bobotss) > 0) {
                    foreach ($bobotss as $item) {
                        $bobots .=  '<table>
                    <tr>
                        <td>
                            ' . $item . '
                        </td>
                    </tr>
                </table>';
                    }
                } else {
                    $bobots = '-';
                }
                return $bobots;
            })
            ->addColumn('nilai_bobot', function ($group) {
                $totalTerbobot = $group->sum(function ($item) {
                    return $item->nilai * $item->matriks_penilaian->indikator->bobot;
                });
                return '<span class="badge badge-info">' . $totalTerbobot . '</span>';
            })
            ->rawColumns(['sub_kriteria', 'no_butir', 'deskripsi', 'bobot', 'nilai', 'nilai_bobot'])
            ->make(true);
    }



    public function jsonAkhir(Request $request, $id_prodi)
    {
        // $data = DeskEvaluasi::with('matriks_penilaian.kriteria')->where('program_studi_id', $id_prodi)->get();
        $kriteria = Kriteria::first();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        $matriks_penilaian = MatriksPenilaian::get();
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();

        $data = AsesmenLapangan::where('program_studi_id', $user_asesor->program_studi_id)
            ->where("tahun_id", $user_asesor->tahun_id)
            ->with(["matriks_penilaian"])
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sub_kriteria', function ($row) {
                if ($row->matriks_penilaian->sub_kriteria != null) {
                    return $row->matriks_penilaian->sub_kriteria->sub_kriteria;
                } else {
                    return $row->matriks_penilaian->kriteria->kriteria;
                }
            })
            ->addColumn('deskripsi', function ($row) {
                if ($row->deskripsi) {
                    return $row->deskripsi;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai', function ($row) {
                if ($row->nilai) {
                    return $row->nilai;
                } else {
                    return ' ';
                }
            })
            ->addColumn('bobot', function ($row) {
                if ($row->matriks_penilaian != null) {
                    return $row->matriks_penilaian->indikator->bobot;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai_bobot', function ($row) {
                if ($row->matriks_penilaian != null) {
                    return '<span class="badge badge-info">' . $row->nilai * $row->matriks_penilaian->indikator->bobot . '</span>';
                } else {
                    return ' ';
                }
            })
            ->rawColumns(['butir', 'deskripsi', 'nilai', 'nilai_bobot'])
            ->make(true);
    }


    public function show($id)
    {
        //
    }
}
