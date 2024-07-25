<?php

namespace App\Http\Controllers;


use App\Models\MatriksPenilaian;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Indikator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MatriksPenilaianController extends Controller
{

    public function index()
    {
        //
    }
    public function jenjang(Request $request, $id)
    {
        $jenjang = Jenjang::findOrFail($id);
        $data = [
            "kriteria" => Kriteria::all(),
            "matriks_penilaian" => MatriksPenilaian::all()
        ];
        return view('UPPS.matriks-penilaian.index', $data, ['jenjang' => $jenjang]);
    }

    public function json(Request $request, $id_jenjang)
    {
        $data = MatriksPenilaian::where('jenjang_id', $id_jenjang)->with(['jenjang', 'kriteria', 'sub_kriteria', 'indikator'])->orderBy('kriteria_id', 'ASC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('informasi', function ($row) {
                $informasi = '<table>
                    <tr>
                        <th>Butir</th>
                        <td>
                            <h6>' . $row->kriteria->butir . '</h6>
                        </td>
                    </tr>
                    <tr>
                        <th>Kriteria</th>
                        <td>
                            <h6>' . $row->kriteria->kriteria . '</h6>
                        </td>
                    </tr>
                    <tr>
                        <th>Bobot</th>
                        <td>
                            ' . $row->indikator->bobot . '
                        </td>
                    </tr>
                </table>';
                return $informasi;
            })
            ->addColumn('indikator', function ($row) {
                $indikator = '<table>
                    <tr>
                        <td>
                            ' . $row->indikator->deskriptor . '
                        </td>
                    </tr>
                </table>';
                return $indikator;
            })
            ->addColumn('nilai', function ($row) {
                $subKriteria = optional($row->sub_kriteria)->sub_kriteria;
                $nilai = '<table>
                    <tr>
                        <th><h6>' . $row->kriteria->butir . '</h6></th>
                        <th>' . ($subKriteria ? $subKriteria : '') . '</th>
                    </tr>
                    <tr>
                        <th>4</th>
                        <td>
                            ' . $row->indikator->sangat_baik . '
                        </td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>
                            ' . $row->indikator->baik . ' 
                        </td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>
                            ' . $row->indikator->cukup . ' 
                        </td>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>
                            ' . $row->indikator->kurang . ' 
                        </td>
                    </tr> 
                    <tr>
                        <th>0</th>
                        <td>
                            ' . $row->indikator->sangat_kurang . ' 
                        </td>
                    </tr>
                </table>';
                return $nilai;
            })
            ->addColumn('action', function ($row) use ($id_jenjang) {
                return '<div class="buttons">
            <a href="' . route('UPPS.matriks-penilaian.edit', ['id' => $row->id, 'id_jenjang' => $id_jenjang]) . '" data-url="" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>
            <a href="javascript:void(0)" data-route="' . route('matriks-penilaian.destroy', $row->id) . '" id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
        </div>';
            })

            ->rawColumns(['informasi', 'indikator', 'nilai', 'action'])
            ->make(true);
    }


    public function create(Request $request, $id)
    {
        $jenjang = Jenjang::findOrFail($id);
        $data = [
            "kriteria" => Kriteria::all(),
            "matriks_penilaian" => MatriksPenilaian::all()
        ];
        return view('UPPS.matriks-penilaian.create', $data, ['jenjang' => $jenjang]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenjang_id' => 'required',
            'kriteria_id' => 'required',
            'sub_kriteria' => 'nullable',
            'indikator' => 'required|array', // Menjadikan 'indikator' sebagai array wajib
            'indikator.*.bobot' => 'sometimes|required|numeric',
            'indikator.*.deskriptor' => 'sometimes|required|min:6',
            'indikator.*.sangat_baik' => 'sometimes|required|min:6',
            'indikator.*.baik' => 'sometimes|required|min:6',
            'indikator.*.cukup' => 'sometimes|required|min:6',
            'indikator.*.kurang' => 'sometimes|required|min:6',
            'indikator.*.sangat_kurang' => 'sometimes|required|min:6',
        ]);

        $subKriteriaId = null;
        if ($request->filled('sub_kriteria')) {
            $subKriteria = SubKriteria::firstOrCreate([
                'kriteria_id' => $request->kriteria_id,
                'sub_kriteria' => $request->sub_kriteria
            ]);
            $subKriteriaId = $subKriteria->id;
        }

        foreach ($request->indikator as $indikatorData) {
            if (isset($indikatorData['deskriptor']) && isset($indikatorData['sangat_baik']) && isset($indikatorData['baik']) && isset($indikatorData['cukup']) && isset($indikatorData['kurang']) && isset($indikatorData['sangat_kurang']) && isset($indikatorData['bobot'])) {
                $indikator = Indikator::create([
                    'deskriptor' => $indikatorData['deskriptor'],
                    'sangat_baik' => $indikatorData['sangat_baik'],
                    'baik' => $indikatorData['baik'],
                    'cukup' => $indikatorData['cukup'],
                    'kurang' => $indikatorData['kurang'],
                    'sangat_kurang' => $indikatorData['sangat_kurang'],
                    'sub_kriteria_id' => $subKriteriaId,
                    'bobot' => $indikatorData['bobot'],
                ]);

                MatriksPenilaian::create([
                    'jenjang_id' => $request->jenjang_id,
                    'kriteria_id' => $request->kriteria_id,
                    'sub_kriteria_id' => $subKriteriaId,
                    'indikator_id' => $indikator->id,
                ]);
            } else {
                // Handle the case where data is missing
                return response()->json(['error' => 'Incomplete data in indikator array'], 422);
            }
        }

        // return response()->json(['success' => 'Data saved successfully'], 200);

        return back()->with('success', 'Data Matriks Penilaian Berhasil Ditambahkan');
    }


    public function edit(Request $request, $id, $id_jenjang)
    {
        $data = [
            "kriteria" => Kriteria::all(),
        ];

        $jenjang = Jenjang::findOrFail($id_jenjang);
        $matriks_penilaian = MatriksPenilaian::where('jenjang_id', $id_jenjang)->find($id);
        return view('UPPS.matriks-penilaian.edit', $data, ['matriks_penilaian' => $matriks_penilaian, 'jenjang' => $jenjang]);
    }

    public function update(Request $request, $id, $id_jenjang)
    {
        // Validasi data
        $validatedData = $request->validate([
            'kriteria_id' => 'required',
            'sub_kriteria' => 'required',
            'deskriptor' => ['required', 'min:6'],
            'sangat_baik' =>  ['required', 'min:6'],
            'baik' =>  ['required', 'min:6'],
            'cukup' =>  ['required', 'min:6'],
            'kurang' =>  ['required', 'min:6'],
            'sangat_kurang' =>  ['required', 'min:6'],
            'bobot' => 'required|numeric',
        ]);

        // Temukan objek MatriksPenilaian
        $matriks_penilaian = MatriksPenilaian::where('jenjang_id', $id_jenjang)->findOrFail($id);
        $matriks_penilaian->jenjang_id = $request->input('jenjang_id', $matriks_penilaian->jenjang_id);
        $matriks_penilaian->kriteria_id = $request->input('kriteria_id', $matriks_penilaian->kriteria_id);
        $matriks_penilaian->save();

        // Temukan dan perbarui SubKriteria
        $sub_kriteria = SubKriteria::where('id', $matriks_penilaian->sub_kriteria_id)->firstOrFail();
        $sub_kriteria->sub_kriteria = $request->input('sub_kriteria', $sub_kriteria->sub_kriteria);
        $sub_kriteria->save();

        // Temukan dan perbarui Indikator
        $indikator = Indikator::where('id', $matriks_penilaian->indikator_id)->firstOrFail();
        $indikator->deskriptor = $request->input('deskriptor', $indikator->deskriptor);
        $indikator->sangat_baik = $request->input('sangat_baik', $indikator->sangat_baik);
        $indikator->baik = $request->input('baik', $indikator->baik);
        $indikator->cukup = $request->input('cukup', $indikator->cukup);
        $indikator->kurang = $request->input('kurang', $indikator->kurang);
        $indikator->sangat_kurang = $request->input('sangat_kurang', $indikator->sangat_kurang);
        $indikator->bobot = $request->input('bobot', $indikator->bobot);
        $indikator->save();

        return back()->with('success', 'Data Matriks Penilaian Berhasil Diperbarui');
    }


    public function destroy($id)
    {
        $matriks_penilaian = MatriksPenilaian::find($id);

        $sub_kriteria = SubKriteria::where('id', $matriks_penilaian->sub_kriteria_id)->firstOrFail();
        $indikator = Indikator::where('id', $matriks_penilaian->indikator_id)->firstOrFail();

        $matriks_penilaian->delete();
        $sub_kriteria->delete();
        $indikator->delete();
    }
}
