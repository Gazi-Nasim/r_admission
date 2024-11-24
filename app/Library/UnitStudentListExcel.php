<?php
namespace App\Library;

use App\Models\Department;
use App\Models\SubjectOption;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UnitStudentListExcel
{

    public static function create($unit, $file_name)
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);

        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->getProperties()->setCreator("Me")
            ->setLastModifiedBy("Me")
            ->setTitle("My Excel Sheet")
            ->setSubject("My Excel Sheet")
            ->setDescription("Excel Sheet")
            ->setKeywords("Excel Sheet")
            ->setCategory("Me");

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Add column headers
        $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'Unit')
            ->setCellValue('B1', 'Group')
            ->setCellValue('C1', 'Exam Roll')
            ->setCellValue('D1', 'Name')
            ->setCellValue('E1', 'Position')
            ->setCellValue('F1', 'Subject')
            ->setCellValue('G1', 'Office Status')
            ->setCellValue('H1', 'Bill No')
            ->setCellValue('I1', 'Bill Status')
            ->setCellValue('J1', 'Stu. Category')
            ->setCellValue('K1', 'Migration Stop')
            ->setCellValue('L1', 'Opt-Out');

        $unitStudentOptions = SubjectOption::where('unit', $unit)
            ->where('office_status', '1')
            ->orderBy('admission_subject')
            ->get();

        $ii = 2;
        foreach ($unitStudentOptions as $subjectOption) {

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $subjectOption->unit);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $subjectOption->exam_group_no);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $subjectOption->admission_roll);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $subjectOption->student->NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $subjectOption->position);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, $subjectOption->admission_subject->name);

            if ($subjectOption->office_status == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, 'Approved');
            } elseif ($subjectOption->office_status == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, 'Pending');
            } elseif ($subjectOption->office_status == -1) {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, 'Canceled');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $subjectOption->bill_id);

            $bill_status = ($subjectOption->bill_status == 1) ? 'Paid' : 'Unpaid';
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$ii, $bill_status);

            //---- category_name--------
            $category_name = $subjectOption?->studentCategory?->category_name ?? '';
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$ii, $category_name);
            //------------

            //migration stop----------
            if (!empty($subjectOption->migration_stop)) {
                $migration_dept = Department::where('dept_code', $subjectOption->migration_stop)->first()->name;
                $migration_stop = $migration_dept;
            } else {
                $migration_stop = '';
            }
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$ii, $migration_stop);
            //------------------------

            //------optout list-------
            $opt_out_array = $subjectOption->choices()
                ->where('opt_out', '2')
                ->pluck('dept_code')->toArray();

            $opt_out_str = empty($opt_out_array) ? '' : implode(',', $opt_out_array);

            $objPHPExcel->getActiveSheet()->setCellValue('L'.$ii, $opt_out_str);

            $ii += 1;
        }


        //-----------------[Style INfo]----------------------------------
        $objPHPExcel->getActiveSheet()
            ->getHeaderFooter()
            ->setOddHeader('&B'.'Student List For Unit -'.$unit);

        $objPHPExcel->getActiveSheet()
            ->getHeaderFooter()
            ->setOddFooter('&R&B Page &P of &N');


        $columns = range('A', 'L');
        foreach ($columns as $column) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $header = '1';
        foreach ($columns as $column) {
            $objPHPExcel->getActiveSheet()->getStyle($column.$header)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle($column.$header)->getFill()
                ->setFillType( Fill::FILL_SOLID)
                ->getStartColor()->setRGB('ffffce');
        }
        // $objPHPExcel->getActiveSheet()->setTitle('My NAme');
        //---------------------------------------------------------


        $output_path = 'downloads/';

        if (!Storage::exists($output_path)) {
            Storage::makeDirectory($output_path, 0775, true);
        }

        $file_path = public_path().'/'.$file_name;

        $objWriter =new Xlsx($objPHPExcel);
        $objWriter->save($file_path);

        return $file_path;

    }

}

?>
