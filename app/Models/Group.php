<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $table = 'groups';

    protected $guarded = array('id');

    public function scopeExam($query, $param)
    {
        return $query->where('exam', '=', $param);
    }
}
