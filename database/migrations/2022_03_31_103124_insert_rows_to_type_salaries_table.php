<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToTypeSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('type_salaries')->insert([
            ['type' => '협의 후 결정'],
            ['type' => '내규에 따름'],
            ['type' => '연봉제'],
            ['type' => '기타'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM type_salaries WHERE type_salaries.id >= 1");
        DB::statement("ALTER TABLE type_salaries AUTO_INCREMENT = 1");
    }
}
