<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionFee extends Model
{
    protected $guarded = ['id'];
    protected $table   = 'admission_fees';

    public function scopeUnits($query, $param)
    {
        return $query->whereIn('unit_name', $param);
    }

}
