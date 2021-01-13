<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertProgramMajorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('program_major_categories')->insert([
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
        DB::table('program_major_categories')->truncate();
        DB::raw("ALTER TABLE program_major_categories AUTO_INCREMENT = 1");
    }
}
