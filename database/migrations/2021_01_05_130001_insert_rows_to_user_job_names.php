<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRowsToUserJobNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('user_job_names')->insert([
            ['name' => '치과의사'],
            ['name' => '치과위생사'],
            ['name' => '치과조무사'],
            ['name' => '코디네이터'],
            ['name' => '학생'],
            ['name' => '기타'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('user_job_names')->truncate();
        DB::raw("ALTER TABLE user_job_names AUTO_INCREMENT = 1");
    }
}
