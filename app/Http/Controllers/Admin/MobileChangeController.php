<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\GstSms;
use App\Library\RUSms;
use App\Models\MobileChange;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MobileChangeController extends Controller
{
    public function index()
    {

        $status = ['A' => 'Accepted', 'R' => 'Rejected'];

        $mobile_changes = MobileChange::with('applicant')
            ->status(null)
            ->take(50)->get();


        return view('admin.mobile_change.index')
            ->with('status', $status)
            ->with('mobile_changes', $mobile_changes);
    }

    public function search(Request $request)
    {
        $input = $request->all();

        $mobile_changes = new MobileChange;

        if ($request->filled('applicant_id')) {
            $mobile_changes = $mobile_changes->where('applicant_id', '=', $input['applicant_id']);
        }

        if ($request->filled('mobile_no')) {
            $mobile_changes = $mobile_changes->where('new_mobile_no', '=', $input['mobile_no']);
        }

        if ($request->filled('app_date')) {
            $from_date = Carbon::createFromFormat('Y-m-d', $input['app_date'])->startOfDay();
            $to_date   = $from_date->copy()->addDay();

            $mobile_changes = $mobile_changes->
            whereBetween('created_at', [$from_date, $to_date]);
        }


        if ($request->filled('status')) {
            $mobile_changes = $mobile_changes->where('status', '=', $input['status']);
        } else {
            $mobile_changes = $mobile_changes->whereNull('status');
        }

        $mobile_changes = $mobile_changes->with('applicant')
            ->paginate(15)->withQueryString();


        return view('admin.mobile_change.search_result')
            ->with('mobile_changes', $mobile_changes);
    }


    public function show($id)
    {
        $mobile_change = MobileChange::find($id);

        $mobile_change_count = MobileChange::where('applicant_id', $mobile_change->applicant_id)
            ->where('status', 'A')
            ->count();


        if (!$mobile_change) {
            return view('admin.mobile_change.show')
                ->with('success', 0);
        }


        return view('admin.mobile_change.show')
            ->with('mobile_change', $mobile_change)
            ->with('mobile_change_count', $mobile_change_count)
            ->with('success', 1);

    }


    public function updateStatus(Request $request)
    {

        $input = $request->all();

        $rules = [
            'status' => 'required',
        ];

        $validation = Validator::make($input, $rules);


        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }


        $mobile_change = MobileChange::findOrFail($input['id']);

        try {

            //if found
            if ($mobile_change) {
                //update status
                $mobile_change->checked_by = auth()->user()->id;
                $mobile_change->status     = $input['status'];
                if ($request->filled('comment')) {
                    $mobile_change->comment = $input['comment'];
                }
                $mobile_change->save();


                // if accepted
                if ($input['status'] == 'A') {
                    //if approve then update master data and replace photo
                    //$photo_review = PhotoReview::find($id);

                    $applicant            = $mobile_change->applicant;
                    $applicant->mobile_no = $mobile_change->new_mobile_no;
                    $applicant->save();

                    $msg       = $applicant->NAME.", Your mobile no. has been updated.\r\n-RU";

                    RUSms::sendSms($mobile_change->new_mobile_no, $msg, 'RU');
                    RUSms::sendSms($mobile_change->old_mobile_no, $msg, 'RU');


                    return redirect()->route('admin.mobile-change.show', $mobile_change->id)
                        ->withInput()
                        ->with('message', 'Data Updated');
                } else {
                    if ($input['status'] == 'R') {//rejected

                        // //upted status in photo_check table to 'R'
                        // $this->ChangePhotoStatus($photo_review->tracking_no,'R');

                        // // free the transaction for reuse
                        // $this->freeTrx($photo_review->trxid, $photo_review->payment_method);

                        // //send reject sms
                        // $this->SendSMS($photo_review->mobile_no,'R');

                        $applicant = $mobile_change->applicant;
                        $msg       = $applicant->NAME.", Your mobile change application is rejected.\r\n-RU";

                        RUSms::sendSms($mobile_change->old_mobile_no, $msg,'RU');
                        RUSms::sendSms($mobile_change->new_mobile_no, $msg,'RU');


                        return redirect()->route('admin.mobile-change.show', $mobile_change->id)
                            ->withInput()
                            ->with('message', 'Application Rejected');
                    }
                }
            } else {
                return 'Request already processed';
            }

        } catch (Exception $e) {
            Log::error('Mobile No change failed', ['context' => $e]);
            return 'Something went wrong';
        }


    }


    public function update_meeting(Request $request)
    {

        $input = $request->all();
        $rules = [
            'meeting_link' => 'url',
            'meeting_time' => 'required_with:meeting_link|date_format:Y-m-d H:i',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->passes()) {
            $mobile_change = MobileChange::findOrFail($input['id']);
            if (!empty($input['meeting_link'])) {
                $mobile_change->meeting_url = $input['meeting_link'];
            } else {
                $mobile_change->meeting_url = null;
            }

            if (!empty($input['meeting_link'])) {
                $mobile_change->meeting_time = $input['meeting_time'];
            } else {
                $mobile_change->meeting_time = null;
            }

            $mobile_change->checked_by = auth()->user()->id;
            $mobile_change->save();

            $SMSmsg = sprintf("Join Zoom meeting at %s using %s for mobile number change",
                $mobile_change->meeting_time, $mobile_change->meeting_url);
            // send only in production mode
            GstSms::sendSms($mobile_change->new_mobile_no, $SMSmsg);

            $msg = '<div class="alert alert-success" >';
            $msg .= sprintf('<i class="fa fa-check-circle"></i> Update Successful');
            $msg .= '</div >';

            return $msg;

        } else {


            $msg = '<div class="alert alert-danger" >';
            $msg .= '<ul>';
            foreach ($validation->errors()->all() as $error) {
                $msg .= sprintf('<li>%s</li>', $error);
            }
            $msg .= '</ul>';
            $msg .= '</div >';

            return $msg;
        }

    }

//	private function SendSMS($mobile_number, $status)
//	{
//		Log::info('Photo Review-Sending SMS to :'.$mobile_number);
//
//		if ($status=='A') {
//			$msg = 'Your photo has been Updated.';
//			RUSms::sendSms($mobile_number, $msg, 'Photo Change A' );
//		}
//		elseif($status=='R') {
//			$msg = 'Your photo change request has been rejected. Contact RU E–Admission Cell for details';
//			RUSms::sendSms($mobile_number, $msg, 'Photo Change R' );
//		}
//	}
//
//	private function ChangePhotoStatus($tracking_no, $status)
//	{
//		$photoCheck = PhotoCheck::firstOrCreate(['tracking_no' => $tracking_no]);
//
//		$photoCheck->tracking_no = $tracking_no;
//		$photoCheck->hsc_board = NameResolve::trackingNoToBoardName($tracking_no);
//		$photoCheck->status = $status;
//		$photoCheck->checked_by = Auth::user()->id;
//
//		$photoCheck->save();
//	}
//
//	private function freeTrx($trx_id, $payment_method)
//	{
//		$trx = Transaction::where('trx_id' , $trx_id)
//					->where('payment_method', $payment_method)
//					->first();
//
//		// if trx found
//		if($trx){
//			$trx->delete();
//		}
//	}
//
//	private function regenerateAdmitCard($tracking_no)
//	{
//		$applications = DB::table('admit_card')
//							->where('tracking_no', $tracking_no)->get();
//
//		if ($applications) {
//			foreach ($applications as $application) {
//				AdmitCardPDF::makePDF($tracking_no,$application->unit);
//			}
//		}
//
//	}
}
