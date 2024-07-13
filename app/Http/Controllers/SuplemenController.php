<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\Suplemen;
use App\Models\Jenjang;
use App\Models\Jenis;
use App\Models\Nilai;
use App\Models\Kriteria;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class SuplemenController extends Controller
{
    public function suplemen($id_prodi)
    {
        $data = [
            "jenjang" => Jenjang::all(),
            "jenis" => Jenis::all(),
            "kriteria" => Kriteria::all(),
            "suplemen" => Suplemen::all()
        ];
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        return view('UPPS.suplemen.index', $data, ['program_studi' => $program_studi]);
    }

    public function json(Request $request, $id_prodi)
    {
        $data = Suplemen::where('program_studi_id', $id_prodi)->with(['jenjang', 'kriteria', 'jenis', 'program_studi'])->orderBy('created_at', 'ASC')
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('informasi', function($row){
            $informasi = '<table>
            <tr>
            <th>Tahun</th>
            <td>
                '.$row->created_at->format('Y').'
            </td>
        </tr>
        <tr>
        </tr>
            <th>Kriteria</th>
            <td>
            <h6>'.$row->kriteria->kriteria.'</h6>
            </td>
        <tr>
            <th>Jenis</th>
            <td>
                '.$row->jenis->jenis.'
            </td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>
                '.$row->deskriptor.'
            </td>
        </tr>
        <tr>
            <th>Bobot</th>
            <td>
                '.$row->bobot.'
            </td>
        </tr>
       ';
        return $informasi;
        })
        ->addColumn('nilai', function($row){
            $nilai = ' <table>
        <tr>
            <th>'.$row->kriteria->butir.' '.$row->no_butir.'</th>
            <th>
             '.$row->sub_kriteria.'
            </th>
        </tr>
        <tr>
            <th>4</th>
            <td>
                '.$row->sangat_baik.'
            </td>
        </tr>
        <tr>
            <th>3</th>
            <td>
                '.$row->baik.' 
            </td>
        </tr>
        <tr>
            <th>2</th>
            <td>
                '.$row->cukup.' 
            </td>
        </tr>
        <tr>
            <th>1</th>
            <td>
                '.$row->kurang.' 
            </td>
        </tr> </table>';
            return $nilai;
        })
        ->addColumn('action', function ($row) use ($id_prodi) {
            return '<div class="buttons">
            <a href="'.route('UPPS.suplemen-d3.edit', ['id' => $row->id, 'id_prodi' => $id_prodi]).'" data-url="" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>
            <a href="javascript:void(0)" data-route="'.route('suplemen-d3.destroy', $row->id).'" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
        </div>';
    })

        ->rawColumns(['informasi', 'nilai','action'])
        ->make(true);
    }


    public function create($id_prodi)
    {
        $data = [
            "jenjang" => Jenjang::all(),
            "jenis" => Jenis::all(),
            "kriteria" => Kriteria::all(),
            "golongan" => Golongan::all(),
            "suplemen" => Suplemen::all(),
            "program_stuid" => ProgramStudi::all()
        ];
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        return view('UPPS.suplemen.create', $data, ['program_studi' => $program_studi]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_id'=>'required',
            'jenjang_id' => 'required',
            'kriteria_id' => 'required',
            'sub_kriteria'=>'required',
            'deskriptor' => ['required', 'min:6'],
            'sangat_baik' =>  ['required', 'min:6'],
            'baik' =>  ['required', 'min:6'],
            'cukup' =>  ['required', 'min:6'],
            'kurang' =>  ['required', 'min:6'],
            'bobot' => 'required|numeric',
        ]);
      
        $suplemen = new Suplemen;
        $suplemen->jenis_id = $request->jenis_id;
        $suplemen->jenjang_id = $request->jenjang_id;
        $suplemen->program_studi_id = $request->program_studi_id;
        $suplemen->kriteria_id = $request->kriteria_id;
        $suplemen->sub_kriteria = $request->sub_kriteria;
        $suplemen->no_butir = $request->no_butir;
        $suplemen->deskriptor = $request->deskriptor;
        $suplemen->sangat_baik = $request->sangat_baik;
        $suplemen->baik = $request->baik;
        $suplemen->cukup = $request->cukup;
        $suplemen->kurang = $request->kurang;
        $suplemen->bobot = $request->bobot;

        $suplemen->save();

        
        return back()->with('success', 'Data Suplemen Berhasil Ditambahkan');
    }

    public function edit(Request $request, $id, $id_prodi)
    {
        $data = [
            "jenjang" => Jenjang::all(),
            "jenis" => Jenis::all(),
            "kriteria" => Kriteria::all(),
            "golongan" => Golongan::all()
        ];
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        $matriks_penilaian = Suplemen::where('program_studi_id', $id_prodi)->find($id);
        return view('UPPS.suplemen.edit', $data, ['matriks_penilaian'=>$matriks_penilaian, 'program_studi' => $program_studi]);
    }

    public function update(Request $request, $id, $id_prodi)
    {
        $validatedData = $request->validate([
            'jenis_id'=>'required',
            'jenjang_id' => 'required',
            'kriteria_id' => 'required',
            'sub_kriteria'=>'required',
            'deskriptor' => ['required', 'min:6'],
            'sangat_baik' =>  ['required', 'min:6'],
            'baik' =>  ['required', 'min:6'],
            'cukup' =>  ['required', 'min:6'],
            'kurang' =>  ['required', 'min:6'],
            'bobot' => 'required|numeric',
        ]);
        $matriks_penilaian = Suplemen::find($id);
        $matriks_penilaian->jenis_id = $request->jenis_id;
        $matriks_penilaian->jenjang_id = $request->jenjang_id;
        $matriks_penilaian->kriteria_id = $request->kriteria_id;
        $matriks_penilaian->sub_kriteria = $request->sub_kriteria;
        $matriks_penilaian->no_butir = $request->no_butir;
        $matriks_penilaian->deskriptor = $request->deskriptor;
        $matriks_penilaian->sangat_baik = $request->sangat_baik;
        $matriks_penilaian->baik = $request->baik;
        $matriks_penilaian->cukup = $request->cukup;
        $matriks_penilaian->kurang = $request->kurang;
        $matriks_penilaian->bobot = $request->bobot;
        $matriks_penilaian->save();

        return back()->with('success', 'Data Suplemen Berhasil Disimpan');
    }

    public function destroy($id)
    {
        $matriks_penilaian = Suplemen::find($id);
        $matriks_penilaian->delete();
    }
}
