<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileChangesTable extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_changes', function (Blueprint $table) {
            $table->id('id');
            $table->integer('applicant_id');
            $table->string('doc1');
            $table->string('doc2')->nullable();
            $table->string('old_mobile_no', 15)->nullable();
            $table->string('new_mobile_no', 15);
            $table->mediumText('reason');
            $table->string('meeting_url')->nullable();
            $table->dateTime('meeting_time')->nullable();
            $table->string('comment')->nullable();
            $table->char('status', 2)->nullable();
            $table->integer('checked_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_changes');
    }
}
