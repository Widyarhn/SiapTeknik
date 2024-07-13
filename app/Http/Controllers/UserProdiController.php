<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Tahun;
use App\Models\Jenjang;
use App\Models\UserProdi;
use App\Models\ProgramStudi;

class UserProdiController extends Controller
{
    public function prodi(Request $request, $id)
    {
        $jenjang = Jenjang::findOrFail($id);
        $user = User::where('role_id', '2')->get();
        $tahun = Tahun::where('is_active', 0)->get();
        $program_studi = ProgramStudi::where('jenjang_id', $id)->get();
        return view('UPPS.user.user-prodi', ['user' => $user, 'program_studi' => $program_studi, 'jenjang'=>$jenjang, 'tahun'=> $tahun]);
    }

    public function jsonProdi(Request $request, $id)
    {
        $data = UserProdi::with(['user','program_studi', 'jenjang'])->where('jenjang_id', $id)->orderBy('id', 'ASC')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama', function($row){
                return $row->user->nama;
            })
            ->addColumn('email', function($row){
                return $row->user->email;
            })
            ->addColumn('prodi', function($row){
                return $row->jenjang->jenjang.' '.$row->program_studi->nama;
            })
            ->addColumn('tahun', function($row){
                return $row->tahun->tahun;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="'.route('user-prodi.show', $row->id).'" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>

                <a href="javascript:void(0)" data-route="'.route('user-prodi.destroy', $row->id).'"
                id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
            </div>';
        })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'program_studi_id' => 'required'
        ],
        [
            'user_id.required' => 'Nama User Harus Diisi',
            'program_studi_id.required' => 'Program Studi Harus Diisi'
        ]
    );

        $user_prodi = new UserProdi;
        $user_prodi->user_id = $request->user_id;
        $user_prodi->jenjang_id = $request->jenjang_id;
        $user_prodi->program_studi_id = $request->program_studi_id;
        $user_prodi->tahun_id = $request->tahun_id;
        $user_prodi->save();
        return redirect()->back()->with('success', 'Data User Prodi Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $user_prodi = UserProdi::find($id);
        $user = User::where('role_id', '2')->get();
        $tahun = Tahun::where('is_active', 0)->get();
        $program_studi = ProgramStudi::get();
        return view('UPPS.user.edit-userprodi',compact('user_prodi', 'user', 'tahun', 'program_studi'));
    }

    public function update(Request $request, $id)
    {
        $user_prodi = UserProdi::find($id);
        $user_prodi->user_id = $request->user_id;
        $user_prodi->tahun_id = $request->tahun_id;
        $user_prodi->save();

        return redirect()->back()->with('success', 'Data User Berhasil Disimpan');
    }

    public function destroy($id)
    {
        $user = UserProdi::find($id);
        $user->delete();
    }
}
