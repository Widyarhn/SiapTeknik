<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\UserProdi;
use App\Models\DataDukung;
use App\Models\UserAsesor;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\AsesmenLapangan;
use App\Models\MatriksPenilaian;
use Illuminate\Support\Facades\Auth;

class DashboardProdiController extends Controller
{
    public function index(Request $request)
    {
        // $data = [
        //     "user_prodi" => UserProdi::where('user_id', Auth::user()->id)->first(),
        //     "instrumen_d3" => Instrumen::where('jenjang_id', 1)->count(),
        //     "instrumen_d4" => Instrumen::where('jenjang_id', 2)->count(),
        //     "data_dukung" => DataDukung:: where('jenjang_id', 1)->count()
        // ];

        // return view('prodi.layout.main', $data);

        $user_prodi = UserProdi::where('user_id', Auth::user()->id)->first();
        $timeline = Timeline::with(['user_asesor' => function ($q) use ($user_prodi) {
            $q->where('program_studi_id', $user_prodi->program_studi_id);
        }])->get();
        return view('prodi.layout.main',['user_prodi'=>$user_prodi, 'timeline' => $timeline]);
        
    }

    public function beritaAcara($id)
    {
        $matrixId = AsesmenLapangan::where('user_asesor_id', $id)->pluck('matriks_penilaian_id');
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

        $user_asesor = UserAsesor::with('tahun')->where("id", $id)->first();
        // $kriteria = Kriteria::first();
        // $matriks_penilaian = MatriksPenilaian::get();
        // $program_studi = ProgramStudi::findOrFail($id_prodi);
        // $matriks = AsesmenLapangan::where("matriks_penilaian_id", "!=", null)->where("program_studi_id", $user_asesor->program_studi->id)->where("tahun_id", $user_asesor->tahun_id)->get();

        //     return view('asesor.rekap-penilaian.d3.akhir', ['program_studi' => $program_studi, 'matriks_penilaian' => $matriks_penilaian, "matriks" => $matriks, 'user_asesor' => $user_asesor]);
        // }
        return view('prodi.berita-acara.ba', ['data' => $data, 'user_asesor' => $user_asesor]);
    }

}