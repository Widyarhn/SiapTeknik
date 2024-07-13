<?php

namespace App\Http\Controllers;

use App\Models\AsesmenLapangan;
use App\Models\ProgramStudi;
use App\Models\MatriksPenilaian;
use App\Models\Kriteria;
use App\Models\Golongan;
use App\Models\Suplemen;
use App\Models\UserAsesor;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiAsesmenLapanganD3Controller extends Controller
{
    // public function index(Request $request)
    // {
    //     return view('asesor.penilaiand3.asesmen-lapangan.index');
    // }

    public function elemen($id_prodi)
    {
        $data = [
            "kriteria" => Kriteria::all(),
        ];
        $user_asesor = UserAsesor::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        $kriteria = Kriteria::first();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        return view('asesor.penilaian.asesmen-lapangan.index', $data,  ['program_studi' => $program_studi, 'user_asesor'=>$user_asesor]);
    }

    public function json(Request $request, $id_prodi)
    {
        $data = Kriteria::orderBy('id', 'ASC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) use ($id_prodi)
        {
            return '<div class="buttons">
            <a href="'.route('asesor.penilaian.asesmen-lapangan.show',['id' => $row->id, 'id_prodi'=>$id_prodi]).'" class="btn btn-primary btn-md"><i class="fa fa-eye"></i></a>
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
        
            return view('asesor.penilaian.asesmen-lapangan.show',
            $data, compact("kriteria", "program_studi", "user_asesor", "golongan"));
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
            'deskripsi.required' => 'Deskripsi harus diisi'
        ]
        );

       $asesmen_lapangan = new AsesmenLapangan;
       $asesmen_lapangan->nilai = $request->nilai;
       $asesmen_lapangan->program_studi_id = $request->program_studi_id;
       $asesmen_lapangan->jenjang_id = $request->jenjang_id;
       $asesmen_lapangan->tahun_id = $request->tahun_id;
       $asesmen_lapangan->suplemen_id = $request->suplemen_id;
       $asesmen_lapangan->matriks_penilaian_id = $request->matriks_penilaian_id;
       $asesmen_lapangan->deskripsi = $request->deskripsi;
       $asesmen_lapangan->save();

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

        $asesmen_lapangan = AsesmenLapangan::find($id);
        $asesmen_lapangan->nilai = $request->nilai;
        $asesmen_lapangan->program_studi_id = $request->program_studi_id;
        $asesmen_lapangan->jenjang_id = $request->jenjang_id;
        $asesmen_lapangan->tahun_id = $request->tahun_id;
        $asesmen_lapangan->suplemen_id = $request->suplemen_id;
        $asesmen_lapangan->matriks_penilaian_id = $request->matriks_penilaian_id;
        $asesmen_lapangan->deskripsi = $request->deskripsi;
        $asesmen_lapangan->save();

        return redirect()->back()->with('success', 'Berhasil mengubah nilai dan deskripsi nilai asesmen lapangan');
    }
}
