<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Hsc;

class FinalApplicationService
{

    public function getEligibleUnits(Hsc $student)
    {
        $units = $student?->enrollments()
            ->where('status', '1')
            ->pluck('status', 'unit')->toArray();

        return $units;
    }

    public function hasUnpaidBill(Hsc $student)
    {
        return Bill::where('applicant_id', $student->id)
            ->where('payment_purpose', 'A')
            ->where('payment_status', '0')
            ->count();
    }

    public function isAllApplyingUnitValid($student, mixed $applying_units)
    {
        $eligible_units = $this->getEligibleUnits($student);

        foreach ($applying_units as $unit) {
            if (!array_key_exists($unit, $eligible_units)) {
                return false;
            }
        }

        return true;
    }

    public function hasAlreadyAppliedInAnyUnit(Hsc $student, mixed $applying_units)
    {
        $applied_units = $student->bills()
            ->where('payment_purpose', 'A')
            ->where('payment_status', '<>', '-1')
            ->pluck('units')->toArray();

        // [(A,B), (C,D),(E)] ==> "A,B,C,D,E" ==> [A,B,C,D,E]
        $unit_str = implode(',', $applied_units);
        $unit_arr = explode(',', $unit_str);

        foreach ($applying_units as $unit) {
            if (in_array($unit, $unit_arr)) {
                return true;
            }
        }

        return false;
    }

    public function initializeStudentSession(mixed $applying_units, Hsc $student)
    {
        session(['inputs.units' => $applying_units]);
    }

    public function createBill(Hsc $student, mixed $total_fees, mixed $applying_units)
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
        $bill->payment_purpose = 'A'; //enrollment
        $bill->payment_status  = '0';

        $bill->save();

        return $bill;
    }

    public function hasSelfie( $student)
    {
        return $student->selfie ? true : false;
    }
}
