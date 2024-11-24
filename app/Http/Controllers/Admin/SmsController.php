<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\RUSms;
use App\Rules\ValidMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SmsController extends Controller
{
    public function index()
    {
        return view('admin.sms.index');
    }

    public function send(Request $request)
    {

        $rules = [
            'mobile_no' => ['required', new ValidMobile()],
            'message'   => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);


        if ( $validation->fails() ) {
            $request->flash();
            return view('admin.sms.sms_form')
                ->withErrors($validation);

        }

        RUSms::sendSms($request->mobile_no, $request->message, 'Admission-21');

        session()->flash('sms-success', 'SMS Sent to : '.$request->mobile_no);
        return view('admin.sms.sms_form');

    }
}
