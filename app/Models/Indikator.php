<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;
    protected $table = 'indikators';
    protected $fillable = [
        'deskriptor', 'sangat_baik', 'baik', 'cukup', 'kurang', 'sangat_kurang', 'sub_kriteria_id', 'bobot'
    ];
    
    public function sub_kriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }
}
