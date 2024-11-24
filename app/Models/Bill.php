<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $guarded = ['id'];

    public static function unitsApplicationStatus($student, $status)
    {
        $bills = $student->bills()
            ->whereIn('payment_purpose', ['A'])
            ->where('payment_status', $status)->get();

        $units = [];

        foreach ($bills as $b) {
            $units = array_merge($units, explode(',', $b->units));
        }

        return $units;

    }

    public static function unitsEnrollmentStatus($student, $status)
    {
        $bills = $student->bills()
            ->whereIn('payment_purpose', ['E'])
            ->where('payment_status', $status)->get();

        $units = [];

        foreach ($bills as $b) {
            $units = array_merge($units, explode(',', $b->units));
        }

        return $units;

    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function photoReview()
    {
        return $this->hasOne(PhotoReview::class);
    }

    public function scopePreApplicationBill($query, $param = null)
    {
        return $query->where('payment_purpose', 'E')
            ->where('payment_status', '<>', '-1');
    }


    public function student()
    {
        return $this->belongsTo(Hsc::class, 'applicant_id');
    }


}
