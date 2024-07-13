<?php

namespace App\Http\Controllers;

use App\Models\DataDukung;
use App\Models\Golongan;
use App\Models\Jenjang;
use App\Models\ProgramStudi;
use App\Models\Kriteria;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Http\Request;

class DataDukungAsesorController extends Controller
{
    public function show($id)
    {
        $data = [
            "kriteria" => Kriteria::all(),
            "golongan" => Golongan::all()
        ];
        $program_studi = ProgramStudi::findOrFail($id);
        return view ('asesor.data-prodid3.data-dukung', $data, ['program_studi'=>$program_studi ]);
    }

    public function json($id_prodi)
    {
        $data = DataDukung::where('jenjang_id','1')->where('program_studi_id', $id_prodi)->where('is_active', 1)->with('kriteria')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('elemen', function($row)
        {
            return  $row->kriteria->butir . ' '. $row->kriteria->kriteria;
        })
        ->addColumn('golongan', function($row)
        {
            if($row->golongan){

                return  $row->golongan->nama;
            }else{
                return ' ';
            }
        })
        ->addColumn('action', function ($row) {
            return '<div class="buttons">
            <a href="'.url("storage/data_dukung/".$row->file).'" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fa fa-book-open"></i></a>
            <a href="'.url("datadukung-d3/download/".$row->file).'" class="btn btn-icon icon-left btn-primary"><i class="fa fa-download"></i></a>
        </div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function download($id)
    {

        $data_prodi = DB::table('data_dukung')->where('file', $id)->first();
        $file = Storage::disk('public')->get('data_dukung/'.$data_prodi->file);
        $filepath = storage_path("app/public/data_dukung/{$data_prodi->file}");

        return FacadesResponse::download($filepath);

    }

    public function indexS1()
    {
        return view ('asesor.data-prodis1.data-dukung');
    }

    public function jsonS1(Request $request)
    {
        $data = DataDukung::with(['program_studi'])->orderBy('id', 'ASC')
        ->where('program_studi_id', '2')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="'.url("storage/data_dukung/".$row->file).'" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fa fa-book-open"></i></a>
                <a href="'.url("datadukung-s1/downloadS1/".$row->file).'" class="btn btn-icon icon-left btn-primary"><i class="fa fa-download"></i></a>
                </div>';
        })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function downloadS1($id)
    {

        $data_prodi = DB::table('data_dukung')->where('file', $id)->first();
        $file = Storage::disk('public')->get('data_dukung/'.$data_prodi->file);
        $filepath = storage_path("app/public/data_dukung/{$data_prodi->file}");

        return FacadesResponse::download($filepath);

    }
}
