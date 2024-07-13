<?php

namespace App\Http\Controllers;

use App\Models\DataDukung;
use App\Models\Instrumen;
use App\Models\Timeline;
use App\Models\UserProdi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardProdiController extends Controller
{
    public function index(Request $request)
    {
        // $data = [
        //     "user_prodi" => UserProdi::where('user_id', Auth::user()->id)->first(),
        //     "instrumen_d3" => Instrumen::where('jenjang_id', 1)->count(),
        //     "instrumen_d4" => Instrumen::where('jenjang_id', 2)->count(),
        //     "data_dukung" => DataDukung:: where('jenjang_id', 1)->count()
        // ];

        // return view('prodi.layout.main', $data);

        $user_prodi = UserProdi::where('user_id', Auth::user()->id)->first();
        $timeline = Timeline::where('program_studi_id', $user_prodi->program_studi_id)->get();
        $instrumen_d3 = Instrumen::where('jenjang_id', 1)->count();
        $instrumen_d4 = Instrumen::where('jenjang_id', 2)->count();
        $data_dukung = DataDukung:: where('jenjang_id', 1)->count();
        if ($user_prodi)
        {
            return view('prodi.layout.main',
            ['data_dukung' => $data_dukung, 'user_prodi'=>$user_prodi, 'timeline' => $timeline]);
        }else {
            return view('prodi.layout.prodi', ['instrumen_d3' => $instrumen_d3, 'instrumen_d4' => $instrumen_d4]);
        }
    }
}