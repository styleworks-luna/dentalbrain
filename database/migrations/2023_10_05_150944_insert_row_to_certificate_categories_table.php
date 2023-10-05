<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowToCertificateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('completion_categories')->insert([
            ['name' => 'Oral Rehabilitation Society'],
        ]);
        DB::table('qualification_categories')->insert([
            ['name' => 'Oral Rehabilitation Society'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM completion_categories WHERE id >= 3");
        DB::statement("ALTER TABLE completion_categories AUTO_INCREMENT = 3");
        DB::delete("DELETE FROM qualification_categories WHERE id >= 3");
        DB::statement("ALTER TABLE qualification_categories AUTO_INCREMENT = 3");
    }
}
