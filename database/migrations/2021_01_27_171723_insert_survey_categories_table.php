<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            ['name' => '객관식 단일 선택'],
            ['name' => '객관식 다중 선택'],
            ['name' => '주관식'],
            ['name' => '주소'],
            ['name' => '파일 첨부'],
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
