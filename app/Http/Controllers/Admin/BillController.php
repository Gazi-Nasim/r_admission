<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\BillPDF;
use App\Library\BkashApi;
use App\Library\RocketApi;
use App\Models\Bill;
use App\Models\PaymentLog;
use App\Services\RocketBillPayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class BillController extends Controller
{
    public function index()
    {
        $status = [
            '0'  => 'Pending',
            '1'  => 'Paid',
            '-1' => 'Canceled'
        ];

        $purposes = [
            'E' => 'Preliminary',
            'A' => 'Application',
            'P' => 'Photo'
        ];


        return view('admin.bill.index')
            ->with('status', $status)
            ->with('purposes', $purposes);
    }

    public function search(Request $request)
    {
        $db = new Bill;

        if ($request->filled('bill_id'))
            $db = $db->where('id', 'like', '%'.$request->input('bill_id').'%');

        if ($request->filled('applicant_id'))
            $db = $db->where('applicant_id', $request->input('applicant_id'));

        if ($request->filled('bkash_trx_id'))
            $db = $db->where('trx_id', $request->input('bkash_trx_id'));

        if ($request->filled('rocket_payment_id'))
            $db = $db->where('rocket_payment_id', $request->input('rocket_payment_id'));

        if ($request->filled('payment_status'))
            $db = $db->where('payment_status', $request->input('payment_status'));

        if ($request->filled('payment_purpose'))
            $db = $db->where('payment_purpose', $request->input('payment_purpose'));


        $data = $db->paginate(30)->withQueryString();

        return view('admin.bill.search_result')
            ->with('data', $data);
    }

    public function getDownloadBill(Bill $bill)
    {

        $path = Storage::path('public/downloads/'.$bill->id.'.pdf');

        if ($bill->payment_purpose == 'E') {
            $file_path = BillPDF::makePreliminaryBillPDF($bill->id);
        } else if ($bill->payment_purpose == 'A') {
            $file_path = BillPDF::makeApplicationBillPDF($bill->id);
        } else if ($bill->payment_purpose == 'P') {
            $file_path = BillPDF::makePhotoChangeBillPDF($bill->id);

        } else {

        }


        if (Storage::exists($file_path)) {
            $headers = [
                'Content-Type: application/pdf',
            ];

            ob_end_clean();
            return response()->download(Storage::path($file_path), "bill-{$bill->id}.pdf", $headers);
        } else {
            abort(404);
        }

    }

    public function showDetails(Bill $bill)
    {
        return view('admin.bill.show_details')
            ->with('bill', $bill);
    }

    public function postBkashQuery(Bill $bill)
    {
        if (empty($bill->bkash_payment_id)) {
            return
                '<p class="alert alert-danger">No bkash payment id found.</p>';
        }

        $service       = new BkashApi();
        $bkashResponse = $service->queryPayment($bill->bkash_payment_id);

        return view('admin.bill.bkash_response')
            ->with('bkashResponse', $bkashResponse)
            ->with('bill', $bill);

    }


    public function postRocketQuery(Bill $bill)
    {

        if (empty($bill->rocket_payment_id)) {
            return
                '<p class="alert alert-danger">No Rocket payment id found.</p>';
        }

        $service        = new RocketApi();
        $rocketResponse = $service->queryPayment($bill->rocket_payment_id);


        return view('admin.bill.rocket_response')
            ->with('rocketResponse', $rocketResponse)
            ->with('bill', $bill);

    }

    public function edit(Bill $bill)
    {
        $columns = Schema::getColumnListing($bill->getTable());

        //exclude columns
        $columns = array_diff($columns, ['quota', 'quota_docs', 'FFQ_type', 'mobile_no']);

        return view('admin.bill.edit_bill')
            ->with('columns', $columns)
            ->with('bill', $bill);
    }


    public function update(Request $request)
    {
        $inputs = $request->except('_token');

        if (!$request->filled('id')) {
            return 'Some Error Occurred';
        }

        $bill = Bill::findOrFail($inputs['id']);

        $bill->update($inputs);

        return redirect()->route('admin.bill.showDetails', $bill);
    }

    public function postAdminBillPayment(Request $request)
    {
        $bill = Bill::findOrFail($request->bill_id);

        switch ($bill->payment_status) {
            case 1:
                return "bill already paid";
            case -1:
                return "bill canceled";
            default:
                break;
        }

        $payment_method = $request->payment_method;

        $billPayService = new RocketBillPayService();
        $paid           = $billPayService->payBill($bill, $payment_method);

        if ($paid) {
            return "Bill successfully paid";
        } else {
            return "error in postAdminBillPayment";
        }

    }

    public function viewPaymentLog($bill, $provider)
    {
        $paymentLogs = PaymentLog::where('bill_id', $bill)
            ->where('payment_method', $provider)
            ->where('bill_id', $bill)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.bill.payment_log')
            ->with('paymentLogs', $paymentLogs)
            ->with('payment_method', $provider)
            ->with('bill', $bill);

    }

    public function getRocketPaymentInfo($paymentId)
    {
        $paymentLog = PaymentLog::findOrFail($paymentId);

        $api      = new RocketApi();
        $response = $api->queryPayment($paymentLog->payment_id);


        return view('admin.bill.log_response_rocket')
            ->with('rocketResponse', $response)
            ->with('paymentLog', $paymentLog);

    }


    public function getBkashPaymentInfo($paymentId)
    {
        $paymentLog = PaymentLog::findOrFail($paymentId);
        $api        = new BkashApi();
        try {
            $response = $api->queryPayment($paymentLog->payment_id);

            return view('admin.bill.log_response_bkash')
                ->with('bkashResponse', $response)
                ->with('paymentLog', $paymentLog);

            $trxID                  = $response?->trxID ?? 'N/A';
            $transactionStatus      = $response?->transactionStatus;
            $verificationStatus     = $response?->verificationStatus;
            $transactionStatusLabel = sprintf('<span class="label label-warning">%s</span>', $transactionStatus);

            return 'TrxID:'.$trxID.' | T:'.$transactionStatusLabel.' | V:'.$verificationStatus;

        } catch (Exception $e) {
            return $e->getMessage();
        }


    }

    public function updatePaymentId(Request $request)
    {
        $paymentLog = PaymentLog::findOrFail($request->paymentId);

        $bill = Bill::findOrFail($paymentLog->bill_id);

        $newLog          = new  PaymentLog;
        $newLog->bill_id = $bill->id;
        if ($paymentLog->payment_method == 'R') {
            $newLog->payment_id = $bill->rocket_payment_id;
        } else if ($paymentLog->payment_method == 'B') {
            $newLog->payment_id = $bill->bkash_payment_id;
        }
        $newLog->payment_method = $paymentLog->payment_method;
        $newLog->save();

        if ($paymentLog->payment_method == 'R') {
            $bill->rocket_payment_id = $paymentLog->payment_id;
            $bill->save();
        } else if ($paymentLog->payment_method == 'B') {
            $bill->bkash_payment_id = $paymentLog->payment_id;
            $bill->save();
        }


        $data = 'Updated: '.$newLog->payment_id.'=>'.$paymentLog->payment_id;
        return sprintf('<label class="label label-success">%s</label>', $data);

    }


}
