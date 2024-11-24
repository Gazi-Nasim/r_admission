<?php

namespace App\Http\Controllers;

use App\Library\BillPDF;
use App\Library\DropDownHelper;
use App\Models\Bill;
use App\Models\Hsc;
use App\Models\Quota;
use App\Models\Zone;
use App\Models\ZoneChoice;
use App\Services\IdentityVerificationService;
use App\Services\PreliminaryApplicationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PreliminaryApplicationController extends Controller
{

    private PreliminaryApplicationService $service;

    public function __construct(PreliminaryApplicationService $preliminaryApplicationService)
    {
        $this->service                 = $preliminaryApplicationService;
        $this->initial_application_fee = 55;
    }

    public function getDashboard()
    {

        session()->forget(['inputs', 'user_flags', 'verification_type']);

        $student = session('student', null);
        $student->refresh();
        $student = Hsc::find($student->id);

        // dd(!$student->mobile_verification_code);
        if (!$student->mobile_no_verified) {
            return redirect()->route('identity_verification.index');
        }

        if (!$student->zone_submitted) {
            return redirect()->route('preliminary.getZones');
        }

        if (!$student->photo) {
            return redirect()->route('preliminary.getUploadStudentPhoto');
        }
        
        if (!$student->selfie) {
            return redirect()->route('getSelfieIndex');
        }


        $flags       = session('user_flags');
        $eligibility = $student->eligibility_array;
        $validBills  = $student->bills()->where('payment_status', '!=', '-1')->get();

        $unitNames = DropDownHelper::getUnits();

        $zoneChoices = ZoneChoice::where('applicant_id', $student->id)
            ->orderBy('choice_priority', 'asc')
            ->with(['zone:id,name'])
            ->get(['applicant_id', 'choice_priority', 'zone_id']);


        if ($this->service->identityVerified($student)) {
            $view = 'preliminary_application.dashboard';
        } else {
            $view = 'preliminary_application.dashboard_unverified';
        }

        return view($view)
            ->with('student', $student)
            ->with('eligibility', $eligibility)
            ->with('validBills', $validBills)
            ->with('pendingUnits', Bill::unitsEnrollmentStatus($student, '0'))
            ->with('paidUnits', Bill::unitsEnrollmentStatus($student, '1'))
            ->with('unitNames', $unitNames)
            ->with('zoneChoices', $zoneChoices)
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


        if (!$this->service->identityVerified($student)) {
            return sprintf('<div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle"></i> আবেদন এর পূর্বে আপনার মোবাইল নম্বর/ ইমেইল ঠিকানা ভেরিফাই করুন।
                        <strong><a href="%s">ভেরিফিকেশনের জন্য এই লিংকে যান</a><strong>
                    </div>', route('identity_verification.index'));
        }


        // if student has unpaid bill
        // (ie: already applied but not paid)
        if ($this->service->hasUnpaidEnrollmentBill($student)) {
            return '<div class="alert alert-danger">
                                <strong><i class="fa fa-exclamation-circle"></i> নতুন ইউনিটে আবেদনের পূর্বে আপনার অপরিশোধিত বিলটি পরিশোধ করুন</strong>
                            </div>';
        }


        //find if the student is not allowed to apply for any  unit
        if (!$this->service->isAllApplyingUnitIsValid($student, $applying_units)) {

            return '<div class="alert alert-danger">
                                            <strong><i class="fa fa-exclamation-circle"></i> আপনার বাছাইকৃত ইউনিট গুলোর মধ্যে এক বা একাধিক ইউনিট বৈধ নয়। </strong>
                                       </div>';
        }


        // next check that if he has selected
        // a unit that he has not applied before
        if ($this->service->hasAlreadyAppliedInAnyUnit($student, $applying_units)) {

            return '<div class="alert alert-danger">
                        <strong><i class="fa fa-exclamation-circle"></i> আপনি বাছাই করা ইউনিট গুলোর মধ্য থেকে এক বা একাধিক ইউনিটে এতোমধ্যেই আবেদন করেছেন। নতুন ইউনিট বাছাই করুন ।</strong>
                    </div>';
        }


        // no he has not applied any of the selected unit before,
        // so we will initialize session variables for application
        // and redirect to the application form

        $this->service->initializeStudentSession($applying_units, $student);

        if (is_null($student->photo)) {

            session(['url.intended' => route('preliminary.getQuotaIndex')]);

            return response()->make()
                ->header("X-IC-Redirect", route('preliminary.getUploadStudentPhoto'));
        }

        if (!$student->hasQuota()) {
            session(['url.intended' => route('preliminary.getConfirmation')]);

            return response()->make()
                ->header("X-IC-Redirect", route('preliminary.getQuotaIndex'));
        }

        return response()->make()
            ->header("X-IC-Redirect", route('preliminary.getConfirmation'));
    }


    public function getUploadStudentPhoto()
    {

        $student = session('student');
        $student = Hsc::find($student->id);
        session(['inputs.photo' => $student->photo]);

        $hasUnpaidBill = $this->service->hasUnpaidEnrollmentBill($student);

        return view('preliminary_application.upload_photo', compact('student', 'hasUnpaidBill'));
    }

    public function postUploadStudentPhoto(Request $request)
    {
        $rules = [
            'photo' => 'required|mimes:jpg,jpeg|max:100|dimensions:min_width=295,min_height=395,max_width=305,max_height=405'
        ];

        $messages = [

            "photo.image"      => "Not a valid photo",
            "photo.mimes"      => "Only JPG image is allowed",
            "photo.max"        => "Photo must be under 100 KB",
            "photo.dimensions" => "Photo must be 300x400 px",
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if ($validation->fails()) {

            if (session()->has('inputs.photo')) {
                $photo = Storage::url('uploads/' . session('inputs.photo'));
            } elseif (session()->has('inputs.tmp_photo')) {
                $photo = Storage::url('public/uploads/bill-photos/' . session('inputs.tmp_photo'));
            } else {
                $photo = asset('assets/img/Profile1.jpg');
            }

            $data = sprintf('<img src="%s"  class="img-responsive img-thumbnail" width="150" alt="Image">', $photo);
            $data .= '<br> <span class="label label-default">Photo Preview</span>';

            $data .= sprintf('<div class="alert alert-danger">
                                               <strong><i class="fa fa-exclamation-circle"></i> %s</strong>
                                           </div>', $validation->messages()->first());

            return $data;
        }

        // if validation passes
        $file = $request->file('photo');

        if ($file->isValid()) {
            $student   = session('student');
            $file_name = sprintf('%s-%s.jpg', $student->id, time());
            $data      = $this->service->processUploadedPhoto($file, $file_name);

            return $data;
        } else {
            return sptintf('<div class="alert alert-danger">
                                   <strong><i class="fa fa-exclamation-circle"></i> %s</strong>
                               </div>', 'Upload Failed');
        }
    }

    public function saveStudentPhoto(Request $request)
    {

        if (session()->missing('inputs.tmp_photo')) {
            return redirect()->back()
                ->withInput()
                ->with('photo-message', 'Please Upload your Photo');
        }

        // update hsc table
        $student        = session('student');
        $student->photo = session('inputs.tmp_photo');
        $student->save();

        //upload bills photo
        $student->bills()->update(['photo' => session('inputs.tmp_photo')]);

        session(['student' => $student]);

        $old_path = 'public/uploads/bill-photos/' . $student->photo;
        $new_path = 'public/uploads/' . $student->photo;


        if (Storage::exists($old_path)) {
            Storage::delete($new_path);
            Storage::copy($old_path, $new_path);
        }

        return redirect()->intended(route('student.getDashboard'));
    }


    public function getQuotaAndOtherInfo()
    {
        $quotas = Cache::remember('quotas', 60, function () {
            return Quota::pluck('quota', 'code');
        });

        $student = session('student');

        if (session()->missing('inputs')) {
            session(['inputs' => $student->getQuotaInputs()]);
        }


        return view('preliminary_application.quota_other_info')
            ->with('quotas', $quotas)
            ->with('student', $student);
    }


    public function getQuotaIndex()
    {

        $quotas = Cache::remember('quotas', 60, function () {
            return Quota::pluck('quota', 'code');
        });

        $student = session('student');
        $student = Hsc::find($student->id);

        if (session('authorize_this_session', 0) == '0') {
            return view('preliminary_application.quota_index_readonly')
                ->with('quotas', $quotas)
                ->with('student', $student);
        }

        return view('preliminary_application.quota_index')
            ->with('quotas', $quotas)
            ->with('student', $student);
    }

    public function getAddQuota($quota)
    {
        $availableQuotas = Cache::remember('quotas', 60, function () {
            return Quota::pluck('quota', 'code');
        });

        // abort if quota is not valid
        if (!in_array($quota, $availableQuotas->keys()->toArray())) {
            abort(404);
        }

        $student = session('student');

        return view('preliminary_application.quota_add')
            ->with('selectedQuota', $quota)
            ->with('quotas', $availableQuotas)
            ->with('student', $student);
    }


    public function postSaveQuota(Request $request)
    {

        $rules = [
            'quota_photo' => 'required|mimes:jpeg,pdf|max:3072',
            'quota'       => 'required',
            'ffq_type'    => 'required_if:quota,FFQ',
        ];

        $messages = [
            "quota_photo.required" => "Please Upload supporting documents for selected quota",
            "quota_photo.image"    => "Not a valid photo",
            "quota_photo.mimes"    => "Only JPG or PDF file is allowed",
            "quota_photo.max"      => "document must be under 3MB",
        ];

        $this->validate($request, $rules, $messages);

        $file = $request->file('quota_photo');
        $selectedQuota = $request->input('quota');

        if ($file->isValid()) {
            $quota_type = $request->input('quota');
            $this->service->processUploadedQuotaPhoto($file, $quota_type);
        }

        $student = session('student');
        $student = Hsc::find($student->id);

        $student->{$selectedQuota . '_photo'} = session('inputs.quota_photo.' . $selectedQuota);
        if ($selectedQuota == 'FFQ') {
            $student->FFQ_type = $request->input('ffq_type');
            $student->FFQ_number = $request->input('ffq_number');
        }

        if ($selectedQuota == 'WQ') {
            $student->WQ_salary_id = $request->input('wq_salary_id');
        }

        $student->save();
        session(['student' => $student]);

        $student->bills()->update(['quota' => $student->quota_string]);

        return redirect()->route('preliminary.getQuotaIndex')
            ->with('message', 'Quota Added Successfully');
    }

    public function postDeleteQuota(Request $request)
    {
        if (session()->missing('student')) {
            return redirect()->route('site.home');
        }

        $student = Hsc::find(session('student')->id);

        $quota = $request->quota;

        $student->{$quota . '_photo'} = null;

        if ($quota == 'FFQ') {
            $student->FFQ_type = null;
            $student->FFQ_number = null;
        }

        if ($quota == 'WQ') {
            $student->WQ_salary_id = null;
        }

        $student->save();
        session(['student' => $student]);


        $filePath = 'public/uploads/' . $student->{$quota . '_photo'};
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        session()->forget('inputs.quota_photo.' . $quota);

        return redirect()->route('preliminary.getQuotaIndex')
            ->with('message', 'Quota Deleted Successfully');
    }


    public function getLanguageIndex()
    {

        $student = session('student');
        $student = Hsc::find($student->id);

        if (session('authorize_this_session', 0) == '0') {
            return view('preliminary_application.language_index_readonly')
                ->with('student', $student);
        }

        return view('preliminary_application.language_index')
            ->with('student', $student);
    }

    public function getEditLanguage()
    {
        $student = session('student');

        return view('preliminary_application.language_edit')
            ->with('student', $student);
    }

    public function postSaveLanguage(Request $request)
    {

        $rules = [
            'question_type' => 'required',
        ];

        $this->validate($request, $rules);

        $student = session('student');

        if ($request->question_type == 'BN') {
            $student->is_english = 0;
        } else {
            $student->is_english = 1;
        }
        $student->save();

        return redirect()->route('preliminary.getLanguageIndex')
            ->with('message', 'Language Updated Successfully');
    }



    public function postQuotaAndOtherInfo(Request $request)
    {

        if (session()->missing('inputs.quota')) {
            return redirect()
                ->back()
                ->with('quota-error-message', 'Please select one or more quotas');
        }

        if (session()->has('inputs.quota')) {
            foreach (session('inputs.quota') as $quota) {
                if (session()->missing('inputs.quota_photo.' . $quota)) {
                    return redirect()
                        ->back()
                        ->with('quota-error-message', 'Please Upload supporting documents for selected quota');
                }
            }
        }

        $student = session('student');
        $student = Hsc::find($student->id);

        $quotas   = session('inputs.quota', $student->quota_array);
        $ffq_type = session('inputs.ffq_type', $student->FFQ_type);
        $ffq_number = session('inputs.ffq_number', $student->FFQ_number);
        $wq_salary_id = session('inputs.wq_salary_id', $student->WQ_salary_id);

        // save quota photos
        if (!empty($quotas)) {
            foreach ($quotas as $quota) {
                $student->{$quota . '_photo'} = session('inputs.quota_photo.' . $quota);
            }
            $student->FFQ_type = $ffq_type;
            $student->FFQ_number = $ffq_number;
            $student->WQ_salary_id = $wq_salary_id;
        }

        // remove quotas that are previously selected but not present
        $all_quotas = Quota::pluck('code')->toArray();
        foreach ($all_quotas as $q) {
            if (!in_array($q, $quotas)) {
                $student->{$q . '_photo'} = null;
            }
        }

        $student->save();

        $bill = Bill::where('applicant_id', $student->id)
            ->where('payment_purpose', 'E')
            ->first();

        $bill?->update(
            [
                'quota'      => implode(',', $quotas),
                'quota_docs' => json_encode($student->quota_document_array)
            ]
        );

        $student->enrollments()->update(['quota' => $student->quota_string]);


        session(['student' => $student]);

        $old_path = 'public/uploads/bill-photos/';
        $new_path = 'public/uploads/';
        foreach ($quotas as $quota) {

            $old_photo = $old_path . session('inputs.quota_photo.' . $quota);
            $new_photo = $new_path . session('inputs.quota_photo.' . $quota);

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

        // todo : this is a temporary fix to collect missing quota document
        // use the commented code after the fix is done
        //        return redirect()->route('student.getDashboard')
        //            ->with('message', 'Photo Uploaded Successfully');

        if (session()->has('inputs.units')) {
            return redirect()->route('preliminary.getConfirmation');
        } else {
            return redirect()->route('student.getDashboard')
                ->with('message', 'Quota Update successfully');
        }
    }

    public function postFFQ(Request $request)
    {
        if ($request->filled('ffq_type')) {
            session(['inputs.ffq_type' => $request->ffq_type]);
        }
        if ($request->filled('ffq_number')) {
            session(['inputs.ffq_number' => $request->ffq_number]);
        }
    }

    public function postWQ(Request $request)
    {
        if ($request->filled('wq_salary_id')) {
            session(['inputs.wq_salary_id' => $request->wq_salary_id]);
        }
    }

    public function postSelectQuota(Request $request)
    {
        $target          = $request->quota_name;
        $selected_quotas = $request->quota;

        // if selected a quota
        if (trim($selected_quotas) != '') {
            session(['inputs.quota.' . $target => $target]);
            return view('preliminary_application.quota_upload_form', ['quota' => $target]);
        }

        // if deselected a quota
        session()->forget('inputs.quota.' . $target);
        session()->forget('inputs.quota_photo.' . $target);
        if ($target == 'FFQ') {
            session()->forget('inputs.ffq_type');
        }
        return "  ";
    }

    public function postUploadQuotaPhoto(Request $request)
    {

        $rules = [
            'quota_photo' => 'required|mimes:jpeg,pdf|max:2048',
            'quota'       => 'required'
        ];

        $messages = [

            "quota_photo.required" => "Please Upload supporting documents for selected quota",
            "quota_photo.image"    => "Not a valid photo",
            "quota_photo.mimes"    => "Only JPG or PDF file is allowed",
            "quota_photo.max"      => "document must be under 2MB",
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        $quota_type = $request->quota;

        // do validation
        if ($validation->fails()) {
            if (session()->has('inputs.quota_photo.' . $quota_type)) {
                $photo = 'public/uploads/bill-photos/' . session('inputs.quota_photo.' . $quota_type);
                if (!Storage::exists($photo)) {
                    $photo = asset('assets/img/Profile1.jpg');
                }
            } else {
                $photo = asset('assets/img/Profile1.jpg');
            }


            $data = sprintf(
                '<img src="%s?%s"  class="img-responsive img-thumbnail" width="50" alt="Image">',
                Storage::url($photo),
                rand()
            );

            $data .= sprintf('<div class="alert alert-danger">
                                            <strong><i class="fa fa-exclamation-circle"></i> %s</strong>
                                        </div>', $validation->messages()->first());

            return $data;
        }

        $file = $request->file('quota_photo');

        if ($file->isValid()) {
            $data = $this->service->processUploadedQuotaPhoto($file, $quota_type);

            return $data;
        } else {
            return sprintf('<div class="alert alert-danger">
                                               <strong><i class="fa fa-exclamation-circle"></i> %s</strong>
                                           </div>', 'Upload Failed');
        }
    }

    public function getConfirmation()
    {
        if (session()->missing('inputs')) {
            return redirect()->route('site.home');
        }

        $inputs   = session('inputs', null);
        $student  = session('student', null);
        $paidBill = Bill::where('applicant_id', $student->id)
            ->where('payment_purpose', 'E')->where('payment_status', '1')
            ->first();

        $total_fees = $this->initial_application_fee;

        $view_ffq_types = [
            'FFQ-C' => 'Child of Freedom fighter',
            'FFQ-G' => 'Grand Child of Freedom fighter'
        ];

        $zoneChoices = ZoneChoice::where('applicant_id', $student->id)
            ->orderBy('choice_priority', 'asc')
            ->with('zone:name,id')
            ->get();

        return view('preliminary_application.confirmation')
            ->with('inputs', $inputs)
            ->with('student', $student)
            ->with('paidBill', $paidBill)
            ->with('view_ffq_types', $view_ffq_types)
            ->with(compact('zoneChoices'))
            ->with(compact('total_fees'));
    }

    public function postSaveApplication(Request $request)
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

        $total_fees = $this->initial_application_fee;

        if ($this->service->hasAlreadyEnrolled($student)) {
            $student->is_english = $request->question_type == 'EN' ? 1 : 0;
            $student->save();
            $this->service->updateBillAndEnrollment($student);
            return redirect()->route('student.getDashboard');
        } else {
            // == try to create the bill===============

            try {
                // create the bill and save to session
                $bill = $this->service->createBill($student, $total_fees, $applying_units);
                $student->is_english = $request->question_type == 'EN' ? 1 : 0;
                $student->save();
                session(['bill' => $bill]);

                // cleanup user information
                // Session::forget('inputs');
                // Session::forget('eligibility');

                return redirect()->route('preliminary.getCompleteApplication');
            } catch (Exception $ex) {
                Log::error('Error In saveApplication()', ['context' => $ex]);
                return 'Some Error occurred. Please call helpline for help';
            }
            //========================================

        } //end else
    }


    public function getCompleteApplication()
    {
        if (session()->missing('bill')) {
            return redirect()->route('student.getDashboard');
        }

        $student = session('student');
        $student->refresh();
        //$bill    = session()->pull('bill');
        $bill = session('bill');


        return view('preliminary_application.enrollment_complete')
            ->with('student', $student)
            ->with('bill', $bill);
    }

    public function getDownloadBill(Bill $bill)
    {
        $student = session('student');
        if ($bill->student->id != $student->id) {
            abort(404);
        }


        $path = Storage::path('public/downloads/' . $bill->id . '.pdf');

        if ($bill->payment_purpose == 'E') {
            $file_path = BillPDF::makePreliminaryBillPDF($bill->id);
        } else if ($bill->payment_purpose == 'A') {
            $file_path = BillPDF::makeApplicationBillPDF($bill->id);
        } else if ($bill->payment_purpose == 'P') {
            $file_path = BillPDF::makePhotoChangeBillPDF($bill->id);
        } else {
        }


        if (Storage::exists($file_path)) {
            $headers = [
                'Content-Type: application/pdf',
            ];

            ob_end_clean();
            return response()->download(Storage::path($file_path), "bill-{$bill->id}.pdf", $headers);
        } else {
            abort(404);
        }
    }

    // to fetch all data from zone table
    public function getZones()
    {
        $student       = session('student');
        $student       = Hsc::find($student->id);
        $zones = Zone::all()->pluck('name', 'id');
        return view('zone_choice.zone_choice_form')
            ->with('student', $student)
            ->with('zones', $zones);
    }

    public function postZoneChoiceForm(Request $request)
    {
        $request->validate([
            'zone' => 'required',
        ], [
            'zone.required' => 'অঞ্চল সমূহ নির্বাচন করুন',
        ]);

        $zoneChoices   = $request->zone;
        $zones = Zone::get()->pluck('name', 'id');

        if (count($zoneChoices) == count($zones)) {
            $appli_id = session('student')->id;
            ZoneChoice::where('applicant_id', $appli_id)->delete();
            foreach ($zoneChoices as $key => $zoneChoice) {
                $singlChoi = [
                    'applicant_id' => $appli_id,
                    'zone_id' => $zoneChoice,
                    'choice_priority' => $key + 1,
                ];
                ZoneChoice::create($singlChoi);
            }
            Hsc::find($appli_id)->update(['zone_submitted' => '1']);
            $message = 'আপনার অঞ্চল সমূহ নির্বাচন সম্পন্ন হয়েছে।';
            return redirect()->route('student.getDashboard')->withMessage($message);
        } else {
            return back()->withMessage('বাম দিকের বক্স থেকে সব গুলো অঞ্চল সিলেক্ট করে ডান দিকের বক্সে আনুন');
        }
    }

    public function UpdateZones()
    {
        $student       = session('student');
        $student       = Hsc::find($student->id);
        $student = session('student');
        $student = Hsc::find($student->id);

        if (!session('authorize_this_session', 0)) {

            $identityVerificationService = new IdentityVerificationService();
            return $identityVerificationService
                ->sendIdentityVerificationChallenge($student, url('edit-zones'));
        }

        $zoneChoices = ZoneChoice::where('applicant_id', $student->id)
            ->orderBy('choice_priority', 'asc')
            ->get('zone_id');

        $zones = [];
        foreach ($zoneChoices as $zoneChoice) {
            $zone = Zone::find($zoneChoice->zone_id);
            $zones[$zone->id] = $zone->name;
        }

        return view('zone_choice.edit_form')
            ->with('student', $student)
            ->with('zones', $zones);
    }
}
