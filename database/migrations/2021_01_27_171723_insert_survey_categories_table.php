<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertSurveyCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('survey_categories')->insert([
            ['name' => '객관식 단일 선택', 'eng_name' => 'singleChoice',],
            ['name' => '객관식 다중 선택', 'eng_name' => 'multipleChoice',],
            ['name' => '주관식', 'eng_name' => 'shortAnswer',],
            ['name' => '주소', 'eng_name' => 'address',],
            ['name' => '파일 첨부', 'eng_name' => 'file',],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('survey_categories')->truncate();
        DB::raw("ALTER TABLE survey_categories AUTO_INCREMENT = 1");
    }
}
