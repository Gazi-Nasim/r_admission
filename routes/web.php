<?php

use App\Http\Controllers\Admin\MiscController;
use App\Http\Controllers\BillPayController;
use App\Http\Controllers\ComplainBoxController;
use App\Http\Controllers\FinalApplicationController;
use App\Http\Controllers\HallChoiceController;
use App\Http\Controllers\HonoursAdmissionController;
use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\MobileChangeController;
use App\Http\Controllers\OthController;
use App\Http\Controllers\PhotoChangeController;
use App\Http\Controllers\PostApplicationController;
use App\Http\Controllers\PreliminaryApplicationController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\SubjectChoiceController;
use App\Models\Bill;
use App\Models\Enrollment;
use App\Models\Hsc;
use App\Notifications\EmailAdmitCardNotification;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// payment api
Route::prefix('bill')->controller(BillPayController::class)
    ->name('billPay.')
    ->middleware('secure-payment')
    ->group(function () {
        Route::get('/cIcC5ErU20I6/{bill_no}/{amount}/check', 'check_bill');
        Route::get('/cIcC5ErU20I6/{bill_no}/{payment_method}/paid', 'process_bill');
    });


// external info page
Route::controller(SiteController::class)->name('site.')->group(function () {

    Route::get('/', 'getHome')->name('home');

    Route::prefix('site')->group(function () {
        Route::get('payment-info', 'getPaymentInfo')->name('payment_info');
        Route::get('admission-info', 'getAdmissionInstruction')->name('admission_info');
        Route::get('application-guideline', 'getApplicationGuideline')->name('application_guideline');
        Route::get('photo-guideline', 'getPhotoGuideline')->name('photo_guideline');
        Route::get('contact', 'getContact')->name('contact');
    });

    Route::get('/{data}/admit-card', 'getAdmitCard')->name('getAdmitCard');
});


//login controller for student
Route::name('student.')->controller(StudentLoginController::class)->group(function () {

    Route::get('login', 'getLogin')->name('getLogin');
    Route::post('login', 'postLogin')->name('postLogin');
    Route::get('logout', 'getLogout')->name('getLogout');
    Route::get('not-found', 'getLoginError')->name('getLoginError');

    Route::get('dashboard', 'getDashboard')->name('getDashboard')->middleware('auth-student');
});


// email and mobile verification for student
Route::name('identity_verification.')->prefix('verify')
    ->controller(IdentityVerificationController::class)->middleware(['auth-student'])
    ->group(function () {

        Route::get("/", 'index')->name('index');
        Route::get("/mobile", 'getMobile')->name('getMobile');
        // Route::get("/mobile", 'getMobile')->name('getMobile')->middleware('application-allowed');
        Route::get("/email", 'getEmail')->name('getEmail');
        Route::post("/", 'postVerifyMobileOrEmail')->name('postVerifyMobileOrEmail');
        Route::get("/verifyPin", 'getVerifyPin')->name('getVerifyPin');
        Route::post("/verifyPin", 'postVerifyPin')->name('postVerifyPin');

        Route::post("/postVerificationChallenge", 'postVerificationChallenge')->name('postVerificationChallenge');
        Route::get("/getVerifyChallengePin", 'getVerifyChallengePin')->name('getVerifyChallengePin');
        Route::post("/postVerifyChallengePin", 'postVerifyChallengePin')->name('postVerifyChallengePin');
    });


