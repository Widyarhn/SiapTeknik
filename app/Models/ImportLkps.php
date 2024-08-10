<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportLkps extends Model
{
    use HasFactory;
    protected $guarded  = [];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
