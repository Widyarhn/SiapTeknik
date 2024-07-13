<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $table = 'jenjangs';
    use HasFactory;

    public function program_studi()
    {
        return $this->hasMany('App\Models\ProgramStudi');
    }

    public function instrumen()
    {
        return $this->hasMany('App\Models\Instrumen');
    }

    public function matriks_penilaian()
    {
        return $this->hasMany('App\Models\MatriksPenilaian');
    }

    public function data_dukung()
    {
        return $this->hasMany('App\Models\DataDukung');
    }

    public function user_prodi()
    {
        return $this->hasMany('App\Models\UserProdi');
    }

    public function user_asesor()
    {
        return $this->hasMany('App\Models\UserAsesor');
    }
}
