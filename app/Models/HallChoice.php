<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallChoice extends Model
{
    protected $guarded = ['id'];
    protected $table   = 'hall_choices';


    public function subjectOption()
    {
        return $this->belongsTo(SubjectOption::class, 'subjectoption_id');
    }


    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_code', 'hall_code');
    }


}
