<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileChange extends Model
{
    public function scopeStatus($query, $param)
    {
        return $query->where('status', '=', $param);
    }


    public function applicant()
    {
        return $this->belongsTo(Hsc::class, 'applicant_id', 'id');
    }


    public function user_checked(){
        return $this->belongsTo(User::class, 'checked_by', 'id');
    }
}
