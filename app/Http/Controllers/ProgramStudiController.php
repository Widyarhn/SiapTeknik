<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\ProgramStudi;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            "jenjang" => Jenjang::all()
        ];
        return view('UPPS.program_studi.index', $data);
    }

    public function json(Request $request)
    {
        $data = ProgramStudi::with(['jenjang'])->orderBy('jenjang_id', 'ASC')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jenjang', function($row){
                return $row->jenjang->jenjang;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="'.route('prodi.show', $row->id).'" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>

                <a href="javascript:void(0)" data-route="'.route('prodi.destroy', $row->id).'"
                id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
            </div>';
        })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenjang_id' => 'required'
        ]);

       $program_studi = new ProgramStudi;
       $program_studi->jenjang_id = $request->jenjang_id;
       $program_studi->nama = $request->nama;
       $program_studi->save();

        return redirect()->back()->with('success', 'Program Studi Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $program_studi = ProgramStudi::with(['jenjang'])->find($id);
        $data = [
            "jenjang" => Jenjang::all()
        ];
        return view('UPPS.program_studi.edit',$data, compact('program_studi'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenjang_id' => 'required'
        ]);

       $program_studi = ProgramStudi::with(['jenjang'])->find($id);
       $program_studi->jenjang_id = $request->jenjang_id;
       $program_studi->nama = $request->nama;
       $program_studi->save();

        return redirect()->back()->with('success', 'Program Studi Berhasil Disimpan');
    }

    public function destroy($id)
    {
        $program_studi = ProgramStudi::find($id);
        $program_studi->delete();
    }
}
