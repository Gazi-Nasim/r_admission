<?php

namespace App\Http\Controllers;

use App\Library\DropDownHelper;
use App\Services\StudentLoginService;
use Illuminate\Http\Request;

class StudentLoginController extends Controller
{

    private $studentLoginService;

    public function __construct(StudentLoginService $studentLoginService)
    {
        $this->studentLoginService = $studentLoginService;
    }

    public function getLogin()
    {

        session()->forget('student');
        session()->forget('bill');
        session()->forget('user_input');
        session()->forget('inputs');
        session()->forget('user_flags');
        session()->forget('authorize_this_session');
        session()->forget('route');


        $ssc_board = DropDownHelper::getSscBoards();
        $hsc_board = DropDownHelper::getHscBoards();
        $ssc_year  = DropDownHelper::getSscYears();
        $hsc_year  = DropDownHelper::getHscYears();


        return view('student.login')
            ->with('ssc_board', $ssc_board)
            ->with('hsc_board', $hsc_board)
            ->with('ssc_year', $ssc_year)
            ->with('hsc_year', $hsc_year);
    }

    public function postLogin(Request $request)
    {
        // set the validation rules
        $rules = [
            'ssc_roll'  => 'required',
            'ssc_board' => 'required',
            'ssc_year'  => 'required',
            'hsc_roll'  => 'required',
            'hsc_board' => 'required',
            'hsc_year'  => 'required',
        ];

        if (!config('app.debug')) {
            $rules += ['captcha' => 'required|captcha'];
        }

        // Nasim 
        $message = [];
        // $message = [
        //     'captcha.captcha' => 'Text did not match'
        // ];

        //run validation
        $inputs = $this->validate($request, $rules, $message);

        $student = $this->studentLoginService->login($inputs);
        $flags   = $this->studentLoginService->getStudentStatusFlags($student, $inputs);


        session(['user_input' => $inputs]);
        session(['user_flags' => $flags]);

        // if student is not found
        if (!$student) {
            return redirect()->route('student.getLoginError');
        }

        //
        if (array_sum($flags) > 0) {
            return redirect()->route('student.getLoginError');
        }

        session(['student' => $student]);
        session()->forget('user_input');

        /* Redirect to various location based on app settings */
//        if (setting('activate_preliminary_application', 0)) {
//            return redirect()->route('student.getboard'); // for first round application homepage
//        }
//
//        if (setting('activate_final_application', 0)) {
//            return redirect()->route('student.getDashboard'); // for final round application homepage
//        }

        return redirect()->route('student.getDashboard'); // for final round application
    }

    public function getLoginError()
    {
        $user_input = session('user_input', []);
        $flags      = session('user_flags', []);

        $ssc_board = DropDownHelper::getSscBoards();
        $hsc_board = DropDownHelper::getHscBoards();


        return view('student.login_error')
            ->with('hsc_board', $hsc_board)
            ->with('ssc_board', $ssc_board)
            ->with('user_input', $user_input)
            ->with('flags', $flags);
    }

    public function getLogout()
    {
        session()->flush();
        return redirect()->route('site.home');
    }


    public function getDashboard()
    {
        if (setting('activate_preliminary_application', 0)) {
            return app(PreliminaryApplicationController::class)->getDashboard();
        }

        if (setting('activate_final_application', 0)) {
            return app(FinalApplicationController::class)->getDashboard();
        }

        if (setting('activate_post_application', 0)) {
            return app(PostApplicationController::class)->getDashboard();
        }

        if (setting('activate_subject_choice', 0)) {
            return app(SubjectChoiceController::class)->getDashboard();
        }

    }


}
