<?php

namespace App\Http\Controllers;

use App\Library\DropDownHelper;
use App\Models\InfoReview;
use App\Rules\ValidMobile;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class   ComplainBoxController extends Controller
{
    public function index()
    {

        $ssc_board = DropDownHelper::getSscBoards();
        $hsc_board = DropDownHelper::getHscBoards();
        $ssc_year  = DropDownHelper::getSscYears();
        $hsc_year  = DropDownHelper::getHscYears();

        $complainTypes = DropDownHelper::getComplainTypes();


        return view('complainbox.index')
            ->with('ssc_board', $ssc_board)
            ->with('hsc_board', $hsc_board)
            ->with('ssc_year', $ssc_year)
            ->with('hsc_year', $hsc_year)
            ->with('complainTypes', $complainTypes);
    }


    public function postInfo(Request $request)
    {

        $rules = [
            'name'      => 'required',
            'fname'     => 'required',
            'mname'     => 'required',
            'sex'       => 'required',
            'dob'       => 'required|date_format:d/m/Y',
            'mobile_no' => ['required', new ValidMobile()],

            'hsc_roll'      => 'required',
            'hsc_board'     => 'required',
            'hsc_pass_year' => 'required|digits:4',
            'hsc_gpa'       => 'required|numeric',

            'ssc_roll'      => 'required',
            'ssc_board'     => 'required',
            'ssc_pass_year' => 'required|digits:4',
            'ssc_gpa'       => 'required|numeric',

            'complain_type_id' => 'required',
            'message'          => 'required|min:5',
            'captcha'          => 'required|captcha'
        ];

        $message = [
            'captcha.captcha'           => 'Text did not match',
            'sex.required'              => 'The gender field is required',
            'complain_type_id.required' => 'This field is required',
            'message.required'          => 'This field is required',
        ];

        $this->validate($request, $rules, $message);

        session(['complain' => $request->all()]);

        return redirect()->route('complainbox.confirm');


    }

    public function confirm()
    {
        if (session()->missing('complain')) {
            return redirect()->route('complainbox.index');
        }

        return view('complainbox.confirm')
            ->with('inputs', session('complain'));
    }

    public function save()
    {
        if (session()->missing('complain')) {
            return redirect()->route('complainbox.index');
        }

        $inputs = session('complain');

        // !! some missing field  add neede
        // prepare data for input
        //
        $data = [
            'NAME'  => $inputs['name'],
            'FNAME' => $inputs['fname'],
            'MNAME' => $inputs['mname'],

            'HSC_REGNO'      => $inputs['hsc_reg_no'],
            'HSC_ROLL_NO'    => $inputs['hsc_roll'],
            'HSC_BOARD_NAME' => strtoupper($inputs['hsc_board']),
            'HSC_PASS_YEAR'  => $inputs['hsc_pass_year'],
            'HSC_GPA'        => $inputs['hsc_gpa'],
            'HSC_GROUP'      => 'N/A',

            'SSC_REGNO'        => $inputs['ssc_reg_no'],
            'SSC_ROLL_NO'      => $inputs['ssc_roll'],
            'SSC_PASS_YEAR'    => $inputs['ssc_pass_year'],
            'SSC_BOARD_NAME'   => strtoupper($inputs['ssc_board']),
            'SSC_GPA'          => $inputs['ssc_gpa'],
            'SSC_GROUP'        => 'N/A',
            'mobile_no'        => $inputs['mobile_no'],
            'photo'            => null,
            'photo_ssc'        => null,
            'photo_hsc'        => null,
            'dob'              => Carbon::createFromFormat('d/m/Y', $inputs['dob'])->toDateString(),
            'SEX'              => $inputs['sex'],
            'status'           => null,
            'complain_type_id' => $inputs['complain_type_id'],
            'message'          => $inputs['message'],
        ];

        session()->forget('complain');

        try {
            // check if already applied for review
            $applied = InfoReview::where('HSC_ROLL_NO', $data['HSC_ROLL_NO'])
                ->where('HSC_BOARD_NAME', $data['HSC_BOARD_NAME'])
                ->where('HSC_PASS_YEAR', $data['HSC_PASS_YEAR'])
                ->where('SSC_ROLL_NO', $data['SSC_ROLL_NO'])
                ->where('SSC_PASS_YEAR', $data['SSC_PASS_YEAR'])
                ->where('SSC_BOARD_NAME', $data['SSC_BOARD_NAME'])
                ->whereNull('status')
                ->count();

            if ($applied) {
                return view('complainbox.feedback')
                    ->with('inputs', $inputs)
                    ->with('success', 0)
                    ->with('msg', 'You have already applied for review.');
            } else {
                //try insert data
                InfoReview::create($data);

                return view('complainbox.feedback')
                    ->with('inputs', $inputs)
                    ->with('success', 1)
                    ->with('msg', 'Submit Successful.');
            }

        } catch (Exception $e) {

            return view('complainbox.feedback')
                ->with('inputs', $inputs)
                ->with('success', 0)
                ->with('msg', 'Internal server error. Please try after some times');
        }
    }


}
