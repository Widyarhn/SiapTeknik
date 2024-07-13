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

    protected $fillable = [
        'file',
        'nama_file',
        'program_studi_id',
        'matriks_penilaian_id'
    ];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function matriks_penilaian()
    {
        return $this->belongsTo(MatriksPenilaian::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    } 
    
    public function dokumen_ajuan()
    {
        return $this->hasMany('App\Models\DokumenAjuan');
    }
}
