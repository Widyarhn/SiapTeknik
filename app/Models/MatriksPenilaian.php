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
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
    
    public function sub_kriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id');
    }

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }

    public function asesmen_kecukupan()
    {
        return $this->hasOne(AsesmenKecukupan::class);
    }

    public function asesmen_lapangan()
    {
        return $this->hasOne(AsesmenLapangan::class);
    }

    public function data_dukung()
    {
        return $this->hasMany(DataDukung::class);
    }
}
