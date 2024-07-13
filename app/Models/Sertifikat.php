<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikats';
    protected $fillable = ['tahun_id', 'file', 'program_studi_id', 'jenjang_id'];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    } 
}
