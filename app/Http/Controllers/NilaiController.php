<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\MatriksPenilaian;
use App\Models\ProgramStudi;
use App\Models\UserAsesor;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        //
    }

    public function bagian(Request $request, $id_prodi)
    {
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        return view('asesor.nilai.elemen-bagian', ['program_studi'=>$program_studi]);
    }

    public function jsonBagian(Request $request, $id_prodi)
    {
        $data = Kriteria::orderBy('id', 'ASC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('nilai', function ($row) use ($id_prodi)
        {
            $user_asesor = UserAsesor::where("program_studi_id", $id_prodi)->first();
            
            if (count($row->suplemen) > 0) {
                $nomer = 0;
                foreach ($row->suplemen as $m) {
                    if (empty($m["evaluasi"])) {
                        $nomer = 0;
                    } else {
                        if (($m["evaluasi"]["program_studi_id"] != $user_asesor["program_studi_id"]) && ($m["evaluasi"]["tahun_id"] != $user_asesor["tahun_id"])) {
                            $nomer = 0;
                        } else {
                            $nomer += $m["bobot"] * $m["evaluasi"]["nilai"];
                        }
                    }
                }
                return $nomer;
            } else if (count($row->matriks_penilaian) > 0) {
                $nomer = 0;
                foreach ($row->matriks_penilaian as $m) {
                    if (empty($m["evaluasi"])) {
                        $nomer = 0;
                    } else {
                        if (($m["evaluasi"]["program_studi_id"] != $user_asesor["program_studi_id"]) && ($m["evaluasi"]["tahunn_id"] != $user_asesor["tahun_id"])) {
                            $nomer = 0;
                        } else {
                            $nomer += $m["bobot"] * $m["evaluasi"]["nilai"];
                        }
                    }
                }

                return $nomer;
            } else {
                return 0;
            }
        })
        ->rawColumns(['nilai'])
        ->make(true);
    }
}
