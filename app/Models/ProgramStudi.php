<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studies';

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

    public function berita_acara()
    {
        return $this->hasMany('App\Models\BeritaAcara');
    }

    public function timeline()
    {
        return $this->hasMany('App\Models\Timeline');
    }

    public function tahun()
    {
        return $this->hasOne(Tahun::class);
    }

    public function pengajuan_dokumen()
    {
        return $this->hasMany(PengajuanDokumen::class);
    }
}
