<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHscOthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hsc_oth', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('NAME', 100)->nullable();
            $table->char('FNAME', 100)->nullable();
            $table->char('MNAME', 100)->nullable();
            $table->char('HSC_REGNO', 20)->nullable();
            $table->char('HSC_SESSION', 10)->nullable();
            $table->char('HSC_ROLL_NO', 20)->nullable();
            $table->integer('HSC_PASS_YEAR')->nullable();
            $table->char('HSC_BOARD_NAME', 20)->nullable();
            $table->char('HSC_GPA', 20)->nullable();
            $table->char('HSC_LTRGRD', 250)->nullable();
            $table->char('HSC_GROUP', 20)->nullable();
            $table->char('HSC_RESULT', 25)->nullable();
            $table->char('SEX', 8)->nullable();
            $table->char('SSC_ROLL_NO', 20)->nullable();
            $table->integer('SSC_PASS_YEAR')->nullable();
            $table->char('SSC_BOARD_NAME', 50)->nullable();
            $table->integer('SSC_DATA')->nullable();
            $table->char('SSC_NAME', 100)->nullable();
            $table->char('SSC_GROUP', 20)->nullable();
            $table->char('SSC_GPA', 20)->nullable();
            $table->char('SSC_RESULT', 25)->nullable();
            $table->char('RU_HSC_GROUP', 3)->nullable();
            $table->double('TOTAL_GPA', 8, 2)->nullable();
            $table->char('MATHEMATICS', 10)->nullable();
            $table->char('A', 10)->nullable();
            $table->char('B', 10)->nullable();
            $table->char('C', 10)->nullable();
            $table->char('D', 10)->nullable();
            $table->char('E', 10)->nullable();
            $table->char('mobile_no', 15)->nullable();
            $table->char('photo', 100)->nullable();
            $table->char('photo_ssc', 100)->nullable();
            $table->char('photo_hsc', 100)->nullable();
            $table->char('tracking_no', 15)->nullable();
            $table->date('dob')->nullable();
            $table->char('status', 2)->nullable();
            $table->char('comment', 250)->nullable();
            $table->char('oth_board', 20)->nullable();
            $table->char('checked_by', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hsc_oth');
    }
}
