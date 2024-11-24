<?php

namespace App\Http\Controllers;


use App\Models\Hsc;
use App\Models\PageContent;
use Exception;

class SiteController extends Controller
{

    public function getHome()
    {
        $student = session('student', null);
        $popupContent = PageContent::where('name', 'home_page_popup')->first();
        $pageHomeMain = PageContent::where('name', 'page_home_main')->first();

        return view('site.home')
            ->with('popupContent', $popupContent)
            ->with('pageHomeMain', $pageHomeMain)
            ->with('student', $student);
    }

    public function getPaymentInfo()
    {
        $content = PageContent::where('name', 'page_payment_info')->first();

        return view('site.payment_instruction', compact('content'));
    }


    public function getAdmissionInstruction()
    {
        return view('site.admission_instruction');
    }

    public function getApplicationGuideline()
    {
        if (setting('activate_preliminary_application')=='1'){
            $content = PageContent::where('name', 'preliminary_application_guideline')->first();
        } else{
            $content = PageContent::where('name', 'final_application_guideline')->first();
        }

        return view('site.application_guideline', compact('content'));

    }

    public function getPhotoGuideline()
    {
        $content = PageContent::where('name', 'page_photo_guideline')->first();
        return view('site.photo_guideline', compact('content'));

    }

    public function getContact()
    {
        $content = PageContent::where('name', 'page_contact')->first();
        return view('site.contact', compact('content'));
    }

    public function getAdmitCard($encryptedData)
    {
        try {
            $decrypted = decrypt($encryptedData);
            $data      = explode('|', $decrypted);

            $student_id = $data[0];
            $unit       = $data[1];

            $student = Hsc::find($student_id);

            return app(PostApplicationController::class)->getDownloadAdmitCard($student, $unit);


        } catch (Exception $e) {
            abort(404);
        }


    }


}

