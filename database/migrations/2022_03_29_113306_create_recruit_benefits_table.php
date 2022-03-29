<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruit_benefits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->comment('복리후생 타입');
            $table->unsignedBigInteger('recruit_id')->comment('구인 정보');
            $table->unsignedBigInteger('type_benefit_id')->comment('복리후생 정보');

            $table->foreign('recruit_id')->references('id')->on('recruits');
            $table->foreign('type_benefit_id')->references('id')->on('type_benefits');

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
        Schema::dropIfExists('recruit_benefits');
    }
}
