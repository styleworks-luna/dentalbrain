<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToInquiryCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('inquiry_categories')->insert([
            ['name' => '일반'],
            ['name' => '환불'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('inquiry_categories')->truncate();
        DB::raw("ALTER TABLE inquiry_categories AUTO_INCREMENT = 1");
    }
}
