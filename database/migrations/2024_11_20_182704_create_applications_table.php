<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bill_id');
            $table->integer('applicant_id')->index('applications_applicant_id');
            $table->string('name');
            $table->string('fname');
            $table->string('sex', 10)->nullable();
            $table->string('mname');
            $table->string('hsc_roll');
            $table->string('hsc_board', 30);
            $table->integer('hsc_year');
            $table->string('hsc_group', 20);
            $table->string('unit', 6);
            $table->string('quota', 20)->nullable();
            $table->string('mobile_no', 20);
            $table->integer('admission_roll')->nullable()->index('adroll');
            $table->string('photo', 60)->nullable();
            $table->integer('download_count')->default(0);
            $table->string('exam_group', 15)->nullable();
            $table->string('RU_HSC_GROUP', 15)->nullable();
            $table->string('RANDOM_STRING', 12)->nullable();
            $table->string('building', 100)->nullable();
            $table->string('room', 20)->nullable();
            $table->integer('seat')->nullable();
            $table->integer('room_roll_start')->nullable();
            $table->string('exam_date', 25)->nullable();
            $table->string('exam_time', 30)->nullable();
            $table->char('is_english', 2)->nullable()->default('0');
            $table->char('is_pdq', 2)->nullable()->default('0');
            $table->integer('exam_group_no')->nullable();
            $table->string('sub_allow', 5)->nullable()->default('0');
            $table->string('omr_id', 20)->nullable();
            $table->string('bundle_no', 10)->nullable();
            $table->string('scan_sequence', 20)->nullable();
            $table->integer('SERIAL_BY_RANDOM_STRING')->nullable()->default(0);
            $table->timestamps();

            $table->unique(['applicant_id', 'unit'], 'idx_unique_applicant_id_unit');
            $table->index(['unit', 'admission_roll'], 'indx_applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
