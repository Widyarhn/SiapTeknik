<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenAjuan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_ajuans';

    public function led()
    {
        return $this->belongsTo(Led::class, 'step_id');
    }
    public function lkps()
    {
        return $this->belongsTo(Lkps::class, 'step_id');
    }
    public function surat_pengantar()
    {
        return $this->belongsTo(SuratPengantar::class, 'step_id');
    }
    public function data_dukung()
    {
        return $this->belongsTo(DataDukung::class, 'step_id');
    }
    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function timeline()
    {
        return $this->belongsTo(Timeline::class);
    }
}
