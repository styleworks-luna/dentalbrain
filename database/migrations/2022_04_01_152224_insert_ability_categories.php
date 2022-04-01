<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertAbilityCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('ability_categories')->insert([
            ['name' => '임플란트', 'seq' => 0],
            ['name' => '보철', 'seq' => 1],
            ['name' => '치주', 'seq' => 2],
            ['name' => '미백', 'seq' => 3],
            ['name' => '보험청구', 'seq' => 4],
            ['name' => '보존', 'seq' => 5],
            ['name' => '교정', 'seq' => 6],
            ['name' => '상담', 'seq' => 7],
            ['name' => '병원 OPEN', 'seq' => 8],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ability_categories')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
