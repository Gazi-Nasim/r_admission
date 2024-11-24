<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionSubjectHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_subject_history', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('unit', 5)->nullable();
            $table->integer('admission_roll')->nullable();
            $table->string('admission_subject', 10)->nullable();
            $table->integer('student_category_id')->nullable();
            $table->dateTime('admission_end')->nullable();
            $table->timestamp('update_time')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission_subject_history');
    }
}
