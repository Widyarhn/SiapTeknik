<?php

namespace App\Http\Controllers;

use App\Models\DataDukung;
use App\Models\Golongan;
use Illuminate\Support\Facades\Storage;
use App\Models\ProgramStudi;
use App\Models\Kriteria;
use App\Models\MatriksPenilaian;
use App\Models\Suplemen;
use App\Models\UserProdi;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DataDukungProdiController extends Controller
{

    public function elemen(Request $request, $id_prodi)
    {
        $user_prodi = UserProdi::where("user_id", Auth::user()->id)
            ->where("program_studi_id", $id_prodi)
            ->get();
        $data = [
            "kriteria" => Kriteria::all(),
        ];
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        return view('prodi.dokumen.data-dukung.elemen', $data, ['program_studi' => $program_studi, 'user_prodi' => $user_prodi]);
    }

    public function json(Request $request, $id_prodi)
    {
        $data = Kriteria::query();
        $year = date("Y");

        if ($request->searchByYear) {
            $year = $request->searchByYear;
        }

        // if ($request->searchByYear) {
        //     $data->whereHas("matriks_penilaian.data_dukung.program_studi.user_prodi.tahun", function ($query) use ($request) {
        //        $query->where('tahun', $request->searchByYear); 
        //     });
        // }

        $data = $data->orderBy('id', 'ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($id_prodi, $year) {
                return '<div class="buttons">
            <a href="' . route('prodi.data-dukung.data', ['id' => $row->id, 'id_prodi' => $id_prodi, 'tahun' => $year]) . '" class="btn btn-primary btn-md"><i class="fa fa-eye"></i></a>
            </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function data(Request $request, $id, $id_prodi, $year)
    {
        $kriteria = Kriteria::where("id", $id)->first();

        $program_studi = ProgramStudi::findOrFail($id_prodi);

        $user_prodi = UserProdi::where("user_id", Auth::user()->id)->where("program_studi_id", $program_studi->id)->first();
        $matriks = MatriksPenilaian::with(['jenjang', 'kriteria', 'sub_kriteria', 'indikator', 'data_dukung'])->orderBy('kriteria_id', 'ASC')
            ->where("jenjang_id", $user_prodi->jenjang_id)
            ->where("kriteria_id", $id)
            ->get();
        return view("prodi.dokumen.data-dukung.create", compact("kriteria", "program_studi", "user_prodi", "year", "matriks"));
    }

    public function store(Request $request)
    {
        // Validasi file, memastikan setiap file adalah PDF
        $validatedData = $request->validate(
            [
                'file.*' => ['required', 'mimes:pdf']
            ],
            [
                'file.*.mimes' => 'Setiap file harus berupa PDF'
            ]
        );

        // Loop melalui setiap file yang diunggah
        foreach ($request->file('file') as $file) {
            $file_name = $file->getClientOriginalName();
            $file_path = $file->store('data-dukung', 'public');

            // Simpan informasi file ke database
            $data_dukung = new DataDukung;
            $data_dukung->file = $file_path;
            $data_dukung->nama = $file_name;
            $data_dukung->program_studi_id = $request->program_studi_id;
            $data_dukung->sub_kriteria_id = empty($request->sub_kriteria_id) ? null : $request->sub_kriteria_id;
            $data_dukung->kriteria_id = $request->kriteria_id;
            $data_dukung->matriks_penilaian_id = $request->matriks_penilaian_id;
            $data_dukung->tahun_id = $request->tahun_id;
            $data_dukung->save();
        }

        return redirect()->back()->with('success', 'Data Dukung Berhasil Ditambahkan');
    }

    public function fetch($id)
    {
        $files = DataDukung::where('matriks_penilaian_id', $id)->get();
        $result = $files->map(function ($file) {
            return [
                'id' => $file->id,
                'name' => basename($file->nama),
                'url' => Storage::url($file->file),
            ];
        });

        return response()->json(['files' => $result]);
    }

    public function update(Request $request)
    {
        // Update logic for new files
        if ($request->hasFile('new_files')) {
            foreach ($request->file('new_files') as $file) {
                $file_name = $file->getClientOriginalName();
                $file_path = $file->store('data-dukung', 'public');

                $data_dukung = new DataDukung;
                $data_dukung->file = $file_path;
                $data_dukung->nama = $file_name;
                $data_dukung->program_studi_id = $request->program_studi_id;
                $data_dukung->sub_kriteria_id = $request->sub_kriteria_id;
                $data_dukung->kriteria_id = $request->kriteria_id;
                $data_dukung->matriks_penilaian_id = $request->matriks_penilaian_id;
                $data_dukung->tahun_id = $request->tahun_id;
                $data_dukung->save();
            }
        }

        return redirect()->back()->with('success', 'Dokumen Berhasil Diperbarui');
    }

    public function delete(Request $request)
    {
        $file = DataDukung::find($request->file_id);
        if ($file) {
            Storage::disk('public')->delete($file->file);
            $file->delete();
        }

        return redirect()->back()->with('success', 'Dokumen Berhasil Dihapus');
    }


    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate(
    //         [
    //             'file' => ['required', 'mimes:pdf']
    //         ],
    //         [
    //             'file.mimes' => 'File harus berupa pdf'
    //         ]
    //     );

    //     $file = $request->file('file');
    //     $file_name = $file->getClientOriginalName();
    //     $file_path = $file->store('data-dukung', 'public');

    //     $data_dukung = new DataDukung;
    //     $data_dukung->file = $file_path;
    //     $data_dukung->nama = $file_name;
    //     $data_dukung->program_studi_id = $request->program_studi_id;
    //     $data_dukung->sub_kriteria_id = empty($request->sub_kriteria_id) ? null : $request->sub_kriteria_id;
    //     $data_dukung->kriteria_id = $request->kriteria_id;
    //     $data_dukung->matriks_penilaian_id = $request->matriks_penilaian_id;
    //     $data_dukung->tahun_id = $request->tahun_id;
    //     $data_dukung->save();

    //     return redirect()->back()->with('success', 'Data Dukung Berhasil Ditambahkan');
    // }

    // public function edit(Request $request, $id)
    // {
    //     $data = [
    //         "kriteria" => Kriteria::all(),
    //         "golongan" => Golongan::all(),
    //     ];
    //     $data_dukung = DataDukung::find($id);
    //     return view('prodi.diploma-tiga.dokumen.data-dukung.edit', $data, [ 'data_dukung' => $data_dukung]);
    // }

    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'file.*' => ['required', 'mimes:pdf']
    //     ], [
    //         'file.*.mimes' => 'File harus berupa pdf'
    //     ]);

    //     $data_dukung = DataDukung::findOrFail($id);

    //     if ($request->hasFile('file')) {
    //         foreach ($request->file('file') as $file) {
    //             $file_name = $file->getClientOriginalName();
    //             $file_path = $file->store('data-dukung', 'public');

    //             $data_dukung = new DataDukung;
    //             $data_dukung->file = $file_path;
    //             $data_dukung->nama = $file_name;
    //             $data_dukung->program_studi_id = $request->program_studi_id;
    //             $data_dukung->sub_kriteria_id = empty($request->sub_kriteria_id) ? null : $request->sub_kriteria_id;
    //             $data_dukung->kriteria_id = $request->kriteria_id;
    //             $data_dukung->matriks_penilaian_id = $request->matriks_penilaian_id;
    //             $data_dukung->tahun_id = $request->tahun_id;
    //             $data_dukung->save();
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Data Dukung Berhasil Diperbarui');
    // }


    // public function elemenHistory(Request $request, $id_prodi)
    // {
    //     $tahun = UserProdi::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
    //     $data = [
    //         "kriteria" => Kriteria::all(),
    //     ];
    //     $program_studi = ProgramStudi::findOrFail($id_prodi);
    //     return view('prodi.dokumen.data-dukung.elemen-history', $data, ['program_studi' => $program_studi, 'tahun' => $tahun]);
    // }

    // public function jsonHistory(Request $request, $id_prodi)
    // {
    //     $data = Kriteria::orderBy('id', 'ASC')->get();

    //     return DataTables::of($data)
    //         ->addIndexColumn()
    //         ->addColumn('action', function ($row) use ($id_prodi) {
    //             return '<div class="buttons">
    //         <a href="' . route('prodi.data-dukung.dataHistory', ['id' => $row->id, 'id_prodi' => $id_prodi]) . '" class="btn btn-primary btn-md"><i class="fa fa-eye"></i></a>
    //         </div>';
    //         })
    //         ->rawColumns(['action'])
    //         ->make(true);
    // }

    // public function dataHistory(Request $request, $id, $id_prodi)
    // {
    //     $kriteria = Kriteria::where("id", $id)->first();

    //     $program_studi = ProgramStudi::findOrFail($id_prodi);

    //     $user_prodi = UserProdi::where("user_id", Auth::user()->id)->where("program_studi_id", $program_studi->id)->first();

    //     if (count($kriteria->matriks_penilaian) > 0) {
    //         $data["matriks_penilaian"] = MatriksPenilaian::where("jenjang_id", $user_prodi->jenjang_id)->where("kriteria_id", $id)->get();
    //     } else if (count($kriteria->suplemen) > 0) {
    //         $data["suplemen"] = Suplemen::where("program_studi_id", $id_prodi)->where("kriteria_id", $id)->get();
    //     }

    //     return view("prodi.dokumen.data-dukung.data-history", $data, compact("kriteria", "program_studi", "user_prodi"));
    // }
}
