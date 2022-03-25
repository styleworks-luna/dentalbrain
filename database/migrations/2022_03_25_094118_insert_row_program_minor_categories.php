<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowProgramMinorCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('program_minor_categories')->insert([
            ['name' => '스토어'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM program_minor_categories WHERE program_minor_categories.id > 19");
        DB::statement("ALTER TABLE program_minor_categories AUTO_INCREMENT = 20");
    }
}
