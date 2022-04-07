<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResumeIdToAbilityAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ability_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('resume_id')->nullable();
            $table->foreign('resume_id')->references('id')->on('resumes');
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

        Schema::table('ability_answers', function (Blueprint $table) {
            $table->dropColumn('resume_id');
        });
    }
}
