<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LampiranRenstra extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    } 
    
    public function pengajuan_dokumen()
    {
        return $this->hasOne('App\Models\PengajuanDokumen');
    }
}
