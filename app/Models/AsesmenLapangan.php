<?php

namespace App\Models;

use App\Models\MatriksPenilaian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesmenLapangan extends Model
{
    use HasFactory;

    protected $table ='asesmen_lapangans';

    
    protected $guarded = [];

    public function matriks_penilaian()
    {
        return $this->belongsTo(MatriksPenilaian::class);
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
