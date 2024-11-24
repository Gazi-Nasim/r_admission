<?php

namespace App\Http\Controllers;

use App\Library\AdmitCardPDF;
use App\Library\DropDownHelper;
use App\Models\Bill;
use App\Models\Hsc;
use App\Services\FinalApplicationService;
use Illuminate\Support\Facades\Storage;

class PostApplicationController
{

    public function __construct(FinalApplicationService $service)
    {
        $this->service = $service;
    }

    public function getDashboard()
    {
        session()->forget(['inputs', 'user_flags', 'verification_type']);

        $student = session('student', null);
        $student = Hsc::find($student->id);

        $flags       = session('user_flags');
        $eligibility = $this->service->getEligibleUnits($student);
        $validBills  = $student->bills()->where('payment_status', '!=', '-1')->get();

        $unitNames = DropDownHelper::getUnits();

        $allowedUnitForResults = array_map('trim',  explode(',', setting('show_results_for', ',')) );

        $results = $student->results()
            ->whereIn('unit', $allowedUnitForResults)
            ->orderBy('unit')->get();


        return view('post_application.dashboard')
            ->with('student', $student)
            ->with('eligibility', $eligibility)
            ->with('validBills', $validBills)
            ->with('pendingUnits', Bill::unitsApplicationStatus($student, '0'))
            ->with('paidUnits', Bill::unitsApplicationStatus($student, '1'))
            ->with('unitNames', $unitNames)
            ->with('results', $results)
            ->with('flags', $flags);
    }


    public function getDownloadAdmitCard(Hsc $student, $unit)
    {

        $photoRejectBill = $student->bills()->where('payment_purpose', 'PR')
            ->first();
        if ( ($student->photo_status != 'A' || $student->selfie_status != 'A') && $photoRejectBill->payment_status !=1 ) {
            return view('post_application.photo_change_warning')
                ->with('photoRejectBill', $photoRejectBill)
                ->with('student', $student);
        }

        $application = $student->applications()->where('unit', $unit)->firstOrFail();

        $application->increment('download_count');

        $file_path = AdmitCardPDF::makePDF($application);

        if (Storage::exists($file_path)) {
            $headers = [
                'Content-Type: application/pdf',
            ];
            ob_end_clean();
            return response()->download(Storage::path($file_path), $unit."-".$application->admission_roll.".pdf", $headers);
        }

        abort(404);

    }

}
