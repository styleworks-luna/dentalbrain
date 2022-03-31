<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToTypeWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_works')->insert([
            ['type' => '정규직'],
            ['type' => '계약직'],
            ['type' => '아르바이트'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM type_works WHERE type_works.id >= 1");
        DB::statement("ALTER TABLE type_works AUTO_INCREMENT = 1");
    }
}
