<?php

namespace App\Http\Controllers;

use App\Models\DataDukung;
use App\Models\UserProdi;
use App\Models\Jenjang;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgramStudi;
use App\Models\Kriteria;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Http\Request;

class DataDukungUppsController extends Controller
{
    public function elemen(Request $request, $id_prodi)
    {
        $tahun = UserProdi::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        $data = [
            "kriteria" => Kriteria::all(),
        ];
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        return view('UPPS.dokumen.data-dukung.elemen', $data, ['program_studi' => $program_studi]);
    }

    public function data($id_prodi)
    {
        $data = DataDukung::where('jenjang_id','1')->where('program_studi_id', $id_prodi)->with('kriteria')->get();
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
            <a href="'.url("prodi/download/".$row->file).'" class="btn btn-icon icon-left btn-primary"><i class="fa fa-download"></i></a>
        </div>';
        })
        ->addColumn('status', function($row)
        {
            if ($row["is_active"] == 1) {
                $status = "<button class='btn btn-success btn-sm'>
                    <i class='fa fa-check'></i> Success
                </button>";
            } else if ($row["is_active"] == 0) {
                $status =  '<form
                action="'.url('upps-datadukung/update/'.$row->id).'"
                method="post" enctype="multipart/form-data"
                id="formActionStore">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="is_active">
                <button type="submit" class="btn btn-warning">Proses</button>
                </form>';
            }
            // $status = '<label for="is_active">Approve?</label>
            // <input type="checkbox" id="is_active">';
            return  $status;
        })
        ->rawColumns(['action', 'status'])
        ->make(true);
    }

    public function update(Request $request, $id)
    {
        DataDukung::where("id", $id)->update([
            "is_active" => 1
        ]);

        return back();
    }

    public function download($id)
    {

        $data_dukung = DB::table('data_dukung')->where('file', $id)->first();
        $file = Storage::disk('public')->get('data_dukung/'.$data_dukung->file);
        $filepath = storage_path("app/public/data_dukung/{$data_dukung->file}");

        return FacadesResponse::download($filepath);

    }

}
