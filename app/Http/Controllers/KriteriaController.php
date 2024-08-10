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
        // $listLkps = ListLkps::with('kriteria')->get();
        return view('UPPS.matriks-penilaian.kriteria.index');
    }

    public function json(Request $request)
    {
        $data = Kriteria::orderBy('id', 'ASC')->get();

        // $data = $data->map(function ($kriteria) {
        //     $listLkpsNames = $kriteria->list_lkps->pluck('nama')->toArray();
        //     $kriteria->listLkpsNames = !empty($listLkpsNames) ? implode('<br>', $listLkpsNames) : '-';
        //     return $kriteria;
        // });

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="' . route('kriteria.show', $row->id) . '" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>
                <a href="javascript:void(0)" data-route="' . route('kriteria.destroy', $row->id) . '" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
                </div>';
            })
            // ->rawColumns(['listLkpsNames', 'action'])
            ->rawColumns([ 'action'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'butir' => 'required|string|max:255',
            'kriteria' => 'required|string|max:255',
            'lkps' => 'nullable|array',
            'lkps.*.nama_tabel_lkps' => 'sometimes|nullable|min:6',
        ]);

        DB::transaction(function () use ($validatedData) {
            $kriteria = Kriteria::create([
                'butir' => $validatedData['butir'],
                'kriteria' => $validatedData['kriteria'],
            ]);
            // if (!empty($validatedData['lkps'])) {
            //     foreach ($validatedData['lkps'] as $lkpsItem) {
            //         if (!empty($lkpsItem['nama_tabel_lkps'])) { // Hanya simpan jika 'nama_tabel_lkps' tidak null
            //             ListLkps::create([
            //                 'kriteria_id' => $kriteria->id,
            //                 'nama' => $lkpsItem['nama_tabel_lkps'],
            //             ]);
            //         }
            //     }
            // }
        });

        return redirect()->back()->with('success', 'Data Kriteria Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $kriteria = Kriteria::find($id);
        // $listLkps = ListLkps::where('kriteria_id', $id)->get();

        return response()->json([
            'kriteria' => $kriteria,
            // 'listLkps' => $listLkps,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'butir' => 'nullable|string|max:255',
            'kriteria' => 'nullable|string|max:255',
            'lkps' => 'nullable|array',
            'lkps.*.id' => 'sometimes|nullable|exists:list_lkps,id',
            'lkps.*.nama_tabel_lkps' => 'sometimes|nullable|min:6',
        ]);

        // Temukan Kriteria berdasarkan id
        $kriteria = Kriteria::find($id);

        // Update hanya kolom yang ada di $validatedData
        if (isset($validatedData['butir'])) {
            $kriteria->butir = $validatedData['butir'];
        }
        if (isset($validatedData['kriteria'])) {
            $kriteria->kriteria = $validatedData['kriteria'];
        }
        $kriteria->save();

        // $deletedLkpsIds = $request->input('deleted_lkps', []);

        // // Delete the ListLkps that are marked for deletion
        // if (!empty($deletedLkpsIds)) {
        //     ListLkps::whereIn('id', $deletedLkpsIds)->delete();
        // }
        
        // // Mengupdate atau menambah ListLkps
        // if (isset($validatedData['lkps'])) {
        //     // Mengupdate ListLkps yang ada
        //     foreach ($validatedData['lkps'] as $lkpsItem) {
        //         if (isset($lkpsItem['id'])) {
        //             $listLkps = ListLkps::find($lkpsItem['id']);
        //             if ($listLkps) {
        //                 $listLkps->nama = $lkpsItem['nama_tabel_lkps'] ?? $listLkps->nama;
        //                 $listLkps->save();
        //             }
        //         } else if (!empty($lkpsItem['nama_tabel_lkps'])) {
        //             // Menambah ListLkps baru jika id tidak ada
        //             ListLkps::create([
        //                 'kriteria_id' => $kriteria->id,
        //                 'nama' => $lkpsItem['nama_tabel_lkps'],
        //             ]);
        //         }
        //     }
        // }

        return redirect()->back()->with('success', 'Data Kriteria Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->delete();
    }
}
