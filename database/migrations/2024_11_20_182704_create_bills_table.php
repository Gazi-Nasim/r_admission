<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('applicant_id')->index('applicant_id');
            $table->string('bill_number');
            $table->double('amount', 8, 2);
            $table->string('bkash_payment_id')->nullable();
            $table->string('rocket_payment_id')->nullable();
            $table->string('units')->nullable();
            $table->char('quota', 20)->nullable();
            $table->text('quota_docs')->nullable();
            $table->string('FFQ_type', 10)->nullable();
            $table->char('mobile_no', 20);
            $table->char('payment_method', 20)->nullable();
            $table->char('trx_id', 50)->nullable();
            $table->char('rocket_trx_id', 50)->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->char('payment_purpose', 20);
            $table->char('payment_status', 5);
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('bills');
    }
}
