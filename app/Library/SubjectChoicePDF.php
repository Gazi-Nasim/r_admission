<?php
namespace App\Library;

use App\Models\SubjectOption;
use Mpdf\Mpdf;

class SubjectChoicePDF
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

    public static function makePDF($subjectOptionId)
    {

        $subjectOption = SubjectOption::find($subjectOptionId);

        $application = $subjectOption->application;

        $studentChoices = $subjectOption->choices()->with('department')
            ->orderBy('dept_code')
            ->get();

        $student = $subjectOption->student;


        if ($studentChoices) {


            $template_path = public_path().'/assets/pdf/subject_choice_template.pdf';

            $name         = strtoupper($student->NAME);
            $fname        = strtoupper($student->FNAME);
            $mname        = strtoupper($student->MNAME);
            $metir        = $subjectOption->position;
            $last_update  = $subjectOption->updated_at;
            $unit         = $subjectOption->unit;
            $quota        = empty($student->quota_string) ? 'Not Applicable' : strtoupper($student->quota_string);
            $applicant_id = $subjectOption->applicant_id;

            $downloaded_at = now();

            $roll   = $application->admission_roll;
            $digits = str_split($roll);
//            $digit1 = ($roll / 10000) % 10;
//            $digit2 = ($roll / 1000) % 10;
//            $digit3 = ($roll / 100) % 10;
//            $digit4 = ($roll / 10) % 10;
//            $digit5 = ($roll % 10);

            $group_no = "GROUP-".$application->exam_group_no;

            //generate pdf
            $mpdf = new Mpdf(self::$config);
            $mpdf->SetTitle('Subject Choice Form '.$unit.$roll);
            $mpdf->SetAuthor('ICT Center-RU');
            $mpdf->SetSubject('Undergraduate Admission Test 2018-19');
            $mpdf->SetProtection(array('print', 'print-highres'));

            //page 1
            $mpdf->AddPage();
            $pagecount = $mpdf->SetSourceFile($template_path);
            $tplIdx    = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplIdx);
            /**/
            $mpdf->SetFont('Arial', 'B', 11);
            $mpdf->SetAlpha(1.0);

            // $mpdf->SetFont('Arial', '', 18);
            // $mpdf->WriteText(94,60.5,"Unit - $unit");
            $offset = -9.5;

            $mpdf->SetFont('FreeMono', '', 20);
            $mpdf->WriteText(44, 66 + $offset, $unit);
            $mpdf->SetFont('Arial', '', 20);
            // $mpdf->WriteText(114,66.5,"$unit");
            $mpdf->WriteText(123.5, 66.5 + $offset, $digits[0]);
            $mpdf->WriteText(135, 66.5 + $offset, $digits[1]);
            $mpdf->WriteText(147, 66.5 + $offset, $digits[2]);
            $mpdf->WriteText(158.5, 66.5 + $offset, $digits[3]);
            $mpdf->WriteText(170, 66.5 + $offset, $digits[4]);
            $mpdf->WriteText(182, 66.5 + $offset, $digits[5]);

            $mpdf->SetFont('FreeMono', '', 18);
            $mpdf->WriteText(163, 49.5, "$group_no");


            $offset = -9;
            $mpdf->SetFont('Arial', '', 11);
            $mpdf->WriteText(58, 79.5 + $offset, "$name");
            $mpdf->WriteText(58, 84.1 + $offset, "$fname");
            $mpdf->WriteText(58, 89 + $offset, "$mname");
            $mpdf->WriteText(58, 93.7 + $offset, "$applicant_id");
            $mpdf->WriteText(58, 98.4 + $offset, "$quota");
            $mpdf->WriteText(58, 103.2 + $offset, "$metir");
            $mpdf->WriteText(58, 108 + $offset, "$last_update");

            $mpdf->SetFont('Arial', '', 10);
            $mpdf->SetAlpha(0.8);
            $mpdf->WriteText(20, 281.1, "Downloaded at: $downloaded_at");


            $html = '<br>';

            $html .= '<table align="center" width="90%" border="1" style="margin-top:3.35in; border-collapse: collapse">';
            $html .= ' <tr>';
            $html .= ' <th>Subject</th>';
            $html .= ' <th>Choice</th>';
            $html .= ' </tr>';

            foreach ($studentChoices as $choice) {
                $html .= ' <tr>';
                $html .= ' <td style="padding: 0 5px">'.$choice->department->name.'</td>';

                if ($choice->opt_out == '0') {
                    $html .= ' <td align="center">'.($choice->priority + 1).'</td>';
                } else {
                    $html .= ' <td align="center">-</td>';
                }

                $html .= ' </tr>';
            }

            $html .= '</table>';

            if ($subjectOption->is_bksp == -1) {
                $html .= '<p style="margin: 0 30px; font-weight: bold">* You have not uploaded BKSP Certificate</p>';
            }

            $mpdf->WriteHTML($html);

            $file_name = 'Choice-form_'.strtoupper($unit).$roll.".pdf";
            $mpdf->Output($file_name, 'D');
            // $mpdf->Output($output_path."/".strtoupper($unit).$roll.".pdf",'F');
            // $mpdf->Output($file_name,'D');

        }

    }


}


?>
