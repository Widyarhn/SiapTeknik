<?php

namespace App\Http\Controllers;

use App\Models\Rumus;
use App\Models\Golongan;
use App\Models\Kriteria;
use App\Models\Suplemen;
use App\Models\UserAsesor;
use App\Models\SubKriteria;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\AsesmenLapangan;
use App\Models\MatriksPenilaian;
use App\Models\Timeline;
use Yajra\DataTables\DataTables;
use App\Services\FormulaEvaluator;
use Illuminate\Support\Facades\Auth;

class NilaiAsesmenLapanganD3Controller extends Controller
{
    // public function index(Request $request)
    // {
    //     return view('asesor.penilaiand3.asesmen-lapangan.index');
    // }
    protected $evaluator;

    public function __construct(FormulaEvaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    public function calculateItem(Request $request, string $id_kriteria)
    {
        try {
            $sub_kriteria_ids = SubKriteria::where('kriteria_id', $id_kriteria)->pluck('id')->toArray();
            $rumuses = Rumus::whereIn('sub_kriteria_id', $sub_kriteria_ids)->get();
            $processedRumusIds = [];

            foreach ($rumuses as $rumus) {
                $rumus_id = $rumus->id;
                $variables = $request->get($rumus_id, []);

                if (is_array($variables) && !empty($variables)) {
                    if (!in_array($rumus_id, $processedRumusIds)) {
                        $persamaan = $rumus->rumus;
                        $result = $this->evaluator->evaluate($persamaan, $variables);
                        $rumus->t_butir = floatval($result['result']);
                        $rumus->save();
                        $processedRumusIds[] = $rumus_id;
                    } else {
                        return redirect()->back()->with('error', 'Rumus_id sudah diproses: ' . $rumus_id);
                    }
                } else {
                    return redirect()->back()->with('error', 'Data variabel tidak valid atau kosong untuk rumus_id: ' . $rumus_id);
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menyimpan data',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function selesai($id)
    {
        $timeline = Timeline::find($id);
        $timeline->status = "1";
        $timeline->save();

        return response()->json(['success' => true, 'message' => 'Asesmen Kecukupan Selesai! Lihat Info selanjutnya!']);
    }

    public function elemen($id_prodi)
    {
        $data = [
            "kriteria" => Kriteria::all(),
        ];
        $user_asesor = UserAsesor::with('tahun')->where("user_id", Auth::user()->id)->where("program_studi_id", $id_prodi)->first();
        $kriteria = Kriteria::first();
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        return view('asesor.penilaian.asesmen-lapangan.index', $data,  ['program_studi' => $program_studi, 'user_asesor' => $user_asesor]);
    }

    public function json(Request $request, $id_prodi)
    {
        $data = Kriteria::orderBy('id', 'ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($id_prodi) {
                return '<div class="buttons">
            <a href="' . route('asesor.penilaian.asesmen-lapangan.show', ['id' => $row->id, 'id_prodi' => $id_prodi]) . '" class="btn btn-primary btn-md"><i class="fa fa-eye"></i></a>
            </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show(Request $request, $id, $id_prodi)
    {
        $kriteria = Kriteria::where("id", $id)->first();

        $program_studi = ProgramStudi::findOrFail($id_prodi);

        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->where("program_studi_id", $program_studi->id)->first();

        $jabatan = UserAsesor::where("program_studi_id", $program_studi->id)->where('jabatan', 'Ketua Asesor')->first();

        $matriks = MatriksPenilaian::with(['jenjang', 'kriteria', 'sub_kriteria', 'indikator', 'data_dukung', 'anotasi_label', 'asesmen_kecukupan' => function ($q) use ($jabatan) {
            $q->where('user_asesor_id', $jabatan->id);
        }])->orderBy('kriteria_id', 'ASC')
            ->where("jenjang_id", $user_asesor->jenjang_id)
            ->where("kriteria_id", $id)
            ->get();


        return view('asesor.penilaian.asesmen-lapangan.show', compact("kriteria", "program_studi", "user_asesor", "matriks"));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate(
            [
                'nilai' => ['required', 'numeric'],
                'deskripsi' => 'required'
            ],
            [
                'nilai.required' => 'Nilai harus diisi',
                'nilai.numeric' => 'Nilai harus berisi angka',
                'nilai.min' => 'Nilai tidak boleh kurang dari 1',
                'nilai.max' => 'Nilai tidak boleh lebih dari 4',
                'deskripsi.required' => 'Deskripsi harus diisi'
            ]
        );

        // Buat instance baru dari model AsesmenLapangan
        $asesmenLapangan = new AsesmenLapangan;

        // Set nilai properti berdasarkan inputan user
        $asesmenLapangan->nilai = $request->nilai;
        $asesmenLapangan->deskripsi = $request->deskripsi;
        $asesmenLapangan->matriks_penilaian_id = $request->m_id;
        $asesmenLapangan->timeline_id = $request->timeline_id;
        $asesmenLapangan->user_asesor_id = $request->user_asesor_id;

        // Simpan data ke dalam database
        $asesmenLapangan->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil memberikan nilai dan deskripsi nilai');
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'nilai' => ['required', 'numeric', 'min:1', 'max:4'],
                'deskripsi' => 'required'
            ],
            [
                'nilai.required' => 'Nilai harus diisi',
                'nilai.numeric' => 'Nilai harus berisi angka',
                'nilai.min' => 'Nilai tidak boleh kurang dari 1',
                'nilai.max' => 'Nilai tidak boleh lebih dari 4',
                'deskripsi.required' => 'Deskripsi nilai harus diisi'
            ]
        );

        $asesmen_lapangan = AsesmenLapangan::find($id);
        $asesmen_lapangan->nilai = $request->nilai;
        $asesmen_lapangan->program_studi_id = $request->program_studi_id;
        $asesmen_lapangan->jenjang_id = $request->jenjang_id;
        $asesmen_lapangan->tahun_id = $request->tahun_id;
        $asesmen_lapangan->suplemen_id = $request->suplemen_id;
        $asesmen_lapangan->matriks_penilaian_id = $request->matriks_penilaian_id;
        $asesmen_lapangan->deskripsi = $request->deskripsi;
        $asesmen_lapangan->save();

        return redirect()->back()->with('success', 'Berhasil mengubah nilai dan deskripsi nilai asesmen lapangan');
    }
}
