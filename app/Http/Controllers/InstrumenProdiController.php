<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\Jenjang;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Http\Request;

class InstrumenProdiController extends Controller
{
    public function index(Request $request)
    {
        return view('prodi.instrumen.dashboard');
    }

    public function dashboard(Request $request)
    {
        $data = Instrumen::orderBy('jenjang_id', 'ASC')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jenjang', function($row){
                return $row->jenjang->jenjang;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="'.url("storage/instrumen/".$row->file).'" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fa fa-book-open"></i></a>
                <a href="'.url("instrumen-prodi/download/".$row->file).'" class="btn btn-icon icon-left btn-primary"><i class="fa fa-download"></i></a>
            </div>';
        })
            ->rawColumns(['jenjang','action'])
            ->make(true);
    }


    public function instrumen(Request $request, $id)
    {
        $jenjang = Jenjang::findOrFail($id);
        return view('prodi.instrumen.index', ['jenjang'=>$jenjang]);
    }

    public function json(Request $request, $id_jenjang)
    {
        $data = Instrumen::where('jenjang_id', $id_jenjang)->orderBy('judul', 'ASC')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jenjang', function($row){
                return $row->jenjang->jenjang;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="'.url("storage/instrumen/".$row->file).'" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fa fa-book-open"></i></a>
                <a href="'.url("instrumen-prodi/download/".$row->file).'" class="btn btn-icon icon-left btn-primary"><i class="fa fa-download"></i></a>
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
