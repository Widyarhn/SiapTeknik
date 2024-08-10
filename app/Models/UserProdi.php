<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProdi extends Model
{
    use HasFactory;

    protected $table = 'user_prodies';
    protected $guarded = [];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun_id');
    }

    public function pengajuan_dokumen()
    {
        return $this->belongsTo(PengajuanDokumen::class, 'id');
    }

    public function lkps()
    {
        return $this->hasOne("App\Models\Lkps", "program_studi_id", "program_studi_id");
    }

    public function led()
    {
        return $this->hasOne("App\Models\Led", "program_studi_id", "program_studi_id");
    }
    public function surat_pengantar()
    {
        return $this->hasOne("App\Models\SuratPengantar", "program_studi_id", "program_studi_id");
    }
    public function data_dukung()
    {
        return $this->hasMany("App\Models\DataDukung", "program_studi_id", "program_studi_id");
    }
}
