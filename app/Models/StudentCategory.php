<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCategory extends Model
{

    public $timestamps = false;
    // protected $table      = 'hsc';
    protected $guarded = ['id'];


    // public function bills()
    // {
    //     return $this->hasMany('Bill','applicant_id');
    // }

    // public function applications()
    // {
    //     return $this->hasMany('Application','applicant_id');
    // }

    // public function scopePhoto_Status($query, $param)
    // {
    //     return $query->where('photo_status', '=', $param);
    // }

    // public function enrollments()
    // {
    //     return $this->hasMany('Enrollment','applicant_id');
    // }


    // public function studentDetails()
    // {
    //     return $this->hasOne('StudentDetails','applicant_id');
    // }


}
