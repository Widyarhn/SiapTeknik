<?php

namespace App\Models;

use App\Models\MatriksPenilaian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesmenLapangan extends Model
{
    use HasFactory;

    protected $table ='asesmen_lapangans';

    protected $fillable = [
        'aspek_penilaian_id',
        'user_asesor_id',
        'timeline_id',
        'nilai',
        'upps_nilai',
        'deskripsi',
    ];

    public function aspek_penilaian()
    {
        return $this->belongsTo(AspekPenilaian::class);
    }

    public function user_asesor()
    {
        return $this->belongsTo(UserAsesor::class);
    }

    public function timeline()
    {
        return $this->belongsTo(Timeline::class);
    }

}
