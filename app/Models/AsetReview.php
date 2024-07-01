<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetReview extends Model
{
    protected $fillable = ['user_id', 'aset_id', 'pinjam_id', 'rate', 'review', 'status', 'photoStatus'];

    public function user_info()
    {
        return $this->belongsTo('App\User', 'user_id'); // Menggunakan belongsTo untuk relasi satu-satu dan menentukan kolom kunci eksternal
    }

    public static function getAllReview()
    {
        return AsetReview::with('user_info', 'pinjams')->paginate(10);
    }

    public static function getAllUserReview()
    {
        return AsetReview::where('user_id', auth()->user()->id)->with('user_info', 'pinjams')->paginate(10);
    }

    public static function countActiveReview()
    {
        $data = AsetReview::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
    public function asets()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }

    public function pinjams()
    {
        return $this->belongsTo(Pinjam::class, 'pinjam_id');
    }
}
