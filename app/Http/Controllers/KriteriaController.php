<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\ListLkps;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $listLkps = ListLkps::with('kriteria')->get();
        return view('UPPS.matriks-penilaian.kriteria.index', $listLkps);
    }

    public function json(Request $request)
    {
        $data = Kriteria::with('list_lkps')->orderBy('id', 'ASC')->get();

        $data = $data->map(function ($kriteria) {
            $listLkpsNames = $kriteria->list_lkps->pluck('nama')->toArray();
            $kriteria->listLkpsNames = !empty($listLkpsNames) ? implode('<br>', $listLkpsNames) : '-';
            return $kriteria;
        });

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="' . route('kriteria.show', $row->id) . '" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>
                <a href="javascript:void(0)" data-route="' . route('kriteria.destroy', $row->id) . '" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
                </div>';
            })
            ->rawColumns(['listLkpsNames', 'action'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'butir' => 'required|string|max:255',
            'kriteria' => 'required|string|max:255',
            'lkps' => 'nullable|array',
            'lkps.*.nama_tabel_lkps' => 'sometimes|nullable|string|min:6',
        ]);

        DB::transaction(function () use ($validatedData) {
            $kriteria = Kriteria::create([
                'butir' => $validatedData['butir'],
                'kriteria' => $validatedData['kriteria'],
            ]);

            if (!empty($validatedData['lkps'])) {
                $lkpsData = [];
                foreach ($validatedData['lkps'] as $lkpsItem) {
                    if (!empty($lkpsItem['nama_tabel_lkps'])) {
                        $lkpsData[] = $lkpsItem['nama_tabel_lkps'];
                    }
                }
                // Simpan lkps sebagai bagian dari kriteria
                $kriteria->lkps = $lkpsData;
                $kriteria->save();
            }
        });

        return redirect()->back()->with('success', 'Data Kriteria Berhasil Ditambahkan');
    }


    public function edit(Request $request, $id)
    {
        $kriteria = Kriteria::find($id);

        return view('UPPS.matriks-penilaian.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->kriteria = $request->kriteria;
        $kriteria->butir = $request->butir;
        $kriteria->save();
        return redirect()->back()->with('success', 'Data Kriteria Berhasil Disimpan');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->delete();
    }
}
