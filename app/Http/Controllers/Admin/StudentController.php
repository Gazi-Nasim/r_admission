<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\AdmitCardPDF;
use App\Library\AppUtility;
use App\Library\DropDownHelper;
use App\Library\EducationBoardCrawler;
use App\Library\RegistrationFormPDF;
use App\Library\SubjectChoicePDF;
use App\Models\Application;
use App\Models\Hsc;
use App\Models\Quota;
use App\Models\SubjectOption;
use App\Models\User;
use App\Rules\ValidMobile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class StudentController extends Controller
{
    public function index()
    {
        $ssc_board = DropDownHelper::getSscBoards();
        $hsc_board = DropDownHelper::getHscBoards();
        $hsc_year  = DropDownHelper::getHscYears();
        $ssc_year  = DropDownHelper::getSscYears();

        return view('admin.student.index')
            ->with('ssc_board', $ssc_board)
            ->with('ssc_year', $ssc_year)
            ->with('hsc_year', $hsc_year)
            ->with('hsc_board', $hsc_board);
    }

    public function search(Request $request)
    {
        $db = new Hsc;

        // id
        if ($request->filled('applicant_id')) {
            $db = $db->where('id', $request->input('applicant_id'));
        }

        // mobile_no
        if ($request->filled('mobile_no')) {
            $db = $db->where('mobile_no', 'like',
                '%'.$request->input('mobile_no').'%');
        }

        // hsc
        if ($request->filled('hsc_roll')) {
            $db = $db->where('HSC_ROLL_NO', $request->input('hsc_roll'));
        }

        if ($request->filled('hsc_board')) {
            $db = $db->where('HSC_BOARD_NAME', '=',
                $request->input('hsc_board'));
        }

        if ($request->filled('hsc_year')) {
            $db = $db->where('HSC_PASS_YEAR', '=', $request->input('hsc_year'));
        }


        // ssc
        if ($request->filled('ssc_roll')) {
            $db = $db->where('SSC_ROLL_NO', 'like',
                '%'.$request->input('ssc_roll').'%');
        }

        if ($request->filled('ssc_board')) {
            $db = $db->where('SSC_BOARD_NAME', '=',
                $request->input('ssc_board'));
        }

        if ($request->filled('ssc_year')) {
            $db = $db->where('SSC_PASS_YEAR', '=', $request->input('ssc_year'));
        }


        $data = $db->paginate(30)->withQueryString();

        return view('admin.student.search_result')
            ->with('data', $data);
    }

    public function show(Hsc $student)
    {
        $elegiblility = AppUtility::extractEligibityData($student);

        // check if photo is verifies
        $photo_status = $student->photo_status ?? 'NA';
        $checked_by   = User::find($student?->photo_checked_by)?->fullname ?? 'N/A';


        $applications   = $student->applications()->orderby('unit')->get();
        $enrollments    = $student->enrollments()->orderby('unit')->get();
        $pending_bill   = $student->bills()->where('payment_status', 0)->get();
        $last_paid_bill = $student->bills()
            ->where('payment_status', 1)
            ->whereIn('payment_purpose', ['A', 'E'])
            ->orderBy('id', 'desc')
            ->first();


        return view('admin.student.show')
            ->with('student_data', $student)
            ->with('elegiblility', $elegiblility)
            ->with('photo_status', $photo_status)
            ->with('checked_by', $checked_by)
            ->with('pending_bill', $pending_bill)
            ->with('last_paid_bill', $last_paid_bill)
            ->with('enrollments', $enrollments)
            ->with('applications', $applications);

    }


    public function edit(Hsc $student)
    {

//        $columns = Schema::getColumnListing('hsc');
        $columns = collect(\DB::select('describe hsc'))->pluck('Field')->toArray();

        return view('admin.student.edit')
            ->with('columns', $columns)
            ->with('student', $student);

    }

    public function boardLookup(Hsc $student)
    {

        $crawler = new EducationBoardCrawler();
        $data    = $crawler->getBoardDate($student);

        return view('admin.student.board_lookup')
            ->with('student', $student)
            ->with('data', $data);
    }

    public function editMobile(Hsc $student)
    {
        return view('admin.student.edit_mobile')
            ->with('student_data', $student);
    }

    public function updateMobile(Request $request)
    {

        $student_id = $request->input('student_id');
        $student    = Hsc::find($student_id);

        $rules = [
            'mobile_no' => ['required', 'unique:hsc,mobile_no', 'digits:11', new ValidMobile()]
        ];

        $messages = [
            'mobile_no.required' => 'Please enter you new mobile no',
            'mobile_no.unique'   => 'Mobile no. already exists'
        ];


        $validation = Validator::make($request->all(), $rules, $messages);


        if ($validation->fails()) {
            return view('admin.student.edit_mobile')
                ->with('student_data', $student)
                ->withInput($request->input())
                ->withErrors($validation);
        }

        try {

            DB::transaction(function () use ($request, $student) {
                $student->mobile_no = $request->input('mobile_no');
                $student->save();

//                $student->bills()
//                    ?->update(['mobile_no' => $request->input('mobile_no')]);

//                $student->applications()
//                    ?->update(['mobile_no' => $request->input('mobile_no')]);
            });


            $result = sprintf('<p>Mobile Number changed to %s</p>',
                $request->input('mobile_no'));
            return $result .= '<p class="text-center"><a href="'
                .route('admin.student.show', $student->id)
                .'" class="btn btn-success" ><i class="fa fa-check"></i> OK</button></p>';

        } catch (Exception $e) {
            $result = '<p>Update UnSuccessful</p>'.$e->getMessage();
            return $result .= '<p><button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> OK</button></p>';
        }

    }

    public function updateFromBoard(Request $request)
    {
        $student_id  = $request->student_id;
        $update_data = [];

        if ($request->has('name')) {
            $update_data ['NAME'] = $request->name;
        }

        if ($request->has('fname')) {
            $update_data['FNAME'] = $request->fname;
        }

        if ($request->has('mname')) {
            $update_data['MNAME'] = $request->mname;
        }


        $student = Hsc::find($student_id);
        $student->update($update_data);
        return 'Updated';

    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token']);

        if ($request->missing('id')) {
            return redirect()->back()->with('message', 'Some thing went wrong');
        }

        $student = Hsc::find($inputs['id']);

        $nullable_field = [
            'MATHEMATICS', 'mobile_no', 'photo', 'photo_status',
            'photo_checked_by'
        ];

        foreach ($inputs as $key => $value) {
            if (in_array($key, $nullable_field)) {
                $student->$key = ($value == '') ? null : $value;
            } else {
                $student->$key = $value;
            }
        }

        $student->save();

        return redirect()->route('admin.student.show', $student->id)
            ->with('message', 'Data Updated!');
    }

    public function clearQuotas(Request $request, Hsc $student)
    {

        try {

            DB::transaction(function () use ($request, $student) {

                $quotas = $student->quota_array;
                foreach ($quotas as $key => $value) {
                    $student->{$key.'_photo'} = null;
                    $student->FFQ_type        = null;
                    $student->save();
                }


                $student->enrollmentBill()
                    ->update(['quota' => null, 'quota_docs' => null, 'FFQ_type' => null]);

                $student->enrollments()->update(['quota' => null]);
            });

            return '<span class="well well-sm">Quota Cleared</span>';

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function showApplication(Application $application)
    {

        if ($application) {

            return view('admin.student.show_application_details')
                ->with('application', $application);
        } else {
            return '<div class="alert alert-danger">
							<strong>No Data Found</strong>
						 </div>';
        }
    }

    public function showSubjectOption($subjectOptionId)
    {
        $subjectOption  = SubjectOption::findOrFail($subjectOptionId);
        $studentChoices = $subjectOption->choices()
            ->with('department')
            ->orderBy('priority')
            ->get();


        return view('admin.student.show_subject_choice')
            ->with('subjectOption', $subjectOption)
            ->with('studentChoices', $studentChoices);
    }


    public function showHonsAdmissionForm($subjectOptionId)
    {

        $subjectOption = SubjectOption::query()
            ->where('id', $subjectOptionId)
            ->firstOrFail();

        $student = $subjectOption->student;

        return view('admin.student.show_hons_admission_form')
            ->with('subjectOption', $subjectOption)
            ->with('student', $student)
            ->with('student_details', $student->studentDetails);
    }


    public function getDownloadAdmitCard(Application $application)
    {
        $student   = $application->student;
        $file_path = AdmitCardPDF::makePDF($application);
        $unit      = $application->unit;


        if (Storage::exists($file_path)) {
            $headers = [
                'Content-Type: application/pdf',
            ];
            ob_end_clean();

            $filename = sprintf("%s-%s.pdf", $unit, $application->admission_roll);

            return response()->download(Storage::path($file_path), $filename, $headers);
        }

        abort(404);
    }

    public function downloadSubjectChoiceForm(SubjectOption $subjectOption)
    {
        SubjectChoicePDF::makePDF($subjectOption->id);

    }


    public function downloadHonsAdmissionForm(SubjectOption $subjectOption)
    {
        RegistrationFormPDF::makePDF($subjectOption->id);
    }


    public function editQuota($student_id)
    {

        $quotas  = Quota::pluck('quota', 'code');
        $student = Hsc::find($student_id);

        // find different quotas
        $student_quotas = $this->get_current_quota($student);

        return view('admin.student.edit_quota')
            ->with('quotas', $quotas)
            ->with('student_quotas', $student_quotas)
            ->with('student', $student);
    }

    private function get_current_quota($student)
    {
        $ru_quotas     = Quota::pluck('code');
        $student_quota = [];
        foreach ($ru_quotas as $ru_quota) {
            if ($student->{$ru_quota.'_photo'} != '') {
                $student_quota[$ru_quota] = $student->{$ru_quota.'_photo'};
            }
        }
        return $student_quota;
    }

    public function updateQuotaPhoto(Request $request)
    {

        $rules = [
            'student_id'  => 'required',
            'quota_photo' => 'required|mimes:jpeg,pdf|max:4096',
            'quota'       => 'required',
            'ffq_type'    => 'required_if:quota,FFQ'
        ];

        $messages = [
            "quota_photo.required" => "Please Upload supporting documents for selected quota",
            "quota_photo.image"    => "Not a valid photo",
            "quota_photo.mimes"    => "Only JPG or PDF file is allowed",
            "quota_photo.max"      => "Photo must be under 2MB",
        ];

        $validation = Validator::make($request->all(), $rules, $messages);


        if ($validation->passes()) {
            $file  = $request->file('quota_photo');
            $quota = $request->quota;

            if ($file->isValid()) {
                $file_extension = $file->getClientOriginalExtension();
                $student        = Hsc::find($request->student_id);

                $new_file_name = sprintf('%s_%s.%s', $student->id, $quota, $file_extension);
                $prevoius_file = $student->{$quota.'_photo'};

                $file_path    = 'public/uploads/';
                $archive_path = 'public/uploads/old_photo/';

                if ($prevoius_file != "") {
                    if (Storage::exists($file_path.$prevoius_file)) {
                        Storage::move($file_path.$prevoius_file, $archive_path.$prevoius_file.'_'.time());
//
                    }
                }

                $file->storeAs('public/uploads/', $new_file_name);

                $ru_quotas = Quota::pluck('code');

                //clear other quotas
                foreach ($ru_quotas as $q) {
                    $student->{$q.'_photo'} = NULL;
                }

                //now set desired quota
                $student->{$quota.'_photo'} = $new_file_name;
                $student->save();

                $update_data = [$quota => $new_file_name];

                $student->bills()->where('payment_purpose', 'E')
                    ->where('payment_status', '1')
                    ->update([
                        'quota'      => $quota,
                        'quota_docs' => json_encode($update_data),
                        'FFQ_type'   => $request->input('FFQ_type', NULL)
                    ]);

                $student->bills()->where('payment_purpose', 'A')
                    ->update([
                        'quota'      => $quota,
                        'quota_docs' => json_encode($update_data),
                        'FFQ_type'   => $request->input('FFQ_type', NULL)
                    ]);

                $student->enrollments()->update(['quota' => $quota]);
                $student->applications()->update(['quota' => $quota]);

                return 'Done';

            } else {
                return 'invalid file';
            }
        } else {
            return $validation->messages()->first();
        }
    }

    public function uploadStudentPhoto($student_id)
    {

        session()->remove('photo.student');

        $student = Hsc::find($student_id);


        return view('admin.student.upload_photo')
            ->with('student_data', $student);
    }

    public function saveStudentPhoto(Request $request)
    {

        $student_data = Hsc::find($request->input('student_id'));

        $destinationPath = 'public/uploads/photo-changes/';

        if (trim($student_data->photo) != "") {
            $student_filename = $student_data->photo;
        } else {
            $student_filename = sprintf('%s-%s.jpg', $student_data->id, time());
        }

        $img = Image::make($request->file('photo'))->resize(300, 400);

        Storage::put($destinationPath.$student_filename, $img->stream());

        session()->put('photo.student', $student_filename);

        $data = sprintf('<img src="%s"  class="img-responsive img-thumbnail" width="200" alt="Image">',
            Storage::url('public/uploads/photo-changes/'.$student_filename));

        return $data;
    }

    public function updateStudentPhoto(Request $request)
    {

        $student = Hsc::find($request->student_id);

        echo $new_photo = 'public/uploads/photo-changes/'.session('photo.student');
        echo '<br>';
        echo $old_photo = 'public/uploads/'.$student->photo;
        echo '<br>';

        echo $backup_path = sprintf("public/uploads/old-photos/%s_%s", $student->photo, time());

        if (Storage::exists($new_photo)) {
            echo 'exists';
            // backup old photo
            if (Storage::exists($old_photo)) {
                Storage::copy($old_photo, $backup_path);
                Storage::delete($old_photo);
            }

            $status = Storage::copy($new_photo, $old_photo);
        }

        if ($status) {
            return redirect()->route('admin.student.show', $student->id);
        } else {
            echo "Something Wrong";
        }

    }


    public function loginAsStudent(Hsc $student)
    {
        session(['student' => $student]);
        session(['authorize_this_session' => 1]);

        return redirect()->route('student.getDashboard');

    }

    public function logoutAsStudent()
    {
        session()->forget('student');
        session()->forget('authorize_this_session');
        return redirect()->route('user.dashboard');
    }


    public function allImages(Hsc $student)
    {
        $images = [];
        $path   = 'public/uploads/';
        $pattern = Storage::path($path.$student->id.'-*');

        // get all images like $student->id-*.jpg
        $files = \File::glob($pattern);
        foreach ($files as $file) {
            $images[] = str_replace(Storage::path('public'), '', $file);
        }


        $selfies = [];
        $pattern = Storage::path($path.$student->id.'_selfie*');

        $files = \File::glob($pattern);
        foreach ($files as $file) {
            $selfies[] = str_replace(Storage::path('public'), '', $file);
        }

        $suspected_selfie = [];
        $pattern = Storage::path($path.$student->id.'_suspect_*');
        $files = \File::glob($pattern);
        foreach ($files as $file) {
            $suspected_selfie[] = str_replace(Storage::path('public'), '', $file);
        }


        return view('admin.student.all_images')
            ->with('images', $images)
            ->with('selfies', $selfies)
            ->with('suspected_selfie', $suspected_selfie)
            ->with('student', $student);

    }

    public function postTempSelfie(Request $request, Hsc $student)
    {
        $student->selfie = 'Selfie.jpg';
        $student->save();

        session(['student' => $student]);

        return response('')
            ->header("X-IC-Redirect", route('admin.student.show', $student->id));


    }

    public function postRestoreImage(Request $request, Hsc $student)
    {

        if ($request->has('photo')){
            $photo = $request->input('photo');
            $photo = str_replace('/uploads/', '', $photo);

            $student->update(['photo' => $photo]);

        }

        if ($request->has('selfie')){
            $selfie = $request->input('selfie');
            $selfie = str_replace('/uploads/', '', $selfie);

            $student->update(['selfie' => $selfie]);
        }

        session(['student' => $student]);

        return response('')
            ->header("X-IC-Redirect", route('admin.student.allImages', $student->id));

    }

}
