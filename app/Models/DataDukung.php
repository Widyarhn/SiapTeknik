<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DataDukung extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_dukungs'; 

    protected $guarded = [];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }

    public function matriks_penilaian()
    {
        return $this->belongsTo(MatriksPenilaian::class);
    }
    public function sub_kriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }

    public function timeline()
    {
        return $this->belongsTo(Timeline::class);
    } 
}
