<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToBannerTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('banner_titles')->insert([
            ['title' => '구역 1'],
            ['title' => '구역 2'],
            ['title' => '구역 3'],
            ['title' => '구역 4'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('banner_titles')->truncate();
        DB::statement("ALTER TABLE banner_categories AUTO_INCREMENT = 1");
    }
}
