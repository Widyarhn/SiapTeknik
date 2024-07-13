<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Led extends Model
{
    use HasFactory;

    protected $table = 'leds';
    // protected $fillable = ['tahun_id', 'file', 'id'];
    protected $guarded = [];

    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    public function dokumen_ajuan()
    {
        return $this->hasMany('App\Models\DokumenAjuan');
    }
}
