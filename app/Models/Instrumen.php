<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrumen extends Model
{
    use HasFactory;
    protected $table = 'instrumens';
    protected $fillable = [
        'file',
        'judul',
        'jenjang_id'
    ];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }
}
