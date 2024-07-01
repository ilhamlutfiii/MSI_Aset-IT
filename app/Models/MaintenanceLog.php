<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    protected $guarded = [];

    public function asets()
    {
        return $this->belongsTo('App\Models\Aset', 'aset_id');
    }

    public function maintenances()
    {
        return $this->belongsTo('App\Models\Maintenance', 'maintenance_id');
    }
    public function logs()
    {
        return $this->hasMany('App\Models\MaintenanceLog');
    }
}
