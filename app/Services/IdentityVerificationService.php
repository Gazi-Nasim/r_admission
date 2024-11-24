<?php

namespace App\Services;

use App\Models\Hsc;
use App\Notifications\EmailPinNotification;
use App\Notifications\SmsPinNotification;
use Carbon\Carbon;
use Faker\Factory as FakerFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class IdentityVerificationService
{
    public function sendIdentityVerificationChallenge(Hsc $student, $intendedUrl): RedirectResponse|Response
    {
        $faker = FakerFactory::create();

        $verification_code = $faker->numerify('####');
        $code_time         = Carbon::now();

        $student->mobile_verification_code = $verification_code;
        $student->email_verification_code  = $verification_code;
        $student->code_time                = $code_time;
        $student->save();
        session(['student' => $student]);
        session(['route' => $intendedUrl]);


        if ($student->mobile_no_verified == 1) {
            Notification::route('sms', $student->mobile_no)
                ->notify(new SmsPinNotification($student->NAME, $student->mobile_no, $student->mobile_verification_code));
        }

        if ($student->email_verified == 1) {
            Notification::route('mail', $student->email)
                ->notify(new EmailPinNotification($student->NAME, $student->email, $student->email_verification_code));
        }

        // send to verify challenge pin page
        if (request()->ajax()) {
            return response()->make()
                ->header("X-IC-Redirect", route('identity_verification.getVerifyChallengePin'));
        }

        return response()->redirectToRoute('identity_verification.getVerifyChallengePin');


    }
}
