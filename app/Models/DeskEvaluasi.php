<?php

namespace App\Models;
use App\Models\MatriksPenilaian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeskEvaluasi extends Model
{
    use HasFactory;

    protected $table = 'desk_evaluasis';
    protected $fillable = [
        'matriks_penilaian_id',
        'tahun_id',
        'program_studi-id',
        'user_asesor_id',
        'timeline_id',
        'nilai', 'upps_nilai', 'deskripsi',

    ];
    public function matriks_penilaian()
    {
        return $this->belongsTo(MatriksPenilaian::class);
    }
    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }
    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
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

