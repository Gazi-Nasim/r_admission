<?php
// SSLCOMMERZ Start
//Route::get('/example1', ['as' => 'exampleEasyCheckout', 'uses' => 'SslCommerzPaymentController@exampleEasyCheckout']);
//Route::get('/example2', ['as' => 'exampleHostedCheckout', 'uses' => 'SslCommerzPaymentController@exampleHostedCheckout']);

use App\Http\Controllers\BkashPaymentController;
use App\Http\Controllers\RocketPaymentController;
use App\Library\RocketAPI;
use App\Library\TestBillPDF;
use App\Models\Bill;
use App\Models\Hsc;

Route::name('bkash.')->middleware('payment-allowed')
    ->prefix('bkash')
    ->controller(BkashPaymentController::class)
    ->group(function () {

        Route::post('/pay', 'pay')->name('pay');
        Route::any('/return', 'return')->name('return');
    });


Route::name('rocket.')->middleware('payment-allowed')
    ->prefix('rupayment')
    ->controller(RocketPaymentController::class)
    ->group(function () {

        Route::post('/pay', 'pay')->name('pay');
        Route::any('/return', 'return')->name('return');
    });


Route::get('demo', function () {

    if (!config('app.debug')) {
        abort(404);
    }

    $userIds = [10988755];

    $students = Hsc::find($userIds);
    return view('misc.demo', compact('students'));
});


Route::get('reset/{id}/{full}', function ($id, $full) {


    if (!config('app.debug')) {
        abort(404);
    }

    $student = Hsc::find($id);
    $student?->enrollments()->delete();

    if (!$full) {
        Bill::where('applicant_id', $student->id)
            ->update([
                'bkash_payment_id' => null,
                'trx_id'           => null,
                'payment_status'   => 0,
                'payment_method'   => null,
            ]);

        $student->selfie = null;
        $student->update();
        return $student->id.' partial reset successfully';

    } else {
        $student->bills()->delete();
        $student->photo              = null;
        $student->mobile_no          = null;
        $student->selfie             = null;
        $student->mobile_no_verified = 0;
        $student->email              = null;
        $student->email_verified     = 0;
        $student->FFQ_photo          = null;
        $student->FFQ_type           = null;
        $student->FFQ_number         = null;
        $student->PDQ_photo          = null;
        $student->SEQ_photo          = null;
        $student->WQ_photo           = null;
        $student->WQ_salary_id       = null;
        $student->save();


        return $student->id.' full reset successfully';
    }

})->name('reset');


Route::get('reset-final/{id}/{full}', function ($id, $full) {


    if (!config('app.debug')) {
        abort(404);
    }

    $student = Hsc::find($id);
    $student?->enrollments()->update([
        'status'  => 1,
        'applied' => 0
    ]);

    if (!$full) {
        Bill::where('applicant_id', $student->id)
            ->where('payment_status', '-1')
            ->orWhere('payment_purpose', 'P')
            ->delete();

        Bill::where('applicant_id', $student->id)
            ->where('payment_purpose', 'A')
            ->update([
                'bkash_payment_id' => null,
                'trx_id'           => null,
                'payment_status'   => 0,
                'payment_method'   => null,
            ]);


        return $student->id.' partial reset successfully';

    } else {
        $student->bills()->whereIn('payment_purpose', ['A', 'P'])->delete();
        $student->applications()->delete();
        $student->photoReviews()->delete();

        $student->mobile_no = '01911064969';
        $student->save();

        return $student->id.' full reset successfully';
    }

})->name('reset-final');

Route::get('bill-pdf', function () {
    if (!config('app.debug')) {
        abort(404);
    }
    TestBillPDF::makePDF(1220233);
});

Route::get('rocket', function () {

    if (!config('app.debug')) {
        abort(404);
    }

    $bill = Bill::find(1220233);

    $transaction = [
        "billId"    => $bill->id,
        "amount"    => $bill->amount,
        "mobile_no" => $bill->student->mobile_no,
        "name"      => $bill->student->NAME,
    ];

    $api = new RocketAPI();

    $rocketPayment = $api->createPayment($transaction);


    if ($rocketPayment) {
        $bill->rocket_payment_id = $rocketPayment->payment_id;
        $bill->rocket_trx_id     = null;
        $bill->save();

        return '<a href="'.$rocketPayment->payment_url.'">Pay Now</a>';
        return redirect($rocketPayment->payment_url);
    }


});
