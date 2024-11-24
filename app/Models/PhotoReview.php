<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoReview extends Model
{

    public static $rules   = [];
    protected     $table   = 'photo_changes';
    protected     $guarded = ['id'];

    public function scopeStatus($query, $param)
    {
        return $query->where('status', '=', $param);
    }


    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Hsc::class, 'applicant_id', 'id');
    }

}
