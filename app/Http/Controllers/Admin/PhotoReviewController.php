<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoCheck;
use App\Models\PhotoReview;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Log;

class PhotoReviewController extends Controller
{
    public function index()
    {
        $photo_reviews = PhotoReview::status(null)
            ->with('applicant')
            ->where('bill_status', '1')
            ->whereNull('status')
            ->paginate(20)->withQueryString();


        $payment_status = ['1' => 'Paid', '0' => 'Unpaid'];
        $photo_status = [''=>'Review Pending','A' => 'Accepted', 'R' => 'Rejected'];

        return view('admin.photo_review.index')
            ->with('payment_status', $payment_status)
            ->with('photo_status', $photo_status)
            ->with('photo_reviews', $photo_reviews);
    }

    public function search(Request $request)
    {

        $db = new PhotoReview;

        if ($request->filled('applicant_id')) {
            $db = $db->where('applicant_id', $request->applicant_id);
        }

        if ($request->filled('bill_id')) {
            $db = $db->where('bill_id', $request->bill_id);
        }

        if ($request->filled('app_date')) {
            $from_date = Carbon::createFromFormat('Y-m-d', $request->app_date)->startOfDay();
            $to_date   = $from_date->copy()->addDay()->endOfDay();

            $db = $db->
            whereBetween('created_at', array($from_date, $to_date));
        }


        if ($request->filled('bill_status')) {
            $db = $db->where('bill_status', $request->bill_status);
        }

        if ($request->filled('photo_status')) {
            $db = $db->where('status', $request->photo_status);
        }
         else {
         	$db = $db->whereNull('status');
         }


        $data = $db
            ->with('applicant')
            ->paginate(20)->withQueryString();

        return view('admin.photo_review.search_result')
            ->with('photo_reviews', $data);
    }

    public function show($id)
    {
        $photo_review = PhotoReview::find($id);
        $previousReviewCount = PhotoReview::where('applicant_id', $photo_review->applicant_id)
            ->count();

        if ($photo_review) {
            return view('admin.photo_review.show')
                ->with('photo_review', $photo_review)
                ->with('previousReviewCount', $previousReviewCount)
                ->with('success', 1);
        } else {
            return view('admin.photo_review.show')
                ->with('success', 0);
        }
    }

    public function updateStatus(Request $request, $id)
    {

        $action = $request->input('action', NULL);

        //get the request
        $photo_review = PhotoReview::findOrFail($id);

        try {

            //update status
            $photo_review->checked_by = auth()->user()->id;
            $photo_review->status     = $action;
            $photo_review->save();

            // if accepted
            if ($action == 'A') {
                //if approve then update master data and replace photo

                $applicant = $photo_review->applicant;

                $new_photo      = $photo_review->new_photo;
                $existing_photo = $applicant->photo;

                $new_photo_path      = 'public/uploads/photo-changes/';
                $existing_photo_path = 'public/uploads/';
                $backup_path         = 'public/uploads/old-photos/';
                if (!Storage::exists($backup_path)) {
                    Storage::makeDirectory($backup_path);
                }

                // 1. Move the existing photo to backup path
                // 2. move the new photo to existing location
                // 3. Update the database

                // backup old photo
                if (Storage::exists($existing_photo_path.$existing_photo)) {
                    Storage::copy($existing_photo_path.$existing_photo, $backup_path.$existing_photo);
                }

                // save new photo
                if (Storage::exists($new_photo_path.$new_photo)) {
                    Storage::copy($new_photo_path.$new_photo, $existing_photo_path.$new_photo);
                }

                //update master table
                $applicant->photo            = $new_photo;
                $applicant->photo_status     = 'A';
                $applicant->photo_checked_by = auth()->user()->id;
                $applicant->save();

                $applicant->applications()
                    ->update(['photo' => $new_photo]);

                //todo : decide if needed this
                /*foreach ($applications as $a) {
                    $a->photo = $new_photo;
                    $a->save();
                    AdmitCardPDF::makePDF($a->applicant_id, $a->unit);
                }*/


                // following lines are needed for regenerating  pdf
                // this shall be kept commented till admission time

                // //update status in photo_check table to 'A'
                $this->changePhotoStatus($photo_review->applicant_id, 'A');

                // //regenerate pdf
                // $this->regenerateAdmitCard($photo_review->tracking_no);

                // //send accept sms
                // $this->SendSMS($photo_review->mobile_no,'A');

                return 'Photo Updated';
            } elseif ($action == 'R') {//rejected

                // //update status in photo_check table to 'R'
                $this->changePhotoStatus($photo_review->applicant_id, 'R');

                // // free the transaction for reuse
                // $this->freeTrx($photo_review->trxid, $photo_review->payment_method);

                // //send reject sms
                // $this->SendSMS($photo_review->mobile_no,'R');
                return 'Photo Rejected';
            }


        } catch (Exception $e) {
            Log::error('Photo change failed', ['context' => $e]);
            return 'Something went wrong';
        }

    }

    private function changePhotoStatus($applicant_id, $status)
    {
        $photoCheck = PhotoCheck::firstOrCreate(['hsc_id' => $applicant_id]);

        $photoCheck->status     = $status;
        $photoCheck->checked_by = auth()->user()->id;
        $photoCheck->save();
    }


}
