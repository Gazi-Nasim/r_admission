<?php
//user login facility

use App\Http\Controllers\Admin\AdmitCardController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\ComplainBoxController;
use App\Http\Controllers\Admin\ControlRoomController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MiscController;
use App\Http\Controllers\Admin\MobileChangeController;
use App\Http\Controllers\Admin\OthController;
use App\Http\Controllers\Admin\PageContentsController;
use App\Http\Controllers\Admin\PhotoCheckController;
use App\Http\Controllers\Admin\PhotoReviewController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UnitOfficeController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('authx/login', [UserController::class, 'getLogin'])->name('user.getLogin');
Route::post('authx/login', [UserController::class, 'postLogin'])->name('user.postLogin');

Route::name('user.')->prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('change-password', [UserController::class, 'getChangePassword'])->name('getChangePassword');
    Route::post('change-password', [UserController::class, 'postUpdatePassword'])->name('postUpdatePassword');
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

});

Route::name('admin.')->prefix('admin')->middleware('auth')->group(function () {

    // Admin/OthController
    Route::name('oth.')->prefix('oth')->controller(OthController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'search')->name('search');
        Route::get('/{student}/show', 'show')->name('show');
        Route::post('/update_status', 'updateStatus')->name('updateStatus');
    });

    // Admin/StudentController
    Route::name('student.')->prefix('student')->controller(StudentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'search')->name('search');
        Route::get('/{student}/show', 'show')->name('show');
        Route::get('/{student}/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::post('/{student}/board-lookup', 'boardLookup')->name('boardLookup');

        Route::get('/{student}/edit_mobile', 'editMobile')->name('editMobile');
        Route::post('/update_mobile', 'updateMobile')->name('updateMobile');

        Route::get('/{student}/edit_quota', 'editQuota')->name('editQuota');
        Route::post('/upload_quota_photo', 'updateQuotaPhoto')->name('updateQuotaPhoto');

        Route::get('{id}/upload_photo', 'uploadStudentPhoto')->name('uploadStudentPhoto');
        Route::post('upload_photo', 'saveStudentPhoto')->name('saveStudentPhoto');
        Route::post('update_photo', 'updateStudentPhoto')->name('updateStudentPhoto');

        Route::post('{student}/clear_quotas', 'clearQuotas')->name('clearQuotas');

        Route::post('/update_from_board', 'updateFromBoard')->name('updateFromBoard');
        Route::get('{application}/show-application', 'showApplication')->name('showApplication');
        Route::get('{application}/download-admitcard', 'getDownloadAdmitCard')->name('getDownloadAdmitCard');
        Route::get('{subjectOption}/show-subjectOption', 'showSubjectOption')->name('showSubjectOption');
        Route::get('{subjectOption}/download-choiceForm', 'downloadSubjectChoiceForm')->name('downloadSubjectChoiceForm');

        Route::get('{subjectOption}/show-honsAdmissionForm', 'showHonsAdmissionForm')->name('showHonsAdmissionForm');
        Route::get('{subjectOption}/download-honsAdmissionForm', 'downloadHonsAdmissionForm')->name('downloadHonsAdmissionForm');

        Route::get('{student}/login-as-student', 'loginAsStudent')->name('loginAsStudent');
        Route::get('login-as-student', 'logoutAsStudent')->name('logoutAsStudent');

        Route::get('{student}/all-images', 'allImages')->name('allImages');
        Route::post('{student}/temp-selfie', 'postTempSelfie')->name('postTempSelfie');
        Route::post('{student}/restore-image', 'postRestoreImage')->name('postRestoreImage');

    });

    // Admin/AdmitCardController
    Route::name('admitCard.')->prefix('admitCard')
        ->controller(AdmitCardController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/search', 'search')->name('search');

        });

    //bills
    Route::name('bill.')->prefix('bill')->controller(BillController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'search')->name('search');
        Route::get('{bill}/download-bill', 'getDownloadBill')->name('getDownloadBill');

        Route::get('{bill}/show-details', 'showDetails')->name('showDetails');

        Route::get('{bill}/edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');

        Route::post('bkash/{bill}/query', 'postBkashQuery')->name('postBkashQuery');
        Route::post('rocket/{bill}/query', 'postRocketQuery')->name('postRocketQuery');

        Route::post('admin/pay', 'postAdminBillPayment')->name('postAdminBillPayment');

        Route::get('view-payment-log/{bill}/{provider}', 'viewPaymentLog')->name('viewPaymentLog');
        Route::get('getRocketPaymentInfo/{paymentID}', 'getRocketPaymentInfo')->name('getRocketPaymentInfo');
        Route::get('getBkashPaymentInfo/{paymentID}', 'getBkashPaymentInfo')->name('getBkashPaymentInfo');

        Route::post('update-paymentId', 'updatePaymentId')->name('updatePaymentId');


    });

    //complain box
    Route::name('complainbox.')->prefix('complainbox')
        ->controller(ComplainBoxController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/search', 'search')->name('search');
            Route::get('/{id}/show', 'show')->name('show');
            Route::post('/update_status', 'updateStatus')->name('updateStatus');

            Route::post('/update_from_student', 'updateSscDataFromStudent')->name('updateSscDataFromStudent');
            Route::get('/{id}/view-ssc-data', 'viewSscData')->name('viewSscData');
        });


    //photo checkk
    Route::name('photo_review.')->prefix('photo-review')
        ->controller(PhotoReviewController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/search', 'search')->name('search');
            Route::get('/{id}/show', 'show')->name('show');
            Route::post('/{id}/update_status', 'updateStatus')->name('updateStatus');
        });


    //settings
    Route::name('settings.')->prefix('settings')
        ->middleware('role:Admin')
        ->controller(SettingsController::class)
        ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/save', 'save')->name('save');
    });

    //SmsSender
    Route::name('sms.')->prefix('sms')->group(function () {
        Route::get('/', [SmsController::class, 'index'])->name('index');
        Route::post('/', [SmsController::class, 'send'])->name('send');
    });

    // user management
    Route::name('user.')->prefix('user')->controller(UserManagementController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'search')->name('search');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::post('/delete', 'delete')->name('delete');
    });

    // photo check
    Route::name('photo_check.')->prefix('photo-check')->controller(PhotoCheckController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/get/{board}', 'getPhotos')->name('getPhotos');
        Route::post('/set-status/{hsc_id}/{status}', 'setStatus')->name('setStatus');
        Route::get('/rejected-photo', 'indexRejectedPhoto')->name('indexRejectedPhoto');
        Route::get('/rejected-selfie', 'indexRejectedSelfie')->name('indexRejectedSelfie');
    });

    //mobile change
    Route::name('mobile-change.')->prefix('mobile_change')
        ->middleware('role:Admin')
        ->controller(MobileChangeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/search', 'search')->name('search');
            Route::get('/{id}/show', 'show')->name('show');
            Route::post('/update_status', 'updateStatus')->name('updateStatus');
        });


    Route::name('misc.')->prefix('misc')->controller(MiscController::class)->group(function () {
        Route::get('/photo-missing', 'photoMissing')->name('photoMissing');
        Route::get('/quota-photo-missing', 'quotaPhotoMissing')->name('quotaPhotoMissing');
        Route::get('{type}/clear-data/', 'clearData')->name('clearData');

        Route::get('captured-photos', 'capturedPhotos')->name('capturedPhotos');


    });

    Route::name('log.')->prefix('log')->controller(LogController::class)->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('{file}/download', 'download')->name('download');
        Route::get('{file}/view', 'view')->name('view');
    });
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class,'index'])->name('vendor.log-viewer');

    Route::name('cms.')->prefix('cms')->middleware('auth')->group(function () {
        Route::get('/', [PageContentsController::class,'index'])->name('index');
        Route::get('{pageContent}/edit', [PageContentsController::class,'edit'])->name('edit');
        Route::post('{pageContent}/update', [PageContentsController::class,'update'])->name('update');
        Route::post('{pageContent}/publish', [PageContentsController::class,'publish'])->name('publish');
    });




});