// preliminary application controller for student
Route::name('preliminary.')->middleware('auth-student')
    ->controller(PreliminaryApplicationController::class)
    ->group(function () {

        //Route::get('dashboard', 'getDashboard')->name('getDashboard');

        Route::middleware(['verify-identity'])->group(function () {

            Route::middleware(['application-allowed'])->group(function () {
                Route::post('apply', 'postApply')->name('postApply');
                Route::get('confirmation', 'getConfirmation')->name('getConfirmation');
                Route::post('save-application', 'postSaveApplication')->name('postSaveApplication');
                Route::get('complete', 'getCompleteApplication')->name('getCompleteApplication');
            });

            Route::middleware(['photo-change-allowed'])->group(function () {
                Route::get('upload-photo', 'getUploadStudentPhoto')->name('getUploadStudentPhoto');
                Route::post('upload-photo', 'postUploadStudentPhoto')->name('postUploadStudentPhoto');
                Route::post('save-student-photo', 'saveStudentPhoto')->name('saveStudentPhoto');
            });

            Route::middleware(['quota-change-allowed'])->group(function () {
                Route::get('quota-index', 'getQuotaIndex')->name('getQuotaIndex');
                Route::get('{quota}/add-quota', 'getAddQuota')->name('getAddQuota');
                Route::post('save-quota', 'postSaveQuota')->name('postSaveQuota');
                Route::post('delete-quota', 'postDeleteQuota')->name('postDeleteQuota');
            });

            Route::middleware(['language-change-allowed'])->group(function () {
                Route::get('language-index', 'getLanguageIndex')->name('getLanguageIndex');
                Route::get('edit-language', 'getEditLanguage')->name('getEditLanguage');
                Route::post('save-language', 'postSaveLanguage')->name('postSaveLanguage');
            });

            Route::post('zones', 'postZoneChoiceForm')->name('postZones');
            Route::get('zones', 'getZones')->name('getZones');
            Route::get('edit-zones', 'UpdateZones')->name('UpdateZones');
            
        });


        Route::get('{bill}/download-bill', 'getDownloadBill')->name('getDownloadBill');
    });

// final application controller for student
Route::name('final_application.')
    ->prefix('final-application')
    ->controller(FinalApplicationController::class)
    ->group(function () {

        Route::middleware(['verify-identity', 'application-allowed', 'auth-student'])->group(function () {
            Route::post('apply', 'postApply')->name('postApply');
            Route::get('confirmation', 'getConfirmation')->name('getConfirmation');
            Route::post('save-application', 'postSaveApplication')->name('postSaveApplication');
            Route::get('complete', 'getCompleteApplication')->name('getCompleteApplication');

            Route::post('/{bill}/delete-bill', 'postDeleteBill')->name('postDeleteBill');
        });

        // // for selfie
        // Route::middleware(['verify-identity', 'selfie-change-allowed', 'auth-student'])->group(function () {
            // Route::get('selfie-index', 'getSelfieIndex')->name('getSelfieIndex');
        //     Route::get('selfie-capture', 'getSelfieCapture')->name('getSelfieCapture');
        //     Route::post('selfie-capture', 'postSelfieCapture')->name('postSelfieCapture');

        //     //remote capture
        //     Route::get('selfie-qr', 'getSelfieQR')->name('getSelfieQR');
        //     Route::get('remote-selfie-capture', 'getRemoteSelfieCapture')->name('getRemoteSelfieCapture');

        //     Route::get('poll-selfie-uploaded/{time}', 'pollSelfieUploaded')->name('pollSelfieUploaded');
        // });

        // Route::middleware(['selfie-change-allowed'])->group(function () {
        //     Route::get('remote-capture', 'processRemoteCaptureLink')->name('processRemoteCaptureLink');
        //     Route::get('remote-capture-complete', 'remoteCaptureComplete')->name('remoteCaptureComplete');
        //     Route::get('remote-capture-error', 'remoteCaptureError')->name('remoteCaptureError');
        // });
    });

Route::name('post_application.')->middleware(['auth-student', 'verify-identity'])
    ->prefix('post-application')
    ->controller(PostApplicationController::class)
    ->group(function () {
        Route::get('dashboard', 'getDashboard')->name('getDashboard');
        Route::get('{student}/unit/{unit}/download-admitCard', 'getDownloadAdmitCard')->name('getDownloadAdmitCard');
    });


// photo change controller for student
Route::name('photo_change.')->middleware('auth-student')
    ->prefix('photo-change')
    ->controller(PhotoChangeController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::post('/{type}/upload', 'postUploadFile')->name('postUploadFile');
        Route::get('/complete', 'complete')->name('complete');
    });


