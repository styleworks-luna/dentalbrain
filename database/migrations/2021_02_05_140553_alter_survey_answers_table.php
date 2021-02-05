<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSurveyAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('survey_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('choice_id')
                ->nullable()->after('survey_id');
            $table->string('content')->comment('답변 내용')
                ->nullable()->change();
            $table->string('address_detail')->comment('답변 상세 주소')
                ->nullable()->after('content');
            $table->string('address')->comment('답변 주소')
                ->nullable()->after('content');
            $table->unsignedBigInteger('file_id')->comment('파일 답변')
                ->nullable()->after('user_id');

            $table->foreign('choice_id')->references('id')->on('surveys');
            $table->foreign('file_id')->references('id')->on('files');
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
            $table->dropForeign('survey_answers_choice_id_foreign');
            $table->dropForeign('survey_answers_file_id_foreign');

            $table->dropColumn(['address_detail', 'address', 'file_id', 'choice_id']);
        });
    }
}
