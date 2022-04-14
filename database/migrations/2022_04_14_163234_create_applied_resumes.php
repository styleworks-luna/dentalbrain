<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliedResumes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_resumes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('recruit_id')->nullable();
            $table->unsignedBigInteger('resume_id')->nullable();
            $table->integer('status')->default(1)->comment('신청 status');
            $table->dateTime('applied_at')->comment('제출 일자');
            $table->dateTime('canceled_at')->nullable()->comment('제출 취소 일자');
            $table->boolean('is_recommended')->default(false)->comment('관리차 추천 여부');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('recruit_id')->references('id')->on('recruits');
            $table->foreign('resume_id')->references('id')->on('resumes');

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
        Schema::dropIfExists('applied_resumes');
    }
}
