<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruit_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('member')->comment("무료회원 / 유료회원");
            $table->integer('price')->comment("구인 등록 가격");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recruit_prices');
    }
}
