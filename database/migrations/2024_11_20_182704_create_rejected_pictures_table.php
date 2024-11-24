<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectedPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rejected_pictures', function (Blueprint $table) {
            $table->bigInteger('ID', true);
            $table->string('UNIT', 5)->nullable()->index('indx_seat');
            $table->string('BUILDING', 200)->nullable();
            $table->integer('GROUP_NO')->nullable();
            $table->string('Control_Room', 100)->nullable();
            $table->integer('both_rejected')->nullable()->default(0);
            $table->integer('photo_rejected')->nullable()->default(0);
            $table->integer('selfie_rejected')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rejected_pictures');
    }
}
