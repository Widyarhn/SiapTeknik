<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaAsesmenLapangan extends Model
{
    use HasFactory;
    protected $table = 'ba_asesmen_lapangans';

    protected $fillable = ['tahun_id', 'file', 'program_studi_id', 'status'];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    } 
}
