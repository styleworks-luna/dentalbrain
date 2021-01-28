<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('NOT NULL : 객관식 선택지');

            $table->string('question')->comment('질문 내용');
            $table->tinyInteger('is_required')->comment('필수 여부');

            $table->foreign('category_id')->references('id')->on('survey_categories');
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('parent_id')->references('id')->on('surveys');

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
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropForeign('surveys_category_id_foreign');
            $table->dropForeign('surveys_program_id_foreign');
            $table->dropForeign('surveys_parent_id_foreign');
        });
        Schema::dropIfExists('surveys');
    }
}
