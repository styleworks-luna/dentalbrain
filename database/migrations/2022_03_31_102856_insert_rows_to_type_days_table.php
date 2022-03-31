<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToTypeDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_days')->insert([
            ['type' => '월~금(주 5일)'],
            ['type' => '월~토(토요일 격주 휴무)'],
            ['type' => '월~토'],
            ['type' => '기타'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM type_days WHERE type_days.id >= 1");
        DB::statement("ALTER TABLE type_days AUTO_INCREMENT = 1");
    }
}
