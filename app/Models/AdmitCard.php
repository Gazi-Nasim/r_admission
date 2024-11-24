<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmitCard extends Model
{

    protected $table = 'admit_card';

    protected $guarded = array('id');

    public function scopeUnit($query, $param)
    {
        return $query->where('unit', '=', $param);
    }

    public function scopeRoll($query, $param)
    {
        return $query->where('admission_roll', '=', $param);
    }

    public function scopeTracking($query, $param)
    {
        return $query->where('tracking_no', '=', $param);
    }

}
