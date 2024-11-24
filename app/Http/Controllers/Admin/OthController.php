<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\AppUtility;
use App\Models\Hsc;
use App\Models\OthStudent;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OthController extends Controller
{
    public function index()
    {

        $applicants = OthStudent::status(null)->get();
        $status     = ['ALL' => 'All', '' => 'Pending', 'A' => 'Approved', 'R' => 'Rejected',];

        $pageSize = ['10' => 'Per Page', '15' => '15', '20' => '20', '25' => '25', '50' => '50',];

        return view('admin.oth.index')
            ->with('pageSize', $pageSize)
            ->with('status', $status)
            ->with('applicants', $applicants);
    }


    public function search(Request $request)
    {

        $db = new OthStudent;

        // name
        if ( $request->filled('name') ) {
            $db = $db->where('NAME', 'like', '%'.$request->name.'%');
        }

        // hsc
        if ( $request->filled('hsc_roll') ) {
            $db = $db->where('HSC_ROLL_NO', 'like', '%'.$request->hsc_roll.'%');
        }

        // mobile_no
        if ( $request->filled('mobile_no') ) {
            $db = $db->where('mobile_no', 'like', '%'.$request->mobile_no.'%');
        }

        //status
        if ( $request->filled('status') ) {
            if ( $request->status != 'ALL' ) {
                $db = $db->where('status', $request->status);
            }
        } else {
            $db = $db->whereNull('status');
        }

        $data = $db->paginate($request->page_size)->withQueryString();

        return view('admin.oth.search_result')
            ->with('applicants', $data);


    }


    public function show(OthStudent $student)
    {

        $units          = Unit::pluck('unit_name')->toArray();
        $units_eligible = AppUtility::extractEligibityData($student);

        return view('admin.oth.show')
            ->with('applicant', $student)
            ->with('units', $units)
            ->with('units_eligible', $units_eligible);
    }


    public function updateStatus(Request $request)
    {

        if ( $request->missing('status') ) {
            $message = [
                'error' => 1,
                'msg'   => 'Status not Set'
            ];

            session()->flash('message', $message);
            return redirect()->route('admin.oth.show', $request->input('id'))
                ->withInput();
        }


        //status filled
        if ( $request->input('status') == 'A' ) {
            $v = Validator::make($request->all(), [
                'units_eligible' => 'required',
                'ru_hsc_group'   => 'required',
                'oth_board'      => 'required'
            ]);
        } else if ( $request->input('status') == 'R' ) {

            $v = Validator::make($request->all(), [
                'comment' => 'required'
            ]);

        }


        if ( $v->fails() ) {
            return redirect()->route('admin.oth.show', $request->input('id'))
                ->withInput()
                ->withErrors($v);
        }


        $id             = $request->input('id');
        $st_status      = $request->input('status');
        $user           = $request->input('u'); // from admin or operator
        $units_eligible = $request->input('units_eligible');
        $ru_hsc_group   = $request->input('ru_hsc_group');
        $send_sms       = $request->input('send_sms', 0);
        $oth_board      = $request->input('oth_board');
        $comment        = $request->input('comment', '');


        try {

            DB::beginTransaction();

            $eligibility = $this->makeEligibilityArray($units_eligible);

            $student = OthStudent::findOrFail($id);


            //set other fields if accepted
            if ( $st_status == 'A' ) {
                //set eligibility
                foreach ($eligibility as $unit => $value) {
                    $student->$unit = $value;
                }

                $student->HSC_RESULT   = 'PASS';
                $student->HSC_GROUP    = 'N/A';
                $student->SSC_RESULT   = 'PASS';
                $student->SSC_GROUP    = 'N/A';
                $student->SSC_DATA     = '11';
                $student->RU_HSC_GROUP = $ru_hsc_group;
                $student->oth_board    = $oth_board;
                $student->comment      = $comment;
            } else if ( $st_status == 'R' ) {
                //set eligibility
                foreach ($eligibility as $unit => $value) {
                    $student->$unit = 0;
                }

                $student->HSC_RESULT   = NULL;
                $student->SSC_RESULT   = NULL;
                $student->SSC_DATA     = '0';
                $student->RU_HSC_GROUP = NULL;
                $student->oth_board    = NULL;
                $student->comment      = $comment;
            }

            $student->status     = $st_status;
            $student->checked_by = auth()->id();
            $student->save();

            // if accepted update into hsc table
            if ( $student->status == 'A' ) {
                $this->updateHscTable($student);
            }

            $message = [
                'error' => 0,
                'msg'   => 'Update Successfully'
            ];

            session()->flash('message', $message);

            DB::commit();

            //------SEND NOTIFICATION  SMS -----------------------
            //todo: send sms to oth student
            /*if ( $send_sms == 1 ) {
                if ( $st_status == 'A' ) {
                    $this->SendSMS($student->mobile_no, 'A');
                } else if ( $st_status == 'R' ) {
                    $this->SendSMS($student->mobile_no, 'R');
                }
            }*/
            //-----------------------------------------------------
        } catch (Exception $e) {

            DB::rollBack();
            Log::info('Info:OTH status update Error', ['context' => $e->getTrace()]);

            $message = [
                'error' => 1,
                'msg'   => 'Update Failed'
            ];

            session()->flash('message', $message);

        }

        return redirect()->route('admin.oth.show', $id)->withInput();


    }

    private function makeEligibilityArray($units_eligible)
    {
        $units = Unit::pluck('unit_name')->toArray();

        if ( !is_array($units_eligible) ) {
            $units_eligible = [];
        }

        $e = [];

        foreach ($units as $unit) {
            if ( in_array($unit, $units_eligible) ) {
                $e[$unit] = 1;
            } else {
                $e[$unit] = 0;
            }
        }

        return $e;

    }

    private function updateHscTable($student)
    {
        $hsc_data = Hsc::where('HSC_ROLL_NO', $student->HSC_ROLL_NO)
            ->where('HSC_BOARD_NAME', 'OTH')
            ->where('HSC_PASS_YEAR', $student->HSC_PASS_YEAR)
            ->firstOrNew();

        $hsc_data->NAME           = $student->NAME;
        $hsc_data->FNAME          = $student->FNAME;
        $hsc_data->MNAME          = $student->MNAME;
        $hsc_data->SEX            = $student->SEX;
        $hsc_data->HSC_REGNO      = $student->HSC_REGNO;
        $hsc_data->HSC_ROLL_NO    = $student->HSC_ROLL_NO;
        $hsc_data->HSC_PASS_YEAR  = $student->HSC_PASS_YEAR;
        $hsc_data->HSC_BOARD_NAME = 'OTH';
        $hsc_data->HSC_GPA        = $student->HSC_GPA;
        $hsc_data->HSC_RESULT     = 'PASS';
        $hsc_data->SSC_DATA       = '11';
        $hsc_data->SSC_ROLL_NO    = $student->SSC_ROLL_NO;
        $hsc_data->SSC_PASS_YEAR  = $student->SSC_PASS_YEAR;
        $hsc_data->SSC_BOARD_NAME = strtoupper($student->SSC_BOARD_NAME);
        $hsc_data->SSC_GPA        = $student->SSC_GPA;
        $hsc_data->SSC_RESULT     = 'PASS';
        $hsc_data->RU_HSC_GROUP   = $student->RU_HSC_GROUP;
        $hsc_data->TOTAL_GPA      = $student->TOTAL_GPA;
        $hsc_data->A              = $student->A;
        $hsc_data->B              = $student->B;
        $hsc_data->C              = $student->C;
        // $hsc_data->D              = $student->D;
        // $hsc_data->E              = $student->E;
        //$hsc_data->mobile_no      = $student->mobile_no;
        $hsc_data->oth_board = $student->oth_board;

        return $hsc_data->save();
    }

}
