<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DeleteTypeJobToRecruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruits', function (Blueprint $table) {
            $table->dropForeign(['type_job_id']);
            $table->dropColumn('type_job_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('recruits', function (Blueprint $table) {
            $table->unsignedBigInteger('type_job_id')->comment('직종 정보')->after('type_work_id');
            $table->foreign('type_job_id')->references('id')->on('type_jobs');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
