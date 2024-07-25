<?php

namespace App\Http\Controllers;

use App\Models\DeskEvaluasi;
use App\Models\DokumenAjuan;
use App\Models\Kriteria;
use App\Models\Led;
use App\Models\Lkps;
use App\Models\ProgramStudi;
use App\Models\Role;
use App\Models\SuratPengantar;
use App\Models\Tahun;
use App\Models\Timeline;
use App\Models\User;
use App\Models\UserAsesor;
use App\Models\UserProdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Mengambil timeline yang memenuhi kriteria
        $timelines = Timeline::join('tahuns', 'timelines.tahun_id', '=', 'tahuns.id')
            ->where('tahuns.is_active', '0')
            ->where('timelines.kegiatan', 'Pengajuan Dokumen')
            ->where('timelines.status', 1)
            ->where('timelines.selesai', 0)
            ->orderBy('tahuns.tahun', 'DESC')
            ->select('timelines.*')
            ->get();

        // Mengambil dokumen yang sesuai dengan timeline yang telah difilter
        $dokumen_ajuans = DokumenAjuan::whereIn('timeline_id', $timelines->pluck('id'))
            ->with('program_studi', 'timeline')
            ->whereIn('kategori', ['LKPS', 'LED', 'Surat Pengantar'])
            ->where('pengajuan_ulang', 0)
            ->first();

        // Mengambil timeline yang memiliki semua dokumen dengan status 1
        $validTimelines = $timelines->filter(function ($timeline) {
            return DokumenAjuan::where('program_studi_id', $timeline->program_studi_id)
                ->where('timeline_id', $timeline->id)
                ->whereIn('kategori', ['lkps', 'led', 'surat_pengantar']) // Sesuaikan kategori
                ->where('pengajuan_ulang', 0)
                ->count() === 3; // Pastikan ada 3 dokumen
        });

        // Mengambil id program studi dari timelines
        $programStudiIds = $timelines->pluck('program_studi_id')->unique();

        $t_asesor = Timeline::with('tahun')
            ->whereHas('tahun', function ($query) {
                $query->where('is_active', '0');
            })
            ->where('kegiatan', 'Asesmen Kecukupan')
            ->where('status', 0)
            ->where('selesai', 0)
            ->whereIn('program_studi_id', $programStudiIds)
            ->first();

        // Mengembalikan view dengan data yang sudah diambil
        $data = [
            "timeline" => $timelines,
            "dokumen_ajuan" => $dokumen_ajuans,
            "approve_dok" => $validTimelines,
            "user" => User::where('role_id', '1')->get(),
            "t_asesor" => $t_asesor,
        ];

        return view('UPPS.akreditasi.index', $data);
    }

    public function selesai($id)
    {
        $timeline = Timeline::find($id);
        $timeline->selesai = true;
        $timeline->save();

        return response()->json(['success' => true, 'message' => 'Ajuan Selesai! Lihat ditahap selanjutnya!']);
    }

    public function approve(Request $request, $id)
    {
        $type = $request->type;

        switch ($type) {
            case 'lkps':
                $dokumen = Lkps::find($id);
                break;
            case 'led':
                $dokumen = Led::find($id);
                break;
            case 'surat_pengantar':
                $dokumen = SuratPengantar::find($id);
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Jenis dokumen tidak valid.']);
        }

        if ($dokumen) {
            $dokumen->status = true;
            $dokumen->keterangan = "Approved";
            $dokumen->save();

            // Update record in DokumenAjuan table if needed
            $dokumen_ajuan = DokumenAjuan::where('step_id', $dokumen->id)
                ->where('kategori', ucfirst($type))
                ->first();

            if ($dokumen_ajuan) {
                $dokumen_ajuan->pengajuan_ulang = false;
                $dokumen_ajuan->keterangan = "Dokumen telah disetujui";
                $dokumen_ajuan->save();
            }

            return response()->json(['success' => true, 'message' => 'Dokumen berhasil disetujui.']);
        }

        return response()->json(['success' => false, 'message' => 'Dokumen tidak ditemukan.']);
    }

    public function disapprove(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string',
        ]);

        // Menentukan jenis dokumen berdasarkan ID
        $dokumen = null;
        switch ($request->input('type')) {
            case 'lkps':
                $dokumen = Lkps::find($id);
                break;
            case 'led':
                $dokumen = Led::find($id);
                break;
            case 'surat_pengantar':
                $dokumen = SuratPengantar::find($id);
                break;
        }

        if ($dokumen) {
            $dokumen->status = 0;
            $dokumen->keterangan = 'Disapproved';
            $dokumen->save();

            $dokumen_ajuan = DokumenAjuan::where('step_id', $dokumen->id)
                ->where('kategori', ucfirst($request->input('type')))
                ->first();

            if ($dokumen_ajuan) {
                $dokumen_ajuan->pengajuan_ulang = true;
                $dokumen_ajuan->keterangan = $request->input('keterangan');
                $dokumen_ajuan->save();
            }

            return redirect()->back()->with('success', 'Dokumen telah ditolak.');
        }

        return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
    }

    public function asesmenKecukupan()
    {
        $timelines = Timeline::with(['program_studi', 'tahun' => function ($query) {
            $query->where('is_active', 0);
        }])
            ->where('kegiatan', 'Asesmen Kecukupan')
            ->where('status', 0)
            ->get();

        $data = [
            "timeline" => $timelines,
            "kriteria" => Kriteria::all(),
        ];
        return view('UPPS.akreditasi.asesmenKecukupan', $data);
    }

    public function jsonAk()
    {
        $data = DeskEvaluasi::with(['timeline', 'program_studi.jenjang', 'user_asesor.user'])
            ->whereHas('timeline', function ($query) {
                $query->where('status', '0')->where('selesai', 0);
            })
            ->get()
            ->groupBy(function ($item) {
                return $item->program_studi_id . '-' . $item->timeline_id . '-' . $item->user_asesor_id;
            })
            ->map(function ($group) {
                return $group->first();
            });

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('tahun', function ($row) {
                return $row->tahun->tahun;
            })
            ->addColumn('prodi', function ($row) {
                return $row->program_studi->jenjang->jenjang . ' ' . $row->program_studi->nama;
            })
            ->addColumn('nilai_asesor1', function ($row) {
                $total = 0.0;
                $data = DeskEvaluasi::where('program_studi_id', $row->program_studi_id)
                ->where('user_asesor_id', $row->user_asesor_id)
                ->where('timeline_id', $row->timeline_id)
                ->get();
                foreach($data as $item){
                    $total += $item->nilai * $item->matriks_penilaian->indikator->bobot;
                }
                return '
                <a href="' . route('akreditasi.asesmenKecukupan.show') . '">' . $total . '</a>
                ';
            })
            ->addColumn('nilai_asesor2', function ($row) {
                // dd($row);
                $total = 0.0;
                $data = DeskEvaluasi::where('program_studi_id', $row->program_studi_id)
                ->where('user_asesor_id', $row->user_asesor_id)
                ->where('timeline_id', $row->timeline_id)
                ->get();
                foreach($data as $item){
                    $total += $item->nilai * $item->matriks_penilaian->indikator->bobot;
                }
                return '
                <a href="' . route('akreditasi.asesmenKecukupan.show') . '">' . $total . '</a>
                ';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('akreditasi.asesmenKecukupan.show') . '" class="show btn btn-info btn-sm"><i class="fa fa-solid fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['tahun','prodi', 'nilai_asesor1','nilai_asesor2', 'action'])
            ->make(true);
    }

    public function asesmenLapangan()
    {
        $timelines = Timeline::with(['program_studi', 'tahun' => function ($query) {
            $query->where('is_active', 0);
        }])
            ->where('kegiatan', 'Asesmen Kecukupan')
            ->where('status', 0)
            ->get();

        $data = [
            "timeline" => $timelines,
            "kriteria" => Kriteria::all(),
        ];
        return view('UPPS.akreditasi.asesmen-Lapangan', $data);
    }

    public function finish()
    {
        $timelines = Timeline::with(['program_studi', 'tahun' => function ($query) {
            $query->where('is_active', 0);
        }])
            ->where('kegiatan', 'Asesmen Kecukupan')
            ->where('status', 0)
            ->get();

        $data = [
            "timeline" => $timelines,
            "kriteria" => Kriteria::all(),
        ];
        return view('UPPS.akreditasi.selesai', $data);
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
    public function show()
    {
        return view('UPPS.akreditasi.showAK');
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

    public function penugasanAsesor(Request $request)
    {
        // Validasi berdasarkan pilihan user
        $validated = $request->validate([
            'user_id' => 'required',
            'tahun_id' => 'required|exists:tahuns,id',
            'program_studi_id' => 'required|exists:program_studis,id',
            'jenjang_id' => 'required|exists:jenjangs,id',
            'jabatan' => 'required|string',
            'tanggal_mulai' => 'required | date',
            'tanggal_akhir' => 'required | date',
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
            $user->role_id = Role::where('role', 'Asesor')->first()->id; // Atur role sesuai dengan kebutuhan
            $user->save();
        } else {
            // Jika pengguna memilih opsi yang sudah ada, dapatkan user yang sesuai dengan ID
            $user = User::findOrFail($request->user_id);
        }

        $timeline = new Timeline();
        $timeline->tahun_id = $request->tahun_id;
        $timeline->program_studi_id = $request->program_studi_id;
        $timeline->kegiatan = 'Asesmen Kecukupan';
        $timeline->tanggal_mulai = $request->tanggal_mulai;
        $timeline->tanggal_akhir = $request->tanggal_akhir;
        $timeline->status = false;
        $timeline->save();

        // Buat entry user_prodi
        $userAsesor = new UserAsesor();
        $userAsesor->user_id = $user->id;
        $userAsesor->tahun_id = $request->tahun_id;
        $userAsesor->program_studi_id = $request->program_studi_id;
        $userAsesor->jenjang_id = $request->jenjang_id;
        $userAsesor->timeline_id = $timeline->id;
        $userAsesor->jabatan = $request->jabatan;
        $userAsesor->save();


        return redirect()->back()->with('success', 'User Asesor Berhasil Ditugaskan');
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
                <a href="#" data-toggle="modal" data-target="#modalDetail" data-url="' . route('akreditasi.show', $row->id) . '" data-prodi="' . $row->program_studi->jenjang->jenjang . ' ' . $row->program_studi->nama . '" data-tahun="' . $row->tahun->tahun . '" class="btn btn-sm btn-secondary btn-detail"><i class="fa fa-solid fa-eye"></i></a>
                <a href="#" data-url="' . route('UPPS.akreditasi.penugasanProdi') . '" data-timeline-id="' . $row->id . '" data-program-studi-id="' . $row->program_studi->id . '" data-tahun-id="' . $row->tahun->id . '" data-jenjang-id="' . $row->program_studi->jenjang->id . '" id="create" class="btn btn-sm btn-info btn-penugasan"><i class="fa fa-solid fa-user-plus"></i></a>
                <a href="javascript:void(0)" data-route="' . route('akreditasi.destroy', $row->id) . '"
                    id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
