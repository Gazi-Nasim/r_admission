<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_choices', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->index('SC_ApplicationId');
            $table->integer('subjectoption_id');
            $table->string('dept_code', 3);
            $table->integer('priority');
            $table->string('selection_status', 15)->nullable();
            $table->integer('opt_out')->nullable()->default(0);
            $table->timestamps();

            $table->index(['subjectoption_id', 'dept_code'], 'idx_sc_idcd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_choices');
    }
}
