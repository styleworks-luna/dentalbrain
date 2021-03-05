<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertNewColumnToProgramMinorCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('program_minor_categories')->insert([
            ['name' => '데스크업무'],
            ['name' => '치과임상기본'],
            ['name' => '감염관리'],
            ['name' => '고객서비스'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM program_minor_categories WHERE program_minor_categories.id > 12");
        DB::statement("ALTER TABLE program_minor_categories AUTO_INCREMENT = 13");
    }
}
