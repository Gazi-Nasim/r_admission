<?php

namespace App\Http\Controllers;

use App\Library\HallChoicePDF;
use App\Library\SubjectChoicePDF;
use App\Models\Hall;
use App\Models\HallChoice;
use App\Models\SubjectOption;
use App\Services\IdentityVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HallChoiceController extends Controller
{
    public function apply($subject_option_id)
    {

        $student       = session('student');
        $subjectOption = $student->subjectOption()->find($subject_option_id);
        if (!$subjectOption) {
            return '<p class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Invalid subject choice id</p>';
        }
        session(['subjectOption' => $subjectOption]);

        if (!session('authorize_this_session', 0)) {
            $identityVerificationService = new IdentityVerificationService();
            return $identityVerificationService
                ->sendIdentityVerificationChallenge($student, route('hall_choice.getHallChoiceForm'));

        }
        return response()->make()
            ->header("X-IC-Redirect", route('hall_choice.getHallChoiceForm'));
    }

    public function getHallChoiceForm()
    {
        $student       = session('student');
        $subjectOption = session('subjectOption', null);

        if (!$subjectOption) {
            return redirect()->route('site.home');
        }
        $studentGender = $subjectOption->gender;

        $allowedHalls = Hall::where('active', 1)
            ->where('gender', $studentGender)
            ->orderBy('hall_code')->pluck('name', 'hall_code');

        return view('hall_choice.hall_choice_form')
            ->with('subjectOption', $subjectOption)
            ->with('student', $student)
            ->with('allowedHalls', $allowedHalls);

    }

    public function postHallChoiceForm(Request $request)
    {
        $subjectOption = session('subjectOption', null);
        $hallChoices   = $request->to;

        $halls = Hall::whereIn('hall_code', $hallChoices)->pluck('name', 'hall_code');

        session(['hallChoices' => $hallChoices], []);

        return view('hall_choice.hall_choice_confirm')
            ->with('subjectOption', $subjectOption)
            ->with('halls', $halls)
            ->with('hallChoices', $hallChoices);
    }


    public function postHallChoiceSave(Request $request)
    {
        $subjectOption = session('subjectOption', null);
        $hallChoices   = session('hallChoices', []);
        
        DB::transaction(function () use ($hallChoices, $subjectOption) {

            $subjectOption?->hallChoices()?->delete();

            foreach ($hallChoices as $priority => $hallCode) {

                $choice                   = new HallChoice();
                $choice->applicant_id     = $subjectOption->applicant_id;
                $choice->subjectoption_id = $subjectOption->id;
                $choice->hall_code        = $hallCode;
                $choice->priority         = $priority;
                $choice->save();

                $subjectOption->hall_choice_complete = 1;
                $subjectOption->updated_at    = now();
                $subjectOption->save();
                $subjectOption->touch();
            }

        });

        return redirect()->route('hall_choice.getHallChoiceComplete')
            ->withMessage('Hall Choice Successful');

    }


    public function getHallChoiceComplete()
    {

        return view('hall_choice.complete')
            ->withMessage('Subject Choice Complete');
    }

    public function downloadHallChoiceForm($id)
    {
        $student = session('student', null);
        $subjectOption = SubjectOption::where('applicant_id', $student?->id)
            ->where('id', $id)
            ->firstOrFail();

        HallChoicePDF::makePDF($subjectOption->id);

    }

    public function showDetails($subjectOptionId)
    {
        $student = session('student', null);

        $subjectOption = SubjectOption::where('applicant_id', $student?->id)
            ->where('id', $subjectOptionId)
            ->firstOrFail();

        $studentChoices = $subjectOption->hallChoices()->with('hall')->orderBy('priority')->get();

        return view('hall_choice.show_details')
            ->with('student', $student)
            ->with('subjectOption', $subjectOption)
            ->with('studentChoices', $studentChoices);


    }



}
