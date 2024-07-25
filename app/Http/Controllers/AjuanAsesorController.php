<?php

namespace App\Http\Controllers;

use App\Models\UserProdi;
use App\Models\ProgramStudi;
use App\Models\AssignmentProdi;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadesResponse;

use Illuminate\Http\Request;

class AjuanAsesorController extends Controller
{
    public function prodi(Request $request, $id_prodi)
    {
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        
        $tahun = UserProdi::with('tahun')->where("program_studi_id", $id_prodi)->first();
        
        return view ('asesor.ajuan.index', ['tahun'=> $tahun, 'program_studi' => $program_studi]);
    }

    public function getLkps(Request $request, $id_prodi){
        $data = AssignmentProdi::where('program_studi_id', $id_prodi)
        ->where('user_id', Auth::user()->id)
        ->with(['lkps'=>function($query) use ($id_prodi)
        {
            $query->where('is_active', 1);
        },'led'=>function ($query) use ($id_prodi){
            $query->where('is_active', 1);
        }
        ])
        ->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('nama', function ($row)
        {
            if ($row->lkps) {
                return 'Dokumen LKPS';
            } else {
                return 'Dokumen LED';
            } 
        })
        ->addColumn('file', function ($row){
            if ($row->lkps) {
                return $row->lkps->file;
            } else {
                return $row->led->file;
            } 
        })
        ->addColumn('action', function ($row) {
            if($row->lkps) {
                return '<div class="buttons">
                <a href="'.url("storage/dokumen_prodi/".$row->lkps->file).'" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fa fa-book-open"></i></a>
                <a href="'.url("data-dokd3/downloadLkps/".$row->lkps->file).'" class="btn btn-icon icon-left btn-primary"><i class="fa fa-download"></i></a>
            </div>';
            }else{
                return '<div class="buttons">
                <a href="'.url("storage/dokumen_prodi/".$row->led->file).'" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fa fa-book-open"></i></a>
                <a href="'.url("data-dokd3/downloadled/".$row->led->file).'" class="btn btn-icon icon-left btn-primary"><i class="fa fa-download"></i></a>
            </div>';
            }
    })
        ->rawColumns(['action'])
        ->make(true);
    }
}
