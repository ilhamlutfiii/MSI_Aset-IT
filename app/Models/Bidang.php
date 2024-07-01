<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $primaryKey = 'bidang_id';
    
    protected $fillable = [
        'bidang_id', 'bidang_name',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
