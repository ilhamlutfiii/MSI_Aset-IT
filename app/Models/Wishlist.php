<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable=['user_id','aset_id','cart_id','quantity'];

    public function aset(){
        return $this->belongsTo(Aset::class,'aset_id');
    }
}
