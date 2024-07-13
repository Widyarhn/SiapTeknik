<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProdi extends Model
{
    use HasFactory;

    protected $table = 'user_prodis';
    protected $fillable = [
        'user_id',
        'program_studi_id',
        'tahun_id',
        'jenjang_id',
        'timeline_id',
    ];

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
        return $this->belongsTo(Tahun::class, 'tahun_id'); // Ganti 'Tahun' dengan nama model yang sesuai
    }

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id'); // Ganti 'Tahun' dengan nama model yang sesuai
    }

    public function lkps()
    {
        return $this->belongsTo("App\Models\Lkps", "program_studi_id", "program_studi_id");
    }

    public function led()
    {
        return $this->belongsTo("App\Models\Led", "program_studi_id", "program_studi_id");
    }
}
