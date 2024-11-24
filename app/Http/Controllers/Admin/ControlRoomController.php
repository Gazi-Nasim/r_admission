<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Hsc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControlRoomController extends Controller
{

    public function studentInfoVerify($admissionRoll)
    {
        if (auth()->user()) {
            $application = Application::where('admission_roll', $admissionRoll)->firstOrFail();
            $student = $application->student;
            session()->put('ctrl_applicant_id', $application->applicant_id);
            session()->put('ctrl_student', $student);
            return redirect()->route('controlRoom.getStudentInfo');

        } else{

            if (setting('allow_control_room_user_login',0)==1) {

                $application = Application::where('admission_roll', $admissionRoll)->firstOrFail();
                $student = $application->student;
                session()->put('ctrl_applicant_id', $application->applicant_id);
                session()->put('ctrl_student', $student);

                session()->put('ctrl_intended_url', route('controlRoom.getStudentInfo'));
                return redirect()->route('user.getLogin');
            }
            session()->flush();
            abort(404);
        }
    }

    public function getDashBoard()
    {
        session()->forget('ctrl_applicant_id');
        session()->forget('ctrl_student');
        session()->forget('ctrl_file_name');

        return view('admin.control-room.dashboard');
    }

    public function postAdmissionRoll(Request $request)
    {

        $admissionRoll = $request->admission_roll;
        $application = Application::where('admission_roll', $admissionRoll)->first();

        if ( $application ) {
            session()->put('ctrl_applicant_id', $application->applicant_id);
            session()->put('ctrl_student', $application->student);
            return response()->make()
                ->header("X-IC-Redirect", route('controlRoom.getStudentInfo'));
        }

        return <<<HTML
            <div class="alert alert-danger">
                <strong> No student found with this admission roll.</strong>
            </div>
            HTML;

    }


    public function getStudentInfo()
    {
        $student = session('ctrl_student');
        $student = Hsc::find($student->id);
        $applications = $student->applications->pluck('admission_roll','unit')->toArray();

        return view('admin.control-room.get_student_info')
            ->with('applications', $applications)
            ->with('student', $student);
    }


    public function getStudentPhotoCapture()
    {
        $student = session('ctrl_student');

        return view('admin.control-room.student_photo_capture')
            ->with('student', $student);
    }

    public function postStudentPhotoCapture(Request $request)
    {
        $student = session('ctrl_student');
        $student = Hsc::find($student->id);


        $imageData = $request->image;
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $data      = base64_decode($imageData);

        //save the image to the server
        $student = $this->saveImage($data, $student);

        session(['ctrl_student' => $student]);

        return response()->make()
            ->header("X-IC-Redirect", route('controlRoom.photoCaptureComplete'));


    }

    public function photoCaptureComplete()
    {
        $student = session('ctrl_student');
        $file_name = session('ctrl_file_name');

        $name = $student->NAME;

        return view('admin.control-room.student_photo_capture_complete')
            ->with('name', $name)
            ->with('file_name', $file_name);
    }

    private function saveImage($imageData, &$student)
    {
        if (setting('photo_capture_test_mode', 0) == 1) {
            $fileName = $student->id.'_suspect_'.time().'.jpg';
            Storage::put('public/uploads/'.$fileName, $imageData);
            $student->suspect_photo = $fileName;
            $student->save();

            session(['ctrl_file_name' => $fileName]);

            return $student;

        }


        $fileName = '';
        if ($student->photo_status == 'A' && $student->selfie_status == 'A') {
            $fileName = $student->id.'_suspect_'.time().'.jpg';
            $student->suspect_photo = $fileName;
            Storage::put('public/uploads/'.$fileName, $imageData);
            session(['ctrl_file_name' => $fileName]);
        }

        if ($student->photo_status == 'A' && $student->selfie_status == 'R') {
            $fileName = $student->id.'_selfie_'.time().'.jpg';
            $student->selfie = $fileName;
            Storage::put('public/uploads/'.$fileName, $imageData);
            session(['ctrl_file_name' => $fileName]);
        }

        if ($student->photo_status == 'R' && $student->selfie_status == 'A') {
            $fileName = $student->id.'-'.time().'.jpg';
            $student->photo = $fileName;
            Storage::put('public/uploads/'.$fileName, $imageData);
            session(['ctrl_file_name' => $fileName]);
        }


        if ($student->photo_status == 'R' && $student->selfie_status == 'R') {
            $photoFileName = $student->id.'-'.time().'.jpg';
            $selfieFileName = $student->id.'_selfie_'.time().'.jpg';
            $suspectFileName = $student->id.'_suspect_'.time().'.jpg';

            $student->photo = $photoFileName;
            $student->selfie = $selfieFileName;
            $student->suspect_photo = $suspectFileName;

            Storage::put('public/uploads/'.$photoFileName, $imageData);
            Storage::put('public/uploads/'.$selfieFileName, $imageData);
            Storage::put('public/uploads/'.$suspectFileName, $imageData);
            session(['ctrl_file_name' => $photoFileName]);
        }

        $student->save();

        return $student;
    }


}
