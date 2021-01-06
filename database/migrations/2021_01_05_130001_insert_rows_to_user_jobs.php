<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertRowsToUserJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('user_jobs')->insert([
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

        Schema::table('user_jobs', function (Blueprint $table) {
            $table->drop();
        });
        DB::raw("ALTER TABLE user_jobs AUTO_INCREMENT = 1");
    }
}
