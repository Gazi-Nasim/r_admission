<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticalApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practical_applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('admission_roll', 16)->nullable();
            $table->string('applicant_id', 16)->nullable();
            $table->string('unit', 64)->nullable();
            $table->string('name')->nullable();
            $table->string('fname')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('otp', 16)->nullable();
            $table->tinyInteger('otp_verified')->default(0);
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
        Schema::dropIfExists('practical_applicants');
    }
}
