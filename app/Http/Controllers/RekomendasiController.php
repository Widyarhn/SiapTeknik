<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\RPembinaan;
use App\Models\UserAsesor;
use App\Models\Rekomendasi;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RekomendasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodi_id = UserAsesor::with('program_studi', 'jenjang')->where("user_id", Auth::user()->id)->pluck('program_studi_id')->first();
        $user_asesor = UserAsesor::with('program_studi', 'jenjang')->where("user_id", Auth::user()->id)->first();
        $prodi = ProgramStudi::with('jenjang')->where('id', $prodi_id)->first();
        $rekomendasi = Rekomendasi::all();
        $data = [
            "kriteria" => Kriteria::whereBetween('id', [3, 13])->get(),
            "prodi" => $prodi,
            "user_asesor" => $user_asesor,
            "rekomendasi" => $rekomendasi,
        ];
        return view('asesor.rekomendasi.index', $data);
    }

    public function json(Request $request)
    {
        $data = Rekomendasi::with(['program_studi', 'kriteria', 'tahun'])->orderBy('id', 'ASC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('kriteria', function ($row) {
                return $row->kriteria->kriteria;
            })
            ->addColumn('komendasi', function ($row) {
                return $row->komendasi;
            })
            ->addColumn('rekomendasi', function ($row) {
                return $row->rekomendasi;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="' . route('rekomendasi.show', $row->id) . '" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>
                <a href="javascript:void(0)" data-route="' . route('rekomendasi.destroy', $row->id) . '"
                id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
                </div>';
            })
            ->rawColumns(['kriteria', 'action', 'komendasi', 'rekomendasi'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kriteria_id' => 'required',
            'komendasi' => 'required',
            'rekomendasi' => 'required',
        ]);

        // Mendapatkan ID user asesor untuk program studi
        $userAsesor = UserAsesor::where('program_studi_id', $request->program_studi_id)
            ->where('jabatan', 'Ketua Asesor')
            ->pluck('id')
            ->first();

        // Cek apakah kriteria sudah ada untuk program studi dan tahun yang sama
        $existingRekomendasi = Rekomendasi::where('kriteria_id', $validatedData['kriteria_id'])
            ->where('program_studi_id', $request->program_studi_id)
            ->where('tahun_id', $request->tahun_id)
            ->first();

        if ($existingRekomendasi) {
            // Jika kriteria sudah ada, return dengan pesan error
            return back()->withErrors(['kriteria_id' => 'Kriteria ini sudah ada untuk program studi dan tahun yang sama.']);
        }

        // Jika kriteria belum ada, simpan data baru
        Rekomendasi::create([
            'kriteria_id' => $validatedData['kriteria_id'],
            'komendasi' => $validatedData['komendasi'],
            'rekomendasi' => $validatedData['rekomendasi'],
            'tahun_id' => $request->tahun_id,
            'program_studi_id' => $request->program_studi_id,
            'user_asesor_id' => $userAsesor,
            'status' => '1',
        ]);

        return back()->with('success', 'Data Rekomendasi Pembinaan Prodi Berhasil Dibuat!');
    }
    public function unggah(Request $request)
    {
        $validatedData = $request->validate(
            [
                'file' => ['required', 'mimes:pdf']
            ],
            [
                'file.mimes' => 'File Rekomendasi Pembinaan harus berupa pdf'
            ]
        );

        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('storage/rekomendasi', $file->getClientOriginalName());
        $rp =  new RPembinaan();
        $rp->file = $nama_file;
        $rp->program_studi_id = $request->program_studi_id;
        $rp->tahun_id = $request->tahun_id;
        $rp->user_asesor_id = $request->user_asesor_id;
        $rp->status = '1';
        $rp->save();

        return back()->with('success', 'Data Rekomendasi Pembinaan Prodi Berhasil diunggah!');
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'kriteria_id' => 'required',
    //         'komendasi' => 'required',
    //         'rekomendasi' => 'required',
    //     ]);

    //     $userAsesor= UserAsesor::where('program_studi_id', $request->program_studi_id)->where('jabatan', 'Ketua Asesor')->pluck('id')->first();

    //     Rekomendasi::create([
    //         'kriteria_id' => $validatedData['kriteria_id'],
    //         'komendasi' => $validatedData['komendasi'],
    //         'rekomendasi' => $validatedData['rekomendasi'],
    //         'tahun_id' => $request->tahun_id,
    //         'program_studi_id' => $request->program_studi_id,
    //         'user_asesor_id' => $userAsesor,
    //         'status' => '1',
    //         // 'rumus_id' => array_key_exists('check', $indikatorData) ? $rumus->id : null,
    //     ]);

    //     return back()->with('success', 'Data Rekomendasi Pembinaan Prodi Berhasil Dibuat!');
    // }

    public function edit($id)
    {
        $rekomendasi = Rekomendasi::find($id);
        $kriteria = Kriteria::whereBetween('id', [3, 13])->get();
        // $program_studi = ProgramStudi::get();
        return view('asesor.rekomendasi.edit-rekomendasi', compact('rekomendasi', 'kriteria'));
    }

    public function update(Request $request, $id)
    {
        $rekomendasi = Rekomendasi::find($id);
        $rekomendasi->kriteria_id = $request->kriteria_id;
        $rekomendasi->komendasi = $request->komendasi;
        $rekomendasi->rekomendasi = $request->rekomendasi;
        $rekomendasi->save();

        return redirect()->back()->with('success', 'Data Rekomendasi Pembinaan Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekomendasi = Rekomendasi::find($id);
        $rekomendasi->delete();
    }
}
