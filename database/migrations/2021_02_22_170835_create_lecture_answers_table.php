<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('display_name');
            $table->unsignedBigInteger('id2');
            $table->timestamps();
        });

        Schema::table('lecture_answers', function (Blueprint $table) {
            $table->foreign('id2')->references('id')->on('lecture_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecture_answers', function (Blueprint $table) {
            $table->dropForeign('lecture_answers_id2_foreign');
        });
        Schema::dropIfExists('lecture_answers');
    }
}
