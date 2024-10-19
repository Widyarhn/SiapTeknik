<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Led;
use App\Models\Lkps;
use App\Models\Role;
use App\Models\User;
use App\Models\Tahun;
use App\Models\Kriteria;
use App\Models\Timeline;
use App\Models\Indikator;
use App\Models\UserProdi;
use App\Models\UserAsesor;
use App\Models\DokumenAjuan;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\SuratPengantar;
use App\Models\AsesmenLapangan;
use App\Models\LampiranRenstra;
use App\Models\SuratPernyataan;
use App\Models\AsesmenKecukupan;
use App\Models\MatriksPenilaian;
use App\Models\PengajuanDokumen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $pengajuan_dokumens = PengajuanDokumen::with(['user_prodi.tahun' => function ($q) {
            $q->where('is_active', 1);
            $q->orderBy('tahun', 'DESC');
        }, 'user_prodi', 'lkps', 'led', 'surat_pengantar'])
            ->where('status', '1')
            ->whereNull('tanggal_selesai')
            ->get();

        // Mengambil id program studi dari timelines
        $programStudiIds = $pengajuan_dokumens->pluck('user_prodi.program_studi_id')->unique();

        $t_asesor = UserAsesor::with(['timeline' => function ($q) {
            $q->where('kegiatan', 'Asesmen Kecukupan');
            $q->where('status', '0');
            $q->where('selesai', 0);
        }])->whereIn('program_studi_id', $programStudiIds)
            ->get();

        $data = [
            "pengajuan" => $pengajuan_dokumens,
            "user" => User::where('role_id', '1')->get(),
            "t_asesor" => $t_asesor,
        ];

        // // Mengambil timeline yang memenuhi kriteria
        // $timelines = Timeline::join('tahuns', 'timelines.tahun_id', '=', 'tahuns.id')
        //     ->where('tahuns.is_active', '0')
        //     ->where('timelines.kegiatan', 'Pengajuan Dokumen')
        //     ->where('timelines.status', '1')
        //     ->where('timelines.selesai', 0)
        //     ->orderBy('tahuns.tahun', 'DESC')
        //     ->select('timelines.*')
        //     ->get();

        // // Mengambil dokumen yang sesuai dengan timeline yang telah difilter
        // $dokumen_ajuans = DokumenAjuan::whereIn('timeline_id', $timelines->pluck('id'))
        //     ->with('program_studi', 'timeline')
        //     ->whereIn('kategori', ['LKPS', 'LED', 'Surat Pengantar'])
        //     ->where('pengajuan_ulang', 0)
        //     ->first();

        // // Mengambil timeline yang memiliki semua dokumen dengan status 1
        // $validTimelines = $timelines->filter(function ($timeline) {
        //     return DokumenAjuan::where('program_studi_id', $timeline->program_studi_id)
        //         ->where('timeline_id', $timeline->id)
        //         ->whereIn('kategori', ['lkps', 'led', 'surat_pengantar']) // Sesuaikan kategori
        //         ->where('pengajuan_ulang', 0)
        //         ->count() === 3; // Pastikan ada 3 dokumen
        // });

        // // Mengambil id program studi dari timelines
        // $programStudiIds = $timelines->pluck('program_studi_id')->unique();

        // $t_asesor = Timeline::with('tahun')
        //     ->whereHas('tahun', function ($query) {
        //         $query->where('is_active', '0');
        //     })
        //     ->where('kegiatan', 'Asesmen Kecukupan')
        //     ->where('status', '0')
        //     ->where('selesai', 0)
        //     ->whereIn('program_studi_id', $programStudiIds)
        //     ->first();

        // // Mengembalikan view dengan data yang sudah diambil
        // $data = [
        //     "timeline" => $timelines,
        //     "dokumen_ajuan" => $dokumen_ajuans,
        //     "approve_dok" => $validTimelines,
        //     "user" => User::where('role_id', '1')->get(),
        //     "t_asesor" => $t_asesor,
        // ];

        return view('UPPS.akreditasi.index', $data);
    }

    public function selesai($id)
    {
        $pengajuan = PengajuanDokumen::find($id);
        $pengajuan->tanggal_selesai = Carbon::today();
        $pengajuan->keterangan = 'Finished';
        $pengajuan->save();

        return response()->json(['success' => true, 'message' => 'Pengajuan Dokumen Selesai! Lihat ditahap selanjutnya!']);
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
            case 'surat_pernyataan':
                $dokumen = SuratPernyataan::find($id);
                break;
            case 'lampiran_renstra':
                $dokumen = LampiranRenstra::find($id);
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Jenis dokumen tidak valid.']);
        }

        if ($dokumen) {
            $dokumen->status = '1';
            $dokumen->keterangan = "Approved";
            $dokumen->save();

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
            case 'surat_pernyataan':
                $dokumen = SuratPernyataan::find($id);
                break;
            case 'lampiran_renstra':
                $dokumen = LampiranRenstra::find($id);
                break;
        }

        if ($dokumen) {
            $dokumen->status = '2';
            $dokumen->keterangan = 'Disapproved';
            $dokumen->save();

            $dokumen_ajuan = PengajuanDokumen::where('id', $dokumen->id)->first();

            if ($dokumen_ajuan) {
                $dokumen_ajuan->status = '2';
                $dokumen_ajuan->keterangan = $request->input('keterangan');
                $dokumen_ajuan->save();
            }

            return redirect()->back()->with('success', 'Dokumen telah ditolak.');
        }

        return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
    }

    public function selesai_ak($id)
    {
        $timeline = Timeline::find($id);
        $timeline->selesai = true;
        $timeline->save();

        return response()->json(['success' => true, 'message' => 'Ajuan Selesai! Lihat ditahap selanjutnya!']);
    }

    public function approve_al(Request $request, $id)
    {
        $ak = Timeline::find($id);

        $ak->selesai = true;
        $ak->keterangan = 'Approved';
        $ak->save();

        $tahun = Tahun::where('id', $ak->tahun_id)->firstOrFail();
        $tahun->akhir_akreditasi = now();
        $tahun->is_active = false;
        $tahun->update();

        return redirect()->back()->with('success', 'Asesmen Lapangan telah disetujui!');
    }

    // public function disapprove_al(Request $request, $id)
    // {
    //     $request->validate([
    //         'keterangan' => 'required|string',
    //     ]);

    //     $ak = Timeline::find($id);

    //     $ak->status = '2';
    //     $ak->keterangan = $request->input('keterangan');
    //     $ak->save();

    //     return redirect()->back()->with('success', 'Asesmen Kecukupan telah ditolak.');
    // }
    public function approve_ak(Request $request, $id)
    {
        $ak = Timeline::find($id);

        $ak->selesai = true;
        $ak->keterangan = 'Approved';
        $ak->save();

        $validated = $request->validate([
            'thn' => 'required|exists:tahuns,id',
            'prodi' => 'required|exists:program_studies,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        $timeline = new Timeline();
        $timeline->tahun_id = $request->thn;
        $timeline->program_studi_id = $request->prodi;
        $timeline->kegiatan = 'Asesmen Lapangan';
        $timeline->tanggal_mulai = $request->tanggal_mulai;
        $timeline->batas_waktu = $request->tanggal_akhir;
        $timeline->status = '0';
        $timeline->save();

        $userAsesors = UserAsesor::where('timeline_id', $ak->id)->get();

        foreach ($userAsesors as $userAsesor) {
            $userAsesor->timeline_id = $timeline->id;
            $userAsesor->save();
        }

        return redirect()->back()->with('success', 'Asesmen Kecukupan telah disetujui. Lihat proses selanjutnya!');
    }

    public function disapprove_ak(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string',
        ]);

        $ak = Timeline::find($id);

        $ak->status = '2';
        $ak->keterangan = $request->input('keterangan');
        $ak->save();

        return redirect()->back()->with('success', 'Asesmen Kecukupan telah ditolak.');
    }

    public function asesmenKecukupan()
    {
        $timelines = Timeline::with(['user_asesor.tahun' => function ($query) {
            $query->where('is_active', 1);
        }, 'user_asesor', 'program_studi', 'tahun'])
            ->where('kegiatan', 'Asesmen Kecukupan')
            ->where('status', '1')
            ->where('selesai', 0)
            ->get();

        $data = [
            "timeline" => $timelines,
            "kriteria" => Kriteria::all(),
        ];
        return view('UPPS.akreditasi.asesmenKecukupan', $data);
    }

    public function jsonAk()
    {
        $dt = [];
        $data = ProgramStudi::with(['timeline' => function ($q) {
            $q->where('status', '1');
            $q->where('selesai', 0);
            $q->where('kegiatan', 'Asesmen Kecukupan');
        }, 'timeline.tahun', 'user_asesor.asesmen_kecukupan'])
            ->whereHas('timeline.tahun', function ($q) {
                $q->where('is_active', 1);
            })
            ->get();

        foreach ($data as $item) {
            if (count($item->timeline) > 0) {
                $format = [];
                foreach ($item->timeline as $timeline) {
                    $format["tahun"] = $timeline->tahun->tahun;
                    $format["program_studi"] = $item->jenjang->jenjang . ' ' . $item->nama;
                    $format["timeline"] = $timeline->id;
                    $format["prodi"] = $timeline->program_studi_id;
                    $format["thn"] = $timeline->tahun_id;
                    $format["keterangan"] = $timeline->keterangan;
                    $format["selesai"] = $timeline->selesai;
                }

                $nilai_asesor = [];
                foreach ($item->user_asesor as $i => $user_asesor) {
                    $total = 0.0;
                    $bobotPerRumus = [];
                    $rumuses = [];

                    foreach ($user_asesor->asesmen_kecukupan as $asesmen_kecukupan) {
                        $indicator = $asesmen_kecukupan->matriks_penilaian->indikator;

                        if ($indicator->no_butir && $indicator->sub_kriteria->rumus) {
                            $rumus_id = $indicator->sub_kriteria->rumus->id ?? null;

                            if ($rumus_id) {
                                if (!isset($bobotPerRumus[$rumus_id])) {
                                    $bobotPerRumus[$rumus_id] = 0;
                                }

                                $bobotPerRumus[$rumus_id] += $indicator->bobot;

                                if (!isset($rumuses[$rumus_id])) {
                                    $rumuses[$rumus_id] = $indicator->sub_kriteria->rumus;
                                }
                            }
                        } else {
                            $total += $indicator->bobot * ($asesmen_kecukupan->nilai ?? 0);
                        }
                    }

                    foreach ($bobotPerRumus as $rumus_id => $totalBobot) {
                        $rumus = $rumuses[$rumus_id] ?? null;

                        if ($rumus) {
                            $total += $totalBobot * ($rumus->t_butir ?? 0);
                        }
                    }

                    $format['nilai_asesor' . ($i + 1)] = $total;
                    $format['asesor' . ($i + 1)] = $user_asesor->id;
                }
                array_push($dt, $format);
            }
        }

        return datatables()->of($dt)
            ->addIndexColumn()
            ->addColumn('tahun', function ($row) {
                return $row['tahun'];
            })
            ->addColumn('prodi', function ($row) {
                return $row['program_studi'];
            })
            ->addColumn('nilai_asesor1', function ($row) {
                return '
            <a href="' . route('akreditasi.asesmenKecukupan.show', ['id' => $row['asesor1']]) . '">' . number_format($row['nilai_asesor1'], 2) . '</a>
            ';
            })
            ->addColumn('nilai_asesor2', function ($row) {
                if (array_key_exists('nilai_asesor2', $row)) {
                    return '
                <a href="' . route('akreditasi.asesmenKecukupan.show', ['id' => $row['asesor2']]) . '">' . number_format($row['nilai_asesor2'], 2) . '</a>
                ';
                }
                return '-';
            })
            ->addColumn('nilai_asesor3', function ($row) {
                if (array_key_exists('nilai_asesor3', $row)) {
                    return '
                <a href="' . route('akreditasi.asesmenKecukupan.show', ['id' => $row['asesor3']]) . '">' . number_format($row['nilai_asesor3'], 2) . '</a>
                ';
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if ($row['selesai'] == 1) {
                    return '
                <div class="buttons btn btn-sm btn-success">' . $row['keterangan'] . '</div>
                ';
                } else {
                    return '<div class="buttons">
            <button type="button" class="btn btn-success btn-sm approve-btn" data-id="' . $row['timeline'] . '" data-prodi="' . $row['prodi'] . '" data-thn="' . $row['thn'] . '"
                data-route="' . route('ak.approve', ['id' => $row['timeline']]) . '"><i class="fas fa-check"></i></button>
            <button type="button" class="btn btn-danger btn-sm disapprove-btn" data-id="' . $row['timeline'] . '" 
                data-route="' . route('ak.disapprove', ['id' => $row['timeline']]) . '"><i class="fas fa-times"></i></button>
            ';
                }
            })
            ->rawColumns(['tahun', 'prodi', 'nilai_asesor1', 'nilai_asesor2', 'nilai_asesor3', 'action'])
            ->make(true);
    }

    public function asesmenLapangan()
    {
        $timelines = Timeline::with(['user_asesor.tahun' => function ($query) {
            $query->where('is_active', 1);
        }, 'user_asesor', 'program_studi', 'tahun'])
            ->where('kegiatan', 'Asesmen Lapangan')
            ->where('status', '1')
            ->where('selesai', 0)
            ->get();

        $data = [
            "timeline" => $timelines,
            "kriteria" => Kriteria::all(),
        ];
        return view('UPPS.akreditasi.asesmen-Lapangan', $data);
    }

    public function jsonAl()
    {

        $dt = [];
        $data = ProgramStudi::with(['timeline' => function ($q) {
            $q->where('status', '1');
            $q->where('selesai', 0);
            $q->where('kegiatan', 'Asesmen Lapangan');
        }, 'user_asesor.asesmen_lapangan', 'berita_acara'])
            ->whereHas('timeline.tahun', function ($q) {
                $q->where('is_active', 1);
            })
            ->get();
        foreach ($data as $item) {
            if ($item->berita_acara && count($item->timeline) > 0) {
                $format = [];
                foreach ($item->timeline as $timeline) {
                    $format["tahun"] = $timeline->tahun->tahun;
                    $format["program_studi"] = $item->jenjang->jenjang . ' ' . $item->nama;
                    // Perbaiki URL untuk berita_acara
                    $format["berita_acara"] = $item->berita_acara->first()->file
                        ? url('storage/berita-acara/' . $item->berita_acara->first()->file)
                        : '-';
                    $format["rekomendasi"] = $item->rpembinaan->first()->file
                        ? url('storage/rekomendasi/' . $item->rpembinaan->first()->file)
                        : '-';
                    // $format["sertifikat"] = $item->sertifikat->file ? url('storage/' . $item->sertifikat->file) : '-';
                    $format["timeline"] = $timeline->id;
                    $format["prodi"] = $timeline->program_studi_id;
                    $format["thn"] = $timeline->tahun_id;
                    $format["keterangan"] = $timeline->keterangan;
                    $format["selesai"] = $timeline->selesai;
                }

                $nilai_asesor = [];
                foreach ($item->user_asesor as $i => $user_asesor) {
                    $total = 0.0;
                    $bobotPerRumus = [];
                    $rumuses = [];

                    foreach ($user_asesor->asesmen_kecukupan as $asesmen_kecukupan) {
                        $indicator = $asesmen_kecukupan->matriks_penilaian->indikator;

                        if ($indicator->no_butir && $indicator->sub_kriteria->rumus) {
                            $rumus_id = $indicator->sub_kriteria->rumus->id ?? null;

                            if ($rumus_id) {
                                if (!isset($bobotPerRumus[$rumus_id])) {
                                    $bobotPerRumus[$rumus_id] = 0;
                                }

                                $bobotPerRumus[$rumus_id] += $indicator->bobot;

                                if (!isset($rumuses[$rumus_id])) {
                                    $rumuses[$rumus_id] = $indicator->sub_kriteria->rumus;
                                }
                            }
                        } else {
                            $total += $indicator->bobot * ($asesmen_kecukupan->nilai ?? 0);
                        }
                    }

                    foreach ($bobotPerRumus as $rumus_id => $totalBobot) {
                        $rumus = $rumuses[$rumus_id] ?? null;

                        if ($rumus) {
                            $total += $totalBobot * ($rumus->t_butir ?? 0);
                        }
                    }

                    $format['nilai_asesor' . ($i + 1)] = $total;
                    $format['asesor' . ($i + 1)] = $user_asesor->id;
                }
                array_push($dt, $format);
            }
        }

        return datatables()->of($dt)
            ->addIndexColumn()
            ->addColumn('tahun', function ($row) {
                return $row['tahun'];
            })
            ->addColumn('prodi', function ($row) {
                return $row['program_studi'];
            })
            ->addColumn('nilai_akhir', function ($row) {
                return '
            <a href="' . route('akreditasi.asesmenLapangan.show', ['id' => $row['asesor1']]) . '">' . number_format($row['nilai_asesor1'], 2) . '</a>
            ';
            })

            ->addColumn('berita_acara', function ($row) {
                return $row['berita_acara'] === '-' ? '-' : '<a href="' . $row['berita_acara'] . '" target="_blank">' . basename($row['berita_acara']) . '</a>';
            })
            ->addColumn('saran_rekomendasi', function ($row) {

                return $row['rekomendasi'] === '-' ? '-' : '<a href="' . $row['rekomendasi'] . '" target="_blank">' . basename($row['rekomendasi']) . '</a>';
            })
            ->addColumn('action', function ($row) {

                if ($row['selesai'] == 1) {
                    return '
                <div class="buttons btn btn-sm btn-success">' . $row['keterangan'] . '</div>
                ';
                } else {
                    return '<div class="buttons">
            <button type="button" class="btn btn-success btn-sm approve-btn" data-id="' . $row['timeline'] . '" 
                data-route="' . route('al.approve', ['id' => $row['timeline']]) . '"><i class="fas fa-check"></i></button>
            ';
                }
            })
            ->rawColumns(['tahun', 'prodi', 'nilai_akhir', 'berita_acara', 'saran_rekomendasi', 'action'])
            ->make(true);
    }

    public function finish()
    {
        $timelines = Timeline::with(['program_studi', 'tahun' => function ($query) {
            $query->where('is_active', 1);
        }])
            ->where('kegiatan', 'Asesmen Lapangan')
            ->where('status', '1')
            ->where('selesai', '1')
            ->get();

        $data = [
            "timeline" => $timelines,
            "kriteria" => Kriteria::all(),
        ];
        return view('UPPS.akreditasi.selesai', $data);
    }

    public function finishJson()
    {
        $dt = [];
        $data = ProgramStudi::with(['timeline' => function ($q) {
            $q->where('status', '1');
            $q->where('selesai', 1);
            $q->where('kegiatan', 'Asesmen Lapangan');
        }, 'user_asesor.asesmen_lapangan', 'berita_acara', 'sertifikat'])
            ->whereHas('timeline.tahun', function ($q) {
                $q->where('is_active', 1);
            })
            ->get();

        foreach ($data as $item) {
            if (count($item->timeline) > 0) {
                $format = [];
                foreach ($item->timeline as $timeline) {
                    $format["tahun"] = $timeline->tahun->tahun;
                    $format["program_studi"] = $item->jenjang->jenjang . ' ' . $item->nama;
                    $format["berita_acara"] = $item->berita_acara->first()->file
                        ? url('storage/berita-acara/' . $item->berita_acara->first()->file)
                        : '-';
                    $format["sertifikat"] = $item->sertifikat->first()->file
                        ? url('storage/sertifikat/' . $item->sertifikat->first()->file)
                        : '-';
                    $format["rekomendasi"] = $item->rpembinaan->first()->file
                        ? url('storage/rekomendasi/' . $item->rpembinaan->first()->file)
                        : '-';
                    $format["timeline"] = $timeline->id;
                    $format["prodi"] = $timeline->program_studi_id;
                    $format["thn"] = $timeline->tahun_id;
                    $format["keterangan"] = $timeline->keterangan;
                    $format["selesai"] = $timeline->selesai;
                }

                $nilai_asesor = [];
                $total_kes = 0;
                foreach ($item->user_asesor as $i => $user_asesor) {
                    $total = 0.0;
                    $bobotPerRumus = [];
                    $rumuses = [];

                    foreach ($user_asesor->asesmen_kecukupan as $asesmen_kecukupan) {
                        $indicator = $asesmen_kecukupan->matriks_penilaian->indikator;

                        if ($indicator->no_butir && $indicator->sub_kriteria->rumus) {
                            $rumus_id = $indicator->sub_kriteria->rumus->id ?? null;

                            if ($rumus_id) {
                                if (!isset($bobotPerRumus[$rumus_id])) {
                                    $bobotPerRumus[$rumus_id] = 0;
                                }

                                $bobotPerRumus[$rumus_id] += $indicator->bobot;

                                if (!isset($rumuses[$rumus_id])) {
                                    $rumuses[$rumus_id] = $indicator->sub_kriteria->rumus;
                                }
                            }
                        } else {
                            $total += $indicator->bobot * ($asesmen_kecukupan->nilai ?? 0);
                        }
                    }

                    foreach ($bobotPerRumus as $rumus_id => $totalBobot) {
                        $rumus = $rumuses[$rumus_id] ?? null;

                        if ($rumus) {
                            $total += $totalBobot * ($rumus->t_butir ?? 0);
                        }
                    }

                    $format['nilai_asesor' . ($i + 1)] = $total;
                    $format['asesor' . ($i + 1)] = $user_asesor->id;

                    // Menambah nilai total keseluruhan dari semua asesor
                    $total_kes += $total;
                }

                // Kondisi untuk menentukan hasil akreditasi
                if ($total_kes >= 1 && $total_kes <= 200) {
                    $format['akreditasi'] = 'TIDAK MEMENUHI SYARAT PERINGKAT';
                } elseif ($total_kes >= 200 && $total_kes <= 301) {
                    $format['akreditasi'] = 'BAIK';
                } elseif ($total_kes >= 301 && $total_kes <= 361) {
                    $format['akreditasi'] = 'BAIK SEKALI';
                } elseif ($total_kes >= 361) {
                    $format['akreditasi'] = 'UNGGUL';
                }

                array_push($dt, $format);
            }
        }

        return datatables()->of($dt)
            ->addIndexColumn()
            ->addColumn('tahun', function ($row) {
                return $row['tahun'];
            })
            ->addColumn('prodi', function ($row) {
                return $row['program_studi'];
            })
            ->addColumn('akreditasi', function ($row) {
                return $row['akreditasi'] ?? '-';
            })
            ->addColumn('sertifikat', function ($row) {
                return $row['sertifikat'] === '-' ? '-' : '<a href="' . $row['sertifikat'] . '" target="_blank">' . basename($row['sertifikat']) . '</a>';
            })
            ->addColumn('saran_rekomendasi', function ($row) {
                return $row['rekomendasi'] === '-' ? '-' : '<a href="' . $row['rekomendasi'] . '" target="_blank">' . basename($row['rekomendasi']) . '</a>';
            })
            ->addColumn('berita_acara', function ($row) {
                return $row['berita_acara'] === '-' ? '-' : '<a href="' . $row['berita_acara'] . '" target="_blank">' . basename($row['berita_acara']) . '</a>';
            })
            ->addColumn('action', function ($row) {
                return '
            <a class="btn btn-secondary btn-sm" href="' . route('upps.dokumenajuan.prodi', ['id_prodi' => $row['prodi']]) . '"><i class="fas fa-eye"></i></a>
            ';
            })
            ->rawColumns(['tahun', 'prodi', 'akreditasi', 'berita_acara', 'saran_rekomendasi', 'sertifikat', 'action'])
            ->make(true);
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
                    'status' => '0',
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
        // Mengambil data user asesor dengan timeline yang sesuai
        $userAsesor = UserAsesor::with(['user', 'timeline' => function ($q) {
            $q->where('status', '1')
                ->where('selesai', 0)
                ->where('kegiatan', 'Asesmen Kecukupan');
        }])->where('id', $id)
            ->first();

        // Mengambil id matriks penilaian yang terkait dengan user asesor
        $matrixId = AsesmenKecukupan::where('user_asesor_id',  $id)->pluck('matriks_penilaian_id');

        // Mengambil data matriks penilaian berdasarkan id yang didapat
        $matrixs = MatriksPenilaian::whereIn('id', $matrixId)->get();

        // Mengambil id indikator yang terkait dengan matriks penilaian
        $indicatorsId = $matrixs->pluck('indikator_id');

        // Mengambil data indikator beserta relasi yang diperlukan
        $indicators = Indikator::with(['matriks.kriteria', 'matriks.asesmen_kecukupan' => function ($q) use ($id) {
            $q->where('user_asesor_id', $id)->get();
        }, 'sub_kriteria.kriteria'])
            ->whereIn('id', $indicatorsId)
            ->get();

        $dataa = []; // Inisialisasi array untuk menyimpan data yang akan ditampilkan

        // Mengelompokkan data indikator berdasarkan kriteria dan sub kriteria
        try {
            foreach ($indicators as $ind) {
                $kriteriaId = $matrixs->where('indikator_id', $ind->id)->first()->kriteria_id;
                if ($ind->sub_kriteria) {
                    $dataa[$kriteriaId][$ind->sub_kriteria->id][$ind->id] = $ind;
                } else {
                    $dataa[$kriteriaId]['x'][$ind->id] = $ind;
                }
            }
        } catch (\Exception $e) {
            // Debugging jika terjadi error
            dd($e->getMessage(), $matrixs);
        }

        // Menggabungkan data yang akan dikirim ke view
        $data = [
            'data' => $dataa,
            'user_asesor' => $userAsesor,
        ];

        // Mengembalikan view dengan data yang telah dipersiapkan
        return view('UPPS.akreditasi.showAK', $data);
    }

    public function showAl($id)
    {
        // Mengambil data user asesor dengan timeline yang sesuai
        $userAsesor = UserAsesor::with(['user', 'timeline' => function ($q) {
            $q->where('status', '1')
                ->where('selesai', 0)
                ->where('kegiatan', 'Asesmen Lapangan');
        }])->where('id', $id)
            ->first();

        // Mengambil id matriks penilaian yang terkait dengan user asesor
        $matrixId = AsesmenLapangan::where('user_asesor_id',  $id)->pluck('matriks_penilaian_id');

        // Mengambil data matriks penilaian berdasarkan id yang didapat
        $matrixs = MatriksPenilaian::whereIn('id', $matrixId)->get();

        // Mengambil id indikator yang terkait dengan matriks penilaian
        $indicatorsId = $matrixs->pluck('indikator_id');

        // Mengambil data indikator beserta relasi yang diperlukan
        $indicators = Indikator::with(['matriks.kriteria', 'matriks.asesmen_lapangan' => function ($q) use ($id) {
            $q->where('user_asesor_id', $id)->get();
        }, 'sub_kriteria.kriteria'])
            ->whereIn('id', $indicatorsId)
            ->get();

        $dataa = []; // Inisialisasi array untuk menyimpan data yang akan ditampilkan

        // Mengelompokkan data indikator berdasarkan kriteria dan sub kriteria
        try {
            foreach ($indicators as $ind) {
                $kriteriaId = $matrixs->where('indikator_id', $ind->id)->first()->kriteria_id;
                if ($ind->sub_kriteria) {
                    $dataa[$kriteriaId][$ind->sub_kriteria->id][$ind->id] = $ind;
                } else {
                    $dataa[$kriteriaId]['x'][$ind->id] = $ind;
                }
            }
        } catch (\Exception $e) {
            // Debugging jika terjadi error
            dd($e->getMessage(), $matrixs);
        }

        // Menggabungkan data yang akan dikirim ke view
        $data = [
            'data' => $dataa,
            'user_asesor' => $userAsesor,
        ];

        // Mengembalikan view dengan data yang telah dipersiapkan
        return view('UPPS.akreditasi.showAl', $data);
    }


    public function detail($id, $id_krit)
    {
        $user_asesor = UserAsesor::with(['user', 'timeline' => function ($q) {
            $q->where('status', '1');
            $q->where('selesai', 0);
            $q->where('kegiatan', 'Asesmen Kecukupan');
        }])->where('id', $id)
            ->first();

        $matriks = MatriksPenilaian::with(['jenjang', 'kriteria', 'sub_kriteria', 'indikator', 'data_dukung', 'anotasi_label', 'asesmen_kecukupan' => function ($q) use ($id) {
            $q->where('user_asesor_id', $id);
        }])->orderBy('kriteria_id', 'ASC')
            ->where("jenjang_id", $user_asesor->jenjang_id)
            ->where("kriteria_id", $id_krit)
            ->get();
        return view('UPPS.akreditasi.detailAK', ['matriks' => $matriks, 'user_asesor' => $user_asesor]);
    }

    public function detailAl($id, $id_krit)
    {
        $user_asesor = UserAsesor::with(['user', 'timeline' => function ($q) {
            $q->where('status', '1');
            $q->where('selesai', 0);
            $q->where('kegiatan', 'Asesmen Lapangan');
        }])->where('id', $id)
            ->first();

        $matriks = MatriksPenilaian::with(['jenjang', 'kriteria', 'sub_kriteria', 'indikator', 'data_dukung', 'anotasi_label', 'asesmen_lapangan' => function ($q) use ($id) {
            $q->where('user_asesor_id', $id);
        }])->orderBy('kriteria_id', 'ASC')
            ->where("jenjang_id", $user_asesor->jenjang_id)
            ->where("kriteria_id", $id_krit)
            ->get();
        return view('UPPS.akreditasi.detailAl', ['matriks' => $matriks, 'user_asesor' => $user_asesor]);
    }

    public function rekap($id)
    {
        $data = AsesmenKecukupan::with(['timeline' => function ($q) {
            $q->where('status', '1');
            $q->where('selesai', 0);
            $q->where('kegiatan', 'Asesmen Kecukupan');
        }, 'matriks_penilaian'])->where("user_asesor_id", $id)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sub_kriteria', function ($row) {
                if ($row->matriks_penilaian->sub_kriteria != null) {
                    return $row->matriks_penilaian->sub_kriteria->sub_kriteria;
                } else {
                    return $row->matriks_penilaian->kriteria->butir . ' ' . $row->matriks_penilaian->kriteria->kriteria;
                }
            })
            ->addColumn('deskripsi', function ($row) {
                if ($row->deskripsi) {
                    return $row->deskripsi;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai', function ($row) {
                if ($row->nilai) {
                    return $row->nilai;
                } else {
                    return ' ';
                }
            })
            ->addColumn('bobot', function ($row) {
                if ($row->matriks_penilaian != null) {
                    return $row->matriks_penilaian->indikator->bobot;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai_bobot', function ($row) {
                if ($row->matriks_penilaian != null) {
                    return '<span class="badge badge-info">' . $row->nilai * $row->matriks_penilaian->indikator->bobot . '</span>';
                } else {
                    return ' ';
                }
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('akreditasi.asesmenKecukupan.detail', ['id' => $row->user_asesor_id, 'id_krit' => $row->id]) . '" class="show btn btn-secondary btn-sm"><i class="fa fa-solid fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'sub_kriteria', 'deskripsi', 'nilai', 'bobot', 'nilai_bobot'])
            ->make(true);
    }

    public function rekapAl($id)
    {
        $data = AsesmenKecukupan::with(['timeline' => function ($q) {
            $q->where('status', '1');
            $q->where('selesai', 0);
            $q->where('kegiatan', 'Asesmen Lapangan');
        }, 'matriks_penilaian'])->where("user_asesor_id", $id)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sub_kriteria', function ($row) {
                if ($row->matriks_penilaian->sub_kriteria != null) {
                    return $row->matriks_penilaian->sub_kriteria->sub_kriteria;
                } else {
                    return $row->matriks_penilaian->kriteria->butir . ' ' . $row->matriks_penilaian->kriteria->kriteria;
                }
            })
            ->addColumn('deskripsi', function ($row) {
                if ($row->deskripsi) {
                    return $row->deskripsi;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai', function ($row) {
                if ($row->nilai) {
                    return $row->nilai;
                } else {
                    return ' ';
                }
            })
            ->addColumn('bobot', function ($row) {
                if ($row->matriks_penilaian != null) {
                    return $row->matriks_penilaian->indikator->bobot;
                } else {
                    return ' ';
                }
            })
            ->addColumn('nilai_bobot', function ($row) {
                if ($row->matriks_penilaian != null) {
                    return '<span class="badge badge-info">' . $row->nilai * $row->matriks_penilaian->indikator->bobot . '</span>';
                } else {
                    return ' ';
                }
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('akreditasi.asesmenLapangan.detail', ['id' => $row->user_asesor_id, 'id_krit' => $row->id]) . '" class="show btn btn-secondary btn-sm"><i class="fa fa-solid fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'sub_kriteria', 'deskripsi', 'nilai', 'bobot', 'nilai_bobot'])
            ->make(true);
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
        // Mengambil data UserProdi berdasarkan ID
        $u_prodi = UserProdi::findOrFail($id);

        // Mengambil user_id dari UserProdi
        $user_id = $u_prodi->user_id;

        // Mengambil semua data PengajuanDokumen yang terkait dengan user_prodi_id
        $pengajuanDokumen = PengajuanDokumen::where('user_prodi_id', $id)->get();

        // Loop melalui setiap PengajuanDokumen dan hapus data yang terkait
        foreach ($pengajuanDokumen as $pengajuan) {
            // Menghapus data PengajuanDokumen
            $pengajuan->delete();
        }

        // Menghapus data User yang terkait dengan user_id
        $user = User::findOrFail($user_id);
        $user->delete();

        // Menghapus data UserProdi
        $u_prodi->delete();
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
            'program_studi_id' => 'required|exists:program_studies,id',
            'jenjang_id' => 'required|exists:jenjangs,id',
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
        $timeline->kegiatan = 'Asesmen Kecukupan';
        $timeline->tanggal_mulai = $request->tanggal_mulai;
        $timeline->batas_waktu = $request->tanggal_akhir;
        $timeline->tahun_id = $request->tahun_id;
        $timeline->program_studi_id = $request->program_studi_id;
        $timeline->status = '0';
        $timeline->save();

        // Buat entry user_prodi
        $userAsesor = new UserAsesor();
        $userAsesor->user_id = $user->id;
        $userAsesor->tahun_id = $request->tahun_id;
        $userAsesor->program_studi_id = $request->program_studi_id;
        $userAsesor->jenjang_id = $request->jenjang_id;
        $userAsesor->timeline_id = $timeline->id;
        $userAsesor->jabatan = "Ketua Asesor";
        $userAsesor->save();




        return redirect()->back()->with('success', 'User Asesor Berhasil Ditugaskan');
    }

    public function json(Request $request)
    {
        $data = UserProdi::with(['pengajuan_dokumen' => function ($r) {
            $r->where('status', '1');
        }, 'program_studi', 'jenjang', 'tahun'])
            ->orderBy('id', 'ASC')->whereNotNull('tahun_id')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('prodi', function ($row) {
                return $row->jenjang->jenjang . ' ' . $row->program_studi->nama;
            })
            ->addColumn('tahun', function ($row) {
                return $row->tahun->tahun;
            })
            ->addColumn('mulai', function ($row) {
                return $row->tahun->mulai_akreditasi;
            })
            ->addColumn('akhir', function ($row) {
                if ($row->tahun->akhir_akreditasi == null) {
                    return '-';
                } else {
                    return $row->tahun->akhir_akreditasi;
                }
            })
            ->addColumn('status', function ($row) {
                $progress = 0;

                // Cek pengajuan dokumen
                $pengajuanDokumen = $row->pengajuan_dokumen->first();
                if ($pengajuanDokumen && $pengajuanDokumen->tanggal_selesai) {
                    $progress += 20; // Pengajuan dokumen selesai
                }

                // Cek asesmen kecukupan
                $timeline = $row->program_studi->timelines()->where('kegiatan', 'Asesmen Kecukupan')->first();
                if ($timeline) {
                    if ($timeline->status == 1) {
                        $progress += 20; // Asesmen kecukupan sudah selesai
                    }
                    if ($timeline->selesai == 1) {
                        $progress += 20; // Nilai asesmen kecukupan selesai
                    }
                }

                // Cek asesmen lapangan
                $timelineLapangan = $row->program_studi->timelines()->where('kegiatan', 'Asesmen Lapangan')->first();
                if ($timelineLapangan) {
                    if ($timelineLapangan->status == 1) {
                        $progress += 20; // Asesmen lapangan sudah selesai
                    }
                    if ($timelineLapangan->selesai == 1) {
                        $progress = 100; // Nilai asesmen lapangan selesai
                    }
                }

                $progress = min($progress, 100); // Pastikan progres tidak lebih dari 100%

                $status = '<div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $progress . '%;">
                        ' . $progress . '%
                    </div>
                    </div>';

                return $status;
            })

            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a class="btn btn-secondary btn-sm" href="' . route('upps.dokumenajuan.prodi', ['id_prodi' => $row->program_studi_id]) . '"><i class="fas fa-eye"></i></a>
                <a href="javascript:void(0)" data-route="' . route('akreditasi.destroy', $row->id) . '"
                    id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['prodi', 'tahun', 'mulai', 'akhir', 'action', 'status'])
            ->make(true);
    }
}
