<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit', 5)->nullable();
            $table->string('exam_group_no', 5)->nullable();
            $table->string('exam_group', 20)->nullable();
            $table->string('applicant_id', 20)->nullable();
            $table->string('application_id', 20)->nullable()->index('SO_ApplicationId');
            $table->string('admission_roll', 20)->nullable()->index('SO_');
            $table->string('name', 200)->nullable()->default('');
            $table->string('exam_score', 20)->nullable();
            $table->string('position', 20)->nullable();
            $table->string('sub_allow', 5)->nullable()->default('0');
            $table->integer('sub_completed')->default(0);
            $table->string('subjects', 200)->nullable();
            $table->string('admission_allow', 5)->nullable();
            $table->string('admission_subject', 10)->nullable();
            $table->string('admission_completed', 5)->nullable();
            $table->integer('bill_id')->nullable();
            $table->string('office_status', 5)->default('0');
            $table->string('reject_reason', 10)->nullable();
            $table->text('comment')->nullable();
            $table->string('bill_status', 10)->default('0');
            $table->string('migration_stop', 10)->nullable();
            $table->timestamp('migration_stopped_at')->nullable();
            $table->string('alloc_dept_code', 3)->nullable();
            $table->integer('student_category_id')->nullable();
            $table->integer('allow_reg')->nullable()->default(0);
            $table->integer('ffq_position')->nullable();
            $table->integer('pdq_position')->nullable();
            $table->integer('seq_position')->nullable();
            $table->integer('wq_position')->nullable();
            $table->string('alloc_dept_code_quota', 3)->nullable();
            $table->integer('quota_selected')->nullable()->default(0);
            $table->integer('list_number')->nullable()->default(0);
            $table->integer('allow_regc')->nullable()->default(0);
            $table->string('quota', 20)->nullable();
            $table->string('gender', 15)->nullable();
            $table->integer('hall_code')->nullable();
            $table->integer('student_details_id')->nullable();
            $table->integer('class_roll')->nullable();
            $table->string('admission_sub_eee', 10)->nullable();
            $table->string('migration_stop_15', 10)->nullable();
            $table->integer('student_id')->nullable();
            $table->tinyInteger('new_ad')->nullable()->default(0);
            $table->string('sp_choice', 5)->nullable()->default('0');
            $table->string('pop_sci', 5)->nullable()->default('0');
            $table->string('alt_mobile_no', 25)->nullable();
            $table->integer('is_bksp')->nullable()->default(0);
            $table->string('bksp_photo', 200)->nullable();
            $table->string('Result', 50)->nullable();
            $table->string('Remarks', 100)->nullable();
            $table->timestamp('admission_end')->default('2025-12-31 00:00:00');
            $table->string('last_admission_subject', 10)->nullable();
            $table->string('admission_subject_selection_status', 250)->nullable();
            $table->integer('hall_choice_allow')->nullable()->default(0);
            $table->integer('hall_choice_complete')->nullable()->default(0);
            $table->timestamps();
            $table->string('mobile_no', 20)->nullable();
            $table->string('admission_subject_2024_05_15', 10)->nullable();
            $table->string('admission_subject_2024_05_23', 10)->nullable();
            $table->string('admission_subject_2024_05_29', 10)->nullable();
            $table->string('admission_subject_2024_06_06', 10)->nullable();
            $table->string('admission_subject_2024_06_20', 10)->nullable();
            $table->string('admission_subject_2024_06_28', 10)->nullable();
            $table->string('admission_subject_2024_09_12', 10)->nullable();
            $table->string('admission_subject_2024_09_15', 10)->nullable();
            $table->string('admission_subject_2024_09_18', 10)->nullable();
            $table->string('admission_subject_2024_09_19', 10)->nullable();
            $table->string('admission_subject_2024_09_20', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_options');
    }
}
