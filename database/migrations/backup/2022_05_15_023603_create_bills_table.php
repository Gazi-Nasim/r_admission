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
            $table->id();
            $table->integer('applicant_id')->index('applicant_id');
            $table->string('bill_number');
            $table->float('amount');
            $table->string('units')->nullable();
            $table->char('quota', 20)->nullable();
            $table->text('quota_docs')->nullable();
            $table->string('FFQ_type', 10)->nullable();
            $table->char('mobile_no', 20);
            $table->char('payment_method', 20)->nullable();
            $table->char('trx_id', 50)->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->char('payment_purpose', 20);
            $table->char('payment_status', 5);
            $table->string('photo')->nullable();
            $table->timestamps();
        });
        DB::update("ALTER TABLE `bills` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100001;");
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
