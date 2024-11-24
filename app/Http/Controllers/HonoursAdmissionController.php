<?php

namespace App\Http\Controllers;

use App\Library\RegistrationFormPDF;
use App\Models\Bill;
use App\Models\District;
use App\Models\Hsc;
use App\Models\RegistrationFee;
use App\Models\StudentChoice;
use App\Models\StudentDetails;
use App\Models\SubjectOption;
use App\Rules\ValidMobile;
use App\Services\IdentityVerificationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class HonoursAdmissionController extends Controller
{

    public function apply($subject_choice_id)
    {
        $student       = session('student');
        $subjectOption = $student->subjectOption()->find($subject_choice_id);

        if (!$subjectOption) {
            return '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Invalid subject choice id</p>';
        }

        session(['subjectOption' => $subjectOption]);

        if (!session('authorize_this_session', 0)) {
            return (new IdentityVerificationService())
                ->sendIdentityVerificationChallenge($student, route('hons_admission.getAdmissionForm'));

        }

        return response()->make()
            ->header("X-IC-Redirect", route('hons_admission.getAdmissionForm'));


    }

    public function getAdmissionForm()
    {
        $student = Hsc::find(session('student')->id);
        session(['student' => $student]);
        $subjectOption   = session('subjectOption', null);
        $student_details = $student->studentDetails;

        if (!$subjectOption) {
            return redirect()->route('site.home');
        }

        $gender = [
            'Male'   => 'Male',
            'Female' => 'Female',
            'Other'  => 'Other'
        ];

        $districts = District::orderBy('name')->pluck('name', 'name')->toArray();

        return view('hons_admission.admission_form')
            ->with('subjectOption', $subjectOption)
            ->with('student', $student)
            ->with('student_details', $student_details)
            ->with('districts', $districts)
            ->with('gender', $gender);
    }


    public function postAdmissionFormSave(Request $request)
    {
        $rules = [
            // 'guardian_name'        =>'required',
            'guardian_relation'     => 'required_with:guardian_name',
            'dob'                   => 'required|date_format:d-m-Y',
            'birth_place'           => 'required',
            'gender'                => 'required',
            'religion'              => 'required',
            'blood_group'           => 'required',
            'height'                => 'required|numeric',
            'birth_reg_no'          => 'required',
            // 'nid_no'               =>'required',
            // 'passport_no'          =>'required',
            'nationality'           => 'required',
            'email'                 => 'nullable|email',
            'permanent_address'     => 'required',
            'permanent_ps_upazila'  => 'required',
            'permanent_post_office' => 'required',
            'permanent_district'    => 'required',
            'current_address'       => 'required',
            'current_ps_upazila'    => 'required',
            'current_post_office'   => 'required',
            'current_district'      => 'required',
            'emergency_name'        => 'required',
            'emergency_relation'    => 'required',
            'emergency_contact'     => ['required', new ValidMobile()],
            'emergency_address'     => 'required',
            'ssc_institute'         => 'required',
            'hsc_institute'         => 'required',
        ];

        $messages = [
            'guardian_relation.required_with' => 'Guardian Relation field is required',
            'dob.required'                    => 'Date of Birth is required',
            'dob.date_format'                 => 'Date must be in dd-mm-yyyy format',
            'birth_place.required'            => 'Place of Birth is required',
            'gender.required'                 => 'Gender is required',
            'religion.required'               => 'Religion is required',
            'blood_group.required'            => 'Blood Group is required',
            'height.required'                 => 'Height is required',
            'height.numeric'                  => 'Height must be in inches',
            'birth_reg_no.required'           => 'Birth Registration Number is required',
            'nationality.required'            => 'Nationality is required',
            'email.email'                     => 'Must be a valid email address',
            'permanent_address.required'      => 'Permanent Address is required',
            'permanent_ps_upazila.required'   => 'Thana/Upazila is required',
            'permanent_post_office.required'  => 'Post Office is required',
            'permanent_district.required'     => 'District is required',
            'current_address.required'        => 'Current Address is required',
            'current_ps_upazila.required'     => 'Thana/Upazila is required',
            'current_post_office.required'    => 'Post Office is required',
            'current_district.required'       => 'District is required',
            'emergency_name.required'         => 'Emergency Contact name is required',
            'emergency_relation.required'     => 'Relation is required',
            'emergency_contact.required'      => 'Contact No. is required',
            'emergency_address.required'      => 'Emergency Address is required',
            'ssc_institute.required'          => 'SSC Institute Name is required',
            'hsc_institute.required'          => 'HSC Institute Name is required',
        ];

        $this->validate($request, $rules, $messages);


        try {
            DB::beginTransaction();

            // update student details
            $this->update_student_details($request);
            $subjectOption = SubjectOption::findOrFail($request->subject_option_id);

            // if no bill is created , create bill for this subject option
            if (!$subjectOption?->bill?->count()) {

                $bill    = new Bill;
                $reg_fee = RegistrationFee::where('unit_name', $subjectOption->unit)->first();

                $bill->applicant_id    = $subjectOption->applicant_id;
                $bill->bill_number     = 'xxx';
                $bill->amount          = $reg_fee->amount;
                $bill->units           = $subjectOption->unit;
                $bill->mobile_no       = $subjectOption->student->mobile_no ?? 'N/A';
                $bill->payment_method  = 'ALL';
                $bill->payment_purpose = 'R';
                $bill->payment_status  = '0';
                $bill->save();

                $subjectOption->admission_completed = '1';
                $subjectOption->bill_id             = $bill->id;
                $subjectOption->save();

                session(['subjectOption' => $subjectOption]);
                session(['student' => Hsc::find($subjectOption->applicant_id)]);

            }

            DB::commit();
            return redirect()->route('hons_admission.showAdmissionForm', $subjectOption->id);

        } catch (Exception $ex) {

            Log::info($ex->getMessage());
            DB::rollBack();

            return redirect()->route('site.home');
        }


    }

    private function update_student_details($request)
    {
        $student_details = StudentDetails::firstOrNew(['applicant_id' => $request->applicant_id]);

        $student_details->guardian_name         = $request->guardian_name;
        $student_details->guardian_relation     = $request->guardian_relation;
        $student_details->dob                   = $request->dob;
        $student_details->birth_place           = $request->birth_place;
        $student_details->gender                = $request->gender;
        $student_details->religion              = $request->religion;
        $student_details->blood_group           = $request->blood_group;
        $student_details->height                = $request->height;
        $student_details->birth_reg_no          = $request->birth_reg_no;
        $student_details->nid_no                = $request->nid_no;
        $student_details->passport_no           = $request->passport_no;
        $student_details->nationality           = $request->nationality;
        $student_details->email                 = $request->email;
        $student_details->permanent_address     = $request->permanent_address;
        $student_details->permanent_ps_upazila  = $request->permanent_ps_upazila;
        $student_details->permanent_post_office = $request->permanent_post_office;
        $student_details->permanent_district    = $request->permanent_district;
        $student_details->current_address       = $request->current_address;
        $student_details->current_ps_upazila    = $request->current_ps_upazila;
        $student_details->current_post_office   = $request->current_post_office;
        $student_details->current_district      = $request->current_district;
        $student_details->emergency_name        = $request->emergency_name;
        $student_details->emergency_relation    = $request->emergency_relation;
        $student_details->emergency_contact     = $request->emergency_contact;
        $student_details->emergency_address     = $request->emergency_address;
        $student_details->ssc_institute         = $request->ssc_institute;
        $student_details->hsc_institute         = $request->hsc_institute;

        $student_details->save();

        return $student_details;

    }

    public function showAdmissionForm($subjectOptionId)
    {
        $student = Hsc::find(session('student', null)->id);

        $subjectOption = SubjectOption::where('applicant_id', $student->id)
            ->where('id', $subjectOptionId)
            ->firstOrFail();


        return view('hons_admission.show_form_details')
            ->with('subjectOption', $subjectOption)
            ->with('student', $student)
            ->with('student_details', $student->studentDetails);

    }

    public function downloadAdmissionForm($id)
    {
        $student       = session('student', null);
        $subjectOption = SubjectOption::where('applicant_id', $student?->id)
            ->where('id', $id)
            ->firstOrFail();

        RegistrationFormPDF::makePDF($subjectOption->id);

    }

    public function postOptOut($subject_choice_id)
    {
        $student       = session('student');
        $subjectOption = $student->subjectOption()->find($subject_choice_id);

        if (!$subjectOption) {
            return '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Invalid subject choice id</p>';
        }

        session(['subjectOption' => $subjectOption]);

        if (!session('authorize_this_session', 0)) {
            return (new IdentityVerificationService())
                ->sendIdentityVerificationChallenge($student, route('hons_admission.getStudentChoices'));

        }

        return response()->make()
            ->header("X-IC-Redirect", route('hons_admission.getStudentChoices'));


    }

    public function getStudentChoices()
    {
        // remove redirect after;
        $student       = session('student');
        $subjectOption = SubjectOption::findOrFail(session('subjectOption', null)?->id);

        if (!$subjectOption) {
            return redirect()->route('site.home');
        }

        $choices = $subjectOption->choices()->with('department')->orderby('priority')->get();

        return view('hons_admission.student_choices')
            ->with('subjectOption', $subjectOption)
            ->with('choices', $choices);


    }


    public function getChangeSubjectChoice($student_choice_id, $status)
    {
        $studentChoice = StudentChoice::find($student_choice_id);

        return view('hons_admission.choice_cancel_form')
            ->with('studentChoice', $studentChoice)
            ->with('status', $status);
    }


    public function postChangeSubjectChoice(Request $request)
    {

        $studentChoice = StudentChoice::findOrFail($request->studentChoiceId);

        $status = 'R';

        if ($status == 'A') {
            $studentChoice->opt_out = '0';
        } else if ($status == 'R') {
            $studentChoice->opt_out      = '2';
            $studentChoice->opted_out_at = now();
        }

        $studentChoice->save();

        $response_A = '<p class="text-danger">Approval Successful</p>';
        $response_A .= '<p class="text-center"><a class="btn btn-success" data-dismiss="modal" role="button"><i class="fa fa-times"></i> Close </a></p>';

        $subjectName = $studentChoice->department->name;

        $response_R = sprintf('<h4 class="text-danger"><b>%s</b> Removed from your choice</h4><hr>', $subjectName);
        $response_R .= '<p class="text-center"><a class="btn btn-success" href="'.route('hons_admission.getStudentChoices').'"  role="button">
								<i class="fa fa-times"></i> Close </a>
					   </p>';

        if ($status == 'A')
            echo $response_A;
        elseif ($status == 'R')
            echo $response_R;

    }


    public function postStopAutoMigrationApply($subject_choice_id)
    {
        $student       = session('student');
        $subjectOption = $student->subjectOption()->find($subject_choice_id);

        if (!$subjectOption) {
            return '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Invalid subject choice id</p>';
        }

        session(['subjectOption' => $subjectOption]);

        if (!session('authorize_this_session', 0)) {
            return (new IdentityVerificationService())
                ->sendIdentityVerificationChallenge($student, route('hons_admission.getMigrationStopDepartmentList'));

        }

        return response()->make()
            ->header("X-IC-Redirect", route('hons_admission.getMigrationStopDepartmentList'));


    }

    public function getMigrationStopDepartmentList()
    {
        // remove redirect after;
        $student       = session('student');
        $subjectOption = session('subjectOption', null);

        if (!$subjectOption) {
            return redirect()->route('site.home');
        }

        $choices = $subjectOption->choices()->with('department')->orderby('priority')->get();

        return view('hons_admission.migration_stop_choice_list')
            ->with('subjectOption', $subjectOption)
            ->with('choices', $choices);


    }


    public function getMigrationStop($subject_option_id)
    {
        $subjectOption = SubjectOption::find($subject_option_id);

        return view('hons_admission.migration_stop_form')
            ->with('subjectOption', $subjectOption);
    }


    public function postMigrationStop(Request $request)
    {

        $student = session('student', null);

        $subjectOption = SubjectOption::where('applicant_id', $student->id)
            ->where('id', $request->subject_option_id)
            ->firstOrFail();


        if ($subjectOption) {
            $subjectOption->migration_stop       = $subjectOption->admission_subject->dept_code;
            $subjectOption->migration_stopped_at = now();
            $subjectOption->save();
            session(['subjectOption' => $subjectOption]);

            $response = '<p class="text-danger">Auto Migration Stop Successful.</p>';

        } else {
            $response = '<p class="text-danger">Auto Migration Stop! Contact Helpline.</p>';
        }

        $response .= '<p class="text-center"><a class="btn btn-success" href="'.route('hons_admission.getMigrationStopDepartmentList').'"  role="button">
								<i class="fa fa-times"></i> Close </a>
					   </p>';
        return $response;

    }


}
