<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertRowsToRecruitPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('recruit_prices')->insert([
            ['member' => '무료회원', 'price' => '10000'],
            ['member' => '유료회원', 'price' => '10000'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("DELETE FROM recruit_prices WHERE recruit_prices.id >= 1");
        DB::statement("ALTER TABLE recruit_prices AUTO_INCREMENT = 1");
    }
}
