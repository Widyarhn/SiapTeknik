<?php

namespace App\Http\Controllers;

use App\Models\BaAsesmenLapangan;
use App\Models\BaDeskEval;
use App\Models\DokumenAjuan;
use App\Models\Timeline;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Instrumen;
use App\Models\MatriksPenilaian;
use App\Models\Sertifikat;
use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\Role;
use App\Models\Tahun;
use Illuminate\Http\Request;

class DashboardUPPSController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            "roles" => Role::all(),
            "timeline" => Timeline::with(['tahun', 'program_studi.jenjang'])->get(),
            "tahun" => Tahun::all(),
            "program_studi" => ProgramStudi::with('jenjang')->get(),
            "dokumen_ajuan" => DokumenAjuan::where('status', 0)
                ->with(['program_studi.jenjang'])
                ->get(),
            "status_1" => DokumenAjuan::where('status', 1)
                ->with(['program_studi.jenjang'])
                ->get(),
            "user" => User::where('role_id', '2')->get(),
        ];

        return view('UPPS.layout.main', $data);
    }


    public function json(Request $request)
    {
        $data = Tahun::orderBy('tahun', 'ASC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                if ($row['is_active'] == 0) {
                    $status = '<a href="javascript:void(0)" data-route="' . route('tahun-akreditasi.selesai', $row->id) . '"
                \ data-id="' . $row->id . '" class="btn btn-outline-success btn-md selesai-btn">Selesaikan</a>
            </div>';
                } else if ($row['is_active'] == 1) {
                    $status = "<button class='btn btn-success btn-sm'>
                    <i class='fa fa-check'></i> Selesai
                </button>";
                }
                return $status;
            })
            ->addColumn('action', function ($row) {
                if ($row['is_active'] == 0) {
                    return '<div class="buttons">
                    <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="' . route('dashboard-UPPS.show', $row->id) . '" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>';
                } else {
                    return ' ';
                }
            })
            ->addColumn('awal', function ($row) {
                return $row->tanggal_awal;
            })
            ->addColumn('akhir', function ($row) {
                return $row->tanggal_akhir;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function sertifTable()
    {
        $data = Sertifikat::orderBy('tahun_id', 'ASC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('file', function ($row) {
                // return $row->file;
                return '<div class="buttons">
                <a href="' . url("storage/sertifikat/" . $row->file) . '" target="_blank" class=""><i>' . $row->file . '</i></a>
            </div>';
            })
            ->addColumn('program_studi', function ($row) {
                return $row->program_studi->jenjang->jenjang . ' ' . $row->program_studi->nama;
            })
            ->rawColumns(['file', 'program_studi'])
            ->make(true);
    }

    // public function deskEvalTable()
    // {
    //     $data = BaDeskEval::orderBy('tahun_id', 'ASC')->get();
    //     return DataTables::of($data)
    //         ->addIndexColumn()
    //         ->addColumn('file', function ($row) {
    //             // return $row->file;
    //             return '<div class="buttons">
    //             <a href="' . url("storage/berita-acara/" . $row->file) . '" target="_blank" class=""><i>' . $row->file . '</i></a>
    //         </div>';
    //         })
    //         ->addColumn('program_studi', function ($row) {
    //             return $row->program_studi->jenjang->jenjang . ' ' . $row->program_studi->nama;
    //         })
    //         ->rawColumns(['file', 'program_studi'])
    //         ->make(true);
    // }

    public function asesmenLapanganTable()
    {
        $data = BaAsesmenLapangan::orderBy('tahun_id', 'ASC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('file', function ($row) {
                // return $row->file;
                return '<div class="buttons">
                <a href="' . url("storage/berita-acara/" . $row->file) . '" target="_blank" class=""><i>' . $row->file . '</i></a>
            </div>';
            })
            ->addColumn('program_studi', function ($row) {
                return $row->program_studi->jenjang->jenjang . ' ' . $row->program_studi->nama;
            })
            ->rawColumns(['file', 'program_studi'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'tahun' => 'required'
            ],
            [
                'tahun.required' => 'Tahun Harus Diisi'
            ]
        );

        $tahun = new Tahun;
        $tahun->tahun = $request->tahun;
        $tahun->tanggal_awal = $request->tanggal_awal;
        $tahun->tanggal_akhir = $request->tanggal_akhir;
        $tahun->save();
        return back()->with('sukses', 'Tahun Akreditasi Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $tahun = Tahun::find($id);
        return view('UPPS.edit-tahun', compact('tahun'));
    }

    public function update(Request $request, $id)
    {

        $tahun = Tahun::find($id);
        $tahun->tahun = $request->tahun;
        $tahun->tanggal_awal = $request->tanggal_awal;
        $tahun->tanggal_akhir = $request->tanggal_akhir;
        $tahun->save();

        return redirect()->back()->with('success', 'Data Tahun Berhasil Diubah');
    }

    public function selesai(Request $request, $id)
    {

        try {
            $data = Tahun::where('id', $id)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }


        // Update data dengan data yang diterima dari permintaan Ajax
        $data->update(['is_active' => 1]);

        return response()->json(['message' => 'Data berhasil diubah']);
    }
}