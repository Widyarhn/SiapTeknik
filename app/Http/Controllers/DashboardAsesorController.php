<?php

namespace App\Http\Controllers;

use App\Models\UserAsesor;
use App\Models\AsesmenKecukupan;
use App\Models\AsesmenLapangan;
use App\Models\BaAsesmenLapangan;
use App\Models\Timeline;
use App\Models\BaDeskEval;
use App\Models\BeritaAcara;
use App\Models\Indikator;
use App\Models\MatriksPenilaian;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class DashboardAsesorController extends Controller
{

    public function index(Request $request)
    {
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();
        $sertifikat = Sertifikat::get();
        $data = [
            'user_asesor' => $user_asesor,
            'sertifikat' => $sertifikat,
            'timeline' => Timeline::all(),
        ];
        return view('asesor.layout.main', $data);
    }

    public function sertif()
    {
        // Ambil data user asesor
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();

        // Ambil ID matriks penilaian untuk user asesor
        $matrixId = AsesmenLapangan::where('user_asesor_id', $user_asesor->id)->pluck('matriks_penilaian_id');

        // Ambil matriks penilaian berdasarkan ID
        $matrixs = MatriksPenilaian::whereIn('id', $matrixId)->get();

        // Ambil ID indikator dari matriks penilaian
        $indicatorsId = $matrixs->pluck('indikator_id');

        // Ambil indikator berdasarkan ID
        $indicators = Indikator::with(['matriks.kriteria', 'matriks.asesmen_lapangan', 'sub_kriteria.kriteria'])
            ->whereIn('id', $indicatorsId)
            ->get();

        $total = 0;
        $total_kes = 0.0;
        $bobotPerRumus = [];
        $rumuses = [];

        // Loop untuk mengumpulkan bobot per rumus_id
        foreach ($indicators as $indicator) {
            if ($indicator->no_butir && $indicator->sub_kriteria->rumus) {
                // Ambil rumus_id dari indikator
                $rumus_id = $indicator->sub_kriteria->rumus->id ?? null;

                if ($rumus_id) {
                    // Inisialisasi bobot jika belum ada
                    if (!isset($bobotPerRumus[$rumus_id])) {
                        $bobotPerRumus[$rumus_id] = 0;
                    }

                    // Tambah bobot berdasarkan rumus_id
                    $bobotPerRumus[$rumus_id] += $indicator->bobot;

                    // Simpan rumus ke dalam array jika belum ada
                    if (!isset($rumuses[$rumus_id])) {
                        $rumuses[$rumus_id] = $indicator->sub_kriteria->rumus;
                    }
                }
            } else {
                // Jika tidak memiliki rumus_id, kalikan bobot dengan nilai
                $total += $indicator->bobot * ($indicator->matriks->asesmen_lapangan->nilai ?? 0);
            }
        }

        // Loop untuk menghitung total berdasarkan bobot dan t_butir
        foreach ($bobotPerRumus as $rumus_id => $totalBobot) {
            // Temukan rumus dengan rumus_id yang sesuai
            $rumus = $rumuses[$rumus_id] ?? null;

            if ($rumus) {
                // Hitung total berdasarkan t_butir dan bobot total per rumus_id
                $total += $totalBobot * ($rumus->t_butir ?? 0);
            }
        }

        // Tambah total perhitungan ke total keseluruhan
        $total_kes += $total;

        // Data untuk PDF
        $data = [
            'user_asesor' => $user_asesor,
            'total' => $total_kes,
        ];

        // Nama file untuk PDF
        $namaFile = 'Sertifikat Akreditasi ' . $user_asesor->program_studi->jenjang->jenjang . ' ' . $user_asesor->program_studi->nama . ' ' . $user_asesor->tahun->tahun;

        // Load view ke dalam PDF
        $pdf = PDF::loadView('asesor.sertifikat.index', $data)->setPaper('a4', 'landscape');

        // Tentukan header untuk respons
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $namaFile . '.pdf"',
        ];

        return Response::make($pdf->output(), 200, $headers);
    }

    // public function sertif()
    // {
    //     $matrixId = AsesmenLapangan::where('user_asesor_id', Auth::user()->user_asesor->id)->pluck('matriks_penilaian_id');
    //     $matrixs = MatriksPenilaian::whereIn('id', $matrixId)->get();
    //     $indicatorsId = $matrixs->pluck('indikator_id');
    //     $indicators = Indikator::with(['matriks.kriteria', 'matriks.asesmen_lapangan', 'sub_kriteria.kriteria'])->whereIn('id', $indicatorsId)->get();

    //     try {
    //         foreach ($indicators as $ind) {
    //             if ($ind->sub_kriteria)
    //                 $data[$matrixs->where('indikator_id', $ind->id)->first()->kriteria_id][$ind->sub_kriteria->id][$ind->id] = $ind;
    //             else
    //                 $data[$matrixs->where('indikator_id', $ind->id)->first()->kriteria_id]['x'][$ind->id] = $ind;
    //         }
    //     } catch (\Exception $e) {
    //         dd($e->getMessage(), $matrixs);
    //     }

    //     $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();

    //     // $matriks = AsesmenLapangan::with(['user_asesor' => function ($q) use ( $user_asesor){
    //     //     $q->where("program_studi_id", $user_asesor->program_studi->id);
    //     //     $q->where("tahun_id", $user_asesor->tahun_id);
    //     // }])->where("matriks_penilaian_id", "!=", null)
    //     //     ->get();

    //     $data = [
    //         'user_asesor' => $user_asesor,
    //     ];

    //     $namaFile = 'Sertifikat Akreditasi' . ' ' .$user_asesor->program_studi->jenjang->jenjang . ' '. $user_asesor->program_studi->nama. ' '. $user_asesor->tahun->tahun ;
    //     $pdf = PDF::loadview('asesor.sertifikat.index', $data)->setPaper('a4', 'landscape');

    //     $headers = [
    //         'Content-Type' => 'application/pdf',
    //         'Content-Disposition' => 'inline; filename="' . $namaFile . '.pdf"',
    //     ];
    //     return Response::make($pdf->output(), 200, $headers);
    // }

    public function asesmen()
    {
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();

        $asesmen_lapangan = AsesmenLapangan::with(['user_asesor' => function ($q) use ($user_asesor) {
            $q->where("program_studi_id", $user_asesor->program_studi->id);
            $q->where("tahun_id", $user_asesor->tahun_id);
        }])->where("matriks_penilaian_id", "!=", null)
            ->get();

        $data = [
            'user_asesor' => $user_asesor,
            'asesmen_lapangan' => $asesmen_lapangan,
        ];

        $namaFile = 'Berita Acara' . ' Asesmen Lapangan ' . ' ' . $user_asesor->program_studi->jenjang->jenjang . ' ' . $user_asesor->program_studi->nama . ' ' . $user_asesor->tahun->tahun;

        $pdf = PDF::loadview('asesor.berita-acara.asesmen', $data)->setPaper('a4', 'potrait');
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $namaFile . '.pdf"',
        ];
        return Response::make($pdf->output(), 200, $headers);
    }

    public function storeSertif(Request $request)
    {
        $validatedData = $request->validate(
            [
                'file' => ['required', 'mimes:pdf']
            ],
            [
                'file.mimes' => 'File Sertifikat harus berupa pdf'
            ]
        );

        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('storage/sertifikat', $file->getClientOriginalName());
        $sertif = new Sertifikat;
        $sertif->file = $nama_file;
        $sertif->program_studi_id = $request->program_studi_id;
        $sertif->tahun_id = $request->tahun_id;
        $sertif->save();

        return redirect()->back()->with('success', [
            'success_title' => 'Success!',
            'success_message' => 'Sertifikat Berhasil dikirim'
        ]);
    }

    public function asesmenLapangan(Request $request)
    {
        $validatedData = $request->validate(
            [
                'file' => ['required', 'mimes:pdf']
            ],
            [
                'file.mimes' => 'File Berita acara Asesmen Lapangan harus berupa pdf'
            ]
        );

        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('storage/berita-acara', $file->getClientOriginalName());
        $asesmen_lapangan =  new BeritaAcara;
        $asesmen_lapangan->file = $nama_file;
        $asesmen_lapangan->program_studi_id = $request->program_studi_id;
        $asesmen_lapangan->tahun_id = $request->tahun_id;
        $asesmen_lapangan->status = '1';
        $asesmen_lapangan->save();

        return redirect()->back()->with('success', [
            'success_title' => 'Success!',
            'success_message' => 'Berita Acara Berhasil dikirim'
        ]);
    }
}
