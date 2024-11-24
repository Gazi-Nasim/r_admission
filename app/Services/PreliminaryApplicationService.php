<?php


namespace App\Services;


use App\Library\AppUtility;
use App\Library\BillPDF;
use App\Models\Bill;
use App\Models\Enrollment;
use App\Models\Hsc;
use App\Models\Quota;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class PreliminaryApplicationService
{
    public function hasUnpaidEnrollmentBill(Hsc $student)
    {
        return Bill::where('applicant_id', $student->id)
            ->where('payment_purpose', 'E')
            ->where('payment_status', '0')
            ->count();
    }

    public
    function hasAlreadyAppliedInAnyUnit(Hsc $student, $applying_units): bool
    {
        $applied_units = $student->bills()
            ->where('payment_purpose', 'E')
            ->where('payment_status', '<>', '-1')
            ->pluck('units')->toArray();

        // [(A,B), (C,D),(E)] ==> "A,B,C,D,E" ==> [A,B,C,D,E]
        $unit_str = implode(',', $applied_units);
        $unit_arr = explode(',', $unit_str);

        // now iterate each selected unit to check if any of them
        // are applied previously then return with an error message

        foreach ($applying_units as $applying_unit) {
            if (in_array($applying_unit, $unit_arr)) {
                return true; // user has previously applied in some unit
            }
        }

        return false; // no he is clean
    }

    public function isAllApplyingUnitIsValid(Hsc $student, mixed $applying_units): bool
    {
        $eligibility = AppUtility::extractEligibityData($student);

        $valid_units = [];

        // get all units which has eligibility set to 1
        foreach ($eligibility as $key => $value) {
            if ($value == 1) {
                $valid_units[] = $key;
            }
        }

        // check applying units against  valid units
        foreach ($applying_units as $applying_unit) {
            // if no valid unit show error message
            if (!in_array($applying_unit, $valid_units)) {
                return false;
            }
        }

        return true;
    }

    public function processUploadedPhoto($file, $file_name)
    {

        // if there is any previous photo then remove from file
        // and also from session
        if (session()->has('inputs.tmp_photo')) {
            $file_path = Storage::path('uploads/') . session('inputs.tmp_photo');

            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }

            session()->forget('inputs.tmp_photo'); // is it necessary? need to review
        }

        $originalFilePath = $file->getRealPath();
        $image = imagecreatefromjpeg($originalFilePath);
        $newImage = imagescale($image, 300, 400);

        // Define the path to save the resized image
        $savePath = storage_path('app/public/uploads/bill-photos/' . $file_name);

        // Save the resized image to the desired location
        imagejpeg($newImage, $savePath);

        // // Clean up and destroy the image resources
        // imagedestroy($image);
        // imagedestroy($newImage);

        // $img = Image::make($file)->resize(300, 400);
        // $file->storeAs('public/uploads/bill-photos', $file_name);

        session()->put('inputs.tmp_photo', $file_name);

        $data = sprintf(
            '<img src="%s?%s"  class="img-responsive img-thumbnail" width="150" alt="Image">',
            Storage::url('public/uploads/bill-photos/' . $file_name),
            rand()
        );
        $data .= '<br> <span class="label label-default">Photo Preview</span>';

        $data .= sprintf('<div class="alert alert-success">
                                               <strong><i class="fa fa-check-circle-o"></i> %s</strong>
                                           </div>', 'Upload Successful');

        return $data;
    }


    /**
     * @param mixed $applying_units
     * @param mixed $student
     * @return void
     */
    public function initializeStudentSession(mixed $applying_units, mixed $student): void
    {
        session(['inputs.units' => $applying_units]);


        //        if ( $student->photo != null ) {
        //            session(['inputs.photo' => $student->photo]);
        //            session(['inputs.tmp_photo' => $student->photo]);
        //        }
        //
        $quotas = Quota::pluck('code')->toArray();
        foreach ($quotas as $quota) {
            if ($student->{$quota . '_photo'} != null) {
                session(['inputs.quota.' . $quota => $quota]);
                session(['inputs.quota_photo.' . $quota => $student->{$quota . '_photo'}]);
            }
        }

        if ($student->FFQ_type != null) {
            session(['inputs.ffq_type' => $student->FFQ_type]);
        }

        if ($student->FFQ_number != null) {
            session(['inputs.ffq_number' => $student->FFQ_number]);
        }

        if ($student->WQ_salary_id != null) {
            session(['inputs.wq_salary_id' => $student->WQ_salary_id]);
        }
    }

    public
    function hasAlreadyEnrolled($student)
    {
        $enrolled = $student->enrollments()
            ->count();

        return (bool)$enrolled;
    }

    public function updateBillAndEnrollment($student)
    {
        $enrolled_units = $student->enrollments->pluck('unit')->toArray();
        $new_units      = session('inputs.units', []);

        $merged_units = array_merge($enrolled_units, $new_units);
        sort($merged_units);

        //update existing bill
        $bill = $this->updateBill($student, $merged_units);

        //regenerate bill
        BillPDF::makePreliminaryBillPDF($bill->id);


        // add new units to enrollment
        foreach ($new_units as $unit) {
            $enrollment               = new Enrollment;
            $enrollment->applicant_id = $student->id;
            $enrollment->bill_id      = $bill->id;
            $enrollment->unit         = $unit;
            $enrollment->quota        = $bill->quota;

            $enrollment->save();
        }

        // update previous enrollment quota
        Enrollment::where('applicant_id', $student->id)
            ->update(['quota' => $bill->quota]);


        //also save quota photos
        //        if ( $bill->quota != null ) {
        //            $quotas = explode(',', $bill->quota);
        //            foreach ($quotas as $quota) {
        //                $student->{$quota.'_photo'} = session('inputs.quota_photo.'.$quota);
        //            }
        //        }
        //
        //        // remove quotas that are previously selected but not present
        //        $all_quotas = Quota::pluck('code');
        //        $quotas     = explode(',', $bill->quota);
        //        foreach ($all_quotas as $q) {
        //            if ( !in_array($q, $quotas) ) {
        //                $student->{$q.'_photo'} = null;
        //            }
        //        }
        //
        //        $student->save();


        if ($bill->quota != null) {
            $quotas = explode(',', $bill->quota);

            $quota_docs = json_decode($bill->quota_docs);

            $old_path = 'public/uploads/bill-photos/';
            $new_path = 'public/uploads/';

            foreach ($quotas as $quota) {
                // $old_photo = $old_path.sprintf('%s_%s.jpg',$student->id,$quota);
                // $new_photo = $new_path.sprintf('%s_%s.jpg',$student->id,$quota);

                $old_photo = $old_path . $quota_docs->{$quota};
                $new_photo = $new_path . $quota_docs->{$quota};

                try {
                    if (Storage::exists($old_photo)) {
                        if (Storage::exists($new_photo)) {
                            Storage::delete($new_photo);
                        }

                        Storage::copy($old_photo, $new_photo);
                    } else {
                        Log::info('Photo Missing', ['context', $old_photo]);
                    }
                } catch (Exception $ex) {
                    Log::info('Error in updateEnrollmentPhotos', ['context', $ex]);
                }
            }
        }
    }

    /**
     * @param $student
     * @param array $units
     * @return mixed
     */
    private function updateBill($student, array $units): mixed
    {
        $bill        = $student->enrollments->first()->bill;
        $bill->units = implode(',', $units);
        $bill->quota = implode(',', session('inputs.quota', $student->quota_array));

        // also save bill quota docs
        if (!empty(session('inputs.quota_photo', $student->quota_documentation_array))) {
            $bill->quota_docs = json_encode(session('inputs.quota_photo', $student->quota_documentation_array));
        }

        $student_quotas = session('inputs.quota');

        if (Arr::get($student_quotas, 'FFQ') != null) {
            $bill->FFQ_type = session('inputs.ffq_type', null);
        } else {
            $bill->FFQ_type = null;
        }

        $bill->save();
        return $bill;
    }

    /**
     * @param $student
     * @param int $total_fees
     * @param mixed $applying_units
     * @return Bill
     */
    public function createBill($student, int $total_fees, mixed $applying_units): Bill
    {
        $bill = new Bill;

        $bill->applicant_id = $student->id;
        $bill->bill_number  = '123'; // do we need it?
        $bill->amount       = $total_fees;
        $bill->units        = implode(',', $applying_units);
        $bill->mobile_no    = $student->mobile_no ?? 'NA';

        $bill->payment_method  = null;
        $bill->trx_id          = null;
        $bill->payment_date    = null;
        $bill->payment_purpose = 'E'; //enrollment
        $bill->payment_status  = '0';

        $student_quotas = session('inputs.quota', []);

        $bill->quota = implode(',', session('inputs.quota', []));

        if (Arr::get($student_quotas, 'FFQ') != null) {

            $bill->FFQ_type = session('inputs.ffq_type', null);
        }

        if ($student->photo != null) {
            $bill->photo = $student->photo;
        } else {
            $bill->photo = session('inputs.tmp_photo');
        }

        // also save bill quota docs
        if (!empty(session('inputs.quota_photo', []))) {
            $bill->quota_docs = json_encode(session('inputs.quota_photo'));
        }

        $bill->save();

        return $bill;
    }

    public function identityVerified(Hsc $student): bool
    {
        return ($student->mobile_no_verified || $student->email_verified);
    }

    public function processUploadedQuotaPhoto($file, $quota_type)
    {
        $file_extension = $file->getClientOriginalExtension();
        $student        = session('student');
        $file_name      = sprintf('%s_%s.%s', $student->id, $quota_type, $file_extension);

        if (session()->has('inputs.quota_photo.' . $quota_type)) {
            $file_path = Storage::url('public/uploads/' . session('inputs.quota_photo.' . $quota_type));
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }

            //session()->forget('inputs.quota_photo.' . $quota_type); // is it necessary? need to review
        }


        $file->storeAs('public/uploads', $file_name);
        session(['inputs.quota_photo.' . $quota_type => $file_name]);

        if ($file_extension == 'pdf') {
            $data = '<i class="fa fa-5x fa-file-text-o"></i>';
        } else {
            $data = sprintf(
                '<img src="%s?%s"  class="img-responsive img-thumbnail" width="80" alt="Image">',
                Storage::url('public/uploads/bill-photos/' . $file_name),
                rand()
            );
        }

        return $data;
    }
}
