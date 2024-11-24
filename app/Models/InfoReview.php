<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoReview extends Model
{

    protected $table = 'info_reviews';

    protected     $guarded = array('id');
    public static $rules   = array();

    public function scopeStatus($query, $param)
    {
        return $query->where('status', '=', $param);
    }


    public function complainType()
    {
        return $this->belongsTo(ComplainType::class);
    }

}
