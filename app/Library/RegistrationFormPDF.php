<?php
namespace App\Library;

use App\Models\SubjectOption;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class RegistrationFormPDF
{
    private static $config = [
        'mode'              => '',
        'format'            => 'a4',
        'default_font_size' => 0,
        'default_font'      => 'Arial',
        'margin_left'       => 20,
        'margin_right'      => 20,
        'margin_top'        => 20,
        'margin_bottom'     => 16,
        'margin_header'     => 0,
        'margin_footer'     => 9,
        'orientation'       => 'P'
    ];

    public static function makePDF($subject_option_id)
    {

        $subjectOption = SubjectOption::find($subject_option_id);

        if ($subjectOption) {
            $application     = $subjectOption->application;
            $student         = $subjectOption->student;
            $student_details = $subjectOption->student->studentDetails;

            $template_path = public_path('/assets/pdf/registration_form.pdf');

            // section 1
            $bill_number = $subjectOption->bill->id;
            $bill_amoumt = 'Tk. '.number_format($subjectOption->bill->amount, 2);

            switch ($subjectOption->bill->payment_status) {
                case '1':
                    $bill_status = "Paid";
                    break;
                case '0':
                    $bill_status = "Unpaid";
                    break;
                case '-1':
                    $bill_status = "Canceled";
                    break;
                default:
                    $bill_status = "Error";
                    break;
            }

            $student_id     = "N/A";
            $exam_roll      = $application->admission_roll;
            $exam_score     = $subjectOption->exam_score;
            $merit_position = $subjectOption->position;
            $reg_no         = "N/A";
            $category       = $subjectOption->unit."-".$subjectOption->exam_group_no;

            // basic
            $photo_path = $photo = Storage::path('public/uploads/'.$student->photo);
            $fullname   = $student->NAME;
            $ac_session = '2023-24';
            $faculty    = $subjectOption->admission_subject->faculty->faculty_name;
            $department = $subjectOption->admission_subject->name;
            $program    = $subjectOption->admission_subject->degree_name;
            $hall       = ($subjectOption->hall != null) ? $subjectOption->hall->name : "N/A";
            $quota      = ($student->quota_string != null) ? $student->quota_string : "N/A";

            /////
            $date_of_birth  = $student_details->dob;
            $place_of_birth = $student_details->birth_place;
            $blood_group    = $student_details->blood_group;
            $gender         = $student_details->gender;
            $mobile_no      = $student->mobile_no;
            $mname          = $student->MNAME;
            $fname          = $student->FNAME;
            $guardian_name  = $student_details->guardian_name;
            $guardian_rel   = $student_details->guardian_relation;
            $em_address     = $student_details->email;
            $national_id    = $student_details->nid_no;
            $birth_regno    = $student_details->birth_reg_no;
            $passport_no    = $student_details->passport_no;
            $nationality    = $student_details->nationality;
            $religion       = $student_details->religion;
            $height         = $student_details->height;
            /////
            $permanent_addr     = $student_details->permanent_address;
            $permanent_thana    = $student_details->permanent_ps_upazila;
            $permanent_district = $student_details->permanent_district;
            $permanent_post     = $student_details->permanent_post_office;
            //////
            $present_addr     = $student_details->current_address;
            $present_thana    = $student_details->current_ps_upazila;
            $present_district = $student_details->current_district;
            $present_post     = $student_details->current_post_office;
            /////
            $emergency_contact  = $student_details->emergency_name;
            $emergency_address  = $student_details->emergency_address;
            $emergency_relation = $student_details->emergency_relation;
            $emergency_phone    = $student_details->emergency_contact;
            /////
            $hsc_roll      = $student->HSC_ROLL_NO;
            $ssc_roll      = $student->SSC_ROLL_NO;
            $hsc_year      = $student->HSC_PASS_YEAR;
            $ssc_year      = $student->SSC_PASS_YEAR;
            $hsc_board     = $student->HSC_BOARD_NAME;
            $ssc_board     = $student->SSC_BOARD_NAME;
            $hsc_regno     = $student->HSC_REGNO;
            $ssc_regno     = $student->SSC_REGNO ?? "";
            $hsc_group     = $student->HSC_GROUP;
            $ssc_group     = $student->SSC_GROUP;
            $hsc_gpa       = $student->HSC_GPA;
            $ssc_gpa       = $student->SSC_GPA;
            $hsc_ltrgrd    = $student->HSC_LTRGRD;
            $ssc_ltrgrd    = $student->SSC_LTRGRD ?? "";
            $hsc_institute = $student_details->hsc_institute;
            $ssc_institute = $student_details->ssc_institute;
            /////////////

            date_default_timezone_set('Asia/Dhaka');
            $dt = date('d M Y, h:i a');


            //================================================
            $mpdf = new Mpdf(self::$config);
            $mpdf->SetTitle('RU Bill');
            $mpdf->SetAuthor('ICT Center-RU');
            $mpdf->SetSubject('Undergraduate Admission Test 2023-24');
            $mpdf->SetProtection(array('print', 'print-highres'));
            $mpdf->SetDocTemplate($template_path, 1);

            //----------[ page 1]-----------------------
            $mpdf->AddPage();

            // bill status
            $mpdf->WriteFixedPosHTML("<b>Bill No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b> $bill_number", 18, 20, 100, 100);
            $mpdf->WriteFixedPosHTML("<b>Bill Amount :</b> $bill_amoumt ($bill_status)", 18, 25, 150, 100);

            $mpdf->Image($photo_path, 170, 15, 24, 28, 'jpg', '', true, true, false);

            $code    = $student->id; //barcode
            $barcode = '<div><barcode code="'.$code.'" type="C128A" size="0.6" height="1.5" /></div>';
            $mpdf->WriteFixedPosHTML($barcode, 165, 46, 160, 200);


            $mpdf->SetWatermarkText('                                     University of Rajshahi');
            $mpdf->watermark_font    = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;


            $mpdf->WriteFixedPosHTML("$exam_roll", 38, 61, 100, 100);
            $mpdf->WriteFixedPosHTML(sprintf("%0.2f", "$exam_score"), 98, 61, 150, 100);
            $mpdf->WriteFixedPosHTML("$merit_position", 152, 61, 150, 200);

            $mpdf->WriteFixedPosHTML("$student_id", 38, 68, 100, 100);

            $mpdf->WriteFixedPosHTML("$reg_no", 98, 68, 100, 100);
            $mpdf->WriteFixedPosHTML("$category", 152, 68, 150, 200);

            // basic Information
            //$mpdf->WriteFixedPosHTML(ucwords(strtolower("$fullname")),51,88,100,100);
            $mpdf->WriteFixedPosHTML("$fullname", 52, 88, 100, 100);

            // $mpdf->WriteFixedPosHTML(banglaText("$name_bangla"),54,72,100,200);
            $mpdf->WriteFixedPosHTML("$ac_session", 52, 94, 140, 200);
            $mpdf->WriteFixedPosHTML("$program", 147, 94.5, 150, 200);

            $mpdf->WriteFixedPosHTML("$faculty", 52, 100.5, 150, 200);
            $mpdf->WriteFixedPosHTML("$department", 52, 107, 150, 200);
            $mpdf->WriteFixedPosHTML("$hall", 52, 113.5, 150, 200);
            $mpdf->WriteFixedPosHTML("$quota", 52, 120, 150, 200);
            // Personal Information =================================

            $mpdf->WriteFixedPosHTML("$date_of_birth", 48, 140, 100, 100);
            //$mpdf->WriteFixedPosHTML(ucwords(strtolower("$place_of_birth")),140,145,100,100);
            $mpdf->WriteFixedPosHTML("$blood_group", 48, 146, 100, 100);
            $mpdf->WriteFixedPosHTML("$mobile_no", 48, 153, 100, 100);
            $mpdf->WriteFixedPosHTML("$national_id", 48, 159, 100, 100);
            $mpdf->WriteFixedPosHTML("$birth_regno", 48, 165, 100, 100);
            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$nationality")), 48, 171.5, 150, 200);

            // Right Column
            $mpdf->WriteFixedPosHTML("$place_of_birth", 149, 139.5, 135, 200);
            $mpdf->WriteFixedPosHTML("$gender", 150, 146, 150, 200);
            $mpdf->WriteFixedPosHTML("$em_address", 150, 152.5, 150, 200);
            $mpdf->WriteFixedPosHTML("$passport_no", 157, 159, 150, 200);
            $mpdf->WriteFixedPosHTML("$religion", 157, 165, 150, 200);
            $mpdf->WriteFixedPosHTML("$height", 157, 171.5, 150, 200);

            $mpdf->WriteFixedPosHTML("$mname", 48, 178, 100, 100);
            $mpdf->WriteFixedPosHTML("$fname", 48, 184, 100, 100);
            $mpdf->WriteFixedPosHTML("$guardian_name [$guardian_rel]", 72, 191, 100, 100);

            // Permanent Address =================================

            $mpdf->WriteFixedPosHTML("$permanent_addr", 47, 217, 150, 200);
            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$permanent_thana")), 37, 223, 100, 100);
            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$permanent_district")), 138, 223, 150, 200);
            $mpdf->WriteFixedPosHTML("$permanent_post", 37, 230, 100, 100);

            // Present Address =================================
            $mpdf->WriteFixedPosHTML("$present_addr", 47, 249, 150, 200);
            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$present_thana")), 37, 256, 100, 100);
            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$present_district")), 138, 256, 150, 200);
            $mpdf->WriteFixedPosHTML("$present_post", 37, 262, 100, 100);

            $mpdf->WriteFixedPosHTML("Page:1/2", 100, 280, 100, 100);


            //------------[page 2]----------------------------------------
            $mpdf->AddPage();
            // Emergency Contact =================================
            $mpdf->WriteFixedPosHTML("$emergency_contact", 46, 26.5, 150, 200);
            $mpdf->WriteFixedPosHTML("$emergency_relation", 40, 32.5, 100, 100);
            $mpdf->WriteFixedPosHTML("$emergency_phone", 151, 32.5, 150, 200);

            //6. Prevoius Academic Information =================================

            $mpdf->WriteFixedPosHTML("$ssc_roll", 40, 58, 110, 100);
            $mpdf->WriteFixedPosHTML("$ssc_regno", 63, 58, 100, 100);
            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$ssc_group")), 104, 58, 100, 100);
            $mpdf->WriteFixedPosHTML("$ssc_year", 152, 58, 100, 100);
            $mpdf->WriteFixedPosHTML("$ssc_gpa", 180, 58, 150, 150);
            // $mpdf->WriteFixedPosHTML(sprintf("%0.2f","$ssc_gpa"),175,29,150,150);


            $mpdf->WriteFixedPosHTML("$hsc_roll", 40, 66, 100, 100);
            $mpdf->WriteFixedPosHTML("$hsc_regno", 63, 66, 100, 100);
            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$hsc_group")), 104, 66, 150, 100);
            $mpdf->WriteFixedPosHTML("$hsc_year", 152, 66, 100, 100);
            $mpdf->WriteFixedPosHTML("$hsc_gpa", 180, 66, 150, 150);

            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$ssc_board")), 43, 74, 100, 100);
            $mpdf->WriteFixedPosHTML(ucwords(strtolower("$hsc_board")), 129, 74, 150, 100);
            $mpdf->WriteFixedPosHTML('<span style="font-size: 9pt">'.$ssc_ltrgrd.'</span>', 43, 82, 150, 80, "auto");
            $mpdf->WriteFixedPosHTML('<span style="font-size: 9pt">'.$hsc_ltrgrd.'</span>', 43, 90, 150, 80, "auto");

            $mpdf->WriteFixedPosHTML("$ssc_institute", 43, 97, 150, 200);
            $mpdf->WriteFixedPosHTML("$hsc_institute", 43, 105, 150, 200);


            // Water Mark
            $mpdf->SetWatermarkText('                                University of Rajshahi');
            $mpdf->watermark_font    = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;

            $mpdf->WriteFixedPosHTML('<span style="font-size: 9pt">ICTC/printed on '.$dt.'</span>', 15, 280, 100, 100);
//			$mpdf->WriteFixedPosHTML("$dt",43,280,100,100);
            $mpdf->WriteFixedPosHTML("Page:2/2", 100, 280, 100, 100);


            $file_name = sprintf("Registration_%s%s_%s.pdf", $subjectOption->unit, $subjectOption->admission_roll, rand());
            $mpdf->Output($file_name, 'D');

            //$mpdf->Output($output_path.$filename,'F');

        }

    }


}


?>
