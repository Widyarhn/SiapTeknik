<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;
    protected $table = 'tahuns';
    protected $fillable = ['id', 'tahun', 'is_active', 'mulai_akreditasi', 'akhir_akreditasi'];

    public function user_prodi()
    {
        return $this->hasMany('App\Models\UserProdi');
    }

    public function user_asesor()
    {
        return $this->hasMany('App\Models\UserAsesor');
    }

    public function lkps()
    {
        return $this->hasMany('App\Models\Lkps');
    }

    public function surat_pengantar()
    {
        return $this->hasMany('App\Models\SuratPengantar');
    }

    public function led()
    {
        return $this->hasMany('App\Models\Led');
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
}
