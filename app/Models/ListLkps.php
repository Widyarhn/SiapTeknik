<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListLkps extends Model
{
    use HasFactory;

    protected $table = 'list_lkpss';
    protected $fillable = ['kriteria_id', 'd3', 'd4', 'nama'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }


}
