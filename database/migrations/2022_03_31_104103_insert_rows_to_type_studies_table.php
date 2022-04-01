<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToTypeStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_studies')->insert([
            ['type' => '고등학교 졸업'],
            ['type' => '전문대학 1년 재중'],
            ['type' => '전문대학 2년 재중'],
            ['type' => '전문대학 3년 재중'],
            ['type' => '전문대학 졸업'],
            ['type' => '대학교 1년 재중'],
            ['type' => '대학교 2년 재중'],
            ['type' => '대학교 3년 재중'],
            ['type' => '대학교 4년 재중'],
            ['type' => '대학교 졸업(학사)'],
            ['type' => '대학원 재중'],
            ['type' => '대학원 졸업(석사)'],
            ['type' => '대학원 졸업(박사)'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM type_studies WHERE type_studies.id >= 1");
        DB::statement("ALTER TABLE type_studies AUTO_INCREMENT = 1");
    }
}
