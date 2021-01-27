<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNeedLicenseColumnToUserJobNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_job_names', function (Blueprint $table) {
            //
            $table->tinyInteger('need_license')->default(0)->comment('면허 번호 입력 가능 여부');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_job_names', function (Blueprint $table) {
            //
            $table->dropColumn('need_license');
        });
    }
}
