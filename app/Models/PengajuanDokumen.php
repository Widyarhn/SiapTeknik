<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDokumen extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_dokumens';

    public function led()
    {
        return $this->belongsTo(Led::class);
    }
    public function lkps()
    {
        return $this->belongsTo(Lkps::class);
    }
    public function surat_pengantar()
    {
        return $this->belongsTo(SuratPengantar::class);
    }
    // public function data_dukung()
    // {
    //     return $this->belongsTo(DataDukung::class, 'step_id');
    // }
    public function user_prodi()
    {
        return $this->belongsTo(UserProdi::class);
    }
    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

}
