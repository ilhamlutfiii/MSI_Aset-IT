<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=['user_id','aset_id','pinjam_id','quantity','status'];

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }
    public function pinjam(){
        return $this->belongsTo(Pinjam::class,'pinjam_id');
    }
}
