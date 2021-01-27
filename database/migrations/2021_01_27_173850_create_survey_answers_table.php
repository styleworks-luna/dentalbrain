<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('user_id');

            $table->string('content')->comment('답변 내용');

            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::table('survey_answers', function (Blueprint $table) {
            $table->dropForeign('survey_answers_survey_id_foreign');
            $table->dropForeign('survey_answers_user_id_foreign');
        });
        Schema::dropIfExists('survey_answers');
    }
}
