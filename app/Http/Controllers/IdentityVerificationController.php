<?php

namespace App\Http\Controllers;

use App\Models\Hsc;
use App\Notifications\EmailPinNotification;
use App\Notifications\SmsPinNotification;
use App\Rules\PinNotExpired;
use App\Rules\ValidMobile;
use App\Rules\ValidPin;
use Carbon\Carbon;
use Faker\Factory as FakerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class IdentityVerificationController extends Controller
{

    public function index()
    {
        session()->forget('verification');

        $student = session('student');
        $student = Hsc::find($student->id);
        return view('identity_verification.index', compact('student'));
    }

    public function getMobile()
    {
        $student = session('student');
        // dd('getMobile');
        return view('identity_verification.get_mobile_no', compact('student'));
    }

    public function getEmail()
    {
        $student = session('student');
        return view('identity_verification.get_email', compact('student'));
    }

    public function postVerifyMobileOrEmail(Request $request)
    {
        $student = session('student');
        $student = Hsc::find($student->id);

        $rules = [
            'type'      => 'required',
            'mobile_no' => [
                'exclude_if:type,email',
                'required',
                new ValidMobile(),
                'unique:App\Models\Hsc,mobile_no',
            ],

            'email' => [
                'exclude_if:type,mobile',
                'required',
                'email:rfc,dns',
                'unique:App\Models\Hsc,email',
            ],
        ];

        $this->validate($request, $rules);


        //generate random number code
        $faker = FakerFactory::create();
        $verification_code = $faker->numerify('####');
        $code_time         = Carbon::now();

        if ($request->type == 'mobile') {

            $verification = [
                'type' => 'mobile',
                'data' => [
                    'mobile_no'                => $request->mobile_no,
                    'mobile_verification_code' => $verification_code,
                    'code_time'                => $code_time,
                ]
            ];

            session(['verification' => $verification]);
            $student->mobile_verification_code = $verification_code;
            $student->save();

            Notification::route('sms', $request->mobile_no)
                ->notify(new SmsPinNotification($student->NAME, $request->mobile_no, $verification_code));
        } elseif ($request->type == 'email') {

            $verification = [
                'type' => 'email',
                'data' => [
                    'email'                   => $request->email,
                    'email_verification_code' => $verification_code,
                    'code_time'               => $code_time,
                ]
            ];

            session(['verification' => $verification]);
            $student->email_verification_code = $verification_code;
            $student->save();

            Notification::route('mail', $request->email)
                ->notify(new EmailPinNotification($student->NAME, $request->email, $verification_code));
        }

        session(['student' => $student]);
        session(['verification_type' => $request->type]);

        return redirect()->route('identity_verification.getVerifyPin');
    }


    public function getVerifyPin()
    {
        $student      = session('student');
        $verification = session('verification');
        // dd(session('verification'));
        return view('identity_verification.verify_pin', compact('student', 'verification'));
    }

    // Verify the pin that is sent to mobile or Email
    public function postVerifyPin(Request $request)
    {
        // dd(session('verification'));

        $student           = session('student');
        $verification_type = session('verification.type');
        $verification_data = session('verification.data');

        if ($verification_type == 'mobile') {
            $rules = [
                'verification_code' => [
                    'required',
                    new ValidPin($verification_data['mobile_verification_code']),
                    new PinNotExpired($verification_data['code_time']),
                ],
            ];
        } elseif ($verification_type == 'email') {
            $rules = [
                'verification_code' => [
                    'required',
                    new ValidPin($verification_data['email_verification_code']),
                    new PinNotExpired($verification_data['code_time']),
                ],
            ];
        } else {
            $rules = [];
        }

        $message = [];
        $this->validate($request, $rules, $message);

        if ($verification_type == 'mobile') {
            $student->update([
                'mobile_no_verified' => 1,
                'mobile_no'          => $verification_data['mobile_no'],
            ]);
            $message = 'আপনার মোবাইল নাম্বার ভেরিফিকেশন সম্পন্ন হয়েছে।';
        } elseif ($verification_type == 'email') {
            $student->update([
                'email_verified' => 1,
                'email'          => $verification_data['email'],
            ]);
            $message = 'আপনার ইমেইল ভেরিফিকেশন সম্পন্ন হয়েছে।';
        }

        session()->forget('verification');
        session(['authorize_this_session' => 1]);
        // nasim
        // return redirect()->route('student.getDashboard')->withMessage($message);

        return redirect()->route('preliminary.getZones')->withMessage($message);
    }


    //  if the number is already exist
    public function postVerificationChallenge(Request $request)
    {
        $student = session('student');
        $student->refresh();

        //generate random number code
        $faker = FakerFactory::create();

        $verification_code = $faker->numerify('####');
        $code_time         = Carbon::now();

        $student->mobile_verification_code = $verification_code;
        $student->email_verification_code  = $verification_code;
        $student->code_time                = $code_time;
        $student->save();
        session(['student' => $student]);
        session(['route' => $request->route]);

        if ($student->mobile_no_verified == 1) {
            Notification::route('sms', $student->mobile_no)
                ->notify(new SmsPinNotification($student->NAME, $student->mobile_no, $student->mobile_verification_code));
        }

        // if ($student->email_verified == 1) {
        //     Notification::route('mail', $student->email)
        //         ->notify(new EmailPinNotification($student->NAME, $student->email, $student->email_verification_code));
        // }

        return response()->make()
            ->header("X-IC-Redirect", route('identity_verification.getVerifyChallengePin'));
    }


    public function getVerifyChallengePin()
    {
        // dd('getVerifyChallengePin');
        if (session()->missing('route')) {
            return redirect()->route('student.getDashboard');
        }

        $student = session('student');

        return view('identity_verification.verify_challenge_pin', compact('student'));
    }


    public function postVerifyChallengePin(Request $request)
    {
        // dd('postVerifyChallengePin');
        $student = session('student');

        $rules = [
            'verification_code' => [
                'required',
                new ValidPin($student->mobile_verification_code),
                new PinNotExpired($student->code_time),
            ],
        ];

        $message = [];

        $this->validate($request, $rules, $message);

        session(['authorize_this_session' => 1]);
        $url = session()->pull('route');

        return redirect()->to($url);
    }
}
