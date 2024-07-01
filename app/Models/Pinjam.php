<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Pinjam extends Model
{
    protected $fillable = ['user_id', 'aset_id', 'main_id', 'pinjam_number', 'sub_total', 'quantity', 'status', 'photoStatus'];

    public function cart_info()
    {
        return $this->hasMany('App\Models\Cart', 'pinjam_id', 'id');
    }
    public static function getAllpinjam($id)
    {
        return pinjam::with('cart_info')->find($id);
    }
    public static function countActivePinjam()
    {
        $data = pinjam::count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public static function countActiveRepair()
    {
        $data = pinjam::where('status', 'Telah Diambil')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function asets()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'id');
    }
    public function asetReviews()
    {
        return $this->hasMany(AsetReview::class, 'pinjam_id');
    }
    public function getReview()
    {
        return $this->hasMany('App\Models\AsetReview', 'aset_id', 'id')->with('user_info')->where('status', 'active')->orderBy('id', 'DESC');
    }
    protected $casts = [
        'photoStatus' => 'string',
    ];
    public function maintenances()
    {
        return $this->belongsTo(Maintenance::class, 'main_id'. 'id');
    }
}
