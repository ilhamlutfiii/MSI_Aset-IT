<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $primaryKey = 'unit_id';
    
    protected $fillable = [
        'unit_id', 'unit_nama',
    ];

    public function fungsis()
    {
        return $this->hasMany('App\Models\Fungsi');
    }
}
