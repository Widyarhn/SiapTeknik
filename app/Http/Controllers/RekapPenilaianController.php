<?php

namespace App\Http\Controllers;

use App\Models\AsesmenLapangan;
use App\Models\MatriksPenilaian;
use App\Models\ProgramStudi;
use App\Models\Kriteria;
use App\Models\DeskEvaluasi;
use App\Models\Suplemen;
use App\Models\UserAsesor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RekapPenilaianController extends Controller
{
    
    public function prodi($id_prodi)
    {
        $user_asesor = UserAsesor::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        $kriteria = Kriteria::first();
        $matriks_penilaian = MatriksPenilaian::get();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        $matriks = DeskEvaluasi::where("matriks_penilaian_id", "!=", null)->where("program_studi_id", $user_asesor->program_studi->id)->where("tahun_id", $user_asesor->tahun_id)->get();
        $suplemen = DeskEvaluasi::where("suplemen_id", "!=", null)->where("program_studi_id", $user_asesor->program_studi_id)->where("tahun_id", $user_asesor->tahun_id)->get();
        
        return view('asesor.rekap-penilaian.d3.awal', ['program_studi'=>$program_studi, 'matriks_penilaian'=>$matriks_penilaian, "matriks" => $matriks, "suplemen" => $suplemen, 'user_asesor'=>$user_asesor]);
    }

    public function prodiasesmen($id_prodi)
    {
        $user_asesor = UserAsesor::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        $kriteria = Kriteria::first();
        $matriks_penilaian = MatriksPenilaian::get();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        $matriks = AsesmenLapangan::where("matriks_penilaian_id", "!=", null)->where("program_studi_id", $user_asesor->program_studi->id)->where("tahun_id", $user_asesor->tahun_id)->get();
        $suplemen = AsesmenLapangan::where("suplemen_id", "!=", null)->where("program_studi_id", $user_asesor->program_studi_id)->where("tahun_id", $user_asesor->tahun_id)->get();
        
        return view('asesor.rekap-penilaian.d3.akhir', ['program_studi'=>$program_studi, 'matriks_penilaian'=>$matriks_penilaian, "matriks" => $matriks, "suplemen" => $suplemen, 'user_asesor'=>$user_asesor]);
    }
    
    public function json(Request $request, $id_prodi)
    {
        // $data = DeskEvaluasi::with('matriks_penilaian.kriteria')->where('program_studi_id', $id_prodi)->get();
        $kriteria = Kriteria::first();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        $matriks_penilaian = MatriksPenilaian::get();
        $suplemen = Suplemen::get();
        
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();
        
        $data = DeskEvaluasi::where('program_studi_id', $user_asesor->program_studi_id)
        ->where("tahun_id", $user_asesor->tahun_id)
        ->with(["matriks_penilaian", "suplemen"])
        ->get();
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('sub_kriteria', function ($row) {
            if ($row->matriks_penilaian != null) {
                return $row->matriks_penilaian->sub_kriteria;
            } else if ($row->suplemen != null) {
                return $row->suplemen->sub_kriteria;
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
                return $row->matriks_penilaian->bobot;
            } else if ($row->suplemen != null) {
                return $row->suplemen->bobot;
            }
        })
        ->addColumn('nilai_bobot', function ($row) {
            if ($row->matriks_penilaian != null) {
                return '<span class="badge badge-info">' . $row->nilai * $row->matriks_penilaian->bobot . '</span>';
            } else if ($row->suplemen != null) {
                return '<span class="badge badge-info">' . $row->nilai * $row->suplemen->bobot . '</span>';
            }
            if ($row->suplemen) {
            } else {
            }
        })
        ->rawColumns(['butir', 'deskripsi', 'nilai', 'nilai_bobot'])
        ->make(true);
        
    }
    
    
    
    public function jsonAkhir(Request $request, $id_prodi)
    {
        // $data = DeskEvaluasi::with('matriks_penilaian.kriteria')->where('program_studi_id', $id_prodi)->get();
        $kriteria = Kriteria::first();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        $matriks_penilaian = MatriksPenilaian::get();
        $suplemen = Suplemen::get();
        
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();
        
        $data = AsesmenLapangan::where('program_studi_id', $user_asesor->program_studi_id)
        ->where("tahun_id", $user_asesor->tahun_id)
        ->with(["matriks_penilaian", "suplemen"])
        ->get();
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('sub_kriteria', function ($row) {
            if ($row->matriks_penilaian != null) {
                return $row->matriks_penilaian->sub_kriteria;
            } else if ($row->suplemen != null) {
                return $row->suplemen->sub_kriteria;
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
                return $row->matriks_penilaian->bobot;
            } else if ($row->suplemen != null) {
                return $row->suplemen->bobot;
            }
        })
        ->addColumn('nilai_bobot', function ($row) {
            if ($row->matriks_penilaian != null) {
                return '<span class="badge badge-info">' . $row->nilai * $row->matriks_penilaian->bobot . '</span>';
            } else if ($row->suplemen != null) {
                return '<span class="badge badge-info">' . $row->nilai * $row->suplemen->bobot . '</span>';
            }
            if ($row->suplemen) {
            } else {
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
