<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectOption extends Model
{
    public    $timestamps = false;
    protected $guarded    = ['id'];
    protected $table      = 'subject_options';

    public function student()
    {
        return $this->belongsTo(Hsc::class, 'applicant_id');
    }


    public function application()
    {
        return $this->belongsTo(Application::class);
    }


    public function choices()
    {
        return $this->hasMany(StudentChoice::class, 'subjectoption_id');
    }



    public function hallChoices()
    {
        return $this->hasMany(HallChoice::class, 'subjectoption_id');
    }


    public function bill()
    {
        return $this->hasOne(Bill::class, 'id', 'bill_id');
    }


    public function getAdmissionSubjectAttribute($value)
    {
        return Department::where('dept_code', $value)->first();
    }


    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_code', 'hall_code');
    }


    public function studentCategory()
    {
        return $this->belongsTo(StudentCategory::class);
    }


    public function admissionDepartment() {
        return $this->belongsTo(Department::class,'admission_subject', 'dept_code');
    }


}
