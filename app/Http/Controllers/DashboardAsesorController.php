<?php

namespace App\Http\Controllers;

use App\Models\UserAsesor;
use App\Models\DeskEvaluasi;
use App\Models\AsesmenLapangan;
use App\Models\BaAsesmenLapangan;
use App\Models\Timeline;
use App\Models\BaDeskEval;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;
use PDF;
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
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();

        $matriks = AsesmenLapangan::where("matriks_penilaian_id", "!=", null)
            ->where("program_studi_id", $user_asesor->program_studi->id)
            ->where("tahun_id", $user_asesor->tahun_id)
            ->get();
        
        $suplemen = AsesmenLapangan::where("suplemen_id", "!=", null)
            ->where("program_studi_id", $user_asesor->program_studi->id)
            ->where("tahun_id", $user_asesor->tahun_id)
            ->get();
        
        $desk_evaluasi = AsesmenLapangan::where('program_studi_id', $user_asesor->program_studi_id)
            ->where("tahun_id", $user_asesor->tahun_id)
            ->with(["matriks_penilaian", "suplemen"])
            ->get();
        
        $data = [
            'user_asesor' => $user_asesor,
            'matriks' => $matriks,
            'suplemen' => $suplemen,
            'desk_evaluasi' => $desk_evaluasi,
        ];

        $namaFile = 'Sertifikat Akreditasi' . ' ' .$user_asesor->program_studi->jenjang->jenjang . ' '. $user_asesor->program_studi->nama. ' '. $user_asesor->tahun->tahun ;
        $pdf = PDF::loadview('asesor.sertifikat.index', $data)->setPaper('a4', 'landscape');

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $namaFile . '.pdf"',
        ];
        return Response::make($pdf->output(), 200, $headers);
    }

    public function show()
    {
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();

        $desk_evaluasi = DeskEvaluasi::where('program_studi_id', $user_asesor->program_studi_id)
        ->where("tahun_id", $user_asesor->tahun_id)
        ->with(["matriks_penilaian", "suplemen"])
        ->get();

        $data = [
            'user_asesor' => $user_asesor,
            'desk_evaluasi' => $desk_evaluasi,
        ];

        $namaFile = 'Berita Acara' . ' Desk Evaluasi ' . ' ' .$user_asesor->program_studi->jenjang->jenjang . ' '. $user_asesor->program_studi->nama. ' '. $user_asesor->tahun->tahun ;

        $pdf = PDF::loadview('asesor.berita-acara.index', $data)->setPaper('a4', 'potrait');
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $namaFile . '.pdf"',
        ];
        return Response::make($pdf->output(), 200, $headers);
    }

    public function asesmen()
    {
        $user_asesor = UserAsesor::where("user_id", Auth::user()->id)->first();

        $asesmen_lapangan = AsesmenLapangan::where('program_studi_id', $user_asesor->program_studi_id)
        ->where("tahun_id", $user_asesor->tahun_id)
        ->with(["matriks_penilaian", "suplemen"])
        ->get();

        $data = [
            'user_asesor' => $user_asesor,
            'asesmen_lapangan' => $asesmen_lapangan,
        ];

        $namaFile = 'Berita Acara' . ' Asesmen Lapangan ' . ' ' .$user_asesor->program_studi->jenjang->jenjang . ' '. $user_asesor->program_studi->nama. ' '. $user_asesor->tahun->tahun ;

        $pdf = PDF::loadview('asesor.berita-acara.asesmen', $data)->setPaper('a4', 'potrait');
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $namaFile . '.pdf"',
        ];
        return Response::make($pdf->output(), 200, $headers);
    }

    public function storeSertif(Request $request)
    {
        $validatedData = $request->validate([
            'file' => ['required', 'mimes:pdf']  
        ],
        [
            'file.mimes' => 'File Sertifikat harus berupa pdf'
        ]);

        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('storage/sertifikat', $file->getClientOriginalName());
        $sertif = new Sertifikat;
        $sertif->file = $nama_file;
        $sertif->program_studi_id = $request->program_studi_id;
        $sertif->tahun_id = $request->tahun_id;
        $sertif->jenjang_id = $request->jenjang_id;
        $sertif->save();

        return redirect()->back()->with('success', 'Sertifikat Berhasil dikirim');
        
    }

    public function deskEval(Request $request)
    {
        $validatedData = $request->validate([
            'file' => ['required', 'mimes:pdf']  
        ],
        [
            'file.mimes' => 'File Berita acara Desk Evaluasi harus berupa pdf'
        ]);

        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('storage/berita-acara', $file->getClientOriginalName());
        $desk_eval = new BaDeskEval;
        $desk_eval->file = $nama_file;
        $desk_eval->program_studi_id = $request->program_studi_id;
        $desk_eval->tahun_id = $request->tahun_id;
        $desk_eval->jenjang_id = $request->jenjang_id;
        $desk_eval->save();

        return redirect()->back()->with('success', 'Berita acara desk evaluasi Berhasil dikirim');
        
    }

    public function asesmenLapangan(Request $request)
    {
        $validatedData = $request->validate([
            'file' => ['required', 'mimes:pdf']  
        ],
        [
            'file.mimes' => 'File Berita acara Asesmen Lapangan harus berupa pdf'
        ]);

        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $file->move('storage/berita-acara', $file->getClientOriginalName());
        $asesmen_lapangan = new BaAsesmenLapangan();
        $asesmen_lapangan->file = $nama_file;
        $asesmen_lapangan->program_studi_id = $request->program_studi_id;
        $asesmen_lapangan->tahun_id = $request->tahun_id;
        $asesmen_lapangan->jenjang_id = $request->jenjang_id;
        $asesmen_lapangan->save();

        return redirect()->back()->with('success', 'Berita acara asesmen lapangan Berhasil dikirim');
        
    }
}
