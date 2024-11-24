<?php

namespace App\Http\Controllers;

use App\Library\RocketApi;
use App\Models\Bill;
use App\Models\PaymentLog;
use App\Services\RocketBillPayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RocketPaymentController extends Controller
{
    private RocketBillPayService $rocketBillPayService;
    private RocketApi $rocketApi;

    public function __construct(RocketBillPayService $rocketBillPayService, RocketApi $rocketApi)
    {
        $this->rocketBillPayService = $rocketBillPayService;
        $this->rocketApi            = $rocketApi;
    }

    public function pay(Request $request)
    {

        $bill = Bill::findOrFail($request->bill_id);

        // if bill already paid initiate success procedure
        if ($bill->payment_status == '1') {
            return view('rocket.success')
                ->with('bill', $bill);
        }

        try {

            if (!empty($bill->rocket_payment_id)) {
                $rocketPayment = $this->rocketApi->queryPayment($bill->rocket_payment_id);

                if ($rocketPayment?->status_code == '1') {
                    return $this->processSuccessResponse($bill);
                }
            }


            // if new transaction
            $transaction = [
                "billId"    => $bill->id,
                "amount"    => $bill->amount,
                "mobile_no" => $bill->student->mobile_no,
                "name"      => $bill->student->NAME,
            ];

            $rocketPayment = $this->rocketApi->createPayment($transaction);

            if ($rocketPayment) {
                try {
                    PaymentLog::create([
                        'bill_id'        => $bill->id,
                        'payment_id'     => $rocketPayment->payment_id,
                        'payment_method' => 'R',
                        'created_at'     => now(),
                    ]);
                } catch (Exception $e) {
                    Log::error('Log Creation Failed: ' . $e->getMessage());
                }

                $bill->rocket_payment_id = $rocketPayment->payment_id;
                $bill->rocket_trx_id     = null;
                $bill->save();

                return redirect($rocketPayment->payment_url);
            }

        } catch (Exception $e) {
            return $this->error($bill, $e->getMessage());
        }

    }

    public function processSuccessResponse(Bill $bill)
    {
        // if bill already paid show success page
        if ($bill->payment_status === '1') {
            return view('rocket.success')
                ->with('bill', $bill);
        }

        // query payment
        try {

            $result = $this->rocketApi->queryPayment($bill->rocket_payment_id);

            if ($result?->status_code == '1') {

                $paymentMethod = $result->payment_method ?? 'R';

                $paid = $this->rocketBillPayService->payBill($bill, $paymentMethod);
                return view('rocket.success')
                    ->with('bill', $bill);
            }


        } catch (Exception $e) { // if failed

            // otherwise reset the transaction
            $bill->rocket_payment_id = null;
            $bill->save();
            return $this->error($bill, $e->getMessage());
        }

        return view('rocket.fail')
            ->with('bill', $bill)
            ->with('error', 'Payment Failed!!');
    }

    public function error($bill, $errorMsg)
    {
        return view('rocket.error')
            ->with('bill', $bill)
            ->with('error', $errorMsg);

    }

    public function return(Request $request)
    {
//        failed = [
//            "status_code"    => "3",
//            "status_message" => "Failed",
//            "payment_id"     => "1017",
//            "bill_id"        => "1220233",
//            "payment_method" => "bKash|Rocket",
//        ];

//        $success = [
//            "status_code"    => "1",
//            "status_message" => "Successful",
//            "payment_id"     => "1018",
//            "bill_id"        => "1220233"
//            "payment_method" => "bKash|Rocket",
//        ];


        $bill = Bill::where('rocket_payment_id', $request->payment_id)
            ->where('id', $request->bill_id)
            ->firstOrFail();


        switch ($request->status_code) {
            case '1'://success
                try {
                    return $this->processSuccessResponse($bill);
                } catch (Exception $e) {
                    return $this->error($bill, $e->getMessage());
                }
                break;
            case '2'://cancel
                return $this->processCancelResponse($bill);
                break;
            case '3': //failed
                return $this->processFailureResponse($bill);

                break;
        }
    }

    public function processCancelResponse($bill)
    {
        if ($bill->payment_status == '1') {
            return view('rocket.success')
                ->with('bill', $bill);
        }

        return view('rocket.cancel')
            ->with('bill', $bill)
            ->with('error', 'Payment Cancelled!!');


    }

    private function processFailureResponse($bill)
    {
        if ($bill->payment_status == '1') {
            return view('rocket.success')
                ->with('bill', $bill)
                ->with('student', $bill->student);
        }

        return view('rocket.fail')
            ->with('bill', $bill)
            ->with('error', 'Payment Failed!!');

    }


}
