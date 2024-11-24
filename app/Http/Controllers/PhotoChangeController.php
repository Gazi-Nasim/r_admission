<?php

namespace App\Http\Controllers;

use App\Library\BillPDF;
use App\Models\Bill;
use App\Models\PhotoReview;
use App\Services\IdentityVerificationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Log;

class PhotoChangeController extends Controller
{
    public function index()
    {
        $student = session('student');

        if ($student->hasPendingPhotoReview()) {
            abort(403, 'You have already submitted a photo change request. Please wait for the approval.');
        }

        if (!session('authorize_this_session', 0)) {

            $identityVerificationService = new IdentityVerificationService();
            return $identityVerificationService
                ->sendIdentityVerificationChallenge($student, route('photo_change.index'));

        }


        return view('photo_change.photo_change_form')
            ->with('student', $student);
    }

    public function postUploadFile(Request $request, $type)
    {
        // if not session expired
        $student = session('student');


        if ($type == 'PHOTO') {
            $input_name = 'photo_student';
            $rules      = [
                $input_name => 'required|mimes:jpg,jpeg|max:100|dimensions:min_width=295,min_height=395,max_width=305,max_height=405'
            ];

            $messages = [
                $input_name.".image"      => "Not a valid photo",
                $input_name.".mimes"      => "Only JPG image is allowed",
                $input_name.".max"        => "Photo must be under 100 KB",
                $input_name.".dimensions" => "Photo must be 300x400 px",
            ];

            $validation = Validator::make($request->all(), $rules, $messages);

            if ($validation->passes()) {
                $file      = $request->file($input_name);
                $img       = Image::make($file)->resize(300, 400);
                $file_name = sprintf('%s-%s_photo.jpg', $student->id, time());
                Storage::put('public/uploads/photo-changes/'.$file_name, $img->stream());

                session(['photo.student' => $file_name]);

                $data = sprintf('<img src="%s?%s"  class="img-responsive img-thumbnail" width="250" alt="Image">'
                    , Storage::url('public/uploads/photo-changes/'.$file_name), rand());
                $data .= '<br> <span class="label label-default">Photo Preview</span>';

                $data .= sprintf('<div class="alert alert-success">
                                               <strong><i class="fa fa-check-circle-o"></i> %s</strong>
                                           </div>', 'Upload Successful');

                return $data;
            } else {

                if (session()->has('photo.student')) {
                    $photo = Storage::url('uploads/photo-changes/'.session('photo.student'));
                } else {
                    $photo = asset('assets/img/photo_placeholder.jpg');
                }

                $data = sprintf('<img src="%s"  class="img-responsive img-thumbnail" width="250" alt="Image">', $photo);
                $data .= '<br> <span class="label label-default">Photo Preview</span>';

                $data .= sprintf('<div class="alert alert-danger">
                                               <strong><i class="fa fa-exclamation-circle"></i> %s</strong>
                                           </div>', $validation->messages()->first());

                return $data;
            }
        }

        if ($type == 'ID-CARD') {
            $input_name = 'photo_registration';

            $rules = [
                $input_name => 'required|mimes:jpg,jpeg|max:1024|min:20',
            ];

            $messages = [
                $input_name.".mimes" => "Only JPG image is allowed",
                $input_name.".max"   => "Photo must be under 100 KB",
            ];

            $validation = Validator::make($request->all(), $rules, $messages);

            if ($validation->passes()) {
                $file      = $request->file($input_name);
                $file_name = sprintf('%s-%s_reg.jpg', $student->id, time());
                $file->storeAs('public/uploads/photo-changes', $file_name);

                session(['photo.registration' => $file_name]);

                $data = sprintf('<img src="%s?%s"  class="img-responsive img-thumbnail" width="250" alt="Image">'
                    , Storage::url('public/uploads/photo-changes/'.$file_name), rand());
                $data .= '<br> <span class="label label-default">Photo Preview</span>';

                $data .= sprintf('<div class="alert alert-success">
                                               <strong><i class="fa fa-check-circle-o"></i> %s</strong>
                                           </div>', 'Upload Successful');

                return $data;
            } else {

                if (session()->has('photo.student')) {
                    $photo = Storage::url('uploads/photo-changes/'.session('photo.registration'));
                } else {
                    $photo = asset('assets/img/regcard_placeholder.jpg');
                }

                $data = sprintf('<img src="%s"  class="img-responsive img-thumbnail" width="250" alt="Image">', $photo);
                $data .= '<br> <span class="label label-default">Photo Preview</span>';

                $data .= sprintf('<div class="alert alert-danger">
                                               <strong><i class="fa fa-exclamation-circle"></i> %s</strong>
                                           </div>', $validation->messages()->first());

                return $data;
            }

        }


    }


    public function store(Request $request)
    {

        // set the validation rules
        $rules = [
            'captcha' => 'required|captcha'
        ];

        $message = [
            'captcha.captcha' => 'Text did not match',
        ];

        //run validation
        $validation = Validator::make($request->all(), $rules, $message);

        if ($validation->fails()) {
            session()->flash('error', 'Please check your inputs');
            return redirect()->back()
                ->withInput()
                ->withErrors($validation);
        }

        if (!session()->has('photo.student') || !session()->has('photo.registration')) {
            session()->flash('error', 'Please Upload all Documents');
            return redirect()->back()
                ->withInput()
                ->with('message', 'Please Upload all documents');
        }

        $student = session('student');

        if ($this->hasPaidPhotoChangeRequest($student)) {

            $paidBill = PhotoReview::where('applicant_id', $student->id)
                ->where('bill_id', '!=', null)
                ->where('bill_status', '1')
                ->first();

            $photo_review                 = new PhotoReview;
            $photo_review->applicant_id   = $student->id;
            $photo_review->bill_id        = $paidBill->bill_id;
            $photo_review->bill_status    = 1;
            $photo_review->photo_reg      = session('photo.registration');
            $photo_review->new_photo      = session('photo.student');
            $photo_review->previous_photo = $student->photo;
            $photo_review->save();

            session()->forget('photo');

            return redirect()->route('student.getDashboard')
                ->with('message', 'Photo change request submitted. Please wait for the approval');

        }

        // if not paid create a bill
        try {

            DB::beginTransaction();
            // all data ok create a bill
            $bill                  = new Bill;
            $bill->applicant_id    = $student->id;
            $bill->bill_number     = '123';
            $bill->amount          = 110; // photo change bill amount
            $bill->mobile_no       = $student->mobile_no;
            $bill->payment_method  = NULL;
            $bill->payment_purpose = 'P';
            $bill->payment_status  = '0';
            $bill->save();

            // create the photo review
            $photo_review                 = new PhotoReview;
            $photo_review->applicant_id   = $student->id;
            $photo_review->bill_id        = $bill->id;
            $photo_review->photo_reg      = session('photo.registration');
            $photo_review->new_photo      = session('photo.student');
            $photo_review->previous_photo = $student->photo;
            $photo_review->save();
            DB::commit();

            // regenerate bill
            BillPDF::makeApplicationBillPDF($bill->id);

            // wipe out all photo from session
            session()->forget('photo');

            session()->put('photo_bill', $bill);
            session()->put('photo_review', $photo_review);
            session()->put('photo_change_success', 1);

            return redirect()->route('photo_change.complete');


        } catch (Exception $ex) {
            DB::rollBack();
            Log::info('Photo Review Error', ['context', $ex]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was some internal error. please contact help line');
        }

    }

    private function hasPaidPhotoChangeRequest($student): bool
    {
        return PhotoReview::where('applicant_id', $student->id)
                ->where('bill_id', '!=', null)
                ->where('bill_status', '1')
                ->count() > 0;
    }

    public function complete()
    {
        if (!session()->has('photo_review') || !session()->has('photo_bill')) {
            return redirect()->route('site.home');
        }

        $photo_bill   = session('photo_bill');
        $photo_review = session('photo_review');

        return view('photo_change.complete')
            ->with('student', session('student'))
            ->with('bill', $photo_bill)
            ->with('photo_review', $photo_review);
    }
}