Route::name('mobile_change.')->controller(MobileChangeController::class)
    ->prefix('mobile-change')->middleware('auth-student')
    ->group(function () {
        Route::get('/get-form', 'getMobileChangeForm')->name('getMobileChangeForm');
        Route::post('/{type}/photo', 'uploadPhoto')->name('uploadPhoto');
        Route::post('/save-request', 'saveMobileChangeRequest')->name('saveMobileChangeRequest');
        Route::get('/feedback', 'getFeedback')->name('getFeedback');
    });




// Oth application controller for student
Route::name('oth.')->prefix('oth')->group(function () {
    Route::get('/', [OthController::class, 'getStudentInfo'])->name('getStudentInfo');
    Route::post('/', [OthController::class, 'postStudentInfo'])->name('postStudentInfo');
    Route::post('/docs/{exam}', [OthController::class, 'postUploadDocument'])->name('postUploadDocument');
    Route::get('/confirmation', [OthController::class, 'getStudentInfoConfirm'])->name('getStudentInfoConfirm');
    Route::post('/save', [OthController::class, 'postSaveStudentInfo'])->name('postSaveStudentInfo');
});


// Complain Box controller for student
Route::name('complainbox.')->prefix('complainbox')
    ->middleware('complain-allowed')
    ->group(function () {
        Route::get('/', [ComplainBoxController::class, 'index'])->name('index');
        Route::post('/', [ComplainBoxController::class, 'postInfo'])->name('postInfo');
        Route::get('/confirm', [ComplainBoxController::class, 'confirm'])->name('confirm');
        Route::post('/save', [ComplainBoxController::class, 'save'])->name('save');
        Route::get('/complete', [ComplainBoxController::class, 'complete'])->name('complete');
    });


Route::name('subject_choice.')->prefix('subject-choice')->middleware('auth-student')
    ->controller(SubjectChoiceController::class)
    ->group(function () {
        Route::middleware('verify-identity')->group(function () {
            Route::post('/{subject_choice_id}/apply', 'apply')->name('apply');
            Route::get('/subject-choice-form', 'getSubjectChoiceForm')->name('getSubjectChoiceForm');
            Route::post('/subject-choice-form', 'postSubjectChoiceForm')->name('postSubjectChoiceForm');
            Route::post('/save', 'postSubjectChoiceSave')->name('postSubjectChoiceSave');
            Route::get('/complete', 'getSubjectChoiceComplete')->name('getSubjectChoiceComplete');
            Route::get('/{id}/show_details', 'showDetails')->name('showDetails');
            Route::get('/{id}/download', 'downloadChoiceForm')->name('downloadChoiceForm');
        });
    });

//========================= Hall Choice
Route::name('hall_choice.')->prefix('hall-choice')->middleware('auth-student')
    ->controller(HallChoiceController::class)
    ->group(function () {
        Route::middleware('verify-identity')->group(function () {
            Route::post('/{subject_option_id}/apply', 'apply')->name('apply');
            Route::get('/hall-choice-form', 'getHallChoiceForm')->name('getHallChoiceForm');
            Route::post('/hall-choice-form', 'postHallChoiceForm')->name('postHallChoiceForm');
            Route::post('/save', 'postHallChoiceSave')->name('postHallChoiceSave');
            Route::get('/complete', 'getHallChoiceComplete')->name('getHallChoiceComplete');

            Route::get('/{id}/show_details', 'showDetails')->name('showDetails');
            Route::get('/{id}/download', 'downloadHallChoiceForm')->name('downloadHallChoiceForm');
        });
    });


