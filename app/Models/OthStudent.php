<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OthStudent extends Model
{


    protected $table = 'hsc_oth';
    // public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $guarded = array('id');

    public static $rules = array();


    // public function scopeUnprocessed($query)
    // {
    // 	return $query->where('status', '=', null);
    // }

    public function scopeStatus($query, $param)
    {
        return $query->where('status', '=', $param);
    }


}
