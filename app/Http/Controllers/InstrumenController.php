<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\Jenjang;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as FacadesResponse;

class InstrumenController extends Controller
{
    public function jenjang($id)
    {
        $jenjang = Jenjang::findOrFail($id);
        return view('UPPS.instrumen.index', ['jenjang' => $jenjang]);
    }

    public function json(Request $request, $id)
    {
        $data = Instrumen::with(['jenjang'])->where('jenjang_id', $id)->orderBy('judul', 'ASC')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jenjang', function($row){
                return $row->jenjang->jenjang;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="'.url("storage/instrumen/".$row->file).'" target="_blank" class="btn btn-icon icon-left btn-info"><i class="fa fa-book-open"></i></a>
                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="'.route('instrumen.show', $row->id).'" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>

                <a href="javascript:void(0)" data-route="'.route('instrumen.destroy', $row->id).'"
                id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
            </div>';

        })
            ->rawColumns(['program_studi','action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'file' => 'required|mimes:pdf',
            'judul' => ['required', 'min:6'],
            'jenjang_id' => 'required'
        ]);

        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('storage/instrumen', $file->getClientOriginalName());
        $instrumen = new Instrumen;
        $instrumen->file = $nama_file;
        $instrumen->jenjang_id = $request->jenjang_id;
        $instrumen->judul = $request->judul;
        $instrumen->save();
    
        return redirect()->back()->with('success', 'Instrumen Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $instrumen = Instrumen::find($id);

        $data = [
            "jenjang" => Jenjang::all()
        ];

        return view('UPPS.instrumen.edit', $data, compact('instrumen'));
    }

    public function update(Request $request,$id){
        $instrumen = Instrumen::find($id);

        $validatedData = $request->validate([
            'file' => 'required|mimes:pdf',
            'judul' => ['required', 'min:6'],
        ]);

        if($request->hasFile('file')){
            $file = $request->file('file');
            $file->storeAs('public/instrumen', $file->getClientOriginalName());
            $file = $file->getClientOriginalName();
        }else {
            $file = $instrumen->file;
        }
        $instrumen->update([
            "file" => $file,
            "judul" => $request->judul,
        ]);

        return redirect()->back()->with('success', 'Data Instrumen Berhasil Disimpan');

    }

    public function destroy($id)
    {
        $instrumen = Instrumen::find($id);
        $instrumen->delete();
    }

    public function show($id){
        //
    }
}
