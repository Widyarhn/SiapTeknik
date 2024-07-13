<?php

namespace App\Http\Controllers;

use App\Models\MatriksPenilaian;
use App\Models\ProgramStudi;
use App\Models\Keterangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NilaiProdiController extends Controller
{
    public function index()
    {
        $data = [
            "prodis" => ProgramStudi::all(),
        ];
        $keterangan = Keterangan::where('program_studi_id', 1)->get();
        $matriks_penilaian = MatriksPenilaian::where('program_studi_id', 1)->get();
        return view('prodi.diploma-tiga.nilai.index', $data, compact('matriks_penilaian', 'keterangan'));
    }

    public function json(Request $request)
    {
        $data = MatriksPenilaian::where('program_studi_id', 1)->with(['kriteria', 'asesmen_lapangan'])->orderBy('no_butir', 'ASC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('butir', function ($row) {
                return $row->kriteria->butir . $row->no_butir;
            })
            ->addColumn('deskripsi', function ($row) {
                if ($row->asesmen_lapangan) {
                    return $row->asesmen_lapangan->deskripsi;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai', function ($row) {
                if ($row->asesmen_lapangan) {
                    return $row->asesmen_lapangan->nilai;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai_bobot', function ($row) {
                if ($row->asesmen_lapangan) {
                    return '<span class="badge badge-info">' . $row->asesmen_lapangan->nilai * $row->bobot . '</span>';
                } else {
                    return '<span class="badge badge-info">0</span>';
                }
            })
            ->rawColumns(['butir', 'deskripsi', 'nilai', 'nilai_akhir', 'nilai_bobot'])
            ->make(true);
    }

    public function indexS1()
    {
        $data = [
            "prodis" => ProgramStudi::all(),
        ];
        $keterangan = Keterangan::where('program_studi_id', 2)->get();
        $matriks_penilaian = MatriksPenilaian::where('program_studi_id', 2)->get();
        return view('prodi.sarjana-terapan.nilai.index', $data, compact('matriks_penilaian', 'keterangan'));
    }

    public function jsonS1(Request $request)
    {
        $data = MatriksPenilaian::where('program_studi_id', 2)->with(['kriteria', 'asesmen_lapangan'])->orderBy('no_butir', 'ASC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('butir', function ($row) {
                return $row->kriteria->butir . $row->no_butir;
            })
            ->addColumn('deskripsi', function ($row) {
                if ($row->asesmen_lapangan) {
                    return $row->asesmen_lapangan->deskripsi;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai', function ($row) {
                if ($row->asesmen_lapangan) {
                    return $row->asesmen_lapangan->nilai;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai_bobot', function ($row) {
                if ($row->asesmen_lapangan) {
                    return '<span class="badge badge-info">' . $row->asesmen_lapangan->nilai * $row->bobot . '</span>';
                } else {
                    return '<span class="badge badge-info">0</span>';
                }
            })
            ->rawColumns(['butir', 'deskripsi', 'nilai', 'nilai_akhir', 'nilai_bobot'])
            ->make(true);
    }
}
