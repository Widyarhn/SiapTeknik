<?php

namespace App\Models;

use App\Models\MatriksPenilaian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriterias';

    protected $fillable = [
        'butir',
        'kriteria',
    ];
    
    public function matriks_penilaian()
    {
        return $this->hasMany(MatriksPenilaian::class);
    }

    public function sub_kriteria()
    {
        return $this->hasMany(SubKriteria::class);
    }

    public function aspek_penilaian()
    {
        return $this->hasMany(AspekPenilaian::class);
    }

    public function data_dukung()
    {
        return $this->hasMany(DataDukung::class);
    }

    public function list_lkps()
    {
        return $this->hasMany(ListLkps::class);
    }

    use HasFactory;
}
