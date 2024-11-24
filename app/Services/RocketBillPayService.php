<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Bill;
use App\Models\Enrollment;
use App\Models\Hsc;
use App\Models\Quota;
use App\Models\SubjectOption;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RocketBillPayService
{

    public function payBill(&$bill, $paymentMethod)
    {
        switch ($bill->payment_purpose) {
            case 'E':
                return $this->payEnrollmentBill($bill, $paymentMethod);
            case 'A':
                return $this->payApplicationBill($bill, $paymentMethod);
            case 'P':
                return $this->payPhotoChangeBill($bill, $paymentMethod);
            case 'PR':
                return $this->payPhotoCollectionBill($bill, $paymentMethod);
            case 'R':
                return $this->payRegistrationBill($bill, $paymentMethod);
            default:
                return false;
        }

    }


    public function payEnrollmentBill(&$bill, $paymentMethod)
    {
        // find the student for whom the bill belongs
        $student = Hsc::find($bill->applicant_id);
        // determine the units for the bill
        $units = explode(',', $bill->units);
        $bill  = Bill::find($bill->id);

        try {
            DB::beginTransaction();

            // save all applications
            foreach ($units as $unit) {
                $enrollment               = new Enrollment;
                $enrollment->applicant_id = $student->id;
                $enrollment->bill_id      = $bill->id;
                $enrollment->unit         = $unit;
                $enrollment->quota        = $bill->quota;

                $enrollment->save();
            }

            //update bill
            $bill->payment_status = '1';
            $bill->payment_method = $paymentMethod;
            $bill->rocket_trx_id  = null;
            $bill->save();
            DB::commit();

            return true;
        } catch (Exception $ex) {

            Log::error('Error in BillPayService::payEnrollmentBill: '.$ex->getMessage(), ['bill' => $bill]);

            DB::rollBack();
            return false;

        }

    }

    public function payApplicationBill(&$bill, $paymentMethod)
    {
        // find the student for whom the bill belongs
        $student = $bill->student;

        // determine the units for the bill
        $units = explode(',', $bill->units);
        $bill  = Bill::find($bill->id);


        try {
            DB::beginTransaction();

            // save all applications
            foreach ($units as $unit) {
                $application               = new Application;
                $application->bill_id      = $bill->id;
                $application->applicant_id = $student->id;
                $application->name         = $student->NAME;
                $application->fname        = $student->FNAME;
                $application->mname        = $student->MNAME;
                $application->hsc_roll     = $student->HSC_ROLL_NO;
                $application->hsc_board    = $student->HSC_BOARD_NAME;
                $application->hsc_year     = $student->HSC_PASS_YEAR;

                $application->hsc_group      = $student->HSC_GROUP ?? $student->RU_HSC_GROUP ?? 'N/A';
                $application->unit           = $unit;
                $application->quota          = $student->quota_string;
                $application->mobile_no      = $bill->mobile_no;
                $application->admission_roll = NULL;

                $application->save();
            }

            //update bill
            $bill->payment_status = '1';
            $bill->payment_method = $paymentMethod;
            $bill->rocket_trx_id  = null;
            $bill->save();
            //update enrollment
            $student->enrollments()->whereIn('unit', $units)->update(['applied' => '1']);
            DB::commit();

            return true;
        } catch (Exception $ex) {

            DB::rollBack();
            Log::info('Application bill is not paid', ['context', $ex]);
            return false;

        }
    }

    public function payPhotoChangeBill(&$bill, $paymentMethod)
    {

        // find the studen for whom the bill belongs
        $student = Hsc::find($bill->applicant_id);
        $bill    = Bill::find($bill->id);

        if ($student->photo != NULL) {
            $bill->payment_status = '1';
            $bill->payment_method = $paymentMethod;
            $bill->rocket_trx_id  = null;
            $bill->save();

            $bill->photoReview()->update(['bill_status' => '1']);

            return true;
        } else {
            return false;
        }

    }

    public function updateEnrollmentPhotos($bill)
    {
        // if bill is paid. update photo
        $student = Hsc::find($bill->applicant_id);

        // if no previous mobile no
        if ($student->mobile_no == null) {
            $student->mobile_no = $bill->mobile_no;
        }

        // if student photo is not previously saved
        if ($student->photo == null) {

            // save photo of student
            $student->photo = $bill->photo;

            $quotas = [];
            //also save quota photos
            if ($bill->quota != null) {
                $quotas     = explode(',', trim($bill->quota));
                $quota_docs = json_decode($bill->quota_docs);

                foreach ($quotas as $quota) {
                    // $student->{$quota.'_photo'} = sprintf('%s_%s.jpg',$student->id,$quota);
                    $student->{$quota.'_photo'} = $quota_docs->{$quota};
                }
            }

            // remove quotas that are previously selected but not present
            $all_quotas = Quota::pluck('code');
            foreach ($all_quotas as $q) {
                if (!in_array($q, $quotas)) {
                    $student->{$q.'_photo'} = null;
                }
            }

            $student->save();

            try {
                // move photo to another folder
                $old_path = 'public/uploads/bill-photos/';
                $new_path = 'public/uploads/';

                $old_photo = $old_path.$bill->photo;
                $new_photo = $new_path.$bill->photo;

                if (Storage::exists($old_photo)) {
                    Storage::copy($old_photo, $new_photo);
                } else {
                    Log::error('Photo Missing', ['context', $old_photo]);
                }

                //also move quota photos
                if ($bill->quota != null) {
                    $quotas = explode(',', $bill->quota);

                    $quota_docs = json_decode($bill->quota_docs);

                    foreach ($quotas as $quota) {
                        $old_photo = $old_path.$quota_docs->{$quota};
                        $new_photo = $new_path.$quota_docs->{$quota};

                        if (Storage::exists($old_photo)) {
                            Storage::copy($old_photo, $new_photo);
                        } else {
                            Log::error('Quota Photo Missing', ['context', $old_photo]);
                        }
                    }
                }

            } catch (Exception $ex) {
                // revert file
                Log::error('Error in updateEnrollmentPhotos', ['context', $bill]);
            }
        }
    }

    public function payRegistrationBill(&$bill, $paymentMethod)
    {
        $bill = Bill::find($bill->id);

        // find the studen for whom the bill belongs
        try {
            DB::beginTransaction();
            $subjectOption = SubjectOption::where('bill_id', $bill->id)->first();
            $student       = $subjectOption?->student;

            $bill->payment_status = '1';
            $bill->payment_method = $paymentMethod;
            $bill->rocket_trx_id  = null;
            $bill->save();

            $subjectOption->bill_status = '1';
            $subjectOption->save();

            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            return false;
        }


    }

    private function payPhotoCollectionBill($bill, $paymentMethod)
    {
        // find the studen for whom the bill belongs
        $student = Hsc::find($bill->applicant_id);
        $bill    = Bill::find($bill->id);


        try {

            $bill->payment_status = '1';
            $bill->payment_method = $paymentMethod;
            $bill->rocket_trx_id  = null;
            $bill->save();

            return true;

        }catch (Exception $ex) {

            return false;
        }

    }


}
