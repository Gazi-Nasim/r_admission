<?php

namespace App\Http\Controllers;

use App\Library\BkashApi;
use App\Models\Bill;
use App\Models\PaymentLog;
use App\Services\BkashBillPayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BkashPaymentController extends Controller
{
    private BkashBillPayService $bkashBillPayService;
    private BkashApi $bkashApi;

    public function __construct(BkashBillPayService $bkashBillPayService, BkashApi $bkashApi)
    {
        $this->bkashBillPayService = $bkashBillPayService;
        $this->bkashApi            = $bkashApi;
    }

    public function pay(Request $request)
    {
        $bill = Bill::findOrFail($request->bill_id);

        // if bill already paid initiate success procedure
        if ($bill->payment_status == '1') {
            return view('bkash.success')
                ->with('bill', $bill);
        }

        try {

            if (!empty($bill->bkash_payment_id)) {
                $bkashPayment = $this->bkashApi->queryPayment($bill->bkash_payment_id);

                if ($bkashPayment?->verificationStatus === 'Complete') {
                    return $this->processSuccessResponse($bill, $bkashPayment);
                }
            }


            // if new transaction
            $transaction = [
                "billId"   => $bill->id,
                "amount"   => $bill->amount,
                "payerRef" => $bill->applicant_id
            ];

            $bkashPayment = $this->bkashApi->createPayment($transaction);

            if ($bkashPayment) {

                try {
                    PaymentLog::create([
                        'bill_id'        => $bill->id,
                        'payment_id'     => $bkashPayment->paymentID,
                        'payment_method' => 'B',
                        'created_at'     => now(),
                    ]);
                } catch (Exception $e) {
                    Log::error('Log Creation Failed: ' . $e->getMessage());
                }

                $bill->bkash_payment_id = $bkashPayment->paymentID;
                $bill->trx_id           = null;
                $bill->save();

                return redirect($bkashPayment->bkashURL);
            }

        } catch (Exception $e) {
            return $this->error($bill, $e->getMessage());
        }

    }

    public function processSuccessResponse(Bill $bill, $bkashPayment = null)
    {
        // if bill already paid show success page
        if ($bill->payment_status === '1') {
            return view('bkash.success')
                ->with('bill', $bill);
        }

        // try to execute payment
        try {

            $result = $this->bkashApi->executePayment($bill->bkash_payment_id);

        } catch (Exception $e) { // if failed

            //query payment
            $result = $this->bkashApi->queryPayment($bill->bkash_payment_id);
            // if payment is completed in Bkash end then
            // update the bill and enrollment and show success page

            if ($result?->transactionStatus == 'Completed') {
                $paid = $this->bkashBillPayService->payBill($bill, $result->trxID);
                return view('bkash.success')
                    ->with('bill', $bill);
            }

            // otherwise reset the transaction
            $bill->bkash_payment_id = null;
            $bill->save();
            return $this->error($bill, $e->getMessage());
        }

        try {
            if ($result?->transactionStatus == 'Completed') {

                $paid = $this->bkashBillPayService->payBill($bill, $result->trxID);

                return view('bkash.success')
                    ->with('bill', $bill);
            }

        } catch (Exception $e) {
            return $this->error($bill, $e->getMessage());
        }


        return view('bkash.fail')
            ->with('bill', $bill)
            ->with('error', 'Payment Failed!!');
    }

    public function error($bill, $errorMsg)
    {
        return view('bkash.error')
            ->with('bill', $bill)
            ->with('error', $errorMsg);

    }

    public function return(Request $request)
    {

        $bill = Bill::where('bkash_payment_id', $request->paymentID)
            ->firstOrFail();

        switch ($request->status) {
            case 'success':
                try {
                    return $this->processSuccessResponse($bill);
                } catch (Exception $e) {
                    return $this->error($bill, $e->getMessage());
                }
                break;
            case 'failure':
                return $this->processFailureResponse($bill);

                break;
            case 'cancel':
                return $this->processCancelResponse($bill);
                break;
        }
    }

    private function processFailureResponse($bill)
    {
        if ($bill->payment_status == '1') {
            return view('bkash.success')
                ->with('bill', $bill)
                ->with('studetn', $bill->student);
        }

        return view('bkash.fail')
            ->with('bill', $bill)
            ->with('error', 'Payment Failed!!');

    }

    public function processCancelResponse($bill)
    {
        if ($bill->payment_status == '1') {
            return view('bkash.success')
                ->with('bill', $bill);
        }

        return view('bkash.cancel')
            ->with('bill', $bill)
            ->with('error', 'Payment Cancelled!!');


    }


}
