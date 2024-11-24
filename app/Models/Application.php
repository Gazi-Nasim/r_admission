<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    protected $table = 'applications';

    protected $guarded = array('id');

    // public function scopeUnit($query, $param)
    // {
    // 	return $query->where('unit', '=', $param);
    // }

    // public function scopeRoll($query, $param)
    // {
    // 	return $query->where('admission_roll', '=', $param);
    // }

    // public function scopeTracking($query, $param)
    // {
    // 	return $query->where('tracking_no', '=', $param);
    // }
    //


    public function student()
    {
        return $this->belongsTo(Hsc::class, 'applicant_id');
    }


    public function subjectOption()
    {
        return $this->hasOne(SubjectOption::class);
    }


}
