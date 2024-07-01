<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    
    protected $fillable = ['aset_id','rentang', 'ganti', 'pinjam_id', 'ket_main', 'mainStatus', 'mainPhoto'];

    public function asets()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pinjams()
    {
        return $this->hasMany(Pinjam::class, 'pinjam_id');
    }

    protected $casts = [
        'mainPhoto' => 'string',
    ];

}
