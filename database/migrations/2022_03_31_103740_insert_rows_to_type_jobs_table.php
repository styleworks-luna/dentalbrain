<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToTypeJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_jobs')->insert([
            ['type' => '치과위생사'],
            ['type' => '간호조무사'],
            ['type' => '관리 및 경영지원'],
            ['type' => '코디네이터/리셉션'],
            ['type' => '무관'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM type_jobs WHERE type_jobs.id >= 1");
        DB::statement("ALTER TABLE type_jobs AUTO_INCREMENT = 1");
    }
}
