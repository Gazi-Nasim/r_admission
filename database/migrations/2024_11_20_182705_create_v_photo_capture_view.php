<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVPhotoCaptureView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement("CREATE VIEW `v_photo_capture` AS select `ru_admission_24`.`applications`.`applicant_id` AS `applicant_id`,`ru_admission_24`.`applications`.`admission_roll` AS `admission_roll`,`ru_admission_24`.`applications`.`name` AS `name`,`ru_admission_24`.`applications`.`unit` AS `unit`,`ru_admission_24`.`applications`.`building` AS `building`,`ru_admission_24`.`applications`.`room` AS `room`,`ru_admission_24`.`applications`.`seat` AS `seat`,`ru_admission_24`.`applications`.`exam_date` AS `exam_date`,`ru_admission_24`.`applications`.`exam_time` AS `exam_time` from `ru_admission_24`.`bills` join `ru_admission_24`.`applications` where ((`ru_admission_24`.`bills`.`payment_purpose` = 'PR') and (`ru_admission_24`.`bills`.`payment_status` = 1) and (`ru_admission_24`.`bills`.`applicant_id` = `ru_admission_24`.`applications`.`applicant_id`)) order by `ru_admission_24`.`applications`.`building`,`ru_admission_24`.`applications`.`unit`,`ru_admission_24`.`applications`.`admission_roll`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `v_photo_capture`");
    }
}
