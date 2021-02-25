<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnsweredAtColumnToLectureQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lecture_questions', function (Blueprint $table) {
            $table->datetime('answered_at')->nullable()->comment('답변시간');
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
            $table->dropColumn('answered_at');
        });
    }
}
