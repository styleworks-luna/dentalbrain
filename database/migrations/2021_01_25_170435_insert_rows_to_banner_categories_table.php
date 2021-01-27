<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToBannerCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('banner_categories')->insert([
            ['name' => '상단배너'],
            ['name' => '띠배너'],
            ['name' => '추천배너'],
            ['name' => '하단배너'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('banner_categories')->truncate();
        DB::raw("ALTER TABLE banner_categories AUTO_INCREMENT = 1");
    }
}
