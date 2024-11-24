<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\DropDownHelper;
use App\Library\RUSms;
use App\Models\Hsc;
use App\Models\InfoReview;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplainBoxController extends Controller
{
    public function index()
    {
        $hsc_board = DropDownHelper::getHscBoards();
        $hsc_year  = DropDownHelper::getHscYears();
        $complainTypes = DropDownHelper::getComplainTypes();

        $status = ['A' => 'Accepted', 'R' => 'Rejected'];
        $orderBy =[ 'DESC' => 'Newest','ASC'=> 'Oldest'];

        // at first show only new complains
        $applicants = InfoReview::status(null)->paginate(30)->withQueryString();

        return view('admin.complainbox.index')
            ->with('hsc_board', $hsc_board)
            ->with('hsc_year', $hsc_year)
            ->with('complainTypes', $complainTypes)
            ->with('status', $status)
            ->with('orderBy', $orderBy)
            ->with('data', $applicants);
    }

    public function search(Request $request)
    {

        $db = new InfoReview;

        if ( $request->filled('complain_type_id') ) {
            $db = $db->where('complain_type_id',$request->input('complain_type_id'));
        }

        if ( $request->filled('name') ) {
            $db = $db->where('name', 'like', '%'.$request->input('name').'%');
        }

        if ( $request->filled('hsc_roll') ) {
            $db = $db->where('HSC_ROLL_NO', $request->input('hsc_roll'));
        }


        if ( $request->filled('hsc_board') ) {
            $db = $db->where('HSC_BOARD_NAME', $request->input('hsc_board'));
        }


        if ( $request->filled('hsc_year') ) {
            $db = $db->where('HSC_PASS_YEAR', $request->input('hsc_year'));
        }

        if ( $request->filled('status') ) {
            $db = $db->where('status', $request->input('status'));
        } else {
            $db = $db->whereNull('status');
        }


        if ( $request->filled('complain_date') ) {
            $from_date = Carbon::createFromFormat('Y-m-d', $request->complain_date)->startOfDay();
            $to_date   = $from_date->copy()->addDay();

            $db = $db->whereBetween('created_at', array($from_date, $to_date));
        }

        if ( $request->filled('orderBy') ) {
            $db = $db->orderBy('id', $request->orderBy);
        }

//        $db = $db->orderBy('id', 'desc');

        $data = $db->paginate(30)->withQueryString();


        return view('admin.complainbox.search_result')
            ->with('data', $data);
    }


    public function show($id)
    {
        $infoReview = InfoReview::findOrFail($id);


        $hscData        = $this->getHscData($infoReview);
        $enrollments    = $hscData?->enrollments;
        $enrollmentBill = $hscData?->enrollmentBill;

        $applications =$hscData?->applications;
        $applicationBills = $hscData?->applicationBill;


        return view('admin.complainbox.show')
            ->with('infoReview', $infoReview)
            ->with('enrollments', $enrollments)
            ->with('enrollmentBill', $enrollmentBill)
            ->with('applicationBills', $applicationBills)
            ->with('ssc_data', null)
            ->with('hscData', $hscData);
    }

    /**
     * @param Model|Collection|InfoReview|array $infoReview
     * @return Hsc|Builder|Model|object|null
     */
    public function getHscData($infoReview)
    {
        $hsc_roll  = $infoReview->HSC_ROLL_NO;
        $hsc_board = $infoReview->HSC_BOARD_NAME;
        $hsc_year  = $infoReview->HSC_PASS_YEAR;

        $hscData = Hsc::where('HSC_ROLL_NO', '=', $hsc_roll)
            ->where('HSC_BOARD_NAME', '=', strtoupper($hsc_board))
            ->where('HSC_PASS_YEAR', '=', $hsc_year)
            ->first();

        return $hscData;
    }

    public function updateStatus(Request $request)
    {
        $id        = $request->id;
        $st_status = $request->status;
        $comment   = $request->comment;

        //--PROCEDURE
        // 1. Set Status in info_review table
        // 2. if status change in not 'F'
        //      a. If data present in master_table, set Elegibility Status there
        //      b. If status change is positive, (May be) send SMS to applicant

        try {
            DB::transaction(function () use ($request, $id, $st_status,  $comment) {
                $infoReview = InfoReview::findOrFail($id);

                $infoReview->status     = $st_status;
                $infoReview->comment    = $comment;
                $infoReview->checked_by = auth()->id();
                $infoReview->save();

                $studentData = $this->getHscData($infoReview);

                if ( $studentData && $st_status == 'A' ) {
                    $this->updateHscTable($studentData, $infoReview);

                    $message = [
                        'error' => 0,
                        'msg'   => 'Update Successful'
                    ];

                    session()->flash('message', $message);

                }

                if ( $request->filled('comment') && $request->filled('send_sms')) {
                    RUSms::sendSms($infoReview->mobile_no, $request->comment,'RU');
                }

            });
        } catch (Exception $e) {
            $message = [
                'error' => 1,
                'msg'   => 'Update Failed'
            ];

            session()->flash('message', $message);
        }

        return redirect()->route('admin.complainbox.show', $id);
    }


    public function updateSscDataFromStudent(Request $request)
    {
        $infoReview = InfoReview::findOrFail($request->infoReviewId);

        $hscData =  $this->getHscData($infoReview);

        if ($hscData){
            $hscData->SSC_ROLL_NO = $infoReview->SSC_ROLL_NO;
            $hscData->SSC_BOARD_NAME = $infoReview->SSC_BOARD_NAME;
            $hscData->SSC_PASS_YEAR = $infoReview->SSC_PASS_YEAR;
            $hscData->SSC_DATA='11';
            $hscData->save();


            $sscData = DB::table('ssc')
                ->where('SSC_ROLL_NO', '=', $infoReview->SSC_ROLL_NO)
                ->where('SSC_BOARD_NAME', '=', strtoupper($infoReview->SSC_BOARD_NAME))
                ->where('SSC_PASS_YEAR', '=', $infoReview->SSC_PASS_YEAR)
                ->first();

            try {
                if ($sscData){
                    $hscData->DOB = $sscData->DOB;
                    $hscData->SSC_NAME = $sscData->NAME;
                    $hscData->SSC_REGNO = $sscData->SSC_REGNO;
                    $hscData->SSC_SESSION = $sscData->SSC_SESSION;
                    $hscData->SSC_C_TYPE = $sscData->C_TYPE;
                    $hscData->SSC_GROUP = $sscData->SSC_GROUP;
                    $hscData->SSC_RESULT = $sscData->RESULT;
                    $hscData->SSC_GPA = $sscData->SSC_GPA;
                    $hscData->SSC_LTRGRD = $sscData->SSC_LTRGRD;
                    $hscData->TOTAL_GPA = $hscData->HSC_GPA + $sscData->SSC_GPA;
                    $hscData->save();

                    if (!in_array($sscData->C_TYPE,['IMPROVED', 'NOT IMPROVE'])
                        && !in_array($hscData->C_TYPE,['IMPROVED', 'NOT IMPROVE'])
                        && $hscData->HSC_RESULT == 'PASS' && $sscData->RESULT == 'PASS'
                    ){

                        switch ($hscData->RU_HSC_GROUP){
                            case 'H' :
                                if ($hscData->HSC_GPA >= 3.00 && $sscData->SSC_GPA >= 3.00 && $hscData->TOTAL_GPA >= 7.00){
                                    $hscData->A='1';
                                    $hscData->B='1';
                                    $hscData->C='1';
                                    $hscData->D='0';
                                    $hscData->E='0';
                                    $hscData->save();
                                }
                                break;

                            case 'C' :
                                if ($hscData->HSC_GPA >= 3.50 && $sscData->SSC_GPA >= 3.50 && $hscData->TOTAL_GPA >= 7.50){
                                    $hscData->A='1';
                                    $hscData->B='1';
                                    $hscData->C='1';
                                    $hscData->D='0';
                                    $hscData->E='0';
                                    $hscData->save();
                                }
                                break;

                            case 'S' :
                                if ($hscData->HSC_GPA >= 3.50 && $sscData->SSC_GPA >= 3.50 && $hscData->TOTAL_GPA >= 8.00){
                                    $hscData->A='1';
                                    $hscData->B='1';
                                    $hscData->C='1';
                                    $hscData->D='0';
                                    $hscData->E='0';
                                    $hscData->save();
                                }
                                break;

                        }


                    }


                }
            }
            catch (Exception $e) {
                return $e->getMessage();
            }

            return 'updated';
        }else{
            return 'not found';
        }


    }

    public function viewSscData($infoReviewId)
    {
        $infoReview = InfoReview::findOrFail($infoReviewId);

        $sscData = DB::table('ssc')
            ->where('SSC_ROLL_NO', '=', $infoReview->SSC_ROLL_NO)
            ->where('SSC_BOARD_NAME', '=', strtoupper($infoReview->SSC_BOARD_NAME))
            ->where('SSC_PASS_YEAR', '=', $infoReview->SSC_PASS_YEAR)
            ->first();

        if ($sscData){
            echo '<table border="1" width="500">';
            foreach ($sscData as $key => $value){
                echo '<tr>';
                echo '<td>'.$key.'</td>';
                echo '<td>'.$value.'</td>';
                echo '</tr>';
            }
            echo '</table>';
        }else{
            echo 'not found';
        }

    }

    private function updateHscTable($studentData, $infoReview)
    {
        /*
        $hsc_roll  = $infoReview->HSC_ROLL_NO;
        $hsc_board = $infoReview->HSC_BOARD_NAME;
        $hsc_year  = $infoReview->HSC_PASS_YEAR;

        $hscData = Hsc::where('HSC_ROLL_NO', '=', $hsc_roll)
            ->where('HSC_BOARD_NAME', '=', strtoupper($hsc_board))
            ->where('HSC_PASS_YEAR', '=', $hsc_year)
            ->first();

        if ( $hscData ) {
        }
        */
    }

}
