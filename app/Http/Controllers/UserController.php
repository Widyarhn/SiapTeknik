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
use App\Models\UserAsesor;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            "roles" => Role::all()
        ];
        return view('UPPS.user.index', $data);
    }


    public function json(Request $request)
    {
        $data = User::with(['role'])->orderBy('nama', 'ASC')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('role', function($row){
                return $row->role->role;
            })
            ->addColumn('action', function ($row) {
                return '<div class="buttons">
                <a href="#" data-toggle="modal" data-target="#modalEdit" data-url="'.route('user.show', $row->id).'" id="edit" class="btn btn-icon icon-left btn-warning btn-edit"><i class="far fa-edit"></i></a>

                <a href="javascript:void(0)" data-route="'.route('user.destroy', $row->id).'"
                id="delete" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>
            </div>';
        })
            ->make(true);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'min:5', 'max:255'],
            'email' => 'required|email|unique:users',
            'password' => ['required', 'min:6'],
            'role_id' => 'required'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        DB::transaction(function () use($validatedData){
            User::create($validatedData);
        });

        return redirect()->back()->with('success', 'Data User Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            "roles" => Role::all()
        ];
        $user = User::find($id);

        return view('UPPS.user.edit',$data, compact('user'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'min:5', 'max:255'],
            'role_id' => 'required'
        ]);

        $user = User::find($id);
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = DB::raw('password');
        $user->save();

        return redirect()->back()->with('success', 'Data User Berhasil Disimpan');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }

}
