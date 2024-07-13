<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studis';
    protected $fillable = ['nama', 'jenjang_id'];
    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }
    public function data_dukung()
    {
        return $this->hasMany('App\Models\DataDukung');
    }



    public function matriks_penilaian()
    {
        return $this->hasMany('App\Models\MatriksPenilaian');
    }

    public function aspek_penilaian()
    {
        return $this->hasMany('App\Models\AspekPenilaian');
    }

    public function lkps()
    {
        return $this->hasMany('App\Models\Lkps');
    }

    public function led()
    {
        return $this->hasMany('App\Models\Led');
    }

    public function user_prodi()
    {
        return $this->hasMany('App\Models\UserProdi');
    }

    public function user_asesor()
    {
        return $this->hasMany('App\Models\UserAsesor');
    }

    public function sertifikat()
    {
        return $this->hasMany('App\Models\Sertifikat');
    }

    public function ba_asesmen_lapangan()
    {
        return $this->hasMany('App\Models\BaAsesmenLapangan');
    }

    public function timeline()
    {
        return $this->hasMany(Timeline::class);
    }

    public function dokumen_ajuan()
    {
        return $this->hasMany(DokumenAjuan::class);
    }
}
