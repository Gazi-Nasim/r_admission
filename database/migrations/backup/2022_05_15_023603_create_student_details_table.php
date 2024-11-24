<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->integer('applicant_id');
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('dob');
            $table->string('birth_place');
            $table->string('gender');
            $table->string('religion');
            $table->string('blood_group')->nullable();
            $table->string('height');
            $table->string('birth_reg_no')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('nationality');
            $table->string('email')->nullable();
            $table->text('permanent_address');
            $table->string('permanent_ps_upazila');
            $table->string('permanent_post_office');
            $table->string('permanent_district');
            $table->text('current_address');
            $table->string('current_ps_upazila');
            $table->string('current_post_office');
            $table->string('current_district');
            $table->string('emergency_name');
            $table->string('emergency_relation')->nullable();
            $table->string('emergency_contact');
            $table->text('emergency_address');
            $table->string('ssc_institute');
            $table->string('hsc_institute');
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
        Schema::dropIfExists('student_details');
    }
}
