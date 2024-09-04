<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
    public function user_asesor()
    {
        return $this->belongsTo(UserAsesor::class);
    }
    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
