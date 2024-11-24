<?php
namespace App\Library;

use DNS2D;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use function GuzzleHttp\Promise\is_rejected;

class AdmitCardPDF
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


    public static function makePDF($application)
    {
        // $faculty = [
        // 			'A'=>'Faculty of Arts',
        // 			'B'=>'Faculty of Law',
        // 			'C'=>'Faculty of Science',
        // 			'D'=>'Faculty of Business Studies',
        // 			'E'=>'Faculty of Social Science',
        // 			'F'=>'Faculty of Life & Earth Science',
        // 			'G'=>'Faculty of Agriculture',
        // 			'H'=>'Faculty of Engineering',
        // 			'I'=>'Faculty of Fine Arts',
        // 			'J'=>'Institute of Business Administration',
        // 			'K'=>'Institute of Education and Research'
        // ];


        $student = $application->student;

        $name         = strtoupper($student->NAME);
        $fname        = strtoupper($student->FNAME);
        $mname        = strtoupper($student->MNAME);
        $unit         = $application->unit;
        $roll         = $application->admission_roll;
        $applicant_id = $student->id;

        $isRejected = false;

        if ($student->photo_status == 'R') {
            $photo_url  = public_path('/assets/img/placeholder_photo_rejected.jpg');
            $isRejected = true;
        } else {
            $photo_url  = Storage::url('public/uploads/'.$student->photo);
        }

        if ($student->selfie_status == 'R') {
            $selfie_url = public_path('/assets/img/placeholder_selfie_rejected.jpg');
            $isRejected = true;
        } else {
            $selfie_url = Storage::url('public/uploads/'.$student->selfie);
        }


        //$data       = "$unit$roll>>>$name>>>$fname>>>$mname>>>$applicant_id";
        $data       = route('admin.misc.studentInfoVerify',$roll);
        //dd($data);
        $qrcode_data = DNS2D::getBarcodePNG($data, "QRCODE", 4, 4);
        $qrcode_file = 'public/downloads/admit_card/'.$applicant_id.'.png';
        Storage::put($qrcode_file, base64_decode($qrcode_data));
        $qrcode_url = Storage::url($qrcode_file);

        //generate pdf
        $mpdf = new Mpdf(self::$config);
        $mpdf->SetTitle('Admit Card '.$application->unit.$application->admission_roll);
        $mpdf->SetAuthor('ICT Center-RU');
        $mpdf->SetSubject('Undergraduate Admission Test 2023-24');
        $mpdf->SetProtection(array('print', 'print-highres'));
        //$mpdf->SetImportUse();

        //page 1
        self::addPage($mpdf, $application, $photo_url, $selfie_url, $qrcode_url,$isRejected ,"Candidate Copy");

        //page 2
        self::addPage($mpdf, $application, $photo_url, $selfie_url, $qrcode_url,$isRejected ,"University Copy");


        $output_path = 'public/downloads/admit_card/';

        if (!Storage::exists($output_path)) {
            Storage::makeDirectory($output_path, 0775, true);
        }

        $file_path = sprintf("%s/%s-%s.pdf", $output_path, $unit, $roll);

        //$mpdf->Output($file_path, 'F');

        Storage::put($file_path, $mpdf->Output('', 'S'));

        return $file_path;

    }

    private static function addPage(Mpdf &$mpdf, $application, $photo_url, $selfie_url, $qrcode_url,$isRejected ,string $copyFor)
    {
        $faculty = [
            'A' => 'UNIT A',
            'B' => 'UNIT B',
            'C' => 'UNIT C',
            'D' => 'UNIT D',
            'E' => 'UNIT E',
        ];

        $template_path = public_path('/assets/pdf/RUAdmitCardTemplate.pdf');
        $logo_path     = public_path('/assets/pdf/logo.png');


        $student = $application->student;

        $name              = strtoupper($student->NAME);
        $fname             = strtoupper($student->FNAME);
        $mname             = strtoupper($student->MNAME);
        $unit              = $application->unit;
        $exam_date         = $application->exam_date;
        $exam_time         = $application->exam_time;
        $building          = $application->building;
        $room              = $application->room;
        $seat              = str_pad($application->seat, 3, "0", STR_PAD_LEFT);
        $tracking_no       = $application->applicant_id;
        $question_language = $student->is_english == '1' ? 'ENGLISH' : 'BANGLA';

        $quota = ($student->quota_string != '') ? $student->quota_string : 'Not Applicable';

//        dd($quota);


        $roll   = $application->admission_roll;
        $digits = str_split($roll);

        $group_no = "GROUP-".$application->exam_group_no;

        // create qrcode file
        $data = "$unit$roll>>>$name>>>$fname>>>$mname>>>$tracking_no";

        $mpdf->AddPage();
        $pagecount = $mpdf->SetSourceFile($template_path);
        $tplIdx    = $mpdf->ImportPage($pagecount);
        $mpdf->UseTemplate($tplIdx);
        $actualsize = $mpdf->UseTemplate($tplIdx);
        $mpdf->SetFont('Arial', 'B', 11);
        $mpdf->WriteText(22, 25.5, $copyFor);

        $mpdf->SetAlpha(.15);
        $mpdf->Cell(180, 42.5, '', 0, 2, 'C', '');
        $mpdf->AutosizeText(strtoupper($faculty[$unit]), 170, 'Arial', 'B', 72);
        $mpdf->SetAlpha(1.0);

        $mpdf->SetFont('FreeMono', '', 20);
        $mpdf->WriteText(44, 79, $unit);
        $mpdf->SetFont('Arial', '', 20);
        $mpdf->WriteText(115, 79.5, "$digits[0]");
        $mpdf->WriteText(128, 79.5, "$digits[1]");
        $mpdf->WriteText(141, 79.5, "$digits[2]");
        $mpdf->WriteText(154, 79.5, "$digits[3]");
        $mpdf->WriteText(168, 79.5, "$digits[4]");
        $mpdf->WriteText(181, 79.5, "$digits[5]");


        $mpdf->SetFont('FreeMono', '', 18);
        $mpdf->WriteText(163, 70.5, "$group_no");

        $offset = 0.5;
        $mpdf->SetFont('Arial', '', 12);
        $mpdf->WriteText(50, 92.5 + $offset, "$name");
        $mpdf->WriteText(50, 100.5 + $offset, "$fname");
        $mpdf->WriteText(50, 108.5 + $offset, "$mname");
        $mpdf->WriteText(50, 116.5 + $offset, "$quota");
        $mpdf->WriteText(50, 125 + $offset, "$question_language");

        $mpdf->SetFont('Arial', 'B', 12);
        $mpdf->WriteText(50, 125.5 + 11, "$exam_date");
        $mpdf->WriteText(50, 130.5 + 11, "$exam_time");
        $mpdf->WriteText(50, 138.5 + 11, "Room# $room, Seat# $seat");
        $mpdf->SetFont('Arial', 'B', 11);
        $mpdf->WriteText(50, 143.5 + 12, "$building");
        $mpdf->WriteText(50, 148.5 + 12, "University of Rajshahi");

        // $cx = $cy = 0;
        // if($unit == 'C'){ $cx = 0.5; $cy = -1.5;}

        $cx = 0.5;
        $cy = -1.5;
        //photo
        $mpdf->Image($photo_url, 152.5, 88.5, 37.5, 50);

        $mpdf->Image($selfie_url, 152.5, 142, 37.5, 50);

        // admission logo
        $mpdf->SetAlpha(0.5);
        $mpdf->Image($logo_path, 140.0 + $cx, 126 + $cy, 25, 25);

        // qr code
        $mpdf->SetAlpha(1);
        $mpdf->Image($qrcode_url, 165.5, 20, 24, 24);


        if ($isRejected){
            $photoCollectionSeal= public_path('/assets/img/photo_collection_seal.png');
            $mpdf->Image($photoCollectionSeal, 80, 165, 48, 18);
        }



        //applicant id for office at the bottom
        $mpdf->SetFont('FreeMono', '', 10);
        $mpdf->SetAlpha(0.8);
        $mpdf->WriteText(20, 288, "$application->applicant_id");
    }


}


?>
