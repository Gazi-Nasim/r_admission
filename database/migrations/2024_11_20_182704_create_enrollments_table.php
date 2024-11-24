<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('applicant_id')->index('applicant_id');
            $table->integer('bill_id')->index('bill_id');
            $table->string('unit', 6);
            $table->string('quota', 20)->nullable();
            $table->string('status', 5)->default('0');
            $table->string('applied', 5)->default('0');
            $table->string('RU_HSC_GROUP', 3)->nullable();
            $table->decimal('HSC_GPA', 4)->nullable();
            $table->decimal('CONV_1000', 10, 4)->nullable();
            $table->bigInteger('MERIT')->nullable();
            $table->timestamps();
            $table->string('phase', 5)->nullable();

            $table->unique(['applicant_id', 'unit'], 'enrollments_unit_applicant_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
