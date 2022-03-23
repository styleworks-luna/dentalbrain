<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsProgramMinorCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('program_minor_categories')->insert([
            ['name' => '구강외과'],
            ['name' => '교합'],
            ['name' => '라이브'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM program_minor_categories WHERE program_minor_categories.id > 16");
        DB::statement("ALTER TABLE program_minor_categories AUTO_INCREMENT = 17");
    }
}
