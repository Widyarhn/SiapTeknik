<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Tahun;
use App\Models\Jenjang;
use App\Models\UserAsesor;
use App\Models\ProgramStudi;

class UserAsesorController extends Controller
{
    
    public function asesor(Request $request, $id)
    {
        $jenjang = Jenjang::findOrFail($id);
        $user = User::where('role_id', '1')->get();
        $tahun = Tahun::where('is_active', 0)->get();
        $program_studi = ProgramStudi::where('jenjang_id', $id)->get();
        return view('UPPS.user.user-asesor', ['user' => $user, 'program_studi' => $program_studi, 'jenjang'=>$jenjang, 'tahun' => $tahun]);
    }


    public function jsonAsesor(Request $request, $id)
    {
        $data = UserAsesor::with(['user','program_studi', 'jenjang'])->where('jenjang_id', $id)->orderBy('id', 'ASC')
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
                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="'.route('user-asesor.show', $row->id).'" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>

                <a href="javascript:void(0)" data-route="'.route('user-asesor.destroy', $row->id).'"
                id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
            </div>';
        })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'tahun_ids' => 'required|exists:tahuns,id',
            'program_studi_ids' => 'required|exists:program_studies,id',
            'jenjang_ids' => 'required|exists:jenjangs,id',
            'timeline_ids' => 'required|exists:timelines,id',
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

        // Buat entry user_prodi
        $userAsesor = new UserAsesor();
        $userAsesor->user_id = $user->id;
        $userAsesor->tahun_id = $request->tahun_ids;
        $userAsesor->program_studi_id = $request->program_studi_ids;
        $userAsesor->jenjang_id = $request->jenjang_ids;
        $userAsesor->timeline_id = $request->timeline_ids;
        $userAsesor->jabatan = 'Anggota';
        $userAsesor->save();

        return redirect()->back()->with('success', 'User Asesor Berhasil Ditugaskan');
    }

    public function edit($id)
    {
        $user_asesor = UserAsesor::find($id);
        $user = User::where('role_id', '1')->get();
        $tahun = Tahun::where('is_active', 0)->get();
        $program_studi = ProgramStudi::get();
        return view('UPPS.user.edit-Userasesor',compact('user_asesor', 'user', 'tahun', 'program_studi'));
    }

    public function update(Request $request, $id)
    {
        $user_asesor = UserAsesor::find($id);
        $user_asesor->user_id = $request->user_id;
        $user_asesor->jabatan = $request->jabatan;
        $user_asesor->tahun_id = $request->tahun_id;
        $user_asesor->save();

        return redirect()->back()->with('success', 'Data User Asesor Berhasil Diubah');
    }

    public function destroy($id)
    {
        $user = UserAsesor::find($id);
        $user->delete();
    }
}
