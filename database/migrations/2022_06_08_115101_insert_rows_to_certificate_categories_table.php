<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertRowsToCertificateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('completion_categories')->insert([
            ['name' => '대한치과위생사협회 대한치과의료관리학회'],
            ['name' => '한국치위생감염관리학회'],
        ]);
        DB::table('qualification_categories')->insert([
            ['name' => '대한치과위생사협회 대한치과의료관리학회'],
            ['name' => '한국치위생감염관리학회'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM completion_categories WHERE id >= 1");
        DB::statement("ALTER TABLE completion_categories AUTO_INCREMENT = 1");
        DB::delete("DELETE FROM qualification_categories WHERE id >= 1");
        DB::statement("ALTER TABLE qualification_categories AUTO_INCREMENT = 1");
    }
}
