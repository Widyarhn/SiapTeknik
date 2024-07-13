<?php

namespace App\Http\Controllers;

use App\Models\DokumenAjuan;
use App\Models\Kriteria;
use App\Models\Led;
use App\Models\Lkps;
use App\Models\ProgramStudi;
use App\Models\Role;
use App\Models\Tahun;
use App\Models\Timeline;
use App\Models\User;
use App\Models\UserProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AkreditasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            "timeline" => Timeline::with(['program_studi', 'tahun'])->get(),
            "tahun" => Tahun::where('is_active', 0,)->orderBy('tahun', 'ASC')->get(),
            "program_studi" => ProgramStudi::with(['jenjang'])->get(),
            "kriteria" => Kriteria::all(),
            ];
        return view('UPPS.akreditasi.index', $data);
    }

    public function asesmenKecukupan()
    {
        $data = [
            "timeline" => Timeline::all(),
            "tahun" => Tahun::where('is_active', 0,),
            "program_studi" => ProgramStudi::with(['jenjang'])->get(),
            'status_0' => DokumenAjuan::where('status', 0)
                ->with(['program_studi.jenjang'])
                ->get(),
            'status_1' => DokumenAjuan::where('status', 1)
                ->with(['program_studi.jenjang'])
                ->get(),
            'user_prodi' => UserProdi::where("program_studi_id")
                ->get(),
        ];
        return view('UPPS.akreditasi.asesmenKecukupan', $data);
    }

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
            'program_studi_id' => ['required'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date'],
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $tahun = Tahun::create([
                    'tahun' => $validatedData['tahun'],
                    'is_active' => false,
                    'mulai_akreditasi' => $validatedData['tanggal_mulai'],
                ]);
                Timeline::create([
                    'tahun_id' => $tahun->id,
                    'program_studi_id' => $validatedData['program_studi_id'],
                    'kegiatan' => 'Pengajuan Dokumen',
                    'tanggal_mulai' => $validatedData['tanggal_mulai'],
                    'tanggal_akhir' => $validatedData['tanggal_akhir'],
                    'status' => false,
                ]);
            });

            return redirect()->back()->with('success', [
                'success_title' => 'Berhasil!',
                'success_message' => 'Akreditasi Prodi berhasil dibuat.'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal membuat Akreditasi Prodi: ' . $e->getMessage()]);
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
        // Find the timeline
        $timeline = Timeline::findOrFail($id);

        // Find related user_prodi entries
        $userProdiEntries = UserProdi::where('timeline_id', $id)->get();

        // Delete related users and user_prodi entries
        foreach ($userProdiEntries as $userProdi) {
            $user = User::findOrFail($userProdi->user_id);
            $user->delete(); // This will use soft delete if enabled
            $userProdi->delete();
        }

        // Finally delete the timeline
        $timeline->delete();
    }

    public function penugasanProdi(Request $request)
    {
        // Validasi berdasarkan pilihan user
        $request->validate([
            'user_id' => 'required', // Pastikan ada user_id yang terpilih
            'nama' => 'required_if:user_id,other|max:255', // Jika user_id adalah 'other', pastikan nama terisi
            'email' => $request->user_id === 'other' ? 'required|email|unique:users,email' : '', // Jika user_id adalah 'other', validasi email, jika tidak abaikan
        ]);

        // Jika pengguna memilih opsi "Lainnya", buat atau dapatkan user baru
        if ($request->user_id === 'other') {
            // Buat user baru
            $user = new User();
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->password = bcrypt('password'); // Default password, sebaiknya diatur dengan cara yang lebih aman
            $user->role_id = Role::where('role', 'Prodi')->first()->id; // Atur role sesuai dengan kebutuhan
            $user->save();
        } else {
            // Jika pengguna memilih opsi yang sudah ada, dapatkan user yang sesuai dengan ID
            $user = User::findOrFail($request->user_id);
        }

        // Buat entry user_prodi
        $userProdi = new UserProdi();
        $userProdi->user_id = $user->id;
        $userProdi->tahun_id = $request->tahun_id;
        $userProdi->program_studi_id = $request->program_studi_id;
        $userProdi->jenjang_id = $request->jenjang_id;
        $userProdi->timeline_id = $request->timeline_id;
        $userProdi->save();

        return redirect()->back()->with('success', [
            'success_title' => 'Berhasil!',
            'success_message' => 'User berhasil ditugaskan ke Program Studi tersebut.'
        ]);
    }

    public function json(Request $request)
    {
        $data = Timeline::with(['tahun', 'program_studi'])
            ->orderBy('id', 'ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('prodi', function ($row) {
                return $row->program_studi->jenjang->jenjang . ' ' . $row->program_studi->nama;
            })
            ->addColumn('tahun', function ($row) {
                return $row->tahun->tahun;
            })
            ->addColumn('mulai', function ($row) {
                return $row->tahun->mulai_akreditasi;
            })
            ->addColumn('akhir', function ($row) {
                if ($row['tahun.akhir_akreditasi'] == null) {
                    return '-';
                } else {
                    return $row->tahun->akhir_akreditasi;
                }
            })
            ->addColumn('status', function ($row) {
                if ($row['tahun.is_active'] == 0) {
                    $status = '<div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0</div>
                    </div>';
                } else if ($row['tahun.is_active'] == 1) {
                    $status = "<button class='btn btn-success btn-sm'>
                    <i class='fa fa-check'></i> Selesai </button>";
                }
                return $status;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="#" data-toggle="modal" data-target="#modalDetail" data-url="'.route('akreditasi.show', $row->id).'" data-prodi="'. $row->program_studi->jenjang->jenjang . ' ' . $row->program_studi->nama.'" data-tahun="' . $row->tahun->tahun . '" class="btn btn-sm btn-secondary btn-detail"><i class="fa fa-solid fa-eye"></i></a>
                <a href="#" data-url="'.route('UPPS.akreditasi.penugasanProdi').'" data-timeline-id="' . $row->id . '" data-program-studi-id="' . $row->program_studi->id . '" data-tahun-id="' . $row->tahun->id . '" data-jenjang-id="' . $row->program_studi->jenjang->id . '" id="create" class="btn btn-sm btn-info btn-penugasan"><i class="fa fa-solid fa-user-plus"></i></a>
                <a href="javascript:void(0)" data-route="'.route('akreditasi.destroy', $row->id).'"
                    id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
