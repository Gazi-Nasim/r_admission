<?php

namespace App\Http\Controllers;

use App\Library\MobileNoChangeReceiptPDF;
use App\Models\Hsc;
use App\Models\MobileChange;
use App\Rules\ValidMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MobileChangeController extends Controller
{

    public function getMobileChangeForm()
    {
        //TODO: remove in production
//        return redirect()->route('student.login')
//            ->with('message', 'Application will start from 01.09.2021 12pm');

        $student = session('student');

        if( count($student->enrollments) == 0 ){
            return redirect()->route('site.home');
        }

        return view('mobile_change.request1_get_mobile_change_form')
            ->with('student', $student);
    }

    public function uploadPhoto(Request $request, $type)
    {

        $student = session('student');

        $rules = [
            'photo_1' => 'required|mimes:jpg,jpeg|max:1024|min:20',
        ];

        $messages = [
            "photo_1.image" => "Not a valid photo",
            "photo_1.mimes" => "Only JPG image is allowed",
            "photo_1.max"   => "Photo must be under :max KB",
            "photo_1.min"   => "Photo Quality poor. Upload high quality image (max size 1MB)",
            // $input_name.".img_min_size"  => "Photo is smaller than 300x400 pixel",
            // $input_name.".img_max_size"  => "Photo is larger than 300x400 pixel",
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if ($validation->fails()) {

            if (session()->has('photo.photo_1')) {
                $photo = Storage::url('public/uploads/mobile-change/'.session('photo.photo_1'));
            } else {
                $photo = asset('assets/img/hsc_placeholder.jpg');
            }


            $data = sprintf('<img src="%s"  class="img-responsive img-thumbnail" width="250" alt="Image">', $photo,
            );

            $data .= sprintf('<p class="alert alert-danger">
                                    	<strong><i class="fa fa-exclamation-circle"></i> %s</strong>
                                	</p>', $validation->messages()->first());

            return $data;
        }


        $filename = sprintf('%s-%s.jpg', $student->id, time());
        // return 'data ok';
        $file = $request->file('photo_1');

        if ($file->isValid()) // if valid file
        {

            $file->storeAs('public/uploads/mobile-change/', $filename);
            session()->put('photo.photo_1', $filename);

            return sprintf('<img src="%s"  class="img-responsive img-thumbnail" width="250" alt="Image">',
                Storage::url('public/uploads/mobile-change/'.$filename));

        } else {
            Log::error(sprintf('Invalid file [%s]', $filename), ['context' => $file]);
            return 'Invalid File';
        }


    }

    public function saveMobileChangeRequest(Request $request)
    {

        if (!$request->session()->has('photo.photo_1')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please Upload your photo ID');
        }

        $student = session('student');

        // if student has unresolved mobile change request
        if ($this->hasUnresolvedMobileChangeRequest($student)) {
            return redirect()->back()
                ->with('error', 'You already have a pending mobile change request. Please wait for it to be resolved.');
        }


        // get all input fields
        $inputs = $request->all();

        // set the validation rules
        $rules = [
            'mobile_no' => ['required', new ValidMobile()],
            'reason'    => 'required',
        ];

        $message = [
            'mobile_no.valid_mobile'    => 'Input a valid mobile no',
            'mobile_no.mobile_not_used' => 'Mobile No. already in use.',
        ];

        //run validation
        $validation = Validator::make($inputs, $rules, $message);

        if ($validation->fails()) {
            $request->session()->flash('error', 'Please check your inputs');
            return redirect()->back()
                ->withInput()
                ->withErrors($validation);
        }

        if (!$request->session()->has('photo.photo_1')) {
            $request->session()
                ->flash('error', 'Please Upload all Documents');

            return redirect()->back()
                ->withInput()
                ->with('message',
                    'Please Upload Upload HSC Reg. Card/NID');
        }

        try {

            // create the photo review
            $mobile_change                = new MobileChange;
            $mobile_change->applicant_id  = $student->id;
            $mobile_change->doc1          = session('photo.photo_1');
            $mobile_change->doc2          = null;
            $mobile_change->old_mobile_no = $student->mobile_no;
            $mobile_change->new_mobile_no = $request->mobile_no;
            $mobile_change->reason        = $request->reason;
            $mobile_change->save();

            session()->put('mobile_change', $mobile_change);
            session()->forget('photo.photo_1');

            return redirect()->route('mobile_change.getFeedback');


        } catch (\Exception $ex) {
            DB::rollBack();
            Log::info('Photo Review Error', ['context', $ex]);
            return redirect()->back()
                ->withInput()
                ->with('error',
                    'There was some internal error. please contact help line');
        }

    }

    public function getFeedback()
    {
        if (!session()->has('mobile_change')) {
            return redirect()->route('site.home');
        }

        $student = session('student');

        $mobile_change = session('mobile_change');

        return view('mobile_change.request2_complete')
            ->with('student', $student)
            ->with('mobile_change', $mobile_change);
    }

    private function hasUnresolvedMobileChangeRequest(mixed $student): int
    {
        return MobileChange::where('applicant_id', $student->id)
            ->whereNull('status')
            ->count();

    }

}
