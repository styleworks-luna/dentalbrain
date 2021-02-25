<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question');
            $table->unsignedBigInteger('lecture_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('lecture_questions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('lecture_questions', function (Blueprint $table) {
            $table->foreign('lecture_id')->references('id')->on('lectures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecture_questions', function (Blueprint $table) {
            $table->dropForeign('lecture_questions_user_id_foreign');
        });

        Schema::table('lecture_questions', function (Blueprint $table) {
            $table->dropForeign('lecture_questions_lecture_id_foreign');
        });
        Schema::dropIfExists('lecture_questions');
    }
}
