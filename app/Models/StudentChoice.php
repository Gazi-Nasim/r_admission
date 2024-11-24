<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentChoice extends Model
{
    protected $guarded = ['id'];
    protected $table   = 'student_choices';

    public function application()
    {
        return $this->belongsTo(Application::class);
    }


    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_code', 'dept_code');
    }


    public function subjectOption()
    {
        return $this->belongsTo(SubjectOption::class, 'subjectoption_id');
    }


}
