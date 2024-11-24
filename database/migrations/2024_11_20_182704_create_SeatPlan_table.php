<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SeatPlan', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('UNIT', 10)->nullable();
            $table->string('GROUP', 10)->nullable();
            $table->integer('GROUP_NO')->nullable();
            $table->string('BUILDING', 100)->nullable();
            $table->integer('BUILDING_ORDER')->nullable();
            $table->string('ROOM_NO', 20)->nullable();
            $table->string('TYPE', 50)->nullable();
            $table->string('OWNER_DEPT', 100)->nullable();
            $table->integer('SEAT')->nullable();
            $table->integer('ROLL_FROM')->nullable();
            $table->integer('ROLL_TO')->nullable();
            $table->integer('ALLOTED')->nullable();
            $table->string('Control_Room', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SeatPlan');
    }
}
