<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    public function index(Request $request)
    {
        return view('UPPS.matriks-penilaian.golongan.index');
    }

    public function tableGolongan(Request $request)
    {
        $data = Golongan::orderBy('id', 'ASC')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row)
        {
            return '<div class="buttons">
            <a href="#" data-toggle="modal" data-target="#editGolongan" data-url="'.route('golongan.show', $row->id).'" id="" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>
            <a href="javascript:void(0)" data-route="'.route('golongan.destroy', $row->id).'" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
            </div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required'
        ]);

        DB::transaction(function () use($validatedData){
            Golongan::create($validatedData);
        });

        return redirect()->back()->with('success', 'Data PPP Berhasil Ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $golongan = Golongan::find($id);

        return view('UPPS.matriks-penilaian.golongan.edit', compact('golongan'));
    }

    public function update(Request $request, $id)
    {
        $golongan = Golongan::find($id);
        $golongan->nama = $request->nama;
        $golongan->save();
        return redirect()->back()->with('success', 'Data PPP Berhasil Disimpan');
    }

    public function destroy($id)
    {
        $golongan = Golongan::find($id);
        $golongan->delete();
    }
}
