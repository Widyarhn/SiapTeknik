<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SettingTahunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = Tahun::orderBy('tahun', 'DESC')->first();
        // return view('UPPS.layout.main', ['tahun'=> $tahun]);
        return view('UPPS.akreditasi.setting-tahun');
    }

    public function json(Request $request)
    {
        $data = Tahun::orderBy('tahun', 'ASC')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row){
                if($row['is_active'] == 0){
                $status = '<a href="javascript:void(0)" data-route="'.route('tahun-akreditasi.selesai', $row->id).'"
                \ data-id="'.$row->id.'" class="btn btn-outline-success btn-md selesai-btn">Selesaikan</a>
            </div>';
                }else if($row['is_active'] == 1){
                    $status = "<button class='btn btn-success btn-sm'>
                    <i class='fa fa-check'></i> Selesai
                </button>";
                } 
                return $status;
            })
            ->addColumn('action', function ($row) {
                if($row['is_active'] == 0){
                    return '<div class="buttons">
                    <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="'.route('dashboard-UPPS.show', $row->id).'" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>';
                }else{
                    return ' ';
                }
            })
            ->addColumn('awal', function ($row){
                return $row->tanggal_awal;
            })
            ->addColumn('akhir', function ($row){
                return $row->tanggal_akhir;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
