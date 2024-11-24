<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('hsc', function (Blueprint $table) {
            $table->integer('upload_quota')->default(0)->after('has_photo');
        });
    }

    public function down()
    {
        Schema::table('hsc', function (Blueprint $table) {
            $table->dropColumn('upload_quota');
        });
    }
};
