<?php
namespace App\Library;

use DB;
use Illuminate\Support\Facades\File;

/**
 *
 */
class AppUtility
{

    public static function extractEligibityData($student_data)
    {
        if ($student_data) {
            $e = array();

            $e['A'] = $student_data->A;
            $e['B'] = $student_data->B;
            $e['C'] = $student_data->C;
            $e['D'] = $student_data->D;
            $e['E'] = $student_data->E;

            return $e;

        } else {
            return null;
        }
    }


    public static function extractEligibityDataForApplication($student_data)
    {
        $keys = range('A', 'E');
        $e    = array_fill_keys($keys, 0);

        if ($student_data->enrollments) {

            $applicable_units = $student_data->enrollments()
                ->where('status', '>', '0')->pluck('unit');

            foreach ($applicable_units as $unit) {
                $e[$unit] = 1;
            }

            return $e;

        } else {
            return null;
        }
    }


    /**
     * determine in which category student belongs.
     * FOR C,D and F unit hetarogenious their roll range will be different
     * @param string $unit unit applying
     * @param string $ru_group equivalent RU group
     * @return string           main/other
     */
    public static function get_roll_group($unit, $ru_group)
    {

        $roll_groups = array(
            'C' => array('S' => 'main', 'C' => 'other', 'H' => 'other'),
            'D' => array('C' => 'main', 'S' => 'other', 'H' => 'other'),
            'F' => array('S' => 'main', 'C' => 'other', 'H' => 'other'),
        );

        if (in_array($unit, array('A', 'B', 'E', 'G', 'H', 'I'))) {
            return 'main';
        } else {
            return $roll_groups[$unit][$ru_group];
        }
    }

    public static function generate_tracking_no($student_data)
    {

        $board_code = DB::table('boards')
            ->where('board_name', '=', $student_data->HSC_BOARD_NAME)
            ->where('exam', '=', 'HSC')
            ->first()->id;

        $tracking_no = substr($student_data->HSC_PASS_YEAR, 2)
            . str_pad($board_code, 2, '0', STR_PAD_LEFT)
            . str_pad($student_data->id, 6, '0', STR_PAD_LEFT);

        return $tracking_no;

    }

    public static function setElegibilityArray($hsc_data, $ssc_data)
    {

        //$e = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0 ];
        $keys = range('A', 'E');
        $e    = array_fill_keys($keys, 0);

        $ru_group = $hsc_data->RU_HSC_GROUP;

        $hsc_gpa    = $hsc_data->HSC_GPA;
        $hsc_result = $hsc_data->HSC_RESULT;

        $hsc_math = trim($hsc_data->MATHEMATICS) != '' ? trim($hsc_data->MATHEMATICS) : '';
        $hsc_bio = trim($hsc_data->BIOLOGY) != '' ? trim($hsc_data->BIOLOGY) : '';

        $ssc_gpa    = $ssc_data->SSC_GPA;
        $ssc_result = $ssc_data->RESULT;
        $total_gpa = $hsc_gpa + $ssc_gpa;

        if ($hsc_result == "PASS" && $ssc_result == "PASS") {

            switch ($ru_group) {
                case 'H':
                    if ($ssc_gpa >= 3.0 && $hsc_gpa >= 3.0 && $total_gpa >= 7.0) {
                        $e['A'] = 1;
                        $e['B'] = 1;
                        $e['C'] = 1;
                        $e['D'] = 0;
                        $e['E'] = 0;
                    }
                    break;

                case 'C':
                    if ($ssc_gpa >= 3.5 && $hsc_gpa >= 3.5 && $total_gpa >= 7.5) {
                        $e['A'] = 1;
                        $e['B'] = 1;
                        $e['C'] = 1;
                        $e['D'] = 0;
                        $e['E'] = 0;
                    }
                    break;

                case 'S':
                    if ($ssc_gpa >= 3.5 && $hsc_gpa >= 3.5 && $total_gpa >= 8.0) {
                        $e['A'] = 1;
                        $e['B'] = 1;
                        $e['C'] = 1;
                        $e['D'] = 0;
                        $e['E'] = 0;
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }

        return $e;

    }


    public static function isPhotoMissing($student_data)
    {
        // chech if he has applied in any unit
        $application_count = count($student_data->applications);

        $photo_missing = false;

        if ($application_count) {
            $photo_dir = public_path() . '/uploads/';
            $file_path = $photo_dir . $student_data->photo;

            if (File::exists($file_path)) {
                $photo_missing = false;
            } else {
                $photo_missing = true;
            }

        } else {
            $photo_missing = false;
        }

        return $photo_missing;

    }



}


?>
