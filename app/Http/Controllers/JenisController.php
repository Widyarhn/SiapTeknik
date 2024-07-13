<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index(Request $request)
    {
        return view('UPPS.matriks-penilaian.jenis.index');
    }

    public function tableJenis(Request $request)
    {
        $data = Jenis::orderBy('id', 'ASC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row)
        {
            return '<div class="buttons">
            <a href="#" data-toggle="modal" data-target="#editJenis" data-url="'.route('jenis.show', $row->id).'" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>
            <a href="javascript:void(0)" data-route="'.route('jenis.destroy', $row->id).'"id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
            </div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis' => 'required'
        ]);

        DB::transaction(function () use($validatedData){
            Jenis::create($validatedData);
        });

        return redirect()->back()->with('success', 'Data Jenis Berhasil Ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $jenis = Jenis::find($id);

        return view('UPPS.matriks-penilaian.jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $jenis = Jenis::find($id);
        $jenis->jenis = $request->jenis;
        $jenis->save();
        return redirect()->back()->with('success', 'Data Jenis Berhasil Disimpan');
    }

    public function destroy($id)
    {
        $jenis = Jenis::find($id);
        $jenis->delete();
    }
}
