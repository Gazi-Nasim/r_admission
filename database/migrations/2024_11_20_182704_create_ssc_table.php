<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSscTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ssc', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('NAME', 100)->nullable();
            $table->string('FNAME', 100)->nullable();
            $table->string('MNAME', 100)->nullable();
            $table->string('SSC_REGNO', 20)->nullable();
            $table->string('SSC_SESSION', 10)->nullable();
            $table->string('SSC_BOARD_NAME', 60)->nullable();
            $table->string('SSC_PASS_YEAR', 5)->nullable();
            $table->string('SSC_ROLL_NO', 15)->nullable();
            $table->string('BOARD_CODE', 3)->nullable();
            $table->string('SSC_GROUP', 100)->nullable();
            $table->string('SSC_GPA', 4)->nullable();
            $table->string('SSC_LTRGRD', 200)->nullable();
            $table->string('DOB', 10)->nullable();
            $table->string('SEX', 8)->nullable();
            $table->string('RESULT_ORI', 25)->nullable();
            $table->string('RESULT', 25);
            $table->string('C_TYPE', 20)->nullable()->default('');

            $table->index(['SSC_BOARD_NAME', 'SSC_PASS_YEAR', 'SSC_ROLL_NO'], 'ssc_SSC_BOARD_NAME_SSC_PASS_YEAR_SSC_ROLL_NO_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ssc');
    }
}
