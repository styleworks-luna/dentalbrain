<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertRowsToTypeCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_careers')->insert([
            ['type' => '1 ~ 9년'],
            ['type' => '10 ~ 19년'],
            ['type' => '20 ~ 29년'],
            ['type' => '30년 이상'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM type_careers WHERE type_careers.id >= 1");
        DB::statement("ALTER TABLE type_careers AUTO_INCREMENT = 1");
    }
}
