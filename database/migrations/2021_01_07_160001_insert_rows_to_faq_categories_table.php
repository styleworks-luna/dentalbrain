<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRowsToFaqCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('faq_categories')->insert([
            ['name' => '강의'],
            ['name' => '결제'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('faq_categories')->truncate();
        DB::raw("ALTER TABLE faq_categories AUTO_INCREMENT = 1");
    }
}
