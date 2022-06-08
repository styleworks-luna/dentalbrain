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
        DB::table('certificate_categories')->insert([
            ['name' => '대한치과위생사협회, 대한치과의료관리학회'],
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
        DB::delete("DELETE FROM certificate_categories WHERE id >= 1");
        DB::statement("ALTER TABLE certificate_categories AUTO_INCREMENT = 1");
    }
}
