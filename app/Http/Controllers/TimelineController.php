<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tahun;
use App\Models\Jenjang;
use App\Models\Timeline;
use App\Models\DokumenAjuan;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            "timeline" => Timeline::all(),
            "tahun" => Tahun::all(),
            "program_studi" => ProgramStudi::with('jenjang')->get(),
            'status_0' => DokumenAjuan::where('status', 0)
                ->with(['program_studi.jenjang'])
                ->get(),
            'status_1' => DokumenAjuan::where('status', 1)
                ->with(['program_studi.jenjang'])
                ->get(),
        ];
        return view('UPPS.timeline.index', $data);
    }

    public function json(Request $request)
    {
        // $program_studi = ProgramStudi::with('jenjang')->get();
        $data = Timeline::with(['tahun', 'program_studi'])
            ->orderBy('nama_kegiatan', 'ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('prodi', function ($row) {
                return $row->program_studi->jenjang->jenjang . ' ' . $row->program_studi->nama;
            })
            ->addColumn('tahun', function ($row) {
                return $row->tahun->tahun;
            })
            ->addColumn('nama', function ($row) {
                return $row->nama_kegiatan;
            })
            ->addColumn('tanggal', function ($row) {
                return $row->jadwal_awal . ' s/d ' . $row->jadwal_akhir;
            })
            ->addColumn('proses', function ($row) {
                if ($row['proses'] == 0) {
                    $proses = '<div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0</div>
                    </div>';
                } else if ($row['proses'] == 1) {
                    $proses = '<div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" data-width="30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                    </div>';
                } else if ($row['proses'] == 2) {
                    $proses = '<div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" data-width="80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                    </div>';
                } else if ($row['proses'] == 3) {
                    $proses = '<div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" data-width="100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>';
                }
                return $proses;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
            <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="' . route('user-prodi.show', $row->id) . '" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a><a href="javascript:void(0)" data-route="' . route('user-prodi.destroy', $row->id) . '"
            id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action', 'proses'])
            ->make(true);
    }
    // <a href="' . route('upps.dokumenajuan.prodi', $row->program_studi->id) . '" id="lihat" class="btn btn-icon icon-left btn-info btn-lihat"><i class="fa fa-solid fa-eye"></i></a>

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tahun' => ['required', 'string', 'max:4'],
            'kegiatan' => ['required', 'min:5', 'max:255'],
            'program_studi_id' => ['required'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date'],
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $tahun = Tahun::create([
                    'tahun' => $validatedData['tahun'],
                    'is_active' => false,
                ]);
                Timeline::create([
                    'tahun_id' => $tahun->id,
                    'program_studi_id' => $validatedData['program_studi_id'],
                    'kegiatan' => $validatedData['kegiatan'],
                    'tanggal_mulai' => $validatedData['tanggal_mulai'],
                    'tanggal_akhir' => $validatedData['tanggal_akhir'],
                    'status' => false, 
                    'tahap' => "1", 
                ]);
            });

            return redirect()->back()->with('success', 'Jadwal Berhasil Dibuat');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal membuat jadwal: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
