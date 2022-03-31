<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('input_name')->comment('Form input name / 영어 이름 (개발용)');
            $table->string('name')->comment('이름 (표출용)');
            $table->integer('seq')->default(0)->comment('순서');
            $table->string('type')->nullable()->comment('답변 타입');

            $table->foreign('category_id')->references('id')->on('ability_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abilities', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('abilities');
    }
}
