<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnotasiLabel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function matriks_penilaian()
    {
        return $this->belongsTo(MatriksPenilaian::class);
    }
}
