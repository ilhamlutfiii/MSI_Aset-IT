<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fungsi extends Model
{
    protected $primaryKey = 'fungsi_id';
    
    protected $fillable = [
        'fungsi_id','unit_id', 'fungsi_name',
    ];

    public function units()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
