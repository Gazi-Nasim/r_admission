<?php

namespace App\Http\Controllers;

use App\Library\BillPDF;
use App\Models\Bill;
use App\Services\BillPayService;

class BillPayController extends Controller
{
    /**
     * @var BillPayService
     */
    private $billPayService;

    public function __construct(BillPayService $billPayService)
    {
        $this->billPayService = $billPayService;
    }


    public function check_bill($bill_no, $amount)
    {

        $bill = Bill::find($bill_no);

        // return code
        // 	'0' => 'OK',
        // '01' => 'Invalid Basic Authentication',
        // '02' => 'Invalid Host Authentication',
        // '03' => 'Invalid Authentication',
        // '04' => 'Invalid Operation Code',
        // '05' => 'Biller Short Code Missing',
        // '06' => 'User Id Missing',
        // '07' => 'Password Missing',
        // '08' => 'Operation Code Missing',
        // '09' => 'Bill Number Missing',
        // '10' => 'Bill Amount Missing',
        // '11' => 'Invalid Bill Amount',
        // '13' => 'Txn Id Missing',
        // '14' => 'Invalid Bill Number',
        // '15' => 'Invalid Payment',
        // '16' => 'Invalid Application',
        // '17' => 'Bill Already Paid'
        //

        if (!$bill) {
            return '14';
        } else {
            if ($bill->amount != $amount || $bill->payment_status != '0') {
                return '11';
            } else {
                return '0';
            }
        }

    }

    public function process_bill($bill_no, $payment_method)
    {

        /*$payment_types = [
            'R' => 'ROCKET',
            'B' => 'BKASH',
            'S' => 'SURECASH',
            'N' => 'NAGAD'
        ];*/

        $bill = Bill::find($bill_no);

        if (!$bill) {
            return 'Bill not found';
        }

        switch ($bill->payment_status) {
            case '1':
                return 'bill already paid';
                break;

            case '-1':
                return 'bill was canceled';
                break;

            case '0': //pay bill

                switch ($bill->payment_purpose) {
                    case 'E':
                        $bill_paid = $this->billPayService->payEnrollmentBill($bill, $payment_method);

                        // make the bill photo permanent for the student.
                        if ($bill_paid) {
                            // update  photo
                            $this->billPayService->updateEnrollmentPhotos($bill);

                            //regenerate bill
                            BillPDF::makePreliminaryBillPDF($bill->id);

                            //queue an sms for sending to the student
                            //todo: send sms
//                                $sms_text = sprintf("Bill No. %s is paid. Your application for unit %s is now complete.",
//                                    $bill->id, $bill->units);
//                                RUSms::queueSms($bill->mobile_no, $sms_text);
                        } else {
                            return 'internal error in E';
                        }
                        break;
                    case 'A':
                        //todo: pay admission bill
                        $bill_paid = $this->billPayService->payApplicationBill($bill, $payment_method);

                        if ($bill_paid) {

                            //regenerate bill
                            BillPDF::makeApplicationBillPDF($bill->id);

                            //queue an sms for sending to the student
                            //todo applicatation complete sms
                        } else {
                            return 'internal error in A';
                        }

                        break;
                    case 'P':
                        //todo: pay photo-change payment bill
                        // admin will be notified of payment
                        // photo will be processed after verification
                        $bill_paid = $this->billPayService->payPhotoChangeBill($bill, $payment_method);

                        if ($bill_paid) {
                            //regenerate bill
                            BillPDF::makePhotoChangeBillPDF($bill->id);
                        } else {
                            return 'internal error in photo';
                        }

                        break;
                    case 'R':
                        //todo: pay registration bill
                        $bill_paid = $this->billPayService->payRegistrationBill($bill, $payment_method);

                        if (!$bill_paid) {
                            return 'Unknown error';
                        }

                        break;
                    default:
                        return 'Unknown error';
                        break;
                }

                return 'bill paid';
                break;

            default:
                return 'Unknown error';
                break;
        }

    }


}
