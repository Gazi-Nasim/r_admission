<?php
namespace App\Library;

use App\Models\Bill;
use App\Models\Hsc;
use Mpdf\Mpdf;

/**
 *
 */
class TestBillPDF
{
    private static $config = [
        'mode'              => '',
        'format'            => 'a4',
        'default_font_size' => 0,
        'default_font'      => 'Arial',
        'margin_left'       => 15,
        'margin_right'      => 15,
        'margin_top'        => 10,
        'margin_bottom'     => 20,
        'margin_header'     => 0,
        'margin_footer'     => 8,
        'orientation'       => 'P'
    ];

    public static function makePDF($bill_id)
    {
        error_reporting(0);
        set_time_limit(0);
        ini_set("pcre.backtrack_limit", "5000000");

        $bill    = Bill::find($bill_id);

        //generate pdf
        $mpdf = new Mpdf(self::$config);

        $mpdf->SetTitle('Bill Sheet');
        $mpdf->SetAuthor('ICT Center, RU');
        $mpdf->SetSubject('Undergraduate Admission Test 2023-24');
        $mpdf->SetProtection(['print', 'print-highres','copy']);

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


         $html = view('pdf.bill_pdf_html')
            ->with('bill', $bill)
            ->with('student', $bill->student);

        // return;


        $mpdf->WriteHTML($html);

        $filename = "A-CenterSeatPlan.pdf";
        $mpdf->Output($filename, 'D');

    }

}


?>
