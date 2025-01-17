<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumus extends Model
{
    use HasFactory;
    protected $table = 'rumuses';

    protected $guarded = [];

    public function sub_kriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id');
    }
    public function indikator()
    {
        return $this->hasOne(Indikator::class);
    }
}
