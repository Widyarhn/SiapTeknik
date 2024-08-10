<?php

namespace App\Models;
use App\Models\MatriksPenilaian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesmenKecukupan extends Model
{
    use HasFactory;

    protected $table = 'asesmen_kecukupans';
    protected $guarded=[];
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