Route::name('unit-office.')->prefix('unit-office')->middleware('auth')->group(function () {
    Route::get('/approve-student', [UnitOfficeController::class,'getApproveStudent'])->name('getApproveStudent');
    Route::post('/approve-student', [UnitOfficeController::class,'postApproveStudent'])->name('postApproveStudent');
    Route::get('/cancel-student', [UnitOfficeController::class,'getCancelStudent'])->name('getCancelStudent');
    Route::post('/cancel-student', [UnitOfficeController::class,'postCancelStudent'])->name('postCancelStudent');

    Route::get('/{subject_option_id}/status/{status}/change-status', [UnitOfficeController::class,'getChangeStatus'])->name('getChangeStatus');
    Route::post('/change-status', [UnitOfficeController::class,'postChangeStatus'])->name('postChangeStatus');

    Route::get('/download-student-data', [UnitOfficeController::class,'getDownloadStudentData'])->name('downloadStudentData');
    Route::get('/{subjectOptionId}/download-admission-form', [UnitOfficeController::class,'downloadAdmissionForm'])->name('downloadAdmissionForm');
});


Route::name('controlRoom.')
    ->prefix('control-room')
    ->controller(ControlRoomController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('dashboard', 'getDashboard')->name('getDashboard');
        Route::post('student-info', 'postAdmissionRoll')->name('postAdmissionRoll');
        Route::get('student-info',  'getStudentInfo')->name('getStudentInfo');
        Route::get('student-photo-capture','getStudentPhotoCapture')->name('getStudentPhotoCapture');
        Route::post('student-photo-capture','postStudentPhotoCapture')->name('postStudentPhotoCapture');
        Route::get('student-photo-capture-complete','photoCaptureComplete')->name('photoCaptureComplete');
    });

Route::get('/{admissionRoll}/info-verify', [ControlRoomController::class, 'studentInfoVerify'])->name('admin.misc.studentInfoVerify');
