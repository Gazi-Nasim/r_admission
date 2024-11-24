<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('unit')->nullable();
            $table->bigInteger('applicant_id')->nullable()->index('results_applicant_id_idx');
            $table->string('exam_roll', 10);
            $table->string('group_number', 10)->nullable();
            $table->string('group_name', 50);
            $table->string('name', 50);
            $table->string('fname', 50);
            $table->string('quota', 15);
            $table->string('mcq_score', 10)->nullable();
            $table->string('saq_score', 10)->nullable();
            $table->string('total_score', 10)->nullable();
            $table->string('test_score', 10);
            $table->string('position', 20)->nullable();
            $table->string('status', 50);
            $table->text('interview_date');
            $table->text('subject_choice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
