<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsBannerCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('banner_categories')->insert([
            ['name' => '구역2'],
            ['name' => '구역3'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM banner_categories WHERE banner_categories.id > 4");
        DB::statement("ALTER TABLE `banner_categories` AUTO_INCREMENT = 5");
    }
}
