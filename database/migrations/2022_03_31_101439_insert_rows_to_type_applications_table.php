<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToTypeApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_applications')->insert([
            ['type' => '진료전반'],
            ['type' => '상담/데스크'],
            ['type' => '교정'],
            ['type' => '보철'],
            ['type' => '예방'],
            ['type' => '구강외과'],
            ['type' => '소아'],
            ['type' => '스케일링'],
            ['type' => '실장'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM type_applications WHERE type_applications.id >= 1");
        DB::statement("ALTER TABLE type_applications AUTO_INCREMENT = 1");
    }
}
