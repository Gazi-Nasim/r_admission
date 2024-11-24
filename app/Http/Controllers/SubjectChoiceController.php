<?php

namespace App\Http\Controllers;

use App\Library\SubjectChoicePDF;
use App\Models\Department;
use App\Models\Hsc;
use App\Models\StudentChoice;
use App\Models\SubjectOption;
use App\Services\IdentityVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectChoiceController extends Controller
{
    public function getDashboard()
    {
        $student = session('student', null);
        $student = Hsc::find($student->id);

        if (!$student->applications()->exists()) {
            return view('subject_choice.no_application_error')
                ->with('student', $student);
        }

        $results = $student->results()->orderBy('unit')->get();

        $validBills = $student->bills()
            ->where('payment_status', '!=', '-1')
            ->get();

        return view('subject_choice.dashboard')
            ->with('validBills', $validBills)
            ->with('results', $results)
            ->with('student', $student);
    }

    public function apply($subject_choice_id)
    {

        $student       = session('student');
        $subjectOption = $student->subjectOption()->find($subject_choice_id);

        if (!$subjectOption) {
            return '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Invalid subject choice id</p>';
        }

        session(['subjectOption' => $subjectOption]);

        if (!session('authorize_this_session', 0)) {
            $identityVerificationService = new IdentityVerificationService();
            return $identityVerificationService
                ->sendIdentityVerificationChallenge($student, route('subject_choice.getSubjectChoiceForm'));

        }

        /*if ($subjectOption->is_bksp == 1) {
            return response()->make()
                 ->header("X-IC-Redirect", route('subject_choice.confirm_bksp'));
        }*/

        return response()->make()
            ->header("X-IC-Redirect", route('subject_choice.getSubjectChoiceForm'));


    }


    public function getSubjectChoiceForm()
    {
        $student       = session('student');
        $subjectOption = session('subjectOption', null);

        if (!$subjectOption) {
            return redirect()->route('site.home');
        }

        $allowed_deps = explode(',', $subjectOption->subjects);
        $subjects     = Department::whereIn('dept_code', $allowed_deps)->pluck('name', 'dept_code');

        return view('subject_choice.subject_choice_form')
            ->with('subjectOption', $subjectOption)
            ->with('student', $student)
            ->with('subjects', $subjects);
    }

    public function postSubjectChoiceForm(Request $request)
    {
        $subjectOption   = session('subjectOption', null);
        $student_choices = $request->to;
        $subjects        = Department::whereIn('dept_code', $student_choices)->pluck('name', 'dept_code');

        session(['student_choices' => $student_choices], []);

        return view('subject_choice.subject_choice_confirm')
            ->with('subjectOption', $subjectOption)
            ->with('subjects', $subjects)
            ->with('student_choices', $student_choices);
    }

    public function postSubjectChoiceSave(Request $request)
    {
        $subjectOption  = session('subjectOption', null);
        $studentChoices = session('student_choices', []);

        $application = $subjectOption->application;

        DB::transaction(function () use ($application, $studentChoices, $subjectOption) {

            /*if (count($subjectOption->choices)) {
                $log = new AppLog;
                $log->log_type  = 'department choices';
                $log->entity    = 'Hsc';
                $log->entity_id = $subject_option->applicant_id;
                $log->log_data  = $subject_option->choices->toJson();
                $log->save();

            }*/

            $subjectOption?->choices()?->delete();

            foreach ($studentChoices as $priority => $dept_code) {

                $choice                   = new StudentChoice;
                $choice->application_id   = $application->id;
                $choice->subjectoption_id = $subjectOption->id;
                $choice->dept_code        = $dept_code;
                $choice->priority         = $priority;
                $choice->save();

                $subjectOption->sub_completed = 1;
                $subjectOption->bksp_photo    = session('inputs.bksp_photo', null);
                $subjectOption->updated_at    = now();
                $subjectOption->save();
                $subjectOption->touch();
            }

        });

        return redirect()->route('subject_choice.getSubjectChoiceComplete')
            ->withMessage('Subject Choice Successful');

    }

    public function getSubjectChoiceComplete()
    {

        return view('subject_choice.complete')
            ->withMessage('Subject Choice Complete');
    }


    public function downloadChoiceForm($id)
    {
        $student = session('student', null);
        $subjectOption = SubjectOption::where('applicant_id', $student?->id)
            ->where('id', $id)
            ->firstOrFail();

        SubjectChoicePDF::makePDF($subjectOption->id);

    }


    public function showDetails($subjectOptionId)
    {
        $student = session('student', null);

        $subjectOption = SubjectOption::where('applicant_id', $student?->id)
            ->where('id', $subjectOptionId)
            ->firstOrFail();

        $studentChoices = $subjectOption->choices()->with('department')->orderBy('priority')->get();

        return view('subject_choice.show_details')
            ->with('student', $student)
            ->with('subjectOption', $subjectOption)
            ->with('studentChoices', $studentChoices);


    }


}
