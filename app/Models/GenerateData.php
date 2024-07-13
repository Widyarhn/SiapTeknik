<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateData extends Model
{
    use HasFactory;
    protected $table = 'generate_datas';
    protected  $guarded  =  [];

    
    public function list_lkps()
    {
        return $this->hasMany(ListLkps::class);
    }
    public function list_document()
    {
        return $this->hasMany(ListDocument::class);
    }
}
