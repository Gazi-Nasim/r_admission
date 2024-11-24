<?php

namespace App\Http\Controllers;

use App\Library\DropDownHelper;
use App\Models\AdmissionFee;
use App\Models\Bill;
use App\Models\Hsc;
use App\Services\FinalApplicationService;
use App\Services\IdentityVerificationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Storage;
use URL;

class FinalApplicationController extends Controller
{
    private FinalApplicationService $service;

    public function __construct(FinalApplicationService $service)
    {
        $this->service = $service;
    }

    public function getDashboard()
    {
        session()->forget(['inputs', 'user_flags', 'verification_type', 'previous_selfie_time']);

        $student = session('student', null);
        $student = Hsc::find($student->id);

        $flags       = session('user_flags');
        $eligibility = $this->service->getEligibleUnits($student);
        $validBills  = $student->bills()->where('payment_status', '!=', '-1')->get();

        $unitNames = DropDownHelper::getUnits();


        return view('final_application.dashboard')
            ->with('student', $student)
            ->with('eligibility', $eligibility)
            ->with('validBills', $validBills)
            ->with('pendingUnits', Bill::unitsApplicationStatus($student, '0'))
            ->with('paidUnits', Bill::unitsApplicationStatus($student, '1'))
            ->with('unitNames', $unitNames)
            ->with('flags', $flags);
    }

    public function postApply(Request $request)
    {
        $student        = session('student');
        $student        = Hsc::find($student->id);
        $applying_units = $request->units;

        if (!$request->has('units')) {
            return '<div class="alert alert-danger">
                        <strong><i class="fa fa-exclamation-circle"></i> আপনার পছন্দের  ইউনিট/ ইউনিটগুলোর পাশের বক্সে টিক (<i class="fa fa-check"></i>)চিহ্ন দিন</strong>
                    </div>';
        }

        if ($this->service->hasUnpaidBill($student)) {
            return '<div class="alert alert-danger">
                        <strong><i class="fa fa-exclamation-circle"></i> নতুন ইউনিটে আবেদনের পূর্বে আপনার অপরিশোধিত বিলটি পরিশোধ করুন</strong>
                    </div>';
        }


        //find if the student is not allowed to apply for any  unit
        if (!$this->service->isAllApplyingUnitValid($student, $applying_units)) {

            return '<div class="alert alert-danger">
                        <strong><i class="fa fa-exclamation-circle"></i> আপনার বাছাইকৃত ইউনিট গুলোর মধ্যে এক বা একাধিক ইউনিট বৈধ নয়। </strong>
                   </div>';
        }

        if ($this->service->hasAlreadyAppliedInAnyUnit($student, $applying_units)) {

            return '<div class="alert alert-danger">
                        <strong><i class="fa fa-exclamation-circle"></i> আপনি বাছাই করা ইউনিট গুলোর মধ্য থেকে এক বা একাধিক ইউনিটে এতোমধ্যেই আবেদন করেছেন। নতুন ইউনিট বাছাই করুন ।</strong>
                    </div>';
        }


        // no he has not applied any of the selected unit before,
        // so we will initialize session variables for application
        // and redirect to the application form

        $this->service->initializeStudentSession($applying_units, $student);

        //        if ($this->service->hasSelfie($student)){
        //            $redirect = route('final_application.getConfirmation');
        //        } else{
        //            session(['first_time_selfie_capturing' => true]);
        //            $redirect = route('final_application.getSelfieIndex');
        //        }

        $redirect = route('getSelfieIndex');

        return response()->make()
            ->header("X-IC-Redirect", $redirect);
    }


    public function getSelfieIndex()
    {
        // dd('getSelfieIndex');
        $student = session('student');
        $student = Hsc::find($student->id);
        return view('final_application.selfie_index')
            ->with('student', $student);
    }


    public function getSelfieCapture()
    {
        // dd('getSelfieCapture');
        $student = session('student');
        $student = Hsc::find($student->id);

        if (!session('authorize_this_session', 0)) {

            $identityVerificationService = new IdentityVerificationService();
            return $identityVerificationService
                ->sendIdentityVerificationChallenge($student, route('getSelfieCapture'));
        }
        $tempUrl = URL::temporarySignedRoute('processRemoteCaptureLink', now()->addMinutes(10), ['student' => $student->id]);

        return view('final_application.selfie_capture')
            ->with('tempUrl', $tempUrl)
            ->with('student', $student);
    }

    public function getRemoteSelfieCapture()
    {
        // dd('getRemoteSelfieCapture');
        $student = session('student');
        $student = Hsc::find($student->id);

        $tempUrl = URL::temporarySignedRoute('processRemoteCaptureLink', now()->addMinutes(10), ['student' => $student->id]);

        return view('final_application.remote_selfie_capture')
            ->with('tempUrl', $tempUrl)
            ->with('student', $student);
    }

    public function remoteCaptureComplete()
    {
        // dd('remoteCaptureComplete');
        if (session()->missing('student')) {
            return redirect()->route('site.home');
        }

        $student = session('student');
        $name = $student->NAME;
        $selfie = $student->selfie;
        session()->flush();

        return view('final_application.remote_capture_complete')
            ->with('name', $name)
            ->with('selfie', $selfie);
    }

