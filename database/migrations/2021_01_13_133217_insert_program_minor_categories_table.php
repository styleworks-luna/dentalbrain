<?php

use Illuminate\Database\Migrations\Migration;

class InsertProgramMinorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('program_minor_categories')->insert([
            ['name' => '예방'],
            ['name' => '보험'],
            ['name' => '교정'],
            ['name' => '치주'],
            ['name' => '보존'],
            ['name' => '보철'],
            ['name' => '임플란트'],
            ['name' => '디지털'],
            ['name' => '방사선'],
            ['name' => '상담'],
            ['name' => '경영'],
            ['name' => '마케팅'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('program_minor_categories')->truncate();
        DB::raw("ALTER TABLE program_minor_categories AUTO_INCREMENT = 1");
    }
}
