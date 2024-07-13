<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\Jenjang;
use App\Models\DeskEvaluasi;
use App\Models\MatriksPenilaian;
use App\Models\Kriteria;
use App\Models\Golongan;
use App\Models\Suplemen;
use App\Models\UserAsesor;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiDeskEvalController extends Controller
{
    public function elemen($id_prodi)
    {
        $data = [
            "kriteria" => Kriteria::all(),
        ];
        $user_asesor = UserAsesor::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        $kriteria = Kriteria::first();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        return view('asesor.penilaian.desk-evaluasi.index', $data,  ['program_studi' => $program_studi, 'user_asesor'=>$user_asesor]);
    }

    public function json(Request $request, $id_prodi)
    {
        $data = Kriteria::orderBy('id', 'ASC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) use ($id_prodi)
        {
            return '<div class="buttons">
            <a href="'.route('asesor.penilaian.desk-evaluasi.show', ['id' => $row->id, 'id_prodi'=>$id_prodi]).'" class="btn btn-primary btn-md"><i class="fa fa-eye"></i></a>
            </div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function show(Request $request, $id, $id_prodi)
    {
        $kriteria = Kriteria::where("id", $id)->first();

        $golongan = Golongan::get();

        $program_studi = ProgramStudi::findOrFail($id_prodi);

        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->where("program_studi_id", $program_studi->id)->first();
        
        if (count($kriteria->matriks_penilaian) > 0 ) {
            $matriks = MatriksPenilaian::query();
            $matriks->where("jenjang_id", $user_asesor->jenjang_id)->where("kriteria_id", $id);

            if ($request->has('golongan') && $request->golongan != 0) {
            $matriks->whereHas('golongan', function ($query) use ($request) {
                $query->where('id', $request->golongan);
               
            });
            }

            $data["matriks_penilaian"] = $matriks->get();
        } else if (count($kriteria->suplemen) > 0) {
            $data["suplemen"] = Suplemen::where("program_studi_id", $id_prodi)->where("kriteria_id", $id)->get();
        }else{
            $data[" "] = "Belum ada data yang dimasukkan";
        }

        return view("asesor.penilaian.desk-evaluasi.show", $data, compact("kriteria", "program_studi", "user_asesor", "golongan"));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nilai' => ['required', 'numeric', 'min:1', 'max:4'],
            'deskripsi' => 'required'
        ],
        [
            'nilai.required' => 'Nilai harus diisi',
            'nilai.numeric' => 'Nilai harus berisi angka',
            'nilai.min' => 'Nilai tidak boleh kurang dari 1',
            'nilai.max' => 'Nilai tidak boleh lebih dari 4',
            'deskripsi.required' =>'Deskripsi nilai harus diisi'
        ]
        );

        $desk_evaluasi = new Deskevaluasi;
        $desk_evaluasi->nilai = $request->nilai;
        $desk_evaluasi->program_studi_id = $request->program_studi_id;
        $desk_evaluasi->jenjang_id = $request->jenjang_id;
        $desk_evaluasi->tahun_id = $request->tahun_id;
        $desk_evaluasi->suplemen_id = $request->suplemen_id;
        $desk_evaluasi->matriks_penilaian_id = $request->matriks_penilaian_id;
        $desk_evaluasi->deskripsi = $request->deskripsi;
        $desk_evaluasi->save();

        return redirect()->back()->with('success', 'Berhasil memberikan nilai dan deskripsi nilai');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nilai' => ['required', 'numeric', 'min:1', 'max:4'],
            'deskripsi' => 'required'
        ],
        [
            'nilai.required' => 'Nilai harus diisi',
            'nilai.numeric' => 'Nilai harus berisi angka',
            'nilai.min' => 'Nilai tidak boleh kurang dari 1',
            'nilai.max' => 'Nilai tidak boleh lebih dari 4',
            'deskripsi.required' =>'Deskripsi nilai harus diisi'
        ]
        );

        $desk_evaluasi = Deskevaluasi::find($id);
        $desk_evaluasi->nilai = $request->nilai;
        $desk_evaluasi->program_studi_id = $request->program_studi_id;
        $desk_evaluasi->jenjang_id = $request->jenjang_id;
        $desk_evaluasi->tahun_id = $request->tahun_id;
        $desk_evaluasi->suplemen_id = $request->suplemen_id;
        $desk_evaluasi->matriks_penilaian_id = $request->matriks_penilaian_id;
        $desk_evaluasi->deskripsi = $request->deskripsi;
        $desk_evaluasi->save();

        return redirect()->back()->with('success', 'Berhasil mengubah nilai dan deskripsi nilai');
    }

    public function history($id_prodi)
    {
        $user_asesor = UserAsesor::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        $kriteria = Kriteria::first();
        $matriks_penilaian = MatriksPenilaian::get();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        $matriks = DeskEvaluasi::where("matriks_penilaian_id", "!=", null)->get();
        $suplemen = DeskEvaluasi::where("suplemen_id", "!=", null)->get();
        
        return view('asesor.rekap-penilaian.history.desk-evaluasi', [ 'user_asesor'=>$user_asesor, 'program_studi'=>$program_studi, 'matriks_penilaian'=>$matriks_penilaian, "matriks" => $matriks, "suplemen" => $suplemen]);
    }

    public function jsonHistory(Request $request, $id_prodi)
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

    }

