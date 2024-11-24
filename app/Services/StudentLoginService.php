<?php

namespace App\Services;

use App\Models\Hsc;

class StudentLoginService
{
    public function login($data)
    {
        $student = Hsc::where('HSC_ROLL_NO', $data['hsc_roll'])
            ->where('HSC_PASS_YEAR', $data['hsc_year'])
            ->where('HSC_BOARD_NAME', strtoupper($data['hsc_board']))
            ->where('SSC_ROLL_NO', $data['ssc_roll'])
            ->where('SSC_BOARD_NAME', strtoupper($data['ssc_board']))
            ->where('SSC_PASS_YEAR', $data['ssc_year'])
            ->first();

        if ($student) {
            return $student;
        }

        return null;
    }

    public function getStudentStatusFlags($student, $inputs)
    {
        $statusFlags = [
            'no_data'       => 0,
            'fail'          => 0,
            'name_mismatch' => 0,
            'data_mismatch' => 0,
            'not_eligible'  => 0,
            'oth_no_data'   => 0
        ];


        if ($student == null) {
            if (strtoupper($inputs['hsc_board']) == 'OTH')// oth student has no data
                $statusFlags['oth_no_data'] = 1;
            else
                $statusFlags['no_data'] = 1;

        } else {

            if ($student->HSC_RESULT == 'FAIL' || $student->SSC_RESULT == 'FAIL') {
                $statusFlags['fail'] = 1;
            }

            if ($student->SSC_DATA == 0) {
                $statusFlags['name_mismatch'] = 1;
            }

            //ssc and hsc data mismatch
            if ($student->SSC_ROLL_NO != $inputs['ssc_roll'] ||
                strtoupper($student->SSC_BOARD_NAME) != strtoupper($inputs['ssc_board']) ||
                $student->SSC_PASS_YEAR != $inputs['ssc_year']) {
                $statusFlags['data_mismatch'] = 1;
            }

            //check if not eligible in any unit
            if (array_sum($student->eligibility_array) == 0) {
                $statusFlags['not_eligible'] = 1;
            }
        }

        return $statusFlags;

    }


}
