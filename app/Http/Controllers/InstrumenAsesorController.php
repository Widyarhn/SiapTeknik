<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Instrumen;
use App\Models\Jenjang;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as FacadesResponse;

class InstrumenAsesorController extends Controller
{
    public function instrumen(Request $request, $id)
    {
        $jenjang = Jenjang::findOrFail($id);
        return view('asesor.instrumen-akreditasi.index', ['jenjang'=>$jenjang]);
    }

    public function json(Request $request)
    {
        $data = Instrumen::with(['jenjang'])->orderBy('judul', 'ASC')
        ->where('jenjang_id', '1')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jenjang', function($row){
                return $row->jenjang->jenjang;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="'.url("storage/instrumen/".$row->file).'" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fa fa-book-open"></i></a>
                <a href="'.url("instrumen-diploma-tiga/download/".$row->file).'" class="btn btn-icon icon-left btn-primary"><i class="fa fa-download"></i></a>
            </div>';
        })
            ->rawColumns(['jenjang','action'])
            ->make(true);
    }
    public function download($id)
    {

        $instrumen = DB::table('instrumens')->where('file', $id)->first();
        $file = Storage::disk('public')->get('instrumen/'.$instrumen->file);
        $filepath = storage_path("app/public/instrumen/{$instrumen->file}");

        return FacadesResponse::download($filepath);

    }

}