    public function remoteCaptureError()
    {
        if (session()->missing('student')) {
            return redirect()->route('site.home');
        }

        $student = session('student');

        $name = $student->NAME;

        session()->flush();

        return view('final_application.remote_capture_error')
            ->with('name', $name);
    }


    public function postSelfieCapture(Request $request)
    {
        // dd('postSelfieCapture');
        $student = session('student');
        $student = Hsc::find($student->id);

        $imageData = $request->image;
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $data      = base64_decode($imageData);

        //save the image to the server
        $name = $student->id . '_selfie_' . time() . '.jpg';
        Storage::put('public/uploads/' . $name, $data);

        $student->selfie = $name;
        $student->selfie_status = null;
        $student->save();

        session(['student' => $student]);

        return response()->make()
            ->header("X-IC-Redirect", route('selfie_getConfirmation'));
    }

    public function getSelfieQR()
    {
        $student = session('student');
        $student = Hsc::find($student->id);

        if (!session('authorize_this_session', 0)) {

            $identityVerificationService = new IdentityVerificationService();
            return $identityVerificationService
                ->sendIdentityVerificationChallenge($student, route('getSelfieQR'));
        }

        $tempUrl = URL::temporarySignedRoute('processRemoteCaptureLink', now()->addMinutes(10), ['student' => $student->id]);
        // dd($tempUrl);
        return view('final_application.selfie_qr')
            ->with('tempUrl', $tempUrl)
            ->with('student', $student);
    }



    public function getConfirmation()
    {
        // dd('getConfirmation');
        if (session()->missing('inputs')) {
            return redirect()->route('site.home');
        }

        $inputs  = session('inputs', null);
        $student = session('student', null);
        $student = Hsc::find($student->id);

        $total_fees = AdmissionFee::units(session('inputs.units'))
            ->sum('amount');

        return view('final_application.confirmation')
            ->with('inputs', $inputs)
            ->with('student', $student)
            ->with('total_fees', $total_fees);
    }

    public function postSaveApplication()
    {
        if (session()->missing('inputs')) {
            return redirect()->route('site.home');
        }

        $student = session('student');
        $student = Hsc::find($student->id);

        $applying_units = session('inputs.units');

        // again check if user has already applied in some units
        if ($this->service->hasAlreadyAppliedInAnyUnit($student, $applying_units)) {
            // if he has, then punish him
            Log::error('Duplicate unit application blocked', ['context' => $student]);
            session()->flush();
            return redirect()->route('site.home');
        }

        $total_fees = AdmissionFee::units(session('inputs.units'))
            ->sum('amount');

        try {
            // create the bill and save to session
            $bill = $this->service->createBill($student, $total_fees, $applying_units);

            session(['bill' => $bill]);

            // cleanup user information
            // Session::forget('inputs');
            // Session::forget('eligibility');

            return redirect()->route('getCompleteApplication');
        } catch (Exception $ex) {
            Log::error('Error In saveApplication()', ['context' => $ex]);
            return 'Some Error occurred. Please call helpline for help';
        }
        //========================================
    }

    public function getCompleteApplication()
    {
        if (session()->missing('bill')) {
            return redirect()->route('student.getDashboard');
        }

        $student = session('student');
        $student = Hsc::find($student->id);
        $bill    = session('bill');

        return view('final_application.application_complete')
            ->with('student', $student)
            ->with('bill', $bill);
    }

    public function postDeleteBill(Request $request, Bill $bill)
    {
        if ($bill->payment_status == '1') {
            $message = 'আপনার বিলটি ইতোমধ্যে পরিশোধ করা হয়েছে। ';
            session()->flash('message', $message);

            return response('')
                ->header("X-IC-Redirect", route('student.getDashboard'));
        }

        $student = session('student');
        if ($bill && $bill?->applicant_id == $student->id) {
            $bill->update(['payment_status' => '-1']);

            if ($bill->payment_purpose == 'P') {
                $bill->photoReview()->update(['status' => 'R']);
            }

            $message = 'আপনার বিলটি বাতিল করা হল। নতুন বিল প্রস্তুত করতে পুনরায় আবেদন করুন।';
        } else {
            $message = '';
        }

        session()->flash('message', $message);

        return response('')
            ->header("X-IC-Redirect", route('student.getDashboard'));
    }


    public function processRemoteCaptureLink(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $student = Hsc::findOrFail($request->student);
        session(['student' => $student]);
        session(['previous_selfie_time' => $student->updated_at]);

        return redirect()->route('getRemoteSelfieCapture');
    }

    public function pollSelfieUploaded($last_updated_at)
    {
        $student = session('student');
        $student = Hsc::find($student->id);

        $previous_selfie_time = $last_updated_at;

        if ($student->updated_at > $previous_selfie_time) {

            return response()->json([
                'uploaded'    => 'true',
                'last_update' => $student->updated_at,
                'redirect'    => route('getSelfieIndex'),
            ]);
        }

        return response()->json(
            [
                'uploaded'    => 'false',
                'last_update' => $student->updated_at,
            ]
        );
    }
}
