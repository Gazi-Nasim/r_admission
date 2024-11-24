<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hall_choices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('applicant_id')->nullable();
            $table->integer('subjectoption_id');
            $table->string('hall_code', 3);
            $table->integer('priority');
            $table->timestamps();

            $table->index(['subjectoption_id', 'hall_code'], 'idx_sc_idcd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hall_choices');
    }
}
