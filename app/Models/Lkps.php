<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lkps extends Model
{
    protected $table = 'lkpss';
    protected $fillable = ['tahun_id', 'file', 'id'];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function dokumen_ajuan()
    {
        return $this->hasMany('App\Models\DokumenAjuan');
    }
    
    use HasFactory;


}
