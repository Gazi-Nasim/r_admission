<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Routine', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('UNIT', 10);
            $table->string('EXAM_GROUP', 10);
            $table->string('EXAM_DATE');
            $table->string('EXAM_TIME');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Routine');
    }
}