Route::name('hons_admission.')->prefix('hons-admission')->middleware('auth-student')
    ->controller(HonoursAdmissionController::class)
    ->group(function () {
        Route::post('/{subject_choice_id}/apply', 'apply')->name('apply');
        Route::get('/admission-form', 'getAdmissionForm')->name('getAdmissionForm');
        Route::post('/admission-form', 'postAdmissionForm')->name('postAdmissionForm');
        Route::post('/save', 'postAdmissionFormSave')->name('postAdmissionFormSave');
        Route::get('/{id}/show-form', 'showAdmissionForm')->name('showAdmissionForm');
        Route::get('/{id}/download', 'downloadAdmissionForm')->name('downloadAdmissionForm');

        // for opt-out
        Route::post('/{subject_choice_id}/postOptOut', 'postOptOut')->name('postOptOut');
        Route::get('/getStudentChoices', 'getStudentChoices')->name('getStudentChoices');
        Route::get('/{student_choice_id}/change-subject-choice/status/{status}', 'getChangeSubjectChoice')->name('getChangeSubjectChoice');
        Route::post('/change-subject-choice', 'postChangeSubjectChoice')->name('postChangeSubjectChoice');

        // for stop auto migration
        Route::post('/stop-migration/{subject_choice_id}/apply', 'postStopAutoMigrationApply')->name('postStopAutoMigrationApply');
        Route::get('/stop-migration/getStudentChoices', 'getMigrationStopDepartmentList')->name('getMigrationStopDepartmentList');
        Route::get('/stop-migration/{subject_choice_id}/stop', 'getMigrationStop')->name('getMigrationStop');
        Route::post('/stop-migration/postMigrationStop', 'postMigrationStop')->name('postMigrationStop');
    });

//=========================


Route::get('reset-all', function () {

    if (!config('app.debug')) {
        abort(404);
    }

    Bill::truncate();
    Enrollment::truncate();


    $reset_ids = [2179631];

    Hsc::whereIn('id', $reset_ids)
        ->update([
            'mobile_no'          => null,
            'email'              => null,
            'mobile_no_verified' => 0,
            'email_verified'     => 0,
            'photo'              => null,
            'SEQ_photo'          => null,
            'PDQ_photo'          => null,
            'WQ_photo'           => null,
            'FFQ_photo'          => null,
            'FFQ_type'           => null,
        ]);

    Enrollment::whereIn('applicant_id', $reset_ids)
        ->delete();
    Bill::whereIn('applicant_id', $reset_ids)
        ->delete();


    //    DB::update("ALTER TABLE `bills` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100001;");
    //    echo 'Bill Truncated <br>';
    //
    //    Enrollment::truncate();
    //    DB::update("ALTER TABLE `enrollments` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100001;");
    //    echo 'Enrollment Truncated <br>';
    //
    //    Application::truncate();
    //    DB::update("ALTER TABLE `applications` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100001;");
    //    echo 'Application Truncated <br>';

    session()->flush();


    return redirect()->back();
})->name('reset-all');

Route::get('change-settings', function () {

    abort(404);
    session()->flush();

    return redirect()->route('site.home');
})->name('change-settings');

Route::get('/{id}/check-mail', function ($id) {

    $students = Hsc::whereIn('id', [$id])->get();
    //dd($students);

    Notification::send($students, (new EmailAdmitCardNotification()));
});

// for selfie
Route::middleware(['verify-identity', 'selfie-change-allowed'])->group(function () {
    Route::get('selfie-index', [FinalApplicationController::class, 'getSelfieIndex'])->name('getSelfieIndex');
    Route::get('selfie-capture', [FinalApplicationController::class, 'getSelfieCapture'])->name('getSelfieCapture');
    Route::post('selfie-capture', [FinalApplicationController::class, 'postSelfieCapture'])->name('postSelfieCapture');
    Route::post('confirmation', [FinalApplicationController::class, 'getConfirmation'])->name('selfie_getConfirmation');

    //remote capture
    Route::get('selfie-qr', [FinalApplicationController::class, 'getSelfieQR'])->name('getSelfieQR');
    Route::get('remote-selfie-capture', [FinalApplicationController::class, 'getRemoteSelfieCapture'])->name('getRemoteSelfieCapture');
    Route::get('poll-selfie-uploaded/{time}', [FinalApplicationController::class, 'pollSelfieUploaded'])->name('pollSelfieUploaded');
});

Route::middleware(['selfie-change-allowed'])->group(function () {
    Route::get('remote-capture', [FinalApplicationController::class, 'processRemoteCaptureLink'])->name('processRemoteCaptureLink');
    Route::get('remote-capture-complete', [FinalApplicationController::class, 'remoteCaptureComplete'])->name('remoteCaptureComplete');
    Route::get('remote-capture-error', [FinalApplicationController::class, 'remoteCaptureError'])->name('remoteCaptureError');
});