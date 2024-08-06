<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $table = 'timelines';
    protected $guarded = [];


    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function user_asesor()
    {
        return $this->hasMany(UserAsesor::class);
    }
    
}
