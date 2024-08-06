<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    use HasFactory;
    protected $table = 'surat_pengantars';
    protected $guarded = [];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    } 
    
    public function pengajua_dokumen()
    {
        return $this->hasOne('App\Models\PengajuanDokumen');
    }
    
}
