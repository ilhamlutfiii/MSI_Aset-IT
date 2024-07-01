<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $primaryKey = 'jabatan_id';
    
    protected $fillable = [
        'jabatan_id', 'jabatan_name',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
