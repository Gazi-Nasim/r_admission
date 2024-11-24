<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = [];

    public function scopeExam($query, $param)
    {
        return $query->where('exam', '=', $param);
    }

}
