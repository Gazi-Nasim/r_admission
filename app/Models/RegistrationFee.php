<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationFee extends Model
{
    protected $guarded = ['id'];
    protected $table   = 'registration_fees';

    public function scopeUnit($query, $param)
    {
        return $query->whereIn('unit_name', $param);
    }
}
