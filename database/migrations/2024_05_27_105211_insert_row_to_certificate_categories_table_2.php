<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowToCertificateCategoriesTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('completion_categories')->insert([
            ['name' => '(주) 브레인스펙'],
        ]);
        DB::table('qualification_categories')->insert([
            ['name' => '(주) 브레인스펙'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM completion_categories WHERE id >= 4");
        DB::statement("ALTER TABLE completion_categories AUTO_INCREMENT = 4");
        DB::delete("DELETE FROM qualification_categories WHERE id >= 4");
        DB::statement("ALTER TABLE qualification_categories AUTO_INCREMENT = 4");
    }
}
