<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_changes', function (Blueprint $table) {
            $table->id();
            $table->integer('applicant_id');
            $table->integer('bill_id');
            $table->char('bill_status', 5)->default('0');
            $table->char('photo_reg', 100);
            $table->char('new_photo', 100);
            $table->char('previous_photo', 100);
            $table->char('status', 2)->nullable();
            $table->char('checked_by', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_changes');
    }
}
