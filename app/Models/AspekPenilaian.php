<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AspekPenilaian extends Model
{
    use HasFactory;
    protected $table ='aspek_penilaians';

    protected $fillable = [
        'matriks_penilaian_id',
        'tahun_id',
        'program_studi-id',
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
}
