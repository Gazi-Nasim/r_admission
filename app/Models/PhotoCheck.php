<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoCheck extends Model
{

    public static $rules   = array();
    protected     $table   = 'photo_checks';
    protected     $guarded = array('id');

    public function scopeStatus($query, $param)
    {
        return $query->where('status', '=', $param);
    }

}
