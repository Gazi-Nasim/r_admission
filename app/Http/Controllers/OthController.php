<?php

namespace App\Http\Controllers;

use App\Library\DropDownHelper;
use App\Models\OthStudent;
use App\Rules\ValidMobile;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OthController extends Controller
{
    public function getStudentInfo()
    {
        session()->forget('user_input');
        session()->forget('user_flags');

        $ssc_board = DropDownHelper::getSscBoards();
        $hsc_board = DropDownHelper::getHscBoards();
        $ssc_year  = DropDownHelper::getSscYears();
        $hsc_year  = DropDownHelper::getHscYears();


        return view('oth.get_student_info')
            ->with('ssc_board', $ssc_board)
            ->with('hsc_board', $hsc_board)
            ->with('ssc_year', $ssc_year)
            ->with('hsc_year', $hsc_year);

    }

    public function postStudentInfo(Request $request)
    {
        $rules = [
            'hsc_roll'      => 'required',
            'hsc_board'     => 'required',
            'hsc_pass_year' => 'required',
            'hsc_gpa'       => 'required|numeric',
            'ssc_roll'      => 'required',
            'ssc_board'     => 'required',
            'ssc_pass_year' => 'required|digits:4',
            'ssc_gpa'       => 'required|numeric',
            'name'          => 'required',
            'fname'         => 'required',
            'mname'         => 'required',
            'sex'           => 'required',
            'dob'           => 'required|date_format:d/m/Y',
            'mobile_no'     => ['required', new ValidMobile()],
            'captcha'       => 'required|captcha'
        ];

        $message = [
            'captcha.captcha' => 'Text did not match',
            'sex.required'    => 'The gender field is required',
            'dob.required'    => 'The date of birth is required',
            'fname.required'  => "The Father's name field is required",
            'mname.required'  => "The Mother's field is required",
        ];


        $this->validate($request, $rules, $message);


        if ( session()->missing('oth.photo_ssc') || session()->missing('oth.photo_hsc') ) {

            session()->flash('error', 'Please Upload all SSC and HSC equivalent Transcripts');

            return redirect()->back()
                ->withInput()
                ->with('message', 'Please Upload all SSC and HSC equivalent Transcripts');
        }


        session()->put('inputs', $request->input());
        session()->put('inputs.photo_hsc', session('oth.photo_hsc'));
        session()->put('inputs.photo_ssc', session('oth.photo_ssc'));

        return redirect()->route('oth.getStudentInfoConfirm');

    }

    public function postUploadDocument(Request $request, $exam)
    {

        // if not session expired
        $input_name = 'photo_'.strtolower($exam);

        $rules = [
            $input_name => 'required|mimes:jpg,jpeg|max:1024|min:20',
        ];

        $messages = [

            $input_name.".image" => "Not a valid photo",
            $input_name.".mimes" => "Only JPG image is allowed",
            $input_name.".max"   => "Photo must be under :max KB",
            $input_name.".min"   => "Photo Quality poor. Upload high quality image (max size 1MB)",
            // $input_name.".img_min_size"  => "Photo is smaller than 300x400 pixel",
            // $input_name.".img_max_size"  => "Photo is larger than 300x400 pixel",
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if ( $validation->fails() ) {

            if ( session()->has('oth.'.$input_name) ) {
                $photo = Storage::url('public/uploads/oth-temp/'.session('oth.'.$input_name));
            } else {
                $photo = asset(sprintf('assets/img/%s_placeholder.jpg', strtolower($exam)));
            }


            $data = sprintf('<img src="%s?%s"  class="img-responsive img-thumbnail" width="250" alt="Image">', $photo,
                rand());

            $data .= sprintf('<p class="alert alert-danger">
                                    	<strong><i class="fa fa-exclamation-circle"></i> %s</strong>
                                	</p>', $validation->messages()->first());

            return $data;
        }


        $file = $request->file($input_name);

        // return 'data ok';
        if ( $file->isValid() ) // if valid file
        {
            if ( $exam == 'SSC' ) {
                $prefix = 'ssc';
            } elseif ( $exam == 'HSC' ) {
                $prefix = 'hsc';
            } else {
                Log::error(sprintf('Upload Error[%s]', $exam), ['context' => session()->all()]);
                return 'Internal Error';
            }

            $filename = sprintf('%s-%s_%s.jpg', time(), rand(100, 999), $prefix);

            $file->storeAs('public/uploads/oth-temp/', $filename);
            session()->put('oth.photo_'.$prefix, $filename);

            return sprintf('<img src="%s?%s"  class="img-responsive img-thumbnail" width="250" alt="Image">',
                Storage::url('public/uploads/oth-temp/'.$filename), rand());


        } else {
            Log::error(sprintf('Invalid file [%s]', $exam), ['context' => $file]);
            return 'Invalid File';
        }
    }

    public function getStudentInfoConfirm()
    {

        if ( session()->missing('inputs') ) {
            return redirect()->route('site.home');
        }

        $inputs = session('inputs');

        return view('oth.student_info_confirm')
            ->with('inputs', $inputs);

    }

    public function postSaveStudentInfo()
    {

        if ( session()->missing('inputs') ) {
            return redirect()->route('site.home');
        }

        $inputs = session('inputs');

        $data = [
            'NAME'           => $inputs['name'],
            'FNAME'          => $inputs['fname'],
            'MNAME'          => $inputs['mname'],
            'HSC_ROLL_NO'    => $inputs['hsc_roll'],
            'HSC_BOARD_NAME' => 'OTH',
            'HSC_PASS_YEAR'  => $inputs['hsc_pass_year'],
            'HSC_GPA'        => $inputs['hsc_gpa'],
            'SSC_ROLL_NO'    => $inputs['ssc_roll'],
            'SSC_BOARD_NAME' => strtoupper($inputs['ssc_board']),
            'SSC_PASS_YEAR'  => $inputs['ssc_pass_year'],
            'SSC_GPA'        => $inputs['ssc_gpa'],
            'mobile_no'      => $inputs['mobile_no'],
            'photo'          => null,
            'photo_ssc'      => $inputs['photo_ssc'],
            'photo_hsc'      => $inputs['photo_hsc'],
            'dob'            => Carbon::createFromFormat('d/m/Y', $inputs['dob'])->toDateString(),
            'SEX'            => $inputs['sex'],
            'status'         => null,
        ];

        session()->forget('inputs');
        session()->forget('oth');

        try {
            //try insert data
            OthStudent::create($data);

            // move photo to a new location
            $sourcePath      = 'public/uploads/oth-temp/';
            $destinationPath = 'public/uploads/oth/';

            $hsc_sourceFilePath = $sourcePath.$data['photo_hsc'];
            $hsc_destFilePath   = $destinationPath.$data['photo_hsc'];

            // Log::info('Info', array('context'=>$hsc_sourceFilePath));
            // Log::info('Info', array('context'=>$hsc_destFilePath));

            if ( Storage::exists($hsc_sourceFilePath) ) {
                Storage::move($hsc_sourceFilePath, $hsc_destFilePath);
            }

            $ssc_sourceFilePath = $sourcePath.$data['photo_ssc'];
            $ssc_destFilePath   = $destinationPath.$data['photo_ssc'];

            // Log::info('Info', array('context'=>$ssc_sourceFilePath));
            // Log::info('Info', array('context'=>$ssc_destFilePath));

            if ( Storage::exists($ssc_sourceFilePath) ) {
                Storage::move($ssc_sourceFilePath, $ssc_destFilePath);
            }

            session(['oth_success' => 1]);

        } catch (Exception $e) {

            Session(['oth_success' => 0]);
            Log::info('OTH-Save Error:', ['context' => $e]);
        }

        return view('oth.student_info_complete');
        //return redirect()->route('reg.missing_info_complete');


    }

}





