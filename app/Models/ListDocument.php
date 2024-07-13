<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDocument extends Model
{
    use HasFactory;
    protected $table = 'list_documents';
    protected $fillable = [
        'program_studi_id',
        'tahun_id',
        'list_lkps_id',
        'nama_dokumen',
    ];

    public function list_lkps()
    {
        return $this->hasMany(ListLkps::class);
    }

    public function generate_data()
    {
        return $this->hasMany(GenerateData::class);
    }

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    } 

}
