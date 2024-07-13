<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\UserProdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadesResponse;

class AjuanUppsController extends Controller
{
    public function prodi(Request $request, $id_prodi)
    {
        $program_studi = ProgramStudi::findOrFail($id_prodi);
        
        $user_prodi = UserProdi::where("program_studi_id", $id_prodi)
            ->get();
    
        return view ('UPPS.dokumen.ajuan', ['user_prodi'=> $user_prodi, 'program_studi' => $program_studi]);
    }

}
