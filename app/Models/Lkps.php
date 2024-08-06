<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lkps extends Model
{
    use HasFactory;
    protected $table = 'lkpss';
    
    protected $guarded = [];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

}
