<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Hsc extends Model
{

    use Notifiable;

//    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'hsc';

    public function enrollmentBill()
    {
        return $this->hasOne(Bill::class, 'applicant_id')
            ->where('payment_purpose', 'E');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'applicant_id');
    }

    public function applicationBill()
    {
        return $this->hasMany(Bill::class, 'applicant_id')
            ->where('payment_purpose', 'A');
    }

    public function scopePhoto_Status($query, $param)
    {
        return $query->where('photo_status', '=', $param);
    }

    public function subjectOption()
    {
        return $this->hasOne(SubjectOption::class, 'applicant_id');
    }

    public function studentDetails()
    {
        return $this->hasOne(StudentDetails::class, 'applicant_id');
    }

    public function hasQuota()
    {
        if ($this->FFQ_photo != null || $this->WQ_photo != null || $this->PDQ_photo != null || $this->SEQ_photo != null) {
            return true;
        }

        return false;
    }

    public function getQuotaInputs()
    {
        $data = [];
        if ($this->FFQ_photo != null) {
            $data['quota']['FFQ']       = 'FFQ';
            $data['quota_photo']['FFQ'] = $this->FFQ_photo;
            $data['ffq_type']           = $this->FFQ_type;
            $data['ffq_number']         = $this->FFQ_number;
        }

        if ($this->WQ_photo != null) {
            $data['quota']['WQ']       = 'WQ';
            $data['quota_photo']['WQ'] = $this->WQ_photo;
            $data['wq_salary_id']      = $this->WQ_salary_id;
        }

        if ($this->PDQ_photo != null) {
            $data['quota']['PDQ']       = 'PDQ';
            $data['quota_photo']['PDQ'] = $this->PDQ_photo;
        }

        if ($this->SEQ_photo != null) {
            $data['quota']['SEQ']       = 'SEQ';
            $data['quota_photo']['SEQ'] = $this->SEQ_photo;
        }

        return $data;

    }

    public function getQuotaArrayAttribute($value)
    {
        $quotas = [];
        if ($this->FFQ_photo != null) {
            $quotas['FFQ'] = 'FFQ';
        }

        if ($this->WQ_photo != null) {
            $quotas['WQ'] = 'WQ';
        }

        if ($this->PDQ_photo != null) {
            $quotas['PDQ'] = 'PDQ';
        }

        if ($this->SEQ_photo != null) {
            $quotas['SEQ'] = 'SEQ';
        }

        return $quotas;
    }

    public function getQuotaStringAttribute($value)
    {
        return implode(', ', $this->quota_array);
    }

    public function getQuotaDocumentArrayAttribute($value)
    {
        $quotas = [];
        if ($this->FFQ_photo != null) {
            $quotas['FFQ'] = $this->FFQ_photo;
        }

        if ($this->WQ_photo != null) {
            $quotas['WQ'] = $this->WQ_photo;
        }

        if ($this->PDQ_photo != null) {
            $quotas['PDQ'] = $this->PDQ_photo;
        }

        if ($this->SEQ_photo != null) {
            $quotas['SEQ'] = $this->SEQ_photo;
        }

        return $quotas;
    }

    public function getEligibilityArrayAttribute($value)
    {
        $units = range('A', 'E');

        foreach ($units as $unit) {
            $eligibility[$unit] = $this->{$unit};
        }

        return $eligibility;

    }

    public function isEnrollingForFirstTime(): bool
    {
        if ($this->enrollments()?->count()) {
            return false;
        }

        if ($this->bills()?->where('payment_purpose', 'E')
            ->where('payment_status', '!=', '-1')
            ->count()) {
            return false;
        }

        return true;
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'applicant_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'applicant_id');
    }

    public function hasPaidEnrollmentBill()
    {
        return $this->bills->where('payment_purpose', 'E')
                ->where('payment_status', '1')
                ->count() > 0;
    }

    public function isEligible(): bool
    {
        $eligibility = $this->eligibilityArray;

        return array_sum($eligibility) > 0;

    }

    public function isEnrolled(): bool
    {
        return $this->enrollments()->count() > 0;
    }

    public function hasPendingPhotoReview()
    {
        return $this->photoReviews()->whereNull('status')->count() > 0;
    }

    public function photoReviews()
    {
        return $this->hasMany(PhotoReview::class, 'applicant_id');
    }


    public function results()
    {
        return $this->hasMany(Result::class, 'applicant_id');
    }

    public function photoCheckedBy()
    {
        return $this->belongsTo(User::class, 'photo_checked_by');
    }


}
