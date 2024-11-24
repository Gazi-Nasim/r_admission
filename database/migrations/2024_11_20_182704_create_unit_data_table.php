<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_data', function (Blueprint $table) {
            $table->bigInteger('applicant_id');
            $table->string('name', 100)->nullable();
            $table->string('fname', 100)->nullable();
            $table->string('mname', 100)->nullable();
            $table->string('dob', 12)->nullable();
            $table->string('mobile_no', 15)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('hsc_exam_name', 20)->nullable();
            $table->string('hsc_board', 60)->nullable();
            $table->string('hsc_regi', 20)->nullable();
            $table->string('hsc_session', 12)->nullable();
            $table->string('hsc_roll', 60)->nullable();
            $table->string('hsc_pass_year', 5)->nullable();
            $table->string('hsc_study_group', 100)->nullable();
            $table->string('ru_hsc_group', 5)->nullable();
            $table->string('hsc_study_type', 30)->nullable();
            $table->string('hsc_gpa', 20)->nullable();
            $table->string('hsc_tot_obt', 15)->nullable();
            $table->string('hsc_full', 15)->nullable();
            $table->string('hsc_conv_1000', 15)->nullable();
            $table->string('hsc_ltrgd', 250)->nullable();
            $table->string('hsc_marks', 250)->nullable();
            $table->string('ssc_board', 60)->nullable();
            $table->string('ssc_regi', 20)->nullable();
            $table->string('ssc_session', 12)->nullable();
            $table->string('ssc_roll', 60)->nullable();
            $table->string('ssc_pass_year', 5)->nullable();
            $table->string('ssc_study_group', 120)->nullable();
            $table->string('ssc_study_type', 30)->nullable();
            $table->string('ssc_ltrgrd', 250)->nullable();
            $table->double('ssc_gpa')->nullable();
            $table->decimal('total_gpa', 4)->nullable();
            $table->string('quota', 10)->nullable();
            $table->string('unit', 5)->nullable();
            $table->string('exam_group_no', 5)->nullable();
            $table->string('admission_roll', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_data');
    }
}
