<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

    protected $guarded = ['id'];

    public function scopeName($query, $param)
    {
        return $query->whereIn('unit_name', $param);
    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }

    public function departments()
    {
        return $this->hasManyThrough(Department::class, Faculty::class);
    }


}
