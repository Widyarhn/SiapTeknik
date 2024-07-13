<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksPenilaian extends Model
{
    use HasFactory;

    protected $table = 'matriks_penilaians';

    protected $guarded = [];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
    
    public function sub_kriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }

    public function aspek_penilaian()
    {
        return $this->hasMany(AspekPenilaian::class);
    }

    public function data_dukung()
    {
        return $this->hasOne(DataDukung::class);
    }

}
