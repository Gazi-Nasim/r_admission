<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\UnitStudentListExcel;
use App\Models\Bill;
use App\Models\SubjectOption;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitOfficeController extends Controller
{
    public function getDashboard()
    {
        //application bills
        $unit_approved_students = SubjectOption::select(DB::raw('count(*) as total'), 'admission_subject')
            ->groupBy('admission_subject')
            ->where('unit', auth()->user()->unit->unit_name)
            ->where('office_status', '1')
            ->where('bill_status', '1')
            ->orderBy('admission_subject')
            ->get();


        $unit_pending_students = SubjectOption::select(DB::raw('count(*) as total'), 'admission_subject')
            ->groupBy('admission_subject')
            ->where('unit', auth()->user()->unit->unit_name)
            ->where('office_status', '0')
            ->where('bill_status', '1')
            ->orderBy('admission_subject')
            ->get();

        return view('admin.unit_office.dashboard')
            ->with('unit_approved_students', $unit_approved_students)
            ->with('unit_pending_students', $unit_pending_students);
    }

    public function getApproveStudent()
    {
        $departments = auth()->user()->unit->departments
            ->pluck('name', 'dept_code')->toArray();

        return view('admin.unit_office.list_approve_students')
            ->with('departments', $departments);
    }

    public function postApproveStudent(Request $request)
    {
        $db = SubjectOption::orderby('admission_roll');
        $db = $db->where('unit', auth()->user()->unit->unit_name);

        // id
        if ($request->filled('admission_roll'))
            $db = $db->where('admission_roll', 'LIKE', '%'.$request->admission_roll.'%');

        if ($request->filled('department'))
            $db = $db->where('admission_subject', $request->department);

        $db = $db->where('bill_status', '1');
        $db = $db->where('office_status', '0');

        $data = $db->get();

        return view('admin.unit_office.list_approve_students_result')
            ->with('data', $data);

    }


    public function getChangeStatus($subject_option_id, $status)
    {
        //--needed don't remove 2 lines below. No time to explain why --
        session()->forget('old.reject_reason');
        session()->forget('old.unit');
        //--------------------------------------------------------------

        $subjectOption  = SubjectOption::find($subject_option_id);
        $reject_reasons = [
            'ABS'    => 'Student Absent',
            'CANCEL' => 'Admission Canceled By Student',
            'UM'     => 'Migration to Unit',
        ];


        return view('admin.unit_office.change_status_form')
            ->with('subjectOption', $subjectOption)
            ->with('reject_reasons', $reject_reasons)
            ->with('status', $status);

    }

    public function postChangeStatus(Request $request)
    {
        $rules = [
            'status'            => 'required',
            'subject_option_id' => 'required',
            'reject_reason'     => 'required_if:status,R',
            'unit'              => 'required_if:reject_reason,UM',
        ];

        $message = [
            'reject_reason.required_if' => ' কি কারণে আবেদন বাতিল করা হচ্ছে তা সিলেক্ট করুন',
            'unit.required_if'          => 'ছাত্র যে ইউনিটে মাইগ্রেট করছে তার নাম লিখুন'
        ];

        $validation    = Validator::make($request->all(), $rules, $message);
        $subjectOption = SubjectOption::find($request->subject_option_id);

        if ($validation->fails()) {

            $reject_reasons = [
                'ABS'    => 'Student Absent',
                'CANCEL' => 'Admission Canceled By Student',
                'UM'     => 'Migration to Unit',
            ];

            session()->flash('old.reject_reason', $request->input('reject_reason'));
            session()->flash('old.unit', $request->input('unit'));

            return view('admin.unit_office.change_status_form')
                ->with('subjectOption', $subjectOption)
                ->with('reject_reasons', $reject_reasons)
                ->with('status', $request->status)
                ->withInput($request->all())
                ->withErrors($validation);
        }

        // if validation passes

        if ($request->status == 'A') {
            $subjectOption->office_status = '1';
            $subjectOption->save();
            $response_A = '<p class="text-danger">Approval Successful</p>';
            $response_A .= '<p class="text-center"><a class="btn btn-success" data-dismiss="modal" role="button"><i class="fa fa-times"></i> Close </a></p>';
            return $response_A;

        } else if ($request->status == 'R') {

            switch ($request->reject_reason) {
                case 'ABS':
                    $subjectOption->office_status = '-1';
                    $subjectOption->reject_reason = 'ABS';
                    $subjectOption->comment       = 'Student Absent';
                    $subjectOption->save();
                    $response_R = '<p class="text-danger">Application Canceled Successful( Reason : Student Absent)</p>';
                    break;
                case 'CANCEL':
                    $subjectOption->office_status = '-1';
                    $subjectOption->reject_reason = 'CANCEL';
                    $subjectOption->comment       = 'Admission Canceled By Student';
                    $subjectOption->save();
                    $response_R = '<p class="text-danger">Application Canceled (Reason : Student Canceled Admission)</p>';
                    break;
                case 'UM':

                    $migration_sub_opt = SubjectOption::where('applicant_id', $subjectOption->applicant_id)
                        ->where('unit', strtoupper($request->unit))
                        ->where('unit', '<>', $subjectOption->unit)
                        ->where('sub_completed', '1')
                        ->first();

                    if ($migration_sub_opt?->count()) {

                        try {
                            DB::beginTransaction();

                            // create new bill
                            $bill          = new Bill;
                            $migration_fee = 510; // migration fee

                            $bill->applicant_id    = $subjectOption->applicant_id;
                            $bill->bill_number     = 'xxx';
                            $bill->amount          = $migration_fee;
                            $bill->units           = $request->unit;
                            $bill->mobile_no       = $subjectOption->student->mobile_no;
                            $bill->payment_method  = 'ALL';
                            $bill->payment_purpose = 'R';
                            $bill->payment_status  = '0';
                            $bill->save();

                            // update old unit
                            $subjectOption->office_status = '-1';
                            $subjectOption->reject_reason = 'UM';
                            $subjectOption->comment       = 'Student Migrated to Unit - '.$request->unit;
                            $subjectOption->save();

                            //update new unit
                            $migration_sub_opt->admission_completed = '1';
                            $migration_sub_opt->comment             = 'Student Migrated from Unit - '.$subjectOption->unit;
                            $migration_sub_opt->bill_id             = $bill->id;
                            $migration_sub_opt->save();

                            DB::commit();
                            $response_R = sprintf('<p class="text-danger"><i class="fa fa-check-circle-o"></i> Application Canceled. ( Reason : Student requested migration to <u>UNIT-%s</u> )</p>', $inputs['unit']);
                        } catch (Exception $ex) {
                            DB::rollBack();
                            $response_R = '<h3 class="text-danger text-center"><i class="fa fa-times-circle-o"></i> Application Canceled Unsuccessful</h3>';
                            $response_R .= '<h4 class="text-danger text-center">Please Contact Helpline</h4>';
                        }

                        // $response_R = sprintf('<p class="text-danger"><i class="fa fa-check-circle-o"></i> Application Canceled. (Reason : Student requested migration to <u>unit %s</u></p>)',$inputs['unit']);

                    } else {
                        $response_R = '<h3 class="text-danger text-center"><i class="fa fa-times-circle-o"></i> Application Canceled Unsuccessful</h3>';
                        $response_R .= '<h4 class="text-danger text-center">Please Contact Helpline</h4>';
                    }

                    break;

            }

            $response_R .= '<p class="text-center"><a class="btn btn-success" data-dismiss="modal" role="button"><i class="fa fa-times"></i> Close </a></p>';
            return $response_R;
        }


    }

    public function getCancelStudent()
    {
        $departments   = auth()->user()->unit->departments->pluck('name', 'dept_code')->toArray();
        $bill_types    = ['1' => 'Paid', '0' => 'Unpaid'];
        $office_status = ['0' => 'Pending', '1' => 'Approved', '-1' => 'Canceled'];


        return view('admin.unit_office.list_cancel_students')
            ->with('departments', $departments)
            ->with('bill_types', $bill_types)
            ->with('office_status', $office_status);
    }


    public function postCancelStudent(Request $request)
    {

        $db = SubjectOption::orderby('admission_roll');
        $db = $db->where('unit', auth()->user()->unit->unit_name);

        // id
        if ($request->filled('admission_roll'))
            $db = $db->where('admission_roll', 'LIKE', '%'.$request->admission_roll.'%');

        if ($request->filled('bill_status'))
            $db = $db->where('bill_status', $request->bill_status);

        if ($request->filled('office_status'))
            $db = $db->where('office_status', $request->office_status);

        if ($request->filled('department'))
            $db = $db->where('admission_subject', $request->department);

        $db = $db->where('admission_completed', '1');
        // $db = $db->where('office_status','<>','-1');
        $db = $db->orderBy('admission_roll');
        $db = $db->take(150);

        $data = $db->get();

        return view('admin.unit_office.list_cancel_students_result')
            ->with('data', $data);

    }

    public function getDownloadStudentData()
    {
        $unit      = auth()->user()->unit->unit_name;
        $file_name = sprintf('Student_list_Unit_%s_%s.xlsx', $unit, date('Ydm_His'));

        $file_path = UnitStudentListExcel::create($unit, $file_name);

        $headers = [
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return response()->download($file_path, $file_name, $headers);

    }

    public function downloadAdmissionForm($subjectOptionId)
    {
        return app(StudentController::class)->showHonsAdmissionForm($subjectOptionId);
    }


}
