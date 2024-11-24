<?php

namespace App\Library;

use App\Models\Bill;
use App\Models\Hsc;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class BillPDF
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

    public static function makeApplicationBillPDF($bill_id)
    {
        $bill = Bill::find($bill_id);


        if ($bill) {

            $mpdf = new Mpdf(self::$config);

            $mpdf->SetTitle('Bill Sheet');
            $mpdf->SetAuthor('ICT Center, RU');
            $mpdf->SetSubject('Undergraduate Admission Test 2023-24');
            $mpdf->SetProtection(['print', 'print-highres', 'copy']);

            //========footer================
            $footerHtml = sprintf('
            <div class="container">
                    <hr style="margin: 1px;padding: 0" >
                    <div class="row text-muted" style="font-size: 9pt;" >
                        <div class="col-xs-6" >
                            Powered by – CIC of CSE Department and ICT Center, RU
                        </div>
                        <div class="col-xs-4 text-right pull-right" >
                           Printed at - %s
                        </div>
                    </div>
            </div>', now()->toDateTimeString());

            $mpdf->SetHTMLFooter($footerHtml);
            //========footer================

            $mpdf->SetWatermarkImage(public_path('assets/img/logo.png'), 0.05, [140, 140], 'F');
            $mpdf->showWatermarkImage = true;


            $html = view('pdf.final_application_bill_pdf')
                ->with('bill', $bill)
                ->with('student', $bill->student);

            $output_path = 'public/downloads';

            if (!Storage::exists($output_path)) {
                Storage::makeDirectory($output_path, 0775, true);
            }

            $file_path = 'public/downloads/' . $bill->id . ".pdf";

            $mpdf->WriteHTML($html);
            Storage::put($file_path, $mpdf->Output('', 'S'));

            return $file_path;
        }
    }


    public static function makePreliminaryBillPDF($bill_id)
    {

        $bill    = Bill::find($bill_id);
        $student = Hsc::find($bill->applicant_id);


        if ($bill && $student) {

            $template_path = public_path('/assets/pdf/RUBillTemplate_preliminary.pdf');
            // $logo_path = public_path().'/assets/pdf/logo.png';
            // $qrcode_path = public_path().'/downloads/';


            $applicant_id      = $student->id;
            $units             = strtoupper($bill->units);
            $bill_no           = $bill->id;
            $name              = strtoupper($student->NAME);
            $fname             = strtoupper($student->FNAME);
            $mname             = strtoupper($student->MNAME);
            $mobile_no         = $student->mobile_no;
            $quota             = !empty($student->quota_string) ? $student->quota_string : 'Not Applicable';
            $bill_amount       = $bill->amount;
            $payment_method    = ($bill->payment_status == 1) ? sprintf("Paid by %s [%s]", $bill->payment_method, $bill->updated_at->format('d-M,Y, H:i:s')) : "UNPAID";
            $question_language = ($student->is_english == 1) ? "English" : "Bangla";

            $photo = Storage::path('public/uploads/' . $student->photo);

            $mpdf = new Mpdf(self::$config);
            $mpdf->SetTitle('RU Preliminary Application Bill');
            $mpdf->SetAuthor('ICT Center-RU');
            $mpdf->SetSubject('Undergraduate Admission Test 2020-21');
            $mpdf->SetProtection(array('print', 'print-highres'));
            //            $mpdf->SetImportUse();

            // //page 1
            $mpdf->AddPage();
            $pagecount = $mpdf->SetSourceFile($template_path);
            $tplIdx    = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplIdx);

            $offset = -20;
            $mpdf->SetFont('Arial', '', 18);
            $mpdf->WriteText(105, 89 + $offset, utf8_encode("TK. " . $bill_amount));
            $mpdf->WriteText(105, 97 + $offset, utf8_encode($units));

            $offset = -17.5;
            $mpdf->SetFont('Arial', '', 12);
            $mpdf->WriteText(60, 106.9 + $offset, utf8_encode($applicant_id));
            $mpdf->WriteText(60, 113.9 + $offset, utf8_encode("$name"));
            $mpdf->WriteText(60, 120.7 + $offset, utf8_encode("$fname"));
            $mpdf->WriteText(60, 128.5 + $offset, utf8_encode("$mname"));
            $mpdf->WriteText(60, 136.1 + $offset, utf8_encode("$mobile_no"));
            $mpdf->WriteText(60, 143.2 + $offset, utf8_encode("$quota"));
            $mpdf->WriteText(60, 150.3 + $offset, utf8_encode("$payment_method"));
            $mpdf->WriteText(60, 157.5 + $offset, utf8_encode("$question_language"));

            // $mpdf->WriteText(130, 251.1, utf8_encode($bill_no));

            //insert student photo
            $mpdf->Image($photo, 157, 85.4, 36, 48);

            if ($bill->payment_status == '1') {
                $paid_logo = public_path('/assets/pdf/paid.png');
                $mpdf->SetAlpha(0.85);
                $mpdf->Image($paid_logo, 139, 30, 50, 50);
                $mpdf->SetAlpha(1);
            }

            //   $mpdf->Output($output_path . $bill_no . ".pdf", 'F');

            $output_path = 'public/downloads';

            if (!Storage::exists($output_path)) {
                Storage::makeDirectory($output_path, 0775, true);
            }

            $file_path = $output_path . '/' . $bill_no . ".pdf";


            Storage::put($file_path, $mpdf->Output('', 'S'));

            return $file_path;
        }
    }

    public static function makePhotoChangeBillPDF($bill_id)
    {

        $bill        = Bill::find($bill_id);
        $photoReview = $bill->photoReview;


        if ($bill) {

            $mpdf = new Mpdf(self::$config);

            $mpdf->SetTitle('Bill Sheet');
            $mpdf->SetAuthor('ICT Center, RU');
            $mpdf->SetSubject('Undergraduate Admission Test 2023-24');
            $mpdf->SetProtection(['print', 'print-highres', 'copy']);

            //========footer================
            $footerHtml = sprintf('
            <div class="container">
                    <hr style="margin: 1px;padding: 0" >
                    <div class="row text-muted" style="font-size: 9pt;" >
                        <div class="col-xs-6" >
                            Powered by – CIC of CSE Department and ICT Center, RU
                        </div>
                        <div class="col-xs-4 text-right pull-right" >
                           Printed at - %s
                        </div>
                    </div>
            </div>', now()->toDateTimeString());

            $mpdf->SetHTMLFooter($footerHtml);
            //========footer================

            $mpdf->SetWatermarkImage(public_path('assets/img/logo.png'), 0.05, [140, 140], 'F');
            $mpdf->showWatermarkImage = true;


            $html = view('pdf.photo_change_bill_pdf')
                ->with('bill', $bill)
                ->with('photoReview', $photoReview)
                ->with('student', $bill->student);


            $output_path = 'public/downloads';

            if (!Storage::exists($output_path)) {
                Storage::makeDirectory($output_path, 0775, true);
            }

            $file_path = 'public/downloads/' . $bill->id . ".pdf";

            $mpdf->WriteHTML($html);
            Storage::put($file_path, $mpdf->Output('', 'S'));

            return $file_path;
            //
            //            $template_path = public_path('/assets/pdf/RUBillTemplate_photo_change.pdf');
            //            // $logo_path = public_path().'/assets/pdf/logo.png';
            //            // $qrcode_path = public_path().'/downloads/';
            //
            //
            //            $applicant_id      = $student->id;
            //            $units             = strtoupper($bill->units);
            //            $bill_no           = $bill->id;
            //            $name              = strtoupper($student->NAME);
            //            $fname             = strtoupper($student->FNAME);
            //            $mname             = strtoupper($student->MNAME);
            //            $mobile_no         = ($student->mobile_no ?? "N/A").','.($student->email ?? "N/A");
            //            $quota             = ($bill->quota != NULL) ? strtoupper($bill->quota) : 'Not Applicable';
            //            $bill_amount       = $bill->amount;
            //            $payment_method    = ($bill->payment_status == 1) ? $bill->payment_method : "UNPAID";
            //            $question_language = ($student->is_english == 1) ? 'ENGLISH' : 'BANGLA';
            //
            //            $current_photo = Storage::path('public/uploads/'.$student->photo);
            //            $new_photo     = Storage::path('public/uploads/photo-changes/'.$photoReview->new_photo);
            //
            //            $mpdf = new Mpdf(self::$config);
            //            $mpdf->SetTitle('RU Preliminary Application Bill');
            //            $mpdf->SetAuthor('ICT Center-RU');
            //            $mpdf->SetSubject('Undergraduate Admission Test 2020-21');
            //            $mpdf->SetProtection(array('print', 'print-highres'));
            ////            $mpdf->SetImportUse();
            //
            //            // //page 1
            //            $mpdf->AddPage();
            //            $pagecount = $mpdf->SetSourceFile($template_path);
            //            $tplIdx    = $mpdf->ImportPage($pagecount);
            //            $mpdf->UseTemplate($tplIdx);
            //
            //            $mpdf->SetFont('Arial', '', 18);
            //            $mpdf->WriteText(105, 82, utf8_encode($bill_no));
            //            $mpdf->WriteText(105, 90, utf8_encode("TK. ".$bill_amount));
            //            $mpdf->WriteText(105, 97, utf8_encode("PHOTO CHANGE"));
            //
            //
            //            $mpdf->SetFont('Arial', '', 12);
            //            $mpdf->WriteText(60, 106.9, utf8_encode($applicant_id));
            //            $mpdf->WriteText(60, 113.9, utf8_encode("$name"));
            //            $mpdf->WriteText(60, 120.7, utf8_encode("$fname"));
            //            $mpdf->WriteText(60, 128.5, utf8_encode("$mname"));
            //            $mpdf->WriteText(60, 136.1, utf8_encode("$mobile_no"));
            //            $mpdf->WriteText(60, 143.1, utf8_encode("$quota"));
            //            $mpdf->WriteText(60, 150.1, utf8_encode("$payment_method"));
            //            $mpdf->WriteText(60, 157.5, utf8_encode("$question_language"));
            //
            //            // $mpdf->WriteText(130, 251.1, utf8_encode($bill_no));
            //
            //            //insert student photo
            //            $mpdf->Image($current_photo, 157, 106.9, 24, 32);
            //            $mpdf->WriteText(160, 106.9, utf8_encode("Old Photo"));
            //            //insert new photo
            //            $mpdf->Image($new_photo, 157, 150, 24, 32);
            //            $mpdf->WriteText(160, 150, utf8_encode("New Photo"));
            //
            //            if ($bill->payment_status == '1') {
            //
            //                $paid_logo = public_path('/assets/pdf/paid.png');
            //
            //                $mpdf->SetAlpha(0.85);
            //                $mpdf->Image($paid_logo, 139, 57, 50, 50);
            //                $mpdf->SetAlpha(1);
            //            }
            //
            ////            $mpdf->Output($output_path . $bill_no . ".pdf", 'F');
            //
            //            $output_path = 'public/downloads';
            //
            //            if (!Storage::exists($output_path)) {
            //                Storage::makeDirectory($output_path, 0775, true);
            //            }
            //
            //            $file_path = $output_path.'/'.$bill_no.".pdf";
            //
            //
            //            Storage::put($file_path, $mpdf->Output('', 'S'));
            //
            //            return $file_path;


        }
    }
}
