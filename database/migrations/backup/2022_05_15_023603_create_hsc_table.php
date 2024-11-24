<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHscTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hsc', function (Blueprint $table) {
            $table->id();
            $table->string('NAME', 100)->nullable();
            $table->string('FNAME', 100)->nullable();
            $table->string('MNAME', 100)->nullable();
            $table->string('HSC_REGNO', 20)->nullable();
            $table->string('HSC_SESSION', 10)->nullable();
            $table->string('HSC_ROLL_NO', 10)->nullable();
            $table->string('HSC_PASS_YEAR', 5)->nullable();
            $table->string('HSC_BOARD_NAME', 60)->nullable();
            $table->string('HSC_GPA', 20)->nullable();
            $table->string('HSC_LTRGRD', 250)->nullable();
            $table->string('HSC_GROUP', 100)->nullable();
            $table->string('SEX', 8)->nullable();
            $table->string('SSC_ROLL_NO', 10)->nullable();
            $table->string('SSC_PASS_YEAR', 5)->nullable();
            $table->string('SSC_BOARD_NAME', 60)->nullable();
            $table->string('HSC_RESULT', 25)->nullable();
            $table->tinyInteger('SSC_DATA')->default(0);
            $table->string('SSC_NAME', 60)->nullable();
            $table->string('SSC_GROUP', 100)->nullable();
            $table->string('SSC_GPA', 4)->nullable();
            $table->string('SSC_RESULT', 25)->nullable();
            $table->string('RU_HSC_GROUP', 3)->nullable()->default('NA');
            $table->decimal('TOTAL_GPA', 4)->nullable()->default(0);
            $table->string('MATHEMATICS', 10)->nullable();
            $table->string('A', 10)->default('0');
            $table->string('B', 10)->default('0');
            $table->string('C', 10)->default('0');
            $table->string('D', 10)->default('0');
            $table->string('E', 10)->default('0');
            $table->string('mobile_no', 15)->nullable()->index('mobile_no');
            $table->string('mobile_verification_code', 10)->nullable();
            $table->integer('mobile_no_verified')->nullable();
            $table->string('email')->nullable();
            $table->integer('email_verified')->nullable();
            $table->string('email_verification_code', 10)->nullable();
            $table->string('zone_submited', 10)->nullable();
            $table->timestamp('code_time')->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('SEQ_photo')->nullable();
            $table->string('PDQ_photo')->nullable();
            $table->string('WQ_photo')->nullable();
            $table->string('FFQ_photo')->nullable();
            $table->string('FFQ_number')->nullable();
            $table->string('FFQ_type', 10)->nullable();
            $table->string('tracking_no', 15)->nullable();
            $table->string('C_TYPE', 20)->nullable();
            $table->string('oth_board', 20)->nullable();
            $table->char('photo_status', 2)->nullable();
            $table->char('photo_checked_by', 30)->nullable();
            $table->integer('has_photo')->default(1);
            $table->string('BIOLOGY', 10)->nullable();
            $table->string('CONV_1000',	10)->nullable();
            $table->string('is_english')->default(0);
            $table->string('edu_hsc_id')->nullable();
            $table->timestamps();
            $table->index(['HSC_ROLL_NO', 'HSC_BOARD_NAME', 'HSC_PASS_YEAR'], 'HSC_ROLL_BOARD_HSC_YEAR');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hsc');
    }
}
