<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruit_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->comment('근무요일 타입');
            $table->string('value')->comment('근무요일 값');
            $table->unsignedBigInteger('recruit_id')->comment('구인 정보');
            $table->unsignedBigInteger('type_day_id')->comment('근무요일 정보');

            $table->foreign('recruit_id')->references('id')->on('recruits');
            $table->foreign('type_day_id')->references('id')->on('type_days');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recruit_days');
    }
}
