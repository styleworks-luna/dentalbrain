<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbilityAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ability_id');
            $table->integer('score')->nullable()->comment('점수');
            $table->boolean('can_learn')->default(false)->comment('교육 가능 여부');
            $table->string('content')->nullable()->comment('수기입력 필드');

            $table->foreign('ability_id')->references('id')->on('abilities');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ability_answers', function (Blueprint $table) {
            $table->dropForeign(['ability_id']);
        });
        Schema::dropIfExists('ability_answers');
    }
}
