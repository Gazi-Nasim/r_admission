<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDetails extends Model
{
    protected $guarded = ['id'];
    protected $table   = 'student_details';


    // public function student()
    // {
    // 	return $this->belongsTo('Hsc','applicant_id');
    // }
}
